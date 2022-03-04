<?php

namespace App\Http\Controllers;

use App\Recibo;
use Illuminate\Http\Request;

class ReciboController extends Controller
{
    public function listado()
    {
        return view('recibo.listado');
    }

    public function ajax_listado(Request $request)
    {
        // dd($request->input('nombre'));
        $query = Recibo::select(
                                'recibos.id as id', 
                                'users.name as persona_nombre',
                                'users.id as personaid',
                                'recibos.carnet',
                                'recibos.fecha',
                                'recibos.total',
                                )
                        ->leftJoin('users', 'users.id', '=', 'recibos.persona_id')
                        ->orderBy('recibos.id', 'desc');
                        // ->get();

        // dd($query);

        if ($request->filled('nombre')) {
            $nombre = $request->input('nombre');
            $query->where('users.nombre', 'like', "%$nombre%");
        }

        if ($request->filled('fecha')) {
            $fecha_ini = $request->input('fecha')." 00:00:00";
            $fecha_fin = $request->input('fecha')." 23:59:59";
            $query->whereBetween('recibos.fecha_inicio', [$fecha_ini,$fecha_fin]);
        }

        if ($request->filled('nombre') || $request->filled('fecha')) {
            $query->limit(300);
        }else{
            $query->limit(200);
        }

        
        $recibos = $query->get();
        
        return view('recibo.ajax_listado')->with(compact('recibos'));

    }

}
