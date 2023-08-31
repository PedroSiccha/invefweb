@extends('layouts.app')
@section('pagina')
    Lista de Bancos
@endsection
@section('contenido')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Lista de Bancos Autorizados</h5>
                <a class="btn btn-white btn-bitbucket" onclick="nuevoBanco()">
                    <i class="fa fa-plus"></i>
                </a>
                <a class="btn btn-success btn-bitbucket" onclick="iniciarBanco()">
                    <i class="fa fa-plus" style="color: white;"></i> <small style="color: white;">Iniciar Bancos</small>
                </a>
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
                    <input type="text" placeholder="Buscar banco" class="input form-control" id="bancoBusqueda" onkeyup="buscarBanco()">
                    <span class="input-group-append">
                            <button type="button" class="btn btn btn-primary"> <i class="fa fa-search"></i> Buscar</button>
                    </span>
                </div>
            </div>
            
            <div class="ibox-content" id="divListBancos">
                <table class="footable table table-stripped toggle-arrow-tiny">
                    <thead>
                    <tr>
                        <th data-toggle="true">Cod</th>
                        <th>Banco</th>
                        <th>Cuenta</th>
                        <th>Action</th>
                    </tr> 
                    </thead>
                    <tbody>
                        
                    @foreach ($listBanco as $lb)
                        <tr>
                            <td>{{ $lb->id }}</td>
                            <td>{{ $lb->tipo }}</td>
                            <td>{{ $lb->detalle }}</td>
                            <td>
                                
                                <button type="button" class="btn btn-xs btn-warning" title="Editar Banco" onclick="verBanco('{{ $lb->id }}', '{{ $lb->tipo }}', '{{ $lb->detalle }}')"><i class="fa fa-pencil"></i> </button>
                                
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
    
    <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Bancos de mi Sucursal</h5>
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
                    <input type="text" placeholder="Buscar banco" class="input form-control" id="bancoBusqueda" onkeyup="buscarBanco()">
                    <span class="input-group-append">
                            <button type="button" class="btn btn btn-primary"> <i class="fa fa-search"></i> Buscar</button>
                    </span>
                </div>
            </div>
            
            <div class="ibox-content" id="divListMisBancos">
                <table class="footable table table-stripped toggle-arrow-tiny">
                    <thead>
                    <tr>
                        <th data-toggle="true">Cod</th>
                        <th>Banco</th>
                        <th>Cuenta</th>
                        <th>Monto</th>
                    </tr> 
                    </thead>
                    <tbody>
                        
                    @foreach ($misBancos as $mb)
                        <tr>
                            <td>{{ $mb->id }}</td>
                            <td>{{ $mb->tipo }}</td>
                            <td>{{ $mb->detalle }}</td>
                            <td>{{ $mb->monto }}</td>
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

<!-- Modal Nuevo Banco -->
<div class="modal inmodal" id="aIniciarBanco" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated flipInY">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Iniciar Banco</h4>
            </div>
            <div class="modal-body">
                <div class="col-lg-12">
                    <select class="form-control m-b" name="nombreAsignarBanco" id="nombreAsignarBanco">
                        <option>Seleccionar un banco...</option>
                        @foreach ($listBanco as $lb)
                        <option value="{{ $lb->tipocaja_id }}">{{ $lb->tipo }}</option>
                        @endforeach
                    </select>
                </div>
                <br>
                <input type="text" class="form-control has-feedback-left" id="montoAsignarBanco" placeholder="Asignar Monto de Banco">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="asignarMontoBanco()">Guardar</button>
            </div>
        </div>
    </div>
</div>
<!-- Fin Modal Nuevo Banco -->

<!-- Modal Nuevo Banco -->
<div class="modal inmodal" id="mNuevoBanco" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated flipInY">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Nuevo Banco</h4>
            </div>
            <div class="modal-body">
                <input type="text" class="form-control has-feedback-left" id="inputNombre" placeholder="Nombre del Banco">
                <br>
                <input type="text" class="form-control has-feedback-left" id="inputDetalle" placeholder="Detalle del Banco">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="crearBanco()">Guardar</button>
            </div>
        </div>
    </div>
</div>
<!-- Fin Modal Nuevo Banco -->



<!-- Modal Editar Banco -->
<div class="modal inmodal" id="mEditarBanco" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated flipInY">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Actualizar Banco</h4>
            </div>
            <div class="modal-body">
                <input type="text" class="form-control has-feedback-left" id="inputBancoId" hidden>
                <br>
                <input type="text" class="form-control has-feedback-left" id="inputNombreEdit" placeholder="Nombre del Banco">
                <br>
                <input type="text" class="form-control has-feedback-left" id="inputDetalleEdit" placeholder="Detalle del Banco">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="editarBanco()">Guardar</button>
            </div>
        </div>
    </div>
</div>
<!-- Fin Modal Editar Banco -->

<!-- Modal Asignar Capital -->
<div class="modal inmodal" id="mAsignarCapital" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated flipInY">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Actualizar Banco</h4>
            </div>
            <div class="modal-body">
                <input type="text" class="form-control has-feedback-left" id="inputTipoBancoId" hidden>
                <br>
                <input type="text" class="form-control has-feedback-left" id="inputCapital" placeholder="Asignar Capital al Banco">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="guardarCapital()">Guardar</button>
            </div>
        </div>
    </div>
</div>
<!-- Fin Modal Asignar Capital -->

@endsection
@section('script')
    <script>
    
        function iniciarBanco() {
            $('#aIniciarBanco').modal('show');
        }
        
        function asignarMontoBanco() {
            var banco_id = $("#nombreAsignarBanco").val();
            var capital = $("#montoAsignarBanco").val();
            
            $.post("{{ Route('asignarCapital') }}", {banco_id: banco_id, capital: capital, _token: '{{ csrf_token() }}'}).done(function(data) {
                if (data.resp == 1) {
                    swal("Correcto", "Se agrego el capital para el banco", "success");    
                } else {
                    swal("Error", "La sucursal ya cuenta con este banco", "error");
                }
                
                $("#divListBancos").empty();
                $("#divListBancos").html(data.view);   
                
                $("#divListMisBancos").empty();
                $("#divListMisBancos").html(data.viewMisBancos);    
            });
        }
    
        function asignarCapital(banco_id) {
            $("#inputTipoBancoId").val(banco_id);
            $('#mAsignarCapital').modal('show');
        }
        
        function guardarCapital() {
            var banco_id = $("#inputTipoBancoId").val();
            var capital = $("#inputCapital").val();
            
            $.post("{{ Route('asignarCapital') }}", {banco_id: banco_id, capital: capital, _token: '{{ csrf_token() }}'}).done(function(data) {
                swal("Correcto", "Se agrego el capital para el banco", "success");
                $("#divListBancos").empty();
                $("#divListBancos").html(data.view);   
                
                $("#divListMisBancos").empty();
                $("#divListMisBancos").html(data.viewMisBancos);    
            });
        }
    
        function verBanco(banco_id, nombre, detalle) {
            $("#inputBancoId").val(banco_id);
            $("#inputNombreEdit").val(nombre);
            $("#inputDetalleEdit").val(detalle);
            $('#mEditarBanco').modal('show');
        }
        
        function nuevoBanco() {
            $('#mNuevoBanco').modal('show');
        }
        
        function editarBanco() {
            var banco_id = $("#inputBancoId").val();
            var nombreBanco = $("#inputNombreEdit").val();
            var detalleBanco = $("#inputDetalleEdit").val();
            
            $.post("{{ Route('editarBanco') }}", {banco_id: banco_id, nombreBanco: nombreBanco, detalleBanco: detalleBanco, _token: '{{ csrf_token() }}'}).done(function(data) {
                
                swal("Correcto", "Se modificó el banco", "success");
                //toastr.success('Semáforo actualizado');
                $("#divListBancos").empty();
                $("#divListBancos").html(data.view);    
                
                
            });
        }
        
        function crearBanco() {
            var nombreBanco = $("#inputNombre").val();
            var detalleBanco = $("#inputDetalle").val();
            
            $.post("{{ Route('crearBanco') }}", {nombreBanco: nombreBanco, detalleBanco: detalleBanco, _token: '{{ csrf_token() }}'}).done(function(data) {
                
                swal("Correcto", "Banco creado correctamente", "success");
                //toastr.success('Semáforo actualizado');
                $("#divListBancos").empty();
                $("#divListBancos").html(data.view);    
                
                
            });
        }
        
        function eliminarBanco(banco_id) {
            
            swal({
              title: "¿Desea Eliminar este banco?",
              text: "El banco se eliminará permanentemente",
              type: "warning",
              showCancelButton: true,
              confirmButtonClass: "btn-danger",
              confirmButtonText: "Si, eliminar!",
              closeOnConfirm: false
            },
            function(){
                
                $.post("{{ Route('eliminarBanco') }}", {banco_id: banco_id, _token: '{{ csrf_token() }}'}).done(function(data) {
                    
                    swal("Correcto", "El banco se eliminó correctamente", "success");    
                    /*
                    if (data.aux == 1) {
                        swal("Correcto", data.resp, "success");    
                    } else {
                        swal("Error", data.resp, "error");
                    }
                    */
                    $("#divListBancos").empty();
                    $("#divListBancos").html(data.view);
                });
            });
            
        }
    
    
        function buscarBanco() {
            var dato = $("#bancoBusqueda").val();
            
            $.post( "{{ Route('buscarBanco') }}", {dato: dato, _token:'{{csrf_token()}}'}).done(function(data) {
                $("#divListBancos").empty();
                $("#divListBancos").html(data.view);
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
