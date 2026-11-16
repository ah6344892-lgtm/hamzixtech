<?php

//available ui modes: simple, livewire

$uiMode = env('HAMZIXTECH_UI_MODE', 'livewire');

if (! in_array($uiMode, ['simple', 'livewire'], true)) {
    throw new InvalidArgumentException('HAMZIXTECH_UI_MODE must be "simple" or "livewire".');
}

return [
    'ui_mode' => $uiMode,
    'whatsapp_number' => env('HAMZIXTECH_WHATSAPP_NUMBER', ''),
    'contact_email' => env('HAMZIXTECH_CONTACT_EMAIL', ''),
    'whatsapp_message' => env('HAMZIXTECH_WHATSAPP_MESSAGE', ''),
    'ai' => [
        'provider' => env('AI_PROVIDER', ''),
        'api_key' => env('AI_API_KEY', ''),
        'model' => env('AI_MODEL', ''),
    ],
];
