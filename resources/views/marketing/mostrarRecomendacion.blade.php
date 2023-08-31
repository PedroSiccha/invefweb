<div class="tabs-container">
    <ul class="nav nav-tabs" role="tablist">
        <li><a class="nav-link active" data-toggle="tab" href="#cNuevo"> Recomendacion</a></li>
    </ul>
    <div class="tab-content">
        <div role="tabpanel" id="cNuevo" class="tab-pane active">
            <div class="panel-body">
                <div class="tabs-container">
                    <div class="col-lg-12">
                    <div class="tabs-left">
                        <ul class="nav nav-tabs">
                            <li><a class="nav-link active" data-toggle="tab" href="#dcNuevo_{{ $idRecomendacion }}"> Dia</a></li>
                            <li><a class="nav-link" data-toggle="tab" href="#mcNuevo_{{ $idRecomendacion }}"> Mes</a></li>
                        </ul>
                        <div class="tab-content ">
                            <div id="dcNuevo_{{ $idRecomendacion }}" class="tab-pane active">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="ibox "> 
                                                <div class="ibox-title">
                                                    <h5>Recomendacion
                                                        <small>Cantidad de recomendacion por día</small>
                                                    </h5>
                                                </div>
                                                
                                                <div class="ibox-content">
                                                    <!-- Cantidad de Recomendacion por día -->
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
                                                            <select class="form-control m-b" name="mesRecomendacion" id="mesRecomendacion" onchange="mostrarRecomendacionDia('{{ $idRecomendacion }}')">
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
                                                    
                                                    <div id="grafDia-{{ $idRecomendacion }}">
                                                        <canvas id="canRecomendacionChart-{{ $idRecomendacion }}" height="100%"></canvas>
                                                    </div>
                                                    <!-- Fin Cantidad de Recomendacion por día -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="mcNuevo_{{ $idRecomendacion }}" class="tab-pane">
                                <div class="panel-body">
                                    <div class="row">
                                        <!-- Cantidad de Recomendacion por Mes -->
                                        <div class="col-lg-12">
                                            <div class="ibox ">
                                                <div class="ibox-title">
                                                    <h5>Recomendacion
                                                        <small>Cantidad de Recomendacion al Mes</small>
                                                    </h5>
                                                </div>
                                                
                                                <div class="ibox-content">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <select class="form-control m-b" name="anioRecomendacionMes" id="anioRecomendacionMes" onchange="mostrarRecomendacionMes('{{ $idRecomendacion }}')">
                                                                <option value="0">Seleccionar un Año...</option>
                                                                @foreach ($anio as $a)
                                                                    <option value="{{ $a->anio }}">{{ $a->anio }}</option>    
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div id="grafMes-{{ $idRecomendacion }}">
                                                        <canvas id="canRecomendacionMesChart-{{ $idRecomendacion }}" height="100%"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Fin Cantidad de Recomendacion por mes -->
                                    </div>
                                </div>
                            </div>
                            <div id="acNuevo_{{ $idRecomendacion }}" class="tab-pane">
                                <div class="panel-body">
                                    <div class="row">
                                        <!-- Cantidad de Recomendacion por año -->
                                        <div class="col-lg-12">
                                            <div class="ibox ">
                                                <div class="ibox-title">
                                                    <h5>Recomendacion
                                                        <small>Cantidad de Recomendacion por Año</small>
                                                    </h5>
                                                </div>
                                                
                                                <div class="ibox-content">
                                                    <div id="grafAnio-{{ $idRecomendacion }}">
                                                        <canvas id="canRecomendacionAnioChart-{{ $idRecomendacion }}" height="100%"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Fin Cantidad de Recomendacion por año -->
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