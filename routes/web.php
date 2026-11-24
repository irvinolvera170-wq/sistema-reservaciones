<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\ReservacionController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:10,1');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::redirect('/home', '/equipos')->name('home');

    // Administrador y estudiante
    Route::middleware('role:admin,estudiante')->group(function () {
        Route::get('/equipos', [EquipoController::class, 'index'])->name('equipos.index');

        Route::prefix('reservaciones')->name('reservaciones.')
            ->where(['reservacion' => '[0-9]+'])
            ->group(function () {
                Route::get('/', [ReservacionController::class, 'index'])->name('index');
                Route::get('/{reservacion}', [ReservacionController::class, 'show'])->name('show');
                Route::patch('/{reservacion}/cancelar', [ReservacionController::class, 'cancel'])->name('cancel');
            });
    });

    // Solo estudiante: reservar
    Route::post('/equipos/{equipo}/reservar', [ReservacionController::class, 'store'])
        ->whereNumber('equipo')
        ->middleware(['role:estudiante', 'throttle:20,1'])
        ->name('reservaciones.store');

    // Solo administrador: gestión de equipos
    Route::middleware('role:admin')
        ->prefix('equipos')->name('equipos.')
        ->where(['equipo' => '[0-9]+'])
        ->group(function () {
            Route::get('/crear', [EquipoController::class, 'create'])->name('create');
            Route::post('/', [EquipoController::class, 'store'])->name('store');
            Route::get('/{equipo}/editar', [EquipoController::class, 'edit'])->name('edit');
            Route::put('/{equipo}', [EquipoController::class, 'update'])->name('update');
            Route::delete('/{equipo}', [EquipoController::class, 'destroy'])->name('destroy');
        });
});