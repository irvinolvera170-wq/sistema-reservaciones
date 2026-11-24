<?php

namespace Database\Seeders;

use App\Models\Equipo;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@test.com',
            'password' => 'password',   // el cast "hashed" del modelo la cifra
            'role' => 'admin',
        ]);

        foreach ([1 => 'Ana López', 2 => 'Luis Pérez', 3 => 'María Gómez'] as $n => $nombre) {
            User::create([
                'name' => $nombre,
                'email' => "estudiante{$n}@test.com",
                'password' => 'password',
                'role' => 'estudiante',
            ]);
        }

        for ($i = 1; $i <= 8; $i++) {
            Equipo::create([
                'nombre' => sprintf('PC-%02d', $i),
                'ubicacion' => $i <= 4 ? 'Laboratorio A' : 'Laboratorio B',
                'descripcion' => 'Intel Core i5, 16 GB de RAM, SSD de 512 GB.',
                'estado' => $i === 8 ? 'mantenimiento' : 'operativo',
            ]);
        }
    }
}