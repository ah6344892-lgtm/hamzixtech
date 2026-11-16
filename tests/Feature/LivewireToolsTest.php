<?php

namespace Tests\Feature;

use App\Livewire\Public\ContactForm;
use App\Livewire\Public\ToolWorkbench;
use App\Models\ContactMessage;
use App\Models\Tool;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class LivewireToolsTest extends TestCase
{
    use RefreshDatabase;

    public function test_json_formatter_formats_valid_json_and_reports_invalid_json(): void
    {
        Livewire::test(ToolWorkbench::class, ['slug'=>'json-formatter'])
            ->set('input','{"ready":true}')
            ->call('run')
            ->assertSet('output', "{\n    \"ready\": true\n}")
            ->assertSet('error', null);

        Livewire::test(ToolWorkbench::class, ['slug'=>'json-formatter'])
            ->set('input','{bad json')
            ->call('run')
            ->assertSet('error','The input is not valid JSON.');
    }

    public function test_simple_mode_uses_the_server_post_tool_workbench(): void
    {
        config()->set('hamzixtech.ui_mode', 'simple');
        $tool = $this->createTool('json-formatter');

        $this->get(route('tools.show', $tool))
            ->assertOk()
            ->assertSee('name="operation"', false)
            ->assertDontSee('wire:model="input"', false);

        $this->post(route('tools.run', $tool), ['input' => '{"ready":true}', 'operation' => 'format'])
            ->assertOk()
            ->assertSee('&quot;ready&quot;: true', false);
    }

    public function test_livewire_mode_uses_livewire_tools_and_contact_form(): void
    {
        config()->set('hamzixtech.ui_mode', 'livewire');
        $tool = $this->createTool('json-formatter');

        $this->get(route('tools.show', $tool))
            ->assertOk()
            ->assertSee('wire:model="input"', false);

        $this->get(route('contact'))
            ->assertOk()
            ->assertSee('wire:submit="submit"', false);
    }

    public function test_livewire_contact_form_validates_and_saves_a_message(): void
    {
        Livewire::test(ContactForm::class)
            ->set('name', 'Visitor')
            ->set('email', 'visitor@example.test')
            ->set('subject', 'Project inquiry')
            ->set('message', 'I would like to discuss a new website project.')
            ->call('submit')
            ->assertHasNoErrors()
            ->assertSet('sent', true);

        $this->assertDatabaseHas('contact_messages', [
            'email' => 'visitor@example.test',
            'subject' => 'Project inquiry',
        ]);
        $this->assertSame(1, ContactMessage::query()->count());
    }

    private function createTool(string $slug): Tool
    {
        return Tool::query()->create([
            'title' => 'JSON Formatter',
            'slug' => $slug,
            'description' => 'Format JSON data.',
            'is_implemented' => true,
            'is_enabled' => true,
            'status' => 'published',
        ]);
    }
}
