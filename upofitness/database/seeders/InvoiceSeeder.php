<?php

namespace Database\Seeders;

use App\Models\Invoice;
use App\Models\Order;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orders = Order::all();

        if ($orders->isEmpty()) {
            $this->command->error('No hay órdenes para generar facturas. Asegúrate de ejecutar OrderSeeder primero.');
            return;
        }
        foreach ($orders as $order) {
            Invoice::create([
                'orders_id' => $order->id,
                'issue_date' => Carbon::now()->subDays(rand(1, 30)), 
                'tax_percentage' => 21, 
                'total_amount' => round($order->total * 1.21, 2),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

        }
    }
}