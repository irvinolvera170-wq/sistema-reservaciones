@extends('layouts.app')

@section('title', 'Editar equipo')

@section('content')
<div class="container py-5 d-flex justify-content-center">
    <div class="card shadow-sm w-100" style="max-width: 480px;">
        <div class="card-body p-4">
            <h3 class="mb-4">Editar equipo</h3>

            <form method="POST" action="{{ route('equipos.update', $equipo) }}" novalidate>
                @csrf
                @method('PUT')
                @include('equipos._form')
                <button type="submit" class="btn btn-primary w-100">Guardar cambios</button>
            </form>

            <a href="{{ route('equipos.index') }}" class="d-block text-center mt-3">← Volver a equipos</a>
        </div>
    </div>
</div>
@endsection