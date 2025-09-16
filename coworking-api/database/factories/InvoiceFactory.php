<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Genera un número único de factura con formato tipo "INV-123AB456"
            'number' => strtoupper('INV-' . fake()->unique()->bothify('###??###')), // Genera un string con números (#) y letras (?) al azar
            'issued_date' => fake()->date(), 
            'meta' => [
                'razon_social' => fake()->company(),
                'direccion' => fake()->address(),
            ],
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
