<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Booking;
use App\Models\Member;
use App\Models\Room;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $members = Member::all();
        $rooms = Room::all();

        if ($members->isEmpty() || $rooms->isEmpty()) {
            $this->command->warn('No hay miembros o habitaciones para crear reservas.');
            return;
        }

        $count = rand(5, 10);
        $created = 0;

        for ($i = 0; $i < $count; $i++) {
            $startAt = fake()->dateTimeBetween('now', '+30 days');
            $endAt = (clone $startAt)->modify('+' . fake()->numberBetween(1, 4) . ' hours');

            $room = $rooms->random();

            // Verificar que no exista reserva solapada en esta habitación
            $overlapExists = Booking::where('room_id', $room->id)
                ->where(function ($query) use ($startAt, $endAt) {
                    $query->whereBetween('start_at', [$startAt, $endAt])
                          ->orWhereBetween('end_at', [$startAt, $endAt])
                          ->orWhere(function ($query2) use ($startAt, $endAt) {
                              $query2->where('start_at', '<=', $startAt)
                                     ->where('end_at', '>=', $endAt);
                          });
                })->exists();

            if ($overlapExists) {
                // Si hay solapamiento, ignorar esta iteración y continuar

                // Devuelve el intento, logrando realizar los requeridos
                $i--;
                continue;
            }

            Booking::factory()->create([
                'member_id' => $members->random()->id,
                'room_id' => $room->id,
                'start_at' => $startAt,
                'end_at' => $endAt,
            ]);

            $created++;
        }

        $this->command->info("$created reservas creadas correctamente sin solapamientos.");
    }
}