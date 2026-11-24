<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReservacionRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Solo un estudiante puede reservar
        return $this->user()?->esEstudiante() ?? false;
    }

    public function rules(): array
    {
        return [
            'duracion' => ['required', 'integer', 'in:1,2,3'],
        ];
    }

    public function messages(): array
    {
        return [
            'duracion.required' => 'Selecciona la duración de la reservación.',
            'duracion.integer' => 'La duración no es válida.',
            'duracion.in' => 'La duración debe ser de 1, 2 o 3 horas.',
        ];
    }
}