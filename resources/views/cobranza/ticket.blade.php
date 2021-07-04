<?php 
    use App\proceso; 
    $pro = new proceso();
?>
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
            //background-image: url("{{asset('../img/image005.png')}}");
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
                        <td class="cantidad"><h1><b>CLIENTE:</b></h1></td>
                        
                        <td class="precio">{{ $pago[0]->cliente }}</td>
                    </tr>
                    <tr>
                        <td class="cantidad"><h1><b>DNI:</b></h1></td>
                        
                        <td class="precio">{{ $pago[0]->dni }}</td>
                    </tr>
                    <tr>
                        <td class="cantidad"><h1><b>COD. PRESTAMO:</b></h1></td>
                        
                        <td class="precio">{{ $pago[0]->prestamo_id }}</td>
                    </tr>
                    <tr>
                        <td class="cantidad"><h1><b>GARANTIA:</b></h1></td>
                        
                        <td class="precio">{{ $pago[0]->garantia }}</td>
                    </tr>
                    <tr>
                        <td class="cantidad"><h1><b>ALMACEN:</b></h1></td>
                        
                        <td class="precio">{{ $pago[0]->almacen }}</td>
                    </tr>
                    <tr>
                        <td class="cantidad"><h1><b>MONTO:</b></h1></td>
                        
                        <td class="precio">S/. {{ $pago[0]->montoPrestamo }}</td>
                    </tr>
                    <tr>
                        <td class="cantidad"><h1><b>INTERES</b></h1></td>
                        
                        <td class="precio">S/. {{ $pago[0]->interes }}</td>
                    </tr> 
                    <tr>
                        <td class="cantidad"><h1><b>MORA</b></h1></td>
                        
                        <td class="precio">S/. {{ $pago[0]->mora }}</td>
                    </tr>
                    <tr>
                        <td class="cantidad"><h1><b>TOTAL:</b></h1></td>
                        
                        <td class="precio"><h2>S/. {{ $pago[0]->total }}</h2></td>
                    </tr>
                    <tr>
                        <td class="cantidad"><h1><b>SU PAGO:</b></h1></td>
                        
                        <td class="precio">S/. {{ $pago[0]->importe }}</td>
                    </tr>
                    <tr>
                        <b>
                            <td class="cantidad"><h1>DEUDA PENDIENTE:</h1></td>
                            <td class="precio">S/. {{ $pago[0]->restante }}</td>
                        </b>
                    </tr>
                    <?php

                        $verFecha = "visibility:hidden;";

                        if($pago[0]->restante> 0){
                            $verFecha = "";
                        }else{
                            $verFecha = "visibility:hidden;";
                        }

                        $fecInicio = $pago[0]->fecinicio;

                        $nuevaFecha = date("d-m-Y",strtotime($fecInicio."+ 1 month"));

                    ?>
                    <tr style="{{ $verFecha }}">
                        <b>
                            <td class="cantidad">Fecha próximo pago: </td>
                            <td class="cantidad">{{ $nuevaFecha }} </td>
                            
                        </b>
                    </tr>
                </tbody>
            </table>
            <p class="centrado">¡GRACIAS POR SU CONFINZA!
                <br>invef.tk</p>
        </div>
</body>
</html>