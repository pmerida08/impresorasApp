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
            'tipo' => 'required|string|max:255',
            'ubicacion' => 'required|string|max:255',
            'usuario' => 'required|string|max:255',
            'ip' => 'required|ip',
            'nombre_reserva_dhcp' => 'nullable|string|max:255',
            'observaciones' => 'nullable|string|max:255',
            'nombre_cola_hacos' => 'nullable|string|max:255',
            'sede' => 'required|string|max:255',
            'num_contrato' => 'required|string|max:255',
            'color' => 'required|boolean',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'required' => 'El campo :attribute es obligatorio.',
            'string' => 'El campo :attribute debe ser texto.',
            'max' => 'El campo :attribute no debe ser mayor a :max caracteres.',
            'ip' => 'El campo :attribute debe ser una dirección IP válida.',
            'boolean' => 'El campo :attribute debe ser verdadero o falso.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            'tipo' => 'Tipo',
            'ubicacion' => 'Ubicación',
            'usuario' => 'Usuario',
            'ip' => 'IP',
            'nombre_reserva_dhcp' => 'Nombre Reserva DHCP',
            'observaciones' => 'Observaciones',
            'nombre_cola_hacos' => 'Nombre Cola HACOS',
            'sede' => 'Sede',
            'num_contrato' => 'Número de Contrato',
            'color' => 'Color',
        ];
    }
}
