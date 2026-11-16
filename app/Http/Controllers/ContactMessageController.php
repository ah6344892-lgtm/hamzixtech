<?php

namespace App\Http\Controllers;

use App\Actions\SubmitContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        app(SubmitContactMessage::class)->handle($request->all(), (string) $request->ip());

        return back()->with('contact_success', 'Thank you. Your message has been received.');
    }
}
