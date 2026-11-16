<?php

namespace App\Models;

use App\Models\Concerns\HasPublishingStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tool extends Model
{
    use HasFactory, HasPublishingStatus, SoftDeletes;

    protected $fillable = [
        'category_id', 'title', 'slug', 'description', 'instructions', 'icon',
        'is_implemented', 'is_enabled', 'status', 'published_at', 'seo_title', 'seo_description',
    ];

    protected function casts(): array
    {
        return ['is_implemented' => 'boolean', 'is_enabled' => 'boolean', 'published_at' => 'datetime'];
    }

    public function category(): BelongsTo { return $this->belongsTo(Category::class); }

    public function scopeAvailable($query)
    {
        return $query->published()->where('is_implemented', true)->where('is_enabled', true);
    }
}
