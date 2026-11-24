<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReservacionRequest;
use App\Models\Equipo;
use App\Models\Reservacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class ReservacionController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $reservaciones = Reservacion::with(['equipo', 'user'])
            // El estudiante solo ve las suyas: el filtro sale de la sesión, no de la URL
            ->when(!$user->esAdmin(), fn ($q) => $q->where('user_id', $user->id))
            ->latest()
            ->orderByDesc('id')
            ->paginate(10);

        return view('reservaciones.index', compact('reservaciones'));
    }

    public function show(Reservacion $reservacion)
    {
        Gate::authorize('view', $reservacion);   // 403 si no es suya y no es admin

        $reservacion->load(['equipo', 'user']);

        return view('reservaciones.show', compact('reservacion'));
    }

    public function store(ReservacionRequest $request, Equipo $equipo)
    {
        $user = $request->user();
        $duracion = (int) $request->validated('duracion');

        try {
            DB::transaction(function () use ($user, $equipo, $duracion) {
                // Bloquea la fila del equipo (SELECT ... FOR UPDATE).
                // Si otro usuario está reservando el mismo equipo, esta petición espera aquí.
                $bloqueado = Equipo::whereKey($equipo->id)->lockForUpdate()->firstOrFail();

                if ($bloqueado->estado !== 'operativo') {
                    throw new \DomainException('Este equipo está en mantenimiento y no se puede reservar.');
                }

                // Con el bloqueo tomado, esta revisión ya ve lo que otro usuario haya confirmado
                if ($bloqueado->reservaciones()->activas()->exists()) {
                    throw new \DomainException('Este equipo ya no está disponible: otro usuario lo reservó.');
                }

                $user->reservaciones()->create([
                    'equipo_id' => $bloqueado->id,
                    'inicia_at' => now(),
                    'termina_at' => now()->addHours($duracion),
                    'estado' => 'activa',
                ]);
            });
        } catch (\DomainException $e) {
            return redirect()->route('equipos.index')->withErrors(['equipo' => $e->getMessage()]);
        }

        return redirect()->route('reservaciones.index')
            ->with('status', "Reservaste {$equipo->nombre} por {$duracion} hora(s).");
    }

    public function cancel(Reservacion $reservacion)
    {
        Gate::authorize('cancel', $reservacion);   // solo el dueño o un administrador

        if (!$reservacion->esActiva()) {
            return back()->withErrors(['reservacion' => 'Solo se pueden cancelar reservaciones activas.']);
        }

        $reservacion->update(['estado' => 'cancelada']);

        return back()->with('status', 'Reservación cancelada correctamente.');
    }
}