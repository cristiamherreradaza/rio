<?php

namespace App\Http\Controllers;

use App\User;
use App\Evento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MedicoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('registro');
    }

    public function registro(Request $request)
    {
        // dd($request->input());
        $persona           = new User();
        $persona->perfil   = 'Doctor';
        $persona->name     = $request->input('name-registro');
        $persona->email    = $request->input('email-registro');
        $persona->password = Hash::make($request->input('password-registro'));
        $persona->estado   = 'Pendiente';
        $persona->save();

        return redirect('/login');

    }

    public function eventos(Request $request)
    {
        $eventos = Evento::latest()
                        ->limit(10)
                        ->get();

        return view('medico.eventos')->with(compact('eventos'));        			
    }
}
