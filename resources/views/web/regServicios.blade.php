@extends('layouts.app')
@section('pagina')
    Config. Servicios
@endsection
@section('contenido')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Configuracion de Servicios</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ Route('home') }}">Inicio</a>
            </li>
            <li class="breadcrumb-item">
                <a>Página web</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Configuracion de Servicios</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">

    <div class="row">

        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Banner Servicios</h5>
                    <div class="ibox-tools">
                        <button type="button" class="btn btn-w-m btn-default btn-xs" onclick="mostrarBaner()"> <i class="fa fa-plus"></i></button>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content" id="tblBanner">

                    <table class="table">
                        <thead>
                        <tr>
                            <th>Cod</th>
                            <th>Titulo</th>
                            <th>Descripción</th>
                            <th>Estado</th>
                            <th>Banner</th>
                            <th>Gestion</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($banner as $b)
                            <?php
                                if($b->estado == "ACTIVO"){
                                    $icon = "fa fa-toggle-on";
                                    $color = "text-info";
                                }else{
                                    $icon = "fa fa-toggle-off";
                                    $color = "text-danger";
                                }
                            ?>
                            <tr>
                                <td>{{ $b->id }}</td>
                                <td>{{ $b->titulo }}</td>
                                <td>{{ $b->descripcion }}</td>
                                <td onclick="cambiarEstadoBanners('{{ $b->id }}', '{{ $b->estado }}')"><i class="{{ $icon }} {{ $color }}"></i></td>
                                <td><img alt="{{ $b->titulo }}" src="{{ $b->imagen }}" width="50" height="50"></td>
                                <td>
                                    <button type="button" class="btn btn-warning btn-xs" onclick="editarBanner('{{ $b->id }}', '{{ $b->titulo }}', '{{ $b->descripcion }}', '{{ $b->estado }}', '{{ $b->imagen }}')"><i class="fa fa-pencil"></i></button>
                                    <button type="button" class="btn btn-danger btn-xs" onclick="eliminarBanner('{{ $b->id }}', '{{ $b->titulo }}')"><i class="fa fa-trash"></i></button>
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

<div class="wrapper wrapper-content animated fadeInRight">

    <div class="row">

        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Resumen Servicios</h5>
                    <div class="ibox-tools">
                        <button type="button" class="btn btn-w-m btn-default btn-xs" onclick="mostrarServicios()"> <i class="fa fa-plus"></i></button>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content" id="tblServicios">

                    <table class="table">
                        <thead>
                        <tr>
                            <th>Cod</th>
                            <th>Titulo</th>
                            <th>Resumen</th>
                            <th>Descripcion</th>
                            <th>Estado</th>
                            <th>Imagen</th>
                            <th>Gestion</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($resumen as $r) 
                            <?php
                                if($r->estado == "ACTIVO"){
                                    $icon = "fa fa-toggle-on";
                                    $color = "text-info";
                                }else{
                                    $icon = "fa fa-toggle-off";
                                    $color = "text-danger";
                                }
                            ?>   
                            <tr>
                                <td>{{ $r->id }}</td>
                                <td>{{ $r->titulo }}</td>
                                <td>{{ $r->resumen }}</td>
                                <td> 
                                    - {{ $r->desc01 }}.
                                    - {{ $r->desc02 }}
                                    - {{ $r->desc03 }}
                                    - {{ $r->desc04 }}
                                    - {{ $r->desc05 }}
                                </td>
                                <td onclick="cambiarEstadoServicio('{{ $r->id }}', '{{ $r->estado }}')"><i class="{{ $icon }} {{ $color }}"></i></td>
                                <td><img alt="{{ $r->titulo }}" src="{{ $r->imagen }}" width="50" height="50"></td>
                                <td>
                                    <button type="button" class="btn btn-warning btn-xs" onclick="editarServicio('{{ $r->id }}', '{{ $r->titulo }}', '{{ $r->resumen }}', '{{ $r->desc01 }}', '{{ $r->desc02 }}', '{{ $r->desc03 }}', '{{ $r->desc04 }}', '{{ $r->desc05 }}', '{{ $r->imagen }}', '{{ $r->estado }}')"><i class="fa fa-pencil"></i></button>
                                    <button type="button" class="btn btn-danger btn-xs" onclick="eliminarServicio('{{ $r->id }}', '{{ $r->titulo }}')"><i class="fa fa-trash"></i></button>
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

<!-- Area de los modal -->

<!-- Crear Banner -->
<!-- Crear -->
<div class="modal inmodal fade" id="banner" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Subir Nuevo Banner</h4>
            </div>
            <form id="fbanner" name="fbanner" method="post" action="guardarBannerServicio" class="formBanner" enctype="multipart/form-data">
            <div class="modal-body">
                
                    <div class="form-group row">
                        <input type="text" name="_token" id="_token" hidden value="{{ csrf_token() }}">
                        <div class="col-md-12 row">
                            <label class="col-sm-4 col-form-label">Titulo de Banner</label>
                            <div class="col-sm-12">
                                <input type="text" placeholder="Asignar un titulo al banner" class="form-control" id="nombre" name="nombre" required>
                            </div>
                        </div>

                        <div class="col-md-12 row">
                            <label class="col-sm-4 col-form-label">Descripción</label>
                            <div class="col-sm-12">
                                <input type="text" placeholder="Ingrese una descripción" class="form-control" id="descripcion" name="descripcion" required>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label class="col-sm-2 col-form-label">Banner</label>
                            <div class="custom-file col-sm-12">
                                <input id="banner" type="file" class="custom-file-input" id="banner" name="banner">
                                <label for="banner" class="custom-file-label">Seleccionar...</label>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label class="col-sm-2 col-form-label">Estado</label>
                            <div class="col-sm-12">
                                <select class="form-control m-b" id="estado" name="estado">
                                    <option>Seleccione un estado...</option>
                                    <option value="ACTIVO">Publicar</option>
                                    <option value="BAJA">Guardar</option>
                                </select>
                            </div>
                        </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            </div>
        </form>
        </div>
    </div>
</div>

<!-- Editar -->

<div class="modal inmodal fade" id="ebanner" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Editar Banner</h4>
            </div>
            <form id="febanner" name="febanner" method="post" action="editarBanner" class="formeBanner" enctype="multipart/form-data">
            <div class="modal-body">
                
                    <div class="form-group row">
                        <input type="text" name="_token" id="_token" hidden value="{{ csrf_token() }}">
                        <input type="text" name="id" id="idBanner" hidden>
                        <div class="col-md-12 row">
                            <label class="col-sm-4 col-form-label">Titulo de Banner</label>
                            <div class="col-sm-12">
                                <input type="text" placeholder="Asignar un titulo al banner" class="form-control" id="eNombre" name="nombre" required>
                            </div>
                        </div>

                        <div class="col-md-12 row">
                            <label class="col-sm-4 col-form-label">Descripción</label>
                            <div class="col-sm-12">
                                <input type="text" placeholder="Ingrese una descripción" class="form-control" id="eDescripcion" name="descripcion" required>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label class="col-sm-2 col-form-label">Banner</label>
                            <div class="custom-file col-sm-12">
                                <input id="banner" type="file" class="custom-file-input" id="eIBanner" name="banner">
                                <label for="banner" class="custom-file-label" id="eLBanner">Seleccionar...</label>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label class="col-sm-2 col-form-label">Estado</label>
                            <div class="col-sm-12">
                                <select class="form-control m-b" id="eEstado" name="estado">
                                    <option>Seleccione un estado...</option>
                                    <option value="ACTIVO">Publicar</option>
                                    <option value="BAJA">Guardar</option>
                                </select>
                            </div>
                        </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            </div>
        </form>
        </div>
    </div>
</div>

<!-- Fin Banner -->

<!-- SERVICIO -->
<!-- Crear -->
<div class="modal inmodal fade" id="resumenServicio" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Subir Servicio</h4>
            </div>
            <form id="fservicio" name="fservicio" method="post" action="guardarServicio" class="formServicio" enctype="multipart/form-data">
            <div class="modal-body">
                
                    <div class="form-group row">
                        <input type="text" name="_token" id="_token" hidden value="{{ csrf_token() }}">
                        <div class="col-md-12 row">
                            <label class="col-sm-4 col-form-label">Titulo</label>
                            <div class="col-sm-12">
                                <input type="text" placeholder="Asignar un titulo al servicio" class="form-control" id="titulo" name="titulo" required>
                            </div>
                        </div>
                        <div class="col-md-12 row">
                            <label class="col-sm-4 col-form-label">Resumen</label>
                            <div class="col-sm-12">
                                <input type="text" placeholder="Asignar un resumen al servicio" class="form-control" id="resumen" name="resumen" required>
                            </div>
                        </div>

                        <div class="col-md-12 row">
                            <label class="col-sm-4 col-form-label">Descripciones</label>
                            <div class="col-sm-12">
                                <input type="text" placeholder="Descripcion 1" class="form-control" id="desc01" name="desc01" required>
                            </div>
                            <div class="col-sm-12">
                                <input type="text" placeholder="Descripcion 2" class="form-control" id="desc02" name="desc02" required>
                            </div>
                            <div class="col-sm-12">
                                <input type="text" placeholder="Descripcion 3" class="form-control" id="desc03" name="desc03">
                            </div>
                            <div class="col-sm-12">
                                <input type="text" placeholder="Descripcion 4" class="form-control" id="desc04" name="desc04">
                            </div>
                            <div class="col-sm-12">
                                <input type="text" placeholder="Descripcion 5" class="form-control" id="desc05" name="desc05">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label class="col-sm-2 col-form-label">Foto</label>
                            <div class="custom-file col-sm-12">
                                <input id="foto" type="file" class="custom-file-input-resumenEmpresa" id="foto" name="foto">
                                <label for="foto" class="custom-file-label">Seleccionar...</label>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label class="col-sm-2 col-form-label">Estado</label>
                            <div class="col-sm-12">
                                <select class="form-control m-b" id="estado" name="estado">
                                    <option>Seleccione un estado...</option>
                                    <option value="ACTIVO">Publicar</option>
                                    <option value="BAJA">Guardar</option>
                                </select>
                            </div>
                        </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            </div>
        </form>
        </div>
    </div>
</div>

<!-- Editar -->

<div class="modal inmodal fade" id="eServicio" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Editar el Servicio</h4>
            </div>
            <form id="efservicio" name="efservicio" method="post" action="editarServicio" class="formeServicio" enctype="multipart/form-data">
            <div class="modal-body">
                
                    <div class="form-group row">
                        <input type="text" name="_token" id="_token" hidden value="{{ csrf_token() }}">
                        <input type="text" name="id" id="idServicio" hidden>
                        <div class="col-md-12 row">
                            <label class="col-sm-4 col-form-label">Titulo</label>
                            <div class="col-sm-12">
                                <input type="text" placeholder="Asignar un titulo al servicio" class="form-control" id="eTitulo" name="titulo" required>
                            </div>
                        </div>

                        <div class="col-md-12 row">
                            <label class="col-sm-4 col-form-label">Titulo</label>
                            <div class="col-sm-12">
                                <input type="text" placeholder="Resumen" class="form-control" id="eresumen" name="resumen" required>
                            </div>
                        </div>

                        <div class="col-md-12 row">
                            <label class="col-sm-4 col-form-label">Descripción</label>
                            <div class="col-sm-12">
                                <input type="text" placeholder="Descripcion 1" class="form-control" id="eDesc01" name="desc01" required>
                            </div>
                            <div class="col-sm-12">
                                <input type="text" placeholder="Descripcion 2" class="form-control" id="eDesc02" name="desc02" required>
                            </div>
                            <div class="col-sm-12">
                                <input type="text" placeholder="Descripcion 3" class="form-control" id="eDesc03" name="desc03" required>
                            </div>
                            <div class="col-sm-12">
                                <input type="text" placeholder="Descripcion 4" class="form-control" id="eDesc04" name="desc04" required>
                            </div>
                            <div class="col-sm-12">
                                <input type="text" placeholder="Descripcion 5" class="form-control" id="eDesc05" name="desc05" required>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label class="col-sm-2 col-form-label">Foto</label>
                            <div class="custom-file col-sm-12">
                                <input type="file" class="custom-file-input-editarServicio" id="eFoto" name="foto">
                                <label for="foto" class="custom-file-label-editarServicio">Seleccionar...</label>
                            </div>
                        </div>

                        
                        <div class="col-md-12">
                            <label class="col-sm-2 col-form-label">Estado</label>
                            <div class="col-sm-12">
                                <select class="form-control m-b" id="eResumenEstado" name="estado">
                                    <option>Seleccione un estado...</option>
                                    <option value="ACTIVO">Publicar</option>
                                    <option value="BAJA">Guardar</option>
                                </select>
                            </div>
                        </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            </div>
        </form>
        </div>
    </div>
</div>

<!-- Fin Servicio -->

@endsection
@section('script')

<link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">

<link href="{{ asset('css/animate.css') }}" rel="stylesheet">
<link href="{{ asset('css/style.css') }}" rel="stylesheet">

<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

<!-- Custom and plugin javascript -->
<script src="{{ asset('js/inspinia.js') }}"></script>
<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

<script>

<!-- FUNCIONES BANNER -->

    $(document).ready(function(){
        $('.custom-file-input').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        });
    });

    function mostrarBaner(){
        $('#banner').modal('show');
    }

    $(document).on("submit",".formBanner",function(e){
        e.preventDefault();
        var formu = $(this);
        var nombreform = $(this).attr("id");
        
        if (nombreform == "fbanner") {
            var miurl = "{{ Route('guardarBannerServicio') }}";
        }
        var formData = new FormData($("#"+nombreform+"")[0]);
        
        $.ajax({ url: miurl, type: 'POST', data: formData, cache: false, contentType: false, processData: false,
                beforeSend: function(){
                    toastr.success('Espere', 'Subiendo Archivos, por favor espere');
                    $('#banner').modal('hide');
                },
                success: function(data){
                    toastr.success('Correcto', 'Se Subio Correctamente');
                    $("#tblBanner").empty();
                    $("#tblBanner").html(data.view);
                },
                error: function(data) {
                    toastr.error('Error', 'Error al subir archivos');
                }
        });
    });

    function cambiarEstadoBanners(id, estado){
        
        if(estado == "ACTIVO"){
            nuevoEstado = "BAJA";
        }else{
            nuevoEstado = "ACTIVO"
        }

        $.post( "{{ Route('cambiarEstadoBannerServicio') }}", {id: id, nuevoEstado: nuevoEstado, _token:'{{csrf_token()}}'}).done(function(data) {
            $("#tblBanner").empty();
            $("#tblBanner").html(data.view);

            if(data.res == "1"){
                if(data.not == "1"){ 
                    toastr.success('Correcto', 'El banner fue publicado');
                }else{
                    toastr.warning('Correcto', 'El banner fue retirado');
                }
            }else{
                toastr.error('Error', 'Hubo un error en la publicación');
            }


        });

    }

    function editarBanner(id, nombre, descripcion, estado, imagen){
        
        $('#idBanner').val(id);
        $('#eNombre').val(nombre);
        $('#eDescripcion').val(descripcion);
        $('#eIBanner').val(imagen);
        $('#eLBanner').val(imagen);
        $('#eEstado').val(estado);
        $('#ebanner').modal('show');
    }

    $(document).on("submit",".formeBanner",function(e){
        e.preventDefault();
        var formu = $(this);
        var nombreform = $(this).attr("id");
        
        if (nombreform == "febanner") {
            var miurl = "{{ Route('editarBannerServicio') }}";
        }
        var formData = new FormData($("#"+nombreform+"")[0]);
        
        $.ajax({ url: miurl, type: 'POST', data: formData, cache: false, contentType: false, processData: false,
                beforeSend: function(){
                    toastr.success('Espere', 'Subiendo Archivos, por favor espere');
                    $('#ebanner').modal('hide');
                },
                success: function(data){
                    toastr.success('Correcto', 'Se Subio Correctamente');
                    $("#tblBanner").empty();
                    $("#tblBanner").html(data.view);
                },
                error: function(data) {
                    toastr.error('Error', 'Error al subir archivos');
                }
        });
    });

    function eliminarBanner(id, titulo){

        swal({
            title: titulo,
            text: "¿Desea eliminar el banner?",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Si",
            cancelButtonText: "No",
            closeOnConfirm: false,
            closeOnCancel: false
          },
          function(isConfirm) {
            if (isConfirm) {

                $.post( "{{ Route('eliminarBannerServicio') }}", {id: id, _token:'{{csrf_token()}}'}).done(function(data) {
                    $("#tblBanner").empty();
                    $("#tblBanner").html(data.view);
        
                    if(data.res == "1"){
                        swal("Eliminado!", "El resumen se está eliminando", "success");
                    }else{
                        swal("Error!", "Hubo un problema al eliminar el resumen", "error");
                    }
        
        
                });

              
            } else {
              swal("Cancelado", "Siga trabajando :)", "error");
            }
          });
    }

<!-- FIN FUNCIONES BANNER -->

<!-- FUNCIONES SERVICIOS -->

    $(document).ready(function(){
        $('.custom-file-input-resumenEmpresa').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        });
    });

    function mostrarServicios(){
        $('#resumenServicio').modal('show');
    }

    $(document).on("submit",".formServicio",function(e){
        e.preventDefault();
        var formu = $(this);
        var nombreform = $(this).attr("id");
        
        if (nombreform == "fservicio") {
            var miurl = "{{ Route('guardarServicio') }}";
        }
        var formData = new FormData($("#"+nombreform+"")[0]);
        
        $.ajax({ url: miurl, type: 'POST', data: formData, cache: false, contentType: false, processData: false,
                beforeSend: function(){
                    toastr.success('Espere', 'Subiendo Archivos, por favor espere');
                    $('#resumenServicio').modal('hide');
                },
                success: function(data){
                    toastr.success('Correcto', 'Se Subio Correctamente');
                    $("#tblServicio").empty();
                    $("#tblServicio").html(data.view);



                },
                error: function(data) {
                    toastr.error('Error', 'Error al subir archivos');
                }
        });
    });

    function cambiarEstadoServicio(id, estado){
        
        if(estado == "ACTIVO"){
            nuevoEstado = "BAJA";
        }else{
            nuevoEstado = "ACTIVO"
        }

        $.post( "{{ Route('cambiarEstadoServicio') }}", {id: id, nuevoEstado: nuevoEstado, _token:'{{csrf_token()}}'}).done(function(data) {
            $("#tblServicio").empty();
            $("#tblServicio").html(data.view);

            if(data.res == "1"){
                if(data.not == "1"){
                    toastr.success('Correcto', 'El Resumen fue publicado');
                }else{
                    toastr.warning('Correcto', 'El Resumen fue retirado');
                }
            }else{
                toastr.error('Error', 'Hubo un error en la publicación');
            }


        });

    }

    $(document).ready(function(){
        $('.custom-file-input-editarServicio').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label-editarServicio').addClass("selected").html(fileName);
        });
    });

    function editarServicio(id, titulo, resumen, desc01, desc02, desc03, desc04, desc05, imagen, estado){
        $('#idServicio').val(id);
        
        $('#eTitulo').val(titulo);
        $('#eresumen').val(resumen);
        $('#eDesc01').val(desc01);
        $('#eDesc02').val(desc02);
        $('#eDesc03').val(desc03);
        $('#eDesc04').val(desc04);
        $('#eDesc05').val(desc05);
       // $('#eFoto').val(imagen);
        $('#eResumenEstado').val(estado);
        $('#eServicio').modal('show');
    }

    $(document).on("submit",".formeServicio",function(e){
        e.preventDefault();
        var formu = $(this);
        var nombreform = $(this).attr("id");
        
        if (nombreform == "efservicio") {
            var miurl = "{{ Route('editarServicio') }}";
        }
        var formData = new FormData($("#"+nombreform+"")[0]);
        
        $.ajax({ url: miurl, type: 'POST', data: formData, cache: false, contentType: false, processData: false,
                beforeSend: function(){
                    toastr.success('Espere', 'Subiendo Archivos, por favor espere');
                    $('#eServicio').modal('hide');
                },
                success: function(data){
                    toastr.success('Correcto', 'Se Subio Correctamente');
                    $("#tblServicio").empty();
                    $("#tblServicio").html(data.view);
                },
                error: function(data) {
                    toastr.error('Error', 'Error al subir archivos');
                }
        });
    });

    function eliminarServicio(id, titulo){

        swal({
            title: titulo,
            text: "¿Desea eliminar el resumen?",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Si",
            cancelButtonText: "No",
            closeOnConfirm: false,
            closeOnCancel: false
          },
          function(isConfirm) {
            if (isConfirm) {

                $.post( "{{ Route('eliminarServicio') }}", {id: id, _token:'{{csrf_token()}}'}).done(function(data) {
                    $("#tblServicio").empty();
                    $("#tblServicio").html(data.view);
        
                    if(data.res == "1"){
                        swal("Eliminado!", "El servicio se está eliminando", "success");
                    }else{
                        swal("Error!", "Hubo un problema al eliminar el servicio", "error");
                    }
        
        
                });

              
            } else {
              swal("Cancelado", "Siga trabajando :)", "error");
            }
          });
    }

<!-- FIN FUNCIONES SERVICIO -->

</script>
    
@endsection
