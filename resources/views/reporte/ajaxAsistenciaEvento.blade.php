<link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet">
<table class="table table-bordered table-hover table-striped" id="tabla_recibos">
    <thead>
        <tr>
            <th>ID</th>
            <th>DOCTOR</th>
            <th>CEDULA</th>
            <th>COLEGIATURA</th>
        </tr>
    </thead>
    <tbody>
        @php
            $total = 0;
        @endphp
        @forelse ($asistencia as $asis)
        @php
            $doctor = App\User::find($asis->user_id);
        @endphp
        <tr>
            <td>{{ $asis->id }}</td>
            <td>{{ $doctor->name }}</td>
            <td>{{ $doctor->ci }}</td>
            <td>{{ $doctor->colegiatura }}</td>
            
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
        <button class="btn btn-danger btn-block" onclick="AsistenciaEventogeneraPdf()"><i class="fa fa-file-pdf"></i>Generar Reporte</button>
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