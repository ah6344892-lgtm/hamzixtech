<?php

namespace App\Models;

use App\Models\Concerns\HasPublishingStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, HasPublishingStatus, SoftDeletes;

    protected $fillable = [
        'category_id', 'title', 'slug', 'summary', 'description', 'main_image',
        'main_image_alt', 'gallery', 'technologies', 'demo_url', 'source_url',
        'completed_at', 'sort_order', 'featured', 'status', 'published_at',
        'seo_title', 'seo_description',
    ];

    protected function casts(): array
    {
        return [
            'gallery' => 'array',
            'technologies' => 'array',
            'completed_at' => 'date',
            'published_at' => 'datetime',
            'featured' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function category(): BelongsTo { return $this->belongsTo(Category::class); }
}
