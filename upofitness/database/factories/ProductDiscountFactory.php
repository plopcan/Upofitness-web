<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductDiscountFactory extends Factory
{
    protected $model = \App\Models\ProductDiscount::class;

    public function definition()
    {
        return [
            'product_id' => \App\Models\Product::factory(),
            'percentage' => $this->faker->numberBetween(1, 90),
            'expiration_date' => $this->faker->dateTimeBetween('now', '+1 year'),
        ];
    }
}
