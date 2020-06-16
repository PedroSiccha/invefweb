@extends('layouts.app')
@section('pagina')
    Buscar Garantías
@endsection
@section('contenido')
<div class="row">

    <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Vista de Almacenes</h5>
                <p class="text-success">Cantidad de Garantias Almacenadas: {{ $cantGarantia[0]->cantGarantia }}</p>
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
            <div class="ibox-content" id="almacen">
                <div class="panel-body">
                    <div class="panel-group" id="accordion">
                        @foreach ($almacen as $a)
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h5 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $a->almacen_id }}" onclick="mostrarStand('{{ $a->almacen_id }}')">{{ $a->nombre }} - {{ $a->direccion }}</a>
                                    </h5>
                                </div>
                                <div id="collapse{{ $a->almacen_id }}" class="panel-collapse collapse in">
                                    <div class="panel-body" id="divMostrarStand_{{ $a->almacen_id }}">
                                        {{ $a->almacen_id }}
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
@endsection

<!-- Cerrar Caja -->
<div class="modal inmodal fade" id="recoger" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Recoger Garantia</h4>
                <small class="font-bold"><span id="garantiaR"></span></small>
            </div>
            <div class="modal-body">
                <input type="text" class="form-control text-success" id="idCajaC" hidden>
                <input type="text" class="form-control text-success" id="montoFinC" hidden>
                
                <table class="table m-b-xs">
                    <tbody>
                    <tr>
                        <td>
                            <strong>CLIENTE</strong>
                            <input style="font-size: large;" type="text" class="form-control text-success" id="idR" hidden>
                        </td>
                        <td>
                            <span id="clienteR">almacen</span>
                        </td>
    
                    </tr>
                    <tr>
                        <td>
                            <strong>Ingrese DNI</strong>
                        </td>
                        <td id="cbStand">
                            <div class="col-sm-10" ><input style="font-size: large;" type="text" class="form-control text-success" id="dniR" placeholder="Ingrese DNI"></div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-outline btn-success dim" data-dismiss="modal" onclick="recoger()"><i class="fa fa-money"></i> Recoger</button>
            </div>
        </div>
    </div>
</div>

<!-- No Liberar Casillero -->
<div class="modal inmodal fade" id="modalNoLiberar" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Estado Garantia</h4>
                <small class="font-bold"><span id="garantiaR"></span></small>
            </div>
            <div class="modal-body" id="divModalNoLiberar">
                
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-outline btn-success dim" data-dismiss="modal"><i class="fa fa-money"></i> OK</button>
            </div>
        </div>
    </div>
</div>

<!-- Liberar Casillero -->
<div class="modal inmodal fade" id="modalLiberar" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Recoger Garantia</h4>
                <small class="font-bold"><span id="garantiaR"></span></small>
            </div>
            <div class="modal-body" id="divModalLiberar">
                <input type="text" class="form-control text-success" id="idCajaC" hidden>
                <input type="text" class="form-control text-success" id="montoFinC" hidden>

                <table class="table m-b-xs">
                    <tbody>
                    <tr>
                        <td>
                            <strong>Cliente</strong>
                            <input style="font-size: large;" type="text" class="form-control text-success" id="prestamo_id_Liberar" hidden>
                        </td>
                        <td>
                            <span id="cliente_Liberar">almacennn</span>
                        </td>

                    </tr>
                    <tr>
                        <td>
                            <strong>Ingrese DNI</strong>
                        </td>
                        <td id="cbStand">
                            <div class="col-sm-10" ><input style="font-size: large;" type="text" class="form-control text-success" id="dni_Liberar" placeholder="Ingrese DNI"></div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-outline btn-success dim" data-dismiss="modal" onclick="recoger()"><i class="fa fa-money"></i> Recoger</button>
            </div>
        </div>
    </div>
</div>

@section('script')
    <script>
        function mostrarStand(almacen_id) {
            
            $.post( "{{ Route('mostrarStand') }}", {almacen_id: almacen_id, _token:'{{csrf_token()}}'}).done(function(data) {
                    $("#divMostrarStand_"+almacen_id).empty();
                    $("#divMostrarStand_"+almacen_id).html(data.view);
                });
        }

        function mostrarCasillero(stand_id) {
            $.post( "{{ Route('mostrarCasillero') }}", {stand_id: stand_id, _token:'{{csrf_token()}}'}).done(function(data) {
                    if (data.resp == 1) {
                        alert('No existen casilleros');
                    }else{
                        $("#divMostrarCasilleros_"+stand_id).empty();
                        $("#divMostrarCasilleros_"+stand_id).html(data.view);
                    }
                        
                });
        }

        function liberarStand(casillero_id) {
            $.post( "{{ Route('liberarStand') }}", {casillero_id: casillero_id, _token:'{{csrf_token()}}'}).done(function(data) {
                        if (data.resp == 0) {
                            alert('Libre');
                        }else if(data.resp == 1){
                            $('#modalNoLiberar').modal('show');
                            $("#divModalNoLiberar").empty();
                            $("#divModalNoLiberar").html(data.view);
                        }else {
                            $('#modalLiberar').modal('show');
                            $("#prestamo_id_Liberar").val(data.prestamo_id);
                            document.getElementById("cliente_Liberar").innerHTML="<p style='text-align:center;'>" +data.cliente+"</p>";
                        }
                });
        }

        function recoger(){
            
            var dni = $("#dni_Liberar").val();
            var id = $("#prestamo_id_Liberar").val();

            $.post( "{{ Route('recogerGarantia') }}", {dni: dni, id: id, _token:'{{csrf_token()}}'}).done(function(data) {
                
                setTimeout(function() {
                    toastr.options = {
                        closeButton: true,
                        progressBar: true,
                        showMethod: 'slideDown',
                        timeOut: 4000,
                        positionClass: 'toast-top-center'
                    };
                    toastr.info(data.mensaje, "FINALIZAR");
                }, 1300);
                /*
                $("#divGarantiaAlmacen").empty();
                $("#divGarantiaAlmacen").html(data.view);
                */
            });
            $('#modalLiberar').modal('hide');
        }

        function eliminarCasillero(casillero_id) {
            $.post( "{{ Route('eliminarCasillero') }}", {casillero_id: casillero_id, _token:'{{csrf_token()}}'}).done(function(data) {
                    
                });
        }
    </script>
@endsection
