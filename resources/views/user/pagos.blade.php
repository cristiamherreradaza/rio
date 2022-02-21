{{-- <!DOCTYPE html>
<head>
<script src="vendor/jquery/jquery-3.2.1.min.js"></script>

<link rel="stylesheet" href="vendor/DataTables/jquery.datatables.min.css"> 
<script src="vendor/DataTables/jquery.dataTables.min.js" type="text/javascript"></script>

<link href="style.css" rel="stylesheet" type="text/css" />

<title>Buscar en columnas DataTables (Completo)</title>
<script>
$(document).ready(function (){
    $('#tbl-contact thead th').each(function () {
        var title = $(this).text();
        $(this).html(title+' <input type="text" class="col-search-input" placeholder="Search ' + title + '" />');
    });

    var table = $('#tbl-contact').DataTable({
    "scrollX": true,
    "pagingType": "numbers",
    "processing": true,
    "serverSide": true,
    "ajax": "server.php",
    order: [[2, 'asc']],
    columnDefs: [{
    targets: "_all",
    orderable: false
    }]
    });

    table.columns().every(function () {
        var table = this;
        $('input', this.header()).on('keyup change', function () {
            if (table.search() !== this.value) {
            table.search(this.value).draw();
            }
        });
    });
});

</script>
</head>

<body>
<div class="datatable-container">
<h2>Buscar en columnas DataTables ServerSide(Completo)</h2>
<hr>
<table name="tbl-contact" id="tbl-contact" class="display" cellspacing="0" width="100%">

<thead>
<tr>

<th>Nombres</th>
<th>Apellidos</th>
<th>Dirección</th>
<th>Teléfono</th>
<th>Fecha de Nacimiento</th>

</tr>
</thead>

</table>
</div>
</body>
</html> --}}

@extends('layouts.app')

@section('css')
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet">
@endsection

@section('content')
	<!--begin::Card-->
	<div class="card card-custom gutter-b">

        <div class="card-header flex-wrap py-3">
            <div class="card-title">
                <h3 class="card-label text-primary">
                    Doctor: <span class="text-secondary">{{ $datosUsuario->name }}</span>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    CI: <span class="text-secondary">{{ $datosUsuario->ci }}</span>
                </h3>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ url('User/guarda_pago') }}" method="POST" id="formularioPersona">
                @csrf
                <input type="hidden" value="{{ $datosUsuario->id }}" name="user_id">
                <!--begin: Datatable-->
                <div class="table-responsive m-t-40">
                    <table class="table table-bordered table-hover table-striped" id="tabla_usuarios">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Gestion</th>
                                <th>Mes</th>
                                <th>Monto</th>
                                <th>Fecha Pago</th>
                                <th>Estado</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pagos as $p)
                            @php
                                $verify = '';
                                if($p->estado == 'Debe'){
                                    $estado = '<a href="#" class="btn btn-light-danger font-weight-bold mr-2">Debe</a>';
                                }else{
                                    $estado = '<a href="#" class="btn btn-light-success font-weight-bold mr-2">Pagado</a>';
                                    $verify = 'checked disabled';
                                }
                            @endphp     
                            <tr>
                                <td>{{ $p->id }}</td>
                                <td>{{ $p->gestion }}</td>
                                <td>{{ $p->mes }}</td>
                                <td>{{ $p->monto }}</td>
                                <td>{{ $p->fecha_pago }}</td>
                                <td>{!! $estado !!}</td>
                                <td nowrap="nowrap">
                                    <div class="form-group row">
                                        <label class="col-3 col-form-label text-danger">Debe</label>
                                        <div class="col-3">
                                            <span class="switch switch-primary">
                                                <label>
                                                <input type="checkbox" {{ $verify }} name="select[{{ $p->id }}]"/>
                                                <span></span>
                                                </label>
                                            </span>
                                        </div>
                                        <label class="col-3 col-form-label text-success">Pago</label>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!--end: Datatable-->
                <div class="row">
                    <div class="col-md-12">
                        <button class="btn btn-block btn-success"><i class="fa fa-money-check"></i> PAGAR</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
									<!--end::Card-->
@stop

@section('js')
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script type="text/javascript">


        $(document).ready(function (){
            $('#tabla_usuarios thead th').each(function () {
                var title = $(this).text();
                $(this).html(title+' <input type="text" class="col-search-input" placeholder="Search ' + title + '" />');
            });

            var table = $('#tabla_usuarios').DataTable({
            "scrollX": true,
            "pagingType": "numbers",
            "processing": true,
            "serverSide": true,
            "ajax": "server.php",
            order: [[2, 'asc']],
            columnDefs: [{
            targets: "_all",
            orderable: false
            }]
            });

            table.columns().every(function () {
                var table = this;
                $('input', this.header()).on('keyup change', function () {
                    if (table.search() !== this.value) {
                    table.search(this.value).draw();
                    }
                });
            });
        });

        // var table = $('#tabla_usuarios').DataTable({
        //     orderCellsTop: true,
        //     fixedHeader: true
        // });

        //   //Creamos una fila en el head de la tabla y lo clonamos para cada columna
        // $('#tabla_usuarios thead tr').clone(true).appendTo( '#tabla_usuarios thead' );
        
        // $('#tabla_usuarios thead tr:eq(1) th').each( function (i) {
        //     var title = $(this).text(); //es el nombre de la columna
        //     $(this).html( '<input type="text" placeholder="Search...'+title+'" />' );

        //     $( 'input', this ).on( 'keyup change', function () {
        //         if ( table.column(i).search() !== this.value ) {
        //             table
        //                 .column(i)
        //                 .search( this.value )
        //                 .draw();
        //         }
        //     } );
        // } ); 

    	// $(document).ready(function() {
    	//     $('#tabla_usuarios').DataTable({
        //         language: {
        //             url: '{{ asset('datatableEs.json') }}'
        //         },
        //         order: [[ 0, "desc" ]]
        //     });
    	// } );

        function asiste(user_id, evento_id)
        {
            window.location.href = "{{ url('Evento/asiste') }}/"+user_id+"/"+evento_id;
        }

        function falta(user_id, evento_id)
        {
            window.location.href = "{{ url('Evento/falta') }}/"+user_id+"/"+evento_id;
        }

        function elimina(id, departamento, nombre)
        {
            Swal.fire({
                title: "Quieres eliminar "+nombre+" de "+departamento+"?",
                text: "Ya no podras recuperarlo!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, borrar!",
                cancelButtonText: "No, cancelar!",
                reverseButtons: true
            }).then(function(result) {
                if (result.value) {

                    window.location.href = "{{ url('Sector/elimina') }}/"+id;

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

        function cambiaPago(id , estado)
        {
            window.location.href = "{{ url('User/cambiaPago') }}/"+id+"/"+estado;
        }

        function pagar(){
            console.log("pagar");
        }
    </script>
@endsection