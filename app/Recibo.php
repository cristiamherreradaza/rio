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
    
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function persona()
    {
        return $this->belongsTo('App\User', 'persona_id');
    }


}
