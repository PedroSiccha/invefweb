<?php 
    $nuevafecha = "";
    $fecha = date('Y-m-j');
    $nuevafecha = strtotime ( '+30 day' , strtotime ( $fecha ) ) ;
    $nuevafecha = date ( 'Y-m-j' , $nuevafecha );
?>  
@extends('layouts.app')
@section('pagina')
    Generar Prestamos
@endsection
@section('contenido')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Generación de Prestamos</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ Route('home') }}">Inicio</a>
            </li>
            <li class="breadcrumb-item">
                <a>Prestamos</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Gestión de Prestamos</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-6">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>{{ $cliente[0]->nombre }} {{ $cliente[0]->apellido }} </h5>
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
            <div class="ibox-content">
                @foreach($cliente as $cli)
                <input type="text" id="cliente_id" value="{{ $cli->id }}" hidden="true">
                <address>
                    {{ $cli->dni }}<br>
                    {{ $cli->direccion }}<br>
                </address>
                @endforeach
                <address>
                    @foreach ($almacen as $al)
                    <strong>{{ $al->casillero }}, {{ $al->stand }}, {{ $al->almacen }} </strong>    
                    @endforeach
                </address>
                </br>
                </br>
                </br>
                </br>
                </br>
                </br>
                </br>
            </div>

        </div>

    </div>

        <div class="col-lg-6">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Cotización</h5>
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
                <div class="ibox-content">
                        @foreach($cotizacion as $cot)
                        <address>
                            <h2 class="font-bold" onclick="modalProducto()">{{ $cot->producto }} </h2><br>
                            <input type="text" id="garantia_id" value="{{ $cot->garantia_id }}" hidden="true">
                            <input type="text" id="cotizacion_id" value="{{ $cot->cotizacion_id }}" hidden="true">
                            <input type="text" id="nomGarantia" value="{{ $cot->producto }}" hidden="true">
                            <div class="row">
                            <div class="col-lg-4">
                                <div class="ibox">
                                    <div class="ibox-content">
                                        <h5 class="m-b-md">Valor Máximo</h5>
                                        <h2 class="text-navy">
                                            <i class="fa fa-play fa-rotate-270"></i> S/. {{ $cot->presmax }}
                                        </h2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="ibox">
                                    <div class="ibox-content">
                                        <h5 class="m-b-md">Valor Mínimo</h5>
                                        <h2 class="text-danger">
                                            <i class="fa fa-play fa-rotate-90"></i> S/. {{ $cot->presmin }}
                                        </h2>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </address>
                        @endforeach
                </div>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Prestamo</h5>
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
                <div class="ibox-content">
                        <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                        <strong>Fecha de Inicio: </strong>
                        <input type="date" class="form-control has-feedback-left" id="fecInicio" value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}" readonly="true">
                        
                        </div>

                        <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                        <strong>Fecha de Fin: </strong>
                        <input type="date" class="form-control" id="fecFin" value="{{ $nuevafecha }}">
                        
                        </div>

                        <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                        <strong>Monto Solicitado: </strong>
                        <input type="number" class="form-control has-feedback-left" id="montoPrestamo" value="{{ $cotizacion[0]->presmax }}" max="{{ $cotizacion[0]->presmax }}" min="{{ $cotizacion[0]->presmin }}"/>
                        
                        </div>

                        <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                        <strong>Seleccione Interes: </strong>
                            <select class="form-control m-b" name="account" id="interes_id" onchange="calcularInteres()">
                                <option>Seleccione el interes...</option>
                                @foreach( $interes as $int ) 
                                <option value="{{ $int->id }}">{{ $int->porcentaje }}</option>
                                @endforeach
                            </select>
                        
                        </div>
                        
                        <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                            <strong>Seleccione la Mora: </strong>
                            <select class="form-control m-b" name="account" id="mora_id">
                                <option>Seleccione una mora...</option>
                                @foreach( $mora as $mo ) 
                                <option value="{{ $mo->id }}">S/. {{ $mo->mora }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                        <strong>Total de Interes: </strong>
                        <input type="text" class="form-control" id="totalInteres" placeholder="Interes Total" readonly="readonly">
                        
                        </div>

                        <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                        <strong>Total de Prestamo: </strong>
                        <input type="text" class="form-control has-feedback-left" id="totalPrestamo" placeholder="Prestamo Total" readonly="readonly">
                        
                        </div>

                        <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                        <strong>Tipo de Préstamo: </strong>
                        <input type="text" class="form-control" id="tipoprestamo_id" value="Prestamo Prendario" readonly="readonly">
                        </div>

                    </div>
                    <button type="button" class="btn btn-primary btn-lg" onclick="generarPrestamo()">Generar Prestamo</button>
                    <button type="button" class="btn btn-danger btn-lg" onclick="cancelarPrestamo()">Cancelar Prestamo</button>
                </div>
                
            </div>


        </div>

    </div>

</div>
@endsection
@section('script')
    <script>
        function calcularInteres(){
            var monto = $("#montoPrestamo").val();
            var select = document.getElementById("interes_id");
            var interes = select.options[select.selectedIndex].text;

            var totalInteres = monto*(interes/100);
            $("#totalInteres").val(totalInteres);

            var montoTotal = parseInt(monto) + parseInt(totalInteres);
            $("#totalPrestamo").val(montoTotal);
        }

        function generarPrestamo(){
            var monto = $("#montoPrestamo").val();
            var fecinicio = $("#fecInicio").val();
            var fecfin = $("#fecFin").val();
            var total = $("#totalPrestamo").val();
            var cotizacion_id = $("#cotizacion_id").val();
            var tipocredito_interes_id = $("#interes_id").val();
            var mora_id = $("#mora_id").val();
            var intpagar = $("#totalInteres").val();
            
            $.post( "{{ Route('generarPrestamo') }}", {monto: monto, fecinicio: fecinicio, fecfin: fecfin, total: total, cotizacion_id: cotizacion_id, tipocredito_interes_id: tipocredito_interes_id, mora_id: mora_id, intpagar: intpagar, _token:'{{csrf_token()}}'}).done(function(data) {
                if (data.result = 1) {
                    $("#listCasillero").empty();
                    $("#listCasillero").html(data.view);
                    $("#areaNotificaciones").empty();
                    $("#areaNotificaciones").html(data.notificacion);
                    window.open('{{ Route('printContrato') }}', '_blank');
                    window.location="{{ Route('home') }}";    
                }else{
                    toastr.error('Evaluación muy baja', 'ERROR');
                }
                
            });
        }
    </script>
@endsection
