<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'orders_id', 
        'card_number',
        'payment_status',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'orders_id');
    }
}
