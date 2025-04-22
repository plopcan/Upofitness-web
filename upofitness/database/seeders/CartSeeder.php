<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Usuario;
use Illuminate\Database\Seeder;

class CartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $usuarios = Usuario::all();
        $productos = Product::all();

        if ($usuarios->isEmpty() || $productos->isEmpty()) {
            $this->command->error('No hay usuarios o productos para poblar los carritos. Asegúrate de ejecutar UsuarioSeeder y ProductSeeder primero.');
            return;
        }

        foreach ($usuarios as $usuario) {
            $cart = Cart::create([
                'usuario_id' => $usuario->id,
            ]);

            $productosSeleccionados = $productos->random(rand(1, 5)); 
            foreach ($productosSeleccionados as $producto) {
                $cart->products()->attach($producto->id, [
                    'quantity' => rand(1, 3), 
                ]);
            }
        }
    }
}