<?php

namespace App\Http\Controllers;

use App\Configuracion;
use Illuminate\Http\Request;

class ConfiguracionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function listado(Request $request){

        $configuraciones = Configuracion::all();

        return view('configuracion.listado')->with(compact('configuraciones'));
        
    }

    public function guarda(Request $request){

        $configuracion_id = $request->input('configuracion_id');

        if($configuracion_id != 0 ){
            $configuracion =  Configuracion::find($configuracion_id);

            $configuracion->valor =  $request->input('descripcion');

            $configuracion->save();
        }

        return redirect('Configuracion/listado');
    }

    public function elimina(Request $request, $configuracion_id){
    
        Configuracion::destroy($configuracion_id);

        return redirect('Configuracion/listado');
    }
}
