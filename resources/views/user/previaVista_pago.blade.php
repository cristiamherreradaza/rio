@extends('layouts.app')

@section('css')
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet">
@endsection

@section('content')
	<!--begin::Card-->
	<div class="card card-custom gutter-b">

        <div class="card-header flex-wrap py-3">
            <div class="card-title">
                <h3 class="card-label text-primary">
                    RECIBO PREVIA VISTA
                </h3>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <img src="{{ asset("img/logo.png") }}" width="30%" alt=" aqui la imagen">
                </div>
                <div class="col-md-4">
                    @php
                        $descripcion = App\Configuracion::find(1);
                        if($descripcion){
                            echo $descripcion->valor;
                        }else{
                            echo 'aqui deberia ir la descripcion del recibo en configuraciones';
                        }
                    @endphp
                </div>
                <div class="col-md-4">

                </div>
            </div>
            @php
                $usuario =  App\User::find($user_id);

                $utilidades = new App\librerias\Utilidades();
                $fechas = date('Y-m-d');
                $fecha = $utilidades->fechaCastellano($fechas);
            @endphp
            <div class="row">
                <div class="col-md-6">
                    <b> Doctor: </b><h6 class="text-info">{{ $usuario->name }}</h6>
                </div>
                <div class="col-md-6">
                    <b> Fecha: </b><h6 class="text-info">{{ $fecha }}</h6>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <form target="_blank" action="{{ url('User/guarda_pago') }}" method="POST" id="formularioPersona">
                        @csrf
                        <input type="hidden" value="{{ $user_id }}" name="user_id">
                        <table class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>Cantidad</th>
                                    <th>Descripcion</th>
                                    <th>Sub Total</th>
                                </tr>
                            </thead>
                            @php
                                $contador = 0;
                            @endphp
                            @forelse ($idsPagos as $id)
                            @php
                                $pagos = App\Pago::find($id);
                                $contador = $contador + $pagos->monto;
                            @endphp
                            <tr>
                                <td class="text-center">1 <input type="hidden" value="{{ $pagos->id }}" name="select[{{ $pagos->id }}]"> </td>
                                <td>Pago de Mensualidad de {{ $pagos->mes }}</td>
                                <td class="text-right" >{{ $pagos->monto }}</td>
                            </tr>
                            @empty
                                
                            @endforelse
                            @php
                                $utilidades = new App\librerias\NumeroALetras();
                                $literal = $utilidades->toMoney($contador);
                            @endphp
                            <tr>
                                <th colspan="2">Son: {{ $literal }} 00/100 Bolivianos</th>
                                <th class="text-right">{{ number_format($contador, 2) }}</th>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <button class="btn btn-dark btn-block"><i class=""></i> Cancelar</button>
                </div>
                <div class="col-md-6">
                    <button class="btn btn-success btn-block" onclick="generaRecibo()"><i class="fas fa-receipt"></i> Generar Recibo</button>
                </div>
            </div>
        </div>
    </div>
									<!--end::Card-->
@stop

@section('js')
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    {{-- <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script> --}}
    <script type="text/javascript">


        $(document).ready(function () {

            var table = $('#tabla_pagos').DataTable({
                language: {
                    url: '{{ asset('datatableEs.json') }}'
                },
                responsive: true,                
            });

        });

        function generaRecibo(){
            $("#formularioPersona").submit();
            
            window.location.href = "{{ url('User/listado')}}"
        }
    </script>
@endsection