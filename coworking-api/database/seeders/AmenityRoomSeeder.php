<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Room;
use App\Models\Amenity;

class AmenityRoomSeeder extends Seeder
{
    public function run(): void
    {
        $rooms = Room::all();
        $amenities = Amenity::all();

        if ($rooms->isEmpty() || $amenities->isEmpty()) {
            $this->command->warn('No hay rooms o amenities para asignar.');
            return;
        }

        foreach ($rooms as $room) {
            // Asignar entre 1 y 3 amenities aleatorios a cada room
            $randomAmenities = $amenities->random(rand(1, 3))->pluck('id')->toArray();

            $room->amenities()->syncWithoutDetaching($randomAmenities);
        }

        $this->command->info("Amenidades asignadas a todas las rooms correctamente.");
    }
}
