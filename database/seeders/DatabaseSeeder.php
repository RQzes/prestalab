<?php

namespace Database\Seeders;

use App\Models\Equipo;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $usuarios = [
            ['Encargado del Laboratorio', 'encargado@lab.com', User::ENCARGADO],
            ['Ana Pérez', 'ana@lab.com', User::ESTUDIANTE],
            ['Luis Gómez', 'luis@lab.com', User::ESTUDIANTE],
        ];

        foreach ($usuarios as [$nombre, $correo, $rol]) {
            User::create([
                'name' => $nombre,
                'email' => $correo,
                'password' => Hash::make('password'),
                'rol' => $rol,
            ]);
        }

        $equipos = [
            ['LAP-001', 'Laptop Dell Inspiron', 'Laptops'],
            ['LAP-002', 'Laptop HP ProBook', 'Laptops'],
            ['PRO-001', 'Proyector Epson X05', 'Proyectores'],
            ['PRO-002', 'Proyector BenQ MS550', 'Proyectores'],
            ['ARD-001', 'Kit Arduino Uno', 'Arduino'],
            ['ARD-002', 'Kit Arduino Mega', 'Arduino'],
            ['MUL-001', 'Multímetro Fluke 117', 'Medición'],
            ['MUL-002', 'Multímetro Uni-T UT33', 'Medición'],
        ];

        foreach ($equipos as [$codigo, $nombre, $categoria]) {
            Equipo::create([
                'codigo' => $codigo,
                'nombre' => $nombre,
                'categoria' => $categoria,
                'estado' => Equipo::DISPONIBLE,
            ]);
        }
    }
}
