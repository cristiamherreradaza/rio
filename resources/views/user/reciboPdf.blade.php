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
    </style>


</head>
<body>
<br/>
    <div class="invoice">
        <h3 align="center" style="margin-top: 180px; font-size: 30px;">RECIBO DE PAGO</h3>
         <table width="100%"  style=" margin-top: 10px; margin-bottom: 15px;">
            <tr>
                <td align="left" width="40"  style=" margin-top: 20px; font-size: 12px; width: 60%; float: right;">                
                    <b>  Doctor: </b> {{ $usuario->name }}                                 
                </td>
               <td align="left" width="30">                
                                                 
                </td>

                <td align="right"  style=" font-size: 12px; float: left;"><b>Fecha:</b> {{ $reciboFin->fecha }} 
                </td>
            
            </tr>
        </table>
        <table id="data" width="100%" class="datos" style="text-align: center;">
            <thead>
                <tr>
                   
                    <th style="border: 1px solid #000;">Cantidad</th> 
                    <th style="border: 1px solid #000;">Descripcion</th> 
                    <th style="border: 1px solid #000;">Precio Unitario</th>
                    <th style="border: 1px solid #000;">Sub Total</th>
                </tr>
            </thead>
            <tbody>   
                @php
                    $pagos = App\Pago::where('recibo_id', $reciboFin->id)->get();
                @endphp         
                @foreach ($pagos as $p)
                    <tr>
                        <td style="border: 1px solid #000;">1</td>
                        <td style="border: 1px solid #000;">Pago de Mensualidad de {{ $p->mes }}</td>
                        <td style="border: 1px solid #000;">{{ $p->monto }}</td>
                        <td style="border: 1px solid #000;">{{ $p->monto }}</td>                        
                    </tr>
                @endforeach
                <tr>
                    <th style="border: 1px solid #000;" colspan="3">TOTAL</th> 
                    <th style="border: 1px solid #000; text-align: right;">{{ $reciboFin->total }} Bs.</th>
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