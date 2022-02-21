<?php

namespace App\Http\Controllers\api;

use App\User;
use App\Evento;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PublicacionesController extends Controller
{
    public function listado()
    {
        $usuarios = User::get();
        // dd($usuarios);
        return response()->json($usuarios);
    }

    public function eventos(){

        $eventos = Evento::latest()
                    ->take(20)
                    ->orderBy('id', 'desc')
                    ->get();       
        //dd($eventos);
        return response()->json($eventos);
    }
}
