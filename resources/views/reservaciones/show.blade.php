@extends('layouts.app')

@section('title', 'Detalle de reservación')

@section('content')
<div class="container py-5 d-flex justify-content-center">
    <div class="card shadow-sm w-100" style="max-width: 480px;">
        <div class="card-body p-4">
            <h3 class="mb-4">Reservación #{{ $reservacion->id }}</h3>

            <dl class="row mb-4">
                <dt class="col-sm-4">Estudiante</dt>
                <dd class="col-sm-8">{{ $reservacion->user->name }}</dd>

                <dt class="col-sm-4">Equipo</dt>
                <dd class="col-sm-8">{{ $reservacion->equipo->nombre }}</dd>

                <dt class="col-sm-4">Ubicación</dt>
                <dd class="col-sm-8">{{ $reservacion->equipo->ubicacion }}</dd>

                <dt class="col-sm-4">Inicio</dt>
                <dd class="col-sm-8">{{ $reservacion->inicia_at->format('d/m/Y H:i') }}</dd>

                <dt class="col-sm-4">Termina</dt>
                <dd class="col-sm-8">{{ $reservacion->termina_at->format('d/m/Y H:i') }}</dd>

                <dt class="col-sm-4">Estado</dt>
                <dd class="col-sm-8"><x-estado-reservacion :estado="$reservacion->estado_real" /></dd>
            </dl>

            <a href="{{ route('reservaciones.index') }}" class="btn btn-outline-secondary">← Volver</a>
        </div>
    </div>
</div>
@endsection