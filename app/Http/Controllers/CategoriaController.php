<?php

namespace App\Http\Controllers;

use App\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function listado()
    {
        // dd('holas');
        $categorias = Categoria::all();
        return view('categoria.listado')->with(compact('categorias'));
    }

    public function guarda(Request $request){
        // dd($request->input('nombre'));
        $categoria_id = $request->input('categoria_id');

        if($categoria_id == 0 ){
            $categoria = new Categoria();
        }else{
            $categoria = Categoria::find($categoria_id);
        }

        $categoria->nombre = $request->input('nombre');
        $categoria->estado = $request->input('estado');

        $categoria->save();

        return redirect('Categoria/listado');
    }

    public function elimina(Request $request, $categoria_id){

        Categoria::destroy($categoria_id);

        return redirect('Categoria/listado');
    }
}
