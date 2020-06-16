@extends('layouts.app')
@section('pagina')
    Flujo de Caja
@endsection
@section('contenido')
<div class="tabs-container">
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
                                                    <h5>Caja
                                                        <small>Control de Flujo de Caja</small>
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
                                                            <select class="form-control m-b" name="mesPrestamo" id="mesPrestamo" onchange="mostrarFlujoCaja()">
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
                                                        <canvas id="montoFlujoCajaDiaChart" height="100%"></canvas>
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
                                                            <select class="form-control m-b" name="anioPrestamoMes" id="anioPrestamoMes" onchange="mostrarFlujoCajaMes()">
                                                                <option value="0">Seleccionar un Año...</option>
                                                                @foreach ($anio as $a)
                                                                    <option value="{{ $a->anio }}">{{ $a->anio }}</option>    
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    
                                                    <div>
                                                        <canvas id="canFlujoCajaMesChart" height="100%"></canvas>
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
                                                        <canvas id="canFlujoCajaAnioChart" height="100%"></canvas>
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
    </div>


</div>
@endsection
@section('script')
    <script>
        $(document).ready(graficoAnual);

        function graficoAnual() {
            $.post( "{{ Route('graficoFlujoCajaAnual') }}", { _token:'{{csrf_token()}}'}).done(function(data) {
                var datos = jQuery.parseJSON(data);
                var totalanios = datos.totalanio;
                var numanio = datos.numanio;
                var egreso = datos.egreso;
                var ingreso = datos.ingreso;
                var anio = [];
                var montoEgreso = [];
                var montoIngreso = [];
                for(i=0; i<totalanios; i++){
                    anio.push( numanio[i] );
                    montoEgreso.push( egreso[i] );
                    montoIngreso.push( ingreso[i] );
                }

                new Chart(document.getElementById("canFlujoCajaAnioChart"), {
                    type: 'line',
                    data: {
                        labels: anio, //Cargar dias
                        datasets: [
                            { 
                                data: montoIngreso, //Cantidad de Prestamos
                                label: "Monto de Ingreso",
                                borderColor: "#3e95cd"
                            },
                            {
                                data: montoEgreso, //Cantidad de Prestamos
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
            });
        }


        function mostrarFlujoCaja() {
            var anio = $('#anioPrestamo').val();
            var mes = $('#mesPrestamo').val();

            if (anio == 0) {
                toastr.error("Primero Seleccione el AÑO para continuar");
            }else{
                $.post( "{{ Route('graficoLineaFlujoCaja') }}", {anio: anio, mes: mes, _token:'{{csrf_token()}}'}).done(function(data) {

                    
                    var datos = jQuery.parseJSON(data);
                    var totaldias = datos.totaldias;
                    var egreso = datos.registroEgreso;
                    var ingreso = datos.registroIngreso;
                    var i=0;
                    var dias = [];
                    var montoEgreso = [];
                    var montoIngreso = [];
                    for(i=1; i<=totaldias; i++){
                        dias.push(i);
                        montoEgreso.push( egreso[i] );
                        montoIngreso.push( ingreso[i] );
                    }

                    new Chart(document.getElementById("montoFlujoCajaDiaChart"), {
                        type: 'line',
                        data: {
                            labels: dias, //Cargar dias
                            datasets: [
                                { 
                                data: montoEgreso, //Cantidad de Prestamos
                                label: "Monto de Egreso",
                                borderColor: "#C72200"
                                },
                                {
                                    data: montoIngreso, //Cantidad de Prestamos
                                    label: "Monto de Ingreso",
                                    borderColor: "#3e95cd"
                                }
                            ]
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
        }

        function mostrarFlujoCajaMes() {
        
        var anio = $('#anioPrestamoMes').val();
        
            $.post( "{{ Route('graficoLineaFlujoCajaMes') }}", {anio: anio, _token:'{{csrf_token()}}'}).done(function(data) {
                
                var datos = jQuery.parseJSON(data);
                var registrosmes = datos.registrosmes;
                var egreso = datos.registroEgreso;
                var ingreso = datos.registroIngreso;
                var i=0;
                var montoEgreso = [];
                var montoIngreso = [];
                for(i=1; i<=12; i++){
                    montoEgreso.push( egreso[i] );
                    montoIngreso.push( ingreso[i] );
                }

                new Chart(document.getElementById("canFlujoCajaMesChart"), {
                    type: 'line',
                    data: {
                        labels: ["ENERO", "FEBRERO", "MARZO", "ABRIL", "MAYO", "JUNIO", "JULIO", "AGOSTO", "SEPTIEMBRE", "OCTUBRE", "NOVIEMBRE", "DICIEMBRE"], //Cargar dias
                        datasets: [
                            { 
                                data: montoIngreso, //Cantidad de Prestamos
                                label: "Monto de Ingreso Mensual",
                                borderColor: "#3e95cd"
                            },
                            {
                                data: montoEgreso, //Cantidad de Prestamos
                                label: "Monto de Egreso Mensual",
                                borderColor: "#C72200"
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
