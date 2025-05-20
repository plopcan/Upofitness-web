<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    protected $model = \App\Models\Address::class;

    public function definition()
    {
        return [
            'usuario_id' => \App\Models\Usuario::factory(),
            'city' => $this->faker->city(),
            'postal_code' => $this->faker->postcode(),
            'address' => $this->faker->streetAddress(),
            'country' => $this->faker->country(),
            'phone' => $this->faker->phoneNumber(),
        ];
    }
}
