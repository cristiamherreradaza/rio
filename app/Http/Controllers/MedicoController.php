<?php

namespace App\Http\Controllers;

use App\Categoria;
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

    public function perfil(Request $request, $user_id){
        
        $user = User::find($user_id);

        $categorias = Categoria::all();

        return view('medico.perfil')->with(compact('user','categorias'));
    }

    public function edita(Request $request){
        // dd($request->all());

        $usuario = User::find($request->input('user_id'));

        $usuario->name              = $request->input('nombre');
        $usuario->ci                = $request->input('ci');
        $usuario->colegiatura       = $request->input('colegiatura');
        $usuario->email             = $request->input('email');
        $usuario->fecha_nacimiento  = $request->input('fecha_nacimiento');
        $usuario->direccion         = $request->input('direccion');
        $usuario->celulares         = $request->input('celulares');
        $usuario->colegiatura       = $request->input('colegiatura');

        if($request->has('password')){
            $usuario->password         = Hash::make($request->input('password'));
        }

        $usuario->save();

        return redirect('Medico/eventos');
    }
}
