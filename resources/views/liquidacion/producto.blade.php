@extends('layouts.app')
@section('pagina')
    Productos en Liquidación
@endsection
@section('contenido')
<div class="wrapper wrapper-content  animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox">
                <div class="ibox-content">
                    <span class="text-muted small float-right">Ultima Modificación: <i class="fa fa-clock-o"></i> {{date( "g:i a") }} - {{ date("d/m/Y")}}</span>
                    <h2>Productos</h2>
                    <p>
                        Productos en riesgo de venta.
                    </p>
                    <div class="input-group">
                        <input type="text" placeholder="Buscar producto... " class="input form-control" id="clienteBusqueda" onkeyup="buscarCliente()">
                        <span class="input-group-append">
                                <button type="button" class="btn btn btn-primary"> <i class="fa fa-search"></i> Buscar</button>
                        </span>
                    </div>
                    <div class="clients-list">
                    <span class="float-right small text-muted" id="cantLiquidacion">0 Productos</span>
                    <ul class="nav nav-tabs">
                        <li><a class="nav-link active" data-toggle="tab" href="#tab-1"><i class="fa fa-user"></i></a></li>
                    </ul>
                    <div class="tab-content" >
                        <div id="tab-1" class="tab-pane active">
                            <div class="full-height-scroll">
                                <div class="table-responsive" id="tabLiquidacion">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Cod</th>
                                                <th>Cliente</th>
                                                <th>DNI</th>
                                                <th>Garantia</th>
                                                <th>Monto Prestamo</th>
                                                <th>Valor Venta</th>
                                                <th>Fecha Agendada</th>
                                                <th>Administración</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                            @foreach ($listLiquidacion as $ll)
                                            <tr class="{{ $ll->color_estado }}">
                                                <td>{{ $ll->prestamo_id }}</td>
                                                <td><a href="{{ Route('perfilCliente', [$ll->cliente_id]) }}">{{ $ll->nombre }}{{ $ll->apellido }}</a></td>
                                                <td>{{ $ll->dni }}</td>
                                                <td>{{ $ll->garantia }}</td>
                                                <td>{{ $ll->monto }}</td>
                                                <td>{{ $ll->total }}</td>
                                                <td>{{ $ll->fecagendar }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-success btn-xs" onclick="Vender(' {{ $ll->prestamo_id }} ', ' {{ $ll->monto }} ', ' {{ $ll->interes }} ', ' {{ $ll->mora }} ', ' {{ $ll->total }} ', ' {{ $ll->fecinicio }} ', ' {{ $ll->fecfin }} ')" data-toggle="tooltip" data-placement="top" title="VENDER GARANTÍA"><i class="fa fa-money"></i></button>
                                                    <button type="button" class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="top" title="HISTORIAL DEL PRESTAMO" onclick="Detalle(' {{ $ll->prestamo_id }} ', '{{ $ll->nombre }} {{ $ll->apellido }}', '{{ $ll->dni }}', '{{ $ll->garantia }}', '{{ $ll->monto }}', '{{ $ll->interes }}', '{{ $ll->mora }}', ' {{ $ll->total }} ', ' {{ $ll->fecinicio }} ', ' {{ $ll->fecfin }} ')"><i class="fa fa-desktop"></i></button>
                                                    <a class="btn btn-success btn-facebook btn-outline btn-xs" href ="{{ $ll->facebook }}" target="_blank" data-toggle="tooltip" data-placement="top" title="Facebook">
                                                        <i class="fa fa-facebook"> </i>
                                                    </a>
                                                    <button class="btn btn-warning btn-outline btn-xs" data-toggle="tooltip" data-placement="top" title="Correo" onclick="correo('{{ $ll->nombre }}', '{{ $ll->apellido }}', '{{ $ll->correo }}')"><i class="fa fa-envelope-o"></i></button>
                                                    <a class="btn btn-warning btn-facebook btn-outline btn-xs" onclick="AgendarRecojo(' {{ $ll->prestamo_id }} ')" data-toggle="tooltip" data-placement="top" title="Agendar">
                                                        <i class="fa fa-calendar">Agendar</i>
                                                    </a>
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
                <h4 class="modal-title">Historial del Prestamo <span id = "detId">Codigo</span></h4>
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
                            <strong>Monto del Prestamo:</strong>
                        </td>
                        <td>
                            <span id="detMonto">Monto del Prestamo</span>
                        </td>
    
                    </tr>
                    <tr>
                        <td>
                            <strong>Fecha de Inicio:</strong>
                        </td>
                        <td>
                            <span id="detFecInicio">Monto del Prestamo</span>
                        </td>
    
                    </tr>
                    <tr>
                        <td>
                            <strong>Fecha de Fin:</strong>
                        </td>
                        <td>
                            <span id="detFecFin">Monto del Prestamo</span>
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

<!-- Pagar Prestamo -->
<div class="modal inmodal fade" id="vender" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Vender Garantía</h4>
                <small class="font-bold">USTED CUENTA CON EL CRÉDITO DE:</small>
            </div>
            <div class="modal-body">
                <table class="table m-b-xs">
                    <tbody>
                    <tr>
                        <td>
                            <strong>PRESTAMO</strong>
                        </td>
                        <td>
                            <span id="vendPrestamo">Modal title</span>
                        </td>
    
                    </tr>
                    <tr>
                        <td>
                            <strong>Fecha de Inicio</strong>
                        </td>
                        <td>
                            <span id="vendFecInicio">Modal title</span>
                        </td>
    
                    </tr>
                    <tr>
                        <td>
                            <strong>Fecha Fin</strong>
                        </td>
                        <td>
                            <span id="vendFecFin">Modal title</span>
                        </td>
    
                    </tr>
                    <tr>
                        <td>
                            <strong>INTERES</strong>
                        </td>
                        <td>
                            <span id="vendInteres">Modal title</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>MORA</strong>
                        </td>
                        <td class = 'bg-danger'>
                            <span id="vendMora">Modal title</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>PAGO TOTAL</strong>
                        </td>
                        <td class = 'bg-primary'>
                            <span id="vendTotal">Modal title</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>IMPORTE</strong>
                        </td>
                        <td>
                            <input style="font-size: large;" type="text" class="form-control text-success" id="idPrestamos" hidden>
                            <input style="font-size: large;" type="text" class="form-control text-success" id="montoTotal" hidden>
                            <input style="font-size: large;" type="text" class="form-control text-success" id="interesTotal" hidden>
                            <div class="col-sm-10" style='float: right; width: 150px;'><input style="font-size: large;" type="text" class="form-control text-success" id="impoPagar" placeholder="S/. 0.00"></div>
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

<!-- Agendar Recojo -->
<div class="modal inmodal fade" id="agendarRecojo" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Agendar Prestamo</h4>
                <small class="font-bold">Seleccionar la fecha de PAGO más corto:</small>
            </div>
            <div class="modal-body">
                <table class="table m-b-xs">
                    <tbody>
                    <tr>
                        <td>
                            <strong>FECHA</strong>
                        </td>
                        <td>
                            <input type="date" class="form-control" id="fechaagenda" required="" name="fechaagenda">
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="modal-footer">
                <input style="font-size: large;" type="text" class="form-control text-success" id="idPrestamosRecojo" hidden>
                <button type="button" class="btn btn-outline btn-success dim" data-dismiss="modal" onclick="postAgendarRecojo()"><i class="fa fa-calendar"></i> AGENDAR</button>
                <button type="button" class="btn btn-outline btn-danger dim"  data-dismiss="modal" onclick="postPonerVenta()"><i class="fa fa-money"></i> PARA VENTA</button>
            </div>
        </div>
    </div>
</div>
<!-- Fin Pagar -->

<!-- Lista Agendados -->
<div class="modal inmodal fade" id="listAgendados" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Lista de Agendados por Vencer</h4>
                <small class="font-bold">Esta lista de agendados vence hoy</small>
            </div>
            <div class="modal-body">
                <div class="tab-content" id="tabAgendado">
                        <div id="tab-1" class="tab-pane active">
                            <div class="full-height-scroll">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Cod</th>
                                                <th>Cliente</th>
                                                <th>DNI</th>
                                                <th>Monto Prestamo</th>
                                                <th>Valor Venta</th>
                                                <th>Fecha Agendada</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>

            <div class="modal-footer">
                <input style="font-size: large;" type="text" class="form-control text-success" id="idPrestamosRecojo" hidden>
                <button type="button" class="btn btn-outline btn-success dim" data-dismiss="modal"><i class="fa fa-check"></i> Entendido</button>
            </div>
        </div>
    </div>
</div>
<!-- Fin Pagar -->
@endsection
@section('script')
    <script>
    
        $(document).ready(cargarAlertaAgendados);
        
        function cargarAlertaAgendados(){
            $.post( "{{ Route('listaAgendados') }}", { _token:'{{csrf_token()}}'}).done(function(data) {
                if (data.aux != 0) {
                        $("#tabAgendado").empty();
                        $("#tabAgendado").html(data.view);
                        $('#listAgendados').modal('show');
                    }
            });
		}
    
        function buscarCliente(){   
            
            var dato = $("#clienteBusqueda").val();
            
            $.post( "{{ Route('buscarProdLiquidacion') }}", {dato: dato, _token:'{{csrf_token()}}'}).done(function(data) {
                $("#tabLiquidacion").empty();
                $("#tabLiquidacion").html(data.view);
                
                $("#cantLiquidacion").empty();
                $("#cantLiquidacion").html(data.cont);
            });
            
        }
    
        function Detalle(id, nombre, dni, garantia, monto, interes, mora, total, fechaInicio, fechaFin) {
            $('#detalle').modal('show');

            document.getElementById("detId").innerHTML="<p>" +id+"</p>";
            document.getElementById("detNombre").innerHTML="<p>"+nombre+"</p>";
            document.getElementById("detDni").innerHTML="<p>"+dni+"</p>";
            document.getElementById("detGarantia").innerHTML="<p style='text-align:right;'>"+garantia+"</p>";
            document.getElementById("detMonto").innerHTML="<p style='text-align:right;'>S/. "+monto+"</p>";
            document.getElementById("detInteres").innerHTML="<p style='text-align:right;'>S/. "+interes+"</p>";
            document.getElementById("detMora").innerHTML="<p style='text-align:right;'>S/. "+mora+"</p>";
            document.getElementById("detTotal").innerHTML="<p style='text-align:right;'>S/. "+total+"</p>";
            document.getElementById("detFecInicio").innerHTML="<p style='text-align:right;'> "+fechaInicio+"</p>";
            document.getElementById("detFecFin").innerHTML="<p style='text-align:right;'> "+fechaFin+"</p>";

        }
        
        function correo(nombre, apellido, correo) {
            $('#mCorreo').modal('show');

            document.getElementById("corNombreT").innerHTML="<p>" +nombre+" "+apellido+"</p>";
            document.getElementById("corDetalle").innerHTML="<p>"+correo+"</p>";

        }

        function Vender(id, monto, interes, mora, total, fechaInicio, fechaFin) {
            
            $('#vender').modal('show');
            document.getElementById("vendPrestamo").innerHTML="<p style='text-align:right;'>S/. " +monto+"</p>";
            document.getElementById("vendInteres").innerHTML="<p style='text-align:right;'>S/. "+interes+"</p>";
            document.getElementById("vendMora").innerHTML="<p style='text-align:right;'>S/. "+mora+"</p>";
            document.getElementById("vendTotal").innerHTML="<p style='text-align:right;'>S/. "+total+"</p>";
            document.getElementById("vendFecInicio").innerHTML="<p style='text-align:right;'> "+fechaInicio+"</p>";
            document.getElementById("vendFecFin").innerHTML="<p style='text-align:right;'> "+fechaFin+"</p>";
            $("#idPrestamos").val(id);
            $("#montoTotal").val(total);
            $("#interesTotal").val(interes);
                
        }
        
        function AgendarRecojo(id) {
            $("#idPrestamosRecojo").val(id);
            $('#agendarRecojo').modal('show');
        }
        
        function cancelarPago() {
            var importe = $("#impoPagar").val();
            var idPrestamo = $("#idPrestamos").val();
            var total = $("#montoTotal").val(); 
            var interes = $("#interesTotal").val();
            if(parseFloat(total) <= parseFloat(importe)){
                $.post( "{{ Route('venderGarantia') }}", {importe: importe, idPrestamo: idPrestamo, total: total, interes: interes, _token:'{{csrf_token()}}'}).done(function(data) {
                    if (data.aux == 0) {
                        alert(data.respuesta);
                    }else{
                        swal("CORRECTO", data.respuesta, "success");
                        $("#tabLiquidacion").empty();
                        $("#tabLiquidacion").html(data.view);
                    }
                });
            }else{
                swal("Error", "Por favor cancele el pago con el mínimo del monto de prestamo. \n¡GRACIAS!", "error");
            } 
        }   
        
        function postAgendarRecojo() {
            var idPrestamo = $("#idPrestamosRecojo").val();
            var fecAgendar = $("#fechaagenda").val();
            
            $.post( "{{ Route('agendarRecojo') }}", {fecAgendar: fecAgendar, idPrestamo: idPrestamo, _token:'{{csrf_token()}}'}).done(function(data) {
                    if (data.aux == 0) {
                        alert(data.aux);
                        swal("ERROR", "Debe escoger una fecha para agendar", "danger");
                    }else{
                        swal("CORRECTO", "Se agendó correctamente su pago", "success");
                        $("#tabLiquidacion").empty();
                        $("#tabLiquidacion").html(data.view);
                    }
                });
            
        }
        
        function postPonerVenta() {
            var idPrestamo = $("#idPrestamosRecojo").val();
            $.post( "{{ Route('ponerVenta') }}", {idPrestamo: idPrestamo, _token:'{{csrf_token()}}'}).done(function(data) {
                    if (data.aux == 0) {
                        alert(data.aux);
                    }else{
                        swal("CORRECTO", "Se pasó correctamente a venta", "success");
                        $("#tabLiquidacion").empty();
                        $("#tabLiquidacion").html(data.view);
                    }
                });
        }
        
    </script>
@endsection