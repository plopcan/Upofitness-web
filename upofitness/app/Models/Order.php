<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'usuario_id',
        'product_id',
        'quantity',
        'total_price',
        'status',
        'promotion_code_id',
        'full_address',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
