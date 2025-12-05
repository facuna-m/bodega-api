<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    protected $table = 'movimiento';

    public $timestamps = false;

    protected $fillable = [
        'tipo', 
        'cantidad', 
        'id_producto'
    ];
}
