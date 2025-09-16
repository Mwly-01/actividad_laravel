<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Crear un inicio entre hoy y 30 días en el futuro
        $startAt = fake()->dateTimeBetween('now', '+30 days');

        // Fin entre 1 y 4 horas después del inicio
        $endAt = (clone $startAt)->modify('+' . fake()->numberBetween(1, 4) . ' hours');

        return [
            'start_at' => $startAt,
            'end_at' => $endAt,
            'status' => 'pending',
            'purpose' => fake()->optional()->sentence(3)
        ];
    }
}
