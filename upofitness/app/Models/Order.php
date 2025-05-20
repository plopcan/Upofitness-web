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
        'total',
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
        return $this->hasOne(Invoice::class, 'orders_id'); // Ensure the foreign key is correctly specified
    }
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function promotion_code()
    {
        return $this->belongsTo(PromotionCode::class);
    }
    public function usuario()
    {
        return $this->belongsTo(\App\Models\Usuario::class, 'usuario_id');
    }
    public function showByUserId($id)
    {
        $orders = Order::with('product')->where('usuario_id', $id)->get();
        return view('orders', compact('orders'));
    }
}
