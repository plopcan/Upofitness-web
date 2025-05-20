<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\ProductDiscount;
use App\Models\Product;

class ProductDiscountTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_discount_can_be_created()
    {
        $discount = ProductDiscount::factory()->create();
        $this->assertDatabaseHas('product_discounts', [
            'id' => $discount->id,
            'product_id' => $discount->product_id,
        ]);
    }

    public function test_product_discount_belongs_to_product()
    {
        $discount = ProductDiscount::factory()->create();
        $this->assertInstanceOf(Product::class, $discount->product);
    }

    public function test_product_discount_can_be_updated()
    {
        $discount = ProductDiscount::factory()->create();
        // Usa el nombre real de la columna, por ejemplo 'percentage'
        $discount->percentage = 50;
        $discount->save();
        $this->assertDatabaseHas('product_discounts', [
            'id' => $discount->id,
            'percentage' => 50,
        ]);
    }

    public function test_product_discount_can_be_deleted()
    {
        $discount = ProductDiscount::factory()->create();
        $discount->delete();
        $this->assertDatabaseMissing('product_discounts', [
            'id' => $discount->id,
        ]);
    }
}
