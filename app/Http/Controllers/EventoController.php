<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EventoController extends Controller
{
    public function listado()
    {
        return view('user.listado');
    }

    public function ajax_listado()
    {
        $usuarios = User::all();
        return Datatables::of($usuarios)
                ->addColumn('action', function($usuarios){
                    return '<a href="#" class="btn btn-icon btn-primary btn-sm mr-2">
                                <i class="flaticon2-list-1"></i>
                            </a>';
                })->make(true);
    }

    public function nuevo()
    {
        return view('user.nuevo')->with(compact('usuarios'));        			
    }


}
