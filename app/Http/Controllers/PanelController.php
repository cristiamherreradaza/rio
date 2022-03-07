<?php

namespace App\Http\Controllers;

use App\Pago;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PanelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function inicio()
    {
        // socios registrados
        $socios = User::where('Perfil', 'Doctor')->count();

        // usuarios registrados
        $usuario = User::where('Perfil', 'Administrador')->count();

        // cantidad de pagos en el mes actual
        $fecha_ini = date('Y')."-".date('m')."-01 00:00:00";
        $fecha_fin = date('Y')."-".date('m')."-".date('t')." 23:59:59";
        
        $pagos = Pago::whereBetween('fecha_pago', [$fecha_ini, $fecha_fin])->count();

        // montos pagados pro mes
        $cuotasPagadas = array();

        for($i = 1 ; $i <= 12 ; $i++){

            $inidate = date("Y")."-".(($i<=9)? '0'.$i : $i )."-01";
            $findate = date("Y")."-".(($i<=9)? '0'.$i : $i )."-".cal_days_in_month(CAL_GREGORIAN, (($i<=9)? '0'.$i : $i ) , date("Y"));

            $cantiodadREgistroMes = Pago::whereBetween('fecha_pago',["$inidate","$findate"])
                                    ->count(); 

            array_push($cuotasPagadas, $cantiodadREgistroMes);

        }

        // doctores por categorias
        $doctorCategoria = DB::table('users')
                                ->select('users.categoria_id')
                                ->selectRaw('count(users.categoria_id) as total')
                                ->whereNotNull('users.categoria_id')
                                ->groupBy('users.categoria_id')
                                ->get();

        // contar deudores del mes actual
        $usuario1 = DB::table('pagos')
                ->select('pagos.user_id as usuario')
                ->groupBy('pagos.user_id')
                ->get();

        $contadorDeudor = 0;
        $contadorPagador = 0;
        $mes = date('m');

        foreach($usuario1 as $u){
            $pado = Pago::where('user_id',$u->usuario)
                        ->where('nmes',$mes)
                        ->first();

            if($pado){

                if($pado->estado == "Pagado"){
                    $contadorPagador++;
                }else{
                    $contadorDeudor++;
                }
                
            }
            
        }

        return view('panel.inicio')->with(compact('socios', 'usuario', 'pagos', 'cuotasPagadas', 'doctorCategoria', 'contadorPagador', 'contadorDeudor'));
    }
}
