<?php

namespace App\Http\Controllers;

use App\Pago;
use App\User;
use Illuminate\Http\Request;

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
        

        // echo "holas";
        return view('panel.inicio')->with(compact('socios', 'usuario', 'pagos'));
    }
}
