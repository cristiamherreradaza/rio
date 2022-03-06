<?php

namespace App\Http\Controllers;

use App\Recibo;
use PDF;
use Illuminate\Http\Request;

class ReporteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('validaEmail');
    }

    public function pagos(Request $request){

        return view('reporte.pagos');

    }

    public function ajax_listado(Request $request){
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

        if ($request->filled('fecha_ini') && $request->filled('fecha_fin')) {
            $fecha_ini = $request->input('fecha_ini');
            $fecha_fin = $request->input('fecha_fin');

            $query->whereBetween('recibos.fecha', [$fecha_ini,$fecha_fin]);
        }

        if ($request->filled('nombre') || $request->filled('fecha_ini') || $request->filled('fecha_fin')) {
            $query->limit(300);
        }else{
            $query->limit(200);
        }

        
        $recibos = $query->get();
        
        return view('reporte.ajax_listado')->with(compact('recibos'));

    }

    public function PagosgeneraPdf(Request $request){
        // dd($request->all());
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

        if ($request->filled('fecha_ini') && $request->filled('fecha_fin')) {
            $fecha_ini = $request->input('fecha_ini');
            $fecha_fin = $request->input('fecha_fin');

            $query->whereBetween('recibos.fecha', [$fecha_ini,$fecha_fin]);
        }

        if ($request->filled('nombre') || $request->filled('fecha_ini') || $request->filled('fecha_fin')) {
            $query->limit(300);
        }else{
            $query->limit(200);
        }

        
        $recibos = $query->get();
        
        $pdf = PDF::loadView('reporte.PagosgeneraPdf', compact('recibos'));
        $pdf->setPaper('letter', 'portrait');

        // download PDF file with download method
        return $pdf->stream('recibo.pdf');
    }
}
