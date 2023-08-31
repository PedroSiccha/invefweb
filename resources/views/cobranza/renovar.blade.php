@extends('layouts.app')
@section('pagina')
    Renovar Préstamos
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
                        Buscar los clientes con pagos pendientes.
                    </p>
                    <div class="input-group">
                        <input type="text" placeholder="Buscar cliente... " class="input form-control" id="clienteBusqueda" onkeyup="buscarCliente()">
                        <span class="input-group-append">
                                <button type="button" class="btn btn btn-primary"> <i class="fa fa-search"></i> Buscar</button>
                        </span>
                    </div>
                    <div class="clients-list">
                    <span class="float-right small text-muted">1406 Elements</span>
                    <ul class="nav nav-tabs">
                        <li><a class="nav-link active" data-toggle="tab" href="#tab-1"><i class="fa fa-user"></i></a></li>
                    </ul>
                    <div class="tab-content" id="tabCliente">
                        <div id="tab-1" class="tab-pane active">
                            <div class="full-height-scroll">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Cod.</th>
                                                <th>Nombres</th>
                                                <th>DNI</th>
                                                <th>Garantía</th>
                                                <th>Fec Inicio</th>
                                                <th>Fec Fin</th>
                                                <th>Dias</th>
                                                <th>Monto</th>
                                                <th>Interes</th>
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

                                                        if($dias > 31){
                                                            $diaMora = $dias - 31;
                                                            $moraPagar = $diaMora*$pr->morapagar;
                                                        }else{
                                                            $moraPagar = "0.00";
                                                        }

                                                        if ($dias > -1 && $dias < 8) {
                                                            $interesActual = $pr->monto*0.07;
                                                        }elseif ($dias > 6 && $dias < 16) {
                                                            $interesActual = $pr->monto*0.1;
                                                        }elseif ($dias > 15 && $dias < 21) {
                                                            $interesActual = $pr->monto*0.15;
                                                        }elseif ($dias > 20 && $dias < 31) {
                                                            $interesActual = $pr->monto*0.20;
                                                        }elseif ($dias > 30) {
                                                            $interesActual = $pr->monto*0.20;
                                                        }

                                                        $totalActual = $pr->monto + $moraPagar + $interesActual;

                                                    ?>

                                                <tr>
                                                    <td>{{ $pr->prestamo_id }}</td>
                                                    <td><a href="{{ Route('perfilCliente', [$pr->cliente_id]) }}">{{ $pr->nombre }} {{ $pr->apellido }}</a></td>
                                                    <td>{{ $pr->dni }}</td>
                                                    <td>{{ $pr->garantia }}</td>
                                                    <td>{{ $pr->fecinicio }}</td>
                                                    <td>{{ $pr->fecfin }}</td>
                                                    <td>{{$dias}} días</td>
                                                    <td>S/. {{ $pr->monto }}</td>
                                                    <td>S/. {{ $interesActual }}</td>
                                                    <td>S/. {{ $moraPagar }}</td>
                                                    <td>S/. {{ $totalActual }}</td>
                                                    <td class="client-status"><button type="button" class="btn btn-warning btn-xs" onclick="Renovar(' {{ $pr->prestamo_id }} ', ' {{ $pr->monto }} ', ' {{ $interesActual }} ', ' {{ $moraPagar }} ', ' {{ $totalActual }} ', '{{ $dias }}' , ' {{ $diaFin }} ')" data-toggle="tooltip" data-placement="top" title="RENOVAR PRESTAMO"><i class="fa fa-history"></i></button><button type="button" class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="top" title="INFORMACIÓN DEL PRESTAMO"><i class="fa fa-desktop"></i></button></td>
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
@endsection

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


@section('script')
    <script src="{{ asset('js/plugins/footable/footable.all.min.js') }}"></script>
    <script>
        function buscarCliente() {
            var dato = $("#clienteBusqueda").val();
            
            $.post( "{{ Route('buscarClientePago') }}", {dato: dato, _token:'{{csrf_token()}}'}).done(function(data) {
                $("#tabCliente").empty();
                $("#tabCliente").html(data.view);
                
            });
            
        }

        

        function vuelto() {
            var importeRecibido = $("#impoRecibido").val();
            var importePago = $("#impoPagar").val();

            var vuelto = parseFloat(importeRecibido) - parseFloat(importePago);

            $("#vuelto").val(vuelto);
            
        }

        function Pagar(id, monto, interes, mora, total, dia, diafin) {
            
            $('#pagar').modal('show');
            document.getElementById("pagarPrestamo").innerHTML="<p style='text-align:right;'>S/. " +monto+"</p>";
            document.getElementById("pagarInteres").innerHTML="<p style='text-align:right;'>S/. "+interes+"</p>";
            document.getElementById("pagarMora").innerHTML="<p style='text-align:right;'>S/. "+mora+"</p>";
            document.getElementById("pagarTotal").innerHTML="<p style='text-align:right;'>S/. "+total+"</p>";
            document.getElementById("idPagar").innerHTML="<input style='font-size: large;' type='text' class='form-control text-success' id='idPrestamoP' value='" +id+"'>";
            document.getElementById("diaPagar").innerHTML="<input style='font-size: large;' type='text' class='form-control text-success' id='diaPago' value='" +dia+"'>";
            //document.getElementById("pagarMinimo").innerHTML="<p style='text-align:right;'>S/. "+interes+"</p>";
                
        }

        function Renovar(id, monto, interes, mora, total, dia, diafin) {
            $('#renovar').modal('show');

            pagoMinimo = parseInt(interes) + parseInt(mora);
            document.getElementById("idRenovar").innerHTML="<input style='font-size: large;' type='text' class='form-control text-success' id='idPrestamoR' value='" +id+"'>";
            document.getElementById("diaRenovar").innerHTML="<input style='font-size: large;' type='text' class='form-control text-success' id='diaReno' value='" +dia+"'>";
            document.getElementById("envInteres").innerHTML="<input style='font-size: large;' type='text' class='form-control text-success' id='renInteres' value='" +interes+"'>";
            document.getElementById("envMora").innerHTML="<input style='font-size: large;' type='text' class='form-control text-success' id='renMora' value='" +mora+"'>";
            document.getElementById("renovarPrestamo").innerHTML="<p style='text-align:right;'>S/. " +monto+"</p>";
            document.getElementById("renovarInteres").innerHTML="<p style='text-align:right;'>S/. "+interes+"</p>";
            document.getElementById("renovarMora").innerHTML="<p style='text-align:right;'>S/. "+mora+"</p>";
            document.getElementById("renovarTotal").innerHTML="<p style='text-align:right;'>S/. "+total+"</p>";
            document.getElementById("renovarMinimo").innerHTML="<p style='text-align:right;'>S/. "+pagoMinimo+"</p>";
        }

        function cancelarPago() {
            var importe = $("#impoRecibido").val();
            var importeMonto = $("#impoPagar").val();
            var vuelto = $("#vuelto").val();
            var idPrestamo = $("#idPrestamoP").val();
            var dia = $("#diaPago").val();
            swal({
                    title: "Confirmar Pago",
                    text: "Codigo de Prestamo:"+idPrestamo+"\nPago a Realizar: S/."+importe,
                    type: "info",
                    showCancelButton: true,
                    confirmButtonColor: "#3366FF",
                    confirmButtonText: "Aceptar",
                    closeOnConfirm: false   
                }, function () {
                    $.post( "{{ Route('pagoPrestamo') }}", {idPrestamo: idPrestamo, importe: importe, importeMonto: importeMonto, vuelto: vuelto, dia: dia, _token:'{{csrf_token()}}'}).done(function(data) {
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
        function cancelarRenovar() {

            var importe = $("#impoRenovar").val();
            var idPrestamo = $("#idPrestamoR").val();
            var dia = $("#diaReno").val();
            var interes = $("#renInteres").val();
            var mora = $("#renMora").val();

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
                    $.post( "{{ Route('renovarPrestamo') }}", {idPrestamo: idPrestamo, importe: importe, dia: dia, interes: interes, mora: mora, _token:'{{csrf_token()}}'}).done(function(data) {
                        if (data.aux == 0) {
                            alert(data.respuesta);
                        }else{
                            $("#tabCliente").empty();
                            $("#tabCliente").html(data.view);
                            var pagoId = data.data.id;
                            var url = '{{ route('printTicket', ['id' => ':id']) }}';
                            url = url.replace(':id', pagoId);
                            window.open(url, '_blank');
                            
                            
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
