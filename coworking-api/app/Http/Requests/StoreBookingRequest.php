<?php

namespace App\Http\Requests;

use App\Rules\NoOverlapRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
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
        return [
          'member_id' => ['required','exists:members,id'],
          'room_id'   => ['required','exists:rooms,id'],

          'start_at' => [
            'required',
            'date',
            'after_or_equal:' . now()->format('Y-m-d H:i:s'),
            new NoOverlapRule(),  // Regla para evitar solapamientos (Recorre start_at primero y luego end_at)
          ],

          'end_at'    => ['required','date','after:start_at'],
          'purpose'   => ['nullable','string','max:160'],
      ];
    }

    public function messages(): array {
        return [
          'start_at.after_or_equal' => 'La fecha de inicio debe ser igual o posterior a hoy.',
          'end_at.after' => 'La fecha de fin debe ser posterior a la fecha de inicio.',
          'member_id.exists' => 'El miembro seleccionado no existe.',
          'room_id.exists' => 'La sala seleccionada no existe.',
        ];
    }
}
