<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Room>
 */
class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->words(2, true), // Nombre compuesto (2 palabras unidas)
            'capacity' => fake()->numberBetween(2, 200), // Número aleatorio entre 2 y 200
            'type' => fake()->randomElement(['meeting', 'workshop', 'phonebooth', 'auditorium']), // Tipo aleatorio
            'is_active' => fake()->boolean(90), // Booleano, 90% de probabilidad de ser true
        ];
    }
}
