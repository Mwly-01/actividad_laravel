<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Plan;
use App\Models\Member;

class MemberSeeder extends Seeder
{
    public function run(): void
    {
        $plans = Plan::all();
        $users = User::all();

        if ($plans->isEmpty() || $users->isEmpty()) {
            $this->command->warn('No se encontraron planes o usuarios. Se omite la creación de Members.');
            return;
        }

        $count = rand(5, 10);

        // Tomar usuarios al azar para crear los members (sin repetir usuario)
        $selectedUsers = $users->shuffle()->take($count);

        foreach ($selectedUsers as $user) {
            Member::factory()->create([
                'user_id' => $user->id,
                'plan_id' => $plans->random()->id,
            ]);
        }

        $this->command->info("Se han creado" . $selectedUsers->count() . "Members correctamente");
    }
}