@extends('layouts.app')

@section('title', 'Registrar equipo')

@section('content')
<div class="container py-5 d-flex justify-content-center">
    <div class="card shadow-sm w-100" style="max-width: 480px;">
        <div class="card-body p-4">
            <h3 class="mb-4">Registrar equipo</h3>

            <form method="POST" action="{{ route('equipos.store') }}" novalidate>
                @csrf
                @include('equipos._form')
                <button type="submit" class="btn btn-primary w-100">Registrar</button>
            </form>

            <a href="{{ route('equipos.index') }}" class="d-block text-center mt-3">← Volver a equipos</a>
        </div>
    </div>
</div>
@endsection