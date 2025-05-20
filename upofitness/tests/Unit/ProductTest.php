<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Product;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_can_be_created()
    {
        $product = Product::factory()->create();
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => $product->name,
        ]);
    }

    public function test_product_has_categories_relationship()
    {
        $product = Product::factory()->create();
        $this->assertTrue(method_exists($product, 'categories'));
    }

    public function test_product_can_be_updated()
    {
        $product = Product::factory()->create();
        $product->name = 'Updated Name';
        $product->save();
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Updated Name',
        ]);
    }

    public function test_product_can_be_deleted()
    {
        $product = Product::factory()->create();
        $product->delete();
        $this->assertDatabaseMissing('products', [
            'id' => $product->id,
        ]);
    }
}
