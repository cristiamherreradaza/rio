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
            <th>COLEGIATURA</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @forelse ($usuarios as $us)
        @php
            $estadoUsuario = "class='text-success h5'";
            if($us->estado == "Pendiente"){
                $estadoUsuario = "class='text-danger h5'";
            }
        @endphp
        <tr>
            <td>{{ $us->id }}</td>
            <td {!! $estadoUsuario !!}>{{ $us->name }}</td>
            <td>{{ $us->ci }}</td>
            <td>{{ $us->email }}</td>
            <td>{{ $us->perfil }}</td>
            <td>{{ $us->celulares}}</td>
            <td>{{ $us->colegiatura }}</td>
            <td>
                @if($us->estado == "Pendiente")
                    <a href="#" class="btn btn-icon btn-info" onclick="quitaPendiente('{{ $us->name }}', '{{ $us->id }}')">
                        <i class="fas fa-plus"></i>
                    </a>
                @endif
                <a href="#" class="btn btn-icon btn-warning" onclick="edita('{{ $us->id }}')">
                    <i class="fas fa-edit"></i>
                </a>
                <a href="#" class="btn btn-icon btn-success" onclick="cuotas('{{ $us->id }}')">
                    <i class="fas fa-list-alt"></i>
                </a>
                @php
                    $cuotas = App\Pago::where('user_id',$us->id)->count();
                @endphp
                @if ($cuotas == 0)
                    <a href="#" class="btn btn-icon btn-danger" onclick="elimina('{{ $us->id }}', '{{ $us->name }}')">
                        <i class="flaticon2-delete"></i>
                    </a>    
                @endif
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