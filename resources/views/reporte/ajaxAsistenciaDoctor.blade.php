<link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet">
<table class="table table-bordered table-hover table-striped" id="tabla_recibos">
    <thead>
        <tr>
            <th>ID</th>
            <th>NOMBRE</th>
            <th>FECHA INICIO</th>
            <th>ASISTENCIA</th>
        </tr>
    </thead>
    <tbody>
        @php
            $total = 0;
        @endphp
        @forelse ($eventos as $eve)
        <tr>
            <td>{{ $eve->id }}</td>
            <td>{{ $eve->nombre }}</td>
            <td>{{ $eve->fecha_inicio }}</td>
            <td>
                @php
                    $asistencia = App\Asistencia::where('user_id', $doctor_id)         
                                                ->where('evento_id', $eve->id)
                                                ->first();
                    // dd($asistencia);
                    // dd($doctor_id);

                    if($asistencia){
                        if($asistencia->estado == "Asistio"){
                            echo "Si";
                        }else{
                            echo "No";
                        }
                    }else{
                        echo "No";
                    }
                @endphp
            </td>
            
        </tr>
        @empty
        <h3 class="text-danger">NO EXISTEN DATOS</h3>
        @endforelse
    </tbody>
    {{-- <tfoot>
        <tr>
            <th colspan="5">TOTAL</th>
            <th>{{ $total }}</th>
            <th></th>
        </tr>
    </tfoot> --}}
</table>
<div class="row">
    <div class="col-md-12">
        <button class="btn btn-danger btn-block" onclick="AsistenciaGestiongeneraPdf()"><i class="fa fa-file-pdf"></i>Generar Reporte</button>
    </div>
</div>
<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script>
    $('#tabla_recibos').DataTable({
        order: [[ 0, "desc" ]],
        searching: false,
        lengthChange: false,
        responsive: true,
        language: {
            url: '{{ asset('datatableEs.json') }}'
        },
    });
</script>