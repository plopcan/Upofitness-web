<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Proteínas',
                'description' => 'Suplementos ricos en proteínas para el desarrollo muscular y recuperación tras el ejercicio.'
            ],
            [
                'name' => 'Vitaminas',
                'description' => 'Complementos con vitaminas esenciales para mantener una salud óptima y prevenir deficiencias.'
            ],
            [
                'name' => 'Minerales',
                'description' => 'Suplementos de minerales esenciales como calcio, magnesio, zinc y hierro.'
            ],
            [
                'name' => 'Aminoácidos',
                'description' => 'Productos con aminoácidos esenciales y BCAA para mejorar el rendimiento y recuperación muscular.'
            ],
            [
                'name' => 'Pre-entreno',
                'description' => 'Suplementos energéticos para tomar antes del ejercicio y maximizar el rendimiento deportivo.'
            ],
            [
                'name' => 'Quemadores de grasa',
                'description' => 'Productos diseñados para acelerar el metabolismo y favorecer la pérdida de grasa corporal.'
            ],
            [
                'name' => 'Ganadores de peso',
                'description' => 'Suplementos hipercalóricos para aumentar la masa corporal y muscular.'
            ],
            [
                'name' => 'Omega-3',
                'description' => 'Suplementos ricos en ácidos grasos esenciales para la salud cardiovascular y cerebral.'
            ],
            [
                'name' => 'Multivitamínicos',
                'description' => 'Complementos con combinación de vitaminas y minerales para una nutrición completa.'
            ],
            [
                'name' => 'Alimentos saludables',
                'description' => 'Productos alimenticios naturales y barritas energéticas para una nutrición equilibrada.'
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}