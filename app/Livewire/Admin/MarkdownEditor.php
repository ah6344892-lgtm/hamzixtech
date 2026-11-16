<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class MarkdownEditor extends Component
{
    public string $name;
    public string $label;
    public bool $required = false;
    public string $value = '';

    public function mount(string $name, string $label, ?string $value = '', bool $required = false): void
    {
        $this->name = $name;
        $this->label = $label;
        $this->value = $value ?? '';
        $this->required = $required;
    }

    public function render()
    {
        return view('livewire.admin.markdown-editor');
    }
}
