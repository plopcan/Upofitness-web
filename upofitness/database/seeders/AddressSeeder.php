<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Address;


class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $addresses = [
            [
                'usuario_id' => 1,
                'address' => '123 Main St',
                'city' => 'New York',
                'postal_code' => '10001',
                'country' => 'USA',
            ],
            [
                'usuario_id' => 1,
                'address' => '456 Elm St',
                'city' => 'Los Angeles',
                'postal_code' => '90001',
                'country' => 'USA',
            ],
            [
                'usuario_id' => 1,
                'address' => '789 Oak St',
                'city' => 'Chicago',
                'postal_code' => '60601',
                'country' => 'USA',
            ],
        ];

        foreach ($addresses as $address) {
            Address::create($address);
        }
    }
}