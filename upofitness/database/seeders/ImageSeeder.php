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
        Image::create([
            'product_id' => 4,
            'url' => 'products/daily.jpeg',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        Image::create([
            'product_id' => 5,
            'url' => 'products/omega3.jpg',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        Image::create([
            'product_id' => 6,
            'url' => 'products/magnesio.png',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        Image::create([
            'product_id' => 7,
            'url' => 'products/vegan.jpeg',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        Image::create([
            'product_id' => 8,
            'url' => 'products/vitaminad3.jpg',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        Image::create([
            'product_id' => 9,
            'url' => 'products/718hxSwO18L._AC_UF894,1000_QL80_.jpg',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        Image::create([
            'product_id' => 10,
            'url' => 'products/71KCiP30TVL._AC_UF1000,1000_QL80_.jpg',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        Image::create([
            'url' => 'profile_images\9uFG0iPheZXnQ3lA4iyLvEA9SiRLa4nlTryp0jam.png',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        Image::create([
            'url' => 'profile_images\iO0yB7J9ddPfx97mVM2wADXsgEPtK1RVEN0dyeV2.png',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        Image::create([
            'url' => 'profile_images\2602d793a7d79dec5e07e44b2d9a89c9.jpg',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        Image::create([
            'url' => 'profile_images\fveg8ebvd37.jpg',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        Image::create([
            'url' => 'profile_images\43278767630_2a2bb039e8_z.jpg',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        Image::create([
            'url' => 'profile_images\1661892088256-0a17130b3d0d.jpeg',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        Image::create([
            'url' => 'profile_images\179653.jpg',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        Image::create([
            'url' => 'profile_images\jbneeg09t487.jpg',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        Image::create([
            'url' => 'profile_images\lBho547hgseoth90.jpg',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);


    }
}