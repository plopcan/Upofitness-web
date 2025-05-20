<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Category;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_category_can_be_created()
    {
        $response = $this->post('/categories', [
            'name' => 'Nueva Categoria',
            'description' => 'Descripción de prueba',
        ]);

        $response->assertRedirect('/categories');
        $this->assertDatabaseHas('categories', [
            'name' => 'Nueva Categoria',
            'description' => 'Descripción de prueba',
        ]);
    }

    public function test_category_can_be_listed()
    {
        Category::factory()->create(['name' => 'Proteínas']);
        $response = $this->get('/categories');
        $response->assertSee('Proteínas');
    }

    public function test_category_can_be_updated()
    {
        $category = Category::factory()->create();
        $response = $this->put("/categories/{$category->id}", [
            'name' => 'Actualizada',
            'description' => 'Nueva descripción',
        ]);
        $response->assertRedirect('/categories');
        $this->assertDatabaseHas('categories', ['name' => 'Actualizada']);
    }

    public function test_category_can_be_deleted()
    {
        $category = Category::factory()->create();
        $response = $this->delete("/categories/{$category->id}");
        $response->assertRedirect('/categories');
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }
}
