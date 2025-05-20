<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UsuarioFactory extends Factory
{
    protected $model = \App\Models\Usuario::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => bcrypt('password'), // o Hash::make('password')
            'phone' => $this->faker->phoneNumber(),
            'role_id' => \App\Models\Role::factory(),
            'image_id' => null,
        ];
    }
}
