<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Wishlist;
use App\Models\Usuario;
use App\Models\Product;

class WishlistTest extends TestCase
{
    use RefreshDatabase;

    public function test_wishlist_can_be_created()
    {
        $wishlist = Wishlist::factory()->create();
        $this->assertDatabaseHas('wishlists', [
            'id' => $wishlist->id,
            'usuario_id' => $wishlist->usuario_id,
        ]);
    }

    public function test_wishlist_belongs_to_usuario()
    {
        $wishlist = Wishlist::factory()->create();
        $this->assertInstanceOf(Usuario::class, $wishlist->usuario);
    }

    public function test_wishlist_can_have_products()
    {
        $wishlist = Wishlist::factory()->create();
        $product = Product::factory()->create();
        $wishlist->products()->attach($product->id);
        $this->assertTrue($wishlist->products->contains($product));
    }

    public function test_wishlist_can_be_updated()
    {
        $wishlist = Wishlist::factory()->create();
        $wishlist->usuario_id = Usuario::factory()->create()->id;
        $wishlist->save();
        $this->assertDatabaseHas('wishlists', [
            'id' => $wishlist->id,
            'usuario_id' => $wishlist->usuario_id,
        ]);
    }

    public function test_wishlist_can_be_deleted()
    {
        $wishlist = Wishlist::factory()->create();
        $wishlist->delete();
        $this->assertDatabaseMissing('wishlists', [
            'id' => $wishlist->id,
        ]);
    }
}
