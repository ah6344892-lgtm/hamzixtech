<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AiTool;
use App\Models\Category;
use App\Models\Post;
use App\Models\Project;
use App\Models\Service;
use App\Models\Tag;
use App\Models\Template;
use App\Models\Tool;
use App\Models\Tutorial;
use App\Support\ActivityLogger;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ResourceController extends Controller
{
    private const DEFINITIONS = [
        'posts' => ['title' => 'Posts', 'class' => Post::class, 'policy' => Post::class, 'fields' => [
            ['title','Title','text',true], ['slug','Slug','text',false], ['excerpt','Excerpt','textarea',false], ['content','Content','textarea',true], ['category_id','Category','category:posts',false], ['tags','Tags','tags',false], ['featured_image','Featured image','image',false], ['featured_image_alt','Image alt text','text',false], ['status','Status','status',true], ['published_at','Publish date','datetime',false], ['featured','Featured','boolean',false], ['seo_title','SEO title','text',false], ['seo_description','SEO description','textarea',false], ['canonical_url','Canonical URL','url',false],
        ], 'columns' => ['title','status','featured','published_at']],
        'tutorials' => ['title' => 'Tutorials', 'class' => Tutorial::class, 'policy' => Tutorial::class, 'fields' => [
            ['title','Title','text',true], ['slug','Slug','text',false], ['summary','Summary','textarea',false], ['content','Content','textarea',true], ['category_id','Category','category:tutorials',false], ['tags','Tags','tags',false], ['cover_image','Cover image','image',false], ['cover_image_alt','Image alt text','text',false], ['difficulty','Difficulty','select:beginner,intermediate,advanced',true], ['estimated_minutes','Estimated minutes','number',false], ['technologies','Technologies (comma separated)','list',false], ['status','Status','status',true], ['published_at','Publish date','datetime',false], ['featured','Featured','boolean',false], ['seo_title','SEO title','text',false], ['seo_description','SEO description','textarea',false],
        ], 'columns' => ['title','difficulty','status','published_at']],
        'templates' => ['title' => 'Templates', 'class' => Template::class, 'policy' => Template::class, 'fields' => [
            ['title','Title','text',true], ['slug','Slug','text',false], ['summary','Summary','textarea',false], ['description','Description','textarea',true], ['features','Features','textarea',false], ['requirements','Requirements','textarea',false], ['installation_instructions','Installation instructions','textarea',false], ['category_id','Category','category:templates',false], ['tags','Tags','tags',false], ['technologies','Technologies (comma separated)','list',false], ['thumbnail','Thumbnail image','image',false], ['thumbnail_alt','Image alt text','text',false], ['github_url','Source URL','url',false], ['demo_url','Demo URL','url',false], ['download_path','Download package','file',false], ['version','Version','text',false], ['license','License','text',false], ['pricing_type','Pricing','select:free,paid','true'], ['status','Status','status',true], ['published_at','Publish date','datetime',false], ['featured','Featured','boolean',false], ['seo_title','SEO title','text',false], ['seo_description','SEO description','textarea',false],
        ], 'columns' => ['title','pricing_type','status','published_at']],
        'tools' => ['title' => 'Tools', 'class' => Tool::class, 'policy' => Tool::class, 'fields' => [
            ['title','Title','text',true], ['slug','Slug','text',false], ['description','Description','textarea',true], ['instructions','Instructions','textarea',false], ['category_id','Category','category:tools',false], ['icon','Icon identifier','text',false], ['is_implemented','Implemented','boolean',false], ['is_enabled','Enabled','boolean',false], ['status','Status','status',true], ['published_at','Publish date','datetime',false], ['seo_title','SEO title','text',false], ['seo_description','SEO description','textarea',false],
        ], 'columns' => ['title','is_implemented','is_enabled','status']],
        'services' => ['title' => 'Services', 'class' => Service::class, 'policy' => Service::class, 'fields' => [
            ['title','Title','text',true], ['slug','Slug','text',false], ['summary','Summary','textarea',false], ['description','Description','textarea',true], ['icon','Icon identifier','text',false], ['featured_image','Featured image','image',false], ['featured_image_alt','Image alt text','text',false], ['sort_order','Sort order','number',false], ['status','Status','status',true], ['published_at','Publish date','datetime',false], ['featured','Featured','boolean',false], ['seo_title','SEO title','text',false], ['seo_description','SEO description','textarea',false],
        ], 'columns' => ['title','sort_order','featured','status']],
        'projects' => ['title' => 'Projects', 'class' => Project::class, 'policy' => Project::class, 'fields' => [
            ['title','Title','text',true], ['slug','Slug','text',false], ['summary','Summary','textarea',false], ['description','Description','textarea',true], ['category_id','Category','category:projects',false], ['main_image','Main image','image',false], ['main_image_alt','Image alt text','text',false], ['technologies','Technologies (comma separated)','list',false], ['demo_url','Live demo URL','url',false], ['source_url','Source code URL','url',false], ['completed_at','Completion date','date',false], ['sort_order','Sort order','number',false], ['featured','Featured','boolean',false], ['status','Status','status',true], ['published_at','Publish date','datetime',false], ['seo_title','SEO title','text',false], ['seo_description','SEO description','textarea',false],
        ], 'columns' => ['title','featured','status','completed_at']],
        'categories' => ['title' => 'Categories', 'class' => Category::class, 'policy' => Category::class, 'fields' => [
            ['type','For section','select:posts,tutorials,templates,tools,projects',true], ['name','Name','text',true], ['slug','Slug','text',false], ['description','Description','textarea',false], ['seo_title','SEO title','text',false], ['seo_description','SEO description','textarea',false],
        ], 'columns' => ['type','name','slug']],
        'tags' => ['title' => 'Tags', 'class' => Tag::class, 'policy' => Tag::class, 'fields' => [
            ['name','Name','text',true], ['slug','Slug','text',false],
        ], 'columns' => ['name','slug']],
        'ai-tools' => ['title' => 'AI tools', 'class' => AiTool::class, 'policy' => null, 'fields' => [
            ['name','Name','text',true], ['slug','Slug','text',false], ['description','Description','textarea',false], ['provider','Provider','text',false], ['icon','Icon identifier','text',false], ['is_implemented','Implemented','boolean',false], ['enabled','Enabled','boolean',false], ['status','Status','select:coming_soon,published,draft',true], ['sort_order','Sort order','number',false],
        ], 'columns' => ['name','provider','is_implemented','enabled','status']],
    ];

    public function index(Request $request, string $resource)
    {
        $definition = $this->definition($resource);
        $this->authorizeResource($request, $resource, 'viewAny');
        $query = $definition['class']::query();
        if ($resource === 'categories' && $request->filled('type')) $query->where('type', $request->string('type'));
        if ($request->filled('q')) {
            $term = '%'.$request->string('q')->toString().'%';
            $query->where(function ($builder) use ($definition, $term): void {
                foreach (['title','name','slug'] as $field) {
                    if (\Illuminate\Support\Facades\Schema::hasColumn($builder->getModel()->getTable(), $field)) $builder->orWhere($field, 'like', $term);
                }
            });
        }
        $records = $query->latest('updated_at')->paginate(15)->withQueryString();
        return view('admin.resources.index', compact('resource','definition','records'));
    }

    public function create(Request $request, string $resource)
    {
        $definition = $this->definition($resource);
        $this->authorizeCreate($request, $resource, $definition);
        $record = new $definition['class'];
        if ($resource === 'categories' && $request->filled('type')) $record->type = $request->string('type')->toString();
        return view('admin.resources.form', compact('resource','definition','record'));
    }

    public function store(Request $request, string $resource)
    {
        $definition = $this->definition($resource);
        $this->authorizeCreate($request, $resource, $definition);
        $this->authorizeRequestedPublish($request, $resource);
        $data = $this->validatedData($request, $resource, $definition);
        $this->assertCanPublish($request, $resource, $data);
        $record = $definition['class']::query()->create($data);
        $this->syncTags($request, $resource, $record, $definition);
        ActivityLogger::record($resource.'.created', $record, 'Created '.$definition['title'].' item '.$record->getAttribute('title')); 
        return redirect()->route('admin.'.$resource.'.index')->with('success', $definition['title'].' item created.');
    }

    public function edit(Request $request, string $id, string $resource)
    {
        $definition = $this->definition($resource);
        $record = $definition['class']::query()->findOrFail($id);
        $this->authorizeRecord($request, $resource, 'update', $record);
        return view('admin.resources.form', compact('resource','definition','record'));
    }

    public function update(Request $request, string $id, string $resource)
    {
        $definition = $this->definition($resource);
        $record = $definition['class']::query()->findOrFail($id);
        $this->authorizeRecord($request, $resource, 'update', $record);
        $this->authorizeRequestedPublish($request, $resource, $record);
        $data = $this->validatedData($request, $resource, $definition, $record);
        $this->assertCanPublish($request, $resource, $data, $record);
        $oldUploads = [];
        foreach (collect($definition['fields'])->filter(fn ($field) => in_array($field[2], ['image','file'], true)) as [$name]) {
            if ($request->hasFile($name) && $record->getAttribute($name)) $oldUploads[$name] = $record->getAttribute($name);
        }
        $record->fill($data)->save();
        foreach ($oldUploads as $name => $path) Storage::disk($name === 'download_path' ? 'local' : 'public')->delete($path);
        $this->syncTags($request, $resource, $record, $definition);
        ActivityLogger::record($resource.'.updated', $record, 'Updated '.$definition['title'].' item');
        return redirect()->route('admin.'.$resource.'.index')->with('success', $definition['title'].' item updated.');
    }

    public function destroy(Request $request, string $id, string $resource)
    {
        $definition = $this->definition($resource);
        $record = $definition['class']::query()->findOrFail($id);
        $this->authorizeRecord($request, $resource, 'delete', $record);
        $record->delete();
        ActivityLogger::record($resource.'.deleted', $record, 'Deleted '.$definition['title'].' item');
        return redirect()->route('admin.'.$resource.'.index')->with('success', $definition['title'].' item deleted.');
    }

    private function definition(string $resource): array
    {
        abort_unless(isset(self::DEFINITIONS[$resource]), 404);
        return self::DEFINITIONS[$resource];
    }

    private function authorizeResource(Request $request, string $resource, string $ability, ?Model $record = null): void
    {
        if ($resource === 'ai-tools') {
            abort_unless($request->user()->can('manage AI tools'), 403);
            return;
        }
        $target = $record ?? self::DEFINITIONS[$resource]['class'];
        Gate::authorize($ability, $target);
    }

    private function authorizeCreate(Request $request, string $resource, array $definition): void
    {
        if ($resource === 'ai-tools') {
            abort_unless($request->user()->can('manage AI tools'), 403);
            return;
        }
        if ($resource === 'categories') {
            $type = $request->input('type');
            if ($type) {
                Gate::authorize('create', [Category::class, $type]);
            } else {
                $canManageAnyCategory = collect(['posts','tutorials','templates','tools','projects'])->contains(fn ($candidate) => $request->user()->can(match ($candidate) {
                    'posts'=>'manage post categories','tutorials'=>'manage tutorial categories','templates'=>'manage template categories','tools'=>'manage tools','projects'=>'manage project categories',
                }));
                abort_unless($canManageAnyCategory, 403);
            }
            return;
        }
        Gate::authorize('create', $definition['class']);
    }

    private function authorizeRecord(Request $request, string $resource, string $ability, Model $record): void
    {
        if ($resource === 'ai-tools') {
            abort_unless($request->user()->can('manage AI tools'), 403);
            return;
        }
        Gate::authorize($ability, $record);
    }

    private function validatedData(Request $request, string $resource, array $definition, ?Model $record = null): array
    {
        $rules = [];
        $fields = collect($definition['fields']);
        foreach ($fields as [$name, $label, $type, $required]) {
            if ($type === 'tags') {
                $rules[$name] = ['nullable','array'];
                $rules[$name.'.*'] = ['integer','exists:tags,id'];
                continue;
            }
            if (str_starts_with($type, 'category:')) {
                $rules[$name] = ['nullable','integer','exists:categories,id'];
                continue;
            }
            if ($type === 'image') {
                $rules[$name] = ['nullable','image','mimes:jpg,jpeg,png,webp','max:5120'];
                continue;
            }
            if ($type === 'file') {
                $rules[$name] = ['nullable','file','mimes:zip,pdf,txt','max:20480'];
                continue;
            }
            $base = $required ? ['required'] : ['nullable'];
            if ($name === 'slug') {
                $table = $definition['class']::make()->getTable();
                $unique = Rule::unique($table, 'slug');
                if ($record) $unique->ignore($record->getKey());
                $rules[$name] = [...$base, 'string','max:180',$unique];
            } elseif ($type === 'status') {
                $rules[$name] = [...$base,'in:draft,published,archived'];
            } elseif (str_starts_with($type, 'select:')) {
                $rules[$name] = [...$base, Rule::in(explode(',', substr($type, 7)))];
            } elseif ($type === 'boolean') {
                $rules[$name] = ['nullable','boolean'];
            } elseif (in_array($type, ['number'], true)) {
                $rules[$name] = [...$base,'integer','min:0','max:65535'];
            } elseif ($type === 'datetime') {
                $rules[$name] = ['nullable','date'];
            } elseif ($type === 'date') {
                $rules[$name] = ['nullable','date'];
            } elseif ($type === 'url') {
                $rules[$name] = [...$base,'url:http,https','max:2048'];
            } else {
                $max = match ($name) {
                    'title','name','seo_title' => 255,
                    'slug' => 180,
                    'icon','provider','license','version' => 80,
                    'seo_description' => 320,
                    'summary','excerpt','description' => $type === 'textarea' ? 200000 : 5000,
                    default => 200000,
                };
                $rules[$name] = [...$base,'string','max:'.$max];
            }
        }

        $validated = $request->validate($rules);
        $data = [];
        foreach ($fields as [$name, $label, $type]) {
            if ($type === 'tags') continue;
            if ($type === 'image' || $type === 'file') {
                if ($request->hasFile($name)) {
                    $disk = $type === 'image' ? 'public' : 'local';
                    $data[$name] = $request->file($name)->store('uploads/'.$resource, $disk);
                }
                continue;
            }
            if (! array_key_exists($name, $validated)) {
                if ($type === 'boolean') $data[$name] = false;
                continue;
            }
            $value = $validated[$name];
            if ($type === 'list') $value = collect(preg_split('/[,\r\n]+/', (string) $value))->map(fn ($item) => trim($item))->filter()->unique()->values()->all();
            if ($name === 'slug' && blank($value)) $value = $this->uniqueSlug($definition, (string) ($validated['title'] ?? $validated['name'] ?? 'item'), $validated['type'] ?? null, $record);
            $data[$name] = $value;
        }
        if (in_array($resource, ['posts','tutorials'], true) && ! $record) $data['author_id'] = $request->user()->id;
        if (($data['status'] ?? null) === 'published' && blank($data['published_at'] ?? null) && in_array('published_at', $definition['class']::make()->getFillable(), true)) $data['published_at'] = now();
        if ($resource === 'categories' && ! in_array($data['type'] ?? $record?->type, ['posts','tutorials','templates','tools','projects'], true)) abort(422, 'Select a supported category type.');
        if (isset($data['category_id'])) {
            $categoryType = $resource === 'posts' ? 'posts' : $resource;
            if ($resource === 'ai-tools') $categoryType = 'ai-tools';
            abort_unless(Category::query()->whereKey($data['category_id'])->where('type', $categoryType)->exists(), 422, 'Select a category for this content type.');
        }
        return $data;
    }

    private function assertCanPublish(Request $request, string $resource, array $data, ?Model $record = null): void
    {
        if (($data['status'] ?? null) !== 'published' || ! in_array($resource, ['posts','tutorials','templates','tools','services','projects'], true)) return;
        if ($record && $record->getAttribute('status') === 'published') return;
        $permission = match ($resource) {
            'posts'=>'publish posts', 'tutorials'=>'publish tutorials', 'templates'=>'publish templates', 'tools'=>'publish tools', 'services'=>'publish services', 'projects'=>'publish projects',
        };
        abort_unless($request->user()->can($permission), 403, 'You do not have permission to publish this content.');
    }

    private function authorizeRequestedPublish(Request $request, string $resource, ?Model $record = null): void
    {
        if (! in_array($resource, ['posts','tutorials','templates','tools','services','projects'], true)) return;
        $request->validate(['status'=>['required','in:draft,published,archived']]);
        $this->assertCanPublish($request, $resource, ['status'=>$request->input('status')], $record);
    }

    private function uniqueSlug(array $definition, string $source, ?string $type, ?Model $record): string
    {
        $base = Str::slug($source) ?: 'item';
        $slug = $base;
        $suffix = 2;
        do {
            $query = \Illuminate\Support\Facades\DB::table((new $definition['class'])->getTable())->where('slug',$slug);
            if ($resourceType = $definition['class'] === Category::class ? $type : null) $query->where('type',$resourceType);
            if ($record) $query->where('id','<>',$record->getKey());
            if (! $query->exists()) return $slug;
            $slug = $base.'-'.$suffix++;
        } while ($suffix < 1000);
        return $base.'-'.Str::lower(Str::random(8));
    }

    private function syncTags(Request $request, string $resource, Model $record, array $definition): void
    {
        if (! collect($definition['fields'])->contains(fn ($field) => $field[0] === 'tags')) return;
        $permission = match ($resource) {
            'posts' => 'manage post tags',
            'tutorials' => 'manage tutorial tags',
            'templates' => 'manage template tags',
            default => null,
        };
        if (! $permission || ! $request->user()->can($permission)) {
            abort_if($request->filled('tags'), 403, 'You cannot manage tags for this content.');
            return;
        }
        $record->tags()->sync($request->input('tags', []));
    }
}
