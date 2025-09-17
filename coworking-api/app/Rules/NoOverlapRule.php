<?php

namespace App\Rules;

use App\Models\Booking;
use Illuminate\Contracts\Validation\Rule;
use Carbon\Carbon;

class NoOverlapRule implements Rule
{
    protected $startAt;
    protected $endAt;

    public function __construct()
    {
        $this->startAt = request('start_at');
        $this->endAt = request('end_at');
    }

    /**
     * Verifica si el valor es válido.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // Recupera el ID de la sala y el ID de la reserva (si existe)
        $roomId = request('room_id');
        $bookingId = request('booking_id'); // ID de la reserva a actualizar, si existe

        // Comprobar si las fechas están en el formato correcto
        $startAt = Carbon::parse($this->startAt);
        $endAt = Carbon::parse($this->endAt);

        // Verificar si hay solapamientos en la base de datos para la sala especificada
        $overlap = Booking::where('room_id', $roomId)
            ->where(function ($query) use ($startAt, $endAt) {
                // Verifica si hay solapamientos de tiempo
                $query->whereBetween('start_at', [$startAt, $endAt])
                    ->orWhereBetween('end_at', [$startAt, $endAt])
                    ->orWhere(function ($query) use ($startAt, $endAt) {
                        $query->where('start_at', '<', $endAt)
                            ->where('end_at', '>', $startAt);
                    });
            })
            // Excluir la propia reserva (al actualizar)
            ->where('id', '!=', $bookingId) // Asegura que no se solape con la propia reserva que se está actualizando
            ->exists();

        return !$overlap; // Retorna si no hay solapamiento
    }


    public function message()
    {
        return 'Ya existe una reserva que se solapa con esta.';
    }
}