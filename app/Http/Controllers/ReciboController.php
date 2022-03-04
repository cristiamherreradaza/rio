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
                                'recibos.numero',
                                'recibos.anio',
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
            $query->where('users.name', 'like', "%$nombre%");
        }
        
        if ($request->filled('ci')) {
            $ci = $request->input('ci');
            $query->where('recibos.carnet', "$ci");
        }

        if ($request->filled('recibo')) {
            $recibo = $request->input('recibo');
            $query->where('recibos.numero_recibo', 'like', "%$recibo%");
        }

        if ($request->filled('fecha')) {
            $fecha = $request->input('fecha');
            $query->where('recibos.fecha', 'like', "%$fecha%");
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
