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
                    <span class="float-right small text-muted">0 Productos</span>
                    <ul class="nav nav-tabs">
                        <li><a class="nav-link active" data-toggle="tab" href="#tab-1"><i class="fa fa-user"></i></a></li>
                    </ul>
                    <div class="tab-content" id="tabLiquidacion">
                        <div id="tab-1" class="tab-pane active">
                            <div class="full-height-scroll">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Cod</th>
                                                <th>Cliente</th>
                                                <th>DNI</th>
                                                <th>Garantia</th>
                                                <th>Monto Prestamo</th>
                                                <th>Valor Venta</th>
                                                <th>Administración</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($listLiquidacion as $ll)
                                            <tr>
                                                <td>{{ $ll->prestamo_id }}</td>
                                                <td><a href="{{ Route('perfilCliente', [$ll->cliente_id]) }}">{{ $ll->nombre }}{{ $ll->apellido }}</a></td>
                                                <td>{{ $ll->dni }}</td>
                                                <td>{{ $ll->garantia }}</td>
                                                <td>{{ $ll->monto }}</td>
                                                <td>{{ $ll->total }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-success btn-xs" onclick="Vender(' {{ $ll->prestamo_id }} ', ' {{ $ll->monto }} ', ' {{ $ll->interes }} ', ' {{ $ll->mora }} ', ' {{ $ll->total }} ')" data-toggle="tooltip" data-placement="top" title="VENDER GARANTÍA"><i class="fa fa-money"></i></button><button type="button" class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="top" title="HISTORIAL DEL PRESTAMO" onclick="Detalle(' {{ $ll->prestamo_id }} ', '{{ $ll->nombre }} {{ $ll->apellido }}', '{{ $ll->dni }}', '{{ $ll->garantia }}', '{{ $ll->monto }}', '{{ $ll->interes }}', '{{ $ll->mora }}', ' {{ $ll->total }} ')"><i class="fa fa-desktop"></i></button>    
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
@endsection
@section('script')
    <script>
        function Detalle(id, nombre, dni, garantia, monto, interes, mora, total) {
            $('#detalle').modal('show');

            document.getElementById("detId").innerHTML="<p>" +id+"</p>";
            document.getElementById("detNombre").innerHTML="<p>"+nombre+"</p>";
            document.getElementById("detDni").innerHTML="<p>"+dni+"</p>";
            document.getElementById("detGarantia").innerHTML="<p style='text-align:right;'>"+garantia+"</p>";
            document.getElementById("detMonto").innerHTML="<p style='text-align:right;'>S/. "+monto+"</p>";
            document.getElementById("detInteres").innerHTML="<p style='text-align:right;'>S/. "+interes+"</p>";
            document.getElementById("detMora").innerHTML="<p style='text-align:right;'>S/. "+mora+"</p>";
            document.getElementById("detTotal").innerHTML="<p style='text-align:right;'>S/. "+total+"</p>";

        }

        function Vender(id, monto, interes, mora, total) {
            
            $('#vender').modal('show');
            document.getElementById("vendPrestamo").innerHTML="<p style='text-align:right;'>S/. " +monto+"</p>";
            document.getElementById("vendInteres").innerHTML="<p style='text-align:right;'>S/. "+interes+"</p>";
            document.getElementById("vendMora").innerHTML="<p style='text-align:right;'>S/. "+mora+"</p>";
            document.getElementById("vendTotal").innerHTML="<p style='text-align:right;'>S/. "+total+"</p>";
            $("#idPrestamos").val(id);
            $("#montoTotal").val(total);
                
        }
        
        function cancelarPago() {
            var importe = $("#impoPagar").val();
            var idPrestamo = $("#idPrestamos").val();
            var total = $("#montoTotal").val();

            if(parseFloat(total) <= parseFloat(importe)){

                $.post( "{{ Route('venderGarantia') }}", {importe: importe, idPrestamo: idPrestamo, total: total, _token:'{{csrf_token()}}'}).done(function(data) {
                    if (data.aux == 0) {
                        alert(data.aux);
                    }else{
                        swal("CORRECTO", "La venta se realizó correctamente", "success");
                        $("#tabLiquidacion").empty();
                        $("#tabLiquidacion").html(data.view);
                    }
                    
                });

            }else{

                swal("Error", "Por favor cancele el pago con el mínimo del monto de prestamo. \n¡GRACIAS!", "error");

            }

            
        }   
    </script>
@endsection