<?php

namespace App\Http\Controllers;

use App\Evento;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function listado()
    {
        return view('evento.listado');
    }

    public function ajax_listado()
    {
        $eventos = Evento::all();
        return Datatables::of($eventos)
                ->addColumn('action', function($eventos){
                    return '<a href="#" class="btn btn-icon btn-warning btn-sm mr-2" onclick="edita('.$eventos->id.')">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="#" class="btn btn-icon btn-danger btn-sm mr-2" onclick="elimina('.$eventos->id.', \''.$eventos->nombre.'\')">
                                <i class="flaticon2-delete"></i>
                            </a>';
                })->make(true);
    }

    public function nuevo()
    {
        return view('evento.nuevo');        			
    }

    public function guarda(Request $request)
    {
        $archivo = $request->imagen;
        $direccion = 'imagenesEventos/'; // upload path
        $nombreArchivo = date('YmdHis'). "." . $archivo->getClientOriginalExtension();
        $archivo->move($direccion, $nombreArchivo);
        
        $evento               = new Evento();
        $evento->user_id      = Auth::user()->id;
        $evento->nombre       = $request->nombre;
        $evento->descripcion  = $request->descripcion;
        $evento->imagen       = $nombreArchivo;
        $evento->fecha_inicio = $request->fecha_inicio;
        $evento->fecha_fin    = $request->fecha_fin;
        $evento->tipo         = $request->tipo;
        $evento->save();

        return redirect('Evento/listado');
    }

    public function edita(Request $request)
    {
        
    }
}