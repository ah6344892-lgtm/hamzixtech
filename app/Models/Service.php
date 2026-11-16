<?php

namespace App\Models;

use App\Models\Concerns\HasPublishingStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory, HasPublishingStatus, SoftDeletes;

    protected $fillable = [
        'title', 'slug', 'summary', 'description', 'icon', 'featured_image',
        'featured_image_alt', 'sort_order', 'status', 'published_at', 'featured', 'seo_title', 'seo_description',
    ];

    protected function casts(): array
    {
        return ['featured' => 'boolean', 'sort_order' => 'integer', 'published_at' => 'datetime'];
    }
}
