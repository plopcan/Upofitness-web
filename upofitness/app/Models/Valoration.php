<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Valoration extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'valorations';

    protected $fillable = [
        'usuario_id',
        'producto_id',
        'puntuacion',
        'comentario',
    ];
}
