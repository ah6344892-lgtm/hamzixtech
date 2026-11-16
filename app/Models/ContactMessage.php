<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'subject', 'project_type', 'message', 'status',
        'internal_notes', 'read_at', 'replied_at', 'closed_at',
    ];

    protected function casts(): array
    {
        return ['read_at' => 'datetime', 'replied_at' => 'datetime', 'closed_at' => 'datetime'];
    }
}
