<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Tutorial;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/** @extends Factory<Tutorial> */
class TutorialFactory extends Factory
{
    protected $model = Tutorial::class;

    public function definition(): array
    {
        $title = fake()->sentence(5);

        return [
            'category_id' => Category::factory()->state(['type' => 'tutorials']),
            'author_id' => User::factory(),
            'title' => $title,
            'slug' => Str::slug($title).'-'.fake()->unique()->numerify('####'),
            'summary' => fake()->sentence(),
            'content' => fake()->paragraphs(4, true),
            'cover_image' => null,
            'cover_image_alt' => null,
            'difficulty' => fake()->randomElement(['beginner', 'intermediate', 'advanced']),
            'estimated_minutes' => fake()->numberBetween(5, 90),
            'technologies' => [],
            'status' => 'draft',
            'published_at' => null,
            'featured' => false,
            'seo_title' => null,
            'seo_description' => null,
        ];
    }
}
