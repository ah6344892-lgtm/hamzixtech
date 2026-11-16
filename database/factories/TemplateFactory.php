<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Template;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/** @extends Factory<Template> */
class TemplateFactory extends Factory
{
    protected $model = Template::class;

    public function definition(): array
    {
        $title = fake()->sentence(4);

        return [
            'category_id' => Category::factory()->state(['type' => 'templates']),
            'title' => $title,
            'slug' => Str::slug($title).'-'.fake()->unique()->numerify('####'),
            'summary' => fake()->sentence(),
            'description' => fake()->paragraphs(2, true),
            'features' => null,
            'requirements' => null,
            'installation_instructions' => null,
            'technologies' => [],
            'screenshots' => [],
            'thumbnail' => null,
            'thumbnail_alt' => null,
            'github_url' => null,
            'demo_url' => null,
            'download_path' => null,
            'version' => '1.0.0',
            'license' => null,
            'pricing_type' => 'free',
            'status' => 'draft',
            'published_at' => null,
            'last_updated_at' => now()->toDateString(),
            'featured' => false,
            'seo_title' => null,
            'seo_description' => null,
        ];
    }
}
