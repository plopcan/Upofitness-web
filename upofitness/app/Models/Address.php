<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
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
