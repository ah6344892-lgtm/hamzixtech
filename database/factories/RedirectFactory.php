<?php

namespace Database\Factories;

use App\Models\Redirect;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Redirect> */
class RedirectFactory extends Factory
{
    protected $model = Redirect::class;

    public function definition(): array
    {
        return ['from_path' => '/old/'.fake()->unique()->slug(), 'to_path' => '/', 'status_code' => 301, 'enabled' => true];
    }
}
