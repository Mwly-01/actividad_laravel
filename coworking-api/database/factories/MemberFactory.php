<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Plan;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Member>
 */
class MemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Datos con probabilidad de ser nulos
            'company' => fake()->optional(30)->company(),
            'joined_at' => fake()->optional(30)->dateTimeBetween('-1 year', 'now')
        ];
    }
}
