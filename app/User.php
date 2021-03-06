<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'ci', 
        'email', 
        'password',
        'perfil_id',
        'sector_id',
        'estado',
        'latitud',
        'longitud',
        'direccion',
        'celulares',
        'deleted_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sector()
    {
        return $this->belongsTo('App\Sector', 'sector_id');
    }

    public function perfil()
    {
        return $this->belongsTo('App\Perfil', 'perfil_id');
    }

}
