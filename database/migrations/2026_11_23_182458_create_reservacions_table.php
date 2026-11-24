<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('reservaciones', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->cascadeOnDelete();
        $table->foreignId('equipo_id')->constrained()->cascadeOnDelete();
        $table->timestamp('inicia_at');
        $table->timestamp('termina_at');
        $table->string('estado')->default('activa');
        $table->timestamps();

        // Acelera la pregunta "¿este equipo tiene una reservación activa?"
        $table->index(['equipo_id', 'estado', 'termina_at']);
    });
}

public function down(): void
{
    Schema::dropIfExists('reservaciones');
}
};
