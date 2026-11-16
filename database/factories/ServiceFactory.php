<?php

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/** @extends Factory<Service> */
class ServiceFactory extends Factory
{
    protected $model = Service::class;

    public function definition(): array
    {
        $title = fake()->words(3, true);

        return [
            'title' => ucfirst($title),
            'slug' => Str::slug($title).'-'.fake()->unique()->numerify('####'),
            'summary' => fake()->sentence(),
            'description' => fake()->paragraphs(2, true),
            'icon' => null,
            'featured_image' => null,
            'featured_image_alt' => null,
            'sort_order' => 0,
            'status' => 'draft',
            'published_at' => null,
            'featured' => false,
            'seo_title' => null,
            'seo_description' => null,
        ];
    }
}
