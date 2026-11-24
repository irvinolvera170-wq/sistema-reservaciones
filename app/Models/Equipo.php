<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['nombre', 'ubicacion', 'descripcion', 'estado'])]
class Equipo extends Model
{
    public const ESTADOS = [
        'operativo' => 'Operativo',
        'mantenimiento' => 'En mantenimiento',
    ];

    public function reservaciones(): HasMany
    {
        return $this->hasMany(Reservacion::class);
    }
}