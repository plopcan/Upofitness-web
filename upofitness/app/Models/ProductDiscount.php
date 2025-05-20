<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductDiscount extends Model
{
    use HasFactory;

    protected $table = 'product_discounts';

    protected $fillable = [
        'product_id',
        'percentage',
        'expiration_date',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
