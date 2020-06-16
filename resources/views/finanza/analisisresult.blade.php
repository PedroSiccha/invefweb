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
<div class="wrapper wrapper-content animated fadeInRight">
        <div class="col-lg-6">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Ingreso de Utilidades </h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#" class="dropdown-item">Config option 1</a>
                            </li>
                            <li><a href="#" class="dropdown-item">Config option 2</a>
                            </li>
                        </ul>
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
                                }else {
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
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#" class="dropdown-item">Config option 1</a>
                            </li>
                            <li><a href="#" class="dropdown-item">Config option 2</a>
                            </li>
                        </ul>
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
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#" class="dropdown-item">Config option 1</a>
                            </li>
                            <li><a href="#" class="dropdown-item">Config option 2</a>
                            </li>
                        </ul>
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
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#" class="dropdown-item">Config option 1</a>
                            </li>
                            <li><a href="#" class="dropdown-item">Config option 2</a>
                            </li>
                        </ul>
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
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#" class="dropdown-item">Config option 1</a>
                            </li>
                            <li><a href="#" class="dropdown-item">Config option 2</a>
                            </li>
                        </ul>
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
                                if ($gastosadministrativos[0]->gasto > 0) {
                                    $color = "text-navy";
                                }else {
                                    $color = "text-danger";
                                } 
                            ?>
                            <td class="{{ $color }}"> S/. {{ $gastosadministrativos[0]->gasto }} </td>
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
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#" class="dropdown-item">Config option 1</a>
                            </li>
                            <li><a href="#" class="dropdown-item">Config option 2</a>
                            </li>
                        </ul>
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
                                if (number_format((FLOAT)$utilidades[0]->utilidades + (FLOAT)$mora[0]->mora + (FLOAT)$venta[0]->venta - (FLOAT)$gastosadministrativos[0]->gasto, 2) > 0) {
                                    $color = "text-navy";
                                }else {
                                    $color = "text-danger";
                                } 
                            ?>
                            <td class="{{ $color }}"> S/. {{ number_format((FLOAT)$utilidades[0]->utilidades + (FLOAT)$mora[0]->mora + (FLOAT)$venta[0]->venta - (FLOAT)$gastosadministrativos[0]->gasto, 2) }} </td>
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
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#" class="dropdown-item">Config option 1</a>
                            </li>
                            <li><a href="#" class="dropdown-item">Config option 2</a>
                            </li>
                        </ul>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
        
                    <table class="table table-striped">
                        <tbody>
                        <tr>
                            <td class="text-navy"> S/. 0.00 </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>UTILIDADES NETAS </h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#" class="dropdown-item">Config option 1</a>
                            </li>
                            <li><a href="#" class="dropdown-item">Config option 2</a>
                            </li>
                        </ul>
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
                                if (number_format((FLOAT)$utilidades[0]->utilidades + (FLOAT)$mora[0]->mora + (FLOAT)$venta[0]->venta - (FLOAT)$gastosadministrativos[0]->gasto, 2) > 0) {
                                    $color = "text-navy";
                                }else {
                                    $color = "text-danger";
                                } 
                            ?>
                            <td class="{{ $color }}"> S/. {{ number_format((FLOAT)$utilidades[0]->utilidades + (FLOAT)$mora[0]->mora + (FLOAT)$venta[0]->venta - (FLOAT)$gastosadministrativos[0]->gasto, 2) }} </td>
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
                    <h5>Utilidades Netas Mensuales </h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#" class="dropdown-item">Config option 1</a>
                            </li>
                            <li><a href="#" class="dropdown-item">Config option 2</a>
                            </li>
                        </ul>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">

                    <table class="table table-striped">
                        <thead>
                        <tr>
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
                        <tr>
                            <td>1</td>
                            <td><span class="line">5,3,2,-1,-3,-2,2,3,5,2</span></td>
                            <td>Samantha</td>
                            <td class="text-navy"> <i class="fa fa-level-up"></i> 40% </td>
                            <td class="text-navy"> <i class="fa fa-level-up"></i> 40% </td>
                            <td class="text-navy"> <i class="fa fa-level-up"></i> 40% </td>
                            <td class="text-navy"> <i class="fa fa-level-up"></i> 40% </td>
                            <td class="text-navy"> <i class="fa fa-level-up"></i> 40% </td>
                            <td class="text-navy"> <i class="fa fa-level-up"></i> 40% </td>
                            <td class="text-navy"> <i class="fa fa-level-up"></i> 40% </td>
                            <td class="text-navy"> <i class="fa fa-level-up"></i> 40% </td>
                            <td class="text-navy"> <i class="fa fa-level-up"></i> 40% </td>
                            <td class="text-navy"> <i class="fa fa-level-up"></i> 40% </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-12" id="graficoUtilidadMensual">

        </div>
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Utilidades Netas Anuales </h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#" class="dropdown-item">Config option 1</a>
                            </li>
                            <li><a href="#" class="dropdown-item">Config option 2</a>
                            </li>
                        </ul>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">

                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>AÑO 2019</th>
                            <th>AÑO 2020</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>Samantha</td>
                            <td class="text-navy"> <i class="fa fa-level-up"></i> 40% </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-12" id="graficoUtilidadAnual">

        </div>
    </div>
</div>
@endsection
@section('script')
    <script>

    </script>
@endsection
