<x-mail::message>
# New contact message

**From:** {{ $messageRecord->name }} ({{ $messageRecord->email }})

**Subject:** {{ $messageRecord->subject }}

{{ $messageRecord->message }}

View and manage submissions in the HamzixTech administration panel.
</x-mail::message>
