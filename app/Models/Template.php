<?php

namespace App\Models;

use App\Models\Concerns\HasPublishingStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Template extends Model
{
    use HasFactory, HasPublishingStatus, SoftDeletes;

    protected $fillable = [
        'category_id', 'title', 'slug', 'summary', 'description', 'features',
        'requirements', 'installation_instructions', 'technologies', 'screenshots',
        'thumbnail', 'thumbnail_alt', 'github_url', 'demo_url', 'download_path',
        'version', 'license', 'pricing_type', 'status', 'published_at',
        'last_updated_at', 'featured', 'seo_title', 'seo_description',
    ];

    protected function casts(): array
    {
        return [
            'technologies' => 'array',
            'screenshots' => 'array',
            'published_at' => 'datetime',
            'last_updated_at' => 'date',
            'featured' => 'boolean',
        ];
    }

    public function category(): BelongsTo { return $this->belongsTo(Category::class); }
    public function tags(): BelongsToMany { return $this->belongsToMany(Tag::class, 'template_tag'); }
}
