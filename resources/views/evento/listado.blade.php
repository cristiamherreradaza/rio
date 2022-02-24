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
					</span>Nuevo Evento</a>
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
			<div class="table-responsive m-t-40">
				<div id="tabla-eventos">

				</div>
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