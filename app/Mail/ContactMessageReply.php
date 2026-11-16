<?php

namespace App\Mail;

use App\Models\ContactMessage;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class ContactMessageReply extends Mailable
{
    public function __construct(public ContactMessage $messageRecord, public string $replyBody) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Re: '.$this->messageRecord->subject);
    }

    public function content(): Content
    {
        return new Content(view: 'mail.contact-message-reply');
    }
}
