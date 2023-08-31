@extends('layouts.app')
@section('pagina')
    Control de Seguridad
@endsection
@section('contenido')
<div class="wrapper wrapper-content  animated fadeInRight">
    <div class="row">
        <div class="col-sm-6">
            <div class="ibox">
                <div class="ibox-content">
                    <span class="text-muted small float-right">Ultima Modificación: <i class="fa fa-clock-o"></i> {{date( "g:i a") }} - {{ date("d/m/Y")}}</span>
                    <h2>Tipo de Usuario</h2>
                    <p>
                        Roles de empleados.
                    </p>
                    <div class="input-group">
                        <input type="text" placeholder="Buscar codigo de empleados... " class="input form-control" id="clienteBusqueda" onkeyup="buscarCliente()">
                        <span class="input-group-append">
                                <button type="button" class="btn btn btn-primary"> <i class="fa fa-search"></i> Buscar</button>
                        </span>
                    </div>
                    <div class="clients-list">
                    <span class="float-right small text-muted">0 Productos</span>
                    <ul class="nav nav-tabs">
                        <li><a class="nav-link active" onclick="nuevoRol()"><i class="fa fa-plus"></i></a></li>
                    </ul>
                    <div class="tab-content" id="tabCliente">
                        <div id="tab-1" class="tab-pane active">
                            <div class="full-height-scroll">
                                <div class="table-responsive"  id="listRoles">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Cod.</th>
                                                <th>Tipo de Usuario</th>
                                                <th>Administración</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($roles as $ro)
                                            <tr onclick="verMenu('{{ $ro->id }}')">
                                                <td> {{ $ro->id }} </td>
                                                <td> {{ $ro->nombre }} </td>
                                                <td>
                                                    <button type="button" class="btn btn-primary" onclick="mostrarPermisos('{{ $ro->id }}', '{{ $ro->nombre }}')"><i class="fa fa-id-badge"></i></button>
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

        <div class="col-sm-6">
            <div class="ibox">
                <div class="ibox-content">
                    <span class="text-muted small float-right">Ultima Modificación: <i class="fa fa-clock-o"></i> {{date( "g:i a") }} - {{ date("d/m/Y")}}</span>
                    <div id="divTitulo">
                        <h2>Funciones</h2>
                        <input type="text" class="input form-control" id="inputIdRol" hidden>
                        <p>
                            Permisos de empleados.
                        </p>    
                    </div>
                    <div class="input-group">
                        <input type="text" placeholder="Buscar codigo de empleados... " class="input form-control" id="clienteBusqueda" onkeyup="buscarCliente()">
                        <span class="input-group-append">
                                <button type="button" class="btn btn btn-primary"> <i class="fa fa-search"></i> Buscar</button>
                        </span>
                    </div>
                    <div class="clients-list">
                    <span class="float-right small text-muted">0 Productos</span>
                    <ul class="nav nav-tabs">
                        <li><a class="nav-link active" data-toggle="tab" href="#tab-1"><i class="fa fa-user"></i></a></li>
                        <li onclick="eliminarPermiso()"><a class="nav-link"><i class="fa fa-trash"></i></a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="tab-1" class="tab-pane active">
                            <div class="full-height-scroll">
                                <div class="table-responsive"  id="tabLista">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Cod.</th>
                                                <th>Menu</th>
                                                <th>Rol</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($menuRols as $pe)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" class="i-checks flat chekboxses" name="idMenuRol[]" value="{{ $pe->menurol_id }}" id="idMenuRol">
                                                </td>
                                                <td> {{ $pe->menurol_id }} </td>
                                                <td> {{ $pe->menu }} </td>
                                                <td>{{ $pe->rol }}</td>
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

<!-- Modal Crear TipoDocumento -->
<div class="modal inmodal fade" id="nuevoRol" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Registrar Nuevo Rol de Usuario</h4>
            </div>
            <div class="modal-body">
                <label class="col-sm-2 col-form-label">Rol</label>
                <input type="text" placeholder="Ingrese nueva nombre de rol" class="form-control" id="nombreRol" name="nombreRol">
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="CrearRol()">Guardar</button>
            </div>
        </div>
    </div>
</div>
<!-- Fin Modal Recomendacion -->

<!-- Modal Mostrar Permisos -->
<div class="modal inmodal fade" id="asignarMenu" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Asignar Permisos al Usuario:</h4>
                <h4 class="font-bold"><span id = "detNombre"></span></h4>
                <input type="text" placeholder="Ingrese nueva nombre de rol" class="form-control" id="idRol" name="idRol" hidden>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>

                            <th></th>
                            <th>Cod </th>
                            <th>Menú </th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($menus as $m)
                            <tr>
                                <td>
                                    <input type="checkbox" class="i-checks flat chekboxses" name="idMenu[]" value="{{ $m->id }}" id="idMenu">
                                </td>
                                <td>{{ $m->id }}</small></td>
                                <td>{{ $m->nombre }}</td>
                            </tr>        
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="asignarMenuRol()">Guardar</button>
            </div>
        </div>
    </div>
</div>
<!-- Fin Modal Mostrar Permisos -->

<!-- Modal Crear Permisos -->
<div class="modal inmodal fade" id="modalPersmiso" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Crear Permiso</h4>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <div class="form-group">
                        <label>Nombre de Permiso</label> 
                        <input type="text" placeholder="Ingrese Nombre de Permiso" class="form-control" id="nombrePermiso" name="nombrePermiso" onchange="completarSlug()" onclick="completarSlug()">
                    </div>
                    <div class="form-group">
                        <label>Slug</label> 
                        <input type="text" placeholder="Ingrese Slug" class="form-control" id="slug" name="slug">
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="guardarPermiso()">Guardar</button>
            </div>
        </div>
    </div>
</div>
<!-- Fin Modal Crear Permisos -->

<!-- Modal Mostrar Permisos Rol -->
<div class="modal inmodal fade" id="asignarPermiso" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Asignar Permisos al Usuario:</h4>
                <h4 class="font-bold"><span id = "detNombrePermiso"></span></h4>
                <input type="text" placeholder="Ingrese nueva nombre de rol" class="form-control" id="idRolPermiso" name="idRolPermiso" hidden>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>

                            <th></th>
                            <th>Cod </th>
                            <th>Permiso </th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($permisos as $p)
                            <tr>
                                <td>
                                    <input type="checkbox" class="i-checks flat chekboxses" name="idPermiso[]" value="{{ $p->id }}" id="idPermiso">
                                </td>
                                <td>{{ $p->id }}</small></td>
                                <td>{{ $p->nombre }}</td>
                            </tr>        
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="asignarPermisoRol()">Guardar</button>
            </div>
        </div>
    </div>
</div>
<!-- Fin Modal Mostrar Permisos Rol -->

@endsection
@section('script')
    <script src="{{asset('js/plugins/iCheck/icheck.min.js')}}"></script>
    <link href="{{asset('css/plugins/iCheck/custom.css')}}" rel="stylesheet">
    <script>
        function nuevoRol() {
            $('#nuevoRol').modal('show');
        }
        
        function verMenu(id) {
            $.post( "{{ Route('verMenuRol') }}", {id: id, _token:'{{csrf_token()}}'}).done(function(data) {
                $("#tabLista").empty();
                $("#tabLista").html(data.view);
                
                $("#divTitulo").empty();
                $("#divTitulo").html(data.Titulo);
                
                $('#inputIdRol').val(id);
                
            });
        }

        function CrearRol() {
            var nombre = $('#nombreRol').val();

            $.post( "{{ Route('crearRol') }}", {nombre: nombre, _token:'{{csrf_token()}}'}).done(function(data) {
                $("#listRoles").empty();
                $("#listRoles").html(data.view);
                $('#nuevoRol').modal('hide');
            });
        }

        function mostrarPermisos(id, rol) {
            document.getElementById("detNombre").innerHTML="<p>"+rol+"</p>";
            $('#idRol').val(id);
            $('#asignarMenu').modal('show');
            
        }

        function mostrarPermisosRoles(id, rol) {
            document.getElementById("detNombrePermiso").innerHTML="<p>"+rol+"</p>";
            $('#idRolPermiso').val(id);
            $('#asignarPermiso').modal('show');
        }

        function nuevoPermiso() {
            $('#modalPersmiso').modal('show');
        }

        function completarSlug() {
            $('#slug').val($('#nombrePermiso').val().toLowerCase().replace(/ /g, '-'));
        }

        function guardarPermiso() {
            var nombre = $('#nombrePermiso').val();
            var slug = $('#slug').val();

            $.post( "{{ Route('nuevoPermiso') }}", {nombre: nombre, slug: slug, _token:'{{csrf_token()}}'}).done(function(data) {
                $("#tabPermisos").empty();
                $("#tabPermisos").html(data.view);
                $('#modalPersmiso').modal('hide');
            });
        }
        
        function eliminarPermiso() {
            var idMenuRol=[];
            var id = $('#inputIdRol').val();

            $('.chekboxses:checked').each(
                function() {
                    idMenuRol.push($(this).val());
                }
            );

            $.post( "{{ Route('eliminarMenuRol') }}", {idMenuRol: idMenuRol, id: id, _token:'{{csrf_token()}}'}).done(function(data) {
                $("#tabLista").empty();
                $("#tabLista").html(data.view);
                
                $("#divTitulo").empty();
                $("#divTitulo").html(data.Titulo);
                
                $('#inputIdRol').val(data.id);
            });
        }

        function asignarMenuRol() {
            
            var rol_id = $('#idRol').val();
            var idMenu=[];

            $('.chekboxses:checked').each(
                function() {
                    idMenu.push($(this).val());
                }
            );

            $.post( "{{ Route('asignarMenuRol') }}", {idMenu: idMenu, rol_id: rol_id, _token:'{{csrf_token()}}'}).done(function(data) {
              /*  $("#listRoles").empty();
                $("#listRoles").html(data.view);
                */
                $('#asignarMenu').modal('hide');
            });
        }

        function asignarPermisoRol() {
            var rol_id = $('#idRolPermiso').val();
            var idPermiso=[];
            
            $('.chekboxses:checked').each(
                function() {
                    idPermiso.push($(this).val());
                
                }
            );

            
            $.post( "{{ Route('asignarPermisoRol') }}", {idPermiso: idPermiso, rol_id: rol_id, _token:'{{csrf_token()}}'}).done(function(data) {
              /*  $("#listRoles").empty();
                $("#listRoles").html(data.view);
                */
                $('#asignarPermiso').modal('hide');
            });
        }
    </script>
    <script>
        $(document).ready(function(){
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
        });
    </script>
@endsection
