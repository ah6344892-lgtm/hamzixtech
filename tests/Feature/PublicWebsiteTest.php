<?php

namespace Tests\Feature;

use App\Models\ContactMessage;
use App\Models\Post;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicWebsiteTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
    }

    public function test_public_pages_render_without_published_content_or_owner_contact_details(): void
    {
        foreach ([
            '/', '/services', '/projects', '/blog', '/tutorials', '/templates', '/tools',
            '/ai-tools', '/about', '/contact', '/privacy-policy', '/terms', '/robots.txt', '/sitemap.xml',
        ] as $path) {
            $this->get($path)->assertOk();
        }
    }

    public function test_published_posts_are_visible_and_drafts_are_not_public(): void
    {
        $published = Post::factory()->published()->create([
            'title' => 'Safe Markdown Article',
            'slug' => 'safe-markdown-article',
            'content' => "## Safe heading\n\n<script>alert('xss')</script>\n\n[unsafe](javascript:alert(1))",
        ]);
        $draft = Post::factory()->create(['slug' => 'private-draft']);

        $this->get('/blog')->assertOk()->assertSee($published->title)->assertDontSee($draft->title);
        $this->get('/blog/safe-markdown-article')->assertOk()->assertSee('<h2>Safe heading</h2>', false)->assertDontSee("alert('xss')", false)->assertDontSee('href="javascript:', false);
        $this->get('/blog/private-draft')->assertNotFound();
    }

    public function test_public_navigation_marks_the_current_section_as_active(): void
    {
        $this->get('/tools')
            ->assertOk()
            ->assertSee('aria-current="page"', false)
            ->assertSee('class="nav-link nav-link-active"', false);

        $this->get('/contact')
            ->assertOk()
            ->assertSee('aria-current="page"', false);
    }

    public function test_example_content_populates_the_public_resource_sections(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->get('/')->assertOk()->assertSee('Practical tutorials')->assertSee('Small tools for everyday work.');
        $this->get('/services')->assertOk()->assertSee('Responsive website design');
        $this->get('/projects')->assertOk()->assertSee('Example: Studio landing page');
        $this->get('/blog')->assertOk()->assertSee('A practical checklist for responsive pages');
        $this->get('/tutorials')->assertOk()->assertSee('Build a responsive page layout');
        $this->get('/templates')->assertOk()->assertSee('Example: Responsive landing page blueprint');
        $this->get('/tools')->assertOk()->assertSee('JSON Formatter');
        $this->get('/ai-tools')->assertOk()->assertSee('Examples only · not active');
    }

    public function test_contact_submission_is_validated_and_persisted(): void
    {
        $this->from('/contact')->post('/contact', [
            'name' => 'Visitor',
            'email' => 'visitor@example.test',
            'subject' => 'Project inquiry',
            'project_type' => 'Website',
            'message' => 'I would like to discuss a new website project.',
        ])->assertRedirect('/contact')->assertSessionHas('contact_success');

        $this->assertDatabaseHas('contact_messages', [
            'email' => 'visitor@example.test',
            'subject' => 'Project inquiry',
            'status' => 'new',
        ]);
        $this->assertSame(1, ContactMessage::query()->count());
    }
}
