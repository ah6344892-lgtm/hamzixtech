<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AiTool extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description', 'icon', 'provider', 'is_implemented', 'enabled', 'status', 'sort_order'];

    protected function casts(): array
    {
        return ['is_implemented' => 'boolean', 'enabled' => 'boolean', 'sort_order' => 'integer'];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopeAvailable($query)
    {
        return $query->where('is_implemented', true)->where('enabled', true)->where('status', 'published');
    }
}
