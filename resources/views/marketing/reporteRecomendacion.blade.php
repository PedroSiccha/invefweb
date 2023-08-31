@extends('layouts.app')
@section('pagina')
    Reportes de Recomendación
@endsection
@section('contenido')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Lista de Recomendaciones</h5>
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
            <div class="ibox-content" id="recomendacion">
                <div class="panel-body">
                    <div class="panel-group" id="accordion">
                        @foreach ($recomendacion as $r)
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h5 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $r->id }}" onclick="mostrarRecomendacion('{{ $r->id }}')">{{ $r->recomendacion }}</a>
                                    </h5>
                                </div>
                                <div id="collapse{{ $r->id }}" class="panel-collapse collapse in">
                                    <div class="panel-body" id="divMostrarRecomendacion_{{ $r->id }}">
                                        {{ $r->id }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Comparativa de Recomendaciones</h5>
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
            <div class="ibox-content" id="divCompRecomendaciones">
                <div class="panel-body">
                    <div class="panel-group" id="accordion">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h5 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseCompRecomendaciones">Comparativa de Recomendaciones</a>
                                    </h5>
                                </div>
                                <div id="collapseCompRecomendaciones" class="panel-collapse collapse in">
                                    <div class="panel-body" id="">
                                        <div class="panel-body">
                                            <div class="tabs-container">
                                                <div class="col-lg-12">
                                                    <div class="tabs-left">
                                                        <ul class="nav nav-tabs col-lg-3">
                                                            <li><a class="nav-link active" data-toggle="tab" href="#dcCompNuevo"> Dia</a></li>
                                                            <li><a class="nav-link" data-toggle="tab" href="#mcCompNuevo"> Mes</a></li>
                                                            <li><a class="nav-link" data-toggle="tab" href="#acCompNuevo"> Año</a></li>
                                                        </ul>
                                                        <div class="tab-content ">
                                                            <div id="dcCompNuevo" class="tab-pane active">
                                                                <div class="panel-body">
                                                                    <div class="row">
                                                                        <div class="col-lg-12">
                                                                            <div class="ibox "> 
                                                                                <div class="ibox-title">
                                                                                    <h5>Comparativo de Recomendaciones
                                                                                        <small>Cantidad de comparativa de recomendaciones por día</small>
                                                                                    </h5>
                                                                                </div>
                                                                                
                                                                                <div class="ibox-content">
                                                                                    <!-- Cantidad de comparativa de recomendaciones por día -->
                                                                                    <div class="row">
                                                                                        <div class="col-lg-6">
                                                                                            <select class="form-control m-b" name="anioCompRecomendaciones" id="anioCompRecomendaciones">
                                                                                                <option value="0">Seleccionar un Año...</option>
                                                                                                @foreach ($anio as $a)
                                                                                                    <option value="{{ $a->anio }}">{{ $a->anio }}</option>    
                                                                                                @endforeach
                                                                                            </select>
                                                                                        </div>
                                                                                        <div class="col-lg-6">
                                                                                            <select class="form-control m-b" name="mesCompRecomendaciones" id="mesCompRecomendaciones" onchange="mostrarCompRecomendaciones()">
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
                                                                                    
                                                                                    <div id="grafDiaComp">
                                                                                        <canvas id="canCompRecomendacionesChart" height="100%"></canvas>
                                                                                    </div>
                                                                                    <!-- Fin Cantidad de comparativa de recomendaciones por día -->
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div id="mcCompNuevo" class="tab-pane">
                                                                <div class="panel-body">
                                                                    <div class="row">
                                                                        <!-- Cantidad de comparativa de recomendaciones por Mes -->
                                                                        <div class="col-lg-12">
                                                                            <div class="ibox ">
                                                                                <div class="ibox-title">
                                                                                    <h5>Comparativa de recomendaciones
                                                                                        <small>Cantidad de comparativa de recomendaciones al Mes</small>
                                                                                    </h5>
                                                                                </div>
                                                                                
                                                                                <div class="ibox-content">
                                                                                    <div class="row">
                                                                                        <div class="col-lg-12">
                                                                                            <select class="form-control m-b" name="anioCompRecomendacionesMes" id="anioCompRecomendacionesMes" onchange="mostrarCompRecomendacionesMes()">
                                                                                                <option value="0">Seleccionar un Año...</option>
                                                                                                @foreach ($anio as $a)
                                                                                                    <option value="{{ $a->anio }}">{{ $a->anio }}</option>    
                                                                                                @endforeach
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div id="grafMesComp">
                                                                                        <canvas id="canCompRecomendacionesMesChart" height="100%"></canvas>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <!-- Fin Cantidad de comparativa de recomendaciones por mes -->
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div id="acCompNuevo" class="tab-pane">
                                                                <div class="panel-body">
                                                                    <div class="row">
                                                                        <!-- Cantidad de comparativa de recomendaciones por año -->
                                                                        <div class="col-lg-12">
                                                                            <div class="ibox ">
                                                                                <div class="ibox-title">
                                                                                    <h5>Comparativa de recomendaciones
                                                                                        <small>Cantidad de comparativa de recomendaciones por Año</small>
                                                                                    </h5>
                                                                                </div>
                                                                                
                                                                                <div class="ibox-content">
                                                                                    <div id="grafAnioComp">
                                                                                        <canvas id="canCompRecomendacionesAnioChart" height="100%"></canvas>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <!-- Fin Cantidad de comparativa de recomendaciones por año -->
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
    
    <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Lista de Recomendaciones General</h5>
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
            <div class="ibox-content" id="recomendacionGeneral">
                <div class="panel-body">
                    <div class="panel-group" id="accordion">
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
        </div>
    </div>
    
</div>
@endsection
@section('script')
    <script src="js/plugins/chartJs/Chart.min.js"></script>
    <script>
        $(document).ready(graficos);
        
        function graficos() {
            $.post( "{{ Route('graficoMarketingRecomendaciones') }}", { _token:'{{csrf_token()}}'}).done(function(data) {
                var datos = jQuery.parseJSON(data);
                var asignaRecomendacion = datos.asignaRecomendacion;
                var numRecomendaciones = datos.numRecomendaciones;
                var nombreRecomendacion = datos.nombreRecomendacion;
                var i=0;
                var verRecomendacion = [];
                var conteoRecomendacion = [];
                var conteoGeneralRecomendacion = [];
                var nomRecomendacion = [];
                
                for (var id in asignaRecomendacion) {
                  if (asignaRecomendacion.hasOwnProperty(id)) {
                    conteoRecomendacion.push(asignaRecomendacion[id]);
                    nomRecomendacion.push(nombreRecomendacion[id]);
                  }
                }
                
                console.log(asignaRecomendacion);
                
                var datasetsRecomendacion = [];
                var borderColors = ["#3e95cd", "#C72200", "#FFA500", "#008000", "#CD5C5C", "#DAF7A6", "#FF5733", "#C70039", "#900C3F"];
                var backgroundColors = ["#3e95cd", "#C72200", "#FFA500", "#008000", "#CD5C5C", "#DAF7A6", "#FF5733", "#C70039", "#900C3F"];

                for (var i = 0; i < nomRecomendacion.length; i++) {
                    var dataset = {
                        data: Object.values(conteoRecomendacion[i]),
                        label: [nomRecomendacion[i]],
                        borderColor: borderColors[i % borderColors.length],
                        backgroundColor: backgroundColors[i % backgroundColors.length]
                    };
                
                    datasetsRecomendacion.push(dataset);
                }
                
                const labels = Object.keys(conteoRecomendacion[0]);
                
                const data1 = {
                  labels: labels,
                  datasets: datasetsRecomendacion
                };
                
                //Bloque grafica anual
                var asignaRecomendacionAnio = datos.asignaRecomendacionAnio;
                var numRecomendacionesAnio = datos.numRecomendacionesAnio;
                var nombreRecomendacionAnio = datos.nombreRecomendacionAnio;
                
                var verRecomendacionAnio = [];
                var conteoRecomendacionAnio = [];
                var nomRecomendacionAnio = [];
                
                for (var id in asignaRecomendacionAnio) {
                      if (asignaRecomendacionAnio.hasOwnProperty(id)) {
                        conteoRecomendacionAnio.push(asignaRecomendacionAnio[id]);
                        nomRecomendacionAnio.push(nombreRecomendacionAnio[id]);
                      }
                    }
                
                var datasetsRecomendacionAnio = [];
                var borderColors = ["#3e95cd", "#FFA500", "#008000", "#C72200", "#CD5C5C", "#DAF7A6", "#FF5733", "#C70039", "#900C3F"];
                var backgroundColors = ["#3e95cd", "#FFA500", "#008000", "#C72200", "#CD5C5C", "#DAF7A6", "#FF5733", "#C70039", "#900C3F"];

                for (var i = 0; i < nomRecomendacionAnio.length; i++) {
                    var dataset = {
                        data: [conteoRecomendacionAnio[i]],
                        label: [nomRecomendacionAnio[i]],
                        borderColor: borderColors[i % borderColors.length],
                        backgroundColor: backgroundColors[i % backgroundColors.length]
                    };
                
                    datasetsRecomendacionAnio.push(dataset);
                }
                
                
                new Chart(document.getElementById("grafBarRecomendacion"), {
                    type: 'bar',
                    data: {
                        labels: [2023], //Cargar dias
                        datasets: datasetsRecomendacionAnio
                    },
                    options: {
                        title: {
                        display: true,
                        text: 'Actividad de Clientes'
                        }
                    }
                });
                
                //FIN Bloque grafica anual
                
                
                console.log(data1);
                
                new Chart(document.getElementById("canCompRecomendacionesAnioChart"), {
                    type: 'bar',
                    data: data1,
                    options: {
                        title: {
                        display: true,
                        text: 'Comparativa de Recomendaciones por Año'
                        }
                    },
                });
            });
        }
        
        function mostrarCompRecomendaciones() {
            var anio = $('#anioCompRecomendaciones').val();
            var mes = $('#mesCompRecomendaciones').val();
            
            if (anio == 0) {
                toastr.error("Primero Seleccione el AÑO para continuar");
            }else{
                $.post( "{{ Route('graficoMarketingRecomendacionesDias') }}", {anio: anio, mes: mes, _token:'{{csrf_token()}}'}).done(function(data) {
                    
                    var datos = jQuery.parseJSON(data);
                    console.log("DATOS DIA", datos);
                    
                    var asignaRecomendacion = datos.asignaRecomendacion;
                    var numRecomendaciones = datos.numRecomendaciones;
                    var nombreRecomendacion = datos.nombreRecomendacion;
                    var i=0;
                    var verRecomendacion = [];
                    var conteoRecomendacion = [];
                    var nomRecomendacion = [];
                    
                    for (var id in asignaRecomendacion) {
                      if (asignaRecomendacion.hasOwnProperty(id)) {
                        conteoRecomendacion.push(asignaRecomendacion[id]);
                        nomRecomendacion.push(nombreRecomendacion[id]);
                      }
                    }
                    
                    var datasetsRecomendacion = [];
                    var borderColors = ["#3e95cd", "#C72200", "#FFA500", "#008000", "#CD5C5C", "#DAF7A6", "#FF5733", "#C70039", "#900C3F"];
                    var backgroundColors = ["#3e95cd", "#C72200", "#FFA500", "#008000", "#CD5C5C", "#DAF7A6", "#FF5733", "#C70039", "#900C3F"];
    
                    for (var i = 0; i < nomRecomendacion.length; i++) {
                        var dataset = {
                            data: Object.values(conteoRecomendacion[i]),
                            label: [nomRecomendacion[i]],
                            borderColor: borderColors[i % borderColors.length],
                            backgroundColor: backgroundColors[i % backgroundColors.length]
                        };
                    
                        datasetsRecomendacion.push(dataset);
                    }
                    
                    const labels = Object.keys(conteoRecomendacion[0]);
                
                    const data1 = {
                      labels: labels,
                      datasets: datasetsRecomendacion
                    };
                    
                    var divGrafDia = document.getElementById('grafDiaComp');
                    divGrafDia.innerHTML = '<canvas id="canCompRecomendacionesChart" height="100%"></canvas>';
    
                    new Chart(document.getElementById("canCompRecomendacionesChart"), {
                        type: 'bar',
                        data: data1,
                        options: {
                            title: {
                            display: true,
                            text: 'Balance Mensual de Recomendaciones'
                            }
                        }
                    });
    
                });
            }
        };
        
        function mostrarCompRecomendacionesMes() {
            var anio = $('#anioCompRecomendacionesMes').val();
            
                $.post( "{{ Route('graficoMarketingRecomendacionMes') }}", {anio: anio, _token:'{{csrf_token()}}'}).done(function(data) {
    
                    var datos = jQuery.parseJSON(data);
                    console.log("DATOS MES", datos);
                    
                    var asignaRecomendacion = datos.asignaRecomendacion;
                    var numRecomendaciones = datos.numRecomendaciones;
                    var nombreRecomendacion = datos.nombreRecomendacion;
                    var i=0;
                    var verRecomendacion = [];
                    var conteoRecomendacion = [];
                    var nomRecomendacion = [];
                    
                    for (var id in asignaRecomendacion) {
                      if (asignaRecomendacion.hasOwnProperty(id)) {
                        conteoRecomendacion.push(asignaRecomendacion[id]);
                        nomRecomendacion.push(nombreRecomendacion[id]);
                      }
                    }
                    
                    var datasetsRecomendacion = [];
                    var borderColors = ["#3e95cd", "#C72200", "#FFA500", "#008000", "#CD5C5C", "#DAF7A6", "#FF5733", "#C70039", "#900C3F"];
                    var backgroundColors = ["#3e95cd", "#C72200", "#FFA500", "#008000", "#CD5C5C", "#DAF7A6", "#FF5733", "#C70039", "#900C3F"];
    
                    for (var i = 0; i < nomRecomendacion.length; i++) {
                        var dataset = {
                            data: Object.values(conteoRecomendacion[i]),
                            label: [nomRecomendacion[i]],
                            borderColor: borderColors[i % borderColors.length],
                            backgroundColor: backgroundColors[i % backgroundColors.length]
                        };
                    
                        datasetsRecomendacion.push(dataset);
                    }
                    
                    const labels = ["ENERO", "FEBRERO", "MARZO", "ABRIL", "MAYO", "JUNIO", "JULIO", "AGOSTO", "SETIEMBRE", "OCTUBRE", "NOVIEMBRE", "DICIEMBRE"];
                
                    const data1 = {
                      labels: labels,
                      datasets: datasetsRecomendacion
                    };
                    
                    var divGrafMes = document.getElementById('grafMesComp');
                    divGrafMes.innerHTML = '<canvas id="canCompRecomendacionesMesChart" height="100%"></canvas>';
    
                    new Chart(document.getElementById("canCompRecomendacionesMesChart"), {
                        type: 'bar',
                        data: data1,
                        options: {
                            title: {
                            display: true,
                            text: 'Balance Mensual de Recomendaciones'
                            }
                        }
                    });
    
                });
        }
        
        function mostrarRecomendacion(recomendacion_id) {
            this.graficoRecomendacionAnual('recomendacion_id');
            $.post( "{{ Route('mostrarRecomendacion') }}", {recomendacion_id: recomendacion_id, _token:'{{csrf_token()}}'}).done(function(data) {
                    $("#divMostrarRecomendacion_"+recomendacion_id).empty();
                    $("#divMostrarRecomendacion_"+recomendacion_id).html(data.view);
                });
        }
        
        function graficoRecomendacionAnual(idRecomendacion) {
            $.post( "{{ Route('graficoLineaRecomendacionAnual') }}", {idRecomendacion: idRecomendacion, _token:'{{csrf_token()}}'}).done(function(data) {
                var datos = jQuery.parseJSON(data);
                console.log(datos);
                
                var divGrafAnio = document.getElementById('grafAnio-'+idRecomendacion);
                divGrafAnio.innerHTML = '<canvas id="canClienteNuevoAnioChart-'+idRecomendacion+'" height="100%"></canvas>';
                
                new Chart(document.getElementById("canClienteNuevoAnioChart-"+idRecomendacion), {
                    type: 'bar',
                    data: {
                        labels: [2019, 2020, 2021, 2022, 2023], //Cargar dias
                        datasets: [{ 
                            data: [ ], //Cantidad de Prestamos
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
            });
        }
        
        function mostrarRecomendacionDia(idRecomendacion) {
            var anio = $('#anioRecomendacion').val();
            var mes = $('#mesRecomendacion').val();
            /*
            if (anio == 0) {
                toastr.error("Primero Seleccione el AÑO para continuar");
            }else{*/
                $.post( "{{ Route('graficoLineaRecomendacion') }}", {anio: anio, mes: mes, idRecomendacion: idRecomendacion, _token:'{{csrf_token()}}'}).done(function(data) {
                    
                    var datos = jQuery.parseJSON(data);
                    var totaldias = datos.totaldias;
                    var registrosdia = datos.registrosdia;
                    var i=0;
                    var dias = [];
                    var cantRecomendacion = [];
                    for(i=1; i<=totaldias; i++){
                        dias.push(i); 
                        cantRecomendacion.push( registrosdia[i] );
                    }
                    
                    var divGrafDia = document.getElementById('grafDia-'+idRecomendacion);
                    divGrafDia.innerHTML = '<canvas id="canRecomendacionChart-'+idRecomendacion+'" height="100%"></canvas>';
    
                    new Chart(document.getElementById("canRecomendacionChart-"+idRecomendacion), {
                        type: 'bar',
                        data: {
                            labels: dias, //Cargar dias
                            datasets: [{ 
                                data: cantRecomendacion, //Cantidad de Recomendacion
                                label: "Cantidad de Recomendaciones",
                                borderColor: "#3e95cd",
                                backgroundColor: "#3e95cd"
                            }]
                        },
                        options: {
                            title: {
                            display: true,
                            text: 'Balance Mensual de Recomendaciones'
                            }
                        }
                    });
    
                });
            //}
        };
        
        function mostrarRecomendacionMes(idRecomendacion) {
            var anio = $('#anioRecomendacionMes').val();
            
                $.post( "{{ Route('graficoLineaRecomendacionMes') }}", {anio: anio, idRecomendacion: idRecomendacion, _token:'{{csrf_token()}}'}).done(function(data) {
    
                    var datos = jQuery.parseJSON(data);
                    var registrosmes = datos.registrosmes;
                    var i=0;
                    var cantRecomendacion = [];
                    for(i=1; i<=12; i++){
                        cantRecomendacion.push( registrosmes[i] );
                    }
                    
                    var divGrafMes = document.getElementById('grafMes-'+idRecomendacion);
                    divGrafMes.innerHTML = '<canvas id="canRecomendacionMesChart-'+idRecomendacion+'" height="100%"></canvas>';
    
                    new Chart(document.getElementById("canRecomendacionMesChart-"+idRecomendacion), {
                        type: 'bar',
                        data: {
                            labels: ["ENERO", "FEBRERO", "MARZO", "ABRIL", "MAYO", "JUNIO", "JULIO", "AGOSTO", "SEPTIEMBRE", "OCTUBRE", "NOVIEMBRE", "DICIEMBRE"], //Cargar dias
                            datasets: [{ 
                                data: cantRecomendacion, //Cantidad de Prestamos
                                label: "Cantidad de Recomendaciones",
                                borderColor: "#3e95cd",
                                backgroundColor: "#3e95cd"
                            }]
                        },
                        options: {
                            title: {
                            display: true,
                            text: 'Balance Mensual de Recomendaciones'
                            }
                        }
                    });
    
                });
        }
        
    </script>
@endsection