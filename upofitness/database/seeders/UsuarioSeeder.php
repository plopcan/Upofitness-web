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
    }
}