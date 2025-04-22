<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
  use HasFactory;
  
  protected $fillable = [
    'usuario_id',
    'card_number',
    'expiration_date',
    'cvv',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }

    public function payment()
    {
        return $this->hasMany(Payment::class);
    }

}
