<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Order;

class InvoiceFactory extends Factory
{
    protected $model = \App\Models\Invoice::class;

    public function definition()
    {
        return [
            'issue_date' => $this->faker->date(),
            'tax_percentage' => $this->faker->numberBetween(0, 21),
            'total_amount' => $this->faker->randomFloat(2, 10, 500),
            'orders_id' => Order::factory(),
        ];
    }
}
