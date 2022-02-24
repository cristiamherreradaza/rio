<?php

namespace App\Http\Controllers;
use PDF;
use App\Pago;
use App\User;
use App\Recibo;
use App\Sector;
use DataTables;
use App\Categoria;
// use Barryvdh\DomPDF\PDF;
use App\Configuracion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function listado()
    {
        return view('user.listado');
    }

    public function ajax_listado()
    {
        $usuarios = User::all();
        return Datatables::of($usuarios)
                ->addColumn('action', function($usuarios){
                    if($usuarios->id != 1){
                        return '<a href="#" class="btn btn-icon btn-warning btn-sm mr-2" onclick="edita('.$usuarios->id.')">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="#" class="btn btn-icon btn-success btn-sm mr-2" onclick="cuotas('.$usuarios->id.')">
                                    <i class="fas fa-list-alt"></i>
                                </a>
                                <a href="#" class="btn btn-icon btn-danger btn-sm mr-2" onclick="elimina('.$usuarios->id.', \''.$usuarios->name.'\')">
                                    <i class="flaticon2-delete"></i>
                                </a>';

                    }
                })->make(true);
    }

    public function nuevo()
    {
        $categorias = Categoria::all();

        $importe = Configuracion::find(2);

        return view('user.nuevo')->with(compact('categorias', 'importe'));        			
    }

    public function ajaxDistrito(Request $request)
    {
        $distritos = Sector::where('departamento', $request->departamento)
                        ->whereNull('padre_id')
                        ->get();
        
        return view('user.ajaxDistritos')->with(compact('distritos'));                   
    }

    public function ajaxOtb(Request $request)
    {
        $otbs = Sector::where('padre_id', $request->distrito)
                        ->get();

        return view('user.ajaxOtb')->with(compact('otbs'));                   
    }

    public function guarda(Request $request)
    {
        // dd($request->all());

        if($request->has('id')){
            $persona = User::find($request->id);
        }else{
            $persona = new User();
        }

        $persona->categoria_id     = $request->categoria_id;
        $persona->name             = $request->nombre;
        $persona->ci               = $request->ci;
        $persona->colegiatura      = $request->colegiatura;
        $persona->email            = $request->email;
        if($request->has('password')){
            $persona->password         = Hash::make($request->password);
        }
        $persona->fecha_nacimiento = $request->fecha_nacimiento;
        $persona->direccion        = $request->direccion;
        $persona->celulares        = $request->celulares;
        $persona->perfil           = "Doctor";
        $persona->save();
        $personaId = $persona->id;

        if(!$request->has('id')){
            $meses = ['Mes', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

            for ($i = $request->mes; $i <= 12; $i++) {
                $pagos = new Pago();
                $pagos->user_id = $personaId;
                $pagos->monto = $request->importe;
                $pagos->nmes = $i;
                $pagos->mes = $meses[$i];
                $pagos->gestion = $request->gestion;
                $pagos->fecha_pago = date('Y-m-d H:i:s');
                $pagos->estado = 'Debe';
                $pagos->save();
            }
        }

        return redirect('User/listado');
    }

    public function elimina(Request $request)
    {
        User::destroy($request->id);
        return redirect('User/listado');

    }

    public function edita(Request $request, $id)
    {
        $datosUsuario = User::findOrFail($id);
        $categorias = Categoria::all();
        return view('user.edita')->with(compact('datosUsuario', 'categorias'));                   
    }

    public function pagos(Request $request, $user_id)
    {
        $pagos = Pago::where('user_id', $user_id)
                    ->get();

        $datosUsuario = User::find($user_id);

        return view('user.pagos')->with(compact('pagos', 'datosUsuario'));                 
    }

    public function cambiaPago(Request $request, $id, $estado)
    {
        $datosPago = Pago::find($id);

        if($estado == 'Pagar'){
            $pago = Pago::where('id', $id)
                        ->update(['estado'=>'Pagado']);
        }else{
            $pago = Pago::where('id', $id)
                        ->update(['estado'=>'Debe']);
        }

        $pagos = Pago::where('user_id', $datosPago->user_id)
                    ->get();

        $datosUsuario = User::find($datosPago->user_id);

        return view('user.pagos')->with(compact('pagos', 'datosUsuario'));                 

    }

    public function ajax_busca(Request $request){
        // dd($request->input('nombre'));
        $query = User::orderBy('id', 'desc');

        if ($request->filled('nombre')) {
            $nombre = $request->input('nombre');
            $query->where('name', 'like', "%$nombre%");
        }

        if ($request->filled('carnet')) {
            $carnet = $request->input('carnet');
            $query->where('ci', $carnet);
        }

        if ($request->filled('email')) {
            $email = $request->input('email');
            $query->where('email', $email);
        }

        if ($request->filled('celular')) {
            $celular = $request->input('celular');
            $query->where('celulares', $celular);
        }

        if ($request->filled('colegiatura')) {
            $colegiatura = $request->input('colegiatura');
            $query->where('colegiatura', $colegiatura);
        }

        if ($request->filled('nombre') || $request->filled('carnet') || $request->filled('email') || $request->filled('celular') || $request->filled('colegiatura')) {
            $query->limit(300);
        }else{
            $query->limit(200);
        }

        
        $usuarios = $query->get();
        
        return view('user.ajax_busca')->with(compact('usuarios'));
    }

    public function guarda_pago(Request $request){

        $user_id = $request->input('user_id');

        $idsPagos = array_keys($request->select);

        $total = 0 ;

        foreach($idsPagos as $ids){
            // echo $ids.'<br>';
            $pago =  Pago::find($ids);

            $pago->estado =  "Pagado";

            $total = $total + $pago->monto ;

            $pago->save();
        }

        $recibo = new Recibo();

        $persona = User::find($user_id);

        $recibo->user_id        = Auth::user()->id;
        $recibo->persona_id     = $persona->id;
        $recibo->carnet         = $persona->ci;
        $recibo->fecha          = date('Y-m-d');
        $recibo->total          = $total;

        $ultimo = DB::table('recibos')->latest()->first();

        if($ultimo){
            $numero = $ultimo->numero + 1 ;
        }else{
            $numero = 1;
        }

        // dd($numero);

        $recibo->numero               = $numero;
        $recibo->numero_recibo        = strval($numero."/".date('Y'));
        $recibo->anio                 = date('Y');

        $recibo->save();

        foreach($idsPagos as $ids){

            $pago =  Pago::find($ids);

            $pago->recibo_id = $recibo->id;

            $pago->save();
        }

        $reciboFin = $recibo;
        $usuario = User::find($user_id);

        $pdf = PDF::loadView('user.reciboPdf', compact('reciboFin', 'usuario'));
        $pdf->setPaper('letter', 'portrait');

        // download PDF file with download method
        return $pdf->stream('recibo.pdf');

    }  
    
    public function listadoAdmin(Request $request){
        $users = User::whereNull('categoria_id')->get();

        return view('user.listadoAdmin')->with(compact('users'));
    }

    public function nuevoAdmin(Request $request, $user_id){

        if($user_id == 0){
            $usuario =  null;
        }else{
            $usuario =  User::find($user_id);
        }

        $categorias = Categoria::all();

        return view('user.nuevoAdmin')->with(compact('categorias','usuario'));      
    }

    public function guardaAdmin(Request $request){

        // dd($request->all());

        if($request->user_id != 0 ){
            $persona = User::find($request->user_id);
        }else{
            $persona = new User();
        }

        // dd($persona);

        $persona->perfil           = $request->perfil;
        $persona->name             = $request->nombre;
        $persona->ci               = $request->ci;
        $persona->email            = $request->email;
        if($request->has('password')){
            $persona->password         = Hash::make($request->password);
        }
        $persona->fecha_nacimiento = $request->fecha_nacimiento;
        $persona->direccion        = $request->direccion;
        $persona->celulares        = $request->celulares;
        $persona->save();

        return redirect('User/listadoAdmin');
    }

    public function eliminaAdmin(Request $request, $user_id){
     
        User::destroy($user_id);
        return redirect('User/listadoAdmin');
   
    }

    public function validaEmail(Request $request)
    {
        // dd($request->all());
        $verificaEmail = User::where('email', $request->email)
                            ->count();

        return response()->json(['vEmail'=>$verificaEmail]);
    }
}
