<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Space;
use App\Models\Room;
use App\Models\Amenity;


class SpaceRoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
            // Creamos 2–3 espacios para cada espacio
    Space::factory(rand(2, 3))->create()->each(function ($space) {
        // Cada espacio tiene 3–5 salas para reuniones
        Room::factory(rand(3, 5))->create([
            'space_id' => $space->id
        ])->each(function ($room) {
            $amenities = Amenity::inRandomOrder()->take(rand(1, 3))->pluck('id');
            $room->amenities()->attach($amenities);
        });
    });
    }
}
