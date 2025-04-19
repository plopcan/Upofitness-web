<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role_id',
        'image_id',
        'wishlist_id',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function image()
    {
        return $this->belongsTo(Image::class);
    }

    public function wishlist()
    {
        return $this->hasOne(Wishlist::class);
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function paymentMethods()
    {
        return $this->hasMany(PaymentMethod::class);
    }
}
