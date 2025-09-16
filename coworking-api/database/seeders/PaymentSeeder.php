<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Booking;
use App\Models\Payment;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bookings = Booking::all();

        if ($bookings->isEmpty()) {
            $this->command->warn('No hay reservas para asociar pagos.');
            return;
        }

        $created = 0;

        foreach ($bookings as $booking) {
            // Solo algunas reservas tendrán pago
            if (fake()->boolean(60)) {
                Payment::factory()->create([
                    'booking_id' => $booking->id,
                ]);
                $created++;
            }
        }
        
        $this->command->info("$created pagos creados para reservas.");
    }
}
