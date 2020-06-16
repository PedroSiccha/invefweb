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
                    <canvas id="grafBarCliente" width="800" height="300"></canvas>
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

<div class="wrapper wrapper-content animated fadeInRight">
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

                for (r = 0; r < numRecomendaciones; r++) {
                    conteoRecomendacion.push( asignaRecomendacion[r] );
                    nomRecomendacion.push( nombreRecomendacion[r] );
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
