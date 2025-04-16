<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'available',
    ];

    protected $casts = [
        'price' => 'float',
        'stock' => 'integer',
        'available' => 'boolean',
    ];
    
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_product');
    }
    
    public function discount()
    {
        return $this->hasOne(ProductDiscount::class, 'product_id');
    }
}
