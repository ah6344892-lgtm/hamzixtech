<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/** @extends Factory<Post> */
class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        $title = fake()->sentence(6);

        return [
            'category_id' => Category::factory()->state(['type' => 'posts']),
            'author_id' => User::factory(),
            'title' => $title,
            'slug' => Str::slug($title).'-'.fake()->unique()->numerify('####'),
            'excerpt' => fake()->paragraph(),
            'content' => fake()->paragraphs(5, true),
            'featured_image' => null,
            'featured_image_alt' => null,
            'status' => 'draft',
            'published_at' => null,
            'featured' => false,
            'seo_title' => null,
            'seo_description' => null,
            'canonical_url' => null,
            'og_image' => null,
        ];
    }

    public function published(): static
    {
        return $this->state(['status' => 'published', 'published_at' => now()]);
    }
}
