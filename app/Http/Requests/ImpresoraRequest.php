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
            'ubicacion' => 'nullable|string|max:255',
            'usuario' => 'nullable|string|max:255',
            'ip' => 'required|ip',
            'organismo' => 'required|string|max:255',
            'nombre_reserva_dhcp' => 'nullable|string|max:255',
            'descripcion' => 'nullable|string|max:255',
            'nombre_cola_hacos' => 'nullable|string|max:255',
            'sede_rcja' => 'required|string|max:255',
            'contrato' => 'required|string|max:255',
            'num_serie' => 'required|string|max:24',
            'color' => 'required|int|max:1',
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
            'ip' => 'IP',
            'sede_rcja' => 'Sede RCJA',
            'tipo' => 'Tipo',
            'contrato' => 'Contrato',
            'organismo' => 'Organismo',
            'descripcion' => 'Descripcion',
            'ubicacion' => 'Ubicación',
            'usuario' => 'Usuario',
            'nombre_reserva_dhcp' => 'Nombre Reserva DHCP',
            'nombre_cola_hacos' => 'Nombre Cola HACOS',
            'num_serie' => 'Número de serie',
            'color' => 'Color',
        ];
    }
}
