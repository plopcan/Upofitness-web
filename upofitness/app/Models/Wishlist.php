<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    protected $fillable = ['user_id'];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'user_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'wishlist_product');
    }
}
