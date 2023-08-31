<div class="ibox" id="divSemaforo">
                    <div class="ibox-title">
                        <h5>Valoración</h5><button class="btn btn-success" type="button" onclick="mostrarValoracion()"><i class="fa fa-pencil"></i></button>
                    </div>
                    <?php
                    
                        $btnGreen = 'btn-default';
                        $lblGreen = 'hidden';
                        $btnAmbar = 'btn-default';
                        $lblGreen = 'hidden';
                        $btnRed = 'btn-default';
                        $lblGreen = 'hidden';
                    
                        switch ($resultSemaforo) {
                            case "VERDE":
                                $btnGreen = 'btn-primary';
                                $btnAmbar = 'btn-default';
                                $btnRed = 'btn-default';
                                $lblGreen = '';
                                $lblAmbar = 'hidden';
                                $lblRed = 'hidden';
                                break;
                            case "AMBAR":
                                $btnGreen = 'btn-default';
                                $btnAmbar = 'btn-warning';
                                $btnRed = 'btn-default'; 
                                $lblGreen = 'hidden';
                                $lblAmbar = '';
                                $lblRed = 'hidden';
                                break;
                            case "ROJO":
                                $btnGreen = 'btn-default';
                                $btnAmbar = 'btn-default';
                                $btnRed = 'btn-danger';
                                $lblGreen = 'hidden';
                                $lblAmbar = 'hidden';
                                $lblRed = '';
                                break;
                        }
                        
                    ?>
                    <div class="ibox-content" id="divValoracion">
                        <div class="col-lg-12 row"> 
                            <div class="profile-image col-lg-12 row">
                                <div class="col-lg-7"><img id="semaforo" class="rounded-circle circle-border border-success m-b-md {{ $btnGreen }}"></div>
                                <div class="col-lg-5" {{ $lblGreen }}>BUEN CLIENTE</div>
                            </div>
                            <div class="profile-image col-lg-12 row">
                                <div class="col-lg-7"><img id="semaforo" class="rounded-circle circle-border border-warning m-b-md {{ $btnAmbar }} "></div>
                                <div class="col-lg-5" {{ $lblAmbar }}>CLIENTE EN RIESGO</div>
                            </div>
                            <div class="profile-image col-lg-12 row"> 
                                <div class="col-lg-7"><img id="semaforo" class="rounded-circle circle-border border-danger border-lg m-b-md {{ $btnRed }} "></div>
                                <div class="col-lg-5" {{ $lblRed }}>CLIENTE RESTRINGIDO</div>
                            </div>
                        </div>
                    </div>
                </div>