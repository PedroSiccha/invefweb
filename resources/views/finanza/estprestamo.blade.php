@extends('layouts.app')
@section('pagina')
    Estadísticas de Préstamos
@endsection
@section('contenido')

<div class="tabs-container">
    <ul class="nav nav-tabs" role="tablist">
        <li><a class="nav-link active" data-toggle="tab" href="#cPrestamo"> Prestamos</a></li>
        <!-- <li><a class="nav-link" data-toggle="tab" href="#cAlmacen"> Almacén</a></li> -->
        <!-- <li><a class="nav-link" data-toggle="tab" href="#cLiquidacion"> Liquidación</a></li> --> 
        <!-- <li><a class="nav-link" data-toggle="tab" href="#cVendido"> Vendidos</a></li> -->
        <!-- <li><a class="nav-link" data-toggle="tab" href="#cCliente"> Clientes</a></li> -->
        <li><a class="nav-link" data-toggle="tab" href="#cEfectivo"> Efectivo</a></li>
        <li><a class="nav-link" data-toggle="tab" href="#pActivos"> Prestamos Activos</a></li>
        <li><a class="nav-link" data-toggle="tab" href="#gInteres"> Ganancia de Interes</a></li>
        <li><a class="nav-link" data-toggle="tab" href="#gMora"> Ganancia por Moras</a></li>
        <li><a class="nav-link" data-toggle="tab" href="#gVenta"> Ganancia de Ventas</a></li>
        <li><a class="nav-link" data-toggle="tab" href="#gAdministrativo"> Gastos Administrativos</a></li>
    </ul>
    <div class="tab-content">
        <div role="tabpanel" id="cPrestamo" class="tab-pane active">
            <div class="panel-body">
                <div class="tabs-container">
                    <div class="col-lg-12">
                    <div class="tabs-left">
                        <ul class="nav nav-tabs">
                            <li><a class="nav-link active" data-toggle="tab" href="#dcPres"> Dia</a></li>
                            <li><a class="nav-link" data-toggle="tab" href="#mcPres"> Mes</a></li>
                            <li><a class="nav-link" data-toggle="tab" href="#acPres"> Año</a></li>
                        </ul>
                        <div class="tab-content ">
                            <div id="dcPres" class="tab-pane active">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="ibox "> 
                                                <div class="ibox-title">
                                                    <h5>Prestamos
                                                        <small>Cantidad de Prestamos Colocados al Día</small>
                                                    </h5>
                                                </div>
                                                
                                                <div class="ibox-content">
                                                    <!-- Cantidad de Prestamos por día -->
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <select class="form-control m-b" name="anioPrestamo" id="anioPrestamo">
                                                                <option value="0">Seleccionar un Año...</option>
                                                                @foreach ($anio as $a)
                                                                    <option value="{{ $a->anio }}">{{ $a->anio }}</option>    
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <select class="form-control m-b" name="mesPrestamo" id="mesPrestamo" onchange="mostrarPrestamo()">
                                                                <option>Seleccionar un mes...</option>
                                                                <option value="1">ENERO</option>
                                                                <option value="2">FEBRERO</option>  
                                                                <option value="3">MARZO</option>
                                                                <option value="4">ABRIL</option>
                                                                <option value="5">MAYO</option>
                                                                <option value="6">JUNIO</option>
                                                                <option value="7">JULIO</option>
                                                                <option value="8">AGOSTO</option>
                                                                <option value="9">SEPTIEMBRE</option>
                                                                <option value="10">OCTUBRE</option>
                                                                <option value="11">NOVIEMBRE</option>
                                                                <option value="12">DICIEMBRE</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    
                                                    <div>
                                                        <canvas id="canPrestamoChart" height="100%"></canvas>
                                                    </div>
                                                    <!-- Fin Cantidad de Prestamos por día -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="mcPres" class="tab-pane">
                                <div class="panel-body">
                                    <div class="row">
                                        <!-- Cantidad de Prestamos por Mes -->
                                        <div class="col-lg-12">
                                            <div class="ibox ">
                                                <div class="ibox-title">
                                                    <h5>Prestamos
                                                        <small>Cantidad de Prestamos Colocados al Mes</small>
                                                    </h5>
                                                </div>
                                                
                                                <div class="ibox-content">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <select class="form-control m-b" name="anioPrestamoMes" id="anioPrestamoMes" onchange="mostrarPrestamoMes()">
                                                                <option value="0">Seleccionar un Año...</option>
                                                                @foreach ($anio as $a)
                                                                    <option value="{{ $a->anio }}">{{ $a->anio }}</option>    
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    
                                                    <div>
                                                        <canvas id="canPrestamoMesChart" height="100%"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Fin Cantidad de Prestamos por mes -->
                                    </div>
                                </div>
                            </div>
                            <div id="acPres" class="tab-pane">
                                <div class="panel-body">
                                    <div class="row">
                                        <!-- Cantidad de Prestamos por año -->
                                        <div class="col-lg-12">
                                            <div class="ibox ">
                                                <div class="ibox-title">
                                                    <h5>Prestamos
                                                        <small>Cantidad de Prestamos Colocados po Año</small>
                                                    </h5>
                                                </div>
                                                
                                                <div class="ibox-content">
                                                    <div>
                                                        <canvas id="canPrestamoAnioChart" height="100%"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Fin Cantidad de Prestamos por año -->
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                </div>
                
            </div>
        </div>
        <div role="tabpanel" id="cAlmacen" class="tab-pane">
            <div class="panel-body">
                    <div class="tabs-container">
                        <div class="col-lg-12">
                        <div class="tabs-left">
                            <ul class="nav nav-tabs">
                                <li><a class="nav-link active" data-toggle="tab" href="#dcAlm"> Dia</a></li>
                                <li><a class="nav-link" data-toggle="tab" href="#mcAlm"> Mes</a></li>
                                <li><a class="nav-link" data-toggle="tab" href="#acAlm"> Año</a></li>
                            </ul>
                            <div class="tab-content ">
                                <div id="dcAlm" class="tab-pane active">
                                    <div class="panel-body">
                                        <div class="row">
                                            <!-- Cantidad de Bienes por día -->
                                            <div class="col-lg-12">
                                                <div class="ibox ">
                                                    <div class="ibox-title">
                                                        <h5>Almacen
                                                            <small>Cantidad de Bienes en Almacen por Día</small>
                                                        </h5>
                                                    </div>
                                                    
                                                    <div class="ibox-content">
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <select class="form-control m-b" name="anioBienesDia" id="anioBienesDia">
                                                                    <option value="0">Seleccionar un Año...</option>
                                                                    @foreach ($anio as $a)
                                                                        <option value="{{ $a->anio }}">{{ $a->anio }}</option>    
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <select class="form-control m-b" name="mesBienesDia" id="mesBienesDia" onchange="mostrarBienesDia()">
                                                                    <option>Seleccionar un mes...</option>
                                                                    <option value="1">ENERO</option>
                                                                    <option value="2">FEBRERO</option>  
                                                                    <option value="3">MARZO</option>
                                                                    <option value="4">ABRIL</option>
                                                                    <option value="5">MAYO</option>
                                                                    <option value="6">JUNIO</option>
                                                                    <option value="7">JULIO</option>
                                                                    <option value="8">AGOSTO</option>
                                                                    <option value="9">SEPTIEMBRE</option>
                                                                    <option value="10">OCTUBRE</option>
                                                                    <option value="11">NOVIEMBRE</option>
                                                                    <option value="12">DICIEMBRE</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        
                                                        <div>
                                                            <canvas id="canBienesDiaChart" height="100%"></canvas>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Fin Cantidad de Bienes por día -->
                                        </div>
                                    </div>
                                </div>
                                <div id="mcAlm" class="tab-pane">
                                    <div class="panel-body">
                                        <div class="row">
                                            <!-- Cantidad de Bienes por mes -->
                                            <div class="col-lg-12">
                                                <div class="ibox ">
                                                    <div class="ibox-title">
                                                        <h5>Almacen
                                                            <small>Cantidad de Bienes en Almacen por Mes</small>
                                                        </h5>
                                                    </div>
                                                    
                                                    <div class="ibox-content">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <select class="form-control m-b" name="anioBienesMes" id="anioBienesMes" onchange="mostrarBienesMes()">
                                                                    <option value="0">Seleccionar un Año...</option>
                                                                    @foreach ($anio as $a)
                                                                        <option value="{{ $a->anio }}">{{ $a->anio }}</option>    
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        
                                                        <div>
                                                            <canvas id="canBienesMesChart" height="100%"></canvas>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Fin Cantidad de Bienes por mes -->
                                        </div>
                                    </div>
                                </div>
                                <div id="acAlm" class="tab-pane">
                                    <div class="panel-body">
                                        <div class="row">
                                            <!-- Cantidad de Bienes por año -->
                                            <div class="col-lg-12">
                                                <div class="ibox ">
                                                    <div class="ibox-title">
                                                        <h5>Almacen
                                                            <small>Cantidad de Bienes en Almacen por Año</small>
                                                        </h5>
                                                    </div>
                                                    
                                                    <div class="ibox-content">
                                                        <div>
                                                            <canvas id="canBienesAnioChart" height="100%"></canvas>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Cantidad de Bienes por año -->
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    </div>
            </div>
        </div>
        <div role="tabpanel" id="cLiquidacion" class="tab-pane">
            <div class="panel-body">
                <div class="tabs-container">
                    <div class="col-lg-12">
                    <div class="tabs-left">
                        <ul class="nav nav-tabs">
                            <li><a class="nav-link active" data-toggle="tab" href="#dcLiq"> Dia</a></li>
                            <li><a class="nav-link" data-toggle="tab" href="#mcLiq"> Mes</a></li>
                            <li><a class="nav-link" data-toggle="tab" href="#acLiq"> Año</a></li>
                        </ul>
                        <div class="tab-content ">
                            <div id="dcLiq" class="tab-pane active">
                                <div class="panel-body">
                                    <div class="row">
                                        <!-- Cantidad de Articulos en Liquidacion por día -->
                                        <div class="col-lg-12">
                                            <div class="ibox ">
                                                <div class="ibox-title">
                                                    <h5>Liquidación
                                                        <small>Cantidad de Artículos en Liquidación por Día</small>
                                                    </h5>
                                                </div>
                                                
                                                <div class="ibox-content">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <select class="form-control m-b" name="anioLiquidacionDia" id="anioLiquidacionDia">
                                                                <option value="0">Seleccionar un Año...</option>
                                                                @foreach ($anio as $a)
                                                                    <option value="{{ $a->anio }}">{{ $a->anio }}</option>    
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <select class="form-control m-b" name="mesLiquidacionDia" id="mesLiquidacionDia" onchange="mostrarLiquidacionDia()">
                                                                <option>Seleccionar un mes...</option>
                                                                <option value="1">ENERO</option>
                                                                <option value="2">FEBRERO</option>  
                                                                <option value="3">MARZO</option>
                                                                <option value="4">ABRIL</option>
                                                                <option value="5">MAYO</option>
                                                                <option value="6">JUNIO</option>
                                                                <option value="7">JULIO</option>
                                                                <option value="8">AGOSTO</option>
                                                                <option value="9">SEPTIEMBRE</option>
                                                                <option value="10">OCTUBRE</option>
                                                                <option value="11">NOVIEMBRE</option>
                                                                <option value="12">DICIEMBRE</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    
                                                    <div>
                                                        <canvas id="canLiquidacionDiaChart" height="100%"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Fin Cantidad de Articulos en Liquidacion por día -->
                                    </div>
                                </div>
                            </div>
                            <div id="mcLiq" class="tab-pane">
                                <div class="panel-body">
                                    <div class="row">
                                        <!-- Cantidad de Liquidaciones por mes -->
                                        <div class="col-lg-12">
                                            <div class="ibox ">
                                                <div class="ibox-title">
                                                    <h5>Liquidación
                                                        <small>Cantidad de Artículos en Liquidacion por Mes</small>
                                                    </h5>
                                                </div>
                                                
                                                <div class="ibox-content">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <select class="form-control m-b" name="anioLiquidacionMes" id="anioLiquidacionMes" onchange="mostrarLiquidacionMes()">
                                                                <option value="0">Seleccionar un Año...</option>
                                                                @foreach ($anio as $a)
                                                                    <option value="{{ $a->anio }}">{{ $a->anio }}</option>    
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    
                                                    <div>
                                                        <canvas id="canLiquidacionMesChart" height="100%"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Fin Cantidad de Liquidacion por mes -->
                                    </div>
                                </div>
                            </div>
                            <div id="acLiq" class="tab-pane">
                                <div class="panel-body">
                                    <div class="row">
                                        <!-- Cantidad de Liquidacion por año -->
                                        <div class="col-lg-12">
                                            <div class="ibox ">
                                                <div class="ibox-title">
                                                    <h5>Liquidación
                                                        <small>Cantidad de Artículos en Liquidación por Año</small>
                                                    </h5>
                                                </div>
                                                
                                                <div class="ibox-content">
                                                    <div>
                                                        <canvas id="canLiquidacionAnioChart" height="100%"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Fin Cantidad de Liquidacion por año -->
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                </div>
            </div>
        </div>
        <div role="tabpanel" id="cVendido" class="tab-pane">
            <div class="panel-body">
                <div class="tabs-container">
                    <div class="col-lg-12">
                    <div class="tabs-left">
                        <ul class="nav nav-tabs">
                            <li><a class="nav-link active" data-toggle="tab" href="#dcVen"> Dia</a></li>
                            <li><a class="nav-link" data-toggle="tab" href="#mcVen"> Mes</a></li>
                            <li><a class="nav-link" data-toggle="tab" href="#acVen"> Año</a></li>
                        </ul>
                        <div class="tab-content ">
                            <div id="dcVen" class="tab-pane active">
                                <div class="panel-body">
                                    <div class="row">
                                        <!-- Cantidad de Vendido por día -->
                                        <div class="col-lg-12">
                                            <div class="ibox ">
                                                <div class="ibox-title">
                                                    <h5>Vendidos
                                                        <small>Cantidad de Artículos Vendidos por Día</small>
                                                    </h5>
                                                </div>
                                                
                                                <div class="ibox-content">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <select class="form-control m-b" name="anioVendidoDia" id="anioVendidoDia">
                                                                <option value="0">Seleccionar un Año...</option>
                                                                @foreach ($anio as $a)
                                                                    <option value="{{ $a->anio }}">{{ $a->anio }}</option>    
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <select class="form-control m-b" name="mesVendidoDia" id="mesVendidoDia" onchange="mostrarVendidoDia()">
                                                                <option>Seleccionar un mes...</option>
                                                                <option value="1">ENERO</option>
                                                                <option value="2">FEBRERO</option>  
                                                                <option value="3">MARZO</option>
                                                                <option value="4">ABRIL</option>
                                                                <option value="5">MAYO</option>
                                                                <option value="6">JUNIO</option>
                                                                <option value="7">JULIO</option>
                                                                <option value="8">AGOSTO</option>
                                                                <option value="9">SEPTIEMBRE</option>
                                                                <option value="10">OCTUBRE</option>
                                                                <option value="11">NOVIEMBRE</option>
                                                                <option value="12">DICIEMBRE</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    
                                                    <div>
                                                        <canvas id="canVendidoDiaChart" height="100%"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Fin Cantidad de Vendido por día -->
                                    </div>
                                </div>
                            </div>
                            <div id="mcVen" class="tab-pane">
                                <div class="panel-body">
                                    <div class="row">
                                        <!-- Cantidad de Vendido por mes -->
                                        <div class="col-lg-12">
                                            <div class="ibox ">
                                                <div class="ibox-title">
                                                    <h5>Vendidos
                                                        <small>Cantidad de Artículos Vendidos por Mes</small>
                                                    </h5>
                                                </div>
                                                
                                                <div class="ibox-content">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <select class="form-control m-b" name="anioVendidoMes" id="anioVendidoMes" onchange="mostrarVendidoMes()">
                                                                <option value="0">Seleccionar un Año...</option>
                                                                @foreach ($anio as $a)
                                                                    <option value="{{ $a->anio }}">{{ $a->anio }}</option>    
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    
                                                    <div>
                                                        <canvas id="canVendidoMesChart" height="100%"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Fin Cantidad de Vendido por mes -->
                                    </div>
                                </div>
                            </div>
                            <div id="acVen" class="tab-pane">
                                <div class="panel-body">
                                    <div class="row">
                                        <!-- Cantidad de Vendido por año -->
                                        <div class="col-lg-12">
                                            <div class="ibox ">
                                                <div class="ibox-title">
                                                    <h5>Vendidos
                                                        <small>Cantidad de Artículos Vendidos por Año</small>
                                                    </h5>
                                                </div>
                                                
                                                <div class="ibox-content">
                                                    <div>
                                                        <canvas id="canVendidoAnioChart" height="100%"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Cantidad de Vendido por año -->
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                </div>
            </div>
        </div>
        <div role="tabpanel" id="cCliente" class="tab-pane">
            <div class="panel-body">
                <div class="tabs-container">
                    <div class="col-lg-12">
                    <div class="tabs-left">
                        <ul class="nav nav-tabs">
                            <li><a class="nav-link active" data-toggle="tab" href="#dcCli"> Dia</a></li>
                            <li><a class="nav-link" data-toggle="tab" href="#mcCli"> Mes</a></li>
                            <li><a class="nav-link" data-toggle="tab" href="#acCli"> Año</a></li>
                        </ul>
                        <div class="tab-content ">
                            <div id="dcCli" class="tab-pane active">
                                <div class="panel-body">
                                    <div class="row">
                                        <!-- Cantidad de Clientes por día -->
                                        <div class="col-lg-12">
                                            <div class="ibox ">
                                                <div class="ibox-title">
                                                    <h5>Clientes
                                                        <small>Cantidad de Clientes Registrados por Día</small>
                                                    </h5>
                                                </div>
                                                
                                                <div class="ibox-content">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <select class="form-control m-b" name="anioClienteDia" id="anioClienteDia">
                                                                <option value="0">Seleccionar un Año...</option>
                                                                @foreach ($anio as $a)
                                                                    <option value="{{ $a->anio }}">{{ $a->anio }}</option>    
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <select class="form-control m-b" name="mesClienteDia" id="mesClienteDia" onchange="mostrarClienteDia()">
                                                                <option>Seleccionar un mes...</option>
                                                                <option value="1">ENERO</option>
                                                                <option value="2">FEBRERO</option>  
                                                                <option value="3">MARZO</option>
                                                                <option value="4">ABRIL</option>
                                                                <option value="5">MAYO</option>
                                                                <option value="6">JUNIO</option>
                                                                <option value="7">JULIO</option>
                                                                <option value="8">AGOSTO</option>
                                                                <option value="9">SEPTIEMBRE</option>
                                                                <option value="10">OCTUBRE</option>
                                                                <option value="11">NOVIEMBRE</option>
                                                                <option value="12">DICIEMBRE</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    
                                                    <div>
                                                        <canvas id="canClienteDiaChart" height="100%"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Fin Cantidad de Clientes por día -->
                                    </div>
                                </div>
                            </div>
                            <div id="mcCli" class="tab-pane">
                                <div class="panel-body">
                                    <div class="row">
                                        <!-- Cantidad de Clientes por mes -->
                                        <div class="col-lg-12">
                                            <div class="ibox ">
                                                <div class="ibox-title">
                                                    <h5>Clientes
                                                        <small>Cantidad de Clientes Registrados por Mes</small>
                                                    </h5>
                                                </div>
                                                
                                                <div class="ibox-content">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <select class="form-control m-b" name="anioClienteMes" id="anioClienteMes" onchange="mostrarClienteMes()">
                                                                <option value="0">Seleccionar un Año...</option>
                                                                @foreach ($anio as $a)
                                                                    <option value="{{ $a->anio }}">{{ $a->anio }}</option>    
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    
                                                    <div>
                                                        <canvas id="canClienteMesChart" height="100%"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Cantidad de Clientes por mes -->
                                    </div>
                                </div>
                            </div>
                            <div id="acCli" class="tab-pane">
                                <div class="panel-body">
                                    <div class="row">
                                        <!-- Cantidad de Clientes por año -->
                                        <div class="col-lg-12">
                                            <div class="ibox ">
                                                <div class="ibox-title">
                                                    <h5>Clientes
                                                        <small>Cantidad de Clientes Registrados por Año</small>
                                                    </h5>
                                                </div>
                                                
                                                <div class="ibox-content">
                                                    <div>
                                                        <canvas id="canClienteAnioChart" height="100%"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Cantidad de Clientes por año -->
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                </div>
            </div>
        </div>
        <div role="tabpanel" id="cEfectivo" class="tab-pane">
            <div class="panel-body">
                <div class="tabs-container">
                    <div class="col-lg-12">
                    <div class="tabs-left">
                        <ul class="nav nav-tabs">
                            <li><a class="nav-link active" data-toggle="tab" href="#dcEfe"> Dia</a></li>
                            <li><a class="nav-link" data-toggle="tab" href="#mcEfe"> Mes</a></li>
                            <li><a class="nav-link" data-toggle="tab" href="#acEfe"> Año</a></li>
                        </ul>
                        <div class="tab-content ">
                            <div id="dcEfe" class="tab-pane active">
                                <div class="panel-body">
                                    <div class="row">
                                        <!-- Cantidad de Efectivo por día -->
                                        <div class="col-lg-12">
                                            <div class="ibox ">
                                                <div class="ibox-title">
                                                    <h5>Efectivo
                                                        <small>Cantidad de Efectivo Colocado por Día</small>
                                                    </h5>
                                                </div>
                                                
                                                <div class="ibox-content">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <select class="form-control m-b" name="anioEfectivoDia" id="anioEfectivoDia">
                                                                <option value="0">Seleccionar un Año...</option>
                                                                @foreach ($anio as $a)
                                                                    <option value="{{ $a->anio }}">{{ $a->anio }}</option>    
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <select class="form-control m-b" name="mesEfectivoDia" id="mesEfectivoDia" onchange="mostrarEfectivoDia()">
                                                                <option>Seleccionar un mes...</option>
                                                                <option value="1">ENERO</option>
                                                                <option value="2">FEBRERO</option>  
                                                                <option value="3">MARZO</option>
                                                                <option value="4">ABRIL</option>
                                                                <option value="5">MAYO</option>
                                                                <option value="6">JUNIO</option>
                                                                <option value="7">JULIO</option>
                                                                <option value="8">AGOSTO</option>
                                                                <option value="9">SEPTIEMBRE</option>
                                                                <option value="10">OCTUBRE</option>
                                                                <option value="11">NOVIEMBRE</option>
                                                                <option value="12">DICIEMBRE</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    
                                                    <div>
                                                        <canvas id="canEfectivoDiaChart" height="100%"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Fin Cantidad de Efectivo por día -->
                                    </div>
                                </div>
                            </div>
                            <div id="mcEfe" class="tab-pane">
                                <div class="panel-body">
                                    <div class="row">
                                        <!-- Cantidad de Efectivo por Mes -->
                                        <div class="col-lg-12">
                                            <div class="ibox ">
                                                <div class="ibox-title">
                                                    <h5>Efectivo
                                                        <small>Cantidad de Efectivo Colocado por Mes</small>
                                                    </h5>
                                                </div>
                                                
                                                <div class="ibox-content">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <select class="form-control m-b" name="anioEfectivoMes" id="anioEfectivoMes" onchange="mostrarEfectivoMes()">
                                                                <option value="0">Seleccionar un Año...</option>
                                                                @foreach ($anio as $a)
                                                                    <option value="{{ $a->anio }}">{{ $a->anio }}</option>    
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    
                                                    <div>
                                                        <canvas id="canEfectivoMesChart" height="100%"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Fin Cantidad de Efectivo por mes -->
                                    </div>
                                </div>
                            </div>
                            <div id="acEfe" class="tab-pane">
                                <div class="panel-body">
                                    <div class="row">
                                        <!-- Cantidad de Efectivo por año -->
                                        <div class="col-lg-12">
                                            <div class="ibox ">
                                                <div class="ibox-title">
                                                    <h5>Efectivo
                                                        <small>Cantidad de Efectivo Colocado por Año</small>
                                                    </h5>
                                                </div>
                                                
                                                <div class="ibox-content">
                                                    <div>
                                                        <canvas id="canEfectivoAnioChart" height="100%"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Fin Cantidad de Efectivo por año -->
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                </div>
            </div>
        </div>
        <div role="tabpanel" id="gInteres" class="tab-pane">
            <div class="panel-body">
                <div class="tabs-container">
                    <div class="col-lg-12">
                    <div class="tabs-left">
                        <ul class="nav nav-tabs">
                            <li><a class="nav-link active" data-toggle="tab" href="#dgInt"> Dia</a></li>
                            <li><a class="nav-link" data-toggle="tab" href="#mgInt"> Mes</a></li>
                            <li><a class="nav-link" data-toggle="tab" href="#agInt"> Año</a></li>
                        </ul>
                        <div class="tab-content ">
                            <div id="dgInt" class="tab-pane active">
                                <div class="panel-body">
                                    <div class="row">
                                        <!-- Cantidad de Interes por día -->
                                        <div class="col-lg-12">
                                            <div class="ibox ">
                                                <div class="ibox-title">
                                                    <h5>Ganancia de Interes
                                                        <small>Cantidad de Utilidades del Interes por Día</small>
                                                    </h5>
                                                </div>
                                                
                                                <div class="ibox-content">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <select class="form-control m-b" name="anioInteresDia" id="anioInteresDia">
                                                                <option value="0">Seleccionar un Año...</option>
                                                                @foreach ($anio as $a)
                                                                    <option value="{{ $a->anio }}">{{ $a->anio }}</option>    
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <select class="form-control m-b" name="mesInteresDia" id="mesInteresDia" onchange="mostrarInteresDia()">
                                                                <option>Seleccionar un mes...</option>
                                                                <option value="1">ENERO</option>
                                                                <option value="2">FEBRERO</option>  
                                                                <option value="3">MARZO</option>
                                                                <option value="4">ABRIL</option>
                                                                <option value="5">MAYO</option>
                                                                <option value="6">JUNIO</option>
                                                                <option value="7">JULIO</option>
                                                                <option value="8">AGOSTO</option>
                                                                <option value="9">SEPTIEMBRE</option>
                                                                <option value="10">OCTUBRE</option>
                                                                <option value="11">NOVIEMBRE</option>
                                                                <option value="12">DICIEMBRE</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    
                                                    <div>
                                                        <canvas id="canInteresDiaChart" height="100%"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Fin Cantidad de Interes por día -->
                                    </div>
                                </div>
                            </div>
                            <div id="mgInt" class="tab-pane">
                                <div class="panel-body">
                                    <div class="row">
                                        <!-- Cantidad de Interes por mes -->
                                        <div class="col-lg-12">
                                            <div class="ibox ">
                                                <div class="ibox-title">
                                                    <h5>Ganancia de Interes
                                                        <small>Cantidad de Utilidades del Interes por Mes</small>
                                                    </h5>
                                                </div>
                                                
                                                <div class="ibox-content">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <select class="form-control m-b" name="anioInteresMes" id="anioInteresMes" onchange="mostrarInteresMes()">
                                                                <option value="0">Seleccionar un Año...</option>
                                                                @foreach ($anio as $a)
                                                                    <option value="{{ $a->anio }}">{{ $a->anio }}</option>    
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    
                                                    <div>
                                                        <canvas id="canInteresMesChart" height="100%"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Fin Cantidad de Interes por mes -->
                                    </div>
                                </div>
                            </div>
                            <div id="agInt" class="tab-pane">
                                <div class="panel-body">
                                    <div class="row">
                                        <!-- Cantidad de Interes por año -->
                                        <div class="col-lg-12">
                                            <div class="ibox ">
                                                <div class="ibox-title">
                                                    <h5>Ganancia de Interes
                                                        <small>Cantidad de Utilidades del Interes por Años</small>
                                                    </h5>
                                                </div>
                                                
                                                <div class="ibox-content">
                                                    <div>
                                                        <canvas id="canInteresAnioChart" height="100%"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Fin Cantidad de Interes por año -->
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                </div>
            </div>
        </div>
        <div role="tabpanel" id="gMora" class="tab-pane">
            <div class="panel-body">
                <div class="tabs-container">
                    <div class="col-lg-12">
                    <div class="tabs-left">
                        <ul class="nav nav-tabs">
                            <li><a class="nav-link active" data-toggle="tab" href="#dgMor"> Dia</a></li>
                            <li><a class="nav-link" data-toggle="tab" href="#mgMor"> Mes</a></li>
                            <li><a class="nav-link" data-toggle="tab" href="#agMor"> Año</a></li>
                        </ul>
                        <div class="tab-content ">
                            <div id="dgMor" class="tab-pane active">
                                <div class="panel-body">
                                    <div class="row">
                                        <!-- Cantidad de Mora por día -->
                                        <div class="col-lg-12">
                                            <div class="ibox ">
                                                <div class="ibox-title">
                                                    <h5>Ganancia por Mora
                                                        <small>Cantidad de Ganancias por Moras del Día</small>
                                                    </h5>
                                                </div>
                                                
                                                <div class="ibox-content">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <select class="form-control m-b" name="anioMoraDia" id="anioMoraDia">
                                                                <option value="0">Seleccionar un Año...</option>
                                                                @foreach ($anio as $a)
                                                                    <option value="{{ $a->anio }}">{{ $a->anio }}</option>    
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <select class="form-control m-b" name="mesMoraDia" id="mesMoraDia" onchange="mostrarMoraDia()">
                                                                <option>Seleccionar un mes...</option>
                                                                <option value="1">ENERO</option>
                                                                <option value="2">FEBRERO</option>  
                                                                <option value="3">MARZO</option>
                                                                <option value="4">ABRIL</option>
                                                                <option value="5">MAYO</option>
                                                                <option value="6">JUNIO</option>
                                                                <option value="7">JULIO</option>
                                                                <option value="8">AGOSTO</option>
                                                                <option value="9">SEPTIEMBRE</option>
                                                                <option value="10">OCTUBRE</option>
                                                                <option value="11">NOVIEMBRE</option>
                                                                <option value="12">DICIEMBRE</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    
                                                    <div>
                                                        <canvas id="canMoraDiaChart" height="100%"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Fin Cantidad de Mora por día -->
                                    </div>
                                </div>
                            </div>
                            <div id="mgMor" class="tab-pane">
                                <div class="panel-body">
                                    <div class="row">
                                        <!-- Cantidad de Mora por mes -->
                                        <div class="col-lg-12">
                                            <div class="ibox ">
                                                <div class="ibox-title">
                                                    <h5>Ganancia por Moras
                                                        <small>Cantidad de Ganancias por Mora del Mes</small>
                                                    </h5>
                                                </div>
                                                
                                                <div class="ibox-content">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <select class="form-control m-b" name="anioMoraMes" id="anioMoraMes" onchange="mostrarMoraMes()">
                                                                <option value="0">Seleccionar un Año...</option>
                                                                @foreach ($anio as $a)
                                                                    <option value="{{ $a->anio }}">{{ $a->anio }}</option>    
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    
                                                    <div>
                                                        <canvas id="canMoraMesChart" height="100%"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Fin Cantidad de Mora por mes -->
                                    </div>
                                </div>
                            </div>
                            <div id="agMor" class="tab-pane">
                                <div class="panel-body">
                                    <div class="row">
                                        <!-- Cantidad de Mora por año -->
                                        <div class="col-lg-12">
                                            <div class="ibox ">
                                                <div class="ibox-title">
                                                    <h5>Ganancia por Mora
                                                        <small>Cantidad de Ganancias por Mora del Año</small>
                                                    </h5>
                                                </div>
                                                
                                                <div class="ibox-content">
                                                    <div>
                                                        <canvas id="canMoraAnioChart" height="100%"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Fin Cantidad de Mora por año -->
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                </div>
            </div>
        </div>
        <div role="tabpanel" id="gVenta" class="tab-pane">
            <div class="panel-body">
                <div class="tabs-container">
                    <div class="col-lg-12">
                    <div class="tabs-left">
                        <ul class="nav nav-tabs">
                            <li><a class="nav-link active" data-toggle="tab" href="#dgVen"> Dia</a></li>
                            <li><a class="nav-link" data-toggle="tab" href="#mgVen"> Mes</a></li>
                            <li><a class="nav-link" data-toggle="tab" href="#agVen"> Año</a></li>
                        </ul>
                        <div class="tab-content ">
                            <div id="dgVen" class="tab-pane active">
                                <div class="panel-body">
                                    <div class="row">
                                        <!-- Cantidad de Venta por día -->
                                        <div class="col-lg-12">
                                            <div class="ibox ">
                                                <div class="ibox-title">
                                                    <h5>Ganancia de Ventas
                                                        <small>Cantidad de Ganancia Extra de Ventas por Día</small>
                                                    </h5>
                                                </div>
                                                
                                                <div class="ibox-content">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <select class="form-control m-b" name="anioVentaDia" id="anioVentaDia">
                                                                <option value="0">Seleccionar un Año...</option>
                                                                @foreach ($anio as $a)
                                                                    <option value="{{ $a->anio }}">{{ $a->anio }}</option>    
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <select class="form-control m-b" name="mesVentaDia" id="mesVentaDia" onchange="mostrarVentaDia()">
                                                                <option>Seleccionar un mes...</option>
                                                                <option value="1">ENERO</option>
                                                                <option value="2">FEBRERO</option>  
                                                                <option value="3">MARZO</option>
                                                                <option value="4">ABRIL</option>
                                                                <option value="5">MAYO</option>
                                                                <option value="6">JUNIO</option>
                                                                <option value="7">JULIO</option>
                                                                <option value="8">AGOSTO</option>
                                                                <option value="9">SEPTIEMBRE</option>
                                                                <option value="10">OCTUBRE</option>
                                                                <option value="11">NOVIEMBRE</option>
                                                                <option value="12">DICIEMBRE</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    
                                                    <div>
                                                        <canvas id="canVentaDiaChart" height="100%"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Fin Cantidad de Venta por día -->
                                    </div>
                                </div>
                            </div>
                            <div id="mgVen" class="tab-pane">
                                <div class="panel-body">
                                    <div class="row">
                                        <!-- Cantidad de Venta por mes -->
                                        <div class="col-lg-12">
                                            <div class="ibox ">
                                                <div class="ibox-title">
                                                    <h5>Ganancia de Ventas
                                                        <small>Cantidad de Ganancia Extra de Ventas por Mes</small>
                                                    </h5>
                                                </div>
                                                
                                                <div class="ibox-content">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <select class="form-control m-b" name="anioVentaMes" id="anioVentaMes" onchange="mostrarVentaMes()">
                                                                <option value="0">Seleccionar un Año...</option>
                                                                @foreach ($anio as $a)
                                                                    <option value="{{ $a->anio }}">{{ $a->anio }}</option>    
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    
                                                    <div>
                                                        <canvas id="canVentaMesChart" height="100%"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Fin Cantidad de Venta mes -->
                                    </div>
                                </div>
                            </div>
                            <div id="agVen" class="tab-pane">
                                <div class="panel-body">
                                    <div class="row">
                                        <!-- Cantidad de Ventas por año -->
                                        <div class="col-lg-12">
                                            <div class="ibox ">
                                                <div class="ibox-title">
                                                    <h5>Ganancia de Ventas
                                                        <small>Cantidad de Ganancia Extra de Ventas por Año</small>
                                                    </h5>
                                                </div>
                                                
                                                <div class="ibox-content">
                                                    <div>
                                                        <canvas id="canVentaAnioChart" height="100%"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Cantidad de Ventas por año -->
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                </div>
            </div>
        </div>
        <div role="tabpanel" id="gAdministrativo" class="tab-pane">
            <div class="panel-body">
                <div class="tabs-container">
                    <div class="col-lg-12">
                    <div class="tabs-left">
                        <ul class="nav nav-tabs">
                            <li><a class="nav-link active" data-toggle="tab" href="#dgAdm"> Dia</a></li>
                            <li><a class="nav-link" data-toggle="tab" href="#mgAdm"> Mes</a></li>
                            <li><a class="nav-link" data-toggle="tab" href="#agAdm"> Año</a></li>
                        </ul>
                        <div class="tab-content ">
                            <div id="dgAdm" class="tab-pane active">
                                <div class="panel-body">
                                    <div class="row">
                                        <!-- Cantidad de Administrativos por dia -->
                                        <div class="col-lg-12">
                                            <div class="ibox ">
                                                <div class="ibox-title">
                                                    <h5>Gastos Administrativos
                                                        <small>Gastos Administrativos por Día</small>
                                                    </h5>
                                                </div>
                                                
                                                <div class="ibox-content">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <select class="form-control m-b" name="anioAdministrativoDia" id="anioAdministrativoDia">
                                                                <option value="0">Seleccionar un Año...</option>
                                                                @foreach ($anio as $a)
                                                                    <option value="{{ $a->anio }}">{{ $a->anio }}</option>    
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <select class="form-control m-b" name="mesAdministrativoDia" id="mesAdministrativoDia" onchange="mostrarAdministrativoDia()">
                                                                <option>Seleccionar un mes...</option>
                                                                <option value="1">ENERO</option>
                                                                <option value="2">FEBRERO</option>  
                                                                <option value="3">MARZO</option>
                                                                <option value="4">ABRIL</option>
                                                                <option value="5">MAYO</option>
                                                                <option value="6">JUNIO</option>
                                                                <option value="7">JULIO</option>
                                                                <option value="8">AGOSTO</option>
                                                                <option value="9">SEPTIEMBRE</option>
                                                                <option value="10">OCTUBRE</option>
                                                                <option value="11">NOVIEMBRE</option>
                                                                <option value="12">DICIEMBRE</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    
                                                    <div>
                                                        <canvas id="canAdministrativoDiaChart" height="100%"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Fin Cantidad de Administrativo por día -->
                                    </div>
                                </div>
                            </div>
                            <div id="mgAdm" class="tab-pane">
                                <div class="panel-body">
                                    <div class="row">
                                        <!-- Cantidad de Administrativa por Mes -->
                                        <div class="col-lg-12">
                                            <div class="ibox ">
                                                <div class="ibox-title">
                                                    <h5>Gastos Administrativos
                                                        <small>Gastos Administrativos por Mes</small>
                                                    </h5>
                                                </div>
                                                
                                                <div class="ibox-content">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <select class="form-control m-b" name="anioAdministrativoMes" id="anioAdministrativoMes" onchange="mostrarAdministrativoMes()">
                                                                <option value="0">Seleccionar un Año...</option>
                                                                @foreach ($anio as $a)
                                                                    <option value="{{ $a->anio }}">{{ $a->anio }}</option>    
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    
                                                    <div>
                                                        <canvas id="canAdministrativoMesChart" height="100%"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Fin Cantidad de Administrativo por Mes -->
                                    </div>
                                </div>
                            </div>
                            <div id="agAdm" class="tab-pane">
                                <div class="panel-body">
                                    <div class="row">
                                        <!-- Cantidad de Administrativo por año -->
                                        <div class="col-lg-12">
                                            <div class="ibox ">
                                                <div class="ibox-title">
                                                    <h5>Gastos Administrativos
                                                        <small>Gastos Administrativos por Año</small>
                                                    </h5>
                                                </div>
                                                
                                                <div class="ibox-content">
                                                    <div>
                                                        <canvas id="canAdministrativoAnioChart" height="100%"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Fin Cantidad de Administrativo por año -->
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                </div>
            </div>
        </div>

        <div role="tabpanel" id="pActivos" class="tab-pane">
            <div class="panel-body">
                <div class="tabs-container">
                    <div class="col-lg-12">
                    <div class="tabs-left">
                        <ul class="nav nav-tabs">
                            <li><a class="nav-link active" data-toggle="tab" href="#dpAct"> Dia</a></li>
                            <li><a class="nav-link" data-toggle="tab" href="#mpAct"> Mes</a></li>
                            <li><a class="nav-link" data-toggle="tab" href="#apAct"> Año</a></li>
                        </ul>
                        <div class="tab-content ">
                            <div id="dpAct" class="tab-pane active">
                                <div class="panel-body">
                                    <div class="row">
                                        <!-- Cantidad de Prestamos Activos por dia -->
                                        <div class="col-lg-12">
                                            <div class="ibox ">
                                                <div class="ibox-title">
                                                    <h5>Prestamos Activos
                                                        <small>Prestamos Activos por Día</small>
                                                    </h5>
                                                </div>
                                                
                                                <div class="ibox-content">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <select class="form-control m-b" name="aniopActivosDia" id="aniopActivosDia">
                                                                <option value="0">Seleccionar un Año...</option>
                                                                @foreach ($anio as $a)
                                                                    <option value="{{ $a->anio }}">{{ $a->anio }}</option>    
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <select class="form-control m-b" name="mespActivosDia" id="mespActivosDia" onchange="mostrarPrestamoActivoDia()">
                                                                <option>Seleccionar un mes...</option>
                                                                <option value="1">ENERO</option>
                                                                <option value="2">FEBRERO</option>  
                                                                <option value="3">MARZO</option>
                                                                <option value="4">ABRIL</option>
                                                                <option value="5">MAYO</option>
                                                                <option value="6">JUNIO</option>
                                                                <option value="7">JULIO</option>
                                                                <option value="8">AGOSTO</option>
                                                                <option value="9">SEPTIEMBRE</option>
                                                                <option value="10">OCTUBRE</option>
                                                                <option value="11">NOVIEMBRE</option>
                                                                <option value="12">DICIEMBRE</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    
                                                    <div>
                                                        <canvas id="canpActivosDiaChart" height="100%"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Fin Cantidad de Prestamos Activos por día -->
                                    </div>
                                </div>
                            </div>
                            <div id="mpAct" class="tab-pane">
                                <div class="panel-body">
                                    <div class="row">
                                        <!-- Cantidad de Prestamos Activados por Mes -->
                                        <div class="col-lg-12">
                                            <div class="ibox ">
                                                <div class="ibox-title">
                                                    <h5>Prestamos Activos
                                                        <small>Prestamos Activos por Mes</small>
                                                    </h5>
                                                </div>
                                                
                                                <div class="ibox-content">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <select class="form-control m-b" name="aniopActivosMes" id="aniopActivosMes" onchange="mostrarpActivosMes()">
                                                                <option value="0">Seleccionar un Año...</option>
                                                                @foreach ($anio as $a)
                                                                    <option value="{{ $a->anio }}">{{ $a->anio }}</option>    
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    
                                                    <div>
                                                        <canvas id="canPactivosMesChart" height="100%"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Fin Cantidad de Prestamos Activos por Mes -->
                                    </div>
                                </div>
                            </div>
                            <div id="apAct" class="tab-pane">
                                <div class="panel-body">
                                    <div class="row">
                                        <!-- Cantidad de Prestamos Activos por año -->
                                        <div class="col-lg-12">
                                            <div class="ibox ">
                                                <div class="ibox-title">
                                                    <h5>Prestamos Activos
                                                        <small>Prestamos Activos por Año</small>
                                                    </h5>
                                                </div>
                                                
                                                <div class="ibox-content">
                                                    <div>
                                                        <canvas id="canpActivosAnioChart" height="100%"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Fin Prestamos Activos por año -->
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>


</div>
@endsection
@section('script')
<script src="js/plugins/chartJs/Chart.min.js"></script>

<script>

    $(document).ready(graficoAnual);

    function graficoAnual() {
        
        $.post( "{{ Route('graficoEstPrestamoAnual') }}", { _token:'{{csrf_token()}}'}).done(function(data) {
                var datos = jQuery.parseJSON(data);
                var totalanios = datos.totalanio;
                var numanio = datos.numanio;
                
                var renovacion = datos.renovacion;
                var prestamosActivos = datos.prestamosActivos;
                var gastosAdministrativos = datos.gastosAdministrativos;
                var venta = datos.venta;
                var mora = datos.mora;
                var interes = datos.interes;
                var efectivo = datos.efectivo;
                var prestamos = datos.prestamos;
                
                var anio = [];
                
                var cantRenovaciones = [];
                var cantPrestActivos = [];
                var montoGastoAdministrativo = [];
                var cantVenta = [];
                var montoMora = [];
                var montoInteres = [];
                var montoEfectivo = [];
                var cantPrestamos = [];
                for(i=0; i<totalanios; i++){
                    anio.push( numanio[i] );
                    
                    cantRenovaciones.push( renovacion[i] );
                    cantPrestActivos.push( prestamosActivos[i] );
                    montoGastoAdministrativo.push( gastosAdministrativos[i] );
                    cantVenta.push( venta[i] );
                    montoMora.push( mora[i] );
                    montoInteres.push( interes[i] );
                    montoEfectivo.push( efectivo[i] );
                    cantPrestamos.push( prestamos[i] );
                }
/*
                new Chart(document.getElementById("canFlujoCajaAnioChart"), {
                    type: 'line',
                    data: {
                        labels: datos.numanio,
                        datasets: [
                            {
                                data: datos.montoIngreso,
                                label: "Monto de Ingreso",
                                borderColor: "#3e95cd"
                            },
                            {
                                data: datos.montoEgreso,
                                label: "Monto de Egreso",
                                borderColor: "#C72200"
                            }
                        ]
                    },
                    options: {
                        title: {
                            display: true,
                            text: 'Balance Anual de los Gastos Administrativos'
                        }
                    }
                });
                */

                
                new Chart(document.getElementById("canPrestamoAnioChart"), {
                    type: 'bar',
                    data: {
                        labels: datos.numanio,
                        datasets: [{
                            data: datos.prestamos,
                            label: "Cantidad de Prestamo",
                            borderColor: "#3e95cd",
                            backgroundColor: "#3e95cd"
                        }]
                    },
                    options: {
                        title: {
                            display: true,
                            text: 'Balance Anual de Prestamo'
                        }
                    }
                });

                
                new Chart(document.getElementById("canEfectivoAnioChart"), {
                    type: 'bar',
                    data: {
                        labels: datos.numanio,
                        datasets: [{
                            data: datos.efectivo,
                            label: "Cantidad de Efectivo",
                            borderColor: "#3e95cd",
                            backgroundColor: "#3e95cd"
                        }]
                    },
                    options: {
                        title: {
                            display: true,
                            text: 'Balance Anual de Efectivo'
                        }
                    }
                });

        
                new Chart(document.getElementById("canInteresAnioChart"), {
                    type: 'bar',
                    data: {
                        labels: datos.numanio,
                        datasets: [{
                            data: datos.interes,
                            label: "Cantidad de Interes",
                            borderColor: "#3e95cd",
                            backgroundColor: "#3e95cd"
                        }]
                    },
                    options: {
                        title: {
                            display: true,
                            text: 'Balance Anual de Interes'
                        }
                    }
                });

        
                new Chart(document.getElementById("canMoraAnioChart"), {
                    type: 'bar',
                    data: {
                        labels: datos.numanio,
                        datasets: [{
                            data: datos.mora,
                            label: "Cantidad de Mora",
                            borderColor: "#3e95cd",
                            backgroundColor: "#3e95cd"
                        }]
                    },
                    options: {
                        title: {
                            display: true,
                            text: 'Balance Anual de Mora'
                        }
                    }
                });

        
                new Chart(document.getElementById("canVentaAnioChart"), {
                    type: 'bar',
                    data: {
                        labels: datos.numanio,
                        datasets: [{
                            data: datos.venta,
                            label: "Cantidad de Venta",
                            borderColor: "#3e95cd",
                            backgroundColor: "#3e95cd"
                        }]
                    },
                    options: {
                        title: {
                            display: true,
                            text: 'Balance Anual de Venta'
                        }
                    }
                });

        
                new Chart(document.getElementById("canAdministrativoAnioChart"), {
                    type: 'bar',
                    data: {
                        labels: datos.numanio,
                        datasets: [{
                            data: datos.gastosAdministrativos,
                            label: "Gastos Administrativos",
                            borderColor: "#3e95cd",
                            backgroundColor: "#3e95cd"
                        }]
                    },
                    options: {
                        title: {
                            display: true,
                            text: 'Balance Anual de los Gastos Administrativos'
                        }
                    }
                });

                
                new Chart(document.getElementById("canpActivosAnioChart"), {
                    type: 'bar',
                    data: {
                        labels: datos.numanio,
                        datasets: [
                            {
                                data: datos.prestamosActivos,
                                label: "Cantidad de Prestamos Activos",
                                borderColor: "#3e95cd",
                                backgroundColor: "#3e95cd"
                            },
                            {
                                data: datos.renovacion,
                                label: "Cantidad de Renovacion",
                                borderColor: "#C72200",
                                backgroundColor: "#C72200"
                            }
                        ]
                    },
                    options: {
                        title: {
                            display: true,
                            text: 'Balance Mensual de Administrativo'
                        }
                    }
                });
        });
    }

    function mostrarPrestamo() {
        var anio = $('#anioPrestamo').val();
        var mes = $('#mesPrestamo').val();
        

        if (anio == 0) {
            toastr.error("Primero Seleccione el AÑO para continuar");
        }else{
            $.post( "{{ Route('graficoLineaPrestamo') }}", {anio: anio, mes: mes, _token:'{{csrf_token()}}'}).done(function(data) {

                
                var datos = jQuery.parseJSON(data);
                var totaldias = datos.totaldias;
                var registrosdia = datos.registrosdia;
                var i=0;
                var dias = [];
                var cantPrestamos = [];
                for(i=1; i<=totaldias; i++){
                    dias.push(i); 
                    cantPrestamos.push( registrosdia[i] );
                }

                new Chart(document.getElementById("canPrestamoChart"), {
                    type: 'bar',
                    data: {
                        labels: dias, //Cargar dias
                        datasets: [{ 
                            data: cantPrestamos, //Cantidad de Prestamos
                            label: "Cantidad de Prestamo",
                            borderColor: "#3e95cd",
                            backgroundColor: "#3e95cd"
                        }]
                    },
                    options: {
                        title: {
                        display: true,
                        text: 'Balance Mensual de Prestamo'
                        }
                    }
                });

            });
        }
    };

    function mostrarPrestamoEstado() {
        var anio = $('#anioPrestamoEstado').val();
        var mes = $('#mesPrestamoEstado').val();
        var estado = $('#estadoPrestamo').val();

        if (anio == 0) {
            toastr.error("Primero Seleccione el AÑO para continuar");
        }else{
            $.post( "{{ Route('graficoLineaPrestamoEstado') }}", {anio: anio, mes: mes, estado: estado, _token:'{{csrf_token()}}'}).done(function(data) {

                
                var dato = jQuery.parseJSON(data);
                var totaldias = dato.totaldias;
                var registrosdia = dato.registrosdia;
                var i=0;
                var diasEstado = [];
                var cantPrestamosEstado = [];
                for(i=1; i<=totaldias; i++){

                    diasEstado.push(i);
                    cantPrestamosEstado.push( registrosdia[i] );
                }

                new Chart(document.getElementById("canPrestamoEstadoChart"), {
                    type: 'line',
                    data: {
                        labels: diasEstado, //Cargar dias
                        datasets: [{ 
                            data: cantPrestamosEstado, //Cantidad de Prestamos
                            label: "Cantidad de Prestamo",
                            borderColor: "#3e95cd"
                        }]
                    },
                    options: {
                        title: {
                        display: true,
                        text: 'Balance Mensual de Prestamo'
                        }
                    }
                });

                new Chart(document.getElementById("canPrestamoEstadoChartPie"), {
                    type: 'pie',
                    data: {
                    labels: ["Pagado", "Vendido", "Desembolso", "Liquidacion", "Activo"],
                    datasets: [{
                        label: "Estados de Prestamos",
                        backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850","#c45578"],
                        data: [12,1,3,1,5]
                        }]
                    },
                    options: {
                    title: {
                        display: true,
                        text: 'Predicted world population (millions) in 2050'
                      }
                    }
                });

            });
        }
    };

    function mostrarBienesDia() {
        var anio = $('#anioBienesDia').val();
        var mes = $('#mesBienesDia').val();

        if (anio == 0) {
            toastr.error("Primero Seleccione el AÑO para continuar");
        }else{

            $.post( "{{ Route('graficoLineaBienesDia') }}", {anio: anio, mes: mes, _token:'{{csrf_token()}}'}).done(function(data) {

                var datos = jQuery.parseJSON(data);
                var totaldias = datos.totaldias;
                var registrosdia = datos.registrosdia;
                var i=0;
                var dias = [];
                var cantBienesDia = [];
                for(i=1; i<=totaldias; i++){
                    dias.push(i);
                    cantBienesDia.push( registrosdia[i] );
                }

                new Chart(document.getElementById("canBienesDiaChart"), {
                    type: 'line',
                    data: {
                        labels: dias, //Cargar dias
                        datasets: [{ 
                            data: cantBienesDia, //Cantidad de Bienes
                            label: "Cantidad de Bienes",
                            borderColor: "#3e95cd"
                        }]
                    },
                    options: {
                        title: {
                        display: true,
                        text: 'Balance Mensual de Bienes'
                        }
                    }
                });

            });

        }
    }

    function mostrarLiquidacionDia() {
        var anio = $('#anioLiquidacionDia').val();
        var mes = $('#mesLiquidacionDia').val();

        if (anio == 0) {
            toastr.error("Primero Seleccione el AÑO para continuar");
        }else{

            $.post( "{{ Route('graficoLineaLiquidacionDia') }}", {anio: anio, mes: mes, _token:'{{csrf_token()}}'}).done(function(data) {

                var datos = jQuery.parseJSON(data);
                var totaldias = datos.totaldias;
                var registrosdia = datos.registrosdia;
                var i=0;
                var dias = [];
                var cantLiquidacionDia = [];
                for(i=1; i<=totaldias; i++){
                    dias.push(i);
                    cantLiquidacionDia.push( registrosdia[i] );
                }

                new Chart(document.getElementById("canLiquidacionDiaChart"), {
                    type: 'line',
                    data: {
                        labels: dias, //Cargar dias
                        datasets: [{ 
                            data: cantLiquidacionDia, //Cantidad de Liquidacion
                            label: "Cantidad de Liquidación",
                            borderColor: "#3e95cd"
                        }]
                    },
                    options: {
                        title: {
                        display: true,
                        text: 'Balance Mensual de Liquidación'
                        }
                    }
                });

            });
            
        }
    }

    function mostrarVendidoDia() {
        var anio = $('#anioVendidoDia').val();
        var mes = $('#mesVendidoDia').val();

        if (anio == 0) {
            toastr.error("Primero Seleccione el AÑO para continuar");
        }else{

            $.post( "{{ Route('graficoLineaVendidoDia') }}", {anio: anio, mes: mes, _token:'{{csrf_token()}}'}).done(function(data) {

                var datos = jQuery.parseJSON(data);
                var totaldias = datos.totaldias;
                var registrosdia = datos.registrosdia;
                var i=0;
                var dias = [];
                var cantVendidoDia = [];
                for(i=1; i<=totaldias; i++){
                    dias.push(i);
                    cantVendidoDia.push( registrosdia[i] );
                }

                new Chart(document.getElementById("canVendidoDiaChart"), {
                    type: 'line',
                    data: {
                        labels: dias, //Cargar dias
                        datasets: [{ 
                            data: cantVendidoDia, //Cantidad de Vendido
                            label: "Cantidad de Vendido",
                            borderColor: "#3e95cd"
                        }]
                    },
                    options: {
                        title: {
                        display: true,
                        text: 'Balance Mensual de Vendido'
                        }
                    }
                });

            });
            
        }
    }

    function mostrarClienteDia() {
        var anio = $('#anioClienteDia').val();
        var mes = $('#mesClienteDia').val();

        if (anio == 0) {
            toastr.error("Primero Seleccione el AÑO para continuar");
        }else{

            $.post( "{{ Route('graficoLineaClienteDia') }}", {anio: anio, mes: mes, _token:'{{csrf_token()}}'}).done(function(data) {

                var datos = jQuery.parseJSON(data);
                var totaldias = datos.totaldias;
                var registrosdia = datos.registrosdia;
                var i=0;
                var dias = [];
                var cantClienteDia = [];
                for(i=1; i<=totaldias; i++){
                    dias.push(i);
                    cantClienteDia.push( registrosdia[i] );
                }

                new Chart(document.getElementById("canClienteDiaChart"), {
                    type: 'line',
                    data: {
                        labels: dias, //Cargar dias
                        datasets: [{ 
                            data: cantClienteDia, //Cantidad de Cliente
                            label: "Cantidad de Cliente",
                            borderColor: "#3e95cd"
                        }]
                    },
                    options: {
                        title: {
                        display: true,
                        text: 'Balance Mensual de Cliente'
                        }
                    }
                });

            });
            
        }
    }

    function mostrarEfectivoDia() {
        var anio = $('#anioEfectivoDia').val();
        var mes = $('#mesEfectivoDia').val();

        if (anio == 0) {
            toastr.error("Primero Seleccione el AÑO para continuar");
        }else{

            $.post( "{{ Route('graficoLineaEfectivoDia') }}", {anio: anio, mes: mes, _token:'{{csrf_token()}}'}).done(function(data) {

                var datos = jQuery.parseJSON(data);
                var totaldias = datos.totaldias;
                var registrosdia = datos.registrosdia;
                var monto = datos.monto;
                var i=0;
                var dias = [];
                var cantEfectivoDia = [];
                for(i=1; i<=totaldias; i++){
                    dias.push(i);
                    cantEfectivoDia.push( monto[i] );
                }

                new Chart(document.getElementById("canEfectivoDiaChart"), {
                    type: 'bar',
                    data: {
                        labels: dias, //Cargar dias
                        datasets: [{ 
                            data: cantEfectivoDia, //Cantidad de Efectivo
                            label: "Cantidad de Efectivo",
                            borderColor: "#3e95cd",
                            backgroundColor: "#3e95cd"
                        }]
                    },
                    options: {
                        title: {
                        display: true,
                        text: 'Balance Mensual de Efectivo'
                        }
                    }
                });

            });
            
        }
    }

    function mostrarInteresDia() {
        var anio = $('#anioInteresDia').val();
        var mes = $('#mesInteresDia').val();

        if (anio == 0) {
            toastr.error("Primero Seleccione el AÑO para continuar");
        }else{

            $.post( "{{ Route('graficoLineaInteresDia') }}", {anio: anio, mes: mes, _token:'{{csrf_token()}}'}).done(function(data) {

                var datos = jQuery.parseJSON(data);
                var totaldias = datos.totaldias;
                var registrosdia = datos.registrosdia;
                var interes = datos.interes;
                var i=0;
                var dias = [];
                var cantInteresDia = [];
                for(i=1; i<=totaldias; i++){
                    dias.push(i);
                    cantInteresDia.push( interes[i] );
                    
                }

                new Chart(document.getElementById("canInteresDiaChart"), {
                    type: 'bar',
                    data: {
                        labels: dias, //Cargar dias
                        datasets: [{ 
                            data: cantInteresDia, //Cantidad de Interes
                            label: "Cantidad de Interes",
                            borderColor: "#3e95cd",
                            backgroundColor: "#3e95cd"
                        }]
                    },
                    options: {
                        title: {
                        display: true,
                        text: 'Balance Mensual de Interes'
                        }
                    }
                });

            });
            
        }
    }

    function mostrarMoraDia() {
        var anio = $('#anioMoraDia').val();
        var mes = $('#mesMoraDia').val();

        if (anio == 0) {
            toastr.error("Primero Seleccione el AÑO para continuar");
        }else{

            $.post( "{{ Route('graficoLineaMoraDia') }}", {anio: anio, mes: mes, _token:'{{csrf_token()}}'}).done(function(data) {

                var datos = jQuery.parseJSON(data);
                var totaldias = datos.totaldias;
                var registrosdia = datos.registrosdia;
                var mora = datos.mora;
                var i=0;
                var dias = [];
                var cantMoraDia = [];
                for(i=1; i<=totaldias; i++){
                    dias.push(i);
                    cantMoraDia.push( mora[i] );
                }

                new Chart(document.getElementById("canMoraDiaChart"), {
                    type: 'bar',
                    data: {
                        labels: dias, //Cargar dias
                        datasets: [{ 
                            data: cantMoraDia, //Cantidad de Mora
                            label: "Cantidad de Mora",
                            borderColor: "#3e95cd",
                            backgroundColor: "#3e95cd"
                        }]
                    },
                    options: {
                        title: {
                        display: true,
                        text: 'Balance Mensual de Mora'
                        }
                    }
                });

            });
            
        }
    }

    function mostrarVentaDia() {
        var anio = $('#anioVentaDia').val();
        var mes = $('#mesVentaDia').val();

        if (anio == 0) {
            toastr.error("Primero Seleccione el AÑO para continuar");
        }else{

            $.post( "{{ Route('graficoLineaVentaDia') }}", {anio: anio, mes: mes, _token:'{{csrf_token()}}'}).done(function(data) {

                var datos = jQuery.parseJSON(data);
                var totaldias = datos.totaldias;
                var registrosdia = datos.registrosdia;
                var gananciaVenta = datos.venta;
                var i=0;
                var dias = [];
                var cantVentaDia = [];
                for(i=1; i<=totaldias; i++){
                    dias.push(i);
                    cantVentaDia.push( gananciaVenta[i] );
                }

                new Chart(document.getElementById("canVentaDiaChart"), {
                    type: 'bar',
                    data: {
                        labels: dias, //Cargar dias
                        datasets: [{ 
                            data: cantVentaDia, //Cantidad de Venta
                            label: "Cantidad de Venta",
                            borderColor: "#3e95cd",
                            backgroundColor: "#3e95cd"
                        }]
                    },
                    options: {
                        title: {
                        display: true,
                        text: 'Balance Mensual de Venta'
                        }
                    }
                });

            });
            
        }
    }

    function mostrarAdministrativoDia() {
        var anio = $('#anioAdministrativoDia').val();
        var mes = $('#mesAdministrativoDia').val();

        if (anio == 0) {
            toastr.error("Primero Seleccione el AÑO para continuar");
        }else{

            $.post( "{{ Route('graficoLineaAdministrativoDia') }}", {anio: anio, mes: mes, _token:'{{csrf_token()}}'}).done(function(data) {

                var datos = jQuery.parseJSON(data);
                var totaldias = datos.totaldias;
                var registrosdia = datos.registrosdia;
                var gastoAdministrativo = datos.administrativo;
                var i=0;
                var dias = [];
                var cantAdministrativoDia = [];
                for(i=1; i<=totaldias; i++){
                    dias.push(i);
                    cantAdministrativoDia.push( gastoAdministrativo[i] );
                }

                new Chart(document.getElementById("canAdministrativoDiaChart"), {
                    type: 'bar',
                    data: {
                        labels: dias, //Cargar dias
                        datasets: [{ 
                            data: cantAdministrativoDia, //Cantidad de Administrativo
                            label: "Cantidad de Administrativo",
                            borderColor: "#3e95cd",
                            backgroundColor: "#3e95cd"
                        }]
                    },
                    options: {
                        title: {
                        display: true,
                        text: 'Balance Mensual de Administrativo'
                        }
                    }
                });

            });
            
        }
    }

    function mostrarPrestamoActivoDia() {
        var anio = $('#aniopActivosDia').val();
        var mes = $('#mespActivosDia').val();

        if (anio == 0) {
            toastr.error("Primero Seleccione el AÑO para continuar");
        }else{

            $.post( "{{ Route('graficoLineaPrestamoActivoDia') }}", {anio: anio, mes: mes, _token:'{{csrf_token()}}'}).done(function(data) {

                var datos = jQuery.parseJSON(data);
                var totaldias = datos.totaldias;
                var registrosdia = datos.registrosdia;
                var prestamo = datos.registrosPrestamo;
                var renovacion = datos.registrosRenovacion;
                var i=0;
                var dias = [];
                var cantPrestamo = [];
                var cantRenovacion = [];
                for(i=1; i<=totaldias; i++){
                    dias.push(i);
                    cantPrestamo.push( prestamo[i] );
                    cantRenovacion.push( renovacion[i] );
                }

                new Chart(document.getElementById("canpActivosDiaChart"), {
                    type: 'bar',
                    data: {
                        labels: dias, //Cargar dias
                        datasets: [
                            { 
                                data: cantPrestamo, 
                                label: "Cantidad de Prestamos Activos",
                                borderColor: "#3e95cd",
                                cackgroungColor: "#3e95cd",
                                backgroundColor: "#3e95cd"
                            },
                            {
                                data: cantRenovacion, 
                                label: "Cantidad de Renovacion",
                                borderColor: "#C72200",
                                cackgroungColor: "#C72200",
                                backgroundColor: "#C72200"
                            }
                        ]
                    },
                    
                    options: {
                        title: {
                        display: true,
                        text: 'Balance Mensual de Administrativo'
                        }
                    }
                });

            });
            
        }
    }

    function mostrarPrestamoMes() {
        var anio = $('#anioPrestamoMes').val();
        
            $.post( "{{ Route('graficoLineaPrestamoMes') }}", {anio: anio, _token:'{{csrf_token()}}'}).done(function(data) {

                
                var datos = jQuery.parseJSON(data);
                var registrosmes = datos.registrosmes;
                var i=0;
                var cantPrestamos = [];
                for(i=1; i<=12; i++){
                    cantPrestamos.push( registrosmes[i] );
                }

                new Chart(document.getElementById("canPrestamoMesChart"), {
                    type: 'bar',
                    data: {
                        labels: ["ENERO", "FEBRERO", "MARZO", "ABRIL", "MAYO", "JUNIO", "JULIO", "AGOSTO", "SEPTIEMBRE", "OCTUBRE", "NOVIEMBRE", "DICIEMBRE"], //Cargar dias
                        datasets: [{ 
                            data: cantPrestamos, //Cantidad de Prestamos
                            label: "Cantidad de Prestamo",
                            borderColor: "#3e95cd",
                            backgroundColor: "#3e95cd"
                        }]
                    },
                    options: {
                        title: {
                        display: true,
                        text: 'Balance Mensual de Prestamo'
                        }
                    }
                });

            });
    }

    function mostrarBienesMes() {
        var anio = $('#anioBienesMes').val();
        
            $.post( "{{ Route('graficoLineaBienesMes') }}", {anio: anio, _token:'{{csrf_token()}}'}).done(function(data) {

                
                var datos = jQuery.parseJSON(data);
                var registrosmes = datos.registrosmes;
                var i=0;
                var cantBienes = [];
                for(i=1; i<=12; i++){
                    cantBienes.push( registrosmes[i] );
                }

                new Chart(document.getElementById("canBienesMesChart"), {
                    type: 'bar',
                    data: {
                        labels: ["ENERO", "FEBRERO", "MARZO", "ABRIL", "MAYO", "JUNIO", "JULIO", "AGOSTO", "SEPTIEMBRE", "OCTUBRE", "NOVIEMBRE", "DICIEMBRE"], //Cargar dias
                        datasets: [{ 
                            data: cantBienes, //Cantidad de Prestamos
                            label: "Cantidad de Bienes",
                            borderColor: "#3e95cd",
                            backgroundColor: "#3e95cd"
                        }]
                    },
                    options: {
                        title: {
                        display: true,
                        text: 'Balance Mensual de Bienes'
                        }
                    }
                });

            });
    }

    function mostrarLiquidacionMes() {
        var anio = $('#anioLiquidacionMes').val();
        
            $.post( "{{ Route('graficoLineaLiquidacionMes') }}", {anio: anio, _token:'{{csrf_token()}}'}).done(function(data) {

                
                var datos = jQuery.parseJSON(data);
                var registrosmes = datos.registrosmes;
                var i=0;
                var cantLiquidacion = [];
                for(i=1; i<=12; i++){
                    cantLiquidacion.push( registrosmes[i] );
                }

                new Chart(document.getElementById("canLiquidacionMesChart"), {
                    type: 'bar',
                    data: {
                        labels: ["ENERO", "FEBRERO", "MARZO", "ABRIL", "MAYO", "JUNIO", "JULIO", "AGOSTO", "SEPTIEMBRE", "OCTUBRE", "NOVIEMBRE", "DICIEMBRE"], //Cargar dias
                        datasets: [{ 
                            data: cantLiquidacion, //Cantidad de Prestamos
                            label: "Cantidad de Liquidacion",
                            borderColor: "#3e95cd",
                            backgroundColor: "#3e95cd"
                        }]
                    },
                    options: {
                        title: {
                        display: true,
                        text: 'Balance Mensual de Liquidacion'
                        }
                    }
                });

            });
    }

    function mostrarVendidoMes() {
        var anio = $('#anioVendidoMes').val();
        
        $.post( "{{ Route('graficoLineaVendidoMes') }}", {anio: anio, _token:'{{csrf_token()}}'}).done(function(data) {

            
            var datos = jQuery.parseJSON(data);
            var registrosmes = datos.registrosmes;
            var i=0;
            var cantVendido = [];
            for(i=1; i<=12; i++){
                cantVendido.push( registrosmes[i] );
            }

            new Chart(document.getElementById("canVendidoMesChart"), {
                type: 'bar',
                data: {
                    labels: ["ENERO", "FEBRERO", "MARZO", "ABRIL", "MAYO", "JUNIO", "JULIO", "AGOSTO", "SEPTIEMBRE", "OCTUBRE", "NOVIEMBRE", "DICIEMBRE"], //Cargar dias
                    datasets: [{ 
                        data: cantVendido, //Cantidad de Prestamos
                        label: "Cantidad de Vendido",
                        borderColor: "#3e95cd",
                        backgroundColor: "#3e95cd"
                    }]
                },
                options: {
                    title: {
                    display: true,
                    text: 'Balance Mensual de Vendido'
                    }
                }
            });

        });
    }

    function mostrarClienteMes() {
        var anio = $('#anioClienteMes').val();
        
            $.post( "{{ Route('graficoLineaClienteMes') }}", {anio: anio, _token:'{{csrf_token()}}'}).done(function(data) {

                
                var datos = jQuery.parseJSON(data);
                var registrosmes = datos.registrosmes;
                var i=0;
                var cantCliente = [];
                for(i=1; i<=12; i++){
                    cantCliente.push( registrosmes[i] );
                }

                new Chart(document.getElementById("canClienteMesChart"), {
                    type: 'bar',
                    data: {
                        labels: ["ENERO", "FEBRERO", "MARZO", "ABRIL", "MAYO", "JUNIO", "JULIO", "AGOSTO", "SEPTIEMBRE", "OCTUBRE", "NOVIEMBRE", "DICIEMBRE"], //Cargar dias
                        datasets: [{ 
                            data: cantCliente, //Cantidad de Prestamos
                            label: "Cantidad de Cliente",
                            borderColor: "#3e95cd",
                            backgroundColor: "#3e95cd"
                        }]
                    },
                    options: {
                        title: {
                        display: true,
                        text: 'Balance Mensual de Cliente'
                        }
                    }
                });

            });
    }

    function mostrarEfectivoMes() {
        var anio = $('#anioEfectivoMes').val();
        
            $.post( "{{ Route('graficoLineaEfectivoMes') }}", {anio: anio, _token:'{{csrf_token()}}'}).done(function(data) {

                var datos = jQuery.parseJSON(data);
                var registrosmes = datos.registrosmes;
                var monto = datos.monto;
                var i=0;
                var cantEfectivoMes = [];
                for(i=1; i<=12; i++){
                    cantEfectivoMes.push( monto[i] );
                }
                

                new Chart(document.getElementById("canEfectivoMesChart"), {
                    type: 'bar',
                    data: {
                        labels: ["ENERO", "FEBRERO", "MARZO", "ABRIL", "MAYO", "JUNIO", "JULIO", "AGOSTO", "SEPTIEMBRE", "OCTUBRE", "NOVIEMBRE", "DICIEMBRE"], //Cargar dias
                        datasets: [{ 
                            data: cantEfectivoMes, //Cantidad de Prestamos
                            label: "Cantidad de Efetivo",
                            borderColor: "#3e95cd",
                            backgroundColor: "#3e95cd"
                        }]
                    },
                    options: {
                        title: {
                        display: true,
                        text: 'Balance Mensual de Efectivo'
                        }
                    }
                });

            });
    }

    function mostrarInteresMes() {
        var anio = $('#anioInteresMes').val();
        
            $.post( "{{ Route('graficoLineaInteresMes') }}", {anio: anio, _token:'{{csrf_token()}}'}).done(function(data) {

                
                var datos = jQuery.parseJSON(data);
                var registrosmes = datos.registrosmes;
                var interes = datos.interes;
                var i=0;
                var cantInteres = [];
                for(i=1; i<=12; i++){
                    cantInteres.push( interes[i] );
                }

                new Chart(document.getElementById("canInteresMesChart"), {
                    type: 'bar',
                    data: {
                        labels: ["ENERO", "FEBRERO", "MARZO", "ABRIL", "MAYO", "JUNIO", "JULIO", "AGOSTO", "SEPTIEMBRE", "OCTUBRE", "NOVIEMBRE", "DICIEMBRE"], //Cargar dias
                        datasets: [{ 
                            data: cantInteres, //Cantidad de Prestamos
                            label: "Cantidad de Interes",
                            borderColor: "#3e95cd",
                            backgroundColor: "#3e95cd"
                        }]
                    },
                    options: {
                        title: {
                        display: true,
                        text: 'Balance Mensual de Interes'
                        }
                    }
                });

            });
    }

    function mostrarMoraMes() {
        var anio = $('#anioMoraMes').val();
        
            $.post( "{{ Route('graficoLineaMoraMes') }}", {anio: anio, _token:'{{csrf_token()}}'}).done(function(data) {

                
                var datos = jQuery.parseJSON(data);
                var registrosmes = datos.registrosmes;
                var mora = datos.mora;
                var i=0;
                var cantMora = [];
                for(i=1; i<=12; i++){
                    cantMora.push( mora[i] );
                }

                new Chart(document.getElementById("canMoraMesChart"), {
                    type: 'bar',
                    data: {
                        labels: ["ENERO", "FEBRERO", "MARZO", "ABRIL", "MAYO", "JUNIO", "JULIO", "AGOSTO", "SEPTIEMBRE", "OCTUBRE", "NOVIEMBRE", "DICIEMBRE"], //Cargar dias
                        datasets: [{ 
                            data: cantMora, //Cantidad de Prestamos
                            label: "Cantidad de Mora",
                            borderColor: "#3e95cd",
                            backgroundColor: "#3e95cd"
                        }]
                    },
                    options: {
                        title: {
                        display: true,
                        text: 'Balance Mensual de Mora'
                        }
                    }
                });

            });
    }

    function mostrarVentaMes() {
        var anio = $('#anioVentaMes').val();
        
            $.post( "{{ Route('graficoLineaVentaMes') }}", {anio: anio, _token:'{{csrf_token()}}'}).done(function(data) {

                
                var datos = jQuery.parseJSON(data);
                var registrosmes = datos.registrosmes;
                var venta = datos.venta;
                var i=0;
                var cantVenta = [];
                for(i=1; i<=12; i++){
                    cantVenta.push( venta[i] );
                }

                new Chart(document.getElementById("canVentaMesChart"), {
                    type: 'bar',
                    data: {
                        labels: ["ENERO", "FEBRERO", "MARZO", "ABRIL", "MAYO", "JUNIO", "JULIO", "AGOSTO", "SEPTIEMBRE", "OCTUBRE", "NOVIEMBRE", "DICIEMBRE"], //Cargar dias
                        datasets: [{ 
                            data: cantVenta, //Cantidad de Prestamos
                            label: "Cantidad de Venta",
                            borderColor: "#3e95cd",
                            backgroundColor: "#3e95cd"
                        }]
                    },
                    options: {
                        title: {
                        display: true,
                        text: 'Balance Mensual de Venta'
                        }
                    }
                });

            });
    }

    function mostrarAdministrativoMes() {
        var anio = $('#anioAdministrativoMes').val();
        
        $.post( "{{ Route('graficoLineaAdministrativoMes') }}", {anio: anio, _token:'{{csrf_token()}}'}).done(function(data) {

            
            var datos = jQuery.parseJSON(data);
            var registrosmes = datos.registrosmes;
            var administrativo = datos.administrativo;
            var i=0;
            var cantAdministrativo = [];
            for(i=1; i<=12; i++){
                cantAdministrativo.push( administrativo[i] );
            }

            new Chart(document.getElementById("canAdministrativoMesChart"), {
                type: 'bar',
                data: {
                    labels: ["ENERO", "FEBRERO", "MARZO", "ABRIL", "MAYO", "JUNIO", "JULIO", "AGOSTO", "SEPTIEMBRE", "OCTUBRE", "NOVIEMBRE", "DICIEMBRE"], //Cargar dias
                    datasets: [{ 
                        data: cantAdministrativo, //Cantidad de Prestamos
                        label: "Cantidad de Gastos Administrativo",
                        borderColor: "#3e95cd",
                        backgroundColor: "#3e95cd"
                    }]
                },
                options: {
                    title: {
                    display: true,
                    text: 'Balance Mensual de Gastos Administrativos'
                    }
                }
            });

        });
    }

    function mostrarpActivosMes() {
        
        var anio = $('#aniopActivosMes').val();
        
            $.post( "{{ Route('graficoLineaPrestamoActivoMes') }}", {anio: anio, _token:'{{csrf_token()}}'}).done(function(data) {
                
                var datos = jQuery.parseJSON(data);
                var registrosmes = datos.registrosmes;
                var prestamo = datos.prestamo;
                var renovacion = datos.renovacion;
                var i=0;
                var cantPrestamo = [];
                var cantRenovacion = [];
                for(i=1; i<=12; i++){
                    cantPrestamo.push( prestamo[i] );
                    cantRenovacion.push( renovacion[i] );
                }

                new Chart(document.getElementById("canPactivosMesChart"), {
                    type: 'bar',
                    data: {
                        labels: ["ENERO", "FEBRERO", "MARZO", "ABRIL", "MAYO", "JUNIO", "JULIO", "AGOSTO", "SEPTIEMBRE", "OCTUBRE", "NOVIEMBRE", "DICIEMBRE"], //Cargar dias
                        datasets: [
                            { 
                                data: cantPrestamo, //Cantidad de Prestamos
                                label: "Cantidad de Prestamos Nuevos",
                                borderColor: "#3e95cd",
                                backgroundColor: "#3e95cd"
                            },
                            {
                                data: cantRenovacion, //Cantidad de Prestamos
                                label: "Cantidad de Renovaciones",
                                borderColor: "#C72200",
                                backgroundColor: "#C72200"
                            }
                        ]
                    },
                    options: {
                        title: {
                        display: true,
                        text: 'Balance Mensual de Prestamos'
                        }
                    }
                });

            });
            
    }

</script>
@endsection