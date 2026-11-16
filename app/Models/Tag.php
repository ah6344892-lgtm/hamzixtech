<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug'];

    public function posts(): BelongsToMany { return $this->belongsToMany(Post::class); }
    public function tutorials(): BelongsToMany { return $this->belongsToMany(Tutorial::class, 'tutorial_tag'); }
    public function templates(): BelongsToMany { return $this->belongsToMany(Template::class, 'template_tag'); }
}
