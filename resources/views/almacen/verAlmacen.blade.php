<div class="ibox-content" id="almacen">
    <div class="panel-body">
        <div class="panel-group" id="accordion">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h5 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">{{ $almacen[0]->nombre }} - {{ $almacen[0]->direccion }}</a>
                    </h5>
                </div>
                <div id="collapseOne" class="panel-collapse collapse in">
                    <div class="panel-body">
                        <div class="row">

                            <div class="ibox col-md-6">
                                <div class="ibox-title">
                                    <h5>{{ $stand[0]->nombre }}</h5>
                                    <div class="ibox-tools">
                                        <a class="close-link">
                                            <i class="fa fa-times"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="ibox-content" id="divTipoPrestamo">
                                    <div class="row">
                                        @foreach ($casillero1 as $ca)
                                        <?php if($ca->estado == "LIBRE"){ $est = "navy-bg"; $modal = ""; }elseif ($ca->estado == "RECOGER") {$est = "yellow-bg"; $modal = $ca->prestamo_id; }else{ $est = "red-bg";  }?>
                                        <div class="col-md-4"  onclick="verRecoger('{{ $modal }}')">
                                            <div class="widget style1 {{ $est }}"  data-toggle="tooltip" data-placement="top" title="Cod. Prestamo: {{ $ca->prestamo_id }}, Total de Prestamo: {{ $ca->total }}, Garantia: {{ $ca->garantia }} ">
                                                <div class="row">
                                                    <div class="col-4">
                                                        <i class="fa fa-archive fa-3x"></i>
                                                    </div>
                                                    <div class="col-8 text-right">
                                                        <h2 class="font-bold"> {{ $ca->nombre }} </h2>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>    
                                        @endforeach
                                    </div>
                                </div>
                            </div>
        
                            <div class="ibox col-md-6">
                                <div class="ibox-title">
                                    <h5>{{ $stand[1]->nombre }}</h5>
                                    <div class="ibox-tools">
                                        <a class="close-link">
                                            <i class="fa fa-times"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="ibox-content" id="divTipoPrestamo">
                                    <div class="row">
                                        @foreach ($casillero2 as $ca)
                                        <?php if($ca->estado == "LIBRE"){ $est = "navy-bg"; $modal = ""; }elseif ($ca->estado == "RECOGER") {$est = "yellow-bg"; $modal = $ca->prestamo_id; }else{ $est = "red-bg";  }?>
                                        <div class="col-md-4"  onclick="verRecoger('{{ $modal }}')">
                                            <div class="widget style1 {{ $est }}"  data-toggle="tooltip" data-placement="top" title="Cod. Prestamo: {{ $ca->prestamo_id }}, Total de Prestamo: {{ $ca->total }}, Garantia: {{ $ca->garantia }} ">
                                                <div class="row">
                                                    <div class="col-4">
                                                        <i class="fa fa-archive fa-3x"></i>
                                                    </div>
                                                    <div class="col-8 text-right">
                                                        <h2 class="font-bold"> {{ $ca->nombre }} </h2>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>    
                                        @endforeach
                                    </div>
                                </div>
                            </div>
        
                            <div class="ibox col-md-6">
                                <div class="ibox-title">
                                    <h5>{{ $stand[2]->nombre }}</h5>
                                    <div class="ibox-tools">
                                        <a class="close-link">
                                            <i class="fa fa-times"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="ibox-content" id="divTipoPrestamo">
                                    <div class="row">
                                        @foreach ($casillero3 as $ca)
                                        <?php if($ca->estado == "LIBRE"){ $est = "navy-bg"; $modal = ""; }elseif ($ca->estado == "RECOGER") {$est = "yellow-bg"; $modal = $ca->prestamo_id; }else{ $est = "red-bg";  }?>
                                        <div class="col-md-4"  onclick="verRecoger('{{ $modal }}')">
                                            <div class="widget style1 {{ $est }}"  data-toggle="tooltip" data-placement="top" title="Cod. Prestamo: {{ $ca->prestamo_id }}, Total de Prestamo: {{ $ca->total }}, Garantia: {{ $ca->garantia }} ">
                                                <div class="row">
                                                    <div class="col-4">
                                                        <i class="fa fa-archive fa-3x"></i>
                                                    </div>
                                                    <div class="col-8 text-right">
                                                        <h2 class="font-bold"> {{ $ca->nombre }} </h2>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>    
                                        @endforeach
                                    </div>
                                </div>
                            </div>
        
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">{{ $almacen[1]->nombre }} - {{ $almacen[1]->direccion }}</a>
                    </h4>
                </div>
                <div id="collapseTwo" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div class="row">

                            <div class="ibox col-md-6">
                                <div class="ibox-title">
                                    <h5>{{ $stand[3]->nombre }}</h5>
                                    <div class="ibox-tools">
                                        <a class="close-link">
                                            <i class="fa fa-times"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="ibox-content" id="divTipoPrestamo">
                                    <div class="row">
                                        @foreach ($casillero4 as $ca)
                                        <?php if($ca->estado == "LIBRE"){ $est = "navy-bg"; $modal = ""; }elseif ($ca->estado == "RECOGER") {$est = "yellow-bg"; $modal = $ca->prestamo_id; }else{ $est = "red-bg";  }?>
                                        <div class="col-md-4"  onclick="verRecoger('{{ $modal }}')">
                                            <div class="widget style1 {{ $est }}"  data-toggle="tooltip" data-placement="top" title="Cod. Prestamo: {{ $ca->prestamo_id }}, Total de Prestamo: {{ $ca->total }}, Garantia: {{ $ca->garantia }} ">
                                                <div class="row">
                                                    <div class="col-4">
                                                        <i class="fa fa-archive fa-3x"></i>
                                                    </div>
                                                    <div class="col-8 text-right">
                                                        <h2 class="font-bold"> {{ $ca->nombre }} </h2>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>    
                                        @endforeach
                                    </div>
                                </div>
                            </div>
        
                            <div class="ibox col-md-6">
                                <div class="ibox-title">
                                    <h5>{{ $stand[4]->nombre }}</h5>
                                    <div class="ibox-tools">
                                        <a class="close-link">
                                            <i class="fa fa-times"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="ibox-content" id="divTipoPrestamo">
                                    <div class="row">
                                        @foreach ($casillero5 as $ca)
                                        <?php if($ca->estado == "LIBRE"){ $est = "navy-bg"; $modal = ""; }elseif ($ca->estado == "RECOGER") {$est = "yellow-bg"; $modal = $ca->prestamo_id; }else{ $est = "red-bg";  }?>
                                        <div class="col-md-4"  onclick="verRecoger('{{ $modal }}')">
                                            <div class="widget style1 {{ $est }}"  data-toggle="tooltip" data-placement="top" title="Cod. Prestamo: {{ $ca->prestamo_id }}, Total de Prestamo: {{ $ca->total }}, Garantia: {{ $ca->garantia }} ">
                                                <div class="row">
                                                    <div class="col-4">
                                                        <i class="fa fa-archive fa-3x"></i>
                                                    </div>
                                                    <div class="col-8 text-right">
                                                        <h2 class="font-bold"> {{ $ca->nombre }} </h2>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>    
                                        @endforeach
                                    </div>
                                </div>
                            </div>
        
                            <div class="ibox col-md-6">
                                <div class="ibox-title">
                                    <h5>{{ $stand[5]->nombre }}</h5>
                                    <div class="ibox-tools">
                                        <a class="close-link">
                                            <i class="fa fa-times"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="ibox-content" id="divTipoPrestamo">
                                    <div class="row">
                                        @foreach ($casillero6 as $ca)
                                        <?php if($ca->estado == "LIBRE"){ $est = "navy-bg"; $modal = ""; }elseif ($ca->estado == "RECOGER") {$est = "yellow-bg"; $modal = $ca->prestamo_id; }else{ $est = "red-bg";  }?>
                                        <div class="col-md-4"  onclick="verRecoger('{{ $modal }}')">
                                            <div class="widget style1 {{ $est }}"  data-toggle="tooltip" data-placement="top" title="Cod. Prestamo: {{ $ca->prestamo_id }}, Total de Prestamo: {{ $ca->total }}, Garantia: {{ $ca->garantia }} ">
                                                <div class="row">
                                                    <div class="col-4">
                                                        <i class="fa fa-archive fa-3x"></i>
                                                    </div>
                                                    <div class="col-8 text-right">
                                                        <h2 class="font-bold"> {{ $ca->nombre }} </h2>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>    
                                        @endforeach
                                    </div>
                                </div>
                            </div>
        
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">{{ $almacen[2]->nombre }} - {{ $almacen[2]->direccion }}</a>
                    </h4>
                </div>
                <div id="collapseThree" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div class="row">

                            <div class="ibox col-md-6">
                                <div class="ibox-title">
                                    <h5>{{ $stand[6]->nombre }}</h5>
                                    <div class="ibox-tools">
                                        <a class="close-link">
                                            <i class="fa fa-times"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="ibox-content" id="divTipoPrestamo">
                                    <div class="row">
                                        @foreach ($casillero7 as $ca)
                                        <?php if($ca->estado == "LIBRE"){ $est = "navy-bg"; $modal = ""; }elseif ($ca->estado == "RECOGER") {$est = "yellow-bg"; $modal = $ca->prestamo_id; }else{ $est = "red-bg";  }?>
                                        <div class="col-md-4"  onclick="verRecoger('{{ $modal }}')">
                                            <div class="widget style1 {{ $est }}"  data-toggle="tooltip" data-placement="top" title="Cod. Prestamo: {{ $ca->prestamo_id }}, Total de Prestamo: {{ $ca->total }}, Garantia: {{ $ca->garantia }} ">
                                                <div class="row">
                                                    <div class="col-4">
                                                        <i class="fa fa-archive fa-3x"></i>
                                                    </div>
                                                    <div class="col-8 text-right">
                                                        <h2 class="font-bold"> {{ $ca->nombre }} </h2>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>    
                                        @endforeach
                                    </div>
                                </div>
                            </div>
        
                            <div class="ibox col-md-6">
                                <div class="ibox-title">
                                    <h5>{{ $stand[7]->nombre }}</h5>
                                    <div class="ibox-tools">
                                        <a class="close-link">
                                            <i class="fa fa-times"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="ibox-content" id="divTipoPrestamo">
                                    <div class="row">
                                        @foreach ($casillero8 as $ca)
                                        <?php if($ca->estado == "LIBRE"){ $est = "navy-bg"; $modal = ""; }elseif ($ca->estado == "RECOGER") {$est = "yellow-bg"; $modal = $ca->prestamo_id; }else{ $est = "red-bg";  }?>
                                        <div class="col-md-4"  onclick="verRecoger('{{ $modal }}')">
                                            <div class="widget style1 {{ $est }}"  data-toggle="tooltip" data-placement="top" title="Cod. Prestamo: {{ $ca->prestamo_id }}, Total de Prestamo: {{ $ca->total }}, Garantia: {{ $ca->garantia }} ">
                                                <div class="row">
                                                    <div class="col-4">
                                                        <i class="fa fa-archive fa-3x"></i>
                                                    </div>
                                                    <div class="col-8 text-right">
                                                        <h2 class="font-bold"> {{ $ca->nombre }} </h2>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>    
                                        @endforeach
                                    </div>
                                </div>
                            </div>
        
                            <div class="ibox col-md-6">
                                <div class="ibox-title">
                                    <h5>{{ $stand[8]->nombre }}</h5>
                                    <div class="ibox-tools">
                                        <a class="close-link">
                                            <i class="fa fa-times"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="ibox-content" id="divTipoPrestamo">
                                    <div class="row">
                                        @foreach ($casillero9 as $ca)
                                        <?php if($ca->estado == "LIBRE"){ $est = "navy-bg"; $modal = ""; }elseif ($ca->estado == "RECOGER") {$est = "yellow-bg"; $modal = $ca->prestamo_id; }else{ $est = "red-bg";  }?>
                                        <div class="col-md-4"  onclick="verRecoger('{{ $modal }}')">
                                            <div class="widget style1 {{ $est }}"  data-toggle="tooltip" data-placement="top" title="Cod. Prestamo: {{ $ca->prestamo_id }}, Total de Prestamo: {{ $ca->total }}, Garantia: {{ $ca->garantia }} ">
                                                <div class="row">
                                                    <div class="col-4">
                                                        <i class="fa fa-archive fa-3x"></i>
                                                    </div>
                                                    <div class="col-8 text-right">
                                                        <h2 class="font-bold"> {{ $ca->nombre }} </h2>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>    
                                        @endforeach
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