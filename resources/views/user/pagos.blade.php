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
                    Doctor: <span class="text-secondary">{{ $datosUsuario->name }}</span>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    CI: <span class="text-secondary">{{ $datosUsuario->ci }}</span>
                </h3>
            </div>
        </div>
        <div class="card-body">
            <form target="_blank" action="{{ url('User/guarda_pago') }}" method="POST" id="formularioPersona">
                @csrf
                <input type="hidden" value="{{ $datosUsuario->id }}" name="user_id">
                <!--begin: Datatable-->
                <div class="table-responsive m-t-40">
                    <table class="table table-bordered table-hover table-striped" id="tabla_pagos">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Gestion</th>
                                <th>Mes</th>
                                <th>Monto</th>
                                <th>Fecha Pago</th>
                                <th>Estado</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pagos as $p)
                            @php
                                $verify = '';
                                if($p->estado == 'Debe'){
                                    $estado = '<a href="#" class="btn btn-light-danger font-weight-bold mr-2">Debe</a>';
                                }else{
                                    $estado = '<a href="#" class="btn btn-light-success font-weight-bold mr-2">Pagado</a>';
                                    $verify = 'checked disabled';
                                }
                            @endphp     
                            <tr>
                                <td>{{ $p->id }}</td>
                                <td>{{ $p->gestion }}</td>
                                <td>{{ $p->mes }}</td>
                                <td>{{ $p->monto }}</td>
                                <td>{{ $p->fecha_pago }}</td>
                                <td>{!! $estado !!}</td>
                                <td nowrap="nowrap">
                                    <div class="form-group row">
                                        <label class="col-3 col-form-label text-danger">Debe</label>
                                        <div class="col-3">
                                            <span class="switch switch-primary">
                                                <label>
                                                <input type="checkbox" {{ $verify }} name="select[{{ $p->id }}]"/>
                                                <span></span>
                                                </label>
                                            </span>
                                        </div>
                                        <label class="col-3 col-form-label text-success">Pago</label>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Gestion</th>
                                <th>Mes</th>
                                <th>Monto</th>
                                <th>Fecha Pago</th>
                                <th>Estado</th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <!--end: Datatable-->
                <div class="row">
                    <div class="col-md-12">
                        <button type="button" onclick="pagar()" class="btn btn-block btn-success"><i class="fa fa-money-check"></i> PAGAR</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
									<!--end::Card-->
@stop

@section('js')
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    {{-- <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script> --}}
    <script type="text/javascript">


        $(document).ready(function () {

            $('#tabla_pagos thead th').each(function () {
                var title = $(this).text();
                $(this).html('<input type="text" class="form-control" placeholder="Buscar ' + title + '" />');
            });

            var table = $('#tabla_pagos').DataTable({
                language: {
                    url: '{{ asset('datatableEs.json') }}'
                },
                initComplete: function () {
                    // Apply the search
                    this.api().columns().every(function () {
                        var that = this;

                        $('input', this.footer()).on('keyup change clear', function () {
                            if (that.search() !== this.value) {
                                that
                                    .search(this.value)
                                    .draw();
                            }
                        });
                    });
                }
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