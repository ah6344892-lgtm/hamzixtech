<?php

namespace App\Support;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ActivityLogger
{
    public static function record(string $event, ?Model $subject = null, ?string $description = null, array $properties = []): void
    {
        ActivityLog::query()->create([
            'user_id' => Auth::id(),
            'event' => $event,
            'subject_type' => $subject?->getMorphClass(),
            'subject_id' => $subject?->getKey(),
            'description' => $description,
            'properties' => $properties,
        ]);
    }
}
