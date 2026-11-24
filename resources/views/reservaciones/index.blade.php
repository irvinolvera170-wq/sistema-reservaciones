@extends('layouts.app')

@section('title', 'Reservaciones')

@section('content')
@php $esAdmin = auth()->user()->esAdmin(); @endphp

<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-body">

            <h3 class="mb-3">{{ $esAdmin ? 'Todas las reservaciones' : 'Mis reservaciones' }}</h3>

            <x-mensajes />

            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            @if ($esAdmin) <th>Estudiante</th> @endif
                            <th>Equipo</th>
                            <th>Inicio</th>
                            <th>Termina</th>
                            <th>Estado</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($reservaciones as $r)
                            <tr>
                                @if ($esAdmin) <td>{{ $r->user->name }}</td> @endif
                                <td>{{ $r->equipo->nombre }}</td>
                                <td>{{ $r->inicia_at->format('d/m/Y H:i') }}</td>
                                <td>{{ $r->termina_at->format('d/m/Y H:i') }}</td>
                                <td><x-estado-reservacion :estado="$r->estado_real" /></td>
                                <td class="text-end">
                                    <div class="d-inline-flex gap-1">
                                        <a href="{{ route('reservaciones.show', $r) }}" class="btn btn-sm btn-outline-info">Ver</a>
                                        @if ($r->esActiva())
                                            <form method="POST" action="{{ route('reservaciones.cancel', $r) }}"
                                                  onsubmit="return confirm('¿Cancelar esta reservación?')">
                                                @csrf
                                                @method('PATCH')
                                                <button class="btn btn-sm btn-warning">Cancelar</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ $esAdmin ? 6 : 5 }}" class="text-center text-muted">
                                    No hay reservaciones.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $reservaciones->links() }}
        </div>
    </div>
</div>
@endsection