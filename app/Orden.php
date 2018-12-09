<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Mpociot\Firebase\SyncsWithFirebase;

class Orden extends Model
{
    use SyncsWithFirebase;

    protected $fillable = [
        'id', 'email', 'subtotal', 'envio', 'estado_orden', 'updated_at',
    ];
}
