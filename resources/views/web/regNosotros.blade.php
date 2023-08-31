@extends('layouts.app')
@section('pagina')
    Config. Nosotros
@endsection
@section('contenido')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Configuracion de Nosotros</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ Route('home') }}">Inicio</a>
            </li>
            <li class="breadcrumb-item">
                <a>Página web</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Configuracion de Nosotros</strong>
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
                    <h5>Banner de Nosotros</h5>
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
                            <th>Banner</th>
                            <th>Estado</th>
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
                                <td><img alt="{{ $b->titulo }}" src="{{ $b->imagen }}" width="50" height="50"></td>
                                <td onclick="cambiarEstadoBanners('{{ $b->id }}', '{{ $b->estado }}')"><i class="{{ $icon }} {{ $color }}"></i></td>
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
                    <h5>Resumen Nosotros</h5>
                    <div class="ibox-tools">
                        <button type="button" class="btn btn-w-m btn-default btn-xs" onclick="mostrarResumenNosotros()"> <i class="fa fa-plus"></i></button>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content" id="tblResumenEmpresa">

                    <table class="table">
                        <thead>
                        <tr>
                            <th>Cod</th>
                            <th>Titulo</th>
                            <th>Descripcion</th>
                            <th>Imagen</th>
                            <th>Estado</th>
                            <th>Posición</th>
                            <th>Gestion</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($nosotros as $n) 
                            <?php
                                if($n->estado == "ACTIVO"){
                                    $icon = "fa fa-toggle-on";
                                    $color = "text-info";
                                }else{
                                    $icon = "fa fa-toggle-off";
                                    $color = "text-danger";
                                }
                            ?>   
                            <tr>
                                <td>{{ $n->id }}</td>
                                <td>{{ $n->titulo }}</td>
                                <td>{{ $n->descripcion }}</td>
                                <td><img alt="{{ $n->titulo }}" src="{{ $n->imagen }}" width="50" height="50"></td>
                                <td>{{ $n->posicion }}</td>
                                <td onclick="cambiarEstadoResumenEmpresa('{{ $n->id }}', '{{ $n->estado }}')"><i class="{{ $icon }} {{ $color }}"></i></td>
                                <td>
                                    <button type="button" class="btn btn-warning btn-xs" onclick="editarResumenEmpresa('{{ $n->id }}', '{{ $n->titulo }}', '{{ $n->posicion }}', '{{ $n->estado }}')"><i class="fa fa-pencil"></i></button>
                                    <button type="button" class="btn btn-danger btn-xs" onclick="eliminarResumenEmpresa('{{ $n->id }}', '{{ $n->titulo }}')"><i class="fa fa-trash"></i></button>
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
            <form id="fbanner" name="fbanner" method="post" action="guardarBannerNostros" class="formBanner" enctype="multipart/form-data">
            <div class="modal-body">
                
                    <div class="form-group row">
                        <input type="text" name="_token" id="_token" hidden value="{{ csrf_token() }}">
                        <div class="col-md-12 row">
                            <label class="col-sm-4 col-form-label">Titulo de Banner</label>
                            <div class="col-sm-12">
                                <input type="text" placeholder="Asignar un titulo al banner" class="form-control" id="titulo" name="titulo" required>
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
                                <input id="banner" type="file" class="custom-file-input" id="bannerNosotros" name="bannerNosotros">
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

<!-- Resumen de Nosotros -->
<!-- Crear -->
<div class="modal inmodal fade" id="resumenNosotros" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Subir Resumen de Nosotros</h4>
            </div>
            <form id="fresumenNosotros" name="fresumenNosotros" method="post" action="guardarResumenNosotros" class="formResumenNosotros" enctype="multipart/form-data">
            <div class="modal-body">
                
                    <div class="form-group row">
                        <input type="text" name="_token" id="_token" hidden value="{{ csrf_token() }}">
                        <div class="col-md-12 row">
                            <label class="col-sm-4 col-form-label">Titulo</label>
                            <div class="col-sm-12">
                                <input type="text" placeholder="Asignar un titulo al resumen de nosotros" class="form-control" id="titulo" name="titulo" required>
                            </div>
                        </div>

                        <div class="col-md-12 row">
                            <label class="col-sm-4 col-form-label">Titulo</label>
                            <div class="col-sm-12">
                                <textarea class="form-control" placeholder="Ingrese una descripción" rows="3" id = "descripcionNosotros" name = "descripcionNosotros"></textarea>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label class="col-sm-2 col-form-label">Imagen</label>
                            <div class="custom-file col-sm-12">
                                <input id="imagenNosotros" type="file" class="custom-file-input" name="imagenNosotros">
                                <label for="imagenNosotros" class="custom-file-label" id="imagenNosotros">Seleccionar...</label>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label class="col-sm-5 col-form-label">Posición del texto</label>
                            <div class="col-sm-12">
                                <select class="form-control m-b" id="posicion" name="posicion">
                                    <option>Seleccione una posición...</option>
                                    <option value="DERECHA">Derecha</option>
                                    <option value="IZQUIERDA">Izquierda</option>
                                </select>
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

<div class="modal inmodal fade" id="eResumenEmpresa" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Subir Resumen de la Empresa</h4>
            </div>
            <form id="efresumenEmpresa" name="efresumenEmpresa" method="post" action="editarResumenEmpresa" class="formeResumenEmpresa" enctype="multipart/form-data">
            <div class="modal-body">
                
                    <div class="form-group row">
                        <input type="text" name="_token" id="_token" hidden value="{{ csrf_token() }}">
                        <input type="text" name="id" id="idResumenEmpresa" hidden>
                        <div class="col-md-12 row">
                            <label class="col-sm-4 col-form-label">Titulo</label>
                            <div class="col-sm-12">
                                <input type="text" placeholder="Asignar un titulo al resumen de la empresa" class="form-control" id="eTitulo" name="titulo" required>
                            </div>
                        </div>

                        <div class="col-md-12 row">
                            <label class="col-sm-4 col-form-label">Titulo</label>
                            <div class="col-sm-12">
                                <input type="text" placeholder="Subtitulo" class="form-control" id="eSubTitulo" name="subTitulo" required>
                            </div>
                        </div>

                        <div class="col-md-12 row">
                            <label class="col-sm-4 col-form-label">Descripción</label>
                            <div class="col-sm-12">
                                <input type="text" placeholder="Ingrese una descripción" class="form-control" id="eDescripcion" name="descripcion" required>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label class="col-sm-2 col-form-label">Foto</label>
                            <div class="custom-file col-sm-12">
                                <input id="foto" type="file" class="custom-file-input-resumenEmpresa" id="eFoto" name="foto">
                                <label for="foto" class="custom-file-label">Seleccionar...</label>
                            </div>
                        </div>

                        <div class="col-md-12 row">
                            <label class="col-sm-4 col-form-label">Titulo del Boton</label>
                            <div class="col-sm-12">
                                <input type="text" placeholder="Asignar un titulo al botón" class="form-control" id="eBtnAsignar" name="btnAsignar" required>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label class="col-sm-2 col-form-label">A donde dirigiar</label>
                            <div class="col-sm-12">
                                <select class="form-control m-b" id="eAsignarUrl" name="asignarUrl">
                                    <option>Seleccione una direccion...</option>
                                    <option value="{{ Route('web') }}">Inicio</option>
                                    <option value="{{ Route('nosotros') }}">Sobre Nosotros</option>
                                    <option value="{{ Route('servicios') }}">Servicio</option>
                                    <option value="{{ Route('preguntas') }}">Preguntas Frecuentes</option>
                                    <option value="{{ Route('equipos') }}">Equipos en Liquidación</option>
                                    <option value="{{ Route('home') }}">Ingresar</option>
                                    <option value="{{ Route('cli') }}">Registrar</option>
                                </select>
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

<!-- Fin Resumen Empresa -->

<!-- DETALLE NOSTROS -->
<!-- Crear -->

<div class="modal inmodal fade" id="detalleNosotros" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">DETALLE NOSOTROS</h4>
                <h4 class="modal-title" id = "titulodetalle">TITULO</h4>
            </div>
            <form id="fdetalleNosotros" name="fdetalleNosotros" method="post" action="guardarDetalleNosotros" class="formDetalleNosotros" enctype="multipart/form-data">
                <div class="modal-body">
                    
                    <div class="form-group row">
                        <input type="text" name="_token" id="_token" hidden value="{{ csrf_token() }}">
                        <input type="text" placeholder="Asignar un subtitulo" class="form-control" id="idNosotros" name="idNosotros" hidden required>
                        <div class="col-md-12 row">
                            <label class="col-sm-4 col-form-label">Subtitulo</label>
                            <div class="col-sm-12">
                                <input type="text" placeholder="Asignar un subtitulo" class="form-control" id="subtitulo" name="subtitulo" required>
                            </div>
                        </div>

                        <div class="col-md-12 row">
                            <label class="col-sm-4 col-form-label">Descripción</label>
                            <div class="col-sm-12">
                                <input type="text" placeholder="Ingrese una descripción" class="form-control" id="descripcion" name="descripcion" required>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label class="col-sm-2 col-form-label">Imagen</label>
                            <div class="custom-file col-sm-12">
                                <input id="imagen" type="file" class="custom-file-input" name="imagen">
                                <label for="imagen" class="custom-file-label" id="imagen">Seleccionar...</label>
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

<div class="modal inmodal fade" id="eDetalleNosotros" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Editar Por que Elegirnos</h4>
            </div>
            <form id="efporQueElegirnos" name="efporQueElegirnos" method="post" action="editarPorQueElegirnos" class="formePorQueElegirnos" enctype="multipart/form-data">
            <div class="modal-body">
                
                    <div class="form-group row">
                        <input type="text" name="_token" id="_token" hidden value="{{ csrf_token() }}">
                        <input type="text" name="id" id="idPorQueElegirnos" hidden value="{{ csrf_token() }}">
                        <div class="col-md-12 row">
                            <label class="col-sm-4 col-form-label">Titulo</label>
                            <div class="col-sm-12">
                                <input type="text" placeholder="Asignar un titulo al por que elegirnos" class="form-control" id="ePqETitulo" name="titulo" required>
                            </div>
                        </div>

                        <div class="col-md-12 row">
                            <label class="col-sm-4 col-form-label">Descripción</label>
                            <div class="col-sm-12">
                                <input type="text" placeholder="Ingrese una descripción" class="form-control" id="ePqEDescripcion" name="descripcion" required>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label class="col-sm-2 col-form-label">Estado</label>
                            <div class="col-sm-12">
                                <select class="form-control m-b" id="ePqEEstado" name="estado">
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

<!-- Fin Por que elegirnos -->

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

<script src="{{ asset('js/plugins/dropzone/dropzone.js')}}"></script>

<script>

<!-- CRUD BANNER -->
    function mostrarBaner(){
        $('#banner').modal('show');
    }

    $(document).on("submit",".formBanner",function(e){
        e.preventDefault();
        var formu = $(this);
        var nombreform = $(this).attr("id");
        
        if (nombreform == "fbanner") {
            var miurl = "{{ Route('guardarBannerNostros') }}";
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

<!-- FIN CRUD BANNER -->

<!-- CRUD RESUMEN NOSOTROD -->


    function mostrarResumenNosotros(){
        $('#resumenNosotros').modal('show');
    }

    $(document).on("submit",".formResumenNosotros",function(e){
        e.preventDefault();
        var formu = $(this);
        var nombreform = $(this).attr("id");
        
        if (nombreform == "fresumenNosotros") {
            var miurl = "{{ Route('guardarResumenNosotros') }}";
        }
        var formData = new FormData($("#"+nombreform+"")[0]);
        
        $.ajax({ url: miurl, type: 'POST', data: formData, cache: false, contentType: false, processData: false,
                beforeSend: function(){
                    toastr.success('Espere', 'Subiendo Archivos, por favor espere');
                    $('#resumenNosotros').modal('hide');
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

<!-- FIN CRUD RESUMEN NOSOTROS -->

<!-- CRUD DETALLE NOSOTROS -->

    function agregarDetalle(id, titulo){
        $('#idNosotros').val(id);
        $('#detalleNosotros').modal('show');
    }

    $(document).on("submit",".formDetalleNosotros",function(e){
        e.preventDefault();
        var formu = $(this);
        var nombreform = $(this).attr("id");
        
        if (nombreform == "fdetalleNosotros") {
            var miurl = "{{ Route('guardarDetalleNosotros') }}";
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

<!-- CRUD FIN DETALLE NOSOTROS -->

    function cargarTablas()
    {
        alert("ESto es una prueba");   
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

    function editarResumenEmpresa(id, nombre, descripcion, estado, imagen){
        $('#idBanner').val(id);
        $('#eNombre').val(nombre);
        $('#eDescripcion').val(descripcion);
        $('#eIBanner').val(imagen);
        $('#eLBanner').val(imagen);
        $('#eEstado').val(estado);
        $('#ebanner').modal('show');
    }

    
    

    function cambiarEstadoBanners(id, estado){
        
        if(estado == "ACTIVO"){
            nuevoEstado = "BAJA";
        }else{
            nuevoEstado = "ACTIVO"
        }

        $.post( "{{ Route('cambiarEstadoBanner') }}", {id: id, nuevoEstado: nuevoEstado, _token:'{{csrf_token()}}'}).done(function(data) {
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

    function cambiarEstadoResumenEmpresa(id, estado){
        
        if(estado == "ACTIVO"){
            nuevoEstado = "BAJA";
        }else{
            nuevoEstado = "ACTIVO"
        }

        $.post( "{{ Route('cambiarEstadoResumenEmpresa') }}", {id: id, nuevoEstado: nuevoEstado, _token:'{{csrf_token()}}'}).done(function(data) {
            $("#tblResumenEmpresa").empty();
            $("#tblResumenEmpresa").html(data.view);

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

    function editarResumenEmpresa(id, titulo, subtitulo, descripcion, icono, imagen, tituloboton, urlboton, estado){
        $('#idResumenEmpresa').val(id);
        $('#eTitulo').val(titulo);
        $('#eSubTitulo').val(subtitulo);
        $('#eDescripcion').val(descripcion);
        $('#eIcono').val(icono);
        $('#eFoto').val(imagen);
        $('#eBtnAsignar').val(tituloboton);
        $('#eAsignarUrl').val(urlboton);
        $('#eResumenEstado').val(estado);
        $('#eResumenEmpresa').modal('show');

    }

    

    function cambiarEstadoPorQueElergirnos(id, estado){
        if(estado == "ACTIVO"){
            nuevoEstado = "BAJA";
        }else{
            nuevoEstado = "ACTIVO"
        }

        $.post( "{{ Route('cambiarEstadoPorQueElegirnos') }}", {id: id, nuevoEstado: nuevoEstado, _token:'{{csrf_token()}}'}).done(function(data) {
            $("#tblPorQueElegirnos").empty();
            $("#tblPorQueElegirnos").html(data.view);

            if(data.res == "1"){
                if(data.not == "1"){
                    toastr.success('Correcto', 'La descripcion de Por Que Elegirnos fue publicado');
                }else{
                    toastr.warning('Correcto', 'La descripcion de Por Que Elegirnos fue retirado');
                }
            }else{
                toastr.error('Error', 'Hubo un error en la publicación');
            }


        });
    }

    function cambiarEstadoCaracteristica(id, estado){
        if(estado == "ACTIVO"){
            nuevoEstado = "BAJA";
        }else{
            nuevoEstado = "ACTIVO"
        }

        $.post( "{{ Route('cambiarEstadoCaracteristica') }}", {id: id, nuevoEstado: nuevoEstado, _token:'{{csrf_token()}}'}).done(function(data) {
            $("#tblCaracteristica").empty();
            $("#tblCaracteristica").html(data.view);

            if(data.res == "1"){
                if(data.not == "1"){
                    toastr.success('Correcto', 'La caracteristica fue publicado');
                }else{
                    toastr.warning('Correcto', 'La caracteristica fue retirado');
                }
            }else{
                toastr.error('Error', 'Hubo un error en la publicación');
            }


        });
    }

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

                $.post( "{{ Route('eliminarBanner') }}", {id: id, _token:'{{csrf_token()}}'}).done(function(data) {
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

    function eliminarResumenEmpresa(id, titulo){

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

                $.post( "{{ Route('eliminarResumen') }}", {id: id, _token:'{{csrf_token()}}'}).done(function(data) {
                    $("#tblResumenEmpresa").empty();
                    $("#tblResumenEmpresa").html(data.view);
        
                    if(data.res == "1"){
                        swal("Eliminado!", "El banner se está eliminando", "success");
                    }else{
                        swal("Error!", "Hubo un problema al eliminar el banner", "error");
                    }
        
        
                });

              
            } else {
              swal("Cancelado", "Siga trabajando :)", "error");
            }
          });
    }

    function eliminarPorQueElegirnos(id, titulo){

        swal({
            title: titulo,
            text: "¿Desea eliminar esta seccion?",
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

                $.post( "{{ Route('eliminarPorQueElegirnos') }}", {id: id, _token:'{{csrf_token()}}'}).done(function(data) {
                    $("#tblPorQueElegirnos").empty();
                    $("#tblPorQueElegirnos").html(data.view);
        
                    if(data.res == "1"){
                        swal("Eliminado!", "El banner se está eliminando", "success");
                    }else{
                        swal("Error!", "Hubo un problema al eliminar el banner", "error");
                    }
        
        
                });

              
            } else {
              swal("Cancelado", "Siga trabajando :)", "error");
            }
          });
    }

    

    function editarPorQueElegirnos(id, nombre, descripcion, icono, estado){
        $('#idPorQueElegirnos').val(id);
        $('#ePqETitulo').val(nombre);
        $('#ePqEDescripcion').val(descripcion);
        $('#ePqEIcono').val(icono);
        $('#ePqEEstado').val(estado);
        $('#ePorQueElegirnos').modal('show');
    }

    $(document).on("submit",".formePorQueElegirnos",function(e){
        e.preventDefault();
        var formu = $(this);
        var nombreform = $(this).attr("id");
        
        if (nombreform == "efporQueElegirnos") {
            var miurl = "{{ Route('editarPorQueElegirnos') }}";
        }
        var formData = new FormData($("#"+nombreform+"")[0]);
        
        $.ajax({ url: miurl, type: 'POST', data: formData, cache: false, contentType: false, processData: false,
                beforeSend: function(){
                    toastr.success('Espere', 'Subiendo Archivos, por favor espere');
                    $('#ePorQueElegirnos').modal('hide');
                },
                success: function(data){
                    toastr.success('Correcto', 'Se Subio Correctamente');
                    $("#tblPorQueElegirnos").empty();
                    $("#tblPorQueElegirnos").html(data.view);
                },
                error: function(data) {
                    toastr.error('Error', 'Error al subir archivos');
                }
        });
    });

    function mostrarPorQueElegirnos(){
        $('#porQueElegirnos').modal('show');
    }

    function mostrarCaracteristica(){
        $('#caracteristicas').modal('show');
    }

    $(document).ready(function(){
        $('.custom-file-input').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        });
    });

    $(document).ready(function(){
        $('.custom-file-input-resumenEmpresa').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        });
    });

    

    $(document).on("submit",".formResumenEmpresa",function(e){
        e.preventDefault();
        var formu = $(this);
        var nombreform = $(this).attr("id");
        
        if (nombreform == "fresumenEmpresa") {
            var miurl = "{{ Route('guardarResumenEmpresa') }}";
        }
        var formData = new FormData($("#"+nombreform+"")[0]);
        
        $.ajax({ url: miurl, type: 'POST', data: formData, cache: false, contentType: false, processData: false,
                beforeSend: function(){
                    toastr.success('Espere', 'Subiendo Archivos, por favor espere');
                    $('#resumenEmpresa').modal('hide');
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

    $(document).on("submit",".formPorQueElegirnos",function(e){
        e.preventDefault();
        var formu = $(this);
        var nombreform = $(this).attr("id");
        
        if (nombreform == "fporQueElegirnos") {
            var miurl = "{{ Route('guardarPorQueElegirnos') }}";
        }
        var formData = new FormData($("#"+nombreform+"")[0]);
        
        $.ajax({ url: miurl, type: 'POST', data: formData, cache: false, contentType: false, processData: false,
                beforeSend: function(){
                    setTimeout(function() {
                        toastr.options = {
                            closeButton: true,
                            progressBar: true,
                            showMethod: 'slideDown',
                            timeOut: 4000,
                            positionClass: 'toast-top-center'
                        };
                        toastr.info('Subiendo Archivos, por favor espere');

                    }, 1300);
                },
                success: function(data){
                    swal({
                        title: "Banner",
                        text: "Se subió exitosamente",
                        type: "success",
                        showCancelButton: true,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "Finalizar",
                        closeOnConfirm: false
                    },
                    function(isConfirm){
                        if (isConfirm) {            
                        {closeOnConfirm: true}
                        }
                    });



                },
                error: function(data) {
                    setTimeout(function() {
                        toastr.options = {
                            closeButton: true,
                            progressBar: true,
                            showMethod: 'slideDown',
                            timeOut: 4000,
                            positionClass: 'toast-top-center'
                        };
                        toastr.error('Error al subir');

                    }, 1300);
                }
        });
    });

    $(document).on("submit",".formCaracteristica",function(e){
        e.preventDefault();
        var formu = $(this);
        var nombreform = $(this).attr("id");
        
        if (nombreform == "fcaracteristica") {
            var miurl = "{{ Route('guardarCaracteristica') }}";
        }
        var formData = new FormData($("#"+nombreform+"")[0]);
        
        $.ajax({ url: miurl, type: 'POST', data: formData, cache: false, contentType: false, processData: false,
                beforeSend: function(){
                    setTimeout(function() {
                        toastr.options = {
                            closeButton: true,
                            progressBar: true,
                            showMethod: 'slideDown',
                            timeOut: 4000,
                            positionClass: 'toast-top-center'
                        };
                        toastr.info('Subiendo Archivos, por favor espere');

                    }, 1300);
                },
                success: function(data){
                    swal({
                        title: "Caracterisitca",
                        text: "Se subió exitosamente",
                        type: "success",
                        showCancelButton: true,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "Finalizar",
                        closeOnConfirm: false
                    },
                    function(isConfirm){
                        if (isConfirm) {            
                        {closeOnConfirm: true}
                        }
                    });



                },
                error: function(data) {
                    setTimeout(function() {
                        toastr.options = {
                            closeButton: true,
                            progressBar: true,
                            showMethod: 'slideDown',
                            timeOut: 4000,
                            positionClass: 'toast-top-center'
                        };
                        toastr.error('Error al subir');

                    }, 1300);
                }
        });
    });

</script>
    
@endsection
