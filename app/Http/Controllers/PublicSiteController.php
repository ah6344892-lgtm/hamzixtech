<?php

namespace App\Http\Controllers;

use App\Models\AiTool;
use App\Models\Category;
use App\Models\Post;
use App\Models\Project;
use App\Models\Service;
use App\Models\SiteSetting;
use App\Models\SocialLink;
use App\Models\Tag;
use App\Models\Template;
use App\Models\Tool;
use App\Models\Tutorial;
use App\Services\AI\AiManager;
use App\Services\ToolRunner;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use InvalidArgumentException;
use JsonException;

class PublicSiteController extends Controller
{
    public function home()
    {
        return view('public.home', [
            'headline' => SiteSetting::read('home.headline', 'Modern websites and software, built with care.'),
            'introduction' => SiteSetting::read('home.introduction', 'We build digital experiences and useful technology resources with clarity, thoughtful design, and a reliable foundation.'),
            'services' => Service::published()->featured()->orderBy('sort_order')->take(3)->get(),
            'projects' => Project::published()->featured()->orderBy('sort_order')->take(3)->get(),
            'posts' => Post::published()->with('author')->latest('published_at')->take(3)->get(),
            'tutorials' => Tutorial::published()->featured()->latest('published_at')->take(3)->get(),
            'templates' => Template::published()->featured()->latest('published_at')->take(3)->get(),
            'tools' => Tool::available()->take(4)->get(),
            'socialLinks' => SocialLink::visible()->orderBy('sort_order')->get(),
        ]);
    }

    public function services()
    {
        return $this->listing('Services', Service::published()->orderBy('sort_order')->orderBy('title'), 'public.services.index');
    }

    public function service(Service $service)
    {
        abort_unless($service->status === 'published' && ($service->published_at === null || $service->published_at->isPast()), 404);
        return view('public.detail', ['item' => $service, 'type' => 'Service', 'back' => route('services.index')]);
    }

    public function projects()
    {
        return $this->listing('Projects', Project::published()->with('category')->orderBy('sort_order')->latest('published_at'), 'public.projects.index');
    }

    public function project(Project $project)
    {
        abort_unless($project->status === 'published' && ($project->published_at === null || $project->published_at->isPast()), 404);
        return view('public.detail', ['item' => $project, 'type' => 'Project', 'back' => route('projects.index')]);
    }

    public function posts(Request $request)
    {
        $posts = Post::published()->with(['category', 'author', 'tags'])->latest('published_at')->paginate(9)->withQueryString();
        return view('public.content-index', ['title' => 'Blog', 'description' => 'Articles and notes from HamzixTech.', 'items' => $posts, 'kind' => 'posts']);
    }

    public function post(Post $post)
    {
        abort_unless($post->status === 'published' && ($post->published_at === null || $post->published_at->isPast()), 404);
        $post->load(['category', 'author', 'tags']);
        $related = Post::published()->whereKeyNot($post->getKey())->when($post->category_id, fn ($q) => $q->where('category_id', $post->category_id))->latest('published_at')->take(3)->get();
        return view('public.article', compact('post', 'related'));
    }

    public function category(string $slug)
    {
        $category = Category::query()->where('type', 'posts')->where('slug', $slug)->firstOrFail();
        return view('public.content-index', [
            'title' => $category->name,
            'description' => $category->seo_description ?: $category->description ?: 'Articles in '.$category->name.'.',
            'items' => Post::published()->where('category_id', $category->id)->with(['category', 'author'])->latest('published_at')->paginate(9),
            'kind' => 'posts',
        ]);
    }

    public function tag(string $slug)
    {
        $tag = Tag::query()->where('slug', $slug)->firstOrFail();
        return view('public.content-index', [
            'title' => 'Tagged: '.$tag->name,
            'description' => 'Articles tagged '.$tag->name.'.',
            'items' => $tag->posts()->published()->with(['category', 'author'])->latest('published_at')->paginate(9),
            'kind' => 'posts',
        ]);
    }

    public function tutorials()
    {
        return view('public.content-index', ['title' => 'Tutorials', 'description' => 'Step-by-step learning resources from HamzixTech.', 'items' => Tutorial::published()->with(['category', 'author'])->latest('published_at')->paginate(9), 'kind' => 'tutorials']);
    }

    public function tutorial(Tutorial $tutorial)
    {
        abort_unless($tutorial->status === 'published' && ($tutorial->published_at === null || $tutorial->published_at->isPast()), 404);
        return view('public.detail', ['item' => $tutorial->load(['category', 'author', 'tags']), 'type' => 'Tutorial', 'back' => route('tutorials.index')]);
    }

    public function templates()
    {
        return view('public.content-index', ['title' => 'Templates', 'description' => 'Reusable templates and starter resources.', 'items' => Template::published()->with(['category', 'tags'])->latest('published_at')->paginate(9), 'kind' => 'templates']);
    }

    public function template(Template $template)
    {
        abort_unless($template->status === 'published' && ($template->published_at === null || $template->published_at->isPast()), 404);
        return view('public.detail', ['item' => $template->load(['category', 'tags']), 'type' => 'Template', 'back' => route('templates.index')]);
    }

    public function downloadTemplate(Template $template)
    {
        abort_unless($template->status === 'published' && ($template->published_at === null || $template->published_at->isPast()), 404);
        abort_unless($template->pricing_type === 'free' && filled($template->download_path), 404);
        abort_unless(Storage::disk('local')->exists($template->download_path), 404);
        return Storage::disk('local')->download($template->download_path, basename($template->download_path));
    }

    public function tools()
    {
        return view('public.tools.index', ['tools' => Tool::available()->with('category')->orderBy('title')->get()]);
    }

    public function tool(Tool $tool)
    {
        abort_unless($tool->is_implemented && $tool->is_enabled && $tool->status === 'published', 404);
        return view('public.tools.show', ['tool' => $tool, 'input' => '', 'operation' => 'format', 'output' => null, 'error' => null]);
    }

    public function runTool(Request $request, Tool $tool)
    {
        abort_unless($tool->is_implemented && $tool->is_enabled && $tool->status === 'published', 404);

        $data = $request->validate([
            'input' => ['nullable', 'string', 'max:50000'],
            'operation' => ['nullable', 'string', 'max:20'],
        ]);
        $input = $data['input'] ?? '';
        $operation = $data['operation'] ?? 'format';

        try {
            $output = app(ToolRunner::class)->run($tool->slug, $input, $operation);
            $error = null;
        } catch (JsonException) {
            $output = null;
            $error = 'The input is not valid JSON.';
        } catch (InvalidArgumentException $exception) {
            $output = null;
            $error = $exception->getMessage();
        }

        return response()->view('public.tools.show', compact('tool', 'input', 'operation', 'output', 'error'));
    }

    public function aiTools()
    {
        $configured = app(AiManager::class)->available();
        return view('public.ai.index', [
            'tools' => $configured ? AiTool::available()->orderBy('sort_order')->get() : collect(),
            'configured' => $configured,
        ]);
    }

    public function about()
    {
        return view('public.page', ['title' => 'About HamzixTech', 'body' => SiteSetting::read('about.introduction', 'HamzixTech focuses on modern websites, software, and useful technology resources.'), 'description' => 'About HamzixTech and its focus on useful technology.']);
    }

    public function contact()
    {
        return view('public.contact', ['email' => config('hamzixtech.contact_email'), 'whatsapp' => $this->whatsAppUrl()]);
    }

    public function privacy()
    {
        $body = SiteSetting::read('legal.privacy_policy');
        return view('public.page', ['title' => 'Privacy Policy', 'description' => 'How contact form information is handled by this website.', 'body' => $body ?: "This website stores information submitted through its contact form, including your name, email address, subject, and message, so HamzixTech can respond to your request. The information is available to authorized site staff and is not displayed publicly. Mail delivery, analytics, cookies, retention periods, and third-party services depend on the deployment configuration. Contact the site owner to request access or deletion. This policy should be reviewed and updated before public launch."]);
    }

    public function terms()
    {
        $body = SiteSetting::read('legal.terms');
        return view('public.page', ['title' => 'Terms and Conditions', 'description' => 'Terms for using this website and its resources.', 'body' => $body ?: "Use this website and its resources lawfully and respect intellectual property notices attached to each item. Templates and downloads may have individual licenses shown on their detail pages. External links are provided for convenience; their content and availability are controlled by their owners. Service scope and deliverables are agreed separately with each client. These draft terms must be reviewed and customized by the site owner before public launch."]);
    }

    public function search(Request $request)
    {
        $data = $request->validate(['q' => ['required', 'string', 'min:2', 'max:100'], 'type' => ['nullable', 'in:all,posts,tutorials,templates,tools,projects']]);
        $q = trim($data['q']);
        $type = $data['type'] ?? 'all';
        $sources = [
            'posts' => [Post::class, 'title', 'slug', 'excerpt', route('blog.index')],
            'tutorials' => [Tutorial::class, 'title', 'slug', 'summary', route('tutorials.index')],
            'templates' => [Template::class, 'title', 'slug', 'summary', route('templates.index')],
            'tools' => [Tool::class, 'title', 'slug', 'description', route('tools.index')],
            'projects' => [Project::class, 'title', 'slug', 'summary', route('projects.index')],
        ];
        $results = collect();
        foreach ($sources as $key => [$model, $title, $slug, $summary, $indexUrl]) {
            if ($type !== 'all' && $type !== $key) continue;
            $query = $model::query();
            if ($key === 'tools') $query->available(); else $query->published();
            $records = $query->where(fn (Builder $query) => $query->where($title, 'like', '%'.$q.'%')->orWhere($summary, 'like', '%'.$q.'%'))->limit(10)->get();
            foreach ($records as $record) {
                $url = match ($key) {
                    'posts' => route('blog.show', $record), 'tutorials' => route('tutorials.show', $record), 'templates' => route('templates.show', $record), 'tools' => route('tools.show', $record), 'projects' => route('projects.show', $record),
                };
                $results->push(['type' => ucfirst(rtrim($key, 's')), 'title' => $record->{$title}, 'summary' => $record->{$summary}, 'url' => $url]);
            }
        }
        return view('public.search', compact('q', 'type', 'results'));
    }

    public function sitemap()
    {
        return response()->view('public.sitemap', [
            'records' => collect([
                ...Post::published()->get()->map(fn ($item) => [route('blog.show', $item), $item->updated_at]),
                ...Tutorial::published()->get()->map(fn ($item) => [route('tutorials.show', $item), $item->updated_at]),
                ...Template::published()->get()->map(fn ($item) => [route('templates.show', $item), $item->updated_at]),
                ...Tool::available()->get()->map(fn ($item) => [route('tools.show', $item), $item->updated_at]),
                ...Project::published()->get()->map(fn ($item) => [route('projects.show', $item), $item->updated_at]),
            ]),
        ])->header('Content-Type', 'application/xml; charset=UTF-8');
    }

    private function listing(string $title, Builder $query, string $view)
    {
        return view($view, ['title' => $title, 'items' => $query->paginate(9), 'description' => 'Explore '.$title.' from HamzixTech.']);
    }

    private function whatsAppUrl(): ?string
    {
        $number = preg_replace('/\D+/', '', (string) (SiteSetting::read('contact.whatsapp') ?: config('hamzixtech.whatsapp_number')));
        if (! $number) return null;
        $url = 'https://wa.me/'.$number;
        $message = SiteSetting::read('contact.whatsapp_message') ?: config('hamzixtech.whatsapp_message');
        return $message ? $url.'?text='.rawurlencode($message) : $url;
    }
}
