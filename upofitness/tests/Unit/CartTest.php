<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Cart;
use App\Models\Usuario;
use App\Models\Product;

class CartTest extends TestCase
{
    use RefreshDatabase;

    public function test_cart_can_be_created()
    {
        $cart = Cart::factory()->create();
        $this->assertDatabaseHas('carts', [
            'id' => $cart->id,
            'usuario_id' => $cart->usuario_id,
        ]);
    }

    public function test_cart_belongs_to_usuario()
    {
        $cart = Cart::factory()->create();
        $this->assertInstanceOf(Usuario::class, $cart->usuario);
    }

    public function test_cart_can_have_products()
    {
        $cart = Cart::factory()->create();
        $product = Product::factory()->create();
        $cart->products()->attach($product->id, ['quantity' => 2]);
        $this->assertTrue($cart->products->contains($product));
    }
}
