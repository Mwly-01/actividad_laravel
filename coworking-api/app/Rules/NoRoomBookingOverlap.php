<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class NoRoomBookingOverlap implements Rule
{
    protected $roomId;
    protected $startAt;
    protected $endAt;

    public function __construct($roomId, $startAt, $endAt)
    {
        $this->roomId = $roomId;
        $this->startAt = $startAt;
        $this->endAt = $endAt;
    }

    public function passes($attribute, $value)
    {
        // Comprobamos si ya existen reservas solapadas
        $overlap = DB::table('room_bookings') 
            ->where('room_id', $this->roomId)
            ->where(function($query) {
                $query->whereBetween('start_at', [$this->startAt, $this->endAt])
                      ->orWhereBetween('end_at', [$this->startAt, $this->endAt])
                      ->orWhere(function($query) {
                          $query->where('start_at', '<=', $this->startAt)
                                ->where('end_at', '>=', $this->endAt);
                      });
            })
            ->exists();

        return !$overlap;
    }

    public function message()
    {
        return 'La sala ya está reservada para las fechas seleccionadas.';
    }
}
