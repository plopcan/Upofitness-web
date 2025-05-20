<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'usuario_id',
        'city',
        'postal_code',
        'address',
        'country',
        'phone',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }
}
