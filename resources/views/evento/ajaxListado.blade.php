<link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet">
<table class="table table-bordered table-hover table-striped" id="tabla_criaderos">
    <thead>
        <tr>
            <th>ID</th>
            <th>NOMBRE</th>
            <th>INVITACION</th>
            <th>ORDEN DEL DIA</th>
            <th>ACTA DE REUNION</th>
            <th>FECHA INICIO</th>
            <th>FECHA FIN</th>
            <th>TIPO</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @forelse ($eventos as $even)
        <tr>
            <td>{{ $even->id }}</td>
            <td>{{ $even->nombre }}</td>
            <td>{{ $even->invitacion }}</td>
            <td>{{ $even->ordendia }}</td>
            <td>{{ $even->actareunion }}</td>
            <td>{{ $even->fecha_inicio}}</td>
            <td>{{ $even->fecha_fin }}</td>
            <td>{{ $even->tipo }}</td>
            <td>
                <a href="#" class="btn btn-icon btn-warning" onclick="edita('{{ $even->id }}')">
                    <i class="fas fa-edit"></i>
                </a>
                <a href="#" class="btn btn-icon btn-success" onclick="asistencia('{{ $even->id }}')">
                    <i class="fas fa-list-alt"></i>
                </a>
                <a href="#" class="btn btn-icon btn-danger" onclick="elimina('{{ $even->id }}', '{{ $even->name }}')">
                    <i class="flaticon2-delete"></i>
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
    $('#tabla_criaderos').DataTable({
        order: [[ 0, "desc" ]],
        searching: false,
        lengthChange: false,
        responsive: true,
        language: {
            url: '{{ asset('datatableEs.json') }}'
        },
    });
</script>