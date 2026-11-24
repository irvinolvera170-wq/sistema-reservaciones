@extends('layouts.app')

@section('title', 'Equipos')

@section('content')
@php $esAdmin = auth()->user()->esAdmin(); @endphp

<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="mb-0">{{ $esAdmin ? 'Equipos de cómputo' : 'Equipos disponibles' }}</h3>
                @if ($esAdmin)
                    <a href="{{ route('equipos.create') }}" class="btn btn-primary btn-sm">+ Nuevo equipo</a>
                @endif
            </div>

            <x-mensajes />

            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>Equipo</th>
                            <th>Ubicación</th>
                            <th>Descripción</th>
                            <th>Estado</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($equipos as $e)
                            <tr>
                                <td>{{ $e->nombre }}</td>
                                <td>{{ $e->ubicacion }}</td>
                                <td>{{ str($e->descripcion)->limit(60) }}</td>
                                <td><x-estado-equipo :equipo="$e" /></td>
                                <td class="text-end">
                                    @if ($esAdmin)
                                        <div class="d-inline-flex gap-1">
                                            <a href="{{ route('equipos.edit', $e) }}" class="btn btn-sm btn-outline-primary">Editar</a>
                                            <form method="POST" action="{{ route('equipos.destroy', $e) }}"
                                                  onsubmit="return confirm('¿Eliminar este equipo? Esta acción no se puede deshacer.')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger">Eliminar</button>
                                            </form>
                                        </div>
                                    @elseif (!$e->ocupado)
                                        <form method="POST" action="{{ route('reservaciones.store', $e) }}"
                                              class="d-inline-flex gap-1">
                                            @csrf
                                            <select name="duracion" class="form-select form-select-sm" style="width: auto;">
                                                <option value="1">1 hora</option>
                                                <option value="2">2 horas</option>
                                                <option value="3">3 horas</option>
                                            </select>
                                            <button class="btn btn-sm btn-success">Reservar</button>
                                        </form>
                                    @else
                                        <span class="text-muted small">No disponible</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center text-muted">No hay equipos registrados.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $equipos->links() }}
        </div>
    </div>
</div>
@endsection