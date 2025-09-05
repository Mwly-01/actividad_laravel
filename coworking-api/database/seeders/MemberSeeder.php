<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Member;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
        public function run()
        {
            // Crea 10–20 miembros para cada plan
            Member::factory(rand(10, 20))->create();
        }
    }
