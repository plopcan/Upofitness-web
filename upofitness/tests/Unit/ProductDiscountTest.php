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
}
