<?php

namespace Database\Factories;

use App\Models\MediaAsset;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<MediaAsset> */
class MediaAssetFactory extends Factory
{
    protected $model = MediaAsset::class;

    public function definition(): array
    {
        $path = 'media/'.fake()->uuid().'.png';

        return [
            'uploaded_by' => null,
            'disk' => 'public',
            'path' => $path,
            'original_name' => basename($path),
            'mime_type' => 'image/png',
            'size_bytes' => 1024,
            'alt_text' => null,
        ];
    }
}
