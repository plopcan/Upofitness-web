<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ValorationFactory extends Factory
{
    protected $model = \App\Models\Valoration::class;

    public function definition()
    {
        return [
            'usuario_id' => null, // Se asignará en el test
            'producto_id' => null, // Se asignará en el test
            'puntuacion' => $this->faker->numberBetween(1, 5),
            'comentario' => $this->faker->sentence(),
        ];
    }
}
