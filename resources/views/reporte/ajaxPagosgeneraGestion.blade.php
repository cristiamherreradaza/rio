<link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet">
<table class="table table-bordered table-hover table-striped" id="tabla_recibos">
    <thead>
        <tr>
            <th>NOMBRE</th>
            <th>ENERO</th>
            <th>FEBRERO</th>
            <th>MARZO</th>
            <th>ABRIL</th>
            <th>MAYO</th>
            <th>JUNIO</th>
            <th>JULIO</th>
            <th>AGOSTO</th>
            <th>SEPTIEMBRE</th>
            <th>OCTUBRE</th>
            <th>NOVIEMBRE</th>
            <th>DICIEMBRE</th>
            <th>TOTAL</th>
        </tr>
    </thead>
    <tbody>
        @php
            $total = 0;
        @endphp
        @forelse ($doctores as $key => $doc)
        <tr>
            <td>{{ $doc->name }}</td>
            @php
                $pagos = App\Pago::where('user_id',$doc->id)
                                    ->where('gestion', $gestion)
                                    ->get();

                $sumador = 0;

                $faltante  =  12 - count($pagos);

            @endphp
            @if ($faltante != 0 )
                @for ($i = 0 ; $i < $faltante; $i++)
                    <td>0</td>
                @endfor
            @endif

            @foreach ( $pagos as $pag)
                <td>
                    @php
                        if($pag->estado == 'Pagado'){
                            echo $pag->monto;
                            $sumador = $sumador + $pag->monto;
                        }else{
                            echo 0;
                        }
                    @endphp
                </td>
            @endforeach
            
            <td>{{ $sumador }}</td>
        </tr>
        @php
            $total = $total + $sumador;
        @endphp
        @empty
        <h3 class="text-danger">NO EXISTEN DATOS</h3>
        @endforelse
    </tbody>
    <tfoot>
        <tr>
            <th>TOTAL</th>
            @foreach ($totales as $to)
                <th>{{ $to->total }}</th>
            @endforeach
            <th>{{ $total }}</th>
        </tr>
    </tfoot>
</table>
<div class="row">
    <div class="col-md-12">
        <button class="btn btn-danger btn-block" onclick="generaGestionPdf()"><i class="fa fa-file-pdf"></i>Generar Reporte</button>
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