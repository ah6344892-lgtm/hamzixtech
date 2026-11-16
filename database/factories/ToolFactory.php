<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Tool;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/** @extends Factory<Tool> */
class ToolFactory extends Factory
{
    protected $model = Tool::class;

    public function definition(): array
    {
        $title = fake()->words(3, true);

        return [
            'category_id' => Category::factory()->state(['type' => 'tools']),
            'title' => ucfirst($title),
            'slug' => Str::slug($title).'-'.fake()->unique()->numerify('####'),
            'description' => fake()->sentence(),
            'instructions' => null,
            'icon' => null,
            'is_implemented' => false,
            'is_enabled' => false,
            'status' => 'draft',
            'published_at' => null,
            'seo_title' => null,
            'seo_description' => null,
        ];
    }
}
