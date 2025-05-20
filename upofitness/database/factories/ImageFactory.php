<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ImageFactory extends Factory
{
    protected $model = \App\Models\Image::class;

    public function definition()
    {
        return [
            'url' => $this->faker->imageUrl(),
            'product_id' => \App\Models\Product::factory(),
        ];
    }
}
