<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Role;
use App\Models\Usuario;

class RoleTest extends TestCase
{
    use RefreshDatabase;

    public function test_role_can_be_created()
    {
        $role = Role::factory()->create();
        $this->assertDatabaseHas('roles', [
            'id' => $role->id,
            'name' => $role->name,
        ]);
    }

    public function test_role_has_usuarios_relationship()
    {
        $role = Role::factory()->create();
        $usuario = Usuario::factory()->create(['role_id' => $role->id]);
        $this->assertTrue($role->usuarios->contains($usuario));
    }

    public function test_role_can_be_updated()
    {
        $role = Role::factory()->create();
        $role->name = 'Updated Role';
        $role->save();
        $this->assertDatabaseHas('roles', [
            'id' => $role->id,
            'name' => 'Updated Role',
        ]);
    }

    public function test_role_can_be_deleted()
    {
        $role = Role::factory()->create();
        $role->delete();
        $this->assertDatabaseMissing('roles', [
            'id' => $role->id,
        ]);
    }
}
