<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'issue_date',
        'tax_percentage',
        'total_amount',
        'orders_id',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
