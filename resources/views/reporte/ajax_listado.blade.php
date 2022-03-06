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
        @php
            $total = 0;
        @endphp
        @forelse ($recibos as $r)
        <tr>
            <td>{{ $r->id }}</td>
            <td>{{ $r->persona_nombre }}</td>
            <td>{{ $r->carnet }}</td>
            <td>{{ $r->fecha }}</td>
            <td>{{ str_pad($r->numero, 4, '0', STR_PAD_LEFT) }}/{{ $r->anio }}</td>
            <td>{{ $r->total }}</td>
            <td>
                <a href='{{ url("User/reciboPdf", [$r->id, $r->personaid]) }}' class="btn btn-icon btn-primary">
                    <i class="fas fa-file-invoice"></i>
                </a>
            </td>
        </tr>
        @php
            $total = $total + $r->total;
        @endphp
        @empty
        <h3 class="text-danger">NO EXISTEN DATOS</h3>
        @endforelse
    </tbody>
    <tfoot>
        <tr>
            <th colspan="5">TOTAL</th>
            <th>{{ $total }}</th>
            <th></th>
        </tr>
    </tfoot>
</table>
<div class="row">
    <div class="col-md-12">
        <button class="btn btn-danger btn-block" onclick="generaPdf()"><i class="fa fa-file-pdf"></i>Generar Reporte</button>
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