<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $products = [
            [
                'name' => 'Whey Protein Gold Standard 2kg',
                'description' => 'Proteína de suero de leche de alta calidad con 24g de proteína por porción, ideal para desarrollo muscular y recuperación post-entrenamiento.',
                'price' => 59.99,
                'stock' => 100,
            ],
            [
                'name' => 'Creatina Monohidratada 500g',
                'description' => 'Suplemento para aumentar la fuerza y rendimiento deportivo. Mejora la producción de energía durante ejercicios de alta intensidad.',
                'price' => 24.95,
                'stock' => 150,
            ],
            [
                'name' => 'BCAA 8:1:1 Aminoácidos Esenciales 300g',
                'description' => 'Fórmula avanzada de aminoácidos de cadena ramificada que ayudan a la recuperación muscular y previenen el catabolismo.',
                'price' => 29.99,
                'stock' => 80,
            ],
            [
                'name' => 'Multivitamínico Daily Support 90 cápsulas',
                'description' => 'Complejo completo de vitaminas y minerales esenciales para mantener la salud óptima y reforzar el sistema inmunológico.',
                'price' => 19.50,
                'stock' => 120,
            ],
            [
                'name' => 'Omega-3 Premium 120 cápsulas',
                'description' => 'Ácidos grasos esenciales EPA y DHA de alta pureza que apoyan la salud cardiovascular, cerebral y articular.',
                'price' => 22.99,
                'stock' => 90,
            ],
            [
                'name' => 'Magnesio Bisglicinato 120 comprimidos',
                'description' => 'Forma altamente biodisponible de magnesio que contribuye a la función muscular normal y reduce la fatiga.',
                'price' => 18.75,
                'stock' => 110,
            ],
            [
                'name' => 'Proteína Vegana Complete 1kg',
                'description' => 'Mezcla de proteínas vegetales completas de guisante, arroz y cáñamo, ideal para dietas veganas y vegetarianas.',
                'price' => 32.90,
                'stock' => 75,
            ],
            [
                'name' => 'Vitamina D3 5000UI 120 tabletas',
                'description' => 'Vitamina esencial para la salud ósea, inmunidad y bienestar general, especialmente en meses con poca exposición solar.',
                'price' => 15.95,
                'stock' => 140,
            ],
            [
                'name' => 'Pre-Workout Explosive Energy 300g',
                'description' => 'Fórmula pre-entrenamiento con cafeína, beta-alanina y citrulina para máxima energía, concentración y bombeo muscular.',
                'price' => 34.99,
                'stock' => 70,
            ],
            [
                'name' => 'Colágeno Hidrolizado con Vitamina C 300g',
                'description' => 'Péptidos de colágeno para la salud de articulaciones, piel y cabello, enriquecido con vitamina C para mejor absorción.',
                'price' => 27.50,
                'stock' => 95,
            ],
        ];

        foreach ($products as $product) {
            Product::create([
                'name' => $product['name'],
                'description' => $product['description'],
                'price' => $product['price'],
                'stock' => $product['stock'],
                'available' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Obtener categorías si existen para asignar productos a categorías
        try {
            $proteinas = Category::where('name', 'Proteínas')->first();
            $vitaminas = Category::where('name', 'Vitaminas')->first();
            $minerales = Category::where('name', 'Minerales')->first();
        } catch (\Exception $e) {
            echo "Error al obtener categorías: " . $e->getMessage();
            return;
        }
    }
}