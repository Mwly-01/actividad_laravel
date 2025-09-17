<?php

namespace App\Http\Requests;

use App\Models\Booking;
use App\Rules\NoOverlapRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateBookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array {
        $routeBooking = $this->route('booking');
        $bookingId = $routeBooking instanceof Booking ? $routeBooking->id : null; 
    
        return [
            'member_id' => ['required','exists:members,id'],
            'room_id'   => ['required','exists:rooms,id'],
    
            'start_at' => [
                'required',
                'date',
                'after_or_equal:' . now()->format('Y-m-d H:i:s'),
                new NoOverlapRule(),  // Regla para evitar solapamientos
            ],
    
            'end_at'    => ['required','date','after:start_at'],
        ];
    }
    
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Agregar el ID de la reserva a las reglas de validación
            $validator->addRules(['booking_id' => 'required|integer']);
            $this->merge(['booking_id' => $this->route('booking')->id]);  // Asigna el ID de la reserva
        });
    }
}
