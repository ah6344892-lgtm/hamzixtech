<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\Project;
use App\Models\Service;
use App\Models\Tag;
use App\Models\Template;
use App\Models\Tutorial;
use Illuminate\Database\Seeder;

class ExampleContentSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [];

        foreach ([
            ['posts', 'Web development', 'web-development'],
            ['tutorials', 'Practical guides', 'practical-guides'],
            ['templates', 'Starter kits', 'starter-kits'],
            ['projects', 'Interface concepts', 'interface-concepts'],
        ] as [$type, $name, $slug]) {
            $categories[$type] = Category::query()->firstOrCreate(
                ['type' => $type, 'slug' => $slug],
                ['name' => $name, 'description' => 'Example category for organizing '.$type.'.']
            );
        }

        $tags = collect([
            ['Laravel', 'laravel'],
            ['UI design', 'ui-design'],
            ['Accessibility', 'accessibility'],
        ])->mapWithKeys(fn (array $tag) => [
            $tag[1] => Tag::query()->firstOrCreate(['slug' => $tag[1]], ['name' => $tag[0]]),
        ]);

        foreach ([
            [
                'slug' => 'responsive-website-design',
                'title' => 'Responsive website design',
                'summary' => 'Clear, responsive websites with thoughtful content structure and a consistent visual system.',
                'description' => "## A clear starting point\n\nPlan the page structure, content hierarchy, and visual direction around the people who will use the site.\n\n## What this can include\n\n- Responsive page design and implementation\n- Accessible navigation and forms\n- Performance-minded front-end foundations\n- A maintainable component and style system\n\nShare your goals to shape a scope that fits your project.",
                'icon' => 'computer-desktop',
            ],
            [
                'slug' => 'web-application-development',
                'title' => 'Web application development',
                'summary' => 'Practical application interfaces, staff dashboards, and workflows built around real tasks.',
                'description' => "## From workflow to interface\n\nTurn a process into a focused web application with clear states, useful feedback, and a responsive layout.\n\n## Typical building blocks\n\n- Authentication and role-aware screens\n- Data entry, search, and reporting flows\n- Reusable interface patterns\n- Tested application behavior",
                'icon' => 'squares-2x2',
            ],
            [
                'slug' => 'api-and-backend-engineering',
                'title' => 'API and backend engineering',
                'summary' => 'Well-structured server-side features and API integrations with validation and clear boundaries.',
                'description' => "## Reliable foundations\n\nDesign server-side features with explicit validation, authorization, and predictable responses.\n\n## Areas to explore\n\n- API endpoints and third-party integrations\n- Database-backed workflows\n- Background processing and notifications\n- Automated tests for important behavior",
                'icon' => 'circle-stack',
            ],
        ] as $order => $service) {
            Service::query()->firstOrCreate(
                ['slug' => $service['slug']],
                [...$service, 'status' => 'published', 'published_at' => now()->subDays(30 - $order), 'featured' => true, 'sort_order' => $order + 1]
            );
        }

        foreach ([
            [
                'slug' => 'sample-studio-landing-page',
                'title' => 'Example: Studio landing page',
                'summary' => 'A sample concept showing how a compact service website can guide visitors from discovery to contact.',
                'description' => "## Concept overview\n\nThis example entry demonstrates a small studio landing-page concept. It is sample content for previewing the portfolio layout, not a client case study.\n\nThe concept focuses on clear service descriptions, readable sections, and a direct contact path.",
                'technologies' => ['Laravel', 'Tailwind CSS', 'Blade'],
            ],
            [
                'slug' => 'sample-project-dashboard',
                'title' => 'Example: Project dashboard',
                'summary' => 'A sample dashboard concept with compact status cards, useful filters, and responsive navigation.',
                'description' => "## Concept overview\n\nThis sample dashboard illustrates a responsive interface for reviewing work items and activity. It is a design example, not a report of a completed client project.\n\nThe layout prioritizes scannable status information and straightforward navigation.",
                'technologies' => ['Laravel', 'Livewire', 'Flux UI'],
            ],
            [
                'slug' => 'sample-developer-workbench',
                'title' => 'Example: Developer workbench',
                'summary' => 'A sample utility interface built around focused input, clear results, and privacy-aware interactions.',
                'description' => "## Concept overview\n\nThis example shows a small tool workspace with a focused input area, an explicit action, and easy-to-copy output. It is an illustrative portfolio entry, not a client case study.",
                'technologies' => ['PHP', 'JavaScript', 'Accessibility'],
            ],
        ] as $order => $project) {
            Project::query()->firstOrCreate(
                ['slug' => $project['slug']],
                [
                    ...$project,
                    'category_id' => $categories['projects']->id,
                    'status' => 'published',
                    'published_at' => now()->subDays(14 - $order),
                    'completed_at' => now()->subDays(14 - $order)->toDateString(),
                    'featured' => true,
                    'sort_order' => $order + 1,
                ]
            );
        }

        $posts = [
            [
                'slug' => 'a-practical-checklist-for-responsive-pages',
                'title' => 'A practical checklist for responsive pages',
                'excerpt' => 'A short, repeatable way to review layout, navigation, text, and touch targets before a page ships.',
                'content' => "## Start with the narrow screen\n\nCheck that the main task is obvious before adding more content. A useful mobile layout should not feel like a squeezed desktop page.\n\n## Review the essentials\n\n- Keep navigation easy to open, use, and dismiss.\n- Let long headings wrap naturally without clipping.\n- Use comfortable spacing around buttons and form controls.\n- Check tables and code blocks for horizontal overflow.\n- Test real content lengths, not only short placeholders.\n\n## Verify more than one width\n\nCheck a narrow phone, a wider phone, a tablet, and a desktop viewport. Look for awkward empty gaps and controls that become difficult to reach.\n\nA quick checklist is most useful when it is repeated after content changes, not just at initial launch.",
            ],
            [
                'slug' => 'accessible-controls-with-clear-feedback',
                'title' => 'Accessible controls with clear feedback',
                'excerpt' => 'Small interface details that help keyboard, screen-reader, and touch users understand what happened.',
                'content' => "## Make state visible\n\nButtons and controls should communicate their purpose and, when relevant, their current state. Do not rely on color alone to communicate success or an error.\n\n## A few useful habits\n\n- Give icon-only buttons an accessible name.\n- Keep keyboard focus visible.\n- Associate labels and validation messages with fields.\n- Announce important asynchronous results.\n- Respect reduced-motion preferences.\n\nThese details make everyday interactions easier to understand for everyone.",
            ],
            [
                'slug' => 'keeping-small-web-tools-private-by-default',
                'title' => 'Keeping small web tools private by default',
                'excerpt' => 'A design note on clear processing expectations, minimal retention, and useful error messages.',
                'content' => "## Tell people what happens to their input\n\nA small utility should explain whether processing happens in the browser or on a server and whether content is stored.\n\n## Keep the workflow focused\n\nAccept only the input required for the task, validate it, and return a clear result. When something fails, explain how to correct it without echoing sensitive information unnecessarily.\n\nPrivacy is part of the interface: make expectations visible before someone submits their data.",
            ],
        ];

        foreach ($posts as $order => $postData) {
            $post = Post::query()->firstOrCreate(
                ['slug' => $postData['slug']],
                [
                    ...$postData,
                    'category_id' => $categories['posts']->id,
                    'status' => 'published',
                    'published_at' => now()->subDays(7 - $order),
                    'featured' => $order === 0,
                    'seo_title' => $postData['title'].' | HamzixTech',
                    'seo_description' => $postData['excerpt'],
                ]
            );
            $post->tags()->syncWithoutDetaching($tags->only(['ui-design', 'accessibility'])->pluck('id'));
        }

        foreach ([
            [
                'slug' => 'build-a-responsive-page-layout',
                'title' => 'Build a responsive page layout',
                'summary' => 'Work from content hierarchy to a flexible grid, then check the experience at practical breakpoints.',
                'content' => "## 1. Outline the content\n\nWrite down the page title, primary action, and supporting sections before choosing columns.\n\n## 2. Add a flexible layout\n\nUse a single-column flow by default, then introduce columns only when the content has room. Keep the reading width comfortable.\n\n## 3. Check real interactions\n\nTry the navigation, keyboard focus, and form controls at a narrow viewport. Confirm that nothing depends on hover alone.",
                'difficulty' => 'beginner',
                'estimated_minutes' => 12,
                'technologies' => ['HTML', 'CSS', 'Tailwind CSS'],
            ],
            [
                'slug' => 'validate-a-laravel-form',
                'title' => 'Validate a Laravel form',
                'summary' => 'A concise walkthrough of server-side validation, helpful feedback, and safe persistence.',
                'content' => "## Validate at the server boundary\n\nDefine the fields the endpoint accepts and set clear type, length, and format rules. Client-side hints improve usability but do not replace server validation.\n\n## Return useful feedback\n\nShow field-specific errors next to the relevant controls and preserve safe old input after a validation failure.\n\n## Persist only validated values\n\nUse the validated data rather than trusting every submitted request field. Add feature tests for valid and invalid submissions.",
                'difficulty' => 'beginner',
                'estimated_minutes' => 15,
                'technologies' => ['Laravel', 'PHP'],
            ],
        ] as $order => $tutorial) {
            Tutorial::query()->firstOrCreate(
                ['slug' => $tutorial['slug']],
                [
                    ...$tutorial,
                    'category_id' => $categories['tutorials']->id,
                    'status' => 'published',
                    'published_at' => now()->subDays(3 - $order),
                    'featured' => $order === 0,
                    'seo_title' => $tutorial['title'].' | HamzixTech',
                    'seo_description' => $tutorial['summary'],
                ]
            );
        }

        foreach ([
            [
                'slug' => 'responsive-landing-page-blueprint',
                'title' => 'Example: Responsive landing page blueprint',
                'summary' => 'A content outline and implementation checklist for a focused landing page.',
                'description' => 'An example starter blueprint for planning sections, writing a clear call to action, and checking responsive behavior.',
                'features' => "Content hierarchy checklist\nResponsive section outline\nAccessibility review prompts",
                'requirements' => 'Basic familiarity with HTML and CSS.',
                'installation_instructions' => 'Use this blueprint as a planning reference; no package download is included.',
                'technologies' => ['HTML', 'CSS', 'Accessibility'],
                'version' => '1.0',
            ],
            [
                'slug' => 'laravel-feature-test-planner',
                'title' => 'Example: Laravel feature test planner',
                'summary' => 'A simple checklist for mapping success, validation, authorization, and persistence cases.',
                'description' => 'An example planning resource for organizing feature-test scenarios before implementing a Laravel workflow.',
                'features' => "Happy path checklist\nValidation failure checklist\nPermission boundary prompts",
                'requirements' => 'A Laravel application and its existing test runner.',
                'installation_instructions' => 'Adapt the checklist to the behavior and conventions of your own application.',
                'technologies' => ['Laravel', 'PHPUnit'],
                'version' => '1.0',
            ],
        ] as $order => $template) {
            Template::query()->firstOrCreate(
                ['slug' => $template['slug']],
                [
                    ...$template,
                    'category_id' => $categories['templates']->id,
                    'pricing_type' => 'free',
                    'license' => 'Example content; review before reuse.',
                    'status' => 'published',
                    'published_at' => now()->subDays(2 - $order),
                    'featured' => true,
                    'seo_title' => $template['title'].' | HamzixTech',
                    'seo_description' => $template['summary'],
                ]
            );
        }
    }
}
