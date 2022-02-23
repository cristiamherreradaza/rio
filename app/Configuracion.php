<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Configuracion extends Model
{
    use SoftDeletes;
    
    protected $table = "configuraciones";

    protected $fillable = [
        'descripcion', 
        'valor',
        'deleted_at'
    ];
}
