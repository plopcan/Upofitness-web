<?php

namespace Database\Seeders;

use App\Models\Payment;
use App\Models\Order;
use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orders = Order::all();

        if ($orders->isEmpty()) {
            $this->command->error('No hay órdenes para asociar pagos. Asegúrate de ejecutar OrderSeeder primero.');
            return;
        }

        foreach ($orders as $order) {
            $paymentMethods = PaymentMethod::where('user_id', $order->usuario_id)->get();

            if ($paymentMethods->isEmpty()) {
                $this->command->warn("El usuario con ID {$order->usuario_id} no tiene métodos de pago. Se omite la orden ID {$order->id}.");
                continue;
            }

            $selectedPaymentMethod = $paymentMethods->random();


            Payment::create([
                'card_number' => $selectedPaymentMethod->card_number,
                'payment_status' => (bool)rand(0, 1), 
                'orders_id' => $order->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

        
        }
    }
}