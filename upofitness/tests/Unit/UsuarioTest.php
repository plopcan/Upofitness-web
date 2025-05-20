<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Usuario;
use App\Models\Role;

class UsuarioTest extends TestCase
{
    use RefreshDatabase;

    public function test_usuario_can_be_created()
    {
        $usuario = Usuario::factory()->create();
        $this->assertDatabaseHas('usuarios', [
            'id' => $usuario->id,
            'email' => $usuario->email,
        ]);
    }

    public function test_usuario_belongs_to_role()
    {
        $usuario = Usuario::factory()->create();
        $this->assertInstanceOf(Role::class, $usuario->role);
        $this->assertEquals($usuario->role_id, $usuario->role->id);
    }
}
