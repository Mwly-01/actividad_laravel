<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Member;
use App\Models\Room;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array {
        $start = fake()->dateTimeBetween('+1 day', '+10 days');
        $end   = (clone $start)->modify('+2 hours');
        return [
          'member_id' => Member::factory(),
          'room_id'   => Room::factory(),
          'start_at'  => $start,
          'end_at'    => $end,
          'status'    => 'pending',
        ];
      }
}
