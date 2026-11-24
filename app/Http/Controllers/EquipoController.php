<?php

namespace App\Http\Controllers;

use App\Http\Requests\EquipoRequest;
use App\Models\Equipo;
use Illuminate\Http\Request;

class EquipoController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $equipos = Equipo::query()
            // "ocupado" se calcula con una subconsulta: sin consultas extra por fila
            ->withExists(['reservaciones as ocupado' => fn ($q) => $q->activas()])
            // El estudiante solo ve los equipos operativos
            ->when(!$user->esAdmin(), fn ($q) => $q->where('estado', 'operativo'))
            ->orderBy('nombre')
            ->paginate(10);

        return view('equipos.index', compact('equipos'));
    }

    public function create()
    {
        return view('equipos.create');
    }

    public function store(EquipoRequest $request)
    {
        Equipo::create($request->validated());

        return redirect()->route('equipos.index')
            ->with('status', 'Equipo registrado correctamente.');
    }

    public function edit(Equipo $equipo)
    {
        return view('equipos.edit', compact('equipo'));
    }

    public function update(EquipoRequest $request, Equipo $equipo)
    {
        $equipo->update($request->validated());

        return redirect()->route('equipos.index')
            ->with('status', 'Equipo actualizado correctamente.');
    }

    public function destroy(Equipo $equipo)
    {
        if ($equipo->reservaciones()->activas()->exists()) {
            return back()->withErrors(['equipo' => 'No puedes eliminar un equipo con una reservación activa.']);
        }

        $equipo->delete();   // sus reservaciones pasadas se borran por la llave foránea (cascade)

        return redirect()->route('equipos.index')
            ->with('status', 'Equipo eliminado correctamente.');
    }
}