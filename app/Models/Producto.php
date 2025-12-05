<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'producto';
    
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'sku',
        'stock'
    ];
}
