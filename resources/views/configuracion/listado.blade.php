@extends('layouts.app')

@section('css')
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet">
@endsection

@section('content')

	{{-- modal formulario --}}
	<div class="modal fade" id="modalCategoria" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Formulario Categorias</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<i aria-hidden="true" class="ki ki-close"></i>
					</button>
				</div>
				<div class="modal-body">
					<form action="{{ url('Configuracion/guarda') }}" method="POST" id="formularioCategorias">
						@csrf
						<div class="row">

							<div class="col-md-6">
								<div class="form-group">
									<input type="text" name="configuracion_id" id="configuracion_id" value="0"/>
									<label for="exampleSelect1">Nombre <span class="text-danger">*</span></label>
									<input type="text" class="form-control" id="nombre" name="nombre" disabled>
								</div>        
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputPassword1">Descripcion
										<span class="text-danger">*</span></label>
									<input type="text" class="form-control" id="descripcion" name="descripcion" required />
								</div>
							</div>
							
						</div>
					
						<div class="row">
							<div class="col-md-6">
								<button type="button" class="btn btn-success mr-2 btn-block" onclick="guardaCategoria();">Guardar</button>
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
				<h3 class="card-label">Configuraciones
				</h3>
			</div>
			<div class="card-toolbar">
				<!--begin::Button-->
				{{-- <a onclick="nuevoCategoria()" class="btn btn-primary font-weight-bolder">
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
					</span>Nuevo Categoria</a>
				<!--end::Button--> --}}
			</div>
		</div>
		<div class="card-body">
			<!--begin: Datatable-->
			<div class="table-responsive m-t-40">
				<table class="table table-bordered table-hover table-striped" id="tabla_categorias">
					<thead>
						<tr>
							<th>ID</th>
							<th>Descripcion</th>
							<th>Valor</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($configuraciones as $con)
							<tr>
								<td>{{ $con->id }}</td>
								<td>{{ $con->descripcion }}</td>
								<td>{{ $con->valor }}</td>
								<td>
									<button class="btn btn-warning" onclick="editar('{{ $con->id }}', '{{ $con->descripcion }}', '{{ $con->valor }}')"><i class="fa fa-edit"></i></button>
									{{-- <button class="btn btn-danger" onclick="elimina('{{ $con->id }}', '{{ $con->nombre }}')"><i class="fa fa-trash"></i></button> --}}
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
			<!--end: Datatable-->
		</div>
	</div>
	<!--end::Card-->
@stop

@section('js')
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
	<script type="text/javascript">
		$(function () {
			$('#tabla_categorias').DataTable({
				language: {
					url: '{{ asset('datatableEs.json') }}',
				},
				order: [[ 0, "desc" ]]
			});

		});

		function nuevoCategoria(){
			$('#modalCategoria').modal('show');
		}

		function guardaCategoria(){
			if ($("#formularioCategorias")[0].checkValidity()) {
				$("#formularioCategorias").submit();
				Swal.fire("Excelente!", "Se guardo el distrito!", "success");
			}else{
				$("#formularioCategorias")[0].reportValidity();
			}
		}
		
		function editar(id, nombre, descripcion){
			$('#configuracion_id').val(id);
			$('#nombre').val(nombre);
			$('#descripcion').val(descripcion);

			$('#modalCategoria').modal('show');
		}

		function elimina(id,nombre){
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

                    window.location.href = "{{ url('Configuracion/elimina') }}/"+id;

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