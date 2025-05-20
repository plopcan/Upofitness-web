<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Order;
use App\Models\Usuario;
use App\Models\Product;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_order_can_be_created()
    {
        $order = Order::factory()->create();
        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => $order->status,
        ]);
    }

    public function test_order_belongs_to_usuario()
    {
        $order = Order::factory()->create();
        $this->assertInstanceOf(Usuario::class, $order->usuario);
        $this->assertEquals($order->usuario_id, $order->usuario->id);
    }

    public function test_order_belongs_to_product()
    {
        $order = Order::factory()->create();
        $this->assertInstanceOf(Product::class, $order->product);
        $this->assertEquals($order->product_id, $order->product->id);
    }
}
