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
					<form action="{{ url('Categoria/guarda') }}" method="POST" id="formularioCategorias">
						@csrf
						<div class="row">

							<div class="col-md-12">
								<div class="form-group">
									<input type="hidden" name="categoria_id" id="categoria_id" value="0"/>
									<label for="exampleSelect1">Nombre <span class="text-danger">*</span></label>
									<input type="text" class="form-control" id="nombre" name="nombre">
								</div>        
							</div>

							{{-- <div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputPassword1">Estado
										<span class="text-danger">*</span></label>
									<input type="text" class="form-control" id="estado" name="estado" required />
								</div>
							</div> --}}
							
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
				<h3 class="card-label">Recibos Generados
				</h3>
			</div>
			<div class="card-toolbar">
			</div>
		</div>
		<div class="card-body">
			<!--begin: Datatable-->
			<table class="table table-bordered table-hover table-striped" id="tabla_categorias">
				<thead>
					<tr>
						<th>ID</th>
						<th>Carnet</th>
						<th>fecha</th>
						<th>Monto</th>
						<th>Numero de Recibo</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($recibos as $re)
						<tr>
							<td>{{ $re->id }}</td>
							<td>{{ $re->carnet }}</td>
							<td>{{ $re->fecha }}</td>
							<td>{{ $re->total }}</td>
							<td>{{ $re->numero_recibo }}</td>
							<td>
                                <a href='{{ url("User/reciboPdf", [$re->id, $re->persona_id]) }}' class="btn btn-icon btn-primary">
                                    <i class="fas fa-file-invoice"></i>
                                </a>
								{{-- <button class="btn btn-icon btn-warning" onclick="editar('{{ $re->id }}', '{{ $re->nombre }}', '{{ $re->estado }}')"><i class="fa fa-edit"></i></button>
								<button class="btn btn-icon btn-danger" onclick="elimina('{{ $re->id }}', '{{ $re->nombre }}')"><i class="fa fa-trash"></i></button> --}}
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
	<script type="text/javascript">
		$(function () {
			$('#tabla_categorias').DataTable({
				language: {
					url: '{{ asset('datatableEs.json') }}',
				},
				responsive: true,
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
		
		function editar(id, nombre, estado){
			$('#categoria_id').val(id);
			$('#nombre').val(nombre);
			$('#estado').val(estado);

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

                    window.location.href = "{{ url('Categoria/elimina') }}/"+id;

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