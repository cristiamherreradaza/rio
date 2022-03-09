<?php

namespace App\Http\Controllers;

use App\Evento;
use App\Asistencia;
use App\User;
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

    public function ajax_listado(Request $request)
    {

        // dd($request->input('nombre'));
        $query = Evento::orderBy('id', 'desc');

        if ($request->filled('nombre')) {
            $nombre = $request->input('nombre');
            $query->where('nombre', 'like', "%$nombre%");
        }

        if ($request->filled('fecha')) {
            $fecha_ini = $request->input('fecha')." 00:00:00";
            $fecha_fin = $request->input('fecha')." 23:59:59";
            $query->whereBetween('fecha_inicio', [$fecha_ini,$fecha_fin]);
        }

        if ($request->filled('nombre') || $request->filled('fecha')) {
            $query->limit(300);
        }else{
            $query->limit(200);
        }

        
        $eventos = $query->get();
        
        return view('evento.ajaxListado')->with(compact('eventos'));

        // $eventos = Evento::all();
        // return Datatables::of($eventos)
        //         ->addColumn('action', function($eventos){
        //             return '<a href="#" class="btn btn-icon btn-warning btn-sm mr-2" onclick="edita('.$eventos->id.')">
        //                         <i class="fas fa-edit"></i>
        //                     </a>
        //                     <a href="#" class="btn btn-icon btn-success btn-sm mr-2" onclick="asistencia('.$eventos->id.')">
        //                         <i class="fas fa-list-alt"></i>
        //                     </a>
        //                     <a href="#" class="btn btn-icon btn-danger btn-sm mr-2" onclick="elimina('.$eventos->id.', \''.$eventos->nombre.'\')">
        //                         <i class="flaticon2-delete"></i>
        //                     </a>';
        //         })->make(true);
    }

    public function nuevo()
    {
        return view('evento.nuevo');        			
    }

    public function guarda(Request $request)
    {
        // dd($request->id);
        // dd($request->all());
        if($request->imagen != null){
            $archivo = $request->imagen;
            $direccion = 'imagenesEventos/'; // upload path
            $nombreArchivo = date('YmdHis'). "." . $archivo->getClientOriginalExtension();
            $archivo->move($direccion, $nombreArchivo);
        }

        if($request->id == null){
            $evento = new Evento();
        }else{
            $evento = Evento::find($request->id);
        }

        
        $evento->user_id     = Auth::user()->id;
        $evento->nombre      = $request->nombre;
        $evento->invitacion  = $request->invitacion;
        $evento->ordendia        = $request->ordendia;
        $evento->actareunion = $request->actareunion;
        if($request->imagen != null){
            $evento->imagen = $nombreArchivo;
        }
        $evento->fecha_inicio = $request->fecha_inicio;
        $evento->fecha_fin    = $request->fecha_fin;
        $evento->tipo         = $request->tipo;
        $evento->save();

        return redirect('Evento/listado');
    }

    public function edita(Request $request, $id)
    {
        $datosEvento = Evento::find($id);
        return view('evento.edita')->with(compact('datosEvento'));        			
    }

    public function elimina(Request $request, $id)
    {
        Evento::destroy($id);
        return redirect('Evento/listado');
    }

    public function asistencia(Request $request, $id)
    {
        $doctores  = User::where('perfil', 'Doctor')
                        ->get();

        $datosEvento = Evento::find($id);

        return view('evento.asistencia')->with(compact('doctores', 'datosEvento'));                  
    }

    public function asiste(Request $request, $user_id, $evento_id)
    {
        // dd($evento_id);
        $asistencia = new Asistencia();
        $asistencia->user_id    = $user_id;
        $asistencia->evento_id  = $evento_id;
        $asistencia->estado     = "Asistio";
        $asistencia->save();
        return redirect("Evento/asistencia/$evento_id");
    }

    public function falta(Request $request, $user_id, $evento_id)
    {
        Asistencia::where('user_id', $user_id)
                    ->where('evento_id', $evento_id)
                    ->delete();

        return redirect("Evento/asistencia/$evento_id");
    }

    public function marcarAsistencia(Request $request){

        $evento_id = $request->input('evento_id');

        $evento = Asistencia::where('evento_id',$evento_id)->count();

        $idsAsistencias = array_keys($request->select);

        if( $evento > 0 ){

            foreach ($idsAsistencias as $ids){

                $asistencia = Asistencia::where('evento_id',$evento_id)
                                        ->where('user_id', $ids)
                                        ->first();

                $asistencia->estado = "Asistio";

                $asistencia->save();
            }
            
        }else{

            $doctores = User::where('perfil','Doctor')->get();

            foreach ($doctores as $d){

                $asistencia = new Asistencia();

                $asistencia->user_id    = $d->id;
                $asistencia->evento_id  = $evento_id;

                if(in_array($d->id, $idsAsistencias)){
                    $asistencia->estado = "Asistio";
                }else{
                    $asistencia->estado = "Falto";
                }

                $asistencia->save();
            }

        }

        

        return redirect('Evento/listado');
    }
}