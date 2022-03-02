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
                                <input type="email" class="form-control" id="email" name="email" onfocusout="validaEmail()"  required />
                                <span class="form-text text-danger" id="msg-error-email" style="display: none;">Correo duplicado, cambielo!!!</span>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="exampleInputPassword1">Fecha Nacimiento
                                    </label>
                                <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento"/>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-7">
                            <div class="form-group">
                                <label for="exampleInputPassword1">Direccion
                                </label>
                                <input type="text" class="form-control" id="direccion" name="direccion"/>
                            </div>        
                        </div>
                        
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="exampleInputPassword1">Telefonos
                                </label>
                                <input type="text" class="form-control" id="celulares" name="celulares" placeholder="78458956 - 68945789"/>
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
                                <input type="number" class="form-control" id="importe" name="importe" value="{{ $importe->valor }}" required />
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

        function validaEmail()
        {
            let email = $("#email").val();

            $.ajax({
                url: "{{ url('User/validaEmail') }}",
                data: {email: email},
                type: 'POST',
                success: function(data) {
                    // console.log(data.vEmail);     
                    if(data.vEmail > 0){
                        $("#msg-error-email").show();
                    }else{
                        $("#msg-error-email").hide();
                    }
                }
            });
        }

    </script>
@endsection
