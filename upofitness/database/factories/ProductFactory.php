<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = \App\Models\Product::class;

    public function definition()
    {
        return [
            'name' => $this->faker->unique()->word(),
            'description' => $this->faker->sentence(8),
            'price' => $this->faker->randomFloat(2, 1, 100),
            'stock' => $this->faker->numberBetween(0, 100),
            'available' => $this->faker->boolean(),
        ];
    }
}
