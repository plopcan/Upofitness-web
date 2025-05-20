<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CartFactory extends Factory
{
    protected $model = \App\Models\Cart::class;

    public function definition()
    {
        return [
            'usuario_id' => \App\Models\Usuario::factory(),
        ];
    }
}
