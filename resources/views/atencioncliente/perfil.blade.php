<?php
use App\proceso;
$pro = new proceso();
?>  
<style>
    
    #semaforo{
       border:3px solid
    }
    
</style>
@extends('layouts.app')
@section('pagina')
    Pefil de Cliente
@endsection
@section('contenido')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>{{ $cliente[0]->nombre }} {{ $cliente[0]->apellido }}</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ Route('home') }}">Inicio</a>
                </li>
                <li class="breadcrumb-item">
                    <a>Atención al cliente</a>
                </li>
                <li class="breadcrumb-item active">     
                    <strong>Perfil del Cliente</strong>
                </li>
                <input value="{{ $cliente[0]->cliente_id }}" id="cliente_id" hidden>
            </ol>
        </div>
        <div class="col-lg-2">

        </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">


        <div class="row m-b-lg m-t-lg">
            <div class="col-md-4">

                <div class="profile-image">
                    <img src="{{ url($cliente[0]->foto) }}" class="rounded-circle circle-border m-b-md" alt="profile">
                </div>
                <div class="profile-info">
                    <div class="">
                        <div>
                            <h2 class="no-margins">
                                {{ $cliente[0]->nombre }} {{ $cliente[0]->apellido }}
                            </h2>
                            <h4>{{ $cliente[0]->dni }}</h4>
                            <small>
                                <p>Telefono: {{ $cliente[0]->telefono }}</p>
                                <p>Correo: {{ $cliente[0]->correo }}</p>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <table class="table small m-b-xs">
                    <tbody>
                        <tr>
                            <td>
                                <strong>{{ $cantPrePendiente[0]->catPrestamo }}</strong> Prestamos Pendientes
                            </td>

                        </tr>
                        <tr>
                            <td>
                                <strong>{{ $cantPreAceptadas[0]->catPrestamo }}</strong> Prestamos Cancelados
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>{{ $cantPrestamo[0]->catPrestamo }}</strong> Total de Prestamos
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>


        </div>
        <div class="row">


            <div class="col-lg-3">

                <div class="ibox ">
                    <button class="btn btn-warning " type="button"
                        onclick="mostrarCliente('{{ $cliente[0]->cliente_id }}')"><i class="fa fa-pencil"></i> Editar
                        Cliente</button>
                </div>
                
                <div class="ibox" id="divSemaforo">
                </div>
            </div>

            <div class="col-lg-5">
                <h3>Prestamos</h3>
                <div class="col-lg-12">
                    <?php
                    $ver = '';
                    $eva = $cliente[0]->evaluacion;
                    if ($eva <= -1) { $ver='hidden' ; } ?> 
                    <button class="btn btn-success " type="button"
                        onclick="nuevoPrestamo()" {{ $ver }}><i class="fa fa-external-link-square"></i>&nbsp;&nbsp;<span
                            class="bold">Realizar Prestamo</span></button>
                        <button class="btn btn-default " type="button" onclick="historialPrestamos()"><i
                                class="fa fa-file-text"></i>&nbsp;&nbsp;<span class="bold">Historial
                                Prestamo</span></button>
                </div>
                <li class="dropdown-divider"></li>
                @foreach ($prestamo as $pr)
                    <?php
                    $inicio = $pr->fecinicio;
                    $fechaActual = date('d-m-Y');
                    $dias = (strtotime($inicio) - strtotime($fechaActual)) / 86400;
                    $dias = abs($dias);
                    $dias = floor($dias);

                    if ($dias < 2) { $dia=$dias . ' día' ; } else { $dia=$dias . ' días' ; } if ($pr->estado == 'ACTIVO') {
                        $estado = 'default';
                        $vDia = 'hidden';
                        $lDia = 'hidden';
                        $sDia = 'hidden';
                        $verBoton = 'hidden';
                        $cDia = 'hidden';
                        } else {
                        if ($dias < 30) { if ($pr->estado == 'ACTIVO DESEMBOLSADO') {
                            $estado = 'primary';
                            $vDia = '';
                            $lDia = 'hidden';
                            $sDia = 'hidden';
                            $verBoton = '';
                            $cDia = 'hidden';
                            } elseif ($pr->estado == 'PAGADO') {
                            $estado = 'success';
                            $vDia = 'hidden';
                            $lDia = 'hidden';
                            $sDia = 'hidden';
                            $verBoton = 'hidden';
                            $cDia = '';
                            } else {
                            $estado = 'default';
                            $vDia = 'hidden';
                            $lDia = 'hidden';
                            $sDia = 'hidden';
                            $verBoton = 'hidden';
                            $cDia = 'hidden';
                            }
                            } elseif (30 < $dias && $dias < 45) { if ($pr->estado == 'ACTIVO DESEMBOLSADO') {
                                $estado = 'warning';
                                $vDia = '';
                                $lDia = 'hidden';
                                $sDia = 'hidden';
                                $verBoton = '';
                                $cDia = 'hidden';
                                } elseif ($pr->estado == 'PAGADO') {
                                $estado = 'success';
                                $vDia = 'hidden';
                                $lDia = 'hidden';
                                $sDia = 'hidden';
                                $verBoton = 'hidden';
                                $cDia = '';
                                } else {
                                $estado = 'default';
                                $vDia = 'hidden';
                                $lDia = 'hidden';
                                $sDia = 'hidden';
                                $verBoton = 'hidden';
                                $cDia = 'hidden';
                                }
                                } elseif (45 < $dias && $dias < 60) { if ($pr->estado == 'ACTIVO DESEMBOLSADO') {
                                    $estado = 'danger';
                                    $vDia = '';
                                    $lDia = 'hidden';
                                    $sDia = 'hidden';
                                    $verBoton = '';
                                    $cDia = 'hidden';
                                    } elseif ($pr->estado == 'PAGADO') {
                                    $estado = 'success';
                                    $vDia = 'hidden';
                                    $lDia = 'hidden';
                                    $sDia = 'hidden';
                                    $verBoton = 'hidden';
                                    $cDia = '';
                                    } else {
                                    $estado = 'default';
                                    $vDia = 'hidden';
                                    $lDia = 'hidden';
                                    $sDia = 'hidden';
                                    $verBoton = 'hidden';
                                    $cDia = 'hidden';
                                    }
                                    } else {
                                    if ($pr->estado == 'ACTIVO DESEMBOLSADO') {
                                    $estado = 'danger';
                                    $vDia = '';
                                    $lDia = 'hidden';
                                    $sDia = 'hidden';
                                    $verBoton = '';
                                    $cDia = 'hidden';
                                    } elseif ($pr->estado == 'PAGADO') {
                                    $estado = 'success';
                                    $vDia = 'hidden';
                                    $lDia = 'hidden';
                                    $sDia = 'hidden';
                                    $verBoton = 'hidden';
                                    $cDia = '';
                                    } elseif ($pr->estado == 'LIQUIDACION') {
                                    $estado = 'danger';
                                    $vDia = 'hidden';
                                    $lDia = '';
                                    $sDia = 'hidden';
                                    $verBoton = 'hidden';
                                    $cDia = 'hidden';
                                    } elseif ($pr->estado == 'VENDIDO') {
                                    $estado = 'danger';
                                    $vDia = 'hidden';
                                    $lDia = 'hidden';
                                    $sDia = '';
                                    $verBoton = 'hidden';
                                    $cDia = 'hidden';
                                    } else {
                                    $estado = 'default';
                                    $vDia = 'hidden';
                                    $lDia = 'hidden';
                                    $sDia = 'hidden';
                                    $verBoton = 'hidden';
                                    $cDia = 'hidden';
                                    }
                                    }
                                    }
                                    ?>
                                    <div class="col-lg-12">
                                        <div class="panel panel-{{ $estado }}">
                                            <div class="panel-heading">
                                                <a href="#" class="text-primary">
                                                    {{ $pr->nombre }}
                                                </a>
                                                <small class="text-primary">Fecha de Registro: {{ $pr->created_at }}</small>
                                                <div class="ibox-tools">
                                                    <label class="label label-default" {{ $vDia }}>{{ $dia }},
                                                        Pendiente</label>
                                                    <br>
                                                    <label class="label label-default" {{ $lDia }}>LIQUIDACION</label>
                                                    <label class="label label-default" {{ $sDia }}>VENDIDO</label>
                                                    <label class="label label-default" {{ $cDia }}>CANCELADO</label>
                                                </div>
                                            </div>
                                            <div class="panel-body row">
                                                <div class="col-lg-6">
                                                    <p>
                                                        Monto del Prestamo: {{ $pr->monto }}
                                                    </p>
                                                    <p>
                                                        Fecha de Inicio: {{ $pro->cambiaf_a_espanol($pr->fecinicio) }}
                                                    </p>
                                                    <p>
                                                        Fecha de Fin: {{ $pro->cambiaf_a_espanol($pr->fecfin) }}
                                                    </p>
                                                </div>
                                                <div class="col-lg-6">
                                                    <img alt="image" src="{{ asset('img/codigoYape.png') }}" height="80%"
                                                        width="80%">
                                                </div>
                                                <div class="col-lg-12">
                                                    <h4>Pagos en:</h4>
                                                    <h5> BCP: <b>375-30500414-0-56</b></h5>
                                                    <h5> B. N.: <b>04-393-261108</b></h5>
                                                    <h5> Interbank: <b>6223172545805</b></h5>
                                                    <h4 style="text-align: center"><b>"CONFIRMAR SU PAGO A LA EMPRESA"</b>
                                                    </h4>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="panel-footer">
                                                <div class="btn-group">
                                                    <button class="btn btn-primary btn-xs" {{ $verBoton }}
                                                        onclick="Pagar('{{ $pr->prestamo_id }}', '{{ $pr->monto }}', '{{ $pro->interesActual($dias, $pr->monto, $pr->porcentaje, $pr->morapagar)[0] }}', '{{ $pro->calcularMora($pr->fecfin, $pr->morapagar) }}', '{{ $pro->interesActual($dias, $pr->monto, $pr->porcentaje, $pr->morapagar)[2] }}', '{{ $pro->interesActual($dias, $pr->monto, $pr->porcentaje, $pr->morapagar)[4] }}', '{{ $pro->cambiaf_a_espanol($pr->fecfin) }}')"><i
                                                            class="fa fa-dollar"></i> Pagar</button>
                                                    <button class="btn btn-warning btn-xs" {{ $verBoton }}
                                                        onclick="Renovar('{{ $pr->prestamo_id }}', '{{ $pr->monto }}', '{{ $pro->interesActual($dias, $pr->monto, $pr->porcentaje, $pr->morapagar)[0] }}', '{{ $pro->calcularMora($pr->fecfin, $pr->morapagar) }}', '{{ $pro->interesActual($dias, $pr->monto, $pr->porcentaje, $pr->morapagar)[2] }}', '{{ $dias }}', '{{ $pro->cambiaf_a_espanol($pr->fecfin) }}')"><i
                                                            class="fa fa-share"></i> Renovars</button>
                                                    <button class="btn btn-info btn-xs"
                                                        onclick="Detalle('{{ $pr->prestamo_id }}', '{{ $pr->nombre }}', '{{ $pro->cambiaf_a_espanol($pr->fecinicio) }}', '{{ $pro->cambiaf_a_espanol($pr->fecfin) }}', '{{ $dias }}', '{{ $pr->monto }}', '{{ $pro->interesActual($dias, $pr->monto, $pr->porcentaje, $pr->morapagar)[0] }}', '{{ $pro->calcularMora($pr->fecfin, $pr->morapagar) }}', '{{ $pro->interesActual($dias, $pr->monto, $pr->porcentaje, $pr->morapagar)[2] }}', '{{ $pr->estado }}')"><i
                                                            class="fa fa-exclamation-triangle"></i> Ver Detalles</button>
                                                    <button class="btn btn-danger btn-xs"
                                                        onclick="verNotificacion('{{ $pr->prestamo_id }}')"><i
                                                            class="fa fa-exclamation-triangle"></i> Ver
                                                        Notificaciones</button>
                                                    <button class="btn btn-success btn-xs" type="button"
                                                        onclick="historialPago('{{ $pr->prestamo_id }}')"><i
                                                            class="fa fa-money"></i>Historial de Pagos</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                @endforeach

            </div>
            <div class="col-lg-4 m-b-lg">
                <h3>Cotizaciones</h3>
                <button class="btn btn-info " type="button" onclick="nuevaCotizacion()"><i
                        class="fa fa-edit"></i>&nbsp;&nbsp;<span class="bold">Realizar Cotización</span></button>
                <div id="vertical-timeline" class="vertical-container light-timeline no-margins">
                    @foreach ($cotizacion as $ct)
                        <div class="vertical-timeline-block">
                            <div class="vertical-timeline-icon navy-bg">
                                <i class="fa fa-briefcase"></i>
                            </div>

                            <div class="vertical-timeline-content">
                                <h2>{{ $ct->garantia }}</h2>
                                <p>Rango de Cotizacion: {{ $ct->max }} - {{ $ct->min }}
                                </p>
                                <p>Tipo de Prestamo: {{ $ct->tipoPrestamo }}
                                </p>
                                <a onclick="verCasillerosAlmacen('{{ $ct->garantia_id }}', '{{ $ct->cotizacion_id }}')" class="btn btn-sm btn-primary"> <p style="color:#FFFFFF";>Asignar Almacen</p></a>
                                <span class="vertical-date">
                                    Fecha de Solicitud <br>
                                    <small>{{ $ct->created_at }}</small>
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="modal inmodal fade" id="nPrestamo" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                    <h4 class="modal-title">Lista de Cotizaciones</h4>
                    <small class="font-bold">En esta lista se mnuestran las cotizaciones aprobadas y pendientes de
                        préstamo.</small>
                </div>
                <div class="modal-body" id="listaCotizaciones">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Tipo de Prestamo</th>
                                <th>Garantía</th>
                                <th>Rango de Prestamo</th>
                                <th>Empleado</th>
                                <th>Generar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($listCotizaciones as $lc)
                                <tr>
                                    <td>{{ $lc->tipoPrestamo }}</td>
                                    <td>{{ $lc->garantia }}</td>
                                    <td>{{ $lc->max }} - {{ $lc->min }}</td>
                                    <td> {{ $lc->empleado }} </td>
                                    <td> <a href="{{ Route('prestamo', [$lc->cotizacion_id]) }}"><i
                                                class="fa fa-plus"></i></a> </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Crear Cotizacion -->
    <div class="modal inmodal fade" id="nCotizacion" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                    <h4 class="modal-title">Nueva Cotización</h4>
                    <small class="font-bold">Generar Nueva Cotización.</small>
                </div>
                <div class="modal-body">
                    <select class="select2_demo_1 form-control" id="tipoPrestamo" onchange="seleccionarTipoPrestamo()">
                        <option>Seleccione un tipo de Prestamo...</option>
                        @foreach ($tipoPrestamo as $tp)
                            <option value="{{ $tp->id }}">{{ $tp->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="modal-body" id="cPrendario">

                    <a href="https://reportedeudas.sbs.gob.pe/reportedeudasSBS1/Default.aspx" target="_blank"
                        class="btn btn-success btn-facebook btn-outline" id="aDeudasSbs">
                        <i class="fa fa-line-chart"></i> Reporte de Deudas SBS
                    </a>
                    <a href="https://www.osiptel.gob.pe/sistemas/sigem.html" target="_blank"
                        class="btn btn-success btn-facebook btn-outline" id="aDeudaOsiptel">
                        <i class="fa fa-tablet"></i> Osiptel
                    </a>
                    <a href="https://www.mercadolibre.com.pe/" target="_blank"
                        class="btn btn-success btn-facebook btn-outline" id="aDeudasMercLibre">
                        <i class="fa fa-shopping-cart"></i> Mercado Libre
                    </a>
                    <a href="https://www.olx.com.pe/" target="_blank" class="btn btn-success btn-facebook btn-outline"
                        id="aDeudaOlx"> 
                        <i class="fa fa-usd"></i> OLX
                    </a>



                    <h2>Crédito Prendario</h2>
                    <p>
                        
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Buscar su ganantía" id="input_garantia">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-primary" onclick="buscarGarantia()">Buscar!</button>
                            </span>
                          </div>
                        <br>
                        <select class="select2_demo_1 form-control" id="tipoGarantiaCp">
                            <option>Seleccione un tipo de Garantia...</option>
                            @foreach ($tipoGarantia as $tg)
                                <option value="{{ $tg->id }}">{{ $tg->nombre }}</option>
                            @endforeach
                        </select>
                        
                    </p>
                    <div class="form-group  row"><label class="col-sm-2 col-form-label">Garantía</label>

                        <div class="col-sm-10"><input type="text" class="form-control" id="nomGarantiaCp"></div>
                    </div>
                    <div class="form-group  row"><label class="col-sm-2 col-form-label">Detalle</label>

                        <div class="col-sm-10"><input type="text" class="form-control" id="detGarantiaCp"></div>
                    </div>
                    <div class="form-group  row">
                        <label class="col-sm-2 col-form-label">Precio Real</label>
                        <div class="col-sm-10"><input type="text" class="form-control" id="precRealCP"
                                onkeyup="EnterCp(event)"></div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-10">
                            <div class="row">
                                <div class="col-md-6"><label class="col-sm-3 col-form-label">Máximo</label><input
                                        type="text" placeholder="max" class="form-control" id="maxCp" readonly></div>
                                <div class="col-md-6"><label class="col-sm-3 col-form-label">Mínimo</label><input
                                        type="text" placeholder="min" class="form-control" id="minCp" readonly></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-body" id="cUniversitario">
                    <a href="https://reportedeudas.sbs.gob.pe/reportedeudasSBS1/Default.aspx" target="_blank"
                        class="btn btn-success btn-facebook btn-outline" id="aDeudasSbs">
                        <i class="fa fa-line-chart"></i> Reporte de Deudas SBS
                    </a>
                    <a href="https://www.osiptel.gob.pe/sistemas/sigem.html" target="_blank"
                        class="btn btn-success btn-facebook btn-outline" id="aDeudaOsiptel">
                        <i class="fa fa-tablet"></i> Osiptel
                    </a>
                    <a href="https://www.mercadolibre.com.pe/" target="_blank"
                        class="btn btn-success btn-facebook btn-outline" id="aDeudasMercLibre">
                        <i class="fa fa-shopping-cart"></i> Mercado Libre
                    </a>
                    <a href="https://www.olx.com.pe/" target="_blank" class="btn btn-success btn-facebook btn-outline"
                        id="aDeudaOlx">
                        <i class="fa fa-usd"></i> OLX
                    </a>
                    <h2>Crédito Univeritario</h2>
                    <p>
                        <select class="select2_demo_1 form-control" id="tipoGarantiaCu">
                            <option>Seleccione un tipo de Garantia...</option>
                            @foreach ($tipoGarantia as $tg)
                                <option value="{{ $tg->id }}">{{ $tg->nombre }}</option>
                            @endforeach
                        </select>
                    </p>
                    <div class="form-group  row"><label class="col-sm-2 col-form-label">Garantía</label>

                        <div class="col-sm-10"><input type="text" class="form-control" id="nomGarantiaCu"></div>
                    </div>
                    <div class="form-group  row"><label class="col-sm-2 col-form-label">Detalle</label>

                        <div class="col-sm-10"><input type="text" class="form-control" id="detGarantiaCu"></div>
                    </div>
                    <div class="form-group  row">
                        <label class="col-sm-2 col-form-label">Precio Real</label>
                        <div class="col-sm-10"><input type="text" class="form-control" id="precRealCU"
                                onkeyup="EnterCu(event)"></div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-10">
                            <div class="row">
                                <div class="col-md-6"><label class="col-sm-3 col-form-label">Máximo</label><input
                                        type="text" placeholder="max" class="form-control" id="maxCu" readonly></div>
                                <div class="col-md-6"><label class="col-sm-3 col-form-label">Mínimo</label><input
                                        type="text" placeholder="min" class="form-control" id="minCu" readonly></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-body" id="cJoyas">
                    <a href="https://reportedeudas.sbs.gob.pe/reportedeudasSBS1/Default.aspx" target="_blank"
                        class="btn btn-success btn-facebook btn-outline" id="aDeudasSbs">
                        <i class="fa fa-line-chart"></i> Reporte de Deudas SBS
                    </a>
                    <a href="https://www.osiptel.gob.pe/sistemas/sigem.html" target="_blank"
                        class="btn btn-success btn-facebook btn-outline" id="aDeudaOsiptel">
                        <i class="fa fa-tablet"></i> Osiptel
                    </a>
                    <a href="https://www.mercadolibre.com.pe/" target="_blank"
                        class="btn btn-success btn-facebook btn-outline" id="aDeudasMercLibre">
                        <i class="fa fa-shopping-cart"></i> Mercado Libre
                    </a>
                    <a href="https://www.olx.com.pe/" target="_blank" class="btn btn-success btn-facebook btn-outline"
                        id="aDeudaOlx">
                        <i class="fa fa-usd"></i> OLX
                    </a>
                    <h2>Crédito de Joyas</h2>
                    <p>
                        <select class="select2_demo_1 form-control" id="tipoJoya">
                            <option>Seleccione un tipo de Joya...</option>
                            @foreach ($tipoJoya as $tj)
                                <option value="{{ $tj->id }}">{{ $tj->nombre }} - {{ $tj->pureza }}</option>
                            @endforeach
                        </select>
                    </p>
                    <div class="form-group  row">
                        <label class="col-sm-2 col-form-label">Peso</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="pesoCj" onkeyup="EnterCj(event)">
                        </div>

                    </div>
                    <div class="form-group  row">
                        <label class="col-sm-2 col-form-label">Detalle</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="detalleCj" placeholder="Peso en Gramos">
                        </div>

                    </div>
                    <div class="form-group  row"><label class="col-sm-2 col-form-label">Valor Real</label>

                        <div class="col-sm-10"><input type="text" class="form-control" id="valorCj" readonly></div>
                    </div>
                </div>
            <!--
                <div class="row col-md-12 col-sm-12 col-xs-12">
                    <div class="col-md-6 col-sm-4 col-xs-12 form-group has-feedback">
                        <strong>Almacen: </strong>
                        <select class="form-control m-b" name="almacen_id" id="almacen_id" onchange="buscarStand()"
                            onclick="buscarStand()">
                            <option>Seleccione un almacen...</option>
                            @foreach ($almacen as $al)
                                <option value="{{ $al->id }}"> {{ $al->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 col-sm-4 col-xs-12 form-group has-feedback" id="listStand">
                        <strong>Stand: </strong>
                        <select class="form-control m-b" name="account" id="stand_id">
                            <option>Seleccione un almacen...</option>
                        </select>
                    </div>
                    <div class="col-md-12 col-sm-8 col-xs-12 form-group has-feedback" id="listCasillero">
                        <strong>Casillero: </strong>
                        <select class="form-control m-b" name="account" id="casillero_id">
                            <option>Seleccione un casillero...</option>
                        </select>
                    </div>
                </div>
            -->


                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="generarCotizacion()">Generar</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- ASIGNAR ALMACEN -->
    <div class="modal inmodal fade" id="asingAlmacen" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                    <h4 class="modal-title">Lista de Casilleros</h4>
                    <small class="font-bold">Se mostrará la lista de casilleros libres.</small>
                    <input type="text" class="form-control" id="inputGarantia" placeholder="Peso en Gramos" hidden>
                    <input type="text" class="form-control" id="inputCotizacion" placeholder="Peso en Gramos" hidden>
                </div>
                <div class="modal-body">
                    <div class="row col-md-12 col-sm-12 col-xs-12">
                        <div class="col-md-6 col-sm-4 col-xs-12 form-group has-feedback">
                            <strong>Almacen: </strong>
                            <select class="form-control m-b" name="almacen_id" id="almacen_id" onchange="buscarStand()"
                                onclick="buscarStand()">
                                <option>Seleccione un almacen...</option>
                                @foreach ($almacen as $al)
                                    <option value="{{ $al->id }}"> {{ $al->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 col-sm-4 col-xs-12 form-group has-feedback" id="listStand">
                            <strong>Stand: </strong>
                            <select class="form-control m-b" name="account" id="stand_id">
                                <option>Seleccione un almacen...</option>
                            </select>
                        </div>
                        <div class="col-md-12 col-sm-8 col-xs-12 form-group has-feedback" id="listCasillero">
                            <strong>Casillero: </strong>
                            <select class="form-control m-b" name="account" id="casillero_id">
                                <option>Seleccione un casillero...</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary" data-dismiss="modal" onclick="asignarAlmacen()">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Editar Cliente -->
    <div class="modal inmodal fade" id="editarClienteModal" tabindex="-1" role="dialog" aria-hidden="true">
        <form id="fcliente" name="fcliente" method="post" action="guardarCliente" class="formCliente"
            enctype="multipart/form-data">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title">Editar el Cliente</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <input type="text" name="_token" id="_token" hidden value="{{ csrf_token() }}">
                            <input type="text" placeholder="Nombres" class="form-control" id="editId" name="editId" hidden>
                            <div class="col-lg-6">
                                <div class="ibox-content">
                                    <form>
                                        <div class="form-group row">
                                            <label class="col-lg-12 col-form-label">Nombre</label>
                                            <div class="col-lg-12">
                                                <input type="text" placeholder="Nombres" class="form-control"
                                                    id="editNombre" name="editNombre">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-12 col-form-label">Tipo Documento</label>
                                            <div class="col-lg-12">
                                                <select class="form-control m-b" name="editTipoDocIde" id="editTipoDocIde">
                                                    <option>Seleccionar un Tipo de Documento...</option>
                                                    @foreach ($tipoDocumento as $td)
                                                        <option value="{{ $td->id }}">{{ $td->nombre }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-12 col-form-label">Correo</label>
                                            <div class="col-lg-12">
                                                <input type="text" placeholder="Correo" id="editCorreo" class="form-control"
                                                    name="editCorreo">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-12 col-form-label">Num Referencia</label>
                                            <div class="col-lg-12">
                                                <input type="text" placeholder="Número de Referencia" id="editNumReferencia"
                                                    class="form-control" name="editNumReferencia">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-12 col-form-label">Fecha de Nacimiento</label>
                                            <div class="col-lg-12">
                                                <input type="date" placeholder="Fecha de Nacimiento" id="editFecNac"
                                                    class="form-control" name="editFecNac">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-12 col-form-label">Genero</label>
                                            <div class="col-lg-12">
                                                <input type="text" placeholder="Género" id="editGenero" class="form-control"
                                                    name="editGenero">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-12 col-form-label">Dirección</label>
                                            <div class="col-lg-12">
                                                <input type="text" placeholder="Dirección" id="editDireccion"
                                                    class="form-control" name="editDireccion">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-12 col-form-label">Distrito</label>
                                            <div class="col-lg-12">
                                                <select class="form-control m-b" name="editDistrito" id="editDistrito">
                                                    <option>Seleccionar un Distrito...</option>
                                                    @foreach ($distrito as $di)
                                                        <option value="{{ $di->id }}">{{ $di->distrito }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-12 col-form-label">Ocupación</label>
                                            <div class="col-lg-12">
                                                <select class="form-control m-b" name="editOcupacion" id="editOcupacion">
                                                    <option>Seleccionar un Ocupación...</option>
                                                    @foreach ($ocupacion as $oc)
                                                        <option value="{{ $oc->id }}">{{ $oc->nombre }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="ibox-content">
                                    <div class="form-group row">
                                        <label class="col-lg-12 col-form-label">Apellido</label>
                                        <div class="col-lg-12">
                                            <input type="text" placeholder="Apellidos" id="editApellido"
                                                class="form-control" name="editApellido">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-12 col-form-label">DNI</label>
                                        <div class="col-lg-12">
                                            <input type="text" placeholder="DNI" id="editDNI" class="form-control"
                                                name="editDNI">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-12 col-form-label">Telefono</label>
                                        <div class="col-lg-12">
                                            <input type="text" placeholder="Teléfono" id="editTelefono" class="form-control"
                                                name="editTelefono">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-12 col-form-label">Whatsapp</label>
                                        <div class="col-lg-12">
                                            <input type="text" placeholder="Whatsapp" id="editWhatsapp" class="form-control"
                                                name="editWhatsapp">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-12 col-form-label">Edad</label>
                                        <div class="col-lg-12">
                                            <input type="text" placeholder="Edad" id="editEdad" class="form-control"
                                                name="editEdad">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-12 col-form-label">Foto</label>
                                        <div class="col-lg-12">
                                            <input id="editFotoA" placeholder="Foto" type="file" class="form-control"
                                                name="editFotoA">
                                            <input id="editFoto" placeholder="Foto" type="text" class="form-control" hidden
                                                name="editFoto">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-12 col-form-label">Facebook</label>
                                        <div class="col-lg-12">
                                            <input type="text" placeholder="Facebook" id="editFacebook" class="form-control"
                                                name="editFacebook">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-12 col-form-label">Provincia</label>
                                        <div class="col-lg-12">
                                            <select class="form-control m-b" name="editProvincia" id="editProvincia">
                                                <option>Seleccionar un Provincia...</option>
                                                @foreach ($provincia as $pr)
                                                    <option value="{{ $pr->id }}">{{ $pr->provincia }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-12 col-form-label">Departamento</label>
                                        <div class="col-lg-12">
                                            <select class="form-control m-b" name="editDepartamento" id="editDepartamento">
                                                <option>Seleccionar un Departamento...</option>
                                                @foreach ($departamento as $de)
                                                    <option value="{{ $de->id }}">{{ $de->departamento }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- Fin Editar -->

    <!-- Pagar Prestamo -->
    <div class="modal inmodal fade" id="pagar" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
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
                                </td>

                            </tr>
                            <tr>
                                <td>
                                    <strong>INTERES</strong>
                                </td>
                                <td>
                                    <span id="pagarInteres">Modal title</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>MORA</strong>
                                </td>
                                <td class='bg-danger'>
                                    <span id="pagarMora">Modal title</span>
                                    <span id="diaMora">Modal title</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>PAGO TOTAL</strong>
                                </td>
                                <td class='bg-primary'>
                                    <span id="pagarTotal">Modal title</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline btn-success dim" data-dismiss="modal"><i
                            class="fa fa-money"></i> ACEPTAR</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin Pagar -->

    <!-- Renovar Prestamo -->
    <div class="modal inmodal fade" id="renovar" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
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
                                <td class='bg-danger'>
                                    <span id="renovarMora">Modal title</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>PAGO TOTAL</strong>
                                </td>
                                <td class='bg-primary'>
                                    <span id="renovarTotal">Modal title</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>PAGO MÍNIMO</strong>
                                </td>
                                <td class='bg-info'>
                                    <span id="renovarMinimo">Modal title</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline btn-success dim" data-dismiss="modal"><i
                            class="fa fa-money"></i> ACEPTAR</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin Pagar -->

    <!-- Detalles de Prestamo -->
    <div class="modal inmodal fade" id="detalle" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                    <h4 class="modal-title">Detalle de Prestamo <span id="detId">Codigo</span></h4>
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
                                <td class='bg-danger'>
                                    <span id="detMora">Mora de Prestamo</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>PAGO TOTAL</strong>
                                </td>
                                <td class='bg-primary'>
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

    <!-- Historial de Prestamo -->
    <div class="modal inmodal fade" id="hPrestamo" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                    <h4 class="modal-title">Detalle de Prestamos <span id="detId">Codigo</span></h4>
                </div>
                <div class="modal-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Monto</th>
                                <th>Garantia</th>
                                <th>Fec Inicio</th>
                                <th>Fec Fin</th>
                                <th>Adminitración</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($hPrestamo as $hp)
                                <tr>
                                    <td>{{ $hp->prestamo_id }}</td>
                                    <td>{{ $hp->monto }}</td>
                                    <td>{{ $hp->garantia }}</td>
                                    <td>{{ $hp->fecinicio }}</td>
                                    <td> {{ $hp->fecfin }} </td>
                                    <td><button class="btn btn-success btn-xs" type="button"
                                            onclick="historialPago('{{ $hp->prestamo_id }}')"><i
                                                class="fa fa-money"></i>Historial de Pagos</button></td>
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
    <!-- Fin Historial -->

    <!-- Historial de Prestamo -->
    <div class="modal inmodal fade" id="vNotificar" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                    <h4 class="modal-title">Ver Notificaciones</span></h4>
                </div>
                <div class="modal-body" id="verNotifi">

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline btn-success dim" data-dismiss="modal"> ACEPTAR</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin Historial -->

    <!-- Historial de Pago -->
    <div class="modal inmodal fade" id="hPago" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                    <h4 class="modal-title">Ver Histortial de Pagos</span></h4>
                </div>
                <div class="modal-body" id="verPagos">

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline btn-success dim" data-dismiss="modal"> ACEPTAR</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin Historial -->
    
    <!-- Config Valoracion -->
    <div class="modal inmodal fade" id="mConfValoracion" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                    <h4 class="modal-title">Editar Valoración</span></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <select class="select2_demo_1 form-control" id="colorValidacion">
                                <option>Seleccione Color...</option>
                                <option value="VERDE">VERDE</option>
                                <option value="AMBAR">AMBAR</option>
                                <option value="ROJO">ROJO</option>
                        </select>
                    </div>
                        
                    <div class="form-group row">
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" value="" id="ValCheck1" checked>
                          <label class="form-check-label" for="ValCheck1">
                            Personalizado
                          </label>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline btn-success dim" data-dismiss="modal" onclick="configSemaforo()"> ACEPTAR</button>
                    <button type="button" class="btn btn-outline btn-danger dim" data-dismiss="modal"> Cancelar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin Config Valoracion -->

@endsection
@section('script')
    <script src="js/plugins/blueimp/jquery.blueimp-gallery.min.js"></script>
    <link href="css/plugins/blueimp/css/blueimp-gallery.min.css" rel="stylesheet">
    <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

    <!-- d3 and c3 charts -->
    <script src="{{ asset('js/plugins/d3/d3.min.js') }}"></script>
    <script src="{{ asset('js/plugins/c3/c3.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            
            actualizarSemaforo();


            $("#sparkline1").sparkline([0], {
                type: 'line',
                width: '100%',
                height: '50',
                lineColor: '#1ab394',
                fillColor: "transparent"
            });


        });
        
        function asignarAlmacen() {
            var garantia_id = $("#inputGarantia").val();
            var casillero_id = $("#casillero_id").val();
            var cotizacion_id = $("#inputCotizacion").val();
            var cliente_id = $("#cliente_id").val();
            var vista = "0";
            
            $.post("{{ Route('asignarCasillero') }}", {garantia_id: garantia_id, casillero_id: casillero_id, cotizacion_id: cotizacion_id, cliente_id: cliente_id, vista: vista, _token: '{{ csrf_token() }}'}).done(function(data) {
                
                swal("Correcto", "Casillero Asignado", "success");
                //toastr.success('Semáforo actualizado');
                $("#vertical-timeline").empty();
                $("#vertical-timeline").html(data.view);    
                
                
            });
        }
        
        function actualizarSemaforo() {
            var cliente_id = $("#cliente_id").val();
            
            $.post("{{ Route('actualizarSemaforo') }}", {cliente_id: cliente_id, _token: '{{ csrf_token() }}'}).done(function(data) {
                
                toastr.success('Semáforo actualizado');
                $("#divSemaforo").empty();
                $("#divSemaforo").html(data.view);    
                
                
            });
            
        }
        
        function configSemaforo() {
            var cliente_id = $("#cliente_id").val();
            var checkbox = document.getElementById("ValCheck1");
            var color = $("#colorValidacion").val();
            var estadoVal = "PERSONALIZADO";
            
            if (checkbox.checked == false) {
               estadoVal = "NUEVO";
            }
            
            $.post("{{ Route('personalizarSemaforo') }}", {cliente_id: cliente_id, estadoVal: estadoVal, color: color, _token: '{{ csrf_token() }}'}).done(function(data) {
                
                toastr.success('Semáforo actualizado');
                $("#divSemaforo").empty();
                $("#divSemaforo").html(data.view);    
                
            });
            
            
        }
        
        function mostrarValoracion() {
            $('#mConfValoracion').modal('show');
        }

        function nuevoPrestamo() {
            $('#nPrestamo').modal('show');
        }

        function historialPrestamos() {
            $('#hPrestamo').modal('show');
        }

        function verNotificacion(id) {
            $('#vNotificar').modal('show');

            $.post("{{ Route('verNotificacion') }}", {
                id: id,
                _token: '{{ csrf_token() }}'
            }).done(function(data) {
                $("#verNotifi").empty();
                $("#verNotifi").html(data.view);

            });
        }

        function historialPago(id) {
            $('#hPago').modal('show');

            $.post("{{ Route('verPagos') }}", {
                id: id,
                _token: '{{ csrf_token() }}'
            }).done(function(data) {
                $("#verPagos").empty();
                $("#verPagos").html(data.view);
            });
        }


        function nuevaCotizacion() {
            document.getElementById('cPrendario').style.display = 'none';
            document.getElementById('cJoyas').style.display = 'none';
            document.getElementById('cUniversitario').style.display = 'none';
            $('#nCotizacion').modal('show');
        }

        function seleccionarTipoPrestamo() {
            var idTipoPrestamo = $("#tipoPrestamo").val();
            if (idTipoPrestamo == "1") {
                document.getElementById('cPrendario').style.display = 'block';
                document.getElementById('cJoyas').style.display = 'none';
                document.getElementById('cUniversitario').style.display = 'none';
            } else if (idTipoPrestamo == "2") {
                document.getElementById('cPrendario').style.display = 'none';
                document.getElementById('cJoyas').style.display = 'block';
                document.getElementById('cUniversitario').style.display = 'none';



            } else if (idTipoPrestamo == "3") {
                document.getElementById('cPrendario').style.display = 'none';
                document.getElementById('cJoyas').style.display = 'none';
                document.getElementById('cUniversitario').style.display = 'block';
            } else {
                document.getElementById('cPrendario').style.display = 'none';
                document.getElementById('cJoyas').style.display = 'none';
                document.getElementById('cUniversitario').style.display = 'none';
            }
        }

        function EnterCp(e) {
            tecla = (document.all) ? e.keyCode : e.which;
            if (tecla == 13) {
                var codigo = $("#precRealCP").val();
                var precMin = "100";
                var precMax = parseInt(codigo) * 0.3;
                $("#maxCp").val(precMax);
                $("#minCp").val(precMin);
            }
        }

        function EnterCu(e) {
            tecla = (document.all) ? e.keyCode : e.which;
            if (tecla == 13) {
                var codigo = $("#precRealCU").val();
                var precMin = "100";
                var precMax = parseInt(codigo) * 0.3;
                $("#maxCu").val(precMax);
                $("#minCu").val(precMin);
            }
        }

        function EnterCj(e) {
            tecla = (document.all) ? e.keyCode : e.which;
            if (tecla == 13) {
                var codigo = $("#pesoCj").val();

                var idTipoGarantia = $('#tipoJoya').val();
                $.post("{{ Route('valorJoyas') }}", {
                    idTipoGarantia: idTipoGarantia,
                    _token: '{{ csrf_token() }}'
                }).done(function(data) {
                    var precMax = data.precMax;
                    var precMin = data.precMin;

                    var valorReal = parseFloat(precMax) * parseFloat(codigo);
                    $("#valorCj").val(valorReal);
                });
            }
        }

        function generarCotizacion() {
            // Datos de CP
            var tipoPrestamoCp = $("#tipoPrestamo").val();
            var cliente_id = $("#cliente_id").val();
            var tipoGarantiaCp = $("#tipoGarantiaCp").val();
            var nomGarantiaCp = $("#nomGarantiaCp").val();
            var detGarantiaCp = $("#detGarantiaCp").val();
            var precRealCP = $("#precRealCP").val();
            var maxCp = $("#maxCp").val();
            var minCp = $("#minCp").val();

            // Datos de CU
            var tipoGarantiaCu = $("#tipoGarantiaCu").val();
            var nomGarantiaCu = $("#nomGarantiaCu").val();
            var detGarantiaCu = $("#detGarantiaCu").val();
            var precRealCU = $("#precRealCU").val();
            var maxCu = $("#maxCu").val();
            var minCu = $("#minCu").val();

            // Datos de CJ
            var tipoJoya = $("#tipoJoya").val();
            var pesoCj = $("#pesoCj").val();
            var valorCj = $("#valorCj").val();
            var detalleCj = $("#detalleCj").val();

            //var casillero = $("#casillero_id").val();


            $.post("{{ Route('generarCotizacion') }}", {
                tipoPrestamoCp: tipoPrestamoCp,
                cliente_id: cliente_id,
                tipoGarantiaCp: tipoGarantiaCp,
                nomGarantiaCp: nomGarantiaCp,
                detGarantiaCp: detGarantiaCp,
                precRealCP: precRealCP,
                maxCp: maxCp,
                minCp: minCp,
                tipoGarantiaCu: tipoGarantiaCu,
                nomGarantiaCu: nomGarantiaCu,
                detGarantiaCu: detGarantiaCu,
                precRealCU: precRealCU,
                maxCu: maxCu,
                minCu: minCu,
                tipoJoya: tipoJoya,
                pesoCj: pesoCj,
                valorCj: valorCj,
                detalleCj: detalleCj,
                _token: '{{ csrf_token() }}'
            }).done(function(data) {
                $('#nCotizacion').modal('hide');
                $("#vertical-timeline").empty();
                $("#vertical-timeline").html(data.view);
                $("#listaCotizaciones").empty();
                $("#listaCotizaciones").html(data.view2);
                $("#areaNotificaciones").empty();
                $("#areaNotificaciones").html(data.notificacion);
            });
        }

        $(document).ready(function() {
            var valoracion = $("#valoracion").val();
            c3.generate({
                bindto: '#gauge',
                data: {
                    columns: [
                        ['Valoración', valoracion]
                    ],

                    type: 'gauge'
                },
                color: {
                    pattern: ['#008CE9', '#BDD5E5']

                }
            });
        });
        
        function buscarGarantia(){
            var dato = $("#input_garantia").val();
            
            $.post("{{ Route('buscarGarantiaPC') }}", {dato: dato, _token: '{{ csrf_token() }}'}).done(function(data) {
                if(data.resp == 1){
                    toastr.success('Garantia admitida, eliga el producto exacto en la lista');
                    $("#tipoGarantiaCp").empty();
                    $("#tipoGarantiaCp").html(data.view);    
                }else{
                    toastr.error('GARANTIA NO ADMITIDA');
                    $("#tipoGarantiaCp").empty();
                    $("#tipoGarantiaCp").html(data.view);
                }
                
            });
            
        }

        function buscarStand() {
            var almacen_id = $("#almacen_id").val();

            $.post("{{ Route('buscarStandCotizacion') }}", {
                almacen_id: almacen_id,
                _token: '{{ csrf_token() }}'
            }).done(function(data) {
                $("#listStand").empty();
                $("#listStand").html(data.view);
            });
        }

        function buscarCasillero() {
            var stand_id = $("#stand_id").val();

            $.post("{{ Route('buscarCasilleroCotizacion') }}", {
                stand_id: stand_id,
                _token: '{{ csrf_token() }}'
            }).done(function(data) {
                $("#listCasillero").empty();
                $("#listCasillero").html(data.view);
            });
        }

        function mostrarCliente(id) {
            $('#editarClienteModal').modal('show');
            $.post("{{ Route('cargarEditCliente') }}", {
                id: id,
                _token: '{{ csrf_token() }}'
            }).done(function(data) {
                $("#editNombre").val(data.nombre);
                $("#editApellido").val(data.apellido);
                $("#editTipoDocIde").val(data.tipodocide_id);
                $("#editDNI").val(data.dni);
                $("#editCorreo").val(data.correo);
                $("#editTelefono").val(data.telefono);
                $("#editNumReferencia").val(data.referencia);
                $("#editWhatsapp").val(data.whatsapp);
                $("#editFecNac").val(data.fecnac);
                $("#editEdad").val(data.edad);
                $("#editGenero").val(data.genero);
                $("#editFoto").val(data.foto);
                $("#editFacebook").val(data.facebook);
                $("#editDireccion").val(data.direccion);
                $("#editDistrito").val(data.distrito_id);
                $("#editProvincia").val(data.provincia_id);
                $("#editDepartamento").val(data.departamento_id);
                $("#editOcupacion").val(data.ocupacion_id);
                $("#editId").val(data.id);
            });
        }

        $(document).on("submit", ".formCliente", function(e) {

            e.preventDefault();
            var formu = $(this);
            var nombreform = $(this).attr("id");

            if ($('#genMasculino').is(":checked")) {
                var genero = "Masculino";
            } else {
                var genero = "Femenino";
            }

            if (nombreform == "fcliente") {
                var miurl = "{{ Route('editarCliente') }}";
            }
            var formData = new FormData($("#" + nombreform + "")[0]);

            $.ajax({
                url: miurl,
                type: 'POST',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    setTimeout(function() {
                        toastr.options = {
                            closeButton: true,
                            progressBar: true,
                            showMethod: 'slideDown',
                            timeOut: 4000,
                            positionClass: 'toast-top-center'
                        };
                        toastr.info('Subiendo Archivos, por favor espere');

                    }, 1300);
                    $('#editarClienteModal').modal('hide');
                },
                success: function(data) {
                    location.reload(true);

                    $('#editarClienteModal').modal('hide');
                },
                error: function(data) {
                    setTimeout(function() {
                        toastr.options = {
                            closeButton: true,
                            progressBar: true,
                            showMethod: 'slideDown',
                            timeOut: 4000,
                            positionClass: 'toast-top-center'
                        };
                        toastr.error('Error al registrar el cliente');

                    }, 1300);
                }
            });
        });

        function Detalle(id, garantia, fecinicio, fecfin, dias, monto, interes, mora, total, estado) {
            $('#detalle').modal('show');

            if (estado == "PAGADO") {
                dias = "CANCELADO";
                mora = "CANCELADO";
                total = "CANCELADO";
            } else {
                if (dias < 30) {
                    total = total - mora;
                    mora = "0.00";
                }
            }

            document.getElementById("detId").innerHTML = "<p>" + id + "</p>";
            document.getElementById("detGarantia").innerHTML = "<p style='text-align:right;'>" + garantia + "</p>";
            document.getElementById("detFecInicio").innerHTML = "<p style='text-align:right;'>" + fecinicio + "</p>";
            document.getElementById("detFecFin").innerHTML = "<p style='text-align:right;'>" + fecfin + "</p>";
            document.getElementById("detDias").innerHTML = "<p style='text-align:right;'>" + dias + "</p>";
            document.getElementById("detMonto").innerHTML = "<p style='text-align:right;'>S/. " + monto + "</p>";
            document.getElementById("detInteres").innerHTML = "<p style='text-align:right;'>S/. " + interes + "</p>";
            document.getElementById("detMora").innerHTML = "<p style='text-align:right;'>S/. " + mora + "</p>";
            document.getElementById("detTotal").innerHTML = "<p style='text-align:right;'>S/. " + total + "</p>";

        }
        
        function verCasillerosAlmacen(garantia_id, cotizacion_id) {
            $("#inputGarantia").val(garantia_id);
            $("#inputCotizacion").val(cotizacion_id);
            $('#asingAlmacen').modal('show');
        }

        function Pagar(id, monto, interes, mora, total, dia, diafin) {
            $('#pagar').modal('show');


            document.getElementById("pagarPrestamo").innerHTML = "<p style='text-align:right;'>S/. " + monto + "</p>";
            document.getElementById("pagarInteres").innerHTML = "<p style='text-align:right;'>S/. " + interes + "</p>";
            document.getElementById("pagarMora").innerHTML = "<p style='text-align:right;'>S/. " + mora + "</p>";
            document.getElementById("pagarTotal").innerHTML = "<p style='text-align:right;'>S/. " + total + "</p>";
            document.getElementById("idPagar").innerHTML =
                "<input style='font-size: large;' type='text' class='form-control text-success' id='idPrestamoP' value='" +
                id + "'>";
            document.getElementById("diaPagar").innerHTML =
                "<input style='font-size: large;' type='text' class='form-control text-success' id='diaPago' value='" +
                dia + "'>";
            document.getElementById("diaMora").innerHTML =
                "<input hidden style='font-size: large;' type='text' class='form-control text-success' id='pagoMora' value='" +
                mora + "'>";


        }

        function Renovar(id, monto, interes, mora, total, dia, diafin) {
            $('#renovar').modal('show');



            pagoMinimo = parseInt(interes) + parseInt(mora);
            document.getElementById("idRenovar").innerHTML =
                "<input style='font-size: large;' type='text' class='form-control text-success' id='idPrestamoR' value='" +
                id + "'>";
            document.getElementById("diaRenovar").innerHTML =
                "<input style='font-size: large;' type='text' class='form-control text-success' id='diaReno' value='" +
                dia + "'>";
            document.getElementById("envInteres").innerHTML =
                "<input style='font-size: large;' type='text' class='form-control text-success' id='renInteres' value='" +
                interes + "'>";
            document.getElementById("envMora").innerHTML =
                "<input style='font-size: large;' type='text' class='form-control text-success' id='renMora' value='" +
                mora + "'>";
            document.getElementById("renovarPrestamo").innerHTML = "<p style='text-align:right;'>S/. " + monto + "</p>";
            document.getElementById("renovarInteres").innerHTML = "<p style='text-align:right;'>S/. " + interes + "</p>";
            document.getElementById("renovarMora").innerHTML = "<p style='text-align:right;'>S/. " + mora + "</p>";
            document.getElementById("renovarTotal").innerHTML = "<p style='text-align:right;'>S/. " + total + "</p>";
            document.getElementById("renovarMinimo").innerHTML = "<p style='text-align:right;'>S/. " + pagoMinimo + "</p>";
        }

    </script>
@endsection
