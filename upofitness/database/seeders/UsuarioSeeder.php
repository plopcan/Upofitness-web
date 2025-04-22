<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Usuario;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Usuario::create([
            'name' => 'Usuario Ejemplo',
            'email' => 'usuario@example.com',
            'password' => 'password', 
            'phone' => '123456789',
            'role_id' => 1, 
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Usuario::create([
            'name' => 'Administrador Ejemplo',
            'email' => 'admin@example.com',
            'password' => 'password', 
            'phone' => '987654321',
            'role_id' => 2, 
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Usuario::create([
            'name' => 'Juan Pérez',
            'email' => 'juan.perez@example.com',
            'password' => 'password',
            'phone' => '888888888',
            'role_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Usuario::create([
            'name' => 'Ana Martínez',
            'email' => 'ana.martinez@example.com',
            'password' => 'password',
            'phone' => '999999999',
            'role_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Usuario::create([
            'name' => 'Luis Fernández',
            'email' => 'luis.fernandez@example.com',
            'password' => 'password',
            'phone' => '101010101',
            'role_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Usuario::create([
            'name' => 'Sofía Gómez',
            'email' => 'sofia.gomez@example.com',
            'password' => 'password',
            'phone' => '121212121',
            'role_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Usuario::create([
            'name' => 'Diego Torres',
            'email' => 'diego.torres@example.com',
            'password' => 'password',
            'phone' => '131313131',
            'role_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
            
    
Usuario::create([
    'name' => 'Carlos García',
    'email' => 'carlos.garcia@example.com',
    'password' => 'password',
    'phone' => '666666666',
    'role_id' => 1,
    'created_at' => now(),
    'updated_at' => now(),
]);

Usuario::create([
    'name' => 'María López',
    'email' => 'maria.lopez@example.com',
    'password' => 'password',
    'phone' => '777777777',
    'role_id' => 1,
    'created_at' => now(),
    'updated_at' => now(),
]);

        }
    }