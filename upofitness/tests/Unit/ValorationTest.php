<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Valoration;
use App\Models\User;
use App\Models\Product;

class ValorationTest extends TestCase
{
    public function test_valoration_can_be_created_in_mongodb()
    {
        // Crea usuario y producto en MySQL
        config(['database.default' => 'mysql']);
        $user = User::factory()->create();
        $product = Product::factory()->create();

        config(['database.default' => 'mongodb']);
        $valoration = Valoration::factory()->create([
            'usuario_id' => $user->id,
            'producto_id' => $product->id,
        ]);
        $this->assertNotNull($valoration->_id);

        // Limpia la colección si es necesario:
        Valoration::raw()->deleteMany([]);
    }

    public function test_user_can_be_created_in_mysql()
    {
        config(['database.default' => 'mysql']);
        $user = User::factory()->create();
        $this->assertNotNull($user->id);
        // Limpia la tabla si es necesario:
        User::truncate();
    }

    public function test_valoration_can_be_updated_in_mongodb()
    {
        config(['database.default' => 'mysql']);
        $user = User::factory()->create();
        $product = Product::factory()->create();

        config(['database.default' => 'mongodb']);
        $valoration = Valoration::factory()->create([
            'usuario_id' => $user->id,
            'producto_id' => $product->id,
            'valor' => 3,
        ]);
        $valoration->valor = 5;
        $valoration->save();
        $this->assertEquals(5, Valoration::find($valoration->_id)->valor);

        Valoration::raw()->deleteMany([]);
    }

    public function test_valoration_can_be_deleted_in_mongodb()
    {
        config(['database.default' => 'mysql']);
        $user = User::factory()->create();
        $product = Product::factory()->create();

        config(['database.default' => 'mongodb']);
        $valoration = Valoration::factory()->create([
            'usuario_id' => $user->id,
            'producto_id' => $product->id,
        ]);
        $id = $valoration->_id;
        $valoration->delete();
        $this->assertNull(Valoration::find($id));

        Valoration::raw()->deleteMany([]);
    }
}
