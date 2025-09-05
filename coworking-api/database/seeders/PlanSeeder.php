<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plan; 

class PlanSeeder extends Seeder
{
    public function run()
    {
        Plan::query()->insert([
            ['name' => 'Basic', 'monthly_hours' => 10, 'guest_passes' => 1, 'price' => 99.00, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Pro', 'monthly_hours' => 30, 'guest_passes' => 3, 'price' => 249.00, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Enterprise', 'monthly_hours' => 100, 'guest_passes' => 10, 'price' => 799.00, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
