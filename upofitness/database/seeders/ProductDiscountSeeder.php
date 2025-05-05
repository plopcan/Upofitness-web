<?php

namespace Database\Seeders;

use App\Models\ProductDiscount;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ProductDiscountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Datos ficticios para los descuentos
        $discounts = [
            ['percentage' => 10, 'expiration_date' => Carbon::now()->addWeeks(1)],
            ['percentage' => 15, 'expiration_date' => Carbon::now()->addWeeks(2)],
            ['percentage' => 20, 'expiration_date' => Carbon::now()->addMonth()],
            ['percentage' => 25, 'expiration_date' => Carbon::now()->addMonths(2)],
            ['percentage' => 30, 'expiration_date' => Carbon::now()->addMonths(3)],
            ['percentage' => 35, 'expiration_date' => Carbon::now()->addWeeks(3)],
            ['percentage' => 40, 'expiration_date' => Carbon::now()->addMonths(1)],
            ['percentage' => 45, 'expiration_date' => Carbon::now()->addMonths(2)],
            ['percentage' => 50, 'expiration_date' => Carbon::now()->addWeeks(4)],
            ['percentage' => 55, 'expiration_date' => Carbon::now()->addMonths(3)],
        ];

        foreach (range(1, 10) as $productId) {
            $discount = $discounts[array_rand($discounts)];

            $productDiscount = ProductDiscount::create([
                'product_id' => $productId,
                'percentage' => $discount['percentage'],
                'expiration_date' => $discount['expiration_date'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            // Aplicar el descuento al producto
            $product = Product::find($productId);
            if ($product) {
                $discountedPrice = $product->price * (1 - ($productDiscount->percentage / 100));
                $product->update(['price' => round($discountedPrice, 2)]);
            }
        }
    }
}