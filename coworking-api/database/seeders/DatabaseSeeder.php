<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserSeeder::class);
        $this->call(PlanSeeder::class);
        $this->call(MemberSeeder::class);
        $this->call(SpaceSeeder::class);
        $this->call(RoomSeeder::class);
        $this->call(AmenitySeeder::class);
        $this->call(AmenityRoomSeeder::class);
        $this->call(BookingSeeder::class);
        $this->call(PaymentSeeder::class);
        $this->call(InvoiceSeeder::class);


        /*User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);*/
    }
}
