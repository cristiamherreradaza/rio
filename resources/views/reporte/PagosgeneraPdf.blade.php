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
            margin-left: 250px;
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
            <h3>REPORTE DE PAGOS</h3>
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
                    <th style="border: 1px solid #000;">ID</th> 
                    <th style="border: 1px solid #000;">Nombre</th> 
                    <th style="border: 1px solid #000;">Carnet</th>
                    <th style="border: 1px solid #000;">Fecha</th> 
                    <th style="border: 1px solid #000;">Recibo</th> 
                    <th style="border: 1px solid #000;">Importe</th>
                </tr>
            </thead>
            <tbody>           
                @foreach ($recibos as $res)
                    <tr>
                        <td style="border: 1px solid #000;">{{ $res->id }}</td>
                        <td style="border: 1px solid #000;">{{ $res->persona_nombre }}</td>
                        <td style="border: 1px solid #000;">{{ $res->carnet }}</td>
                        <td style="border: 1px solid #000;">{{ $res->fecha }}</td>
                        <td style="border: 1px solid #000;">{{ $res->numero."/".$res->anio }}</td>
                        <td style="border: 1px solid #000;text-align: right;">{{ $res->total }}</td>
                    </tr>
                    @php
                        $total = $total + $res->total;
                    @endphp
                @endforeach
                <tr>
                    @php
                        $utilidades = new App\librerias\NumeroALetras();
                        $literal = $utilidades->toMoney(200);
                    @endphp
                    <th style="border: 1px solid #000;text-align: left;" colspan="5" >Total</th> 
                    <th style="border: 1px solid #000;text-align: right;">{{ $total }}</th>
                    {{-- <th style="border: 1px solid #000; text-align: right;">{{ number_format($reciboFin->total, 2) }}</th> --}}
                </tr>
            </tbody>
        </table>
        {{-- <br>
        <table width="100%" style=" margin-top: 10px; margin-left: 30px;">
            <tr>
                <td style="width: 80%;">
               NOTA.- Las fechas de medida, primera prueba y entrega ser&aacute;n fijadas con la promoci&oacute;n.
               <p>
                   La entrega se realizaran en respectivo colgador y porta saco.
               </p>                 
                </td>
                
            </tr>
        </table> --}}
        {{-- <table width="100%" style=" margin-top: 120px;">
                <tr>
                    <td style="width: 80%; text-align: center;">
                        Soliz & Mendoza
                    </td>
                </tr>
                <tr>
                    <td style="width: 80%; text-align: center;">Calle Antonio Quijaro N° 911, Zona Garita de Lima La Paz - Bolivia</td>
                </tr>
                <tr>
                    <td style="width: 80%; text-align: center;">soliz.y.mendoza@gmail.com</td>
                </tr>
                <tr>
                    <td style="width: 80%; text-align: center;">http://solizmendoza.com</td>
                </tr>
                <tr>
                    <td style="width: 80%; text-align: center;">(591)-79135112</td>
                </tr>
        </table> --}}
    </div>
</body>
</html>