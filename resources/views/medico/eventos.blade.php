@extends('layouts.app')

@section('css')
<link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet">
@endsection
@section('metadatos')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('content')
<!--begin::Card-->
@forelse ($eventos as $e)
    
<div class="card card-custom gutter-b">
    <!--begin::Body-->
    <div class="card-body">
        <!--begin::Top-->
        <div class="d-flex align-items-center">
            <!--begin::Symbol-->
            <div class="symbol symbol-40 symbol-light-success mr-5">
                <span class="symbol-label">
                    <i class="far fa-calendar-check icon-3x text-primary"></i>
                    <img src="assets/media/svg/avatars/047-girl-25.svg" class="h-75 align-self-end" alt="">
                </span>
            </div>
            <!--end::Symbol-->
            <!--begin::Info-->
            <div class="d-flex flex-column flex-grow-1">
                <a href="#" class="text-dark-75 text-hover-primary mb-1 font-size-lg font-weight-bolder">{{ $e->nombre }}</a>
                <span class="text-muted font-weight-bold">
                    @php
                        // $hoy = date("Y-m-d");
                        $utilidades = new App\librerias\Utilidades();
                        echo $utilidades->fechaHoraCastellano($e->fecha_inicio);
                    @endphp
                </span>
            </div>
            <!--end::Info-->
            <!--begin::Dropdown-->
            
            <!--end::Dropdown-->
        </div>
        <!--end::Top-->
        <!--begin::Bottom-->
        <div class="pt-4">
            <!--begin::Image-->
            @if ($e->imagen == null)
                <div class="bgi-no-repeat bgi-size-cover rounded min-h-275px"
                                style="background-image: url({{ asset('assets/eventosDefecto.jpg') }})"></div>                
            @else
                <div class="bgi-no-repeat bgi-size-cover rounded min-h-275px" style="background-image: url({{ asset("imagenesEventos/$e->imagen") }})"></div>
            @endif
            <!--end::Image-->
            <!--begin::Text-->
            <p class="text-dark-75 font-size-lg font-weight-normal pt-5 mb-2">
                {{ $e->invitacion }}
            </p>
            <!--end::Text-->
            <!--begin::Action-->
            
            <!--end::Action-->
        </div>
        <!--end::Bottom-->
        <!--begin::Separator-->
        <!--end::Separator-->
        <!--begin::Editor-->
        
        <!--edit::Editor-->
    </div>
    <!--end::Body-->
</div>

@empty
<h3>NO EXISTEN EVENTOS</h3>
@endforelse
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
			
			var this_item = document.getElementById('barra-busqueda');
			this_item.style.display = 'none';

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