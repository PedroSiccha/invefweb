<!DOCTYPE html>
<html>
<head>
    <title></title>
    <SCRIPT language="javascript">
        function imprimir(){
                window.print() ;
        }
    </SCRIPT>
    <style type="text/css">
          
        * {
            font-size: 10px;
            font-family: 'Times New Roman';
        }

        td,
        th,
        tr,
        table {
            border-top: 1px solid black;
            border-collapse: collapse;
        }

        td.producto,
        th.producto {
            width: 2px;
            max-width: 2px;
        }

        td.cantidad,
        th.cantidad {
            width: 190px;
            max-width: 190px;
            word-break: break-all;
        }

        td.precio,
        th.precio {
            width: 250px;
            max-width: 250px;
            word-break: break-all;
        }

        .centrado {
            text-align: center;
            align-content: center;
        }

        .ticket {
            width: 330px;
            max-width: 330px;
            background-image: url("{{asset('../img/image005.png')}}");
            background-size: 100%;
        }

        img {
            max-width: inherit;
            width: inherit;
        }

        body { height: 5% GO }

     </style>
     <link rel="stylesheet" type="text/css" media="print" href="print.css">
</head>
<body onload="imprimir();">
<div class="ticket" >
            <img src="{{asset('../img/log.png')}}" alt="Logotipo" style="width: 98%;">
            <p class="centrado">INVEF
                <br>inversiones
                <br>{{ date('m/d/Y') }} {{  date("g:i a") }}</p>
            <table>
                <thead>
                </thead>
                <tbody>
                    <tr>
                        <td class="cantidad"><b>CLIENTE:</b></td>
                        
                        <td class="precio">{{ $pago[0]->cliente }}</td>
                    </tr>
                    <tr>
                        <td class="cantidad"><b>DNI:</b></td>
                        
                        <td class="precio">{{ $pago[0]->dni }}</td>
                    </tr>
                    <tr>
                        <td class="cantidad"><b>COD. PRESTAMO:</b></td>
                        
                        <td class="precio">{{ $pago[0]->prestamo_id }}</td>
                    </tr>
                    <tr>
                        <td class="cantidad"><b>GARANTIA:</b></td>
                        
                        <td class="precio">{{ $pago[0]->garantia }}</td>
                    </tr>
                    <tr>
                        <td class="cantidad"><b>ALMACEN:</b></td>
                        
                        <td class="precio">{{ $pago[0]->almacen }}</td>
                    </tr>
                    <tr>
                        <td class="cantidad"><b>MONTO:</b></td>
                        
                        <td class="precio">S/. {{ $pago[0]->montoPrestamo }}</td>
                    </tr>
                    <tr>
                        <td class="cantidad"><b>INTERES</b></td>
                        
                        <td class="precio">S/. {{ $pago[0]->interes }}</td>
                    </tr>
                    <tr>
                        <td class="cantidad"><b>MORA</b></td>
                        
                        <td class="precio">S/. {{ $pago[0]->mora }}</td>
                    </tr>
                    <tr>
                        <td class="cantidad"><b>TOTAL:</b></td>
                        
                        <td class="precio">S/. {{ $pago[0]->total }}</td>
                    </tr>
                    <tr>
                        <td class="cantidad"><b>SU PAGO:</b></td>
                        
                        <td class="precio">S/. {{ $pago[0]->importe }}</td>
                    </tr>
                    <tr>
                        <b>
                            <td class="cantidad">DEUDA PENDIENTE:</td>
                            <td class="precio">S/. 0.00</td>
                        </b>
                    </tr>
                </tbody>
            </table>
            <p class="centrado">¡GRACIAS POR SU CONFINZA!
                <br>invef.tk</p>
        </div>
</body>
</html>