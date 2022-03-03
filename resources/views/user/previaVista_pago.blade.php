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
            <div class="row">
                <div class="col-md-12">
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
                            <td>1</td>
                            <td>Pago de Mensualidad de {{ $pagos->mes }}</td>
                            <td>{{ $pagos->monto }}</td>
                        </tr>
                        @empty
                            
                        @endforelse
                        @php
                            $utilidades = new App\librerias\NumeroALetras();
                            $literal = $utilidades->toMoney($contador);
                        @endphp
                        <tr>
                            <th colspan="2">Son: {{ $literal }} 00/100 Bolivianos</th>
                            <th>{{ number_format($contador, 2) }}</th>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <button class="btn btn-dark btn-block"><i class=""></i>Cancelar</button>
                </div>
                <div class="col-md-6">
                    <button class="btn btn-success btn-block"><i class=""></i>Guardar</button>
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

        function asiste(user_id, evento_id)
        {
            window.location.href = "{{ url('Evento/asiste') }}/"+user_id+"/"+evento_id;
        }

        function falta(user_id, evento_id)
        {
            window.location.href = "{{ url('Evento/falta') }}/"+user_id+"/"+evento_id;
        }

        function elimina(id, departamento, nombre)
        {
            Swal.fire({
                title: "Quieres eliminar "+nombre+" de "+departamento+"?",
                text: "Ya no podras recuperarlo!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, borrar!",
                cancelButtonText: "No, cancelar!",
                reverseButtons: true
            }).then(function(result) {
                if (result.value) {

                    window.location.href = "{{ url('Sector/elimina') }}/"+id;

                    Swal.fire(
                        "Borrado!",
                        "El registro fue eliminado.",
                        "success"
                    )
                    // result.dismiss can be "cancel", "overlay",
                    // "close", and "timer"
                } else if (result.dismiss === "cancel") {
                    Swal.fire(
                        "Cancelado",
                        "La operacion fue cancelada",
                        "error"
                    )
                }
            });
        }

        function cambiaPago(id , estado)
        {
            window.location.href = "{{ url('User/cambiaPago') }}/"+id+"/"+estado;
        }

        function pagar(){
            $("#formularioPersona").submit();
            window.location.href = "{{ url('User/listado')}}"
        }
    </script>
@endsection