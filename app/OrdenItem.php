<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Mpociot\Firebase\SyncsWithFirebase;

class OrdenItem extends Model
{
    use SyncsWithFirebase;

    protected $fillable = [
        'id', 'cantidad', 'precio', 'id_producto', 'id_orden', 'nombre_producto', 'codigo_barras',
    ];
}
