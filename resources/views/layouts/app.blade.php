<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Reservación de equipos')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    @auth
        <nav class="navbar navbar-expand navbar-dark bg-primary">
            <div class="container">
                <span class="navbar-brand">Reservación de equipos</span>

                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('equipos.index') }}">Equipos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('reservaciones.index') }}">
                            {{ auth()->user()->esAdmin() ? 'Todas las reservaciones' : 'Mis reservaciones' }}
                        </a>
                    </li>
                </ul>

                <div class="d-flex align-items-center gap-3 text-white">
                    <span>
                        {{ auth()->user()->name }}
                        <span class="badge bg-light text-primary">{{ auth()->user()->role }}</span>
                    </span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-outline-light btn-sm">Cerrar sesión</button>
                    </form>
                </div>
            </div>
        </nav>
    @endauth

    @yield('content')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>