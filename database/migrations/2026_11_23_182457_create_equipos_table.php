<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('equipos', function (Blueprint $table) {
        $table->id();
        $table->string('nombre', 100)->unique();
        $table->string('ubicacion', 100);
        $table->text('descripcion')->nullable();
        $table->string('estado')->default('operativo');
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('equipos');
}
};
