<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Room;
use App\Models\Space;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        // Obtener todos los spaces existentes
        $spaces = Space::all();

        if ($spaces->isEmpty()) {
            $this->command->warn('No se encontraron spaces. Se omite la creación de rooms.');
            return;
        }

        // Para cada espacio, crear entre 3 y 5 habitaciones
        $spaces->each(function ($space) {
            $roomsCount = rand(3, 5);
            Room::factory()
                ->count($roomsCount)
                ->create([
                    'space_id' => $space->id,
                ]);

            $this->command->info("Se crearon" . $roomsCount . "rooms para el space con ID" . $space->id);
        });

        $this->command->info('Se han creado todas las rooms asociadas a sus spaces correctamente.');
    }
}