<link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet">
<table class="table table-bordered table-hover table-striped" id="tabla_recibos">
    <thead>
        <tr>
            <th>ID</th>
            <th>NOMBRE</th>
            <th>CARNET</th>
            <th>FECHA</th>
            <th>RECIBO</th>
            <th>IMPORTE</th>
            <th>ACCIONES</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($recibos as $r)
        <tr>
            <td>{{ $r->id }}</td>
            <td>{{ $r->persona_nombre }}</td>
            <td>{{ $r->carnet }}</td>
            <td>{{ $r->fecha }}</td>
            <td>{{ str_pad($r->numero, 4, '0', STR_PAD_LEFT) }}/{{ $r->anio }}</td>
            <td>{{ $r->total }}</td>
            <td>
                <a href='{{ url("User/reciboPdf", [$r->personaid, $r->id]) }}' class="btn btn-icon btn-primary">
                    <i class="fas fa-file-invoice"></i>
                </a>
            </td>
        </tr>
        @empty
        <h3 class="text-danger">NO EXISTEN DATOS</h3>
        @endforelse
    </tbody>
</table>
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