<?php

namespace App\Livewire\Public;

use App\Actions\SubmitContactMessage;
use Livewire\Component;

class ContactForm extends Component
{
    public string $name = '';
    public string $email = '';
    public string $project_type = '';
    public string $subject = '';
    public string $message = '';
    public string $website = '';
    public bool $sent = false;

    public function submit(SubmitContactMessage $submission): void
    {
        $submission->handle([
            'name' => $this->name,
            'email' => $this->email,
            'project_type' => $this->project_type,
            'subject' => $this->subject,
            'message' => $this->message,
            'website' => $this->website,
        ], (string) request()->ip());

        $this->reset(['name', 'email', 'project_type', 'subject', 'message', 'website']);
        $this->sent = true;
    }

    public function render()
    {
        return view('livewire.public.contact-form');
    }
}
