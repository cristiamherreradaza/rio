@extends('layouts.app')

@section('metadatos')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('css')
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet">
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <!--begin::Card-->
        <div class="card card-custom gutter-b example example-compact">
            <div class="card-header">
                <h3 class="card-title">Edita Evento</h3>
            </div>
            <!--begin::Form-->
            <form action="{{ url('Evento/guarda') }}" method="POST" id="formularioPersona" enctype="multipart/form-data">
                @csrf
                <div class="card-body">

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputPassword1">Nombre
                                <span class="text-danger">*</span></label>
                                <input type="hidden" id="id" name="id" value="{{ $datosEvento->id }}" />
                                <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $datosEvento->nombre }}" required />
                            </div>        
                        </div>

                        @php
                            $arrayFechaInicio = explode(" ", $datosEvento->fecha_inicio);
                            $nuevaFechaInicio = $arrayFechaInicio[0]."T".$arrayFechaInicio[1];

                            if($datosEvento->fecha_fin != null){
                                $arrayFechaFin = explode(" ", $datosEvento->fecha_fin);
                                $nuevaFechaFin = $arrayFechaFin[0]."T".$arrayFechaFin[1];
                            }else{
                                $nuevaFechaFin = null;
                            }
                        @endphp

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="exampleInputPassword1">Fecha Inicio
                                <span class="text-danger">*</span></label>
                                <input type="datetime-local" class="form-control" id="fecha_inicio" name="fecha_inicio" value="{{ $nuevaFechaInicio }}" required />
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="exampleInputPassword1">Fecha Fin</label>
                                <input type="datetime-local" class="form-control" id="fecha_fin" name="fecha_fin" value="{{ $nuevaFechaFin }}" />
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="tipo">Tipo</label>
                                <select class="form-control" id="tipo" name="tipo">
                                    <option value="Interno" {{ ($datosEvento->tipo == 'Interno')?'selected':'' }}>Interno</option>
                                    <option value="Externo" {{ ($datosEvento->tipo == 'Externo')?'selected':'' }}>Externo</option>
                                </select>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <img src="{{ asset("imagenesEventos/$datosEvento->imagen") }}" width="50%" alt="">
                        </div>
                        <div class="col-md-6">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="imagen" id="customFile" />
                                <label class="custom-file-label" for="customFile">Subir Archivo</label>
                            </div>
                        </div>
                    </div>
                    <br />
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="exampleInputPassword1">INVITACION</label>
                                <textarea name="invitacion" id="invitacion" cols="30" rows="10" class="form-control">{{ $datosEvento->invitacion }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="exampleInputPassword1">ORDEN DEL DIA</label>
                                <textarea name="ordendia" id="ordendia" cols="30" rows="10" class="form-control">{{ $datosEvento->ordendia }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="exampleInputPassword1">ACTA DE REUNION</label>
                                <textarea name="actareunion" id="actareunion" cols="30" rows="10" class="form-control">{{ $datosEvento->actareunion }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <button type="button" class="btn btn-primary mr-2 btn-block" onclick="guarda()">Guardar</button>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ url('User/listado') }}" class="btn btn-secondary btn-block">Volver</a>
                        </div>
                    </div>
                    
                </div>
                
            </form>
            <!--end::Form-->
        </div>
        <!--end::Card-->
    </div>
    
</div>

@stop

@section('js')
    <script src="{{ asset('assets/plugins/custom/ckeditor/ckeditor-classic.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/pages/crud/forms/editors/ckeditor-classic.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/pages/crud/file-upload/dropzonejs.js') }}"></script> --}}
    <script type="text/javascript">
        $.ajaxSetup({
            // definimos cabecera donde estarra el token y poder hacer nuestras operaciones de put,post...
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function guarda()
        {
            if ($("#formularioPersona")[0].checkValidity()) {

                $("#formularioPersona").submit();
                Swal.fire("Excelente!", "Se guardo el distrito!", "success");

            }else{
                $("#formularioPersona")[0].reportValidity();
            }
        }

        function canbiaDepartamento()
        {
            let departamento = $("#departamento").val();

            $.ajax({
                url: "{{ url('User/ajaxDistrito') }}",
                data: {departamento: departamento},
                type: 'POST',
                success: function(data) {
                    $("#ajaxDistritos").html(data);
                    // $("#listadoProductosAjax").html(data);
                }
            });

        }

    </script>
@endsection
