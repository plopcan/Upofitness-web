<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CategoryProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::all();
        $categories = Category::all();

        if ($products->isEmpty()) {
            $this->command->error('No hay productos para asignar a categorías. Asegúrate de ejecutar ProductSeeder primero.');
            return;
        }

        if ($categories->isEmpty()) {
            $this->command->error('No hay categorías disponibles. Asegúrate de ejecutar CategorySeeder primero.');
            return;
        }

        // Limpiar tabla pivote antes de insertar nuevos datos
        DB::table('category_product')->truncate();

        // Asignar categorías aleatorias a cada producto
        foreach ($products as $product) {
            // Cada producto tendrá entre 1 y 3 categorías aleatorias
            $randomCategories = $categories->random(rand(1, 3));
            
            foreach ($randomCategories as $category) {
                DB::table('category_product')->insert([
                    'product_id' => $product->id,
                    'category_id' => $category->id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }

        $this->command->info('Relaciones entre productos y categorías creadas con éxito.');
    }
}