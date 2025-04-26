<?php

namespace Database\Seeders;

use App\Models\Wishlist;
use App\Models\Usuario;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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

        $wishlists = Wishlist::all();
        $products = \App\Models\Product::all();

        if ($products->isEmpty()) {
            $this->command->error('No hay productos para añadir a las listas de deseos. Asegúrate de ejecutar ProductSeeder primero.');
            return;
        }

        foreach ($wishlists as $wishlist) {
            $randomProducts = $products->random(rand(1, 5));
            
            foreach ($randomProducts as $product) {
                DB::table('wishlist_product')->insert([
                    'wishlist_id' => $wishlist->id,
                    'product_id' => $product->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

    }
}