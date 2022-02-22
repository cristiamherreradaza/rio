<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Recibo extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 
        'persona_id', 
        'carnet', 
        'fecha', 
        'total', 
        'numero', 
        'numero_recibo', 
        'anio', 
        'estado',
        'deleted_at'
    ];
}
