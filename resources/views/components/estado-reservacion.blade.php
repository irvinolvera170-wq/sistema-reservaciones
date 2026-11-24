@props(['estado'])

@php
    $mapa = [
        'activa' => ['success', 'Activa'],
        'cancelada' => ['secondary', 'Cancelada'],
        'finalizada' => ['dark', 'Finalizada'],
    ];
    [$color, $texto] = $mapa[$estado];
@endphp

<span class="badge bg-{{ $color }}">{{ $texto }}</span>