<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Image;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Image::create([
            'product_id' => 1,
            'url' => 'products/DLQviXpZrBZ6FrUslczj0WCyFByW7Gnt856hwCcG.jpg',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        Image::create([
            'product_id' => 2,
            'url' => 'products/zTAXojlIlbfaw5z3ymaYsWgSoU6klH91qr888uFk.jpg',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        Image::create([
            'product_id' => 3,
            'url' => 'products/mvSKoXAv18jcXuQs8Lccu1OCGM7pwvix6AV0oBRU.jpg',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);


    }
}