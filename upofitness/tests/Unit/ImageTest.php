<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Image;
use App\Models\Product;

class ImageTest extends TestCase
{
    use RefreshDatabase;

    public function test_image_can_be_created()
    {
        $image = Image::factory()->create();
        $this->assertDatabaseHas('images', [
            'id' => $image->id,
            'url' => $image->url,
        ]);
    }

    public function test_image_belongs_to_product()
    {
        $image = Image::factory()->create();
        $this->assertInstanceOf(Product::class, $image->product);
    }

    public function test_image_can_be_updated()
    {
        $image = Image::factory()->create();
        $image->url = 'http://new-url.com/image.jpg';
        $image->save();
        $this->assertDatabaseHas('images', [
            'id' => $image->id,
            'url' => 'http://new-url.com/image.jpg',
        ]);
    }

    public function test_image_can_be_deleted()
    {
        $image = Image::factory()->create();
        $image->delete();
        $this->assertDatabaseMissing('images', [
            'id' => $image->id,
        ]);
    }
}
