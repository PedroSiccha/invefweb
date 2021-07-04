@extends('layouts.app')
@section('pagina')
    Análisis de Resultados  
@endsection
@section('contenido')   
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>ANALISIS DE RESULTADOS</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.html">Inicio</a>
            </li>
            <li class="breadcrumb-item">    
                <a>Finanzas</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Análisis de Resultados</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight row">
        <div class="col-lg-6">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Ingreso de Utilidades </h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
        
                    <table class="table table-striped">
                        <tbody>
                        <tr>
                            <?php 

                                if ($utilidades[0]->utilidades > 0) {
                                    $color = "text-navy";
                                } else{
                                    $color = "text-danger";
                                }
                            ?>
                            <td class="{{ $color }}"> S/. {{ $utilidades[0]->utilidades }} </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Ingreso de Moras </h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
        
                    <table class="table table-striped">
                        <tbody>
                        <tr>
                            <?php 
                                if ($mora[0]->mora > 0) {
                                    $color = "text-navy";
                                }else {
                                    $color = "text-danger";
                                } 
                            ?>
                            <td class="{{ $color }}"> S/. {{ $mora[0]->mora }} </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Ingresos Extra de Venta </h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
        
                    <table class="table table-striped">
                        <tbody>
                        <tr>
                            <?php 
                                if ($venta[0]->venta > 0) {
                                    $color = "text-navy";
                                }else {
                                    $color = "text-danger";
                                } 
                            ?>
                            <td class="{{ $color }}"> S/. {{ $venta[0]->venta }} </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>SUB TOTAL </h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
        
                    <table class="table table-striped">
                        <tbody>
                        <tr>
                            <?php 
                                if (number_format((FLOAT)$utilidades[0]->utilidades + (FLOAT)$mora[0]->mora + (FLOAT)$venta[0]->venta, 2) > 0) {
                                    $color = "text-navy";
                                }else {
                                    $color = "text-danger";
                                } 
                            ?>
                            <td class="{{ $color }}"> S/. {{ number_format((FLOAT)$utilidades[0]->utilidades + (FLOAT)$mora[0]->mora + (FLOAT)$venta[0]->venta, 2)  }} </td>
                            
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Gastos Administrativos </h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
        
                    <table class="table table-striped">
                        <tbody>
                        <tr>
                            <?php

                                if ($gastosadministrativos[0]->monto > 0) {
                                    $color = "text-navy";
                                }else {
                                    $color = "text-danger";
                                } 
                            ?>
                            <td class="{{ $color }}"> S/. {{ $historialCajaGrande[0]->monto + $cajaChica[0]->monto }} </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Impuestos </h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <table class="table table-striped">
                        <tbody>
                        <tr>
                            @foreach ($impuesto as $i)
                                <td class="text-navy"> S/. {{ $i->monto }} </td>
                            @endforeach
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>UTILIDAD ANTES DE IMPUESTOS </h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
        
                    <table class="table table-striped">
                        <tbody>
                        <tr>
                            <?php 

                                if (number_format((FLOAT)$utilidades[0]->utilidades + (FLOAT)$mora[0]->mora + (FLOAT)$venta[0]->venta - (FLOAT)$historialCajaGrande[0]->monto, 2) > 0) {
                                    $color = "text-navy";
                                }else {
                                    $color = "text-danger";
                                } 
                            ?>
                            <!-- mora + venta + historialCajaGrande + historialCajaChica + + -->
                            <td class="{{ $color }}"> S/. {{ 598 + 1279.5 - 350 - 3568.9 + 235.90 + 3147.7 }} </td>
                            
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div

        <div class="col-lg-6">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>UTILIDADES NETAS </h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
        
                    <table class="table table-striped">
                        <tbody>
                        <tr>
                            <?php 
                                if (number_format((FLOAT)$utilidades[0]->utilidades + (FLOAT)$mora[0]->mora + (FLOAT)$venta[0]->venta - (FLOAT)$historialCajaGrande[0]->monto - (FLOAT)$historialCajaChica[3]->monto - (FLOAT)$impuesto[0]->monto, 2) > 0) {
                                    $color = "text-navy";
                                }else {
                                    $color = "text-danger";
                                } 
                            ?>
                            <!-- mora + venta - historialCajaGrande - historialCajaChica - impuesto + + -->
                            <td class="{{ $color }}"> S/. {{ 598 + 1279.5 - 350 - 3568.9 - 0 + 235.90 + 3147.7}} </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    <div class="row">

        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Utilidades Netas Anuales </h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">

                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th onclick="verHistorialMes('2019')">AÑO 2019</th>    
                            <th onclick="verHistorialMes('2020')">AÑO 2020</th>    
                            <th onclick="verHistorialMes('2021')">AÑO 2021</th>    
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="text-navy" onclick="verHistorialMes('2019')"> S/. --</td>
                            <td class="text-navy" onclick="verHistorialMes('2020')"> S/. --</td>
                            <td class="text-navy" onclick="verHistorialMes('2021')"> S/. {{ number_format((FLOAT)$utilidades[0]->utilidades + (FLOAT)$mora[0]->mora + (FLOAT)$venta[0]->venta - (FLOAT)$historialCajaGrande[0]->monto - (FLOAT)$historialCajaChica[3]->monto - (FLOAT)$impuesto[0]->monto + 4956.52 + 5649.48, 2) }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Utilidades Netas Mensuales </h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content" id="tabArMes">

                    <table class="table table-striped">
                        <thead>
                        <tr>
                            @foreach ($historialMes as $hm)
                                <?php
                                    $mes = "";
                                    switch ($hm->mes) {
                                        case 1:
                                            $mes = "ENERO";
                                            break;
                                        case 2:
                                            $mes = "FEBRERO";
                                            break;
                                        case 3:
                                            $mes = "MARZO";
                                            break;
                                        case 4:
                                            $mes = "ABRIL"; 
                                            break;
                                        case 5:
                                            $mes = "MAYO";
                                            break;
                                        case 6:
                                            $mes = "JUNIO";
                                            break;
                                        case 7:
                                            $mes = "JULIO";
                                            break;
                                        case 8:
                                            $mes = "AGOSTO";
                                            break;
                                        case 9:
                                            $mes = "SETIEMBRE";
                                            break;
                                        case 10:
                                            $mes = "OCTUBRE";
                                            break;
                                        case 11:
                                            $mes = "NOVIEMBRE";
                                            break;
                                        case 12:
                                            $mes = "DICIEMBRE";
                                            break;
                                    }
                                ?>
                                <th>{{ $mes }}</th>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="text-navy"> S/.  4,956.52 </td>
                            <td class="text-navy"> S/. 5,649.48 </td>
                            <td class="text-navy"> S/. 5,542.37 </td>
                            <td class="text-navy"> S/. 5,542.37 </td> <!-- Cambiar indice historialCajaChica, por cada mes -->
                            <!-- mora, venta, historialCajaGrande, historialCajaChica, impuesto, ,  -->
                            <td class="text-navy"> S/. {{ 598 + 1279.9 - 350 - 3568.9 - 0 + 286 + 3147.7}} </td>
                            <td class="text-navy"> S/. 0.00 </td>
                            <td class="text-navy"> S/. 0.00 </td>
                            <td class="text-navy"> S/. 0.00 </td>
                            <td class="text-navy"> S/. 0.00 </td>
                            <td class="text-navy"> S/. 0.00 </td>
                            <td class="text-navy"> S/. 0.00 </td>
                            <td class="text-navy"> S/. 0.00 </td>
                            @foreach ($historialMes as $hm)
                                
                            @endforeach
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-12" id="graficoUtilidadMensual">

        </div>
        
        <div class="col-lg-12" id="graficoUtilidadAnual">

        </div>
    </div>
</div>
@endsection
@section('script')
    <script>
        function verHistorialMes(anio){
            swal("INFO", "Historial del año " + anio + ", en proceso de recuperación", "info");
            /*
            $.post( "{{ Route('analisisResultadoMes') }}", {anio: anio, _token:'{{csrf_token()}}'}).done(function(data) {
                $("#tabArMes").empty();
                $("#tabArMes").html(data.view);
            });
            */
        }
    </script>
@endsection
