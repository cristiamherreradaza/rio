@extends('layouts.app')

@section('content')
<!--Begin::Row-->
  
<div class="row">
    <div class="col-xl-4">
        <!--begin::Stats Widget 22-->
        <div class="card card-custom bgi-no-repeat card-stretch gutter-b"
            style="background-position: right top; background-size: 30% auto; background-image: url(assets/media/svg/shapes/abstract-3.svg)">
            <!--begin::Body-->
            <div class="card-body my-4">
                <a href="#"
                    class="card-title font-weight-bolder text-info font-size-h6 mb-4 text-hover-state-dark d-block">SOCIOS</a>
                <div class="font-weight-bold text-muted font-size-sm">
                    <span class="text-dark-75 font-weight-bolder font-size-h2 mr-2">{{ $socios }}</span>Registrados
                </div>
                <div class="progress progress-xs mt-7 bg-info-o-60">
                    <div class="progress-bar bg-info" role="progressbar" style="width: 22%;" aria-valuenow="50"
                        aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
            <!--end::Body-->
        </div>
        <!--end::Stats Widget 22-->
    </div>
    <div class="col-xl-4">
        <!--begin::Stats Widget 23-->
        <div class="card card-custom bg-info card-stretch gutter-b">
            <!--begin::Body-->
            <div class="card-body my-4">
                <a href="#"
                    class="card-title font-weight-bolder text-white font-size-h6 mb-4 text-hover-state-dark d-block">USUARIOS</a>
                <div class="font-weight-bold text-white font-size-sm">
                    <span class="font-size-h2 mr-2">{{ $usuario }}</span>Registrados
                </div>
                <div class="progress progress-xs mt-7 bg-white-o-90">
                    <div class="progress-bar bg-white" role="progressbar" style="width: 87%;" aria-valuenow="50"
                        aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
            <!--end::Body-->
        </div>
        <!--end::Stats Widget 23-->
    </div>
    <div class="col-xl-4">
        <!--begin::Stats Widget 24-->
        <div class="card card-custom bg-dark card-stretch gutter-b">
            <!--begin::Body-->
            <div class="card-body my-4">
                <a href="#"
                    class="card-title font-weight-bolder text-white font-size-h6 mb-4 text-hover-state-dark d-block">CUOTAS PAGASDAS DEL MES DE <span class="mes-actual"></span></a>
                <div class="font-weight-bold text-white font-size-sm">
                    <span class="font-size-h2 mr-2">{{ $pagos }}</span>Cuotas Pagados
                </div>
                <div class="progress progress-xs mt-7 bg-white-o-90">
                    <div class="progress-bar bg-white" role="progressbar" style="width: 52%;" aria-valuenow="50"
                        aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
            <!--end::Body-->
        </div>
        <!--end::Stats: Widget 24-->
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <!--begin::Card-->
        <div class="card card-custom gutter-b">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Pagos por mes de la gestion {{ date('Y') }}</h3>
                </div>
            </div>
            <div class="card-body">
                <!--begin::Chart-->
                <div id="chart" class="d-flex justify-content-center"></div>
                <!--end::Chart-->
            </div>
        </div>
        <!--end::Card-->
    </div>
</div>

<div class="row">
    <div class="col-lg-6">
        <!--begin::Card-->
        <div class="card card-custom gutter-b">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Cantidad de Medicos por catecorias</h3>
                </div>
            </div>
            <div class="card-body">
                <!--begin::Chart-->
                <div id="chart_1" class="d-flex justify-content-center"></div>
                <!--end::Chart-->
            </div>
        </div>
        <!--end::Card-->
    </div>

    <div class="col-lg-6">
        <!--begin::Card-->
        <div class="card card-custom gutter-b">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Cantidad de Socios que pagaron y no pagaron en el mes de <span class="mes-actual"></span></h3>
                </div>
            </div>
            <div class="card-body">
                <!--begin::Chart-->
                <div id="chart_2" class="d-flex justify-content-center"></div>
                <!--end::Chart-->
            </div>
        </div>
        <!--end::Card-->
    </div>
</div>
<!--End::Row-->
@stop

@section('js')
    {{-- <script src="{{ asset('assets/js/pages/features/charts/apexcharts.js') }}"></script> --}}
    <script>
        var mes =  {{ date('m') }}
        
        var expr = "";

        switch (mes) {
            case 1:
                expr = "ENERO";
                break;
            case 2:
                expr = "FEBRERO";
                break;
            case 3:
                expr = "MARZO";
                break;
            case 4:
                expr = "ABRIL";
                break;
            case 5:
                expr = "MAYO";
                break;
            case 6:
                expr = "JUNIO";
                break;
            case 7:
                expr = "JULIO";
                break;
            case 8:
                expr = "AGOSTO";
                break;
            case 9:
                expr = "SEPTIEMBRE";
                break;
            case 10:
                expr = "OCTUBRE";
                break;
            case 11:
                expr = "NOVIEMBRE";
                break;
            case 12:
                expr = "DICIEMBRE";
                break;
        }

        $('.mes-actual').text(expr);

      // const $array1;

      // grafico de barras
        var options = {
          series: [{
          name: 'Pagos por Mes',
          data: @json($cuotasPagadas)
        //   data: [50, 3, 4, 10, 4, 5, 3, 2, 1, 3, 5, 2] //valores del grafico
        //   data: ['50', 3, 4, 10, 4, 5, 3, 2, 1, 3, 5, 2] //valores del grafico

        }],
          chart: {
          height: 350,
          type: 'bar',
        },
        plotOptions: {
          bar: {
            borderRadius: 10,
            dataLabels: {
              position: 'top', // top, center, bottom
            },
          }
        },
        dataLabels: {
          enabled: true,
          formatter: function (val) {
            return val + "";
          },
          offsetY: -20,
          style: {
            fontSize: '12px',
            colors: ["#304758"]
          }
        },
        
        xaxis: {
          categories: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
          position: 'top',
          axisBorder: {
            show: false
          },
          axisTicks: {
            show: false
          },
          crosshairs: {
            fill: {
              type: 'gradient',
              gradient: {
                colorFrom: '#D8E3F0',
                colorTo: '#BED1E6',
                stops: [0, 100],
                opacityFrom: 0.4,
                opacityTo: 0.5,
              }
            }
          },
          tooltip: {
            enabled: true,
          }
        },
        yaxis: {
          axisBorder: {
            show: false
          },
          axisTicks: {
            show: false,
          },
          labels: {
            show: false,
            formatter: function (val) {
              return val + "";
            }
          }
        
        },
        title: {
          text: 'Cantidad de Cuotas pagadas por mes de esta gestion',
          floating: true,
          offsetY: 330,
          align: 'center',
          style: {
            color: '#444'
          }
        }
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();

        // grafico pie
        var options = {
        //   series: [44, 55],
          series: [
              @php
                  foreach ($doctorCategoria as $doc){
                    echo $doc->total.",";
                  }
              @endphp
            ],
          chart: {
          width: 480,
          type: 'pie',
        },
        // labels: ['Ejemplares Nacionales', 'Ejemplares Extranjeros'],
        labels: [
                @php
                 foreach ($doctorCategoria as $doc){
                     $categoria = App\Categoria::find($doc->categoria_id);
                     echo "'".$categoria->nombre."'".",";
                 }
                @endphp
                ],
        responsive: [{
          breakpoint: 480,
          options: {
            chart: {
              width: 200
            },
            legend: {
              position: 'bottom'
            }
          }
        }]
        };

        var chart = new ApexCharts(document.querySelector("#chart_1"), options);
        chart.render();

        // grafico dona
         var options = {
          series: [{{ $contadorPagador }}, {{ $contadorDeudor }}],
          chart: {
          width: 480,
          type: 'donut',
        },
        labels: ['Pagaron', 'Deudores'],	
        responsive: [{
          breakpoint: 480,
          options: {
            chart: {
              width: 200
            },
            legend: {
              position: 'bottom'
            }
          }
        }]
        };

        var chart = new ApexCharts(document.querySelector("#chart_2"), options);
        chart.render();
    
    </script>
@endsection