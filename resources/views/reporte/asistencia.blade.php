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
				<h3 class="card-label">REPORTE DE ASISTENCIA POR GESTION
				</h3>
			</div>
			<div class="card-toolbar">
				<!--begin::Button-->
				{{-- <a href="#" class="btn btn-success font-weight-bolder" onclick="muestraBarra();">
                    <i class="fas fa-search"></i>
                </a> --}}
				<!--end::Button-->
			</div>
		</div>
		<div class="card-body">
            <div class="row">
                <table class="table table-bordered border-1 border-success ">
                    <tr>
                        <td class="border-success border-1">
                            <!--begin::Card-->
                                <div class="card card-custom gutter-b">
                                    <div class="card-header flex-wrap py-3">
                                        <div class="card-title">
                                            <h3 class="card-label">REPORTE DE ASISTENCIA POR GESTION
                                            </h3>
                                        </div>
                                        <div class="card-toolbar">
                                            <!--begin::Button-->
                                            {{-- <a href="#" class="btn btn-success font-weight-bolder" onclick="muestraBarra();">
                                                <i class="fas fa-search"></i>
                                            </a> --}}
                                            <!--end::Button-->
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <form action="{{ url('Reporte/AsistenciaGestionPdf') }}" method="POST" id="formularioreporteGestion">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <input type="number" class="form-control" name="gestion" id="gestion" value="{{ date('Y') }}">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <button type="button" onclick="ajaxAsistenciaGestion()" class="btn btn-block btn-success"><i class="fa fas-search"></i> Buscar</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <!--end::Card-->
                        </td>
                        <td class="border-success border-1">
                            <!--begin::Card-->
                                <div class="card card-custom gutter-b">
                                    <div class="card-header flex-wrap py-3">
                                        <div class="card-title">
                                            <h3 class="card-label">REPORTE DE ASISTENCIA POR DOCTOR
                                            </h3>
                                        </div>
                                        <div class="card-toolbar">

                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <form action="{{ url('Reporte/PagosgeneraGestionPdf') }}" method="POST" id="formularioreporteDoctor">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <select name="doctor" id="doctor" class="form-control">
                                                                <option value=""></option>
                                                                @foreach ($doctores as $doc)
                                                                    <option value="{{ $doc->id }}">{{ $doc->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <button type="button" onclick="ajaxAsistenciaDoctor()" class="btn btn-block btn-success"><i class="fa fas-search"></i> Buscar</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <!--end::Card-->    
                        </td>
                        <td class="border-success border-1">
                            <!--begin::Card-->
                                <div class="card card-custom gutter-b">
                                    <div class="card-header flex-wrap py-3">
                                        <div class="card-title">
                                            <h3 class="card-label">REPORTE DE ASISTENCIA POR EVENTO
                                            </h3>
                                        </div>
                                        <div class="card-toolbar">
                                            <!--begin::Button-->
                                            {{-- <a href="#" class="btn btn-success font-weight-bolder" onclick="muestraBarra();">
                                                <i class="fas fa-search"></i>
                                            </a> --}}
                                            <!--end::Button-->
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <form target="_blank" action="{{ url('Reporte/PagosgeneraGestionPdf') }}" method="POST" id="formularioreporteEvento">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <select name="evento" id="evento" class="form-control">
                                                                <option value="">Elija el Evento</option>
                                                                @foreach ($eventos as $even)
                                                                    <option value="{{ $even->id }}">{{ $even->nombre }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <button type="button" onclick="ajaxAsistenciaEvento()" class="btn btn-block btn-success"><i class="fa fas-search"></i> Buscar</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <!--end::Card-->
                        </td>
                    </tr>
                </table>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div id="tabla-gestion">
    
                    </div>
                </div>
            </div>
		</div>
        
        {{-- <div class="row">
            <div class="col-md-12">
                <div id="tabla-gestion">

                </div>
            </div>
        </div> --}}

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
    	// $(document).ready(function() {
		// 	buscarRecibo();
    	// } );

        //cargamos a los script para select 2
        $('#doctor').select2({
            placeholder: "Seleccione"
        });

        //cargamos a los script para select 2
        $('#evento').select2({
            placeholder: "Seleccione"
        });

		function ajaxAsistenciaGestion(){
			
			// var this_item = document.getElementById('barra-busqueda');
			// this_item.style.display = 'none';

			var gestion =  $("#gestion").val();

			$.ajax({
                url: "{{ url('Reporte/ajaxAsistenciaGestion') }}",
                data: {
					gestion: gestion,
				},
                type: 'POST',
                success: function(data) {
                    $("#tabla-gestion").html(data);
                    // $("#listadoProductosAjax").html(data);
                }
            });
		}

        function AsistenciaGestiongeneraPdf(){

            // var nombre =  $("#nombre").val();
            // var fecha_ini  =  $("#fecha_ini").val();
            // var fecha_fin  =  $("#fecha_fin").val();
            // var ci  =  $("#ci").val();
            // var recibo  =  $("#recibo").val();

            $('#formularioreporteGestion').submit();

        }

        function ajaxAsistenciaDoctor(){
            // var this_item = document.getElementById('barra-busqueda');
			// this_item.style.display = 'none';

			var doctor =  $("#doctor").val();

			$.ajax({
                url: "{{ url('Reporte/ajaxAsistenciaDoctor') }}",
                data: {
					doctor: doctor,
				},
                type: 'POST',
                success: function(data) {
                    $("#tabla-gestion").html(data);
                    // $("#listadoProductosAjax").html(data);
                }
            });
        }

		function muestraBarra(){

			// document.getElementById('nombre').value = '';
			// document.getElementById('ci').value = '';
			// document.getElementById('fecha_ini').value = '';
			// document.getElementById('fecha_fin').value = '';
			// document.getElementById('recibo').value = '';

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