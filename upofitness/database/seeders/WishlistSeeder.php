<?php

namespace Database\Seeders;

use App\Models\Wishlist;
use App\Models\Usuario;
use Illuminate\Database\Seeder;

class WishlistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $usuarios = Usuario::all();

        if ($usuarios->isEmpty()) {
            $this->command->error('No hay usuarios para crear listas de deseos. Asegúrate de ejecutar UsuarioSeeder primero.');
            return;
        }

        foreach ($usuarios as $usuario) {
            Wishlist::create([
                'usuario_id' => $usuario->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);


        }
    }
}