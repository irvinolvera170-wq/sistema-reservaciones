<?php

namespace App\Http\Requests;

use App\Models\Equipo;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EquipoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->esAdmin() ?? false;
    }

    public function rules(): array
    {
        $equipo = $this->route('equipo');   // null al registrar

        return [
            'nombre' => ['required', 'string', 'max:100',
                Rule::unique('equipos', 'nombre')->ignore($equipo?->id)],
            'ubicacion' => ['required', 'string', 'max:100'],
            'descripcion' => ['nullable', 'string', 'max:500'],
            'estado' => ['required', Rule::in(array_keys(Equipo::ESTADOS))],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'Escribe el nombre del equipo.',
            'nombre.unique' => 'Ya existe un equipo con ese nombre.',
            'nombre.max' => 'El nombre no puede tener más de 100 caracteres.',
            'ubicacion.required' => 'Escribe la ubicación del equipo.',
            'ubicacion.max' => 'La ubicación no puede tener más de 100 caracteres.',
            'descripcion.max' => 'La descripción no puede tener más de 500 caracteres.',
            'estado.required' => 'Selecciona el estado.',
            'estado.in' => 'El estado debe ser Operativo o En mantenimiento.',
        ];
    }
}