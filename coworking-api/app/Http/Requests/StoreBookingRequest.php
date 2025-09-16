<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
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
          'start_at'  => ['required','date','after_or_equal:now'],
          'end_at'    => ['required','date','after:start_at'],
          'purpose'   => ['nullable','string','max:160'],
        ];
      }
}
