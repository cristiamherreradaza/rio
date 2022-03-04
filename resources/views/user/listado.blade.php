@extends('layouts.app')

@section('css')
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet">
@endsection

@section('metadatos')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('content')

	{{-- modal formulario --}}
	<div class="modal fade" id="modalQuitapendiente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title text-info" id="exampleModalLabelnombre">Formulario Categorias</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<i aria-hidden="true" class="ki ki-close"></i>
					</button>
				</div>
				<div class="modal-body">
					<form action="{{ url('Medico/quitaPendiente') }}" method="POST" id="formularioCategorias">
						@csrf
						<div class="row">

							<div class="col-md-3">
								<div class="form-group">
									<input type="text" name="user_id" id="user_id" value="0"/>
									<label for="exampleSelect1">Categoria <span class="text-danger">*</span></label>
									<select class="form-control" id="categoria_id" name="categoria_id" required >
										<option value="">Seleccione</option>
										@foreach ($categorias as $c)
											<option value="{{ $c->id }}">{{ $c->nombre }}</option>
										@endforeach
									</select>
									</div>        
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="exampleSelect1">Mes <span class="text-danger">*</span></label>
									<select class="form-control" id="mes" name="mes" required >
										<option value="1" {{ (date('m') == 1)? "selected": ""}}>Enero</option>
										<option value="2" {{ (date('m') == 2)? "selected": ""}}>Febrero</option>
										<option value="3" {{ (date('m') == 3)? "selected": ""}}>Marzo</option>
										<option value="4" {{ (date('m') == 4)? "selected": ""}}>Abril</option>
										<option value="5" {{ (date('m') == 5)? "selected": ""}}>Mayo</option>
										<option value="6" {{ (date('m') == 6)? "selected": ""}}>Junio</option>
										<option value="7" {{ (date('m') == 7)? "selected": ""}}>Julio</option>
										<option value="8" {{ (date('m') == 8)? "selected": ""}}>Agosto</option>
										<option value="9" {{ (date('m') == 9)? "selected": ""}}>Septiembre</option>
										<option value="10" {{ (date('m') == 10)? "selected": ""}}>Octubre</option>
										<option value="11" {{ (date('m') == 11)? "selected": ""}}>Noviembre</option>
										<option value="12" {{ (date('m') == 12)? "selected": ""}}>Diciembre</option>
									</select>
								</div>        
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="exampleSelect1">Gestion <span class="text-danger">*</span></label>
									<input type="number" class="form-control" id="gestion" name="gestion" value="{{ date('Y') }}">
								</div>        
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="exampleSelect1">Importe <span class="text-danger">*</span></label>
									<input type="number" class="form-control" id="importe" name="importe"  value="{{ $importe->valor }}">
								</div>        
							</div>
						</div>
						<div class="row">
							<button class="btn btn-success btn-block">GUARDAR</button>
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
				<h3 class="card-label">Socios
				</h3>
			</div>
			<div class="card-toolbar">
				<!--begin::Button-->
				<a href="{{ url('User/nuevo') }}" class="btn btn-primary font-weight-bolder">
					<i class="fas fa-plus-square"></i> Socio</a>
					&nbsp;
				<a href="#" class="btn btn-success font-weight-bolder" onclick="muestraBarra();">
					<i class="fas fa-search"></i> </a>
				<!--end::Button-->
			</div>
		</div>
		<div class="card-body">
			<div id="barra-busqueda" style="display: none">
				<div class="row">
					<div class="col-md-2">
						<div class="form-group">
							<label for="exampleInputPassword1">Nombre
								<span class="text-danger">*</span></label>
							<input type="text" class="form-control" id="nombre" name="nombre" />
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<label for="exampleInputPassword1">Carnet
								<span class="text-danger">*</span></label>
							<input type="text" class="form-control" id="carnet" name="carnet" />
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<label for="exampleInputPassword1">Email
								<span class="text-danger">*</span></label>
							<input type="text" class="form-control" id="email" name="email" />
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<label for="exampleInputPassword1">Celular
								<span class="text-danger">*</span></label>
							<input type="text" class="form-control" id="celular" name="celular" />
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<label for="exampleInputPassword1">Colegiatura
								<span class="text-danger">*</span></label>
							<input type="text" class="form-control" id="colegiatura" name="colegiatura" />
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<p style="margin-top: 24px"></p>
							<button class="btn btn-success btn-block"  onclick="buscar()"><i class="fa fa-search"></i>Buscar</button>
						</div>
					</div>
				</div>
			</div>
			<!--begin: Datatable-->
			<div id="tabla-usuarios">

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

			buscar();
			// $(function () {
			// 	$('#tabla_usuarios').DataTable({
			// 		language: {
			// 			url: '{{ asset('datatableEs.json') }}',
			// 		},
			// 		order: [[ 0, "desc" ]]
			// 	});

			// });
			
    	    // $('#tabla_usuarios').DataTable({
			// 	iDisplayLength: 10,
			// 	processing: true,
			// 	serverSide: true,
			// 	ajax: "{{ url('User/ajax_listado') }}",
			// 	"order": [[ 0, "desc" ]],
			// 	columns: [
			// 		{data: 'id', name: 'id'},
			// 		{data: 'name', name: 'name'},
			// 		{data: 'ci', name: 'ci'},
			// 		{data: 'email', name: 'email'},
			// 		{data: 'perfil', name: 'perfil'},
			// 		{data: 'celulares', name: 'celulares'},
			// 		{data: 'action'},
			// 	],
            //     language: {
            //         url: '{{ asset('datatableEs.json') }}'
            //     }
            // });
    	} );

		function edita(id)
		{
			window.location.href = "{{ url('User/edita') }}/"+id;
		}

		function cuotas(id)
		{
			window.location.href = "{{ url('User/pagos') }}/"+id;
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

                    window.location.href = "{{ url('User/elimina') }}/"+id;

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

		function buscar(){

			var this_item = document.getElementById('barra-busqueda');
			this_item.style.display = 'none';

			var nombre		 = $('#nombre').val();
			var carnet		 = $('#carnet').val();
			var email		 = $('#email').val();
			var celular		 = $('#celular').val();
			var colegiatura	 = $('#colegiatura').val();

			$.ajax({
                url: "{{ url('User/ajax_busca') }}",
                data: {
					nombre: nombre,
					carnet: carnet,
					email: email,
					celular: celular,
					colegiatura: colegiatura
				},
                type: 'POST',
                success: function(data) {
                    $("#tabla-usuarios").html(data);
                    // $("#listadoProductosAjax").html(data);
                }
            });
		}

		function muestraBarra(){
			var this_item = document.getElementById('barra-busqueda'); 
			if( this_item.style.display == 'block' ) {
				this_item.style.display = 'none';
			}
			else {
				this_item.style.display = 'block';
			}
		}

		function quitaPendiente(nombre, id){
			$('#exampleModalLabelnombre').text(nombre);
			$('#user_id').val(id);
			$('#modalQuitapendiente').modal('show');
		}
    </script>
@endsection