@extends('layouts.app')
@section('pagina')
    Reportes
@endsection
@section('contenido')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Reportes</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">Inicio</a>
            </li>
            <li class="breadcrumb-item">
                <a>Marketing</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Reportes</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">
        
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Clientes por Mes</h5>
                    
                </div>
                <div class="ibox-content" id="">
                    <canvas id="grafBarCliente" width="800" height="300" hidden></canvas>
                    <canvas id="grafPieCliente" width="800" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Ocupaciones</h5>
                    
                </div>
                <div class="ibox-content" id="">
                    <canvas id="grafBarOcupacion" width="800" height="300"></canvas>
                    

                </div>
            </div>
        </div>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight" hidden>
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Recomendación</h5>
                    
                </div>
                <div class="ibox-content" id="">
                    <canvas id="grafBarRecomendacion" width="800" height="300"></canvas>
                    

                </div>
            </div>
        </div>
    </div>
</div>

<div class="tabs-container" hidden>
    <ul class="nav nav-tabs" role="tablist">
        <li><a class="nav-link active" data-toggle="tab" href="#cRecomendaciones"> Recomendaciones</a></li>
    </ul>
    <div class="tab-content">
        <div role="tabpanel" id="cRecomendaciones" class="tab-pane active">
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
                                                    <h5>Recomendaciones
                                                        <small>Cantidad de recomendaciones por día</small>
                                                    </h5>
                                                </div>
                                                
                                                <div class="ibox-content">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <select class="form-control m-b" name="anioRecomendacion" id="anioRecomendacion">
                                                                <option value="0">Seleccionar un Año...</option>
                                                                @foreach ($anio as $a)
                                                                    <option value="{{ $a->anio }}">{{ $a->anio }}</option>    
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <select class="form-control m-b" name="mesRecomendacion" id="mesRecomendacion" onchange="mostrarRecomendacion()">
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
                                                        <canvas id="canRecomendacionChart" height="100%"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="mcNuevo" class="tab-pane">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="ibox ">
                                                <div class="ibox-title">
                                                    <h5>Recomendación
                                                        <small>Cantidad de Recomendaciones al Mes</small>
                                                    </h5>
                                                </div>
                                                
                                                <div class="ibox-content">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <select class="form-control m-b" name="anioRecomendacionMes" id="anioRecomendacionMes" onchange="mostrarRecomendacionMes()">
                                                                <option value="0">Seleccionar un Año...</option>
                                                                @foreach ($anio as $a)
                                                                    <option value="{{ $a->anio }}">{{ $a->anio }}</option>    
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>Cantidad de recomendaciones por día
                                                    <div id="grafMes">
                                                        <canvas id="canRecomendacionMesChart" height="100%"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="acNuevo" class="tab-pane">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="ibox ">
                                                <div class="ibox-title">
                                                    <h5>Recomendacion
                                                        <small>Cantidad de Recomendacion por Año</small>
                                                    </h5>
                                                </div>
                                                
                                                <div class="ibox-content">
                                                    <div id="grafAnio">
                                                        <canvas id="canRecomendacionAnioChart" height="100%"></canvas>
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
    <script>
        $(document).ready(graficos);

        function graficos() {
            $.post( "{{ Route('graficoMarketing') }}", { _token:'{{csrf_token()}}'}).done(function(data) {
                var datos = jQuery.parseJSON(data);
                var cliActivo = datos.cliActivo;
                var cliInac = datos.cliInac;
                var canCliActivo = datos.canCliActivo;
                var canCliInActivo = datos.canCliInActuvi;
                var canOcupa = datos.cantidadOcupa;
                var cantOcupaciones = datos.ocupacion;
                var nombreOcupacion = datos.nomOcupacion;
                var asignaRecomendacion = datos.asignaRecomendacion;
                var numRecomendaciones = datos.numRecomendaciones;
                var nombreRecomendacion = datos.nombreRecomendacion;
                var i=0;
                var cantCliActivo = [];
                var cantCliInActivo = [];
                var CantOcupac = [];
                var nomOcupacion = [];
                var verRecomendacion = [];
                var conteoRecomendacion = [];
                var nomRecomendacion = [];
                
                for(i=1; i<=12; i++){
                    cantCliActivo.push( cliActivo[i] );
                    cantCliInActivo.push( cliInac[i] );
                }

                for (o = 0; o <= cantOcupaciones; o++) {
                    CantOcupac.push( canOcupa[o] );
                    nomOcupacion.push( nombreOcupacion[o] );

                }
                
                for (var id in asignaRecomendacion) {
                      if (asignaRecomendacion.hasOwnProperty(id)) {
                        conteoRecomendacion.push(asignaRecomendacion[id]);
                        nomRecomendacion.push(nombreRecomendacion[id]);
                      }
                    }

                new Chart(document.getElementById("grafBarCliente"), {
                    type: 'bar',
                    data: {
                        labels: ["ENERO", "FEBRERO", "MARZO", "ABRIL", "MAYO", "JUNIO", "JULIO", "AGOSTO", "SEPTIEMBRE", "OCTUBRE", "NOVIEMBRE", "DICIEMBRE"], //Cargar dias
                        datasets: [
                            { 
                                data: cantCliActivo, //Cantidad de Prestamos
                                label: "Clientes con Prestamos Activos",
                                borderColor: "#3e95cd",
                                backgroundColor: "#3e95cd"
                            },
                            {
                                data: cantCliInActivo, //Cantidad de Prestamos
                                label: "Clientes Sin Actividad",
                                borderColor: "#C72200",
                                backgroundColor: "#C72200"
                            }
                        ]
                    },
                    options: {
                        title: {
                        display: true,
                        text: 'Actividad de Clientes'
                        }
                    }
                });
                
                var datasetsRecomendacion = [];
                var borderColors = ["#3e95cd", "#C72200", "#FFA500", "#008000"];
                var backgroundColors = ["#3e95cd", "#C72200", "#FFA500", "#008000"];

                for (var i = 0; i < nomRecomendacion.length; i++) {
                    var dataset = {
                        data: [conteoRecomendacion[i]],
                        label: [nomRecomendacion[i]],
                        borderColor: borderColors[i % borderColors.length],
                        backgroundColor: backgroundColors[i % backgroundColors.length]
                    };
                
                    datasetsRecomendacion.push(dataset);
                }
                
                new Chart(document.getElementById("canRecomendacionAnioChart"), {
                    type: 'bar',
                    data: {
                        labels: [2019, 2020, 2021, 2022, 2023], //Cargar dias
                        datasets: datasetsRecomendacion
                    },
                    options: {
                        title: {
                        display: true,
                        text: 'Actividad de Clientes'
                        }
                    }
                });

                new Chart(document.getElementById("grafPieCliente"), {
                type: 'pie',
                data: {
                labels: ["Clientes Activos", "Clientes Inactivos"],
                datasets: [
                    {
                        label: "Population (millions)",
                        backgroundColor: ["#3e95cd", "#C72200"],
                        data: [canCliActivo,canCliInActivo]
                    }
                ]
                },
                    options: {
                        title: {
                            display: true,
                            text: 'Predicted world population (millions) in 2050'
                        }
                    }
                });

                new Chart(document.getElementById("grafBarOcupacion"), {
                    type: 'bar',
                    data: {
                        labels: nomOcupacion, //Cargar dias
                        datasets: [
                            { 
                                data: CantOcupac, //Cantidad de Prestamos
                                label: "Clientes con Prestamos Activos",
                                borderColor: "#3e95cd",
                                backgroundColor: "#3e95cd"
                            }
                        ]
                    },
                    options: {
                        title: {
                        display: true,
                        text: 'Actividad de Clientes'
                        }
                    }
                });

                new Chart(document.getElementById("grafBarRecomendacion"), {
                    type: 'bar',
                    data: {
                        labels: nomRecomendacion, //Cargar dias
                        datasets: [
                            { 
                                data: conteoRecomendacion, //Cantidad de Prestamos
                                label: "Clientes con Prestamos Activos",
                                borderColor: "#3e95cd",
                                backgroundColor: "#3e95cd"
                            }
                        ]
                    },
                    options: {
                        title: {
                        display: true,
                        text: 'Actividad de Clientes'
                        }
                    }
                });
            });
            
        }
    </script>
@endsection
