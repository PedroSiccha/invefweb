@extends('layouts.app')
@section('pagina')
    Realizar Pagos
@endsection 
@section('contenido')
 
<?php 
    use App\proceso; 
    $pro = new proceso();
?>

<div class="wrapper wrapper-content  animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox">
                <div class="ibox-content">
                    <span class="text-muted small float-right">Ultima Modificación: <i class="fa fa-clock-o"></i> {{date( "g:i a") }} - {{ date("d/m/Y")}}</span>
                    <h2>Clientes</h2>
                    <p>
                        Buscar los clientes con pagos pendientes.
                    </p>
                    <div class="input-group">
                        <input type="text" placeholder="Buscar cliente... " class="input form-control" id="clienteBusqueda" onkeyup="buscarCliente()">
                        <span class="input-group-append">
                                <button type="button" class="btn btn btn-primary"> <i class="fa fa-search"></i> Buscar</button>
                        </span>
                    </div>
                    <div class="clients-list">
                    <span class="float-right small text-muted">{{ $cantPrestamo[0]->cantidad }} Prestamos Activos</span>
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
                                                <th>Fec Fin</th>
                                                <th>Dias</th>
                                                <th>Monto</th>
                                                <th>Interes</th>
                                                <th>Interes Actual</th>
                                                <th>Mora Actual</th>
                                                <th>Total</th>
                                                <th>Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($prestamo as $pr)

                                                    <?php

                                                        $inicio = $pr->fecinicio;
                                                        $fechaActual = date("d-m-Y");
                                                        $dias = (strtotime($inicio)-strtotime($fechaActual))/86400;
                                                        $dias = abs($dias); $dias = floor($dias);

                                                        $inicioF = $pr->fecfin;
                                                        $diaFin = (strtotime($fechaActual) - strtotime($inicioF))/86400;
                                                        $diaFin = abs($diaFin); 
                                                        $diaFin = floor($diaFin);   

                                                    ?>

                                                <tr>
                                                    <td>{{ $pr->prestamo_id }}</td>
                                                    <td>{{ $pr->nombre }} {{ $pr->apellido }}</td>
                                                    <td>{{ cambiaf_a_espanol($pr->fecfin) }}</td>
                                                    <td>{{$dias}} días</td>
                                                    <td>S/. {{ $pr->monto }}</td>
                                                    <td>{{ $pr->porcentaje }} %</td>
                                                    <td>S/. {{ $pro->interesActual($dias, $pr->monto, $pr->porcentaje, $pr->morapagar)[0] }}</td>
                                                    <td>S/. {{ $pro->interesActual($dias, $pr->monto, $pr->porcentaje, $pr->morapagar)[1] }}</td>
                                                    <td>S/. {{ $pro->interesActual($dias, $pr->monto, $pr->porcentaje, $pr->morapagar)[2] }}</td>
                                                    <td class="client-status"><button type="button" class="btn btn-success btn-xs" onclick="Pagar(' {{ $pr->prestamo_id }} ', ' {{ $pr->monto }} ', ' {{ $pro->interesActual($dias, $pr->monto, $pr->porcentaje, $pr->morapagar)[0] }} ', ' {{ $pro->interesActual($dias, $pr->monto, $pr->porcentaje, $pr->morapagar)[1] }} ', ' {{ $pro->interesActual($dias, $pr->monto, $pr->porcentaje, $pr->morapagar)[2] }} ', '{{ $dias }}' , ' {{ $diaFin }} ', '{{ $pro->interesActual($dias, $pr->monto, $pr->porcentaje, $pr->morapagar)[3] }}')" data-toggle="tooltip" data-placement="top" title="PAGAR PRESTAMO"><i class="fa fa-money"></i></button><button type="button" class="btn btn-warning btn-xs" onclick="Renovar(' {{ $pr->prestamo_id }} ', ' {{ $pr->monto }} ', ' {{ $pro->interesActual($dias, $pr->monto, $pr->porcentaje, $pr->morapagar)[0] }} ', ' {{ $pro->interesActual($dias, $pr->monto, $pr->porcentaje, $pr->morapagar)[1] }} ', ' {{ $pro->interesActual($dias, $pr->monto, $pr->porcentaje, $pr->morapagar)[2] }} ', '{{ $dias }}' , ' {{ $diaFin }} ', '{{ $pro->interesActual($dias, $pr->monto, $pr->porcentaje, $pr->morapagar)[3] }}')" data-toggle="tooltip" data-placement="top" title="RENOVAR PRESTAMO"><i class="fa fa-history"></i></button><button type="button" class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="top" title="INFORMACIÓN DEL PRESTAMO" onclick="Detalle(' {{ $pr->prestamo_id }} ', '{{ $pr->nombre }} {{ $pr->apellido }}', '{{ $pr->dni }}', '{{ $pr->garantia }}', '{{ cambiaf_a_espanol($pr->fecinicio) }}', '{{ cambiaf_a_espanol($pr->fecfin) }}', '{{ $dias }}', ' {{ $pr->monto }} ', ' {{ $pro->interesActual($dias, $pr->monto, $pr->porcentaje, $pr->morapagar)[0] }} ', ' {{ $pro->interesActual($dias, $pr->monto, $pr->porcentaje, $pr->morapagar)[1] }} ', ' {{ $pro->interesActual($dias, $pr->monto, $pr->porcentaje, $pr->morapagar)[2] }} ', '{{ $pro->interesActual($dias, $pr->monto, $pr->porcentaje, $pr->morapagar)[3] }}')"><i class="fa fa-desktop"></i></button></td>
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

<!-- Pagar Prestamo -->
<div class="modal inmodal fade" id="pagar" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
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
                            <input id="pagoPrestamo" hidden>
                        </td>
    
                    </tr>
                    <tr>
                        <td>
                            <strong>INTERES</strong>
                        </td>
                        <td>
                            <span id="pagarInteres">Modal title</span>
                            <input id="pagoInteres" hidden>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>MORA</strong>
                        </td>
                        <td class = 'bg-danger'>
                            <span id="pagarMora">Modal title</span>
                            <span id="diaMora">Modal title</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>PAGO TOTAL</strong>
                        </td>
                        <td class = 'bg-primary'>
                            <span id="pagarTotal">Modal title</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>IMPORTE RECIBIDO</strong>
                        </td>
                        <td>
                            <div class="col-sm-10" style='float: right; width: 150px;'><input style="font-size: large;" type="text" class="form-control text-success" id="impoRecibido" placeholder="S/. 0.00" onkeyup="vuelto()"></div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>IMPORTE</strong>
                        </td>
                        <td>
                            <div class="col-sm-10" style='float: right; width: 150px;'><input style="font-size: large;" type="text" class="form-control text-success" id="impoPagar" placeholder="S/. 0.00" onkeyup="vuelto()"></div>
                        </td>
                    </tr>
                    <tr>
                        <td> 
                            <strong>VUELTO</strong>
                        </td>
                        <td>
                            <div class="col-sm-10" style='float: right; width: 150px;'><input style="font-size: large;" type="text" class="form-control text-success" id="vuelto" placeholder="S/. 0.00" readonly></div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-outline btn-success dim" data-dismiss="modal" onclick="cancelarPago()"><i class="fa fa-money"></i> PAGAR</button>
            </div>
        </div>
    </div>
</div>
<!-- Fin Pagar -->

<!-- Renovar Prestamo -->
<div class="modal inmodal fade" id="renovar" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
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
                            <input id="renPrestamo" hidden>
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
                        <td class = 'bg-danger'>
                            <span id="renovarMora">Modal title</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>PAGO TOTAL</strong>
                        </td>
                        <td class = 'bg-primary'>
                            <span id="renovarTotal">Modal title</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>PAGO MÍNIMO</strong>
                        </td>
                        <td class = 'bg-info'>
                            <span id="renovarMinimo">Modal title</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>IMPORTE</strong>
                        </td>
                        <td>
                            <div class="col-sm-10" style='float: right; width: 150px;'><input style="font-size: large;" type="text" class="form-control text-success" id="impoRenovar" placeholder="S/. 0.00"></div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-outline btn-success dim" data-dismiss="modal" onclick="cancelarRenovar()"><i class="fa fa-money"></i> PAGAR</button>
            </div>
        </div>
    </div>
</div>
<!-- Fin Pagar -->


@endsection

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


@section('script')
    <script src="{{ asset('js/plugins/footable/footable.all.min.js') }}"></script>
    <script src="{{ asset('js/proceso/proceso.js') }}"></script>
    <script>

        function buscarCliente() {
            var dato = $("#clienteBusqueda").val();
            
            $.post( "{{ Route('buscarClientePago') }}", {dato: dato, _token:'{{csrf_token()}}'}).done(function(data) {
                $("#tabCliente").empty();
                $("#tabCliente").html(data.view);
                
            });
        }

        function cancelarPago() {
            var importe = $("#impoRecibido").val();
            var importeMonto = $("#impoPagar").val();
            var idPrestamo = $("#idPrestamoP").val();
            var dia = $("#diaPago").val();
            var mora = $("#pagoMora").val();
            var interes = $("#pagoInteres").val();
            var monto = $("#pagoPrestamo").val();
            
            swal({
                    title: "Confirmar Pago", 
                    text: "Codigo de Prestamo:"+idPrestamo+"\nPago a Realizar: S/."+importe,
                    type: "info",
                    showCancelButton: true,
                    confirmButtonColor: "#3366FF",
                    confirmButtonText: "Aceptar",
                    closeOnConfirm: false   
                }, function () {
                    $.post( "{{ Route('pagoPrestamo') }}", {idPrestamo: idPrestamo, importe: importe, importeMonto: importeMonto, dia: dia, mora: mora, interes: interes, monto: monto, _token:'{{csrf_token()}}'}).done(function(data) {
                        $("#tabCliente").empty();
                        $("#tabCliente").html(data.view);
                        window.open('{{ Route('printTicket') }}', '_blank');
                    });
                    swal("Correcto", "El pago de S/." +importe+", se realizó correctamente", "success");
                });
        }
        function cancelarRenovar() {

            var importe = $("#impoRenovar").val();
            var idPrestamo = $("#idPrestamoR").val();
            var dia = $("#diaReno").val();
            var interes = $("#renInteres").val();
            var mora = $("#renMora").val();
            var monto = $("#renPrestamo").val();

            var calc = parseFloat(interes) + parseFloat(mora);

            if (importe >= calc ) {
                swal({
                    title: "Confirmar Pago",
                    text: "Codigo de Prestamo:"+idPrestamo+"\nPago a Realizar: S/."+importe,
                    type: "info",
                    showCancelButton: true, 
                    confirmButtonColor: "#3366FF",
                    confirmButtonText: "Aceptar",
                    closeOnConfirm: false
                }, function () {
                    $.post( "{{ Route('renovarPrestamo') }}", {idPrestamo: idPrestamo, importe: importe, dia: dia, interes: interes, mora: mora, monto: monto, _token:'{{csrf_token()}}'}).done(function(data) {
                        if (data.aux == 0) {
                            swal("Verificar", "Error en la renovacion", "warning");
                        }else{
                            $("#tabCliente").empty();
                            $("#tabCliente").html(data.view);
                            window.open('{{ Route('printTicket') }}', '_blank');
                        }
                        
                    });
                    swal("Correcto", "El pago de S/." +importe+", se realizó correctamente", "success");
                }); 
            }else{
                swal("Verificar", "El importe mínimo debe ser S/." +calc, "warning");
            }
            
        }
    </script>
@endsection
<?php
function cambiaf_a_espanol($fecha){
    preg_match( '/([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})/', $fecha, $mifecha);
    $lafecha=$mifecha[3]."/".$mifecha[2]."/".$mifecha[1];
    return $lafecha;
}
?>
