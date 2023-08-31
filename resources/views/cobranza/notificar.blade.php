
<?php 
use App\proceso; 
$pro = new proceso();
?>
@extends('layouts.app')
@section('pagina')
    Control de Notificaciones
@endsection
@section('contenido') 
<div class="wrapper wrapper-content  animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox">
                <div class="ibox-content">
                    <span class="text-muted small float-right">Ultima Modificación: <i class="fa fa-clock-o"></i> {{date( "g:i a") }} - {{ date("d/m/Y")}}</span>
                    <h2>Clientes</h2>
                    <p>
                        Notificar a los clientes con pagos pendientes.
                    </p>
                    <div class="input-group">
                        <input type="text" placeholder="Buscar cliente... " class="input form-control" id="clienteBusqueda" onkeyup="buscarCliente()">
                        <span class="input-group-append">
                                <button type="button" class="btn btn btn-primary"> <i class="fa fa-search"></i> Buscar</button>
                        </span>
                    </div> 
                <div class="clients-list">
                    <span class="float-right small text-muted">{{ $countNotificar }} Clientes</span>
                    <ul class="nav nav-tabs">
                        <li><a class="nav-link active" data-toggle="tab" href="#tab-1"><i class="fa fa-user"></i></a></li>
                    </ul>
                    <div class="tab-content" >
                        <div id="tab-1" class="tab-pane active">
                            <div class="full-height-scroll">
                                <div class="table-responsive" id="tabCliente">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Cod.</th>
                                                <th>Nombres</th>
                                                <th>DNI</th>
                                                <th>Garantía</th>
                                                <th>Fec Fin</th>
                                                <th>Dias</th>
                                                <th>Monto</th>
                                                <th>Interes</th>
                                                <th>Mora Actual</th>
                                                <th>Total</th>
                                                <th>Herramientas</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($listNotificar as $ln)
                                            <?php
                                                $color = "bg-secondary";
                                                $botonWhats1 = "hidden";
                                                $botonWhats2 = "hidden";
                                                $botonWhats3 = "hidden";
                                                $botonWhats4 = "hidden";
                                                $botonWhats5 = "hidden";
                                                $botonWhats6 = "hidden";
                                                $mora = ($ln->dia - 30)*$ln->mora; 
                                                if ( $ln->dia < 31 and $ln->dia > 28) {
                                                    //2 dias antes hasta la fecha
                                                    $botonWhats1 = "";
                                                    $botonWhats2 = "hidden";
                                                    $botonWhats3 = "hidden";
                                                    $botonWhats4 = "hidden";
                                                    $botonWhats5 = "hidden";
                                                    $botonWhats6 = "hidden";
                                                    $color = "bg-secondary";
                                                }elseif ( 30 < $ln->dia and $ln->dia < 38) {
                                                    //De la fecha hasta 7 dias despues
                                                    $botonWhats1 = "hidden";
                                                    $botonWhats2 = "";
                                                    $botonWhats3 = "hidden";
                                                    $botonWhats4 = "hidden";
                                                    $botonWhats5 = "hidden";
                                                    $botonWhats6 = "hidden";
                                                    $color = "bg-secondary";
                                                }elseif (37 < $ln->dia and $ln->dia < 41) {
                                                    //De 7 dias despues hasta los 10 dias
                                                    $botonWhats1 = "hidden";
                                                    $botonWhats2 = "hidden";
                                                    $botonWhats3 = "";
                                                    $botonWhats4 = "hidden";
                                                    $botonWhats5 = "hidden";
                                                    $botonWhats6 = "hidden";
                                                    $color = "bg-secondary";
                                                }elseif (39 < $ln->dia and $ln->dia < 46) {
                                                    //De 10 dias despues hasta 15 dias
                                                    $botonWhats1 = "hidden";
                                                    $botonWhats2 = "hidden";
                                                    $botonWhats3 = "hidden";
                                                    $botonWhats4 = "";
                                                    $botonWhats5 = "hidden";
                                                    $botonWhats6 = "hidden";
                                                    $color = "bg-warning";
                                                }elseif (50 < $ln->dia and $ln->dia < 55) {
                                                    //Despues de los 21 dias 
                                                    $botonWhats1 = "hidden";
                                                    $botonWhats2 = "hidden";
                                                    $botonWhats3 = "hidden";
                                                    $botonWhats4 = "hidden";
                                                    $botonWhats5 = "";
                                                    $botonWhats6 = "hidden";
                                                    $color = "bg-warning";
                                                }elseif (54 < $ln->dia and $ln->dia < 61) {
                                                    //Despues de los 25 dias
                                                    $botonWhats1 = "hidden";
                                                    $botonWhats2 = "hidden";
                                                    $botonWhats3 = "hidden";
                                                    $botonWhats4 = "hidden";
                                                    $botonWhats5 = "";
                                                    $color = "bg-danger";
                                                }elseif (59 < $ln->dia) {
                                                    // Despues de los 30 dias pasar a liquidacion
                                                    $botonWhats1 = "hidden";
                                                    $botonWhats2 = "hidden";
                                                    $botonWhats3 = "hidden";
                                                    $botonWhats4 = "hidden";
                                                    $botonWhats5 = "hidden";
                                                    $color = "bg-secondary";
                                                }
                                            ?>
                                            
                                                <tr  class="{{ $color }}" >
                                                    <td class="text-white">{{ $ln->prestamo_id }}</td>
                                                    <td><a class="text-white" href="{{ Route('perfilCliente', [$ln->cliente_id]) }}">{{ $ln->nombre }} {{ $ln->apellido }}</a></td>
                                                    <td class="text-white">{{ $ln->dni }}</td> 
                                                    <td class="text-white">{{ $ln->garantia }}</td>
                                                    <td class="text-white">{{ cambiaf_a_espanol($ln->fecfin) }}</td>
                                                    <td class="text-white">{{ $ln->dia }}</td>
                                                    <td class="text-white">{{ $ln->monto }}</td>
                                                    <td class="text-white">{{ $pro->interesActual($ln->dia,  $ln->monto, $ln->porcentaje, $ln->mora)[0] }}</td>
                                                    <td class="text-white">S/. {{ $pro->calcularMora($ln->fecfin, $ln->mora) }} </td>
                                                    <td class="text-white">{{ $pro->interesActual($ln->dia,  $ln->monto, $ln->porcentaje, $ln->mora)[2] }}</td>
                                                    <td class="client-status">
                                                        <a class="btn btn-success btn-facebook btn-outline btn-xs" href ="{{ $ln->facebook }}" target="_blank" data-toggle="tooltip" data-placement="top" title="Facebook">
                                                            <i class="fa fa-facebook"> </i>
                                                        </a>
                                                        
                                                        
                                                        <a class="btn btn-primary btn-outline btn-xs" {{ $botonWhats1 }} href="https://api.whatsapp.com/send?phone=51{{ $ln->whatsapp }}&text=Estimado%20{{ $ln->nombre }}%20{{ $ln->apellido }},%20le%20saludamos%20cordialmente%20de%20INVERSIONES%20INVEF%20SAC.%20Le%20enviamos%20los%20detalles%20de%20si%20crédito.%20Prestamo:%20S/.%20{{ $ln->monto }}.%20Interes:%20S/.%20{{ $pro->interesActual($ln->dia,  $ln->monto, $ln->porcentaje, $ln->mora)[0] }}.%20Vence%20el%20día:%20{{ cambiaf_a_espanol($ln->fecfin) }}.%20*Medios%20de%20pago:*%20En%20nuestra%20oficina%20dentro%20de%20los%20horarios%20establecidos.%20Cuenta%20BCP:%20375-30500414-0-56.%20Gerente%20Kelvin%20Javier%20R.%20Sin%20comisiones%20ni%20recargos%20en%20Agentes%20BCP.%20RECUERDE%20QUE%20USTED%20PUEDE:%20CANCELAR%20-%20RENOVAR%20-%20AMORTIZAR,%20SUS%20DEUDAS%20VENCIDAS.%20A%20si%20mismo%20informarle%20que%20usted%20tiene%20el%20derecho%20de%20poder%20realizar%20amortizaciones%20de%20capital%20con%20la%20siguiente%20reduccion%20de%20su%20monto%20de%20prestamo%20y%20su%20interes%20al%20siguiente%20mes." target="_blank" data-toggle="tooltip" data-placement="top" title="Whatsapp">
                                                            <i class="fa fa-whatsapp"></i>
                                                        </a>
                                                        <a class="btn btn-primary btn-outline btn-xs"  {{ $botonWhats2 }} href="https://api.whatsapp.com/send?phone=51{{ $ln->whatsapp }}&text=Estimado%20cliente%20{{ $ln->nombre }}%20{{ $ln->apellido }},%20le%20saludamos%20cordialmente%20de%20INVERSIONES%20INVEF%20SAC.%20Por%20que%20nos%20preocupamos%20por%20su%20credito%20y%20su%20pronta%20cancelacion%20o%20renovacion%20le%20enviamos%20los%20detalles%20de%20su%20credito.%20Prestamo:%20S/.%20{{ $ln->monto }}.%20Interes:%20S/.%20{{ $pro->interesActual($ln->dia,  $ln->monto, $ln->porcentaje, $ln->mora)[0] }}.%20Mora:%20S/.%20{{ $pro->calcularMora($ln->fecfin, $ln->mora) }}.%20Vencio%20el%20dia:%20{{ cambiaf_a_espanol($ln->fecfin) }}.%20Medios%20de%20Pago:%20En%20nuestra%20oficina%20dentro%20de%20los%20horarios%20establecidos.%20Cuenta%20BCP:%20375-30500414-0-56.%20Gerente:%20Kelvin%20Javier%20R.%20RECUERDE%20QUE%20USTEDE%20PUEDE:%20CANCELAR%20-%20RENOVAR%20-%20AMORTIZAR,%20SUS%20DEUDAS%20VENCIDAS.%20Las%20moras%20estan%20sujetas%20de%20acuerdo%20al%20contrato%20entre%20la%20empresa%20y%20el%20cliente%20prestatario.%20Servicio%20de%20atencion:%20043-634749.%20Pagina%20web:%20www.invef.tk" target="_blank" data-toggle="tooltip" data-placement="top" title="Whatsapp">
                                                            <i class="fa fa-whatsapp"></i>
                                                        </a>
                                                        <a class="btn btn-primary btn-outline btn-xs" {{ $botonWhats3 }} href="https://api.whatsapp.com/send?phone=51{{ $ln->whatsapp }}&text=DEUDA%20ATRASADA%20INVERSIONES%20INVEF%20SAC.%20Le%20recordamos%20que%20su%20contrato%20tiene%20fecha%20limite,%20despues%20de%20la%20fecha%20de%20vencimiento%20segun%20estipulado%20su%20contrato,%20con%20el%20plazo%20maximo%20de%2015%20dias.%20Prestamo:%20S/.%20{{ $ln->monto }}.%20Interes:%20S/.%20{{ $pro->interesActual($ln->dia,  $ln->monto, $ln->porcentaje, $ln->mora)[0] }}.%20Mora:%20S/.%20{{ $pro->calcularMora($ln->fecfin, $ln->mora) }}.%20({{ $ln->dia }}%20dias%20de%20retraso).%20Vencio%20el%20dia:%20{{ cambiaf_a_espanol($ln->fecfin) }}.%20Medios%20de%20Pago:%20En%20nuestra%20oficina%20dentro%20de%20los%20horarios%20establecidos.%20Cuenta%20BCP:%20375-30500414-0-56.%20Gerente:%20Kelvin%20Javier%20R.%20RECUERDE%20QUE%20USTED%20PUEDE:%20CANCELAR%20-%20RENOVAR%20-%20AMORTIZAR,%20SUS%20DEUDAS%20VENCIDAS.%20Las%20moras%20estan%20sujetas%20de%20acuerdo%20al%20contrato%20entre%20la%20empresa%20y%20el%20cliente%20prestatario.%20Servicio%20de%20atencion:%20043-634749.%%20web:%20www.invef.tk." target="_blank" data-toggle="tooltip" data-placement="top" title="Whatsapp">
                                                            <i class="fa fa-whatsapp"></i>
                                                        </a>
                                                        <a class="btn btn-primary btn-outline btn-xs" {{ $botonWhats4 }} href="https://api.whatsapp.com/send?phone=51{{ $ln->whatsapp }}&text=DEUDA%20ATRASADA%20INVERSIONES%20INVEF%20SAC.%20Es%20nuestro%20deber%20notificarle%20que%20su%20contrato%20ya%20venció%20su%20último%20día%20de%20plazo,%20pasado%20dicha%20fecha%20la%20empresa%20pondrá%20a%20su%20elección%20y%20ejecutar%20la%20liquidación%20de%20la%20garantía%20que%20fue%20constituido%20a%20su%20favor.%20Prestamo:%20S/.%20{{ $ln->monto }}.%20Interes:%20S/.%20{{ $pro->interesActual($ln->dia,  $ln->monto, $ln->porcentaje, $ln->mora)[0] }}.%20Mora:%20S/.%20{{ $pro->calcularMora($ln->fecfin, $ln->mora) }}.%20({{ $ln->dia }}%20dias%20de%20retraso).%20Vencio%20el%20dia:%20{{ cambiaf_a_espanol($ln->fecfin) }}.%20Medios%20de%20Pago:%20En%20nuestra%20oficina%20dentro%20de%20los%20horarios%20establecidos.%20Cuenta%20BCP:%20375-30500414-0-56.%20Gerente:%20Kelvin%20Javier%20R.%20RECUERDE%20QUE%20USTED%20PUEDE:%20CANCELAR%20-%20RENOVAR%20-%20AMORTIZAR,%20SUS%20DEUDAS%20VENCIDAS.%20Las%20moras%20estan%20sujetas%20de%20acuerdo%20al%20contrato%20entre%20la%20empresa%20y%20el%20cliente%20prestatario.NOTA:%20último%20día%20de%20plazo%EDITARFECHA.%20Con%20dos%20meses%20En%20caso%20que%20incumpla%20con%20su%20obligación%20de%20pago,%20la%20empresa%20pondrá%20a%20su%20disposición%20ejecutar%20las%20garantías%20que%20fueron%20constituido%20a%20su%20favor%20Servicio%20de%20atencion:%20043-634749.%%20web:%20www.invef.tk." target="_blank" data-toggle="tooltip" data-placement="top" title="Whatsapp">
                                                            <i class="fa fa-whatsapp"></i>
                                                        </a>
                                                        <a class="btn btn-primary btn-outline btn-xs" {{ $botonWhats5 }} href="https://api.whatsapp.com/send?phone=51{{ $ln->whatsapp }}&text=DEUDA%20ATRAZADA%20EJECUTACION%20DE%20CONTRATO%20INVERSIONES%20“INVEF”%20SAC.%20Es%20nuestro%20deber%20notificarle%20que%20el%20día%20de%20hoy%20venció%20su%20último%20día%20de%20plazo,%20pasado%20dicha%20fecha%20la%20empresa%20pone%20a%20su%20disposición%20y%20ejecutar%20de%20su%20garantía%20que%20fue%20constituido%20a%20su%20favor.%20%20Prestamo:%20S/.%20{{ $ln->monto }}.%20Interes:%20S/.%20{{ $pro->interesActual($ln->dia,  $ln->monto, $ln->porcentaje, $ln->mora)[0] }}.%20Mora:%20S/.%20{{ $pro->calcularMora($ln->fecfin, $ln->mora) }}.%20({{ $ln->dia }}%20dias%20de%20retraso).%20Vencio%20el%20dia:%20{{ cambiaf_a_espanol($ln->fecfin) }}.%20Medios%20de%20Pago:%20En%20nuestra%20oficina%20dentro%20de%20los%20horarios%20establecidos.%20Cuenta%20BCP:%20375-30500414-0-56.%20Gerente:%20Kelvin%20Javier%20R.%20RECUERDE%20QUE%20USTED%20PUEDE:%20CANCELAR%20-%20RENOVAR%20-%20AMORTIZAR,%20SUS%20DEUDAS%20VENCIDAS.%20Las%20moras%20estan%20sujetas%20de%20acuerdo%20al%20contrato%20entre%20la%20empresa%20y%20el%20cliente%20prestatario.%20NOTA:%20el%20día%20de%20mañana%20por%20incumplimiento%20de%20contrato%20la%20empresa%20pone%20a%20disposición%20y%20venta%20de%20su%20garantía%20para%20su%20recuperación%20de%20capital.%20ATT:%20%20LA%20GERENCIA.%20Servicio%20de%20atención:%20043-634749.%20Página%20web:%20invef.tk" target="_blank" data-toggle="tooltip" data-placement="top" title="Whatsapp">
                                                            <i class="fa fa-whatsapp"></i>
                                                        </a>
                                                        <button class="btn btn-warning btn-outline btn-xs" data-toggle="tooltip" data-placement="top" title="Correo" onclick="correo('{{ $ln->nombre }}', '{{ $ln->apellido }}', '{{ $ln->correo }}')"><i class="fa fa-envelope-o"></i></button>
                                                        <button type="button" class="btn btn-default btn-xs" data-toggle="tooltip" data-placement="top" title="Mensaje de Text"><i class="fa fa-comment-o"></i></button>
                                                        <button type="button" class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="top" title="Números Telefónicos" onclick="Numeros(' {{ $ln->prestamo_id }} ', '{{ $ln->nombre }} {{ $ln->apellido }}', '{{ $ln->dni }}', '{{ $ln->telefono }}', '{{ $ln->whatsapp }}', '{{ $ln->referencia }}')"><i class="fa fa-phone"></i></button>
                                                        <button type="button" class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="top" title="INFORMACIÓN DEL PRESTAMO" onclick="Detalle(' {{ $ln->prestamo_id }} ', '{{ $ln->nombre }} {{ $ln->apellido }}', '{{ $ln->dni }}', '{{ $ln->garantia }}', '{{ cambiaf_a_espanol($ln->fecinicio) }}', '{{ cambiaf_a_espanol($ln->fecfin) }}', '{{ $ln->dia }}', ' {{ $ln->monto }} ', ' {{ $pro->interesActual($ln->dia,  $ln->monto, $ln->porcentaje, $ln->mora)[0] }} ', ' {{ $pro->calcularMora($ln->fecfin, $ln->mora) }} ', ' {{ $pro->interesActual($ln->dia,  $ln->monto, $ln->porcentaje, $ln->mora)[2] }} ')"><i class="fa fa-desktop"></i></button>
                                                        <button type="button" class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="top" title="Subir Notificacion" onclick="subirNotificacion(' {{ $ln->prestamo_id }} ')"><i class="fa fa-cloud-upload"></i></button>
                                                    </td>
                                                        
                                                </tr>
                                            @endforeach        
                                        </tbody>
                                    </table>  
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

<!-- Telefono de Cliente -->
<div class="modal inmodal fade" id="mTelefonos" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Telefono del Cliente </h4>
                <h4 class="font-bold"><span id = "detNombreT">Nombre</span></h4>
                <small class="font-bold"><span id = "detDniT">Dni</span></small>
            </div>
            <div class="modal-body">
                <table class="table m-b-xs">
                    <tbody>
                    <tr>
                        <td>
                            <strong>Telefono:</strong>
                        </td>
                        <td>
                            <span id="telefono">telefono</span>
                        </td>
    
                    </tr>
                    <tr>
                        <td>
                            <strong>Número de Referencia:</strong>
                        </td>
                        <td>
                            <span id="numReferencia">numero de referencia</span>
                        </td>
    
                    </tr>
                    <tr>
                        <td>
                            <strong>Whatsapp:</strong>
                        </td>
                        <td>
                            <span id="whatsapp">whatsapp</span>
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

<!-- Correo de Cliente -->
<div class="modal inmodal fade" id="mCorreo" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Correo del Cliente </h4>
                <h4 class="font-bold"><span id = "corNombreT">Nombre</span></h4>
            </div>
            <div class="modal-body">
                <table class="table m-b-xs">
                    <tbody>
                    <tr>
                        <td>
                            <strong>Correo:</strong>
                        </td>
                        <td>
                            <span id="corDetalle">telefono</span>
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
<!-- Fin Correo -->
<form id="fnotificar" name="fnotificar" method="post" action="guardarNotificar" class="formNotificar" enctype="multipart/form-data">
<div class="modal inmodal fade" id="notificacionArch" tabindex="-1" role="dialog"  aria-hidden="true">
    
        <input type="text" name="_token" id="_token" hidden value="{{ csrf_token() }}">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">SUBIR ARCHIVO DE NOTIFICACION</h4>
                    <small class="font-bold">Subir un archivo que sustente que se realizó la notificación:</small>
                </div>
                <div class="modal-body">
                    <table class="table m-b-xs">
                        <tbody>
                        <tr hidden>
                            <td>
                                <strong>idPrestamo</strong>
                            </td>
                            <td>
                                <input style="font-size: large;" type="text" class="form-control text-success" id="prestamo_id" name="prestamo_id">
                            </td>
        
                        </tr>
                        <tr>
                            <td>
                                <strong>Nombre de Archivo</strong>
                            </td>
                            <td>
                                <div class="col-sm-10"><input style="font-size: large;" type="text" class="form-control text-success" id="nomArchivo" name="nomArchivo"></div>
                            </td>
        
                        </tr>
                        <tr>
                            <td>
                                <strong>Asunto</strong>
                            </td>
                            <td>
                                <div class="col-sm-10"><input style="font-size: large;" type="text" class="form-control text-success" id="asunArchivo" name="asunArchivo"></div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Archivo</strong>
                            </td>
                            <td>
                                <div class="col-sm-10">
                                    <div class="custom-file">
                                        <input id="logo" type="file" class="custom-file-input" id="archivo" name="archivo">
                                        <label for="logo" class="custom-file-label">Seleccionar...</label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Tipo de Archivo</strong>
                            </td>
                            <td>
                                <div class="col-sm-10">
                                    <select class="form-control m-b" name="tipodocumento_id">
                                        <option>Seleccionar el Tipo de Archivo...</option>
                                        @foreach ($listTipoArch as $lta)
                                            <option value="{{ $lta->id }}">{{ $lta->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    
</div>
</form>
@endsection

<?php
function cambiaf_a_espanol($fecha){
    preg_match( '/([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})/', $fecha, $mifecha);
    $lafecha=$mifecha[3]."/".$mifecha[2]."/".$mifecha[1];
    return $lafecha;
}
?>
@section('script')
<script src="{{ asset('js/plugins/footable/footable.all.min.js') }}"></script>
<script src="{{ asset('js/proceso/proceso.js') }}"></script>
<script>


    $(document).on("submit",".formNotificar",function(e){
        
        e.preventDefault();
        var formu = $(this);
        var nombreform = $(this).attr("id");
        
        
        
        if (nombreform == "fnotificar") {
            var miurl = "{{ Route('guardarNotificar') }}";
        }
        var formData = new FormData($("#"+nombreform+"")[0]);
        
        $.ajax({ url: miurl, type: 'POST', data: formData, cache: false, contentType: false, processData: false,
                beforeSend: function(){
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
                },
                success: function(data){
                    swal({
                        title: "Cliente",
                        text: "Se guardó exitosamente",
                        type: "success",
                        showCancelButton: true,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "Finalizar",
                        closeOnConfirm: false
                    },
                    function(isConfirm){
                        if (isConfirm) {            
                        {closeOnConfirm: true}
                                    
                        }
                    });
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

    $(document).ready(function(){
        $('.custom-file-input').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        });
    });

    function subirNotificacion(id) {
        $('#notificacionArch').modal('show');
        $('#prestamo_id').val(id);
    }
    

    function cancelarPago() {
        var importe = $("#impoRecibido").val();
        var importeMonto = $("#impoPagar").val();
        var vuelto = $("#vuelto").val();
        var idPrestamo = $("#idPrestamoP").val();
        var dia = $("#diaPago").val();
        var mora = $("#pagoMora").val();
        swal({
                title: "Confirmar Pago", 
                text: "Codigo de Prestamo:"+idPrestamo+"\nPago a Realizar: S/."+importe,
                type: "info",
                showCancelButton: true,
                confirmButtonColor: "#3366FF",
                confirmButtonText: "Aceptar",
                closeOnConfirm: false   
            }, function () {
                $.post( "{{ Route('pagoPrestamo') }}", {idPrestamo: idPrestamo, importe: importe, importeMonto: importeMonto, vuelto: vuelto, dia: dia, mora: mora , _token:'{{csrf_token()}}'}).done(function(data) {
                    $("#tabCliente").empty();
                    $("#tabCliente").html(data.view);
                    var pagoId = data.data.id;
                    var url = '{{ route('printTicket', ['id' => ':id']) }}';
                    url = url.replace(':id', pagoId);
                    window.open(url, '_blank');
                });
                swal("Correcto", "El pago de S/." +importe+", se realizó correctamente", "success");
            });
    }

    function buscarCliente() {
        var datoCliente = $("#clienteBusqueda").val();
        
        $.post( "{{ Route('busquedaClienteNotifi') }}", {datoCliente: datoCliente, _token:'{{csrf_token()}}'}).done(function(data) {
                    $("#tabCliente").empty();
                    $("#tabCliente").html(data.view);
                });
    }

    $(document).ready( function()
    {
        $.post( "{{ Route('pasarLiquidacion') }}", { _token:'{{csrf_token()}}'}).done(function(data) {
                    $("#tabCliente").empty();
                    $("#tabCliente").html(data.view);
                });
    } );

</script>
@endsection