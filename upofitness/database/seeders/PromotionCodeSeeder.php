<?php

namespace Database\Seeders;

use App\Models\PromotionCode;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PromotionCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $promotionCodes = [
            ['code' => 'WELCOME10', 'percentage' => 10, 'expiration_date' => Carbon::now()->addMonth(), 'uses' => 0],
            ['code' => 'SUMMER15', 'percentage' => 15, 'expiration_date' => Carbon::now()->addMonths(2), 'uses' => 0],
            ['code' => 'FALL20', 'percentage' => 20, 'expiration_date' => Carbon::now()->addMonths(3), 'uses' => 0],
            ['code' => 'WINTER25', 'percentage' => 25, 'expiration_date' => Carbon::now()->addWeeks(4), 'uses' => 0],
            ['code' => 'SPRING30', 'percentage' => 30, 'expiration_date' => Carbon::now()->addMonths(1), 'uses' => 0],
            ['code' => 'FITNESS40', 'percentage' => 40, 'expiration_date' => Carbon::now()->addMonths(2), 'uses' => 0],
            ['code' => 'HEALTH50', 'percentage' => 50, 'expiration_date' => Carbon::now()->addWeeks(6), 'uses' => 0],
            ['code' => 'BOOST15', 'percentage' => 15, 'expiration_date' => Carbon::now()->addMonths(3), 'uses' => 0],
            ['code' => 'ENERGY20', 'percentage' => 20, 'expiration_date' => Carbon::now()->addWeeks(8), 'uses' => 0],
            ['code' => 'RECOVERY25', 'percentage' => 25, 'expiration_date' => Carbon::now()->addMonths(4), 'uses' => 0],
        ];

        foreach ($promotionCodes as $promo) {
            PromotionCode::create($promo);
        }
    }
}