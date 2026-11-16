<?php

namespace Database\Factories;

use App\Models\ContactMessage;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<ContactMessage> */
class ContactMessageFactory extends Factory
{
    protected $model = ContactMessage::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'subject' => fake()->sentence(5),
            'project_type' => null,
            'message' => fake()->paragraphs(2, true),
            'status' => 'new',
            'internal_notes' => null,
            'read_at' => null,
            'replied_at' => null,
            'closed_at' => null,
        ];
    }
}
