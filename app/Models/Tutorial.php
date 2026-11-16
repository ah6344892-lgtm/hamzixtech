<?php

namespace App\Models;

use App\Models\Concerns\HasPublishingStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tutorial extends Model
{
    use HasFactory, HasPublishingStatus, SoftDeletes;

    protected $fillable = [
        'category_id', 'author_id', 'title', 'slug', 'summary', 'content',
        'cover_image', 'cover_image_alt', 'difficulty', 'estimated_minutes',
        'technologies', 'status', 'published_at', 'featured', 'seo_title', 'seo_description',
    ];

    protected function casts(): array
    {
        return ['technologies' => 'array', 'published_at' => 'datetime', 'featured' => 'boolean'];
    }

    public function category(): BelongsTo { return $this->belongsTo(Category::class); }
    public function author(): BelongsTo { return $this->belongsTo(User::class, 'author_id'); }
    public function tags(): BelongsToMany { return $this->belongsToMany(Tag::class, 'tutorial_tag'); }
}
