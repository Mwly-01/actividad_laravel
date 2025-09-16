<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Amenity;

class AmenitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        collect(['projector','whiteboard','tv','conference_speaker','coffee_machine'])
        ->each(fn($n)=> Amenity::create(['name'=>$n]));
    }
}
