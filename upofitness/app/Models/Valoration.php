<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Valoration extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'valorations';

    protected $fillable = [
        'usuario_id',
        'producto_id',
        'puntuacion',
        'comentario',
    ];
}
