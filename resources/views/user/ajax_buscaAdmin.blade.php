<link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet">
<table class="table table-bordered table-hover table-striped" id="tabla_criaderos">
    <thead>
        <tr>
            <th>ID</th>
            <th>NOMBRE</th>
            <th>CARNET</th>
            <th>EMAIL</th>
            <th>PERFIL</th>
            <th>CELULARES</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @forelse ($usuarios as $us)
        <tr>
            <td>{{ $us->id }}</td>
            <td>{{ $us->name }}</td>
            <td>{{ $us->ci }}</td>
            <td>{{ $us->email }}</td>
            <td>{{ $us->perfil }}</td>
            <td>{{ $us->celulares}}</td>
            <td>
                <a href="#" class="btn btn-icon btn-warning btn-sm mr-2" onclick="edita('{{ $us->id }}')">
                    <i class="fas fa-edit"></i>
                </a>
                <a href="#" class="btn btn-icon btn-success btn-sm mr-2" onclick="cuotas('{{ $us->id }}')">
                    <i class="fas fa-list-alt"></i>
                </a>
                <a href="#" class="btn btn-icon btn-danger btn-sm mr-2" onclick="elimina('{{ $us->id }}', '{{ $us->name }}')">
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
        language: {
            url: '{{ asset('datatableEs.json') }}'
        },
    });
</script>