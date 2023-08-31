@extends('layouts.app')
@section('pagina')
    Config. Preguntas Frecuentes
@endsection
@section('contenido')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Configuracion de Preguntas Frecuentes</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ Route('home') }}">Inicio</a>
            </li>
            <li class="breadcrumb-item">
                <a>Página web</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Configuracion de Preguntas Frecuentes</strong>
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
                        <button type="button" class="btn btn-w-m btn-default btn-xs" onclick="mostrarPregunta()"> <i class="fa fa-plus"></i></button>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content" id="tblPregunta">

                    <table class="table">
                        <thead>
                        <tr>
                            <th>Cod</th>
                            <th>Pregunta</th>
                            <th>Respuesta</th>
                            <th>Area Derivada</th>
                            <th>Contacto</th>
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
                                <td>{{ $r->pregunta }}</td>
                                <td>{{ $r->respuesta }}</td>
                                <td> {{ $r->area }}</td>
                                <td> {{ $r->contacto }}</td>
                                <td onclick="cambiarEstadoServicios('{{ $r->id }}', '{{ $r->estado }}')"><i class="{{ $icon }} {{ $color }}"></i></td>
                                <td>
                                    <button type="button" class="btn btn-warning btn-xs" onclick="editarServicio('{{ $r->id }}', '{{ $r->pregunta }}', '{{ $r->respuesta }}', '{{ $r->area }}', '{{ $r->contacto }}', '{{ $r->estado }}')"><i class="fa fa-pencil"></i></button>
                                    <button type="button" class="btn btn-danger btn-xs" onclick="eliminarServicio('{{ $r->id }}', '{{ $r->pregunta }}')"><i class="fa fa-trash"></i></button>
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
            <form id="fbanner" name="fbanner" method="post" action="guardarBannerPregunta" class="formBanner" enctype="multipart/form-data">
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
            <form id="febanner" name="febanner" method="post" action="editarBannerPreguntas" class="formeBanner" enctype="multipart/form-data">
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

<!-- PREGUNTA FRECUENTA -->
<!-- Crear -->
<div class="modal inmodal fade" id="resumenPreguntaFrecuente" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Subir Pregunta Frecuente</h4>
            </div>
            <form id="fpregunta" name="fpregunta" method="post" action="guardarPreguntaFrecuente" class="formPregunta" enctype="multipart/form-data">
            <div class="modal-body">
                
                    <div class="form-group row">
                        <input type="text" name="_token" id="_token" hidden value="{{ csrf_token() }}">
                        <div class="col-md-12 row">
                            <label class="col-sm-4 col-form-label">Titulo</label>
                            <div class="col-sm-12">
                                <input type="text" placeholder="Ingresar pregunta" class="form-control" id="pregunta" name="pregunta" required>
                            </div>
                        </div>
                        <div class="col-md-12 row">
                            <label class="col-sm-4 col-form-label">Respuesta</label>
                            <div class="col-sm-12">
                                <textarea class="form-control" placeholder="Ingrese la respuesta" rows="3" id = "respuesta" name = "respuesta" required></textarea>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label class="col-sm-2 col-form-label">Area Designada</label>
                            <div class="col-sm-12">
                                <select class="form-control m-b" id="area" name="area">
                                    <option>Seleccione un área...</option>
                                    <option value="ATENCIÓN AL CLIENTE">ATENCIÓN AL CLIENTE</option>
                                    <option value="ALMACEN">ALMACEN</option>
                                    <option value="COBRANZA">COBRANZA</option>
                                    <option value="MARKETING">MARKETING</option>
                                    <option value="INFORMÁTICA">INFORMÁTICA</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12 row">
                            <label class="col-sm-4 col-form-label">Número de Contacto</label>
                            <div class="col-sm-12">
                                <input type="text" placeholder="Número de Contacto" class="form-control" id="numContacto" name="numContacto" required>
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
                                <input id="foto" type="file" class="custom-file-input-resumenEmpresa" id="eFoto" name="foto">
                                <label for="foto" class="custom-file-label">Seleccionar...</label>
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
            var miurl = "{{ Route('guardarBannerPregunta') }}";
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
                    $("#tblResumenEmpresa").empty();
                    $("#tblResumenEmpresa").html(data.view);
        
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

    function mostrarPregunta(){
        $('#resumenPreguntaFrecuente').modal('show');
    }

    $(document).on("submit",".formPregunta",function(e){
        e.preventDefault();
        var formu = $(this);
        var nombreform = $(this).attr("id");
        
        if (nombreform == "fpregunta") {
            var miurl = "{{ Route('guardarPreguntaFrecuente') }}";
        }
        var formData = new FormData($("#"+nombreform+"")[0]);
        
        $.ajax({ url: miurl, type: 'POST', data: formData, cache: false, contentType: false, processData: false,
                beforeSend: function(){
                    toastr.success('Espere', 'Subiendo Archivos, por favor espere');
                    $('#resumenPreguntaFrecuente').modal('hide');
                },
                success: function(data){
                    toastr.success('Correcto', 'Se Subio Correctamente');
                    $("#tblPregunta").empty();
                    $("#tblPregunta").html(data.view);



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

    function editarServicio(id, nombre, descripcion, estado, imagen){
        $('#idBanner').val(id);
        $('#eNombre').val(nombre);
        $('#eDescripcion').val(descripcion);
        $('#eIBanner').val(imagen);
        $('#eLBanner').val(imagen);
        $('#eEstado').val(estado);
        $('#ebanner').modal('show');
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
                    $('#eResumenEmpresa').modal('hide');
                },
                success: function(data){
                    toastr.success('Correcto', 'Se Subio Correctamente');
                    $("#tblResumenEmpresa").empty();
                    $("#tblResumenEmpresa").html(data.view);
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
