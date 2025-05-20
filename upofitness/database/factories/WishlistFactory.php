<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class WishlistFactory extends Factory
{
    protected $model = \App\Models\Wishlist::class;

    public function definition()
    {
        return [
            'usuario_id' => \App\Models\Usuario::factory(),
        ];
    }
}
