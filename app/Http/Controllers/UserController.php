<?php

namespace App\Http\Controllers;

use App\User;
use App\Sector;
use DataTables;
use App\Categoria;
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
        return view('user.listado');
    }

    public function ajax_listado()
    {
        $usuarios = User::all();
        return Datatables::of($usuarios)
                ->addColumn('action', function($usuarios){
                    return '<a href="#" class="btn btn-icon btn-warning btn-sm mr-2" onclick="edita('.$usuarios->id.')">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="#" class="btn btn-icon btn-danger btn-sm mr-2" onclick="elimina('.$usuarios->id.', \''.$usuarios->name.'\')">
                                <i class="flaticon2-delete"></i>
                            </a>';
                })->make(true);
    }

    public function nuevo()
    {
        $categorias = Categoria::all();
        return view('user.nuevo')->with(compact('categorias'));        			
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
        // dd($request->input());

        if($request->has('id')){
            $persona = User::find($request->id);
        }else{
            $persona = new User();
        }

        $persona->categoria_id     = $request->categoria_id;
        $persona->name             = $request->name;
        $persona->ci               = $request->ci;
        $persona->email            = $request->email;
        if($request->has('password')){
            $persona->password         = Hash::make($request->password);
        }
        $persona->fecha_nacimiento = $request->fecha_nacimiento;
        $persona->direccion        = $request->direccion;
        $persona->celulares        = $request->celulares;
        $persona->perfil           = "Doctor";
        $persona->save();

        return redirect('User/listado');
    }

    public function elimina(Request $request)
    {

    }

    public function edita(Request $request, $id)
    {
        $datosUsuario = User::findOrFail($id);
        $categorias = Categoria::all();
        return view('user.edita')->with(compact('datosUsuario', 'categorias'));                   
    }
}
