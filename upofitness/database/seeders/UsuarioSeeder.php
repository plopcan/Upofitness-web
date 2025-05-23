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
            'password' => bcrypt('password'),
            'phone' => '123456789',
            'role_id' => 1,
            'image_id' => 11,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Usuario::create([
            'name' => 'Administrador Ejemplo',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'phone' => '987654321',
            'role_id' => 2,
            'image_id' => 12,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Usuario::create([
            'name' => 'Juan Pérez',
            'email' => 'juan.perez@example.com',
            'password' => bcrypt('password'),
            'phone' => '888888888',
            'role_id' => 1,
            'image_id' => 13,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Usuario::create([
            'name' => 'Ana Martínez',
            'email' => 'ana.martinez@example.com',
            'password' => bcrypt('password'),
            'phone' => '999999999',
            'role_id' => 1,
            'image_id' => 14,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Usuario::create([
            'name' => 'Luis Fernández',
            'email' => 'luis.fernandez@example.com',
            'password' => bcrypt('password'),
            'phone' => '101010101',
            'role_id' => 1,
            'image_id' => 15,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Usuario::create([
            'name' => 'Sofía Gómez',
            'email' => 'sofia.gomez@example.com',
            'password' => bcrypt('password'),
            'phone' => '121212121',
            'role_id' => 1,
            'image_id' => 16,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Usuario::create([
            'name' => 'Diego Torres',
            'email' => 'diego.torres@example.com',
            'password' => bcrypt('password'),
            'phone' => '131313131',
            'role_id' => 1,
            'image_id' => 17,
            'created_at' => now(),
            'updated_at' => now(),
        ]);


        Usuario::create([
            'name' => 'Carlos García',
            'email' => 'carlos.garcia@example.com',
            'password' => bcrypt('password'),
            'phone' => '666666666',
            'role_id' => 1,
            'image_id' => 18,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Usuario::create([
            'name' => 'María López',
            'email' => 'maria.lopez@example.com',
            'password' => bcrypt('password'),
            'phone' => '777777777',
            'role_id' => 1,
            'image_id' => 19,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

    }

}
