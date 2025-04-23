<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

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

    public function carts()
    {
        return $this->belongsToMany(Cart::class, 'cart_product')->withPivot('quantity');
    }

    public function wishlists()
    {
        return $this->belongsToMany(Wishlist::class, 'wishlist_product');
    }

    public function images()
    {
        return $this->hasMany(Image::class, 'product_id');
    }
}
