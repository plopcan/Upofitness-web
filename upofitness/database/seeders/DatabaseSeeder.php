<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            ImageSeeder::class,
            UsuarioSeeder::class,
            AddressSeeder::class, 
            PaymentMethodSeeder::class,
            CartSeeder::class,
            OrderSeeder::class, 
            ProductDiscountSeeder::class,
            PromotionCodeSeeder::class,
            PaymentSeeder::class,
            InvoiceSeeder::class,
            WishlistSeeder::class,
            CategoryProductSeeder::class,
        ]);
    }
}
