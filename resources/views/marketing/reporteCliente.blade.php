@extends('layouts.app')
@section('pagina')
    Reportes de Clientes
@endsection
@section('contenido')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Clientes Nuevos</h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-wrench"></i>
                    </a>
                    <a class="close-link">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content" id="divClientesNuevo">
                <div class="panel-body">
                    <div class="panel-group" id="accordion">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h5 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseClienteNuevo">Clientes Nuevos</a>
                                    </h5>
                                </div>
                                <div id="collapseClienteNuevo" class="panel-collapse collapse in">
                                    <div class="panel-body" id="">
                                        <div class="panel-body">
                                            <div class="tabs-container">
                                                <div class="col-lg-8">
                                                    <div class="tabs-left">
                                                        <ul class="nav nav-tabs">
                                                            <li><a class="nav-link active" data-toggle="tab" href="#dcNuevo"> Dia</a></li>
                                                            <li><a class="nav-link" data-toggle="tab" href="#mcNuevo"> Mes</a></li>
                                                            <li><a class="nav-link" data-toggle="tab" href="#acNuevo"> Año</a></li>
                                                        </ul>
                                                        <div class="tab-content ">
                                                            <div id="dcNuevo" class="tab-pane active">
                                                                <div class="panel-body">
                                                                    <div class="row">
                                                                        <div class="col-lg-12">
                                                                            <div class="ibox "> 
                                                                                <div class="ibox-title">
                                                                                    <h5>Clientes Nuevos
                                                                                        <small>Cantidad de clientes nuevos por día</small>
                                                                                    </h5>
                                                                                </div>
                                                                                
                                                                                <div class="ibox-content">
                                                                                    <!-- Cantidad de Clientes nuevos por día -->
                                                                                    <div class="row">
                                                                                        <div class="col-lg-6">
                                                                                            <select class="form-control m-b" name="anioClienteNuevo" id="anioClienteNuevo">
                                                                                                <option value="0">Seleccionar un Año...</option>
                                                                                                @foreach ($anio as $a)
                                                                                                    <option value="{{ $a->anio }}">{{ $a->anio }}</option>    
                                                                                                @endforeach
                                                                                            </select>
                                                                                        </div>
                                                                                        <div class="col-lg-6">
                                                                                            <select class="form-control m-b" name="mesClienteNuevo" id="mesClienteNuevo" onchange="mostrarClienteNuevo()">
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
                                                                                    
                                                                                    <div id="grafDia">
                                                                                        <canvas id="canClienteNuevoChart" height="100%"></canvas>
                                                                                    </div>
                                                                                    <div id="listDia">
                                                                                    
                                                                                    </div>
                                                                                    <!-- Fin Cantidad de Clientes Nuevos por día -->
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div id="mcNuevo" class="tab-pane">
                                                                <div class="panel-body">
                                                                    <div class="row">
                                                                        <!-- Cantidad de Clientes Nuevos por Mes -->
                                                                        <div class="col-lg-12">
                                                                            <div class="ibox ">
                                                                                <div class="ibox-title">
                                                                                    <h5>Clientes Nuevos
                                                                                        <small>Cantidad de Clientes Nuevos al Mes</small>
                                                                                    </h5>
                                                                                </div>
                                                                                
                                                                                <div class="ibox-content">
                                                                                    <div class="row">
                                                                                        <div class="col-lg-12">
                                                                                            <select class="form-control m-b" name="anioClienteNuevoMes" id="anioClienteNuevoMes" onchange="mostrarClienteNuevoMes()">
                                                                                                <option value="0">Seleccionar un Año...</option>
                                                                                                @foreach ($anio as $a)
                                                                                                    <option value="{{ $a->anio }}">{{ $a->anio }}</option>    
                                                                                                @endforeach
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div id="grafMes">
                                                                                        <canvas id="canClienteNuevoMesChart" height="100%"></canvas>
                                                                                    </div>
                                                                                    <div id="listMes">
                                                                                                    
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <!-- Fin Cantidad de Clientes Nuevos por mes -->
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div id="acNuevo" class="tab-pane">
                                                                <div class="panel-body">
                                                                    <div class="row">
                                                                        <!-- Cantidad de Clientes Nuevos por año -->
                                                                        <div class="col-lg-12">
                                                                            <div class="ibox ">
                                                                                <div class="ibox-title">
                                                                                    <h5>Clientes Nuevos
                                                                                        <small>Cantidad de Clientes Nuevos por Año</small>
                                                                                    </h5>
                                                                                </div>
                                                                                
                                                                                <div class="ibox-content">
                                                                                    <div id="grafAnio">
                                                                                        <canvas id="canClienteNuevoAnioChart" height="100%"></canvas>
                                                                                    </div>
                                                                                    <div class="panel-group" id="accordion">
                                                                                        <div class="panel panel-default">
                                                                                            <div class="panel-heading">
                                                                                                <h5 class="panel-title">
                                                                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseListaClienteNuevoAnio">Lista de Clientes Nuevos</a>
                                                                                                </h5>
                                                                                            </div>
                                                                                            <div id="collapseListaClienteNuevoAnio" class="panel-collapse collapse in">
                                                                                                <div id="listAnio">
                                                                                                        <table class="table table-striped">
                                                                                                            <thead>
                                                                                                            <tr>
                                                                                                                <th>Cod.</th>
                                                                                                                <th>Cliente</th>
                                                                                                                <th>DNI</th>
                                                                                                            </tr>
                                                                                                            </thead>
                                                                                                            <tbody>
                                                                                                                @foreach ($listClientes as $lc)
                                                                                                                    <tr>
                                                                                                                        <td>{{ $lc->id }}</td>
                                                                                                                        <td><a class="text-success" href="{{ Route('perfilCliente', [$lc->id]) }}">{{ $lc->nombre }} - {{ $lc->apellido }}</a></td>
                                                                                                                        <td>{{ $lc->dni }}</td>
                                                                                                                    </tr>        
                                                                                                                @endforeach
                                                                                                            </tbody>
                                                                                                        </table>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <!-- Fin Cantidad de Clientes Nuevos por año -->
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
                    </div>
                </div>
            </div>
            
            
            <div class="ibox-content" id="divRenovaciones">
                <div class="panel-body">
                    <div class="panel-group" id="accordion">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h5 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseRenovaciones">Reporte de Renovaciones</a>
                                    </h5>
                                </div>
                                <div id="collapseRenovaciones" class="panel-collapse collapse in">
                                    <div class="panel-body" id="">
                                        <div class="panel-body">
                                            <div class="tabs-container">
                                                <div class="col-lg-8">
                                                    <div class="tabs-left">
                                                        <ul class="nav nav-tabs">
                                                            <li><a class="nav-link active" data-toggle="tab" href="#drNuevo"> Dia</a></li>
                                                            <li><a class="nav-link" data-toggle="tab" href="#mrNuevo"> Mes</a></li>
                                                            <li><a class="nav-link" data-toggle="tab" href="#arNuevo"> Año</a></li>
                                                        </ul>
                                                        <div class="tab-content ">
                                                            <div id="drNuevo" class="tab-pane active">
                                                                <div class="panel-body">
                                                                    <div class="row">
                                                                        <div class="col-lg-12">
                                                                            <div class="ibox "> 
                                                                                <div class="ibox-title">
                                                                                    <h5>Renovaciones
                                                                                        <small>Cantidad de renovaciones por día</small>
                                                                                    </h5>
                                                                                </div>
                                                                                
                                                                                <div class="ibox-content">
                                                                                    <!-- Cantidad de Clientes nuevos por día -->
                                                                                    <div class="row">
                                                                                        <div class="col-lg-6">
                                                                                            <select class="form-control m-b" name="anioRenovaciones" id="anioRenovaciones">
                                                                                                <option value="0">Seleccionar un Año...</option>
                                                                                                @foreach ($anio as $a)
                                                                                                    <option value="{{ $a->anio }}">{{ $a->anio }}</option>    
                                                                                                @endforeach
                                                                                            </select>
                                                                                        </div>
                                                                                        <div class="col-lg-6">
                                                                                            <select class="form-control m-b" name="mesRenovaciones" id="mesRenovaciones" onchange="mostrarRenovacionesDia()">
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
                                                                                    
                                                                                    <div id="grafDiaRenovaciones">
                                                                                        <canvas id="canRenovacionesChart" height="100%"></canvas>
                                                                                    </div>
                                                                                    <div id="listDiaRenovaciones">
                                                                                    
                                                                                    </div>
                                                                                    <!-- Fin Cantidad de Clientes Nuevos por día -->
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div id="mrNuevo" class="tab-pane">
                                                                <div class="panel-body">
                                                                    <div class="row">
                                                                        <!-- Cantidad de Clientes Nuevos por Mes -->
                                                                        <div class="col-lg-12">
                                                                            <div class="ibox ">
                                                                                <div class="ibox-title">
                                                                                    <h5>Renovaciones
                                                                                        <small>Reporte de renovaciones al Mes</small>
                                                                                    </h5>
                                                                                </div>
                                                                                
                                                                                <div class="ibox-content">
                                                                                    <div class="row">
                                                                                        <div class="col-lg-12">
                                                                                            <select class="form-control m-b" name="anioRenovacionesMes" id="anioRenovacionesMes" onchange="mostrarRenovacionesMes()">
                                                                                                <option value="0">Seleccionar un Año...</option>
                                                                                                @foreach ($anio as $a)
                                                                                                    <option value="{{ $a->anio }}">{{ $a->anio }}</option>    
                                                                                                @endforeach
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div id="grafMesRenovaciones">
                                                                                        <canvas id="canRenovacionesMesChart" height="100%"></canvas>
                                                                                    </div>
                                                                                    <div id="listMesRenovaciones">
                                                                                                    
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <!-- Fin Cantidad de Clientes Nuevos por mes -->
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div id="arNuevo" class="tab-pane">
                                                                <div class="panel-body">
                                                                    <div class="row">
                                                                        <!-- Cantidad de Clientes Nuevos por año -->
                                                                        <div class="col-lg-12">
                                                                            <div class="ibox ">
                                                                                <div class="ibox-title">
                                                                                    <h5>Renovaciones
                                                                                        <small>Reporte de renovaciones por Año</small>
                                                                                    </h5>
                                                                                </div>
                                                                                
                                                                                <div class="ibox-content">
                                                                                    <div id="grafAnioRenovaciones">
                                                                                        <canvas id="canRenovacionesAnioChart" height="100%"></canvas>
                                                                                    </div>
                                                                                    <div class="panel-group" id="accordion">
                                                                                        <div class="panel panel-default">
                                                                                            <div class="panel-heading">
                                                                                                <h5 class="panel-title">
                                                                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseListaRenovacionesAnio">Lista de Renovaciones</a>
                                                                                                </h5>
                                                                                            </div>
                                                                                            <div id="collapseListaRenovacionesAnio" class="panel-collapse collapse in">
                                                                                                <div id="listAnioRenovaciones">
                                                                                                        <table class="table table-striped">
                                                                                                            <thead>
                                                                                                            <tr>
                                                                                                                <th>Cod.</th>
                                                                                                                <th>Cliente</th>
                                                                                                                <th>DNI</th>
                                                                                                            </tr>
                                                                                                            </thead>
                                                                                                            <tbody>
                                                                                                                @foreach($listClientesRenovaciones as $lc)
                                                                                                                    <tr>
                                                                                                                        <td>{{ $lc->id }}</td>
                                                                                                                        <td><a class="text-success" href="{{ Route('perfilCliente', [$lc->id]) }}">{{ $lc->nombre }} - {{ $lc->apellido }}</a></td>
                                                                                                                        <td>{{ $lc->dni }}</td>
                                                                                                                    </tr>        
                                                                                                                @endforeach
                                                                                                            </tbody>
                                                                                                        </table>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <!-- Fin Cantidad de Clientes Nuevos por año -->
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
                    </div>
                </div>
            </div>
            
            
            <div class="ibox-content" id="divPresGenerales">
                <div class="panel-body">
                    <div class="panel-group" id="accordion">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h5 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapsePresGenerales">Reporte de Prestamos Generales</a>
                                    </h5>
                                </div>
                                <div id="collapsePresGenerales" class="panel-collapse collapse in">
                                    <div class="panel-body" id="">
                                        <div class="panel-body">
                                            <div class="tabs-container">
                                                <div class="col-lg-8">
                                                    <div class="tabs-left">
                                                        <ul class="nav nav-tabs">
                                                            <li><a class="nav-link active" data-toggle="tab" href="#dpgNuevo"> Dia</a></li>
                                                            <li><a class="nav-link" data-toggle="tab" href="#mpgNuevo"> Mes</a></li>
                                                            <li><a class="nav-link" data-toggle="tab" href="#apgNuevo"> Año</a></li>
                                                        </ul>
                                                        <div class="tab-content ">
                                                            <div id="dpgNuevo" class="tab-pane active">
                                                                <div class="panel-body">
                                                                    <div class="row">
                                                                        <div class="col-lg-12">
                                                                            <div class="ibox "> 
                                                                                <div class="ibox-title">
                                                                                    <h5>Prestamos Generales
                                                                                        <small>Reporte de prestamos generales por día</small>
                                                                                    </h5>
                                                                                </div>
                                                                                
                                                                                <div class="ibox-content">
                                                                                    <!-- Cantidad de Clientes nuevos por día -->
                                                                                    <div class="row">
                                                                                        <div class="col-lg-6">
                                                                                            <select class="form-control m-b" name="anioPresGenerales" id="anioPresGenerales">
                                                                                                <option value="0">Seleccionar un Año...</option>
                                                                                                @foreach ($anio as $a)
                                                                                                    <option value="{{ $a->anio }}">{{ $a->anio }}</option>    
                                                                                                @endforeach
                                                                                            </select>
                                                                                        </div>
                                                                                        <div class="col-lg-6">
                                                                                            <select class="form-control m-b" name="mesPresGenerales" id="mesPresGenerales" onchange="mostrarPresGeneralesDia()">
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
                                                                                    
                                                                                    <div id="grafDiaPresGenerales">
                                                                                        <canvas id="canPresGeneralesChart" height="100%"></canvas>
                                                                                    </div>
                                                                                    <div id="listDiaPresGenerales">
                                                                                    
                                                                                    </div>
                                                                                    <!-- Fin Cantidad de Clientes Nuevos por día -->
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div id="mpgNuevo" class="tab-pane">
                                                                <div class="panel-body">
                                                                    <div class="row">
                                                                        <!-- Cantidad de Clientes Nuevos por Mes -->
                                                                        <div class="col-lg-12">
                                                                            <div class="ibox ">
                                                                                <div class="ibox-title">
                                                                                    <h5>Prestamos Generales
                                                                                        <small>Reporte de prestamos generales por Mes</small>
                                                                                    </h5>
                                                                                </div>
                                                                                
                                                                                <div class="ibox-content">
                                                                                    <div class="row">
                                                                                        <div class="col-lg-12">
                                                                                            <select class="form-control m-b" name="anioPresGeneralesMes" id="anioPresGeneralesMes" onchange="mostrarPresGeneralesMes()">
                                                                                                <option value="0">Seleccionar un Año...</option>
                                                                                                @foreach ($anio as $a)
                                                                                                    <option value="{{ $a->anio }}">{{ $a->anio }}</option>    
                                                                                                @endforeach
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div id="grafMesPresGenerales">
                                                                                        <canvas id="canPresGeneralesMesChart" height="100%"></canvas>
                                                                                    </div>
                                                                                    <div id="listMesPresGenerales">
                                                                                                    
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <!-- Fin Cantidad de Clientes Nuevos por mes -->
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div id="apgNuevo" class="tab-pane">
                                                                <div class="panel-body">
                                                                    <div class="row">
                                                                        <!-- Cantidad de Clientes Nuevos por año -->
                                                                        <div class="col-lg-12">
                                                                            <div class="ibox ">
                                                                                <div class="ibox-title">
                                                                                    <h5>Prestamos Generales
                                                                                        <small>Reporte de prestamos generales por Año</small>
                                                                                    </h5>
                                                                                </div>
                                                                                
                                                                                <div class="ibox-content">
                                                                                    <div id="grafAnioPresGenerales">
                                                                                        <canvas id="canPresGeneralesAnioChart" height="100%"></canvas>
                                                                                    </div>
                                                                                    <div class="panel-group" id="accordion">
                                                                                        <div class="panel panel-default">
                                                                                            <div class="panel-heading">
                                                                                                <h5 class="panel-title">
                                                                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseListaPresGeneralesAnio">Lista de Prestamos Generales</a>
                                                                                                </h5>
                                                                                            </div>
                                                                                            <div id="collapseListaPresGeneralesAnio" class="panel-collapse collapse in">
                                                                                                <div id="listAnioPresGenerales">
                                                                                                        <table class="table table-striped">
                                                                                                            <thead>
                                                                                                            <tr>
                                                                                                                <th>Cod.</th>
                                                                                                                <th>Cliente</th>
                                                                                                                <th>DNI</th>
                                                                                                            </tr>
                                                                                                            </thead>
                                                                                                            <tbody>
                                                                                                                @foreach ($listClientesPresGenerales as $lc)
                                                                                                                    <tr>
                                                                                                                        <td>{{ $lc->id }}</td>
                                                                                                                        <td><a class="text-success" href="{{ Route('perfilCliente', [$lc->id]) }}">{{ $lc->nombre }} - {{ $lc->apellido }}</a></td>
                                                                                                                        <td>{{ $lc->dni }}</td>
                                                                                                                    </tr>        
                                                                                                                @endforeach
                                                                                                            </tbody>
                                                                                                        </table>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <!-- Fin Cantidad de Clientes Nuevos por año -->
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
        //Clientes Nuevos
        var divGrafAnio = document.getElementById('grafAnio');
        divGrafAnio.innerHTML = '<canvas id="canClienteNuevoAnioChart" height="100%"></canvas>';
        
        const chartDataClienteNuevo = Object.keys($registros).map(anio => $registros[anio]);
        const chartLabelsClienteNuevo = Object.keys($registros);
        
        new Chart(document.getElementById("canClienteNuevoAnioChart"), {
            type: 'bar',
            data: {
                labels: chartLabelsClienteNuevo, //Cargar dias
                datasets: [{ 
                    data: chartDataClienteNuevo, //Cantidad de Prestamos
                    label: "Cantidad de Clientes Nuevos",
                    borderColor: "#3e95cd",
                    backgroundColor: "#3e95cd"
                }]
            },
            options: {
                title: {
                display: true,
                text: 'Balance Anual de Clientes Nuevos'
                }
            }
        });
        
        //FIN Clientes Nuevos
        
        //RENOVACIONES
        var divGrafAnio = document.getElementById('grafAnioRenovaciones');
        divGrafAnio.innerHTML = '<canvas id="canRenovacionesAnioChart" height="100%"></canvas>';
        
        const chartDataRenovaciones = Object.keys($registrosRenovaciones).map(anio => $registrosRenovaciones[anio]);
        const chartLabelsRenovaciones = Object.keys($registrosRenovaciones);
        
        new Chart(document.getElementById("canRenovacionesAnioChart"), {
            type: 'bar',
            data: {
                labels: chartLabelsRenovaciones, //Cargar dias
                datasets: [{ 
                    data: chartDataRenovaciones, //Cantidad de Renovaciones
                    label: "Reporte de Renovaciones",
                    borderColor: "#3e95cd",
                    backgroundColor: "#3e95cd"
                }]
            },
            options: {
                title: {
                display: true,
                text: 'Balance Anual de Renovaciones'
                }
            }
        });
        
        //FIN RENOVACIONES
        
        //PRESTAMOS GENERALES
        var divGrafAnio = document.getElementById('grafAnioPresGenerales');
        divGrafAnio.innerHTML = '<canvas id="canPresGeneralesAnioChart" height="100%"></canvas>';
        
        const chartDataPresGenerales = Object.keys($registrosPresGenerales).map(anio => $registrosPresGenerales[anio]);
        const chartLabelsPresGenerales = Object.keys($registrosPresGenerales);
        
        new Chart(document.getElementById("canPresGeneralesAnioChart"), {
            type: 'bar',
            data: {
                labels: chartLabelsPresGenerales, //Cargar dias
                datasets: [{ 
                    data: chartDataPresGenerales, //Cantidad de Prestamos Generales
                    label: "Reporte de Prestamos Generales",
                    borderColor: "#3e95cd",
                    backgroundColor: "#3e95cd"
                }]
            },
            options: {
                title: {
                display: true,
                text: 'Balance Anual de Prestamos Generales'
                }
            }
        });
        
        //FIN PRESTAMOS GENERALES
    }
        
        function mostrarClienteNuevo() {
            var anio = $('#anioClienteNuevo').val();
            var mes = $('#mesClienteNuevo').val();
            
            if (anio == 0) {
                toastr.error("Primero Seleccione el AÑO para continuar");
            }else{
                $.post( "{{ Route('graficoLineaClienteNuevo') }}", {anio: anio, mes: mes, _token:'{{csrf_token()}}'}).done(function(data) {
                    var datos = jQuery.parseJSON(data);
                    var totaldias = datos.totaldias;
                    var registrosdia = datos.registrosdia;
                    var i=0;
                    var dias = [];
                    var cantClientesNuevos = [];
                    for(i=1; i<=totaldias; i++){
                        dias.push(i); 
                        cantClientesNuevos.push( registrosdia[i] );
                    }
                    
                    var divGrafDia = document.getElementById('grafDia');
                    divGrafDia.innerHTML = '<canvas id="canClienteNuevoChart" height="100%"></canvas>';
    
                    new Chart(document.getElementById("canClienteNuevoChart"), {
                        type: 'bar',
                        data: {
                            labels: dias, //Cargar dias
                            datasets: [{ 
                                data: cantClientesNuevos, //Cantidad de Clientes Nuevos
                                label: "Cantidad de Clientes Nuevos",
                                borderColor: "#3e95cd",
                                backgroundColor: "#3e95cd"
                            }]
                        },
                        options: {
                            title: {
                            display: true,
                            text: 'Balance Mensual de Clientes Nuevos'
                            }
                        }
                    });
    
                });
                
                $.post( "{{ Route('listaClienteNuevoDia') }}", {anio: anio, mes: mes, _token:'{{csrf_token()}}'}).done(function(data) {
                    $("#listDia").empty();
                    $("#listDia").html(data.view);
                });
            }
        };
        
        function mostrarRenovacionesDia() {
            var anio = $('#anioRenovaciones').val();
            var mes = $('#mesRenovaciones').val();
            
            if (anio == 0) {
                toastr.error("Primero Seleccione el AÑO para continuar");
            }else{
                $.post( "{{ Route('graficoLineaRenovacionesDia') }}", {anio: anio, mes: mes, _token:'{{csrf_token()}}'}).done(function(data) {
                    var datos = jQuery.parseJSON(data);
                    var totaldias = datos.totaldias;
                    var registrosdia = datos.registrosdia;
                    var i=0;
                    var dias = [];
                    var cantRenovaciones = [];
                    for(i=1; i<=totaldias; i++){
                        dias.push(i); 
                        cantRenovaciones.push( registrosdia[i] );
                    }
                    
                    var divGrafDia = document.getElementById('grafDiaRenovaciones');
                    divGrafDia.innerHTML = '<canvas id="canRenovacionesChart" height="100%"></canvas>';
    
                    new Chart(document.getElementById("canRenovacionesChart"), {
                        type: 'bar',
                        data: {
                            labels: dias, //Cargar dias
                            datasets: [{ 
                                data: cantRenovaciones, //Cantidad de Renovaciones
                                label: "Reporte de renovaciones por día",
                                borderColor: "#3e95cd",
                                backgroundColor: "#3e95cd"
                            }]
                        },
                        options: {
                            title: {
                            display: true,
                            text: 'Balance diario de renovaciones'
                            }
                        }
                    });
    
                });
                
                $.post( "{{ Route('listaRenovacionesDia') }}", {anio: anio, mes: mes, _token:'{{csrf_token()}}'}).done(function(data) {
                    $("#listDiaRenovaciones").empty();
                    $("#listDiaRenovaciones").html(data.view);
                });
            }
            
        };
        
        function mostrarPresGeneralesDia() {
            var anio = $('#anioPresGenerales').val();
            var mes = $('#mesPresGenerales').val();
            
            if (anio == 0) {
                toastr.error("Primero Seleccione el AÑO para continuar");
            }else{
                $.post( "{{ Route('graficoLineaPresGenerales') }}", {anio: anio, mes: mes, _token:'{{csrf_token()}}'}).done(function(data) {
                    var datos = jQuery.parseJSON(data);
                    var totaldias = datos.totaldias;
                    var registrosdia = datos.registrosdia;
                    var i=0;
                    var dias = [];
                    var cantPresGenerales = [];
                    for(i=1; i<=totaldias; i++){
                        dias.push(i); 
                        cantPresGenerales.push( registrosdia[i] );
                    }
                    
                    var divGrafDia = document.getElementById('grafDiaPresGenerales');
                    divGrafDia.innerHTML = '<canvas id="canPresGeneralesChart" height="100%"></canvas>';
    
                    new Chart(document.getElementById("canPresGeneralesChart"), {
                        type: 'bar',
                        data: {
                            labels: dias, //Cargar dias
                            datasets: [{ 
                                data: cantPresGenerales, //Cantidad de Prestamos Generales
                                label: "Reporte de Prestamos Generales por Día",
                                borderColor: "#3e95cd",
                                backgroundColor: "#3e95cd"
                            }]
                        },
                        options: {
                            title: {
                            display: true,
                            text: 'Balance Diario de Prestamos Generales'
                            }
                        }
                    });
    
                });
                
                $.post( "{{ Route('listaPresGeneralesDia') }}", {anio: anio, mes: mes, _token:'{{csrf_token()}}'}).done(function(data) {
                    $("#listDiaPresGenerales").empty();
                    $("#listDiaPresGenerales").html(data.view);
                });
            }
            
        };
        
        function mostrarClienteNuevoMes() {
            var anio = $('#anioClienteNuevoMes').val();
        
            $.post( "{{ Route('graficoLineaClientesNuevosMes') }}", {anio: anio, _token:'{{csrf_token()}}'}).done(function(data) {
                var datos = jQuery.parseJSON(data);
                var registrosmes = datos.registrosmes;
                var i=0;
                var cantClienteNuevo = [];
                for(i=1; i<=12; i++){
                    cantClienteNuevo.push( registrosmes[i] );
                }
                
                var divGrafMes = document.getElementById('grafMes');
                divGrafMes.innerHTML = '<canvas id="canClienteNuevoMesChart" height="100%"></canvas>';

                new Chart(document.getElementById("canClienteNuevoMesChart"), {
                    type: 'bar',
                    data: {
                        labels: ["ENERO", "FEBRERO", "MARZO", "ABRIL", "MAYO", "JUNIO", "JULIO", "AGOSTO", "SEPTIEMBRE", "OCTUBRE", "NOVIEMBRE", "DICIEMBRE"], //Cargar dias
                        datasets: [{ 
                            data: cantClienteNuevo, //Cantidad de Prestamos
                            label: "Cantidad de Clientes Nuevos",
                            borderColor: "#3e95cd",
                            backgroundColor: "#3e95cd"
                        }]
                    },
                    options: {
                        title: {
                        display: true,
                        text: 'Balance Mensual de Clientes Nuevos'
                        }
                    }
                });

            });
            
            $.post( "{{ Route('listaClientesNuevosMes') }}", {anio: anio, _token:'{{csrf_token()}}'}).done(function(data) {
                    $("#listMes").empty();
                    $("#listMes").html(data.view);
                });
                
        }
        
        function mostrarRenovacionesMes() {
            var anio = $('#anioRenovacionesMes').val();
        
            $.post( "{{ Route('graficoLineaRenovacionesMes') }}", {anio: anio, _token:'{{csrf_token()}}'}).done(function(data) {
                var datos = jQuery.parseJSON(data);
                var registrosmes = datos.registrosmes;
                var i=0;
                var cantRenovaciones = [];
                for(i=1; i<=12; i++){
                    cantRenovaciones.push( registrosmes[i] );
                }
                
                var divGrafMes = document.getElementById('grafMesRenovaciones');
                divGrafMes.innerHTML = '<canvas id="canRenovacionesMesChart" height="100%"></canvas>';

                new Chart(document.getElementById("canRenovacionesMesChart"), {
                    type: 'bar',
                    data: {
                        labels: ["ENERO", "FEBRERO", "MARZO", "ABRIL", "MAYO", "JUNIO", "JULIO", "AGOSTO", "SEPTIEMBRE", "OCTUBRE", "NOVIEMBRE", "DICIEMBRE"], //Cargar dias
                        datasets: [{ 
                            data: cantRenovaciones, //Cantidad de Renovaciones por mes
                            label: "Reporte de renovaciones por mes",
                            borderColor: "#3e95cd",
                            backgroundColor: "#3e95cd"
                        }]
                    },
                    options: {
                        title: {
                        display: true,
                        text: 'Balance Mensual de Renovaciones'
                        }
                    }
                });

            });
            
            $.post( "{{ Route('listaRenovacionesMes') }}", {anio: anio, _token:'{{csrf_token()}}'}).done(function(data) {
                    $("#listMesRenovaciones").empty();
                    $("#listMesRenovaciones").html(data.view);
                });
                
        }
        
        function mostrarPresGeneralesMes() {
            var anio = $('#anioPresGeneralesMes').val();
        
            $.post( "{{ Route('graficoLineaPresGeneralesMes') }}", {anio: anio, _token:'{{csrf_token()}}'}).done(function(data) {
                var datos = jQuery.parseJSON(data);
                var registrosmes = datos.registrosmes;
                var i=0;
                var cantPresGenerales = [];
                for(i=1; i<=12; i++){
                    cantPresGenerales.push( registrosmes[i] );
                }
                
                var divGrafMes = document.getElementById('grafMesPresGenerales');
                divGrafMes.innerHTML = '<canvas id="canPresGeneralesMesChart" height="100%"></canvas>';

                new Chart(document.getElementById("canPresGeneralesMesChart"), {
                    type: 'bar',
                    data: {
                        labels: ["ENERO", "FEBRERO", "MARZO", "ABRIL", "MAYO", "JUNIO", "JULIO", "AGOSTO", "SEPTIEMBRE", "OCTUBRE", "NOVIEMBRE", "DICIEMBRE"], //Cargar dias
                        datasets: [{ 
                            data: cantPresGenerales, //Cantidad de Prestamos Generales por mes
                            label: "Reporte de prestamos generales por mes",
                            borderColor: "#3e95cd",
                            backgroundColor: "#3e95cd"
                        }]
                    },
                    options: {
                        title: {
                        display: true,
                        text: 'Balance Mensual de Prestamos Generales'
                        }
                    }
                });

            });
            
            $.post( "{{ Route('listaPresGeneralesMes') }}", {anio: anio, _token:'{{csrf_token()}}'}).done(function(data) {
                    $("#listMesPresGenerales").empty();
                    $("#listMesPresGenerales").html(data.view);
                });
                
        }
        
        
        
    </script>
@endsection