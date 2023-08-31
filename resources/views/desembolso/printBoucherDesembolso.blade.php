<!DOCTYPE html>
<html>
<head>
    <title></title>
    <SCRIPT language="javascript">
        function imprimir(){

            if ((navigator.appName == "Netscape")) { 
                window.print() ;
            } else { 
                var WebBrowser = '<OBJECT ID="WebBrowser1" WIDTH=0 HEIGHT=0 CLASSID="CLSID:8856F961-340A-11D0-A96B-00C04FD705A2"></OBJECT>';
                document.body.insertAdjacentHTML('beforeEnd', WebBrowser); WebBrowser1.ExecWB(6, -1); WebBrowser1.outerHTML = "";
            }
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

     </style>
</head>
<body onload="imprimir();" >
<div class="ticket" >
            <img src="{{asset('../img/log.png')}}" alt="Logotipo" style="width: 98%;">
            <p class="centrado">INVEF
                <br>inversiones
                <br>{{ $desembolso[0]->created_at }}</p>
            <table>
                <thead>
                </thead>
                <tbody>
                    <tr>
                        <td class="cantidad"><b>CLIENTE:</b></td>
                        
                        <td class="precio">{{ $desembolso[0]->nombre }} {{ $desembolso[0]->apellido }}</td>
                    </tr>
                    <tr>
                        <td class="cantidad"><b>DNI:</b></td>
                        
                        <td class="precio">{{ $desembolso[0]->dni }}</td>
                    </tr>
                    <tr>
                        <td class="cantidad"><b>MONTO:</b></td>
                        
                        <td class="precio">S/. {{ $desembolso[0]->monto }}</td>
                    </tr>
                    <tr>
                        <td class="cantidad"><b>GARANTIA:</b></td>
                        
                        <td class="precio">{{ $desembolso[0]->garantia }}</td>
                    </tr>
                </tbody>
            </table>
            <h1>{{ $desembolso[0]->estado }} a la cuenta {{ $desembolso[0]->numero }}</h1>
            <p class="centrado">¡GRACIAS POR SU CONFINZA!
                <br>invef.tk</p>
        </div> 
</body>
</html>