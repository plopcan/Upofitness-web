<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Usuario;
use App\Models\Product;
use App\Models\PromotionCode;
use App\Models\Address;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $usuarios = Usuario::all();
        $productos = Product::all();
        $promotionCodes = PromotionCode::all();

        if ($usuarios->isEmpty() || $productos->isEmpty()) {
            $this->command->error('No hay usuarios o productos para crear órdenes. Asegúrate de ejecutar UsuarioSeeder, ProductSeeder y AddressSeeder primero.');
            return;
        }

        // Crear órdenes ficticias
        foreach ($usuarios as $usuario) {
            $addresses = Address::where('usuario_id', $usuario->id)->get();

            if ($addresses->isEmpty()) {
                $this->command->warn("El usuario con ID {$usuario->id} no tiene direcciones. Se omiten sus órdenes.");
                continue;
            }

            $numOrders = rand(1, 3); // Cada usuario tendrá entre 1 y 3 órdenes

            for ($i = 0; $i < $numOrders; $i++) {
                $producto = $productos->random();
                $quantity = rand(1, 5); // Cantidad aleatoria entre 1 y 5
                $total = $producto->price * $quantity;

                // Aplicar un código promocional aleatorio en algunas órdenes
                $promotionCodeId = null;
                if ($promotionCodes->isNotEmpty() && rand(0, 1)) {
                    $promotionCode = $promotionCodes->random();
                    $promotionCodeId = $promotionCode->id;
                    $total = $total * (1 - ($promotionCode->percentage / 100)); // Aplicar descuento
                }

                // Seleccionar una dirección aleatoria del usuario
                $address = $addresses->random();
                $fullAddress = "{$address->address}, {$address->city}, {$address->postal_code}, {$address->country}";

                Order::create([
                    'full_address' => $fullAddress,
                    'total' => round($total, 2), // Redondear el total a 2 decimales
                    'status' => ['pendiente', 'en camino', 'entregado'][rand(0, 2)], // Estado aleatorio
                    'purchase_date' => Carbon::now()->subDays(rand(1, 30)), // Fecha aleatoria en los últimos 30 días
                    'quantity' => $quantity,
                    'promotion_code_id' => $promotionCodeId,
                    'product_id' => $producto->id,
                    'usuario_id' => $usuario->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        $this->command->info('Se han creado órdenes ficticias para los usuarios existentes.');
    }
}