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
				<h3 class="card-label">Usuarios
				</h3>
			</div>
			<div class="card-toolbar">
                <!--begin::Button-->
				<a href="{{ url('User/nuevoAdmin/0') }}" class="btn btn-primary font-weight-bolder">
					<i class="fas fa-plus-square"></i> Usuario</a>
					&nbsp;
				<a href="#" class="btn btn-success font-weight-bolder" onclick="muestraBarra();">
					<i class="fas fa-search"></i> </a>
				<!--end::Button-->
			</div>
		</div>
		<div class="card-body">
            <div id="barra-busqueda" style="display: none">
                <div class="row">
                    <div class="col-md-3">
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
                    <div class="col-md-3">
                        <div class="form-group">
                            <p style="margin-top: 24px"></p>
                            <button class="btn btn-success btn-block"  onclick="buscar()"><i class="fa fa-search"></i>Buscar</button>
                        </div>
                    </div>
                </div>
            </div>
			<!--begin: Datatable-->
			{{-- <div class="table-responsive m-t-40"> --}}
                <div id="tablaAdmin">

                </div>
			{{-- </div> --}}
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

        buscar();

        function edita(id)
		{
			window.location.href = "{{ url('User/nuevoAdmin') }}/"+id;
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

                    window.location.href = "{{ url('User/eliminaAdmin') }}/"+id;

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

            var nombre		 = $('#nombre').val();
            var carnet		 = $('#carnet').val();
            var email		 = $('#email').val();
            var celular		 = $('#celular').val();

            $.ajax({
                url: "{{ url('User/ajax_buscaAdmin') }}",
                data: {
                    nombre: nombre,
                    carnet: carnet,
                    email: email,
                    celular: celular
                },
                type: 'POST',
                success: function(data) {
                    $("#tablaAdmin").html(data);
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
    </script>
@endsection