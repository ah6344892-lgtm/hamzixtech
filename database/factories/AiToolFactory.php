<?php

namespace Database\Factories;

use App\Models\AiTool;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/** @extends Factory<AiTool> */
class AiToolFactory extends Factory
{
    protected $model = AiTool::class;

    public function definition(): array
    {
        $name = fake()->words(3, true);

        return [
            'name' => ucfirst($name),
            'slug' => Str::slug($name).'-'.fake()->unique()->numerify('####'),
            'description' => fake()->sentence(),
            'icon' => null,
            'provider' => null,
            'is_implemented' => false,
            'enabled' => false,
            'status' => 'coming_soon',
            'sort_order' => 0,
        ];
    }
}
