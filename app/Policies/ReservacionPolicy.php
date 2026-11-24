<?php

namespace App\Policies;

use App\Models\Reservacion;
use App\Models\User;

class ReservacionPolicy
{
    // Ver el detalle: el dueño o un administrador
    public function view(User $user, Reservacion $reservacion): bool
    {
        return $user->esAdmin() || $reservacion->user_id === $user->id;
    }

    // Cancelar: el dueño o un administrador
    public function cancel(User $user, Reservacion $reservacion): bool
    {
        return $user->esAdmin() || $reservacion->user_id === $user->id;
    }
}