<?php

namespace App\Actions;

use App\Mail\ContactMessageReceived;
use App\Models\ContactMessage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Validator;

class SubmitContactMessage
{
    public static function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email:rfc', 'max:190'],
            'subject' => ['required', 'string', 'max:180'],
            'project_type' => ['nullable', 'string', 'max:80'],
            'message' => ['required', 'string', 'min:20', 'max:10000'],
        ];
    }

    public function handle(array $input, string $ip): void
    {
        $key = 'contact:'.$ip;
        abort_if(RateLimiter::tooManyAttempts($key, 5), 429, 'Please wait before sending another message.');
        RateLimiter::hit($key, 600);

        if (filled($input['website'] ?? null)) {
            return;
        }

        $data = Validator::make($input, self::rules())->validate();
        $message = ContactMessage::query()->create($data);
        $recipient = config('hamzixtech.contact_email');

        if (filled($recipient)) {
            try {
                Mail::to($recipient)->send(new ContactMessageReceived($message));
            } catch (\Throwable $exception) {
                report($exception);
            }
        }
    }
}
