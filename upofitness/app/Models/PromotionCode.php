<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromotionCode extends Model
{
    use HasFactory;
    protected $fillable = [
        'code',
        'percentage',
        'expiration_date',
        'uses'
    ];
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
