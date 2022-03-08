<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recibo de Pago</title>

    <style type="text/css">
        @page {
            margin: 0px;
        }

        body {

           background-repeat: no-repeat; 

        }

        * {
            font-family: Verdana, Arial, sans-serif;

        }

        a {
            color: #fff;
            text-decoration: none;
        }

        table {
            font-size: 13px;
            line-height:14px;
            
            
        }

       

        tfoot tr td {
            font-weight: bold;
            font-size: x-small;
        }

        
        .invoice {
            /*margin-top: 10px; */
            margin-left: 40px;
            margin-right: 40px;

        }

        .information {
            background-color: #60A7A6;
            color: #FFF;
            line-height:7px;
        }

        .information .logo {
            margin: 5px;
        }

        .information table {
            padding: 10px;
        }

        .glosa {
            font-size: 10px;
            line-height:14px;
        }

        .pie_pagina {
            font-size: 10px;
            line-height:14px;
        }

        .titulo {
            font-size: 13px;
            line-height:18px;
        }

        /*estilos para tablas de datos*/
        table.datos {
            margin-top: 150px;
            font-size: 13px;
            /*line-height:14px;*/
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
        }
        .datos th {
          height: 15px;
          background-color: #616362;
          color: #fff;
        }
        .datos td {
          height: 20px;
        }
        .datos th, .datos td {
          border: 1px solid #ddd;
          padding: 2px;
          text-align: center;
        }
        .datos tr:nth-child(even) {background-color: #f2f2f2;}
        /*fin de estilos para tablas de datos*/
        #logo{
            position: absolute;
            max-width: 150px;
            margin-top: 35px;
        }
        #recibo{
            position: absolute;
            font-size: 15px;
            margin-top: 60px;
            float: right;
            /* text-align: right; */
        }
        #descripcion{
            position: absolute;
            margin-top: 40px;
            margin-left: 130px;
            width: 400px;
            /* background-color: red; */
        }
    </style>


</head>
<body>
<br/>
    <div class="invoice">
        <div id="logo">
            <img src="{{ asset("img/logo.png") }}" width="55%" alt=" aqui la imagen">
        </div>
        <div id="descripcion">
            <h3>REPORTE DE ASISTENCIA DEL DR. {{ $doctor->name }}</h3>
        </div>
        <div id="recibo">
            @php
                $utilidades = new App\librerias\Utilidades();
                $fecha = $utilidades->fechaCastellano(date('Y-m-d'));
                echo  $fecha;
                $total = 0;
            @endphp
        </div>
        <table id="data" width="100%" class="datos" style="text-align: center;">
            <thead>
                <tr>
                    <th style="border: 1px solid #000;">NOMBRE</th> 
                    <th style="border: 1px solid #000;">FECHA INICIO</th>
                    <th style="border: 1px solid #000;">ASISTENCIA</th>
                </tr>
            </thead>
            <tbody>           
                @foreach ($eventos as $eve)
                    <tr>
                        <td>{{ $eve->nombre }}</td>
                        <td>{{ $eve->fecha_inicio }}</td>
                        <td>
                            @php
                                $asistencia = App\Asistencia::where('user_id', $doctor->id)         
                                                            ->where('evento_id', $eve->id)
                                                            ->first();
            
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
                @endforeach
            </tbody>
            {{-- <tfoot>
                <tr>
                    <th>TOTAL</th>
                    @foreach ($totales as $to)
                        <th>{{ $to->total }}</th>
                    @endforeach
                    <th style="border: 1px solid #000;text-align: right;">{{ $total }}</th>
                </tr>
            </tfoot> --}}
        </table>
    </div>
</body>
</html>