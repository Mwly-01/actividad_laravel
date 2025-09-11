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
     * Ejercutar el seeder de reserva y pagos 
     */
    public function run(): void{
        //vamos a obtener todas la habitaciones y usuarios de la base de datos
        $rooms=Room::all();
        $users=User::all();
    

    //pero si no existe niguno de estos no podemos continuar y se mostrara una alerta

    if ($rooms->isEmpty() || $users->isEmpty()) {
        $this->command->warn('Rooms or Users are empty. Skipping BookingPaymentSeeder.');
        return;
    }
    //se define el numero de reservas que se van a crear
    $bookingsToCreate= 50 ;

    // numero maximo de intentos para evitar solpamientos por reserva 

    $maxAttemptsPerBooking=10;
    //
} }
;