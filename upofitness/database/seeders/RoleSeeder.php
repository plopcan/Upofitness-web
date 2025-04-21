<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            ['name' => 'usuario', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'administrador', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}