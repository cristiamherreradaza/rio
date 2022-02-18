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
                <h3 class="card-title">Nuevo Socio</h3>
                
            </div>
            <!--begin::Form-->
            <form action="{{ url('User/guarda') }}" method="POST" id="formularioPersona">
                @csrf
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputPassword1">Nombre
                                <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required />
                            </div>        
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="exampleInputPassword1">Carnet
                                <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="ci" name="ci" required />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="exampleInputPassword1">Colegiatura
                                <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="colegiatura" name="colegiatura" required />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="exampleInputPassword1">Email
                                <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" name="email" required />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="exampleInputPassword1">Fecha Nacimiento
                                    <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" required />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-7">
                            <div class="form-group">
                                <label for="exampleInputPassword1">Direccion
                                <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="direccion" name="direccion" required />
                            </div>        
                        </div>
                        
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="exampleInputPassword1">Telefonos
                                <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="celulares" name="celulares" required />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleSelect1">Categorias <span class="text-danger">*</span></label>
                                <select class="form-control" id="categoria_id" name="categoria_id" required >
                                    <option value="">Seleccione</option>
                                    @foreach ($categorias as $c)
                                        <option value="{{ $c->id }}">{{ $c->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputPassword1">Password
                                    <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" id="password" name="password" required />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12"><h3 class="text-info">Cuotas</h3></div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleSelect1">Mes <span class="text-danger">*</span></label>
                                <select class="form-control" id="mes" name="mes" required >
                                    <option value="1">Enero</option>
                                    <option value="2">Febrero</option>
                                    <option value="3">Marzo</option>
                                    <option value="4">Abril</option>
                                    <option value="5">Mayo</option>
                                    <option value="6">Junio</option>
                                    <option value="7">Julio</option>
                                    <option value="8">Agosto</option>
                                    <option value="9">Septiembre</option>
                                    <option value="10">Octubre</option>
                                    <option value="11">Noviembre</option>
                                    <option value="12">Diciembre</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputPassword1">Gestion
                                    <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="gestion" name="gestion" value="{{ date('Y') }}" required />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputPassword1">Importe
                                    <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="importe" name="importe" value="350" required />
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
