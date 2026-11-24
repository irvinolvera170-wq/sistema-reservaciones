<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['user_id', 'equipo_id', 'inicia_at', 'termina_at', 'estado'])]
class Reservacion extends Model
{
    // Laravel pluralizaría "reservacions"; se indica el nombre real de la tabla
    protected $table = 'reservaciones';

    protected function casts(): array
    {
        return [
            'inicia_at' => 'datetime',
            'termina_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function equipo(): BelongsTo
    {
        return $this->belongsTo(Equipo::class);
    }

    // Activa = no cancelada y todavía vigente
    public function scopeActivas(Builder $query): Builder
    {
        return $query->where('estado', 'activa')->where('termina_at', '>', now());
    }

    public function esActiva(): bool
    {
        return $this->estado === 'activa' && $this->termina_at->isFuture();
    }

    // Estado que se muestra: activa, cancelada o finalizada (venció la hora)
    protected function estadoReal(): Attribute
    {
        return Attribute::get(fn () => match (true) {
            $this->estado === 'cancelada' => 'cancelada',
            $this->termina_at->isPast() => 'finalizada',
            default => 'activa',
        });
    }
}