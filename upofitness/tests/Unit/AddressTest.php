<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Address;
use App\Models\Usuario;

class AddressTest extends TestCase
{
    use RefreshDatabase;

    public function test_address_can_be_created()
    {
        $address = Address::factory()->create();
        $this->assertDatabaseHas('addresses', [
            'id' => $address->id,
            'city' => $address->city,
        ]);
    }

    public function test_address_belongs_to_usuario()
    {
        $address = Address::factory()->create();
        $this->assertInstanceOf(Usuario::class, $address->usuario);
    }
}
