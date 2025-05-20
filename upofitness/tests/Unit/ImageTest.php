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
}
