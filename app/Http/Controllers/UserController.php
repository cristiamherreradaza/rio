<?php

namespace App\Http\Controllers;

use App\User;
use App\Sector;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function listado()
    {
    	// $usuarios = User::all();
    	// dd($usuarios);
        return view('user.listado');
    }

    public function ajax_listado()
    {
        $usuarios = User::all();
        return Datatables::of($usuarios)
                ->addColumn('action', function($usuarios){
                    return '<button onclick="muestra(' . $usuarios->id . ')" class="btn btn-info" title="Ver detalle"><i class="fas fa-eye"></i></button>';
                })->make(true);
    }

    public function nuevo()
    {
        $sectores = Sector::all();
        // dd($sectores);
        
        return view('user.nuevo')->with(compact('usuarios'));        			
    }

    public function ajaxDistrito(Request $request)
    {
        $distritos = Sector::where('departamento', $request->departamento)
                        ->whereNull('padre_id')
                        ->get();
        
        return view('user.ajaxDistritos')->with(compact('distritos'));                   
    }

    public function ajaxOtb(Request $request)
    {
        $otbs = Sector::where('padre_id', $request->distrito)
                        ->get();

        return view('user.ajaxOtb')->with(compact('otbs'));                   
    }

    public function guarda(Request $request)
    {
        // dd($request->all());
        $persona                   = new User();
        $persona->sector_id        = $request->sector_id;
        $persona->name             = $request->name;
        $persona->ci               = $request->ci;
        $persona->email            = $request->email;
        $persona->password         = Hash::make($request->password);
        $persona->fecha_nacimiento = $request->fecha_nacimiento;
        $persona->direccion        = $request->direccion;
        $persona->celulares        = $request->celulares;
        $persona->perfil           = $request->perfil;
        $persona->save();

        return redirect('User/listado');

    }
}
