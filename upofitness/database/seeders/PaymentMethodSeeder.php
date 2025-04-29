<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use App\Models\Usuario;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = Usuario::all();

        foreach ($users as $user) {
            PaymentMethod::create([
                'usuario_id' => $user->id,
                'card_number' => $this->generateFakeCardNumber(),
                'expiration_date' => Carbon::now()->addYears(rand(1, 5)),
                'cvv' => rand(100, 999), 
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Genera un número de tarjeta ficticio.
     */
    private function generateFakeCardNumber(): string
    {
        return '4111-' . rand(1000, 9999) . '-' . rand(1000, 9999) . '-' . rand(1000, 9999);
    }
}