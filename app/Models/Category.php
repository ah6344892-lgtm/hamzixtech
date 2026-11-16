<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['type', 'name', 'slug', 'description', 'seo_title', 'seo_description'];

    public function posts(): HasMany { return $this->hasMany(Post::class); }
    public function tutorials(): HasMany { return $this->hasMany(Tutorial::class); }
    public function templates(): HasMany { return $this->hasMany(Template::class); }
    public function tools(): HasMany { return $this->hasMany(Tool::class); }
    public function projects(): HasMany { return $this->hasMany(Project::class); }

    public function scopeForType($query, string $type)
    {
        return $query->where('type', $type);
    }
}
