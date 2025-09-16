<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'method' => fake()->randomElement(['card', 'cash', 'transfer']),
            'amount' => fake()->randomFloat(2, 100000, 500000), // Monto entre $100.000 y $500.000
            'status' => fake()->randomElement(['pending', 'paid', 'failed'])
        ];
    }
}
