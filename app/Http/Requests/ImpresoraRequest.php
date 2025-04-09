<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImpresoraRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'tipo' => 'nullable|string|max:255',
            'ubicacion' => 'nullable|string|max:255',
            'usuario' => 'nullable|string|max:255',
            'ip' => 'nullable|ip',
            'nombre_reserva_dhcp' => 'nullable|string|max:255',
            'observaciones' => 'nullable|string|max:255',
            'nombre_cola_hacos' => 'nullable|string|max:255',
        ];
    }

}
