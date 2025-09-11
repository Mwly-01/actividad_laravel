<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Support\Carbon;

class BookingPaymentSeeder extends Seeder
{
    /**
     * Ejecuta el seeder de reservas y pagos.
     */
    public function run(): void
    {
        // Obtenemos todas las habitaciones y usuarios existentes
        $rooms = Room::all();
        $users = User::all();

        // Si no hay habitaciones o usuarios, mostramos advertencia y salimos
        if ($rooms->isEmpty() || $users->isEmpty()) {
            $this->command->warn('Rooms or Users are empty. Skipping BookingPaymentSeeder.');
            return;
        }

        // Definimos cuántas reservas queremos crear
        $bookingsToCreate = 50;

        // Número máximo de intentos para evitar solapamientos por reserva
        $maxAttemptsPerBooking = 20;

        // Lista donde almacenaremos las reservas creadas
        $bookings = [];

        // Creamos reservas en un bucle
        foreach (range(1, $bookingsToCreate) as $_) {
            // Seleccionamos aleatoriamente una habitación y un usuario
            $room = $rooms->random();
            $user = $users->random();

            $attempts = 0;

            // Intentamos generar una reserva sin solapamiento
            do {
                // Generamos fechas aleatorias de inicio y fin (1 a 5 días)
                $start = Carbon::today()->addDays(rand(0, 60));
                $end = (clone $start)->addDays(rand(1, 5));

                // Verificamos si hay reservas existentes en la misma habitación y fechas
                $overlapping = Booking::where('room_id', $room->id)
                    ->where(function ($query) use ($start, $end) {
                        $query->whereBetween('start_date', [$start, $end]) // Inicio entre otra reserva
                              ->orWhereBetween('end_date', [$start, $end])   // Fin entre otra reserva
                              ->orWhere(function ($q) use ($start, $end) {
                                  $q->where('start_date', '<=', $start)
                                    ->where('end_date', '>=', $end);         // Otra reserva envuelve a la actual
                              });
                    })
                    ->exists(); // ¿Existe alguna reserva en conflicto?

                $attempts++; // Contamos los intentos

                // Si no hay solapamiento, creamos la reserva
                if (!$overlapping) {
                    $booking = Booking::create([
                        'room_id' => $room->id,
                        'user_id' => $user->id,
                        'start_date' => $start,
                        'end_date' => $end,
                    ]);

                    // Guardamos la reserva creada en el array
                    $bookings[] = $booking;

                    // Aleatoriamente, generamos un pago (50% de probabilidad)
                    if (rand(0, 1)) {
                        Payment::create([
                            'booking_id' => $booking->id,
                            'amount' => rand(100, 500), // Monto aleatorio
                            'payment_date' => Carbon::now()->subDays(rand(0, 10)), // Fecha de pago reciente
                            'method' => collect(['credit_card', 'paypal', 'cash'])->random(), // Método aleatorio
                        ]);
                    }

                    // Salimos del bucle si la reserva fue válida
                    break;
                }

                // Si se alcanzan muchos intentos y no se logra reservar sin solapamiento, se omite

            } while ($attempts < $maxAttemptsPerBooking);
        }

        // Mensaje al final indicando cuántas reservas se crearon
        $this->command->info(count($bookings) . " bookings creados, con algunos pagos.");
    }
}
