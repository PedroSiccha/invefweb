<?php 
    use App\proceso; 
    $pro = new proceso();
?>
@extends('layouts.app')
@section('pagina')
    Control de Caja
@endsection
@section('contenido')
<div class="row" id="genCaja">  
        <div class="col-lg-3" onclick="modalCaja('', '', '')">
            <div class="widget style1 navy-bg">
                <div class="row">
                    <div class="col-4">
                        <i class="fa fa-money fa-5x"></i>
                    </div>
                    <div class="col-8 text-right">
                        <span> Caja Chica </span>
                        <h2 class="font-bold">S/. {{ $cajaChica->monto }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3" onclick="modalAbrirCaja()">
            <div class="widget style1 navy-bg">
                <div class="row">
                    <div class="col-4">
                        <i class="fa fa-money fa-5x"></i>
                    </div>
                    <div class="col-8 text-right">
                        <span> Caja Grande </span>
                        <h2 class="font-bold">S/. {{ $cajaGrande->monto }}</h2>
                        <input type="text" class="form-control text-success" id="montoFin" value=" " hidden>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4" onclick="verBancos()">
            <div class="widget style1 lazur-bg">
                <div class="row">
                    <div class="col-4">
                        <i class="fa fa-money fa-5x"></i>
                    </div>
                    <div class="col-8 text-right">
                        <span> Balance de Bancos</span>
                        <h2 class="font-bold">S/. {{ $cantBancos->monto }}</h2>
                        <input type="text" class="form-control text-success" id="montoFin" value=" " hidden>
                    </div>
                </div>
            </div>
        </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="tabs-container">
            <ul class="nav nav-tabs" role="tablist">
                <li><a class="nav-link active" data-toggle="tab" href="#bActual"> Balance Actual</a></li>
                <li><a class="nav-link" data-toggle="tab" href="#bHistorialActual"> Historial de Balance</a></li>
                <li><a class="nav-link" data-toggle="tab" href="#regDeposito">Registrar Depósito</a></li>
                <li><a class="nav-link" data-toggle="tab" href="#consMovimientos">Consultar Movimientos de Pago</a></li>
            </ul>
            <div class="tab-content">
                <div role="tabpanel" id="bActual" class="tab-pane active">
                    <div class="panel-body row">

                        <div class="col-lg-6">
                            <div class="ibox ">
                                <div class="ibox-title">
                                    <h5>Caja Salida</h5>
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
                                <div class="ibox-content" id="divTipoPrestamo">
                                    <table class="footable table table-stripped toggle-arrow-tiny">
                                        <thead>
                                        <tr>
                                            <th>Concepto</th>
                                            <th>Cliente</th>
                                            <th>Fecha de Transcaccion</th>
                                            <th>Monto</th>
                                            <th>Usuario</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($egreso as $eg)
                                            <tr>
                                                <td>{{ $eg->concepto }}</td>
                                                <td><?php if($eg->nombreCl==null) echo $eg->nombreEm; else echo $eg->nombreCl; ?> <?php if($eg->apellidoCl==null) echo $eg->apellidoEm; else echo $eg->apellidoCl; ?></td>
                                                <td>{{ $pro->cambiaf_a_espanol($eg->created_at) }}</td>
                                                <td>{{ $eg->monto }}</td>
                                                <td><?php if($eg->nombreEm==null) echo "Carlos Fernando"; else echo $eg->nombreEm; ?> <?php if($eg->apellidoEm==null) echo "Javier Rimac"; else echo $eg->apellidoEm; ?></td>
                                            </tr>    
                                        @endforeach
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td>
                                                    TOTAL
                                                </td>
                                                <td>
                                                    {{ $cantEgreso->monto }}
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <td colspan="5">
                                                <ul class="pagination float-right"></ul>
                                            </td>
                                        </tr>
                                        </tfoot>
                                    </table>
                    
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="ibox ">
                                <div class="ibox-title">
                                    <h5>Caja Entrada</h5>
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
                                <div class="ibox-content" id="divTipoPrestamo">
                                    <table class="footable table table-stripped toggle-arrow-tiny">
                                        <thead>
                                            <tr>
                                                <th>Concepto</th>
                                                <th>Cliente</th>
                                                <th>Fecha de Transcaccion</th>
                                                <th>Monto</th>
                                                <th>Usuario</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($ingreso as $ing)
                                            <tr>
                                                <td>{{ $ing->concepto }}</td>
                                                <td>{{ $ing->nombreCl }} {{ $ing->apellidoCl }}</td>
                                                <td>{{ $pro->cambiaf_a_espanol($ing->created_at) }}</td>
                                                <td>{{ $ing->importe }}</td>
                                                <td><?php if($ing->nombreEm==null) echo "Carlos Fernando"; else echo $ing->nombreEm; ?> <?php if($ing->apellidoEm==null) echo "Javier Rimac"; else echo $ing->apellidoEm; ?></td>
                                            </tr>    
                                        @endforeach
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td>
                                                    TOTAL
                                                </td>
                                                <td>
                                                    {{ $cantIngreso->monto }}
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <td colspan="5">
                                                <ul class="pagination float-right"></ul>
                                            </td>
                                        </tr>
                                        </tfoot>
                                    </table>
                    
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div role="tabpanel" id="bHistorialActual" class="tab-pane">
                    <div class="panel-body row">

                        <div class="form-group col-md-12" id="data_3">
                            <label class="font-normal">Seleccionar una fecha</label>
                            <div class="input-group date">
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar"></i></span>
                                    <input id="fecHistorial" type="text" class="form-control" value="" onchange="obtenerFecha()">
                            </div>
                        </div>
                        <div class="row col-lg-12" id="listaHitorial">
                        <div class="col-lg-6">
                            <div class="ibox ">
                                <div class="ibox-title">
                                    <h5>Caja Salida</h5>
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
                                <div class="ibox-content" id="divListaHistorial">
                                    <table class="footable table table-stripped toggle-arrow-tiny">
                                        <thead>
                                        <tr>
                                            <th>Concepto</th>
                                            <th>Cliente</th>
                                            <th>Fecha de Transcaccion</th>
                                            <th>Monto</th>
                                            <th>Usuario</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($egreso as $eg)
                                            <tr>
                                                <td>{{ $eg->concepto }}</td>
                                                <td>{{ $eg->nombreCl }} {{ $eg->apellidoCl }}</td>
                                                <td>{{ $pro->cambiaf_a_espanol($eg->created_at) }}</td>
                                                <td>{{ $eg->monto }}</td>
                                                <td>{{ $eg->nombreEm }} {{ $eg->apellidoEm }}</td>
                                            </tr>    
                                        @endforeach
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td>
                                                    TOTAL
                                                </td>
                                                <td>
                                                    {{ $cantEgreso->monto }}
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <td colspan="5">
                                                <ul class="pagination float-right"></ul>
                                            </td>
                                        </tr>
                                        </tfoot>
                                    </table>
                    
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="ibox ">
                                <div class="ibox-title">
                                    <h5>Caja Entrada</h5>
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
                                <div class="ibox-content" id="divTipoPrestamo">
                                    <table class="footable table table-stripped toggle-arrow-tiny">
                                        <thead>
                                            <tr>
                                                <th>Concepto</th>
                                                <th>Cliente</th>
                                                <th>Fecha de Transcaccion</th>
                                                <th>Monto</th>
                                                <th>Usuario</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($ingreso as $ing)
                                            <tr>
                                                <td>{{ $ing->concepto }}</td>
                                                <td>{{ $ing->nombreCl }} {{ $ing->apellidoCl }}</td>
                                                <td>{{ $pro->cambiaf_a_espanol($ing->created_at) }}</td>
                                                <td>{{ $ing->monto }}</td>
                                                <td>{{ $ing->nombreEm }} {{ $ing->apellidoEm }}</td>
                                            </tr>    
                                        @endforeach
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td>
                                                    TOTAL
                                                </td>
                                                <td>
                                                    {{ $cantIngreso->monto }}
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <td colspan="5">
                                                <ul class="pagination float-right"></ul>
                                            </td>
                                        </tr>
                                        </tfoot>
                                    </table>
                    
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>

                <div role="tabpanel" id="regDeposito" class="tab-pane">
                    <div class="panel-body">
                        <div class="col-lg-12">
                            <div class="input-group">
                                <input type="text" placeholder="Buscar cliente... " class="input form-control" id="clienteBusqueda" onkeyup="buscarCliente()">
                                <span class="input-group-append">
                                        <button type="button" class="btn btn btn-primary"> <i class="fa fa-search"></i> Buscar</button>
                                </span>
                            </div>
                            <div id="listDepositoCliente">

                            </div>
                        </div>
                    </div>
                </div>

                <div role="tabpanel" id="consMovimientos" class="tab-pane">
                    <div class="panel-body">
                        <div class="col-lg-12 row">
                            <div class="input-group col-lg-5">
                                <input type="text" placeholder="Nombre del Cliente " class="input form-control" id="nomClienteCm">
                            </div>
                            <div class="input-group col-lg-2">
                                <input type="text" placeholder="Cod. Transacción " class="input form-control" id="codCm">
                            </div>
                            <div class="input-group col-lg-2">
                                <input type="date" class="form-control" id="fecInicioCm">
                            </div>
                            <div class="input-group col-lg-2">
                                <input type="date" class="form-control" id="fecFinCm">
                            </div>
                            <div class="input-group col-lg-1">
                                <span class="input-group-append">
                                        <button type="button" class="btn btn btn-primary" onclick="consultarPago()"> <i class="fa fa-search"></i> Buscar</button>
                                </span>
                            </div>
                            <div id="consMov">

                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>

<!-- Abrir Caja -->
<div class="modal inmodal fade" id="caja" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Abrir Caja</h4>
                <small class="font-bold">Caja {{ date('d/m/Y') }}:</small>
            </div>
            <div class="modal-body">

                <table class="table m-b-xs">
                    <tbody>
                    <tr hidden>
                        <td>
                            <strong>idAlmacen</strong>
                        </td>
                        <td>
                            <span id="idAlmacenNC">idAlmacen</span>
                        </td>
    
                    </tr>
                    <tr>
                        <td>
                            <strong>Periodo Caja Anterior</strong>
                        </td>
                        <td>
                            <span id="periodCaja">almacen</span>
                        </td>
    
                    </tr>
                    <tr>
                        <td>
                            <strong>Monto De Cierre Anterior</strong>
                        </td>
                        <td id="cbStand">
                            <span id="montoCierre">almacen</span>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="col-sm-12"><p style='text-align:left;'>Monto Caja:</p>
                    <input style="font-size: large;" type="text" class="form-control text-success" id="montoInicial" placeholder="S/. 0.00">
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-outline btn-success dim" data-dismiss="modal" onclick="abrirCaja()"><i class="fa fa-money"></i> Abrir Caja</button>
            </div>
        </div>
    </div>
</div>

<!-- Abrir Caja Grande -->
<div class="modal inmodal fade" id="cajaGrande" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Abrir Caja Grande</h4>
                <small class="font-bold">Caja {{ date('d/m/Y') }}:</small>
            </div>
            <div class="modal-body">

                <table class="table m-b-xs">
                    <tbody>
                    <tr>
                        <td>
                            <strong>Monto De Caja Grande</strong>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="col-sm-12"><p style='text-align:left;'>Monto Caja:</p>
                    <input style="font-size: large;" type="text" class="form-control text-success" id="montoInicialCajaGrande" placeholder="S/. 0.00">
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-outline btn-success dim" data-dismiss="modal" onclick="abrirCajaGrande()"><i class="fa fa-money"></i> Abrir Caja</button>
            </div>
        </div>
    </div>
</div>

<!-- Cerrar Caja -->
<div class="modal inmodal fade" id="cerrarCaja" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Cerrar Caja</h4>
                <small class="font-bold">Caja {{ date('d/m/Y') }}:</small>
            </div>
            <div class="modal-body">
                <input type="text" class="form-control text-success" id="idCajaC" hidden>
                <input type="text" class="form-control text-success" id="montoFinC" hidden>
                
                <table class="table m-b-xs">
                    <tbody>
                    <tr>
                        <td>
                            <strong>Inicio de Caja</strong>
                        </td>
                        <td>
                            <span id="periodCajaC">almacen</span>
                        </td>
    
                    </tr>
                    <tr>
                        <td>
                            <strong>Monto De Caja</strong>
                        </td>
                        <td id="cbStand">
                            <span id="montoCierreC">almacen</span>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-outline btn-success dim" data-dismiss="modal" onclick="cerrarCaja()"><i class="fa fa-money"></i> Cerrar Caja</button>
            </div>
        </div>
    </div>
</div>

<!-- Detalle de la Caja del Dia -->
<div class="modal inmodal fade" id="detalleCajaDia" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Detalle de la Caja</h4>
                <small class="font-bold">Fecha: <span id="detCajaFecha">idAlmacen</span></small>
            </div>
            <div class="modal-body" id="modalDetalleCajaDia">

                <div class="col-lg-12">
                    <div class="tabs-container">
                        <ul class="nav nav-tabs" role="tablist">
                            <li><a class="nav-link active" data-toggle="tab" href="#cSalida"> Caja Salida</a></li>
                            <li><a class="nav-link" data-toggle="tab" href="#cEntrada"> Caja Entrada</a></li>
                        </ul>
                        <div class="tab-content" id="divDetalleCaja">
                            <div role="tabpanel" id="cSalida" class="tab-pane active">
                                <div class="panel-body">
                                    <div class="ibox-content">
                                        <table class="footable table table-stripped toggle-arrow-tiny">
                                            <thead>
                                            <tr>
                                                <th data-toggle="true">Código</th>
                                                <th>Concepto</th>
                                                <th>Cliente</th>
                                                <th>Fecha de Transcaccion</th>
                                                <th>Monto</th>
                                                <th>Usuario</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($egreso as $eg)
                                                <tr>
                                                    <td>{{ $eg->id }}</td>
                                                    <td>{{ $eg->concepto }}</td>
                                                    <td>{{ $eg->nombreCl }} {{ $eg->apellidoCl }}</td>
                                                    <td>{{ $pro->cambiaf_a_espanol($eg->created_at) }}</td>
                                                    <td>{{ $eg->monto }}</td>
                                                    <td>{{ $eg->nombreEm }} {{ $eg->apellidoEm }}</td>
                                                </tr>    
                                            @endforeach
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <td colspan="5">
                                                    <ul class="pagination float-right"></ul>
                                                </td>
                                            </tr>
                                            </tfoot>
                                        </table>
                        
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" id="cEntrada" class="tab-pane">
                                <div class="panel-body">
                                    <div class="ibox-content">
                                        <table class="footable table table-stripped toggle-arrow-tiny">
                                            <thead>
                                                <tr>
                                                    <th data-toggle="true">Código</th>
                                                    <th>Concepto</th>
                                                    <th>Cliente</th>
                                                    <th>Fecha de Transcaccion</th>
                                                    <th>Monto</th>
                                                    <th>Usuario</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($ingreso as $ing)
                                                <tr>
                                                    <td>{{ $ing->id }}</td>
                                                    <td>{{ $ing->concepto }}</td>
                                                    <td>{{ $ing->nombreCl }} {{ $ing->apellidoCl }}</td>
                                                    <td>{{ $pro->cambiaf_a_espanol($ing->created_at) }}</td>
                                                    <td>{{ $ing->monto }}</td>
                                                    <td>{{ $ing->nombreEm }} {{ $ing->apellidoEm }}</td>
                                                </tr>    
                                            @endforeach
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <td colspan="5">
                                                    <ul class="pagination float-right"></ul>
                                                </td>
                                            </tr>
                                            </tfoot>
                                        </table>
                        
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-outline btn-success dim" data-dismiss="modal"><i class="fa fa-money"></i> ACEPTAR</button>
            </div>
        </div>
    </div>
</div>


<!-- Pagar Prestamo -->
<div class="modal inmodal fade" id="pagar" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Pagar Prestamo</h4>
                <small class="font-bold">USTED CUENTA CON EL CRÉDITO DE:</small>
            </div>
            <div class="modal-body">
                <table class="table m-b-xs">
                    <tbody>
                    <tr hidden>
                        <td>
                            <strong>Dia</strong>
                        </td>
                        <td>
                            <span id="diaPagar">Pagar</span>
                        </td>
    
                    </tr>
                    <tr hidden>
                        <td>
                            <strong>idPrestamo</strong>
                        </td>
                        <td>
                            <span id="idPagar">Pagar</span>
                        </td>
    
                    </tr>
                    <tr>
                        <td>
                            <strong>PRESTAMO</strong>
                        </td>
                        <td>
                            <span id="pagarPrestamo">Modal title</span>
                            <span id="diaMonto">Modal title</span>
                        </td>
    
                    </tr>
                    <tr>
                        <td>
                            <strong>INTERES</strong>
                        </td>
                        <td>
                            <span id="pagarInteres">Modal title</span>
                            <span id="diaInteres">Modal title</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>MORA</strong>
                        </td>
                        <td class = 'bg-danger'>
                            <span id="pagarMora">Modal title</span>
                            <span id="diaMora">Modal title</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>PAGO TOTAL</strong>
                        </td>
                        <td class = 'bg-primary'>
                            <span id="pagarTotal">Modal title</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Elegir Banco</strong>
                        </td>
                        <td>
                            <div class="col-sm-10" style='float: right; width: 150px;'>
                                <select class="form-control m-b" name="pBanco" id="pBanco">
                                    <option>
                                        Seleccione un banco
                                    </option>
                                    @foreach($listaBancos as $lb)
                                    <option value="{{ $lb->codigo }}">
                                        {{ $lb->tipo }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Código del Depósito</strong>
                        </td>
                        <td>
                            <div class="col-sm-10" style='float: right; width: 150px;'><input style="font-size: large;" type="text" class="form-control text-success" id="depSerie" placeholder="1111111"></div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Importe del Depósito</strong>
                        </td>
                        <td>
                            <div class="col-sm-10" style='float: right; width: 150px;'><input style="font-size: large;" type="text" class="form-control text-success" id="depImporte" placeholder="S/. 0.00"></div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-outline btn-success dim" data-dismiss="modal" onclick="depositarPago()"><i class="fa fa-money"></i> PAGAR</button>
            </div>
        </div>
    </div>
</div>
<!-- Fin Pagar -->

<!-- Renovar Prestamo -->
<div class="modal inmodal fade" id="renovar" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Renovar Prestamo</h4>
                <small class="font-bold">USTED CUENTA CON EL CRÉDITO DE:</small>
            </div>
            <div class="modal-body">
                <table class="table m-b-xs">
                    <tbody>
                    <tr hidden>
                        <td>
                            <strong>Dia</strong>
                        </td>
                        <td>
                            <span id="diaRenovar">Renovar</span>
                        </td>
    
                    </tr>
                    <tr hidden>
                        <td>
                            <strong>Interes</strong>
                        </td>
                        <td>
                            <span id="envInteres">Renovar</span>
                            <span id="envMonto">Renovar</span>
                        </td>
    
                    </tr>
                    <tr hidden>
                        <td>
                            <strong>Mora</strong>
                        </td>
                        <td>
                            <span id="envMora">Renovar</span>
                        </td>
    
                    </tr>
                    <tr hidden>
                        <td>
                            <strong>idPrestamo</strong>
                        </td>
                        <td>
                            <span id="idRenovar">Renovar</span>
                        </td>
    
                    </tr>
                    <tr>
                        <td>
                            <strong>PRESTAMO</strong>
                        </td>
                        <td>
                            <span id="renovarPrestamo">Modal title</span>
                        </td>
    
                    </tr>
                    <tr>
                        <td>
                            <strong>INTERES</strong>
                        </td>
                        <td>
                            <span id="renovarInteres">Modal title</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>MORA</strong>
                        </td>
                        <td class = 'bg-danger'>
                            <span id="renovarMora">Modal title</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>PAGO TOTAL</strong>
                        </td>
                        <td class = 'bg-primary'>
                            <span id="renovarTotal">Modal title</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>PAGO MÍNIMO</strong>
                        </td>
                        <td class = 'bg-info'>
                            <span id="renovarMinimo">Modal title</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Elegir Banco</strong>
                        </td>
                        <td>
                            <div class="col-sm-10" style='float: right; width: 150px;'>
                                <select class="form-control m-b" name="rBanco" id="rBanco">
                                    <option>
                                        Seleccione un banco
                                    </option>
                                    @foreach($listaBancos as $lb)
                                    <option value="{{ $lb->codigo }}">
                                        {{ $lb->tipo }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Código del Depósito</strong>
                        </td>
                        <td>
                            <div class="col-sm-10" style='float: right; width: 150px;'><input style="font-size: large;" type="text" class="form-control text-success" id="serRenovar"></div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>IMPORTE</strong>
                        </td>
                        <td>
                            <div class="col-sm-10" style='float: right; width: 150px;'><input style="font-size: large;" type="text" class="form-control text-success" id="impoRenovar" placeholder="S/. 0.00"></div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-outline btn-success dim" data-dismiss="modal" onclick="cancelarRenovar()"><i class="fa fa-money"></i> PAGAR</button>
            </div>
        </div>
    </div>
</div>
<!-- Fin Pagar -->

<!-- Detalles de Prestamo -->
<div class="modal inmodal fade" id="detalle" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Detalle de Prestamo <span id = "detId">Codigo</span></h4>
                <h4 class="font-bold"><span id = "detNombre">Nombre</span></h4>
                <small class="font-bold"><span id = "detDni">Dni</span></small>
            </div>
            <div class="modal-body">
                <table class="table m-b-xs">
                    <tbody>
                    <tr>
                        <td>
                            <strong>Garantía:</strong>
                        </td>
                        <td>
                            <span id="detGarantia">Garantia</span>
                        </td>
    
                    </tr>
                    <tr>
                        <td>
                            <strong>Fecha de Inicio:</strong>
                        </td>
                        <td>
                            <span id="detFecInicio">Fecha de Inicio</span>
                        </td>
    
                    </tr>
                    <tr>
                        <td>
                            <strong>Fecha de Fin:</strong>
                        </td>
                        <td>
                            <span id="detFecFin">Fecha de Fin</span>
                        </td>
    
                    </tr>
                    <tr>
                        <td>
                            <strong>Dias Transcurridos:</strong>
                        </td>
                        <td>
                            <span id="detDias">Dias Transcurridos</span>
                        </td>
    
                    </tr>
                    <tr>
                        <td>
                            <strong>Monto del Prestamo:</strong>
                        </td>
                        <td>
                            <span id="detMonto">Monto del Prestamo</span>
                        </td>
    
                    </tr>
                    <tr>
                        <td>
                            <strong>INTERES</strong>
                        </td>
                        <td>
                            <span id="detInteres">Interes del Prestamo</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>MORA</strong>
                        </td>
                        <td class = 'bg-danger'>
                            <span id="detMora">Mora de Prestamo</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>PAGO TOTAL</strong>
                        </td>
                        <td class = 'bg-primary'>
                            <span id="detTotal">Total de Prestamo</span>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-outline btn-success dim" data-dismiss="modal"> ACEPTAR</button>
            </div>
        </div>
    </div>
</div>
<!-- Fin Detalle -->

<!-- Comisión de Prestamo -->
<div class="modal inmodal fade" id="comision" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Comisión</h4>
                <small class="font-bold"><span id = "detDni">Registrar si existe comision del banco, si no ignorar</span></small>
            </div>
            <div class="modal-body">
                <table class="table m-b-xs">
                    <tbody>
                    <tr>
                        <td>
                            <strong>Comisión</strong>
                        </td>
                        <td>
                            <div class="col-sm-10" style='float: right; width: 150px;'><input style="font-size: large;" type="text" class="form-control text-success" id="imputComision" placeholder="S/. 0.00"></div>
                        </td>
                    </tr>
                    <tr hidden>
                        <td>
                            <div class="col-sm-10" style='float: right; width: 150px;'><input style="font-size: large;" type="text" class="form-control text-success" id="imputId" placeholder="S/. 0.00"></div>
                        </td>
                    </tr>
                    <tr hidden>
                        <td>
                            <div class="col-sm-10" style='float: right; width: 150px;'><input style="font-size: large;" type="text" class="form-control text-success" id="imputBanco" placeholder="S/. 0.00"></div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-outline btn-success dim" onclick="ingresarComision()"> ACEPTAR</button>
                <button type="button" class="btn btn-outline btn-danger dim" data-dismiss="modal"> SIN COMISION</button>
            </div>
        </div>
    </div>
</div>
<!-- Fin Detalle -->

<!-- Ver Bancos -->
<div class="modal inmodal fade" id="verBancos" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Ver Bancos <span id = "detId">Codigo</span></h4>
            </div>
            <div class="modal-body">
                <table class="table m-b-xs" id="tabBancos">
                    <tbody>
                        @foreach($listaBancos as $lb)
                        <tr style='background-color: #1AB394; color: #FFFFFF;'>
                            <td>
                                <a title='$nombre' data-gallery=''>{{ $lb->tipo }}</a>
                            </td>
                            <td>
                                <p style='text-align:right;'>S/. {{ $lb->monto }}</p>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-outline btn-success dim" data-dismiss="modal"> ACEPTAR</button>
            </div>
        </div>
    </div>
</div>
<!-- Fin Ver Bancos -->


<!-- Comisión de Prestamo -->
<div class="modal inmodal fade" id="modalBanco" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Abrir Caja de Banco</h4>
                <small class="font-bold"><span>Aqui puede abrir la caja del banco</span></small>
            </div>
            <div class="modal-body">
                <table class="table m-b-xs">
                    <tbody>
                    <tr>
                        <td>
                            <strong>Monto</strong>
                        </td>
                        <td>
                            <div class="col-sm-10" style='float: right; width: 150px;'><input style="font-size: large;" type="text" class="form-control text-success" id="imputMontoBanco" placeholder="S/. 0.00"></div>
                        </td>
                    </tr>
                    <tr hidden>
                        <td>
                            <div class="col-sm-10" style='float: right; width: 150px;'><input style="font-size: large;" type="text" class="form-control text-success" id="imputIdBanco" placeholder="S/. 0.00"></div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-outline btn-success dim" onclick="abrirBanco()"> Abrir Caja</button>
                <button type="button" class="btn btn-outline btn-danger dim" data-dismiss="modal"> Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- Fin Detalle -->

@endsection
@section('script')


<link href="{{ asset('css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">


   <script src="{{ asset('js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
    <script>
        
        function verBancos(){
            $('#verBancos').modal('show');
            document.getElementById("montoBn").innerHTML="<p style='text-align:right;'>S/. " +bn+"</p>";
            document.getElementById("montoBCP").innerHTML="<p style='text-align:right;'>S/. " +bcp+"</p>";
            document.getElementById("montoInterbanck").innerHTML="<p style='text-align:right;'>S/. " +interbank+"</p>";
        }
        
        function modalAbrirCaja() {
            $('#cajaGrande').modal('show');
        }

        function obtenerFecha(){

            var fecha = $('#fecHistorial').val();

            //var varDate = $("#dateStart").val(); 

            var DateinISO = $.datepicker.parseDate('mm/dd/yy', fecha); 

            var dateFormato = $.datepicker.formatDate( "yy-mm-dd", new Date( DateinISO ) );

            $.post('{{ route("consultarHistorial") }}', { fecha: dateFormato, _token: '{{ csrf_token() }}'}).done(function(data){
                $("#listaHitorial").empty();
                $("#listaHitorial").html(data.view);
            });

        }

        function modalCaja(montoFin, fechaInicio, fechaFin){
            $('#caja').modal('show');
            document.getElementById("montoCierre").innerHTML="<span> S/. " +montoFin+"</span>";
            document.getElementById("periodCaja").innerHTML="<span> " +fechaInicio+" - " +fechaFin+ "</span>";
        }
        
        function modalAbrirBanco(id) {
            $('#imputIdBanco').val(id);
            $('#modalBanco').modal('show');
            
        }

        function modalCerrarCaja(montoFin, fechaInicio, fechaFin){
            $('#cerrarCaja').modal('show');

            $.post('{{ route("consultarCaja") }}', { _token: '{{ csrf_token() }}'}).done(function(data){
                document.getElementById("montoCierreC").innerHTML="<span> S/. " +data.monto+"</span>";
                document.getElementById("periodCajaC").innerHTML="<span> " +data.fecha+"</span>";
                
                $("#idCajaC").val(data.id);
                $("#montoFinC").val(data.monto);
            });
        }

        function detalleCajaDia(id) {
            
            $('#detalleCajaDia').modal('show');

            $.post('{{ route("detalleCajaDia") }}', {id: id, _token: '{{ csrf_token() }}'}).done(function(data){
                  $("#divDetalleCaja").empty();
                  $("#divDetalleCaja").html(data.view);
            });

        }
        
        function abrirBanco(){
            var imputIdBanco = $('#imputIdBanco').val();
            var imputMontoBanco = $('#imputMontoBanco').val();
            $('#modalBanco').modal('hide');
            
             $.post('{{ route("abrirBanco") }}', {imputIdBanco: imputIdBanco, imputMontoBanco: imputMontoBanco, _token: '{{ csrf_token() }}'}).done(function(data){
                $("#tabBancos").empty();
                $("#tabBancos").html(data.view);
                $('#modalBanco').modal('show');
                setTimeout(function() {
                    toastr.options = {
                        closeButton: true,
                        progressBar: true,
                        showMethod: 'slideDown',
                        timeOut: 4000,
                        positionClass: 'toast-top-center'
                    };
                    toastr.success(data.respuesta, 'Iniciar');

                }, 1300);
            });
            
        }

        function abrirCaja(){
            var montoInicial = $('#montoInicial').val();
            $.post('{{ route("abrirCaja") }}', {montoInicial: montoInicial, _token: '{{ csrf_token() }}'}).done(function(data){
                $("#genCaja").empty();
                $("#genCaja").html(data.view);
                
                swal("Respuesta!", data.respuesta);
                /*
                if (data.aux == 0) {
                    swal("Error!", data.respuesta);
                } else {
                    setTimeout(function() {
                        toastr.options = {
                            closeButton: true,
                            progressBar: true,
                            showMethod: 'slideDown',
                            timeOut: 4000,
                            positionClass: 'toast-top-center'
                        };
                        toastr.success(data.aux, 'Iniciar');
    
                    }, 1300);
                }
                */
                
            });
        }
        
        function abrirCajaGrande(){
            var montoInicial = $('#montoInicialCajaGrande').val();
            $.post('{{ route("abrirCajaGrande") }}', {montoInicial: montoInicial, _token: '{{ csrf_token() }}'}).done(function(data){
                $("#genCaja").empty();
                $("#genCaja").html(data.view);
                
                swal("Respuesta!", data.respuesta);
                /*
                if (data.aux == 0) {
                    swal("Error!", data.respuesta);
                } else {
                    setTimeout(function() {
                        toastr.options = {
                            closeButton: true,
                            progressBar: true,
                            showMethod: 'slideDown',
                            timeOut: 4000,
                            positionClass: 'toast-top-center'
                        };
                        toastr.success(data.aux, 'Iniciar');
    
                    }, 1300);
                }
                */
                
            });
        }

        function cerrarCaja(){
            var id = $('#idCajaC').val();
            var montoFin = $('#montoFinC').val();

            $.post('{{ route("cerrarCaja") }}', {id: id, montoFin: montoFin, _token: '{{ csrf_token() }}'}).done(function(data){
                $("#genCaja").empty();
                $("#genCaja").html(data.view);
                setTimeout(function() {
                    toastr.options = {
                        closeButton: true,
                        progressBar: true,
                        showMethod: 'slideDown',
                        timeOut: 4000,
                        positionClass: 'toast-top-center'
                    };
                    toastr.success(data.respuesta, 'Gracias');

                }, 1300);
            });
        }

        function buscarFechaDia() {
            var FechaInicio = $('#hBFecInicio').val();
            var FechaFin = $('#hBFecFin').val();

            $.post('{{ route("buscarFechaDiaCaja") }}', {FechaInicio: FechaInicio, FechaFin: FechaFin, _token: '{{ csrf_token() }}'}).done(function(data){
                $("#divCajaDia").empty();
                $("#divCajaDia").html(data.view);
            });
            
        }

        function buscarFechaMensual() {
            var FechaInicio = $('#hMFecInicio').val();
            var FechaFin = $('#hMFecFin').val();

            $.post('{{ route("buscarFechaMesCaja") }}', {FechaInicio: FechaInicio, FechaFin: FechaFin, _token: '{{ csrf_token() }}'}).done(function(data){
                $("#divCajaMes").empty();
                $("#divCajaMes").html(data.view);
            });
            
        }

        function buscarCliente() {
            var cliente = $('#clienteBusqueda').val();          
            
            $.post('{{ route("buscarDepositoCliente") }}', {cliente: cliente, _token: '{{ csrf_token() }}'}).done(function(data){
                $("#listDepositoCliente").empty();
                $("#listDepositoCliente").html(data.view);
            });
             
        }

        function Pagar(id, monto, interes, mora, total, dia, diafin) {
            
            $('#pagar').modal('show');

            document.getElementById("pagarPrestamo").innerHTML="<p style='text-align:right;'>S/. " +monto+"</p>";
            document.getElementById("pagarInteres").innerHTML="<p style='text-align:right;'>S/. "+interes+"</p>";
            document.getElementById("pagarMora").innerHTML="<p style='text-align:right;'>S/. "+mora+"</p>";
            document.getElementById("pagarTotal").innerHTML="<p style='text-align:right;'>S/. "+total+"</p>";
            document.getElementById("idPagar").innerHTML="<input style='font-size: large;' type='text' class='form-control text-success' id='idPrestamoP' value='" +id+"'>";
            document.getElementById("diaPagar").innerHTML="<input style='font-size: large;' type='text' class='form-control text-success' id='diaPago' value='" +dia+"'>";
            document.getElementById("diaMora").innerHTML="<input hidden style='font-size: large;' type='text' class='form-control text-success' id='pagoMora' value='" +mora+"'>";
            document.getElementById("diaInteres").innerHTML="<input hidden style='font-size: large;' type='text' class='form-control text-success' id='pagoInteres' value='" +interes+"'>";
            document.getElementById("diaMonto").innerHTML="<input hidden style='font-size: large;' type='text' class='form-control text-success' id='pagoMonto' value='" +monto+"'>";
            //document.getElementById("pagarMinimo").innerHTML="<p style='text-align:right;'>S/. "+interes+"</p>";
                
        }

        function vuelto() {
            var importeRecibido = $("#impoRecibido").val();
            var importePago = $("#impoPagar").val();

            var vuelto = parseFloat(importeRecibido) - parseFloat(importePago);

            $("#vuelto").val(vuelto);
            
        }

        function Detalle(id, nombre, dni, garantia, fecinicio, fecfin, dias, monto, interes, mora, total) {
            $('#detalle').modal('show');

            document.getElementById("detId").innerHTML="<p>" +id+"</p>";
            document.getElementById("detNombre").innerHTML="<p>"+nombre+"</p>";
            document.getElementById("detDni").innerHTML="<p>"+dni+"</p>";
            document.getElementById("detGarantia").innerHTML="<p style='text-align:right;'>"+garantia+"</p>";
            document.getElementById("detFecInicio").innerHTML="<p style='text-align:right;'>"+fecinicio+"</p>";
            document.getElementById("detFecFin").innerHTML="<p style='text-align:right;'>"+fecfin+"</p>";
            document.getElementById("detDias").innerHTML="<p style='text-align:right;'>"+dias+"</p>";
            document.getElementById("detMonto").innerHTML="<p style='text-align:right;'>S/. "+monto+"</p>";
            document.getElementById("detInteres").innerHTML="<p style='text-align:right;'>S/. "+interes+"</p>";
            document.getElementById("detMora").innerHTML="<p style='text-align:right;'>S/. "+mora+"</p>";
            document.getElementById("detTotal").innerHTML="<p style='text-align:right;'>S/. "+total+"</p>";
           /* if (dias < 21) {
                alert('descuento');
            }*/
        }

        function Renovar(id, monto, interes, mora, total, dia, diafin) {
            $('#renovar').modal('show');
            pagoMinimo = parseInt(interes) + parseInt(mora);
            document.getElementById("idRenovar").innerHTML="<input style='font-size: large;' type='text' class='form-control text-success' id='idPrestamoR' value='" +id+"'>";
            document.getElementById("diaRenovar").innerHTML="<input style='font-size: large;' type='text' class='form-control text-success' id='diaReno' value='" +dia+"'>";
            document.getElementById("envInteres").innerHTML="<input style='font-size: large;' type='text' class='form-control text-success' id='renInteres' value='" +interes+"'>";
            document.getElementById("envMora").innerHTML="<input style='font-size: large;' type='text' class='form-control text-success' id='renMora' value='" +mora+"'>";
            document.getElementById("envMonto").innerHTML="<input style='font-size: large;' type='text' class='form-control text-success' id='renMonto' value='" +monto+"'>";
            document.getElementById("renovarPrestamo").innerHTML="<p style='text-align:right;'>S/. " +monto+"</p>";
            document.getElementById("renovarInteres").innerHTML="<p style='text-align:right;'>S/. "+interes+"</p>";
            document.getElementById("renovarMora").innerHTML="<p style='text-align:right;'>S/. "+mora+"</p>";
            document.getElementById("renovarTotal").innerHTML="<p style='text-align:right;'>S/. "+total+"</p>";
            document.getElementById("renovarMinimo").innerHTML="<p style='text-align:right;'>S/. "+pagoMinimo+"</p>";
        }

        function depositarPago() {
            var idPrestamo = $("#idPrestamoP").val();
            var dia = $("#diaPago").val();
            var mora = $("#pagoMora").val();
            var pago = $("#depImporte").val();
            var interes = $("#pagoInteres").val();
            var serie = $("#depSerie").val();
            var monto = $("#pagoMonto").val();
            var banco = $("#pBanco").val();
            
            $.post( "{{ Route('depositarPrestamo') }}", {idPrestamo: idPrestamo, dia: dia, mora: mora, pago: pago, interes: interes, serie: serie, monto: monto, banco: banco, _token:'{{csrf_token()}}'}).done(function(data) {
                       // $("#tabCliente").empty();
                        //$("#tabCliente").html(data.view);
                        if( data.resp == 0){
                            swal("Error", "Hubo un problema al registrar su pago", "error");
                        }else if(data.resp == 1){

                            swal("Correcto", "El pago se realizó correctamente", "success");
                            $("#imputId").val(data.idPrestamo);
                            $("#imputBanco").val(data.banco);
                            $('#comision').modal('show');

                        }else if(data.resp == 2){
                            swal("Error", "Monto incorrecto", "error");
                        }
                        
                    });
            
        }

        function ingresarComision() {
            var idPrestamo = $("#imputId").val();
            var comision = $("#imputComision").val();
            var banco = $("#imputBanco").val();

            $.post( "{{ Route('ingresarComision') }}", {idPrestamo: idPrestamo, comision: comision, banco: banco, _token:'{{csrf_token()}}'}).done(function(data) {
                // $("#tabCliente").empty();
                 //$("#tabCliente").html(data.view);
                 if( data.resp == 0){
                     swal("Error", "Hubo un problema al registrar su pago", "error");
                 }else if(data.resp == 1){

                     swal("Correcto", "Gracias por registrar el deposito", "success");
                     $('#comision').modal('hide');
                     var pagoId = data.data.id;
                     var url = '{{ route('printTicket', ['id' => ':id']) }}';
                     url = url.replace(':id', pagoId);
                     window.open(url, '_blank');

                 }else if(data.resp == 2){
                     swal("Error", "Monto incorrecto", "error");
                 }
                 
             });
        }


        function cancelarRenovar() {
            var idPrestamo = $("#idPrestamoR").val();
            var dia = $("#diaReno").val();
            var mora = $("#renMora").val();
            var pago = $("#impoRenovar").val();
            var interes = $("#renInteres").val();
            var serie = $("#serRenovar").val();
            var monto = $("#renMonto").val();
            var banco = $("#rBanco").val();
            var calc = parseFloat(interes) + parseFloat(mora);
            if (pago >= calc ) {

                $.post( "{{ Route('renovarDepositoPrestamo') }}", {idPrestamo: idPrestamo, pago: pago, dia: dia, interes: interes, mora: mora, serie: serie, monto: monto, banco: banco, _token:'{{csrf_token()}}'}).done(function(data) {
                    
                        if( data.resp == 0){
                            swal("Error", "Hubo un problema al registrar su pago", "error");
                        }else if(data.resp == 1){

                            swal("Correcto", "El pago se realizó correctamente", "success");
                            
                            $("#imputId").val(data.idPrestamo);
                            $("#imputBanco").val(data.banco);
                            $('#comision').modal('show');

                        }else if(data.resp == 2){
                            swal("Error", "Monto incorrecto", "error");
                        }
                        
                    });
            }else{
                swal("Verificar", "El importe mínimo debe ser S/." +calc, "warning");
            }
            
        }

        function consultarPago() {
            var nombre = $("#nomClienteCm").val();
            var codigo = $("#codCm").val();
            var fecInicio = $("#fecInicioCm").val();
            var fecFin = $("#fecFinCm").val();
            
            $.post( "{{ Route('consultarMovimiento') }}", {nombre: nombre, codigo: codigo, fecInicio: fecInicio, fecFin: fecFin, _token:'{{csrf_token()}}'}).done(function(data) {

                            $("#consMov").empty();
                            $("#consMov").html(data.view);

                        
                    });
        }
        
        //Prueba
        $(document).ready(function(){

            $('#data_3 .input-group.date').datepicker({
                startView: 2,
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true
            });
        });
        //Fin Prueba

    </script>
@endsection
