<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\ContactMessageReply;
use App\Models\ContactMessage;
use App\Support\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;

class ContactMessagesController extends Controller
{
    public function index(Request $request)
    {
        Gate::authorize('viewAny', ContactMessage::class);
        $query = ContactMessage::query()->latest();
        if ($request->filled('status')) $query->where('status', $request->string('status'));
        if ($request->filled('q')) $query->where(fn ($q) => $q->where('name','like','%'.$request->string('q').'%')->orWhere('email','like','%'.$request->string('q').'%')->orWhere('subject','like','%'.$request->string('q').'%'));
        return view('admin.contact-messages.index', ['messages' => $query->paginate(20)->withQueryString()]);
    }

    public function update(Request $request, ContactMessage $message)
    {
        Gate::authorize('update', $message);
        $data = $request->validate([
            'status' => ['required','in:new,read,replied,closed'],
            'internal_notes' => ['nullable','string','max:10000'],
            'reply_body' => ['nullable','string','max:10000'],
        ]);
        if ($data['status'] === 'replied') Gate::authorize('reply', $message);
        $message->status = $data['status'];
        $message->internal_notes = $data['internal_notes'] ?? null;
        if ($data['status'] !== 'new' && ! $message->read_at) $message->read_at = now();
        if ($data['status'] === 'closed') $message->closed_at = now();
        if ($data['status'] === 'replied' && filled($data['reply_body'] ?? null)) {
            Gate::authorize('reply', $message);
            Mail::to($message->email)->send(new ContactMessageReply($message, $data['reply_body']));
            $message->replied_at = now();
        }
        $message->save();
        ActivityLogger::record('contact_message.updated', $message, 'Updated contact message status');
        return back()->with('success', 'Contact message updated.');
    }

    public function destroy(Request $request, ContactMessage $message)
    {
        Gate::authorize('delete', $message);
        $message->delete();
        ActivityLogger::record('contact_message.deleted', $message, 'Deleted contact message');
        return back()->with('success', 'Contact message deleted.');
    }
}
