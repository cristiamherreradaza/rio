@extends('layouts.app')

@section('css')
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet">
@endsection
@section('metadatos')
	<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('content')
	<!--begin::Card-->
	<div class="card card-custom gutter-b">
		<div class="card-header flex-wrap py-3">
			<div class="card-title">
				<h3 class="card-label">Eventos
				</h3>
			</div>
			<div class="card-toolbar">
				<!--begin::Button-->
				<a href="{{ url('Evento/nuevo') }}" class="btn btn-primary font-weight-bolder">
					<i class="fas fa-plus-square"></i> Evento
				</a>
				<!--end::Button-->
			</div>
		</div>
		<div class="card-body">

			<div class="row">
				<div class="col-md-4">
					<label for="">Nombre</label>
					<input type="text" class="form-control" name="nombre" id="nombre">
				</div>

				<div class="col-md-4">
					<label for="">Fecha</label>
					<input type="date" class="form-control" name="fecha" id="fecha">
				</div>

				<div class="col-md-4">
					<p style="margin-top: 27px"></p>
					<button class="btn btn-success btn-block" onclick="buscarEvento()"><i class="fa fa-search"></i> Buscar</button>
				</div>
			</div>

			<!--begin: Datatable-->
			<div id="tabla-eventos">

			</div>
			<!--end: Datatable-->
		</div>

	</div>
	<!--end::Card-->
@stop

@section('js')
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script type="text/javascript">
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
    	$(document).ready(function() {
			buscarEvento();
    	    // $('#tabla_usuarios').DataTable({
			// 	iDisplayLength: 10,
			// 	processing: true,
			// 	serverSide: true,
			// 	ajax: "{{ url('Evento/ajax_listado') }}",
			// 	"order": [[ 0, "desc" ]],
			// 	columns: [
			// 		{data: 'id', name: 'id'},
			// 		{data: 'nombre', name: 'nombre'},
			// 		{data: 'invitacion', name: 'invitacion'},
			// 		{data: 'fecha_inicio', name: 'fecha_inicio'},
			// 		{data: 'fecha_fin', name: 'fecha_fin'},
			// 		{data: 'tipo', name: 'tipo'},
			// 		{data: 'action'},
			// 	],
            //     language: {
            //         url: '{{ asset('datatableEs.json') }}'
            //     }
            // });
    	} );

		function edita(id)
		{
			window.location.href = "{{ url('Evento/edita') }}/"+id;
		}

		function elimina(id, nombre)
        {
            Swal.fire({
                title: "Quieres eliminar "+nombre,
                text: "Ya no podras recuperarlo!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, borrar!",
                cancelButtonText: "No, cancelar!",
                reverseButtons: true

            }).then(function(result) {
                if (result.value) {

                    window.location.href = "{{ url('Evento/elimina') }}/"+id;

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

        function asistencia(id)
        {
        	window.location.href = "{{ url('Evento/asistencia') }}/"+id;
        }

		function buscarEvento(){
			var nombre =  $("#nombre").val();
			var fecha  =  $("#fecha").val();

			$.ajax({
                url: "{{ url('Evento/ajax_listado') }}",
                data: {
					nombre: nombre,
					fecha:  fecha
				},
                type: 'POST',
                success: function(data) {
                    $("#tabla-eventos").html(data);
                    // $("#listadoProductosAjax").html(data);
                }
            });
		}
    </script>
@endsection