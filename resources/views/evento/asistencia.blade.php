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
                    <h5 class="modal-title" id="exampleModalLabel">Formulario Distrito</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('Sector/guarda') }}" method="POST" id="formularioDistritos">
                        @csrf
                        <div class="row">

                            <div class="col-md-5">
                                <div class="form-group">
                                    <input type="hidden" name="id" id="id" />
                                    <label for="exampleSelect1">Ciudad <span class="text-danger">*</span></label>
                                    <select class="form-control" id="departamento" name="departamento">
                                        <option value="La Paz">La Paz</option>
                                        <option value="Cochabamba">Cochabamba</option>
                                        <option value="Santa Cruz">Santa Cruz</option>
                                        <option value="Oruro">Oruro</option>
                                        <option value="Tarija">Tarija</option>
                                        <option value="Sucre">Sucre</option>
                                        <option value="Potosi">Potosi</option>
                                        <option value="Beni">Beni</option>
                                        <option value="Pando">Pandoa</option>
                                    </select>
                                </div>        
                            </div>

                            <div class="col-md-7">
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
                <h3 class="card-label text-primary">
                    Evento: <span class="text-secondary">{{ $datosEvento->nombre }}</span>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    Fecha: <span class="text-secondary">{{ $datosEvento->fecha_inicio }}</span>
                </h3>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ url('Evento/marcarAsistencia') }}" method="POST" id="formularioMarcaAsistencia">
                <input type="hidden" name="evento_id" id="evento_id" value="{{ $datosEvento->id }}">
                @csrf
                <!--begin: Datatable-->
                <div class="table-responsive m-t-40">
                    <table class="table table-bordered table-hover table-striped" id="tabla_usuarios">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Carnet</th>
                                <th>Email</th>
                                <th>Categoria</th>
                                <th>Estado</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($doctores as $d)
                            @php
                                $asistencia = App\Asistencia::where('evento_id', $datosEvento->id)
                                                ->where('user_id', $d->id)
                                                ->first();
                                                // ->count();
                                                
                                // if($asistencia > 0){
                                if($asistencia){
                                    if($asistencia->estado == 'Asistio'){
                                        $estado = '<a href="#" class="btn btn-light-success font-weight-bold mr-2">Asistio</a>';
                                        $texto = '<span class="text-success">Asistio</span>';
                                    }else{
                                        $estado = '<a href="#" class="btn btn-light-danger font-weight-bold mr-2">Falto</a>';
                                        $texto = '<span class="text-danger">Falto</span>';
                                        $verify = 'checked disabled';
                                    }
                                }else{
                                    $estado = '<a href="#" class="btn btn-light-danger font-weight-bold mr-2">Falto</a>';
                                    $texto = '<span class="text-danger">Falto</span>';
                                    $verify = 'checked disabled';
                                }
                            @endphp     
                            <tr>
                                <td>{{ $d->id }}</td>
                                <td>{{ $d->name }}</td>
                                <td>{{ $d->ci }}</td>
                                <td>{{ $d->email }}</td>
                                <td>{{ $d->categoria->nombre }}</td>
                                <td>{!! $estado !!}</td>
                                <td nowrap="nowrap">
                                    <div class="form-group">
                                        @if($asistencia)
                                            @if ($asistencia->estado == 'Falto')
                                                <div class="checkbox-inline">
                                                    <label class="checkbox checkbox-lg checkbox-success">
                                                            <input type="checkbox" name="select[{{ $d->id }}]"/>
                                                        <span></span>
                                                    </label>
                                                </div>
                                            @endif
                                        @else
                                            <div class="checkbox-inline">
                                                <label class="checkbox checkbox-lg checkbox-success">
                                                        <input type="checkbox" name="select[{{ $d->id }}]"/>
                                                    <span></span>
                                                </label>
                                            </div>
                                        @endif
                                        {!! $texto !!}
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!--end: Datatable-->
                <div class="row">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-success btn-block" onclick="marcarAsistencia()"><i class="fa fa-list"></i>GUARDAR</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
									<!--end::Card-->
@stop

@section('js')
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script type="text/javascript">
    	$(document).ready(function() {
    	    $('#tabla_usuarios').DataTable({
                language: {
                    url: '{{ asset('datatableEs.json') }}'
                },
                order: [[ 0, "desc" ]]
            });
    	} );

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

        function marcarAsistencia(){
            var c = () => Array.from(document.getElementsByTagName("INPUT")).filter(cur => cur.type === 'checkbox' && cur.checked).length > 0;

            // Acciones a realizar

            if(!c()) { // Si NO hay ningun checkbox chequeado.
                // console.log("Ningún chequeado..");
                Swal.fire(
                    "Error",
                    "Debe Cancelar al menos una cuota",
                    "error"
                )
            } else {
                // console.log("Al menos uno chequeado..");

                $("#formularioMarcaAsistencia").submit();
            }

        }

    </script>


@endsection