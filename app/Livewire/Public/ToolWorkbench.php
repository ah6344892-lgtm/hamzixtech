<?php

namespace App\Livewire\Public;

use App\Services\ToolRunner;
use Livewire\Component;
use InvalidArgumentException;
use JsonException;

class ToolWorkbench extends Component
{
    public string $slug = '';
    public string $input = '';
    public string $output = '';
    public ?string $error = null;

    public function mount(string $slug): void
    {
        $this->slug = $slug;
    }

    public function run(string $operation = 'format'): void
    {
        $this->validate(['input' => ['nullable','string','max:50000']]);
        $this->error = null;
        $this->output = '';

        try {
            $this->output = app(ToolRunner::class)->run($this->slug, $this->input, $operation);
        } catch (JsonException) {
            $this->error = 'The input is not valid JSON.';
        } catch (InvalidArgumentException $exception) {
            $this->error = $exception->getMessage();
        }
    }

    public function render()
    {
        return view('livewire.public.tool-workbench');
    }
}
