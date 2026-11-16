<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/** @extends Factory<Project> */
class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition(): array
    {
        $title = fake()->sentence(4);

        return [
            'category_id' => Category::factory()->state(['type' => 'projects']),
            'title' => $title,
            'slug' => Str::slug($title).'-'.fake()->unique()->numerify('####'),
            'summary' => fake()->sentence(),
            'description' => fake()->paragraphs(2, true),
            'main_image' => null,
            'main_image_alt' => null,
            'gallery' => [],
            'technologies' => [],
            'demo_url' => null,
            'source_url' => null,
            'completed_at' => null,
            'sort_order' => 0,
            'featured' => false,
            'status' => 'draft',
            'published_at' => null,
            'seo_title' => null,
            'seo_description' => null,
        ];
    }
}
