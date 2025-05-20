<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = \App\Models\Order::class;

    public function definition()
    {
        return [
            'full_address' => $this->faker->address,
            'total' => $this->faker->randomFloat(2, 10, 500),
            'status' => 'pendiente',
            'purchase_date' => $this->faker->date(),
            'quantity' => $this->faker->numberBetween(1, 10),
            'product_id' => \App\Models\Product::factory(),
            'usuario_id' => \App\Models\Usuario::factory(),
        ];
    }
}
