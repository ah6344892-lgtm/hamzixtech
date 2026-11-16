<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    use HasFactory;

    protected $fillable = ['key', 'value', 'value_type', 'group'];

    public function getValueAttribute(?string $value): mixed
    {
        if ($value === null) {
            return null;
        }

        return ($this->attributes['value_type'] ?? 'text') === 'json'
            ? json_decode($value, true)
            : $value;
    }

    public function setValueAttribute(mixed $value): void
    {
        $this->attributes['value_type'] = is_array($value) || is_object($value) ? 'json' : 'text';
        $this->attributes['value'] = $this->attributes['value_type'] === 'json'
            ? json_encode($value, JSON_THROW_ON_ERROR)
            : $value;
    }

    public static function read(string $key, mixed $default = null): mixed
    {
        return static::query()->where('key', $key)->first()?->value ?? $default;
    }

    public static function write(string $key, mixed $value, string $group = 'general'): self
    {
        $setting = static::query()->firstOrNew(['key' => $key]);
        $setting->group = $group;
        $setting->value = $value;
        $setting->save();

        return $setting;
    }
}
