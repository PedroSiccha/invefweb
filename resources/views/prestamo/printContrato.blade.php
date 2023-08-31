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
	      body {
		        width: 100%;
		        height: 100%;
		        margin: 0;
		        padding: 0;
		        background-color: #FAFAFA;
		        font: 12pt "Tahoma";
		    }
		    * {
		        box-sizing: border-box;
		        -moz-box-sizing: border-box;
		    }
		    .page {
		        width: 210mm;
		        min-height: 297mm;
		        padding: 20mm;
		        margin: 10mm auto;
		        border: 1px #D3D3D3 solid;
		        border-radius: 5px;
		        background: white;
		        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
		        position: absolute;
		        top: 0px;
		        left: 0px;
		    }

		    .cuerpo {
		        position: absolute;
		        top: 0px;
		        left: 0px;
		        border: none;
		        width: 210mm;
		        height: 297mm;
		    }
		    
		    @page {
		        size: A4;
		        margin-top: 0cm;
    			margin-bottom: 0cm;
		    }
		    @media print {
		        html, body {
		            width: 210mm;
		            height: 297mm;
		            margin-top: 0mm;
		            margin-bottom: 0mm;
           			margin-left: 0mm;
           			margin-right: 0mm;
		        }
		        .page {
		            margin: 0px;
		            border: initial;
		            border-radius: initial;
		            width: initial;
		            min-height: initial;
		            box-shadow: initial;
		            background: initial;
		            page-break-after: always;
		        }
		    }

		    .titulo{
		    	text-align: center;
		    	font-family: "Times New Roman", Georgia, Serif;
		    	font-size: 12pt;
		    }

		    .textos{
		    	text-align: justify;
		    	font-family: "Times New Roman", Georgia, Serif;
		    	font-size: 11pt;
		    }

			.lineaFirma{
		    	text-align: right;
		    	font-family: "Times New Roman", Georgia, Serif;
		    	font-size: 8pt;
		    }
		    .titfirma{
		    	text-align: right;
		    	font-family: "Times New Roman", Georgia, Serif;
		    	font-size: 8pt;
		    }
		    .cliente{
		    	text-align: right;
		    	font-family: "Times New Roman", Georgia, Serif;
		    	font-size: 8pt;
		    }
		    .dni{
		    	text-align: right;
		    	font-family: "Times New Roman", Georgia, Serif;
		    	font-size: 8pt;
		    }

	 </style>
</head>
<body onload="imprimir();">
<div>
    
    <?php
    function valorEnLetras($x)
    {
    if ($x<0) { $signo = "menos ";}
    else      { $signo = "";}
    $x = abs ($x);
    $C1 = $x;
    
    $G6 = floor($x/(1000000));  // 7 y mas
    
    $E7 = floor($x/(100000));
    $G7 = $E7-$G6*10;   // 6
    
    $E8 = floor($x/1000);
    $G8 = $E8-$E7*100;   // 5 y 4
    
    $E9 = floor($x/100);
    $G9 = $E9-$E8*10;  //  3
    
    $E10 = floor($x);
    $G10 = $E10-$E9*100;  // 2 y 1
    
    
    $G11 = round(($x-$E10)*100,0);  // Decimales
    //////////////////////
    
    $H6 = unidades($G6,0);
    
    if($G7==1 AND $G8==0) { $H7 = " CIEN "; }
    else {    $H7 = decenas($G7); }
    
    $H8 = unidades($G8,0);
    
    if($G9==1 AND $G10==0) { $H9 = " CIEN "; }
    else {    $H9 = decenas($G9); }
    
    $H10 = unidades($G10,1);
    
    if($G11 < 10) { $H11 = "0".$G11; }
    else { $H11 = $G11; }
    
    /////////////////////////////
        if($G6==0) { $I6=" "; }
    elseif($G6==1) { $I6=" MILLON "; }
             else { $I6=" MILLONES "; }
             
    if ($G8==0 AND $G7==0) { $I8=" "; }
             else { $I8=" MIL "; }
             
    $I10 = " ";
    //$I10 = "Soles ";
    $I11 = "";
    //$I11 = "/100 M.N. ";
    
    $C3 = $signo.$H6.$I6.$H7.$H8.$I8.$H9.$H10;
    //$C3 = $signo.$H6.$I6.$H7.$I7.$H8.$I8.$H9.$I9.$H10.$I10.$H11.$I11;
    
    return $C3; //Retornar el resultado
    
    }
    
    function unidades($u,$ver)
    {
        if ($u==0)  {$ru = " ";}
    elseif ($u==1)  {
      if($ver==1){
        $ru = " UNO ";  
      }else{
        $ru = " ";  
      }
      
    }
    elseif ($u==2)  {$ru = " DOS ";}
    elseif ($u==3)  {$ru = " TRES ";}
    elseif ($u==4)  {$ru = " CUATRO ";}
    elseif ($u==5)  {$ru = " CINCO ";}
    elseif ($u==6)  {$ru = " SEIS ";}
    elseif ($u==7)  {$ru = " SIETE ";}
    elseif ($u==8)  {$ru = " OCHO ";}
    elseif ($u==9)  {$ru = " NUEVE ";}
    elseif ($u==10) {$ru = " DIEZ ";}
    
    elseif ($u==11) {$ru = " ONCE ";}
    elseif ($u==12) {$ru = " DOCE ";}
    elseif ($u==13) {$ru = " TRECE ";}
    elseif ($u==14) {$ru = " CATORCE ";}
    elseif ($u==15) {$ru = " QUINCE";}
    elseif ($u==16) {$ru = " DIECISEIS ";}
    elseif ($u==17) {$ru = " DIECISIETE ";}
    elseif ($u==18) {$ru = " DIECIOCHO ";}
    elseif ($u==19) {$ru = " DIECINUEVE ";}
    elseif ($u==20) {$ru = " VEINTE ";}
    
    elseif ($u==21) {$ru = " VEINTIUNO ";}
    elseif ($u==22) {$ru = " VEINTIDOS ";}
    elseif ($u==23) {$ru = " VEINTITRES ";}
    elseif ($u==24) {$ru = " VEINTICUATRO ";}
    elseif ($u==25) {$ru = " VEINTICINCO ";}
    elseif ($u==26) {$ru = " VEINTISEIS ";}
    elseif ($u==27) {$ru = " VEINTISIETE ";}
    elseif ($u==28) {$ru = " VEINTIOCHO ";}
    elseif ($u==29) {$ru = " VEINTINUEVE ";}
    elseif ($u==30) {$ru = " TREINTA ";}
    
    elseif ($u==31) {$ru = " TREINTA y UNO ";}
    elseif ($u==32) {$ru = " TREINTA y DOS ";}
    elseif ($u==33) {$ru = " TREINTA y TRES ";}
    elseif ($u==34) {$ru = " TREINTA y CUATRO ";}
    elseif ($u==35) {$ru = " TREINTA y CINCO ";}
    elseif ($u==36) {$ru = " TREINTA y SEIS ";}
    elseif ($u==37) {$ru = " TREINTA y SIETE ";}
    elseif ($u==38) {$ru = " TREINTA y OCHO ";}
    elseif ($u==39) {$ru = " TREINTA y NUEVE ";}
    
    elseif ($u==40) {$ru = " CUARENTA ";}
    elseif ($u==41) {$ru = " CUARENTA y UNO ";}
    elseif ($u==42) {$ru = " CUARENTA y DOS ";}
    elseif ($u==43) {$ru = " CUARENTA y TRES ";}
    elseif ($u==44) {$ru = " CUARENTA y CUATRO ";}
    elseif ($u==45) {$ru = " CUARENTA y CINCO ";}
    elseif ($u==46) {$ru = " CUARENTA y SEIS ";}
    elseif ($u==47) {$ru = " CUARENTA y SIETE ";}
    elseif ($u==48) {$ru = " CUARENTA y OCHO ";}
    elseif ($u==49) {$ru = " CUARENTA y NUEVE ";}
    elseif ($u==50) {$ru = " CINCUENTA ";}
    
    elseif ($u==51) {$ru = "CINCUENTA y UNO ";}
    elseif ($u==52) {$ru = "CINCUENTA y DOS ";}
    elseif ($u==53) {$ru = "CINCUENTA y TRES ";}
    elseif ($u==54) {$ru = "CINCUENTA y CUATRO ";}
    elseif ($u==55) {$ru = "CINCUENTA y CINCO ";}
    elseif ($u==56) {$ru = "CINCUENTA y SEIS ";}
    elseif ($u==57) {$ru = "CINCUENTA y SIETE ";}
    elseif ($u==58) {$ru = "CINCUENTA y OCHO ";}
    elseif ($u==59) {$ru = "CINCUENTA y NUEVE ";}
    elseif ($u==60) {$ru = "SESENTA ";}
    
    elseif ($u==61) {$ru = "SESENTA y UNO ";}
    elseif ($u==62) {$ru = "SESENTA y DOS ";}
    elseif ($u==63) {$ru = "SESENTA y TRES ";}
    elseif ($u==64) {$ru = "SESENTA y CUATRO ";}
    elseif ($u==65) {$ru = "SESENTA y CINCO ";}
    elseif ($u==66) {$ru = "SESENTA y SEIS ";}
    elseif ($u==67) {$ru = "SESENTA y SIETE ";}
    elseif ($u==68) {$ru = "SESENTA y OCHO ";}
    elseif ($u==69) {$ru = "SESENTA y NUEVE ";}
    elseif ($u==70) {$ru = "SETENTA ";}
    
    elseif ($u==71) {$ru = "SETENTA y UNO ";}
    elseif ($u==72) {$ru = "SETENTA y DOS ";}
    elseif ($u==73) {$ru = "SETENTA y TRES ";}
    elseif ($u==74) {$ru = "SETENTA y CUATRO ";}
    elseif ($u==75) {$ru = "SETENTA y CINCO ";}
    elseif ($u==76) {$ru = "SETENTA y SEIS ";}
    elseif ($u==77) {$ru = "SETENTA y SIETE ";}
    elseif ($u==78) {$ru = "SETENTA y OCHO ";}
    elseif ($u==79) {$ru = "SETENTA y NUEVE ";}
    elseif ($u==80) {$ru = "OCHENTA ";}
    
    elseif ($u==81) {$ru = "OCHENTA y UNO ";}
    elseif ($u==82) {$ru = "OCHENTA y DOS ";}
    elseif ($u==83) {$ru = "OCHENTA y TRES ";}
    elseif ($u==84) {$ru = "OCHENTA y CUATRO ";}
    elseif ($u==85) {$ru = "OCHENTA y CINCO ";}
    elseif ($u==86) {$ru = "OCHENTA y SEIS ";}
    elseif ($u==87) {$ru = "OCHENTA y SIETE ";}
    elseif ($u==88) {$ru = "OCHENTA y OCHO ";}
    elseif ($u==89) {$ru = "OCHENTA y NUEVE ";}
    elseif ($u==90) {$ru = "NOVENTA ";}
    
    elseif ($u==91) {$ru = "NOVENTA y UNO ";}
    elseif ($u==92) {$ru = "NOVENTA y DOS ";}
    elseif ($u==93) {$ru = "NOVENTA y TRES ";}
    elseif ($u==94) {$ru = "NOVENTA y CUATRO ";}
    elseif ($u==95) {$ru = "NOVENTA y CINCO ";}
    elseif ($u==96) {$ru = "NOVENTA y SEIS ";}
    elseif ($u==97) {$ru = "NOVENTA y SIETE ";}
    elseif ($u==98) {$ru = "NOVENTA y OCHO ";}
    else            {$ru = "NOVENTA y NUEVE ";}
    return $ru; //Retornar el resultado
    }
    
    function decenas($d)
    {
        if ($d==0)  {$rd = "";}
    elseif ($d==1)  {$rd = "CIENTO ";}
    elseif ($d==2)  {$rd = "DOSCIENTOS ";}
    elseif ($d==3)  {$rd = "TRESCIENTOS ";}
    elseif ($d==4)  {$rd = "CUATROCIENTOS ";}
    elseif ($d==5)  {$rd = "QUINIENTOS ";}
    elseif ($d==6)  {$rd = "SEISCIENTOS ";}
    elseif ($d==7)  {$rd = "SETECIENTOS ";}
    elseif ($d==8)  {$rd = "OCHOCIENTOS ";}
    else            {$rd = "NOVECIENTOS ";}
    return $rd; //Retornar el resultado
    }
    
    function interes($int, $monto)
    {
        $re = ($int * $monto)/100;
        return $re;
    }
    ?>
    <div class="page">
            <img class="cuerpo" src="{{asset('../contrato/cuerpo.png')}}">
            <br>
            <br>
            <br>
            <h1 class="titulo" style="text-decoration: underline;">CONTRATO DE PRÉSTAMO CON GARANTÍA PRENDÁRIA N° {{ $contrato->prestamo_id }}</h1>
            <h1 class="textos">
                Conste por el presente documento de contrato de préstamo de dinero que suscribe de una parte, <b>LA EMPRESA INVERSIONES “INVEF” S.A.C</b> con <b>RUC Nº 20602118721</b>, Domiciliado en el {{ $direccion }}. Y de la otra parte el <b>Sr(a). {{ $contrato->nombre }} {{ $contrato->apellido }}</b> Con <b>DNI. {{ $contrato->dni }}</b>, Domiciliado en la <b>{{ $contrato->direccion }}</b>. Quien en adelante se le denominará el <b>PRESTATARIO</b>, ambas partes llegan a los acuerdos siguientes: 
            </h1>
            
             <h1 class="textos">
                <b style="text-decoration: underline;">CLAUSULA PRIMERA:</b> <b>LA EMPRESA INVERSIONES “INVEF” S.A.C</b>, cede en calidad de préstamo al <b>PRESTATARIO</b>, la suma total de <b>S/. {{ $contrato->monto }}</b> (<?php echo valorEnLetras( $contrato->monto ); ?> SOLES), <?php  $arrayMeses = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
                                                    $arrayDias = array( 'Domingo', 'Lunes', 'Martes','Miercoles', 'Jueves', 'Viernes', 'Sabado');
                                                    echo $arrayDias[date('w')].", ".date('d')." de ".$arrayMeses[date('m')-1]." de ".date('Y'); 
                                              ?>.         	
             </h1>
    
             <h1 class="textos">
                <b style="text-decoration: underline;">CLAUSULA SEGUNDA:</b> <b>EL PRESTATARIO</b>, se compromete a devolver el total de dinero mencionado en la primera clausula más los intereses generados por el préstamo, a partir de la fecha del inicio del presente contrato en el plazo de un mes que <b>FINALIZA EL DÍA <?php  echo date("d/m/Y", strtotime($contrato->fecfin)); ?></b>, ambas partes acuerdan que dicho préstamo generará el interés de <b><?php  $moneda = $contrato->intpagar; echo "S/. ".number_format($moneda, 2); ?>(<?php echo valorEnLetras( $moneda ); ?> SOLES)</b>. Serán pagados en las distintas agencias bancarias que seran brindadas al solicitarla.         	
             </h1>
    
             <h1 class="textos">
                 <b style="text-decoration: underline;">CLAUSULA TERCERA:</b> <b>EL PRESTATARIO</b> acepta dicho dinero en calidad de préstamo y asegura haber recibido el total del dinero a la firma del presente documento, <b>(DEJANDO EN GARANTÍA {{ $contrato->garantia }}, {{ $contrato->detgarantia }})</b>.
             </h1>
    
             <h1 class="textos">
                 <b style="text-decoration: underline;">CLAUSULA CUARTA:</b> En caso de incumplimiento pactado en la fecha mencionada el <b>PRESTATARIO</b> tendrá un <b>PLAZO MÁXIMO DE 15 DÍAS</b> para la cancelación o renovación de contrato con una <b>MORA FIJA DIARIA DE S/{{ $contrato->mora }} POR DÍA</b>, pasado dicha fecha de término la <b>EMPRESA INVERSIONES “INVEF” S.A.C.</b> Quedará facultado a recurrir a las autoridades pertinentes y hacer valer sus derechos, <b>(POR LO QUE ÉL PRESTATARIO PERDERÁ SU GARANTIA POR INCUMPLIMIENTO DE CONTRATO)</b>, mencionado en la clausula tercera. Mediante el presente documento es suficiente medio probatorio y vale como <b>RECIBO</b>.
             </h1>
    
             <h1 class="textos">
                 A sí mismo el cliente deberá brindar de forma obligatoria a la empresa cualquier cambio de número telefónico que el cliente realice, siendo responsabilidad del cliente en caso se pierda cualquier comunicación que la empresa requiere en cuanto a las notificaciones y avisos de cobranza. Siendo así la empresa solo se regirá por el contrato del plazo máximo de espera de 15 días.
    
             </h1> 
    
             <h1 class="textos">
                 <b style="text-decoration: underline;">CLAUSULA QUINTA:</b> Ambas partes señalan y aseguran que en la celebración del mismo no ha mediado error, dolo de nulidad anulabilidad que pudiera invalidar el contenido del mismo, por lo que proceden a firmar en el Distrito de Independencia, Provincia de Huaraz, Departamento de Ancash. El día <?php  $arrayMeses = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
                                                                                                                                                                                                                                                                                                                                                                        $arrayDias = array( 'Domingo', 'Lunes', 'Martes','Miercoles', 'Jueves', 'Viernes', 'Sabado');
                                                                                                                                                                                                                                                                                                                                                                        echo $arrayDias[date('w')].", ".date('d')." de ".$arrayMeses[date('m')-1]." de ".date('Y'); 
                                                                                                                                                                                                                                                                                                                                                                ?>.
             </h1>
    
             <br>
             <br>
             <br>
             <br>
             <br>
             <br>
             <div style="margin-left: 60%">
                <h1 class="lineaFirma" style="text-align: center">……………………………………… </h1> 
                <h1 class="titfirma" style="text-align: center">PRESTATARIO</h1>
                <h1 class="cliente" style="text-align: center">{{ $contrato->nombre }} {{ $contrato->apellido }}</h1> 
                <h1 class="dni" style="text-align: center">DNI. {{ $contrato->dni }}</h1>
            </div>
            
        </div>    
    
</div>
</body>
</html>