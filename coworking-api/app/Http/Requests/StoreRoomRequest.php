<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoomRequest extends FormRequest
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
          'space_id'  => ['required','exists:spaces,id'],
          'name'      => ['required','string','min:3','max:120','unique:rooms,name'],
          'capacity'  => ['required','integer','min:1','max:200'],
          'type'      => ['required','in:meeting,workshop,phonebooth,auditorium'],
          'is_active' => ['boolean'],
        ];
      }
}
