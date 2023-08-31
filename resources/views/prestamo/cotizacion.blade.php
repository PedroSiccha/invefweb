@extends('layouts.app')
@section('pagina')
    Lista de Cotización
@endsection
@section('contenido')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Gestión de Cotización</h5>
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
                <div class="input-group">
                    <input type="text" placeholder="Buscar clientes" class="input form-control" id="clienteBusqueda" onkeyup="buscarClientes()">
                    <span class="input-group-append">
                            <button type="button" class="btn btn btn-primary"> <i class="fa fa-search"></i> Buscar</button>
                    </span>
                </div>
            </div>
            
            <div class="ibox-content" id="divListCotizacion">
                <table class="footable table table-stripped toggle-arrow-tiny">
                    <thead>
                    <tr>
                        <th data-toggle="true">Cod</th>
                        <th>Garantia</th>
                        <th>Cliente</th>
                        <th>Tipo de Prestammo</th>
                        <th>Precio</th>
                        <th>Cot. Maximo</th>
                        <th>Cot. Minimo</th>
                        <th>Fecha de Cotizacion</th>
                        <th>Action</th>
                    </tr> 
                    </thead>
                    <tbody>
                        
                    @foreach ($listCotizacion as $ls)
                        <tr>
                            <td>{{ $ls->cotizacion_id }}</td>
                            <td>{{ $ls->g_nombre }}</td>
                            <td><a class="text-blue" href="{{ Route('perfilCliente', [$ls->cliente_id]) }}">{{ $ls->cl_nombre }} {{ $ls->cl_apellido }}</a></td>
                            <td>{{ $ls->tp_nombre }}</td>
                            <td>{{ $ls->precio }}</td>
                            <td>{{ $ls->max }}</td>
                            <td>{{ $ls->min }}</td>
                            <td>{{ $ls->created_at }}</td>
                            <td>
                                
                                
                                <button type="button" class="btn btn-xs btn-danger" title="Eliminar Cotización" onclick="eliminarCotizacion('{{ $ls->garantia_id }}', '{{ $ls->cotizacion_id }}')"><i class="fa fa-trash"></i> </button>
                                
                            </td>
                        </tr>    
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="5">
                            <ul class="pagination float-right"></ul>
                        </td>
                    </tr>
                    </tfoot>
                </table>

            </div>
        </div>
    </div>
</div>

<!-- Modal Mostrar Correo -->
<div class="modal inmodal fade" id="verCorreo" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Ver Correo <span id = "detId">Codigo</span></h4>
            </div>
            <div class="modal-body" id="divModalCorreo">
                <table class="table m-b-xs">
                    <tbody>
                    <tr>
                        <td>
                            <strong>Cliente:</strong>
                        </td>
                        <td>
                            <span id="corCliente">Cliente</span>
                        </td>
    
                    </tr>
                    <tr>
                        <td>
                            <strong>Correo:</strong>
                        </td>
                        <td>
                            <span id="corCorreo">Correo</span>
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

<!-- ASIGNAR ALMACEN -->
    <div class="modal inmodal fade" id="asingAlmacen" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                    <h4 class="modal-title">Lista de Casilleros</h4>
                    <small class="font-bold">Se mostrará la lista de casilleros libres.</small>
                    <input type="text" class="form-control" id="inputGarantia" placeholder="Peso en Gramos" hidden>
                    <input type="text" class="form-control" id="inputCotizacion" placeholder="Peso en Gramos" hidden>
                </div>
                <div class="modal-body">
                    <div class="row col-md-12 col-sm-12 col-xs-12">
                        <div class="col-md-6 col-sm-4 col-xs-12 form-group has-feedback">
                            <strong>Almacen: </strong>
                            <select class="form-control m-b" name="almacen_id" id="almacen_id" onchange="buscarStand()"
                                onclick="buscarStand()">
                                <option>Seleccione un almacen...</option>
                                @foreach ($almacen as $al)
                                    <option value="{{ $al->id }}"> {{ $al->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 col-sm-4 col-xs-12 form-group has-feedback" id="listStand">
                            <strong>Stand: </strong>
                            <select class="form-control m-b" name="account" id="stand_id">
                                <option>Seleccione un almacen...</option>
                            </select>
                        </div>
                        <div class="col-md-12 col-sm-8 col-xs-12 form-group has-feedback" id="listCasillero">
                            <strong>Casillero: </strong>
                            <select class="form-control m-b" name="account" id="casillero_id">
                                <option>Seleccione un casillero...</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary" data-dismiss="modal" onclick="asignarAlmacen()">Guardar</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
    
        function verCasillerosAlmacen(garantia_id, cotizacion_id) {
            $("#inputGarantia").val(garantia_id);
            $("#inputCotizacion").val(cotizacion_id);
            $('#asingAlmacen').modal('show');
        }
        
        function buscarStand() {
            var almacen_id = $("#almacen_id").val();

            $.post("{{ Route('buscarStandCotizacion') }}", {
                almacen_id: almacen_id,
                _token: '{{ csrf_token() }}'
            }).done(function(data) {
                $("#listStand").empty();
                $("#listStand").html(data.view);
            });
        }
        
        function buscarCasillero() {
            var stand_id = $("#stand_id").val();

            $.post("{{ Route('buscarCasilleroCotizacion') }}", {
                stand_id: stand_id,
                _token: '{{ csrf_token() }}'
            }).done(function(data) {
                $("#listCasillero").empty();
                $("#listCasillero").html(data.view);
            });
        }
        
        function asignarAlmacen() {
            var garantia_id = $("#inputGarantia").val();
            var casillero_id = $("#casillero_id").val();
            var cotizacion_id = $("#inputCotizacion").val();
            var cliente_id = $("#cliente_id").val();
            var vista = "1";
            
            $.post("{{ Route('asignarCasillero') }}", {garantia_id: garantia_id, casillero_id: casillero_id, cotizacion_id: cotizacion_id, cliente_id: cliente_id, vista: vista, _token: '{{ csrf_token() }}'}).done(function(data) {
                
                swal("Correcto", "Casillero Asignado", "success");
                //toastr.success('Semáforo actualizado');
                $("#divListCotizacion").empty();
                $("#divListCotizacion").html(data.view);    
                
                
            });
        }
        
        function eliminarCotizacion(garantia_id, cotizacion_id) {
            
            swal({
              title: "¿Desea Eliminar esta cotización?",
              text: "La cotización se eliminará permanentemente",
              type: "warning",
              showCancelButton: true,
              confirmButtonClass: "btn-danger",
              confirmButtonText: "Si, eliminar!",
              closeOnConfirm: false
            },
            function(){
                
                $.post("{{ Route('eliminarCotizacion') }}", {garantia_id: garantia_id, cotizacion_id: cotizacion_id, _token: '{{ csrf_token() }}'}).done(function(data) {
                    
                    swal("Correcto", "La cotización se eliminó correctamente", "success");    
                    /*
                    if (data.aux == 1) {
                        swal("Correcto", data.resp, "success");    
                    } else {
                        swal("Error", data.resp, "error");
                    }
                    */
                    $("#divListCotizacion").empty();
                    $("#divListCotizacion").html(data.view);
                });
            });
            
        }
    
    
        function buscarClientes() {
            var dato = $("#clienteBusqueda").val();
            
            $.post( "{{ Route('buscarCotizacion') }}", {dato: dato, _token:'{{csrf_token()}}'}).done(function(data) {
                $("#divListCotizacion").empty();
                $("#divListCotizacion").html(data.view);
            });
            
        }
        /*
        function verCorreo(id, cliente) {
            $('#verCorreo').modal('show');

            document.getElementById("corCliente").innerHTML="<p style='text-align:right;'>"+cliente+"</p>";

            $.post( "{{ Route('verCorreo') }}", {id: id, _token:'{{csrf_token()}}'}).done(function(data) {

                document.getElementById("corCorreo").innerHTML="<p style='text-align:right;'>"+data.correo+"</p>";

            });
        }
        */
    </script>
@endsection
