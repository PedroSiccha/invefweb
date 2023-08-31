@extends('layouts.app')
@section('pagina')
    Gestión de Almacen
@endsection
@section('contenido')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Gestión de Almacenes</h5>
                <button type="button" class="btn btn-default btn-xs" data-toggle="tooltip" data-placement="top" title="AGREGAR ALMACEN" onclick="nuevoAlmacen()"><i class="fa fa-plus"></i></button>
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
            <div class="ibox-content" id="divAlmacen">
                <table class="footable table table-stripped toggle-arrow-tiny">
                    <thead>
                    <tr>
                        <th data-toggle="true">Código</th>
                        <th>Nombre</th>
                        <th>Dirección</th>
                        <th>Cant. Stands</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($almacen as $al)
                        <tr>
                            <td>{{ $al->almacen_id }}</td>
                            <td>{{ $al->nombre }}</td>
                            <td>{{ $al->direccion }}</td>
                            <td onclick="verCantStand('{{ $al->almacen_id }}')">{{ $al->cantstand }}</td>
                            <td>
                                <button type="button" class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="top" title="AGREGAR STAND" onclick="nuevoStand(' {{ $al->cantstand }} ', ' {{ $al->direccion }} ', '{{ $al->almacen_id }}')"><i class="fa fa-columns"></i></button>
                                <button type="button" class="btn btn-primary btn-xs" data-toggle="tooltip" data-placement="top" title="AGREGAR CASILLERO" onclick="nuevoCasillero(' {{ $al->cantstand }} ', ' {{ $al->direccion }} ', '{{ $al->almacen_id }}')"><i class="fa fa-archive"></i></button>
                                <button type="button" class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="top" title="ELIMINAR"><i class="fa fa-minus"></i></button>
                                <button type="button" class="btn btn-warning btn-xs" data-toggle="tooltip" data-placement="top" title="EDITAR" onclick="editarAlmacen('{{ $al->almacen_id }}', '{{ $al->nombre }}')"><i class="fa fa-pencil"></i></button>
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

<!-- Nuevo Stand -->
<div class="modal inmodal fade" id="nuevoStand" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Crear Nuevo Stand</h4>
                <small class="font-bold">Cantidad de Stands: <span id="numStand">numStand</span></small>
            </div>
            <div class="modal-body">
                <table class="table m-b-xs">
                    <tbody>
                    <tr hidden>
                        <td>
                            <strong>idAlmacen</strong>
                        </td>
                        <td>
                            <span id="idAlmacenNS">idAlmacen</span>
                        </td>
    
                    </tr>
                    <tr>
                        <td>
                            <strong>Almacen</strong>
                        </td>
                        <td>
                            <span id="dirAlmacen">almacen</span>
                        </td>
    
                    </tr>
                    <tr>
                        <td>
                            <strong>Nombre Stand</strong>
                        </td>
                        <td>
                            <input type="text" class="form-control text-success" id="nomStand" placeholder="Stand 1">
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            <strong>Detalle</strong>
                        </td>
                        <td>
                            <input type="text" class="form-control text-success" id="detStand" placeholder="Articulos Pequeños">
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-success btn-lg" onclick="crearStand()">Guardar</button>
                <button type="button" class="btn btn-danger btn-lg" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- Fin Stand -->
<!-- Nuevo Casillero -->
<div class="modal inmodal fade" id="nuevoCasillero" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Crear Nuevo Stand</h4>
                <small class="font-bold">Cantidad de Stands: <span id="numStand">numStand</span></small>
            </div>
            <div class="modal-body">
                <table class="table m-b-xs">
                    <tbody>
                    <tr hidden>
                        <td>
                            <strong>idAlmacen</strong>
                        </td>
                        <td>
                            <span id="idAlmacenNC">idAlmacen</span>
                        </td>
    
                    </tr>
                    <tr>
                        <td>
                            <strong>Almacen</strong>
                        </td>
                        <td>
                            <span id="dirAlmacenC">almacen</span>
                        </td>
    
                    </tr>
                    <tr>
                        <td>
                            <strong>Seleccionar Stand</strong>
                        </td>
                        <td id="cbStand">
                            
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            <strong>Codigo de Casillero</strong>
                        </td>
                        <td>
                            <input type="text" class="form-control text-success" id="nomCasillero" placeholder="Cn">
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <strong>Detalle</strong>
                        </td>
                        <td>
                            <input type="text" class="form-control text-success" id="detCasillero" placeholder="Casillero n">
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="modal-footer">
                    <button type="button" class="btn btn-success btn-lg" onclick="crearCasillero()">Guardar</button>
                    <button type="button" class="btn btn-danger btn-lg" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- Fin Casillero -->

<!-- Nuevo Almacen -->
<div class="modal inmodal fade" id="nuevoAlmacen" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Crear Nuevo Almacen</h4>
            </div>
            <div class="modal-body">
                <table class="table m-b-xs">
                    <tbody>
                    <tr>
                        <td>
                            <strong>Nombre de Almacen</strong>
                        </td>
                        <td>
                            <input type="text" class="form-control text-success" id="nomAlmacen" placeholder="Almacen...">
                        </td>
    
                    </tr>
                    <tr>
                        <td>
                            <strong>Dirección</strong>
                        </td>
                        <td>
                            <select class="form-control m-b" name="cbDepartamento" id="cbDepartamento" onclick="verProvincia()" onchange="verProvincia()">
                                <option>Seleccione Departamento...</option>
                                @foreach ($departamento as $de)
                                <option value="{{ $de->id }}">{{ $de->departamento }}</option>    
                                @endforeach
                                
                            </select>

                            <select class="form-control m-b" name="cbProvincia" id="cbProvincia" onclick="verDistrito()" onchange="verDistrito()">
                                <option>Seleccione Provincia ...</option>
                            </select>

                            <select class="form-control m-b" name="cbDistrito" id="cbDistrito">
                                <option>Seleccione Distrito ...</option>
                            </select>

                            <input type="text" class="form-control text-success" id="dirAlmacenS" placeholder="Direccion...">
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-success btn-lg" onclick="guardarAlmacen()">Guardar</button>
                <button type="button" class="btn btn-danger btn-lg" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- Fin Almacen -->
<!-- Modal Editar Almacen -->
<div class="modal inmodal fade" id="editarAlmacen" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Editar Almacen</h4>
                <small class="font-bold">Codigo de Almacen: <span id="eAlmacen_id">numStand</span></small>
            </div>
            <div class="modal-body">
                <table class="table m-b-xs">
                    <tbody>
                    <tr>
                        <td>
                            <strong>Nombre</strong>
                        </td>
                        <td>
                            <input type="text" class="form-control text-success" id="eNombreA" placeholder="Nombre de Almacen">
                            <input type="text" class="form-control text-success" id="eIdAlmacenA" placeholder="Nombre de Almacen" hidden>
                        </td>
    
                    </tr>
                    <tr>
                        <td>
                            <strong>Departamento</strong>
                        </td>
                        <td>
                            <select class="form-control m-b" name="eDepartamentoA" id="eDepartamentoA">
                                <option>Seleccione Departamento...</option>
                                @foreach ($departamento as $de)
                                <option value="{{ $de->id }}">{{ $de->departamento }}</option>    
                                @endforeach
                                
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Provincia</strong>
                        </td>
                        <td>
                            <select class="form-control m-b" name="eProvinciaA" id="eProvinciaA">
                                <option>Seleccione Provincia...</option>
                                @foreach ($provincia as $p)
                                <option value="{{ $p->id }}">{{ $p->provincia }}</option>    
                                @endforeach
                                
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Distrito</strong>
                        </td>
                        <td>
                            <select class="form-control m-b" name="eDistritoA" id="eDistritoA">
                                <option>Seleccione Distrito...</option>
                                @foreach ($distrito as $d)
                                <option value="{{ $d->id }}">{{ $d->distrito }}</option>    
                                @endforeach
                                
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Direccion</strong>
                        </td>
                        <td>
                            <input type="text" class="form-control text-success" id="eDireccionA" placeholder="Direccion de Almacen">
                        </td>
    
                    </tr>
                    <tr>
                        <td>
                            <strong>Referencia</strong>
                        </td>
                        <td>
                            <input type="text" class="form-control text-success" id="eReferenciaA" placeholder="Referencia de Almacen">
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-success btn-lg" onclick="editarA()">Guardar</button>
                <button type="button" class="btn btn-danger btn-lg" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Cantidad de Casillera -->
<div class="modal inmodal fade" id="modalCantCasillero" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Mostrar Cantidad de Casilleros</h4>
            </div>
            <div class="modal-body" id="divCantCasillero">
                
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-success btn-lg" data-dismiss="modal">Aceptar</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script src="{{ asset('js/plugins/footable/footable.all.min.js') }}"></script>
    <script>

        function nuevoStand(cantidad, direccion, id) {
            $('#nuevoStand').modal('show');
                document.getElementById("numStand").innerHTML="<p>" +cantidad+"</p>";
                document.getElementById("dirAlmacen").innerHTML="<p>"+direccion+"</p>";
                document.getElementById("idAlmacenNS").innerHTML="<input type='text' class='form-control text-success' id='nalmacen_id' value='"+id+"'>";
        }


        function crearStand() {
            var nombre = $("#nomStand").val();
            var detalle = $("#detStand").val();
            var almacen_id = $("#nalmacen_id").val();
            swal({
                    title: "Crear Stand",
                    text: "Nombre de Stand:"+nombre+"\nCodigo de Almacen: "+almacen_id,
                    type: "info",
                    showCancelButton: true,
                    confirmButtonColor: "#3366FF",
                    confirmButtonText: "Aceptar",
                    closeOnConfirm: false
                }, function () {
                    $.post( "{{ Route('guardarStand') }}", {almacen_id: almacen_id, nombre: nombre, detalle: detalle, _token:'{{csrf_token()}}'}).done(function(data) {
                        $("#divAlmacen").empty();
                        $("#divAlmacen").html(data.view);
                    });
                    $('#nuevoStand').modal('hide');
                    swal("Correcto", "El Stand: " +nombre+", fué creado exitosamente", "success");
                });
        }

        function nuevoCasillero(cantidad, direccion, id) {

            $.post( "{{ Route('cargarStand') }}", {id: id, _token:'{{csrf_token()}}'}).done(function(data) {
                    $("#cbStand").empty();
                    $("#cbStand").html(data.view);
                  });

            $('#nuevoCasillero').modal('show');
                document.getElementById("numStand").innerHTML="<p>" +cantidad+"</p>";
                document.getElementById("dirAlmacenC").innerHTML="<p>"+direccion+"</p>";
                document.getElementById("idAlmacenNC").innerHTML="<input type='text' class='form-control text-success' id='ncalmacen_id' value='"+id+"'>";
        }

        function crearCasillero() {
            var nombre = $("#nomCasillero").val();
            var detalle = $("#detCasillero").val();
            var stand_id = $("#sstand_id").val();
            swal({
                    title: "Crear Casillero",
                    text: "Nombre de Casillero:"+nombre+"\nCodigo de Stand: "+stand_id,
                    type: "info",
                    showCancelButton: true,
                    confirmButtonColor: "#3366FF",
                    confirmButtonText: "Aceptar",
                    closeOnConfirm: false
                }, function () {
                    $.post( "{{ Route('guardarCasillero') }}", {stand_id: stand_id, nombre: nombre, detalle: detalle, _token:'{{csrf_token()}}'}).done(function(data) {
                        $("#divAlmacen").empty();
                        $("#divAlmacen").html(data.view);
                    });
                    $('#nuevoCasillero').modal('hide');
                    swal("Correcto", "El Casillero: " +nombre+", fué creado exitosamente", "success");
                });
        }

        function nuevoAlmacen() {
            $('#nuevoAlmacen').modal('show');
        }

        function guardarAlmacen() {
            var nombre = $("#nomAlmacen").val();
            var direccion = $("#dirAlmacenS").val();
            var distrito_id = $("#cbDistrito").val();

            swal({
                    title: "Crear Almacen",
                    text: "Crear nuevo almacen:"+nombre+"\nCon la dirección: "+direccion,
                    type: "info",
                    showCancelButton: true,
                    confirmButtonColor: "#3366FF",
                    confirmButtonText: "Aceptar",
                    closeOnConfirm: false
                }, function () {
                    $.post( "{{ Route('guardarAlmacen') }}", {nombre: nombre, direccion: direccion, distrito_id: distrito_id, _token:'{{csrf_token()}}'}).done(function(data) {
                        $("#divAlmacen").empty();
                        $("#divAlmacen").html(data.view);
                    });
                    swal("Correcto", "El almacen" +nombre+", fué creado correctamente", "success");
                    $('#nuevoAlmacen').modal('hide');
                });
        }

        function verProvincia(){
            var departamento_id = $("#cbDepartamento").val();
            
            $.post( "{{ Route('verProvinciaAlmacen') }}", {departamento_id: departamento_id, _token:'{{csrf_token()}}'}).done(function(data) {
                $("#cbProvincia").empty();
                $("#cbProvincia").html(data.view);
            });
        }

        function verDistrito(){
            var provincia_id = $("#cbProvincia").val();
            
            $.post( "{{ Route('verDistritoAlmacen') }}", {provincia_id: provincia_id, _token:'{{csrf_token()}}'}).done(function(data) {
                $("#cbDistrito").empty();
                $("#cbDistrito").html(data.view);
            });
        }
        function editarAlmacen(id) {
            $('#editarAlmacen').modal('show');

            $.post( "{{ Route('cargarAlmacen') }}", {id: id, _token:'{{csrf_token()}}'}).done(function(data) {
                $("#eIdAlmacenA").val(data.almacen_id);
                $("#eNombreA").val(data.nombre);
                $("#eDireccionA").val(data.direccion);
                $("#eReferenciaA").val(data.referencia);
                $("#eDistritoA").val(data.distrito_id);
                $("#eProvinciaA").val(data.provincia_id);
                $("#eDepartamentoA").val(data.departamento_id);

            });
            
        }

        function editarA() {
            var almacen_id = $("#eIdAlmacenA").val();
            var nombre = $("#eNombreA").val();
            var direccion = $("#eDireccionA").val();
            var referencia = $("#eReferenciaA").val();
            var distrito_id = $("#eDistritoA").val();
            var provincia_id = $("#eProvinciaA").val();
            var departamento_id = $("#eDepartamentoA").val();
            
            $.post( "{{ Route('editarAlmacen') }}", {almacen_id: almacen_id, nombre: nombre, direccion: direccion, referencia: referencia, distrito_id: distrito_id, provincia_id: provincia_id, departamento_id: departamento_id, _token:'{{csrf_token()}}'}).done(function(data) {
                $("#divAlmacen").empty();
                $("#divAlmacen").html(data.view);
                $('#editarAlmacen').modal('hide');
            });
        }

        function verCantStand(almacen_id) {
            $('#modalCantCasillero').modal('show');

            $.post( "{{ Route('mostrarCantCasulleros') }}", {almacen_id: almacen_id, _token:'{{csrf_token()}}'}).done(function(data) {
                $("#divCantCasillero").empty();
                $("#divCantCasillero").html(data.view);
            });
        }
    </script>
@endsection