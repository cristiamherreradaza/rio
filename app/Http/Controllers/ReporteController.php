<?php

namespace App\Http\Controllers;

use PDF;
use App\User;
use App\Evento;
use App\Recibo;
use App\Asistencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function gestion(Request $request){

        return view('reporte.gestion');

    }

    public function ajaxPagosgeneraGestion(Request $request){

        $doctores = User::where('perfil', 'Doctor')->get();

        $gestion = $request->input('gestion');

        $totales = DB::table('pagos')
                 ->select('nmes', DB::raw('sum(monto) as total'))
                 ->where('gestion',$gestion)
                 ->where('estado',"Pagado")
                 ->groupBy('nmes')
                 ->get();

        return view('reporte.ajaxPagosgeneraGestion')->with(compact('doctores','gestion', 'totales'));

    }

    public function PagosgeneraGestionPdf(Request $request){
        
        $doctores = User::where('perfil', 'Doctor')->get();

        $gestion = $request->input('gestion');

        $totales = DB::table('pagos')
                 ->select('nmes', DB::raw('sum(monto) as total'))
                 ->where('gestion',$gestion)
                 ->where('estado',"Pagado")
                 ->groupBy('nmes')
                 ->get();


        $pdf = PDF::loadView('reporte.PagosgeneraGestionPdf', compact('doctores','gestion', 'totales'));
        // $pdf->setPaper('letter', 'portrait');
        $pdf->setPaper('letter', 'landscape');

        // download PDF file with download method
        return $pdf->stream('reciboGestio.pdf');
    }

    public function asistenciaGestion(Request $request){

        $doctores = User::where('perfil', 'Doctor')->get();

        $eventos = Evento::all();

        return view('reporte.asistencia')->with(compact('doctores','eventos'));

    }

    public function ajaxAsistenciaGestion(Request $request){

        $doctores = User::where('perfil', 'Doctor')->get();

        $gestion = $request->input('gestion');
         
        $fecha_ini  = $gestion."-01-01 00:00:00";
        $fecha_fin  = $gestion."-12-31 23:59:59";

        $eventos = Evento::whereBetween('fecha_inicio', [$fecha_ini,$fecha_fin])->get();

        return view('reporte.ajaxAsistenciaGestion')->with(compact('doctores','eventos'));
    }

    public function AsistenciaGestionPdf(Request $request){

        $doctores = User::where('perfil', 'Doctor')->get();

        $gestion = $request->input('gestion');
         
        $fecha_ini  = $gestion."-01-01 00:00:00";
        $fecha_fin  = $gestion."-12-31 23:59:59";

        $eventos = Evento::whereBetween('fecha_inicio', [$fecha_ini,$fecha_fin])->get();

        $pdf = PDF::loadView('reporte.AsistenciaGestionPdf', compact('doctores','eventos', 'gestion'));
        $pdf->setPaper('letter', 'portrait');
        // $pdf->setPaper('letter', 'landscape');

        // download PDF file with download method
        return $pdf->stream('AsistenciaGestio.pdf');

    }

    public function ajaxAsistenciaDoctor(Request $request){

        $doctor_id = $request->input('doctor');

        $eventos = Evento::all();

        return view('reporte.ajaxAsistenciaDoctor')->with(compact('doctor_id','eventos'));

    }

    public function AsistenciaDoctorPdf(Request $request){
        
        $doctor = User::find($request->input('doctor'));

        $eventos = Evento::all();

        $pdf = PDF::loadView('reporte.AsistenciaDoctorPdf', compact('doctor','eventos'));
        $pdf->setPaper('letter', 'portrait');
        // $pdf->setPaper('letter', 'landscape');

        // download PDF file with download method
        return $pdf->stream('AsistenciaGestio.pdf');

    }

    public function ajaxAsistenciaEvento(Request $request){

        $evento_id = $request->input('evento');

        $evento = Evento::find($evento_id);

        $asistencia  = Asistencia::where('evento_id',$evento_id)
                                    ->where('estado','Asistio')
                                    ->get();
        
        return view('reporte.ajaxAsistenciaEvento')->with(compact('asistencia','evento'));

    }

    public function AsistenciaEventoPdf(Request $request){       

        $evento_id = $request->input('evento');

        $evento = Evento::find($evento_id);

        $asistencia  = Asistencia::where('evento_id',$evento_id)
                                    ->where('estado','Asistio')
                                    ->get();

        $pdf = PDF::loadView('reporte.AsistenciaEventoPdf', compact('asistencia','evento'));
        $pdf->setPaper('letter', 'portrait');
        // $pdf->setPaper('letter', 'landscape');

        // download PDF file with download method
        return $pdf->stream('AsistenciaGestio.pdf');
    }
}
