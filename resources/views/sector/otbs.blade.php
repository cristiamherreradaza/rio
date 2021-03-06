@extends('layouts.app')

@section('css')
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet">
@endsection

@section('content')

    {{-- modal formulario --}}
    <div class="modal fade" id="modalDistrito" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Formulario Otb</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('Sector/guardaOtb') }}" method="POST" id="formularioOtbs">
                        @csrf
                        <div class="row">

                            <div class="col-md-5">
                                <div class="form-group">
                                    <input type="hidden" name="id" id="id" />
                                    <input type="hidden" name="ciudad" id="ciudad" value="{{ $distrito->departamento }}" />
                                    <input type="hidden" name="padre_id" id="padre_id" value="{{ $distrito->id }}" />
                                    <label for="exampleSelect1">Ciudad </label>
                                    <input type="text" class="form-control" id="ciudad" name="ciudad" value="{{ $distrito->departamento }}" disabled />
                                </div>        
                            </div>

                            <div class="col-md-7">
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Distrito
                                        </label>
                                    <input type="text" class="form-control" id="distrito" name="distrito" value="{{ $distrito->nombre }}" disabled />
                                </div>
                            </div>
                            
                        </div>

                        <div class="row">
                        
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Nombre
                                        <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" required />
                                </div>
                            </div>
                        
                        </div>
                    
                        <div class="row">
                            <div class="col-md-6">
                                <button type="button" class="btn btn-success mr-2 btn-block" onclick="guarda();">Guardar</button>
                            </div>
                            <div class="col-md-6">
                                <button type="reset" class="btn btn-secondary btn-block" data-dismiss="modal">Cancelar</button>
                            </div>
                        </div>

                    </form>
                </div>
                
            </div>
        </div>
    </div>
    {{-- fin modal formulario --}}

	<!--begin::Card-->
	<div class="card card-custom gutter-b">
        <div class="card-header flex-wrap py-3">
            <div class="card-title">
                <h3 class="card-label">OTBS - {{ $distrito->nombre }}
                </h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Button-->
                <a href="#" class="btn btn-primary font-weight-bolder" onclick="nuevaOtb();">
                    <span class="svg-icon svg-icon-md">
                        <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                            height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24" />
                                <circle fill="#000000" cx="9" cy="15" r="6" />
                                <path
                                    d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z"
                                    fill="#000000" opacity="0.3" />
                            </g>
                        </svg>
                        <!--end::Svg Icon-->
                    </span>Nueva Otb</a>
                <!--end::Button-->
            </div>
        </div>
        <div class="card-body">
            <!--begin: Datatable-->
            <table class="table table-bordered table-hover table-striped" id="tabla_usuarios">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Ciudad</th>
                        <th>nombre</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($otbs as $o)
                    <tr>
                        <td>{{ $o->id }}</td>
                        <td>{{ $o->departamento }}</td>
                        <td>{{ $o->nombre }}</td>
                        <td nowrap="nowrap">

                            <a href="#" class="btn btn-icon btn-warning btn-sm mr-2" onclick="edita('{{ $o->id }}', '{{ $o->departamento }}', '{{ $o->nombre }}')">
                                <i class="fas fa-edit"></i>
                            </a>
    
                            <a href="#" class="btn btn-icon btn-danger btn-sm mr-2" onclick="elimina('{{ $o->id }}', '{{ $o->departamento }}', '{{ $o->nombre }}')">
                                <i class="flaticon2-delete"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <!--end: Datatable-->
        </div>
    </div>
									<!--end::Card-->
@stop

@section('js')
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/pages/crud/datatables/basic/basic.js') }}"></script>
    <script type="text/javascript">
    	$(document).ready(function() {
    	    $('#tabla_usuarios').DataTable({
                language: {
                    url: '{{ asset('datatableEs.json') }}'
                },
                order: [[ 0, "desc" ]]
            });
    	} );

        function nuevaOtb()
        {
            $("#id").val("");
            $("#nombre").val("");

            $("#modalDistrito").modal('show');
        }

        function guarda()
        {
            if ($("#formularioOtbs")[0].checkValidity()) {

                $("#formularioOtbs").submit();
                Swal.fire("Excelente!", "Se guardo el distrito!", "success");

            }else{
                $("#formularioOtbs")[0].reportValidity();
            }
        }

        function edita(id, departamento, nombre)
        {
            $("#id").val(id);
            $("#departamento").val(departamento);
            $("#nombre").val(nombre);

            $("#modalDistrito").modal('show');

        }

        function elimina(id, departamento, nombre)
        {
            let distrito = '{{ $distrito->nombre }}';
            Swal.fire({
                title: "Quieres eliminar "+nombre+" del "+distrito+"?",
                text: "Ya no podras recuperarlo!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, borrar!",
                cancelButtonText: "No, cancelar!",
                reverseButtons: true
            }).then(function(result) {
                if (result.value) {

                    window.location.href = "{{ url('Sector/eliminaOtb') }}/"+id;

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

    </script>


@endsection