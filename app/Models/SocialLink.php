<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialLink extends Model
{
    use HasFactory;

    protected $fillable = ['platform', 'label', 'url', 'enabled', 'sort_order'];

    protected function casts(): array
    {
        return ['enabled' => 'boolean', 'sort_order' => 'integer'];
    }

    public function scopeVisible($query)
    {
        return $query->where('enabled', true)->whereNotNull('url')->where('url', '<>', '');
    }
}
