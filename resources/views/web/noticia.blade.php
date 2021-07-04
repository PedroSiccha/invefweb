@extends('layouts.app')
@section('pagina')
    Config. Inicio
@endsection
@section('contenido')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Configuracion de Inicio</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ Route('home') }}">Inicio</a>
            </li>
            <li class="breadcrumb-item">
                <a>Página web</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Configuracion de Inicio</strong>
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
                    <h5>Banner Principal</h5>
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
                            <th>Fec Publicacion</th>
                            <th>Fec Baja</th>
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
                                <td>{{ $b->nombre }}</td>
                                <td>{{ $b->descripcion }}</td>
                                <td>{{ $b->fecinicio }}</td>
                                <td>{{ $b->fecfin }}</td>
                                <td onclick="cambiarEstadoBanners('{{ $b->id }}', '{{ $b->estado }}')"><i class="{{ $icon }} {{ $color }}"></i></td>
                                <td><img alt="{{ $b->nombre }}" src="{{ $b->imagen }}" width="50" height="50"></td>
                                <td>
                                    <button type="button" class="btn btn-warning btn-xs" onclick="editarBanner('{{ $b->id }}', '{{ $b->nombre }}', '{{ $b->descripcion }}', '{{ $b->estado }}', '{{ $b->imagen }}')"><i class="fa fa-pencil"></i></button>
                                    <button type="button" class="btn btn-danger btn-xs" onclick="eliminarBanner('{{ $b->id }}', '{{ $b->nombre }}')"><i class="fa fa-trash"></i></button>
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
                    <h5>Resumen Empresa</h5>
                    <div class="ibox-tools">
                        <button type="button" class="btn btn-w-m btn-default btn-xs" onclick="mostrarResumenEmpresa()"> <i class="fa fa-plus"></i></button>
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
                            <th>Sub Titulo</th>
                            <th>Descripcion</th>
                            <th>Estado</th>
                            <th>Icono</th>
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
                                <td>{{ $r->subtitulo }}</td>
                                <td>{{ $r->descripcion }}</td>
                                <td onclick="cambiarEstadoResumenEmpresa('{{ $r->id }}', '{{ $r->estado }}')"><i class="{{ $icon }} {{ $color }}"></i></td>
                                <td><i class="{{ $r->icono }}"></i></td>
                                <td>
                                    <button type="button" class="btn btn-warning btn-xs" onclick="editarResumenEmpresa('{{ $r->id }}', '{{ $r->titulo }}', '{{ $r->subtitulo }}', '{{ $r->descripcion }}', '{{ $r->icono }}', '{{ $r->imagen }}', '{{ $r->tituloboton }}', '{{ $r->urlboton }}', '{{ $r->estado }}')"><i class="fa fa-pencil"></i></button>
                                    <button type="button" class="btn btn-danger btn-xs" onclick="eliminarResumenEmpresa('{{ $r->id }}', '{{ $r->titulo }}')"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Por que Elegirnos</h5>
                    <div class="ibox-tools">
                        <button type="button" class="btn btn-w-m btn-default btn-xs" onclick="mostrarPorQueElegirnos()"> <i class="fa fa-plus"></i></button>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content" id="tblPorQueElegirnos">

                    <table class="table" >
                        <thead>
                        <tr>
                            <th>Cod</th>
                            <th>Titulo</th>
                            <th>Descripción</th>
                            <th>Publicacion</th>
                            <th>Retirado</th>
                            <th>Estado</th>
                            <th>Icono</th>
                            <th>Gestion</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($resumenEmpresa as $re)
                            <?php
                                if($re->estado == "ACTIVO"){
                                    $icon = "fa fa-toggle-on";
                                    $color = "text-info";
                                }else{
                                    $icon = "fa fa-toggle-off";
                                    $color = "text-danger";
                                }
                            ?>     
                            <tr>
                                <td>{{ $re->id }}</td>
                                <td>{{ $re->titulo }}</td>
                                <td>{{ $re->descripcion }}</td>
                                <td>{{ $re->fecinicio }}</td>
                                <td>{{ $re->fecfin }}</td>
                                <td onclick="cambiarEstadoPorQueElergirnos('{{ $re->id }}', '{{ $re->estado }}')"><i class="{{ $icon }} {{ $color }}"></i></td>
                                <td><i class="{{ $re->icono }}"></i></td>
                                <td>
                                    <button type="button" class="btn btn-warning btn-xs" onclick="editarPorQueElegirnos('{{ $re->id }}', '{{ $re->titulo }}', '{{ $re->descripcion }}', '{{ $re->icono }}', '{{ $re->estado }}')"><i class="fa fa-pencil"></i></button>
                                    <button type="button" class="btn btn-danger btn-xs" onclick="eliminarPorQueElegirnos('{{ $re->id }}', '{{ $re->titulo }}')"><i class="fa fa-trash"></i></button>
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
                    <h5>Caracteristicas</h5>
                    <div class="ibox-tools">
                        <button type="button" class="btn btn-w-m btn-default btn-xs" onclick="mostrarCaracteristica()"> <i class="fa fa-plus"></i></button>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content" id="tblCaracteristica">

                    <table class="table">
                        <thead>
                        <tr>
                            <th>Cod</th>
                            <th>Titulo</th>
                            <th>Descripción</th>
                            <th>Icono</th>
                            <th>Estado</th>
                            <th>Gestion</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($caracteristicas as $c)    
                            <?php
                                if($c->estado == "ACTIVO"){
                                    $icon = "fa fa-toggle-on";
                                    $color = "text-info";
                                }else{
                                    $icon = "fa fa-toggle-off";
                                    $color = "text-danger";
                                }
                            ?>  
                            <tr>
                                <td>{{ $c->id }}</td>
                                <td>{{ $c->titulo }}</td>
                                <td>{{ $c->descripcion }}</td>
                                <td><i class="{{ $c->icono }}"></i></td>
                                <td onclick="cambiarEstadoCaracteristica('{{ $c->id }}', '{{ $c->estado }}')"><i class="{{ $icon }} {{ $color }}"></i></td>
                                <td>
                                    <button type="button" class="btn btn-warning btn-xs" onclick="editarCaracteristica('{{ $c->id }}', '{{ $c->titulo }}', '{{ $c->descripcion }}', '{{ $c->icono }}', '{{ $c->estado }}')"><i class="fa fa-pencil"></i></button>
                                    <button type="button" class="btn btn-danger btn-xs" onclick="eliminarCaracteristica('{{ $c->id }}', '{{ $c->titulo }}')"><i class="fa fa-trash"></i></button>
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
            <form id="fbanner" name="fbanner" method="post" action="guardarBanner" class="formBanner" enctype="multipart/form-data">
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

<!-- Resumen de Empresa -->
<!-- Crear -->
<div class="modal inmodal fade" id="resumenEmpresa" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Subir Resumen de la Empresa</h4>
            </div>
            <form id="fresumenEmpresa" name="fresumenEmpresa" method="post" action="guardarResumenEmpresa" class="formResumenEmpresa" enctype="multipart/form-data">
            <div class="modal-body">
                
                    <div class="form-group row">
                        <input type="text" name="_token" id="_token" hidden value="{{ csrf_token() }}">
                        <div class="col-md-12 row">
                            <label class="col-sm-4 col-form-label">Titulo</label>
                            <div class="col-sm-12">
                                <input type="text" placeholder="Asignar un titulo al resumen de la empresa" class="form-control" id="titulo" name="titulo" required>
                            </div>
                        </div>

                        <div class="col-md-12 row">
                            <label class="col-sm-4 col-form-label">Titulo</label>
                            <div class="col-sm-12">
                                <input type="text" placeholder="Subtitulo" class="form-control" id="subTitulo" name="subTitulo" required>
                            </div>
                        </div>

                        <div class="col-md-12 row">
                            <label class="col-sm-4 col-form-label">Descripción</label>
                            <div class="col-sm-12">
                                <input type="text" placeholder="Ingrese una descripción" class="form-control" id="descripcion" name="descripcion" required>
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
                            <label class="col-sm-2 col-form-label">Icono</label>
                            <div class="col-sm-12">
                                <select class="form-control m-b fa" id="icono" name="icono">
                                    <option>Seleccione un icono...</option>
                                    <option value="fa fa-address-book" class="fa">
                                        &#xf2b9;
                                    </option>
                                    <option value="fa fa-address-card" class="fa">
                                        &#xf2bb;
                                    </option>
                                    <option value="fa fa-envelope-open" class="fa">
                                        &#xf2b6;
                                    </option>
                                    <option value="fa fa-etsy" class="fa">
                                        &#xf2d7;  
                                    </option>
                                    <option value="fa fa-grav" class="fa">
                                        &#xf2d6;
                                    </option>
                                    <option value="fa fa-handshake-o" class="fa">
                                        &#xf2b5;
                                    </option>
                                    <option value="fa fa-id-badge" class="fa">
                                        &#xf2c1;
                                    </option>
                                    <option value="fa fa-linode" class="fa">
                                        &#xf2b8;
                                    </option>
                                    <option value="fa fa-meetup" class="fa">
                                        &#xf2e0;
                                    </option>
                                    <option value="fa fa-microchip" class="fa">
                                        &#xf2db;
                                    </option>
                                    <option value="fa fa-podcast" class="fa">
                                        &#xf2ce;
                                    </option>
                                    <option value="fa fa-quora" class="fa">
                                        &#xf2c4;
                                    </option>
                                    <option value="fa fa-ravelry" class="fa">
                                        &#xf2d9;
                                    </option>
                                    <option value="fa fa-snowflake-o" class="fa">
                                        &#xf2dc;
                                    </option>
                                    <option value="fa fa-telegram" class="fa">
                                        &#xf2c6;
                                    </option>
                                    <option value="fa fa-times-rectangle" class="fa">
                                        &#xf2d3;
                                    </option>
                                    <option value="fa fa-user-circle" class="fa">
                                        &#xf2bd;
                                    </option>
                                    <option value="fa fa-user-o" class="fa">
                                        &#xf007;
                                    </option>
                                    <option value="fa fa-window-maximize" class="fa">
                                        &#xf2d0;
                                    </option>
                                    <option value="fa fa-window-minimize" class="fa">
                                        &#xf2d1;
                                    </option>
                                    <option value="fa fa-window-restore" class="fa">
                                        &#xf2d2;
                                    </option>
                                    <option value="fa fa-wpexplorer" class="fa">
                                        &#xf2b9;
                                    </option>
                                    <option value="fa fa-angellist" class="fa">
                                        &#xf2de;
                                    </option>
                                    <option value="fa fa-area-chart" class="fa">
                                        &#xf1fe;
                                    </option>
                                    <option value="fa fa-at" class="fa">
                                        &#xf1fa;
                                    </option>
                                    <option value="fa fa-bell-slash" class="fa">
                                        &#xf1f6;
                                    </option>
                                    <option value="fa fa-bicycle" class="fa">
                                        &#xf206;
                                    </option>
                                    <option value="fa fa-binoculars" class="fa">
                                        &#xf1e5;
                                    </option>
                                    <option value="fa fa-birthday-cake" class="fa">
                                        &#xf1fd;
                                    </option>
                                    <option value="fa fa-bus" class="fa">
                                        &#xf207;
                                    </option>
                                    <option value="fa fa-calculador" class="fa">
                                        &#xf1ec;
                                    </option>
                                    <option value="fa fa-cc-mastercard" class="fa">
                                        &#xf1f1;
                                    </option>
                                    <option value="fa fa-cc-paypal" class="fa">
                                        &#xf1f4;
                                    </option>
                                    <option value="fa fa-cc-visa" class="fa">
                                        &#xf1f0;
                                    </option>
                                    <option value="fa fa-copyright" class="fa">
                                        &#xf1f9;
                                    </option>
                                    <option value="fa fa-futbol-o" class="fa">
                                        &#xf1e3;
                                    </option>
                                    <option value="fa fa-line-chart" class="fa">
                                        &#xf201;
                                    </option>
                                    <option value="fa fa-newspaper-o" class="fa">
                                        &#xf1ea;
                                    </option>
                                    <option value="fa fa-paint-brush" class="fa">
                                        &#xf1fc;
                                    </option>
                                    <option value="fa fa-pie-chart" class="fa">
                                        &#xf200;
                                    </option>
                                    <option value="fa fa-plug" class="fa">
                                        &#xf1e6;
                                    </option>
                                    <option value="fa fa-slideshare" class="fa">
                                        &#xf1e7;
                                    </option>
                                    <option value="fa fa-trash" class="fa">
                                        &#xf1f8;
                                    </option>
                                    <option value="fa fa-tty" class="fa">
                                        &#xf1e4;
                                    </option>
                                    <option value="fa fa-wifi" class="fa">
                                        &#xf1eb;
                                    </option>
                                    <option value="fa fa-yelp" class="fa">
                                        &#xf1e9;
                                    </option>
                                    <option value="fa fa-pagelines" class="fa">
                                        &#xf18c;
                                    </option>
                                    <option value="fa fa-stack-exchange" class="fa">
                                        &#xf18d;
                                    </option>
                                    <option value="fa fa-wheelchair" class="fa">
                                        &#xf193;
                                    </option>
                                    <option value="fa fa-vimeo-square" class="fa">
                                        &#xf194;
                                    </option>
                                    <option value="fa fa-plus-square-o" class="fa">
                                        &#xf0fe;
                                    </option>
                                    <option value="fa fa-automobile" class="fa">
                                        &#xf1b9;
                                    </option>
                                    <option value="fa fa-bank" class="fa">
                                        &#xf19c;
                                    </option>
                                    <option value="fa fa-behance-square" class="fa">
                                        &#xf1b5;
                                    </option>
                                    <option value="fa fa-bomb" class="fa">
                                        &#xf1e2;
                                    </option>
                                    <option value="fa fa-building" class="fa">
                                        &#xf1ad;
                                    </option>
                                    <option value="fa fa-child" class="fa">
                                        &#xf1ae;
                                    </option>
                                    <option value="fa fa-codepen" class="fa">
                                        &#xf1cb;
                                    </option>
                                    <option value="fa fa-cube" class="fa">
                                        &#xf1b2;
                                    </option>
                                    <option value="fa fa-cubes" class="fa">
                                        &#xf1b3;
                                    </option>
                                    <option value="fa fa-database" class="fa">
                                        &#xf1c0;
                                    </option>
                                    <option value="fa fa-delicious" class="fa">
                                        &#xf1a5;
                                    </option>
                                    <option value="fa fa-deviantart" class="fa">
                                        &#xf1bd;
                                    </option>
                                    <option value="fa fa-digg" class="fa">
                                        &#xf1a6;
                                    </option>
                                    <option value="fa fa-drupal" class="fa">
                                        &#xf1a9;
                                    </option>
                                    <option value="fa fa-empire" class="fa">
                                        &#xf1d1;
                                    </option>
                                    <option value="fa fa-fax" class="fa">
                                        &#xf1ac;
                                    </option>
                                    <option value="fa fa-file-archive-o" class="fa">
                                        &#xf1c6;
                                    </option>
                                    <option value="fa fa-file-audio-o" class="fa">
                                        &#xf1c7;
                                    </option>
                                    <option value="fa fa-file-code-o" class="fa">
                                        &#xf1c9;
                                    </option>
                                    <option value="fa fa-file-excel-o" class="fa">
                                        &#xf1c3;
                                    </option>
                                    <option value="fa fa-file-image-o" class="fa">
                                        &#xf1c5;
                                    </option>
                                    <option value="fa fa-file-movie-o" class="fa">
                                        &#xf1c8;
                                    </option>
                                    <option value="fa fa-file-pdf-o" class="fa">
                                        &#xf1c1;
                                    </option>
                                    <option value="fa fa-file-photo-o" class="fa">
                                        &#xf1c5;
                                    </option>
                                    <option value="fa fa-google" class="fa">
                                        &#xf1a0;
                                    </option>
                                    <option value="fa fa-graduation-cap" class="fa">
                                        &#xf19d;
                                    </option>
                                    <option value="fa fa-hacker-news" class="fa">
                                        &#xf1d4;
                                    </option>
                                    <option value="fa fa-header" class="fa">
                                        &#xf1dc;
                                    </option>
                                    <option value="fa fa-history" class="fa">
                                        &#xf1da;
                                    </option>
                                    <option value="fa fa-institution" class="fa">
                                        &#xf19c;
                                    </option>
                                    <option value="fa fa-joomla" class="fa">
                                        &#xf1aa;
                                    </option>
                                    <option value="fa fa-jsfiddle" class="fa">
                                        &#xf1cc;
                                    </option>
                                    <option value="fa fa-language" class="fa">
                                        &#xf1ab;
                                    </option>
                                    <option value="fa fa-life-ring" class="fa">
                                        &#xf1cd;
                                    </option>
                                    <option value="fa fa-openid" class="fa">
                                        &#xf19b;
                                    </option>
                                    <option value="fa fa-paper-plane" class="fa">
                                        &#xf1d8;
                                    </option>
                                    <option value="fa fa-paragraph" class="fa">
                                        &#xf1dd;
                                    </option>
                                    <option value="fa fa-paw" class="fa">
                                        &#xf1b0;
                                    </option>
                                    <option value="fa fa-pied-piper-alt" class="fa">
                                        &#xf1a8;
                                    </option>
                                    <option value="fa fa-qq" class="fa">
                                        &#xf1d6;
                                    </option>
                                    <option value="fa fa-rebel" class="fa">
                                        &#xf1d0;
                                    </option>
                                    <option value="fa fa-recycle" class="fa">
                                        &#xf1b8;
                                    </option>
                                    <option value="fa fa-reddit" class="fa">
                                        &#xf1a1;
                                    </option>
                                    <option value="fa fa-share-alt" class="fa">
                                        &#xf1e0;
                                    </option>
                                    <option value="fa fa-slack" class="fa">
                                        &#xf198;
                                    </option>
                                    <option value="fa fa-sliders" class="fa">
                                        &#xf1de;
                                    </option>
                                    <option value="fa fa-soundcloud" class="fa">
                                        &#xf1be;
                                    </option>
                                    <option value="fa fa-space-shuttle" class="fa">
                                        &#xf197;
                                    </option>
                                    <option value="fa fa-spotify" class="fa">
                                        &#xf1bc;
                                    </option>
                                    <option value="fa fa-steam" class="fa">
                                        &#xf1b6;
                                    </option>
                                    <option value="fa fa-stumbleupon" class="fa">
                                        &#xf1a4;
                                    </option>
                                    <option value="fa fa-taxi" class="fa">
                                        &#xf1ba;
                                    </option>
                                    <option value="fa fa-tencent-weibo" class="fa">
                                        &#xf1d5;
                                    </option>
                                    <option value="fa fa-tree" class="fa">
                                        &#xf1bb;
                                    </option>
                                    <option value="fa fa-weixin" class="fa">
                                        &#xf1d7;
                                    </option>
                                    <option value="fa fa-wordpress" class="fa">
                                        &#xf19a;
                                    </option>
                                    <option value="fa fa-yahoo" class="fa">
                                        &#xf19e;
                                    </option>
                                    <option value="fa fa-anchor" class="fa">
                                        &#xf13d;
                                    </option>
                                    <option value="fa fa-archive" class="fa">
                                        &#xf187;
                                    </option>
                                    <option value="fa fa-asterisk" class="fa">
                                        &#xf069;
                                    </option>
                                    <option value="fa fa-ban" class="fa">
                                        &#xf05e;
                                    </option>
                                    <option value="fa fa-bar-chart-o" class="fa">
                                        &#xf080;
                                    </option>
                                    <option value="fa fa-barcode" class="fa">
                                        &#xf02a;
                                    </option>
                                    <option value="fa fa-beer" class="fa">
                                        &#xf0fc;
                                    </option>
                                    <option value="fa fa-bell" class="fa">
                                        &#xf0f3;
                                    </option>
                                    <option value="fa fa-bolt" class="fa">
                                        &#xf0e7;
                                    </option>
                                    <option value="fa fa-book" class="fa">
                                        &#xf02d;
                                    </option>
                                    <option value="fa fa-bookmark" class="fa">
                                        &#xf02e;
                                    </option>
                                    <option value="fa fa-briefcase" class="fa">
                                        &#xf0b1;
                                    </option>
                                    <option value="fa fa-bug" class="fa">
                                        &#xf188;
                                    </option>
                                    <option value="fa fa-bullhorn" class="fa">
                                        &#xf0a1;
                                    </option>
                                    <option value="fa fa-calendar" class="fa">
                                        &#xf073;
                                    </option>
                                    <option value="fa fa-camera" class="fa">
                                        &#xf030;
                                    </option>
                                    <option value="fa fa-certificate" class="fa">
                                        &#xf0a3;
                                    </option>
                                    <option value="fa fa-check" class="fa">
                                        &#xf00c;
                                    </option>
                                    <option value="fa fa-clock-o" class="fa">
                                        &#xf017;
                                    </option>
                                    <option value="fa fa-cloud" class="fa">
                                        &#xf0c2;
                                    </option>
                                    <option value="fa fa-code" class="fa">
                                        &#xf121;
                                    </option>
                                    <option value="fa fa-code-fork" class="fa">
                                        &#xf126;
                                    </option>
                                    <option value="fa fa-coffee" class="fa">
                                        &#xf0f4;
                                    </option>
                                    <option value="fa fa-cog" class="fa">
                                        &#xf013;
                                    </option>
                                    <option value="fa fa-cogs" class="fa">
                                        &#xf085;
                                    </option>
                                    <option value="fa fa-comments" class="fa">
                                        &#xf086;
                                    </option>
                                    <option value="fa fa-compass" class="fa">
                                        &#xf14e;
                                    </option>
                                    <option value="fa fa-crosshairs" class="fa">
                                        &#xf05b;
                                    </option>
                                    <option value="fa fa-desktop" class="fa">
                                        &#xf108;
                                    </option>
                                    <option value="fa fa-download" class="fa">
                                        &#xf019;
                                    </option>
                                    <option value="fa fa-edit" class="fa">
                                        &#xf044;
                                    </option>
                                    <option value="fa fa-eraser" class="fa">
                                        &#xf12d;
                                    </option>
                                    <option value="fa fa-exclamation-triangle" class="fa">
                                        &#xf071;
                                    </option>
                                    <option value="fa fa-eye" class="fa">
                                        &#xf06e;
                                    </option>
                                    <option value="fa fa-female" class="fa">
                                        &#xf182;
                                    </option>
                                    <option value="fa fa-fire" class="fa">
                                        &#xf06d;
                                    </option>
                                    <option value="fa fa-fire-extinguisher" class="fa">
                                        &#xf134;
                                    </option>
                                    <option value="fa fa-flag" class="fa">
                                        &#xf024;
                                    </option>
                                    <option value="fa fa-flask" class="fa">
                                        &#xf0c3;
                                    </option>
                                    <option value="fa fa-folder" class="fa">
                                        &#xf07b;
                                    </option>
                                    <option value="fa fa-folder-open" class="fa">
                                        &#xf07c;
                                    </option>
                                    <option value="fa fa-frown-o" class="fa">
                                        &#xf119;
                                    </option>
                                    <option value="fa fa-gamepad" class="fa">
                                        &#xf11b;
                                    </option>
                                    <option value="fa fa-gavel" class="fa">
                                        &#xf0e3;
                                    </option>
                                    <option value="fa fa-gift" class="fa">
                                        &#xf06b;
                                    </option>
                                    <option value="fa fa-glass" class="fa">
                                        &#xf000;
                                    </option>
                                    <option value="fa fa-globe" class="fa">
                                        &#xf0ac;
                                    </option>
                                    <option value="fa fa-group" class="fa">
                                        &#xf0c0;
                                    </option>
                                    <option value="fa fa-hdd-o" class="fa">
                                        &#xf0a0;
                                    </option>
                                    <option value="fa fa-headphones" class="fa">
                                        &#xf025;
                                    </option>
                                    <option value="fa fa-heart" class="fa">
                                        &#xf21e;
                                    </option>
                                    <option value="fa fa-home" class="fa">
                                        &#xf015;
                                    </option>
                                    <option value="fa fa-inbox" class="fa">
                                        &#xf01c;
                                    </option>
                                    <option value="fa fa-info" class="fa">
                                        &#xf129;
                                    </option>
                                    <option value="fa fa-key" class="fa">
                                        &#xf084;
                                    </option>
                                    <option value="fa fa-keyboard-o" class="fa">
                                        &#xf11c;
                                    </option>
                                    <option value="fa fa-laptop" class="fa">
                                        &#xf109;
                                    </option>
                                    <option value="fa fa-leaf" class="fa">
                                        &#xf06c;
                                    </option>
                                    <option value="fa fa-lemon-o" class="fa">
                                        &#xf094;
                                    </option>
                                    <option value="fa fa-lightbulb-o" class="fa">
                                        &#xf0eb;
                                    </option>
                                    <option value="fa fa-lock" class="fa">
                                        &#xf023;
                                    </option>
                                    <option value="fa fa-magic" class="fa">
                                        &#xf0d0;
                                    </option>
                                    <option value="fa fa-magnet" class="fa">
                                        &#xf076;
                                    </option>
                                    <option value="fa fa-map-marker" class="fa">
                                        &#xf041;
                                    </option>
                                    <option value="fa fa-meh-o" class="fa">
                                        &#xf11a;
                                    </option>
                                    <option value="fa fa-microphone" class="fa">
                                        &#xf130;
                                    </option>
                                    <option value="fa fa-minus" class="fa">
                                        &#xf068;
                                    </option>
                                    <option value="fa fa-money" class="fa">
                                        &#xf0d6;
                                    </option>
                                    <option value="fa fa-moon-o" class="fa">
                                        &#xf186;
                                    </option>
                                    <option value="fa fa-music" class="fa">
                                        &#xf001;
                                    </option>
                                    <option value="fa fa-pencil" class="fa">
                                        &#xf040;
                                    </option>
                                    <option value="fa fa-phone" class="fa">
                                        &#xf095;
                                    </option>
                                    <option value="fa fa-picture-o" class="fa">
                                        &#xf03e;
                                    </option>
                                    <option value="fa fa-plus" class="fa">
                                        &#xf067;
                                    </option>
                                    <option value="fa fa-power-off" class="fa">
                                        &#xf011;
                                    </option>
                                    <option value="fa fa-print" class="fa">
                                        &#xf02f;
                                    </option>
                                    <option value="fa fa-puzzle-piece" class="fa">
                                        &#xf12e;
                                    </option>
                                    <option value="fa fa-qrcode" class="fa">
                                        &#xf029;
                                    </option>
                                    <option value="fa fa-question" class="fa">
                                        &#xf128;
                                    </option>
                                    <option value="fa fa-road" class="fa">
                                        &#xf018;
                                    </option>
                                    <option value="fa fa-rocket" class="fa">
                                        &#xf135;
                                    </option>
                                    <option value="fa fa-rss" class="fa">
                                        &#xf09e;
                                    </option>
                                    <option value="fa fa-search" class="fa">
                                        &#xf00e;
                                    </option>
                                    <option value="fa fa-shield" class="fa">
                                        &#xf132;
                                    </option>

                                    <option value="fa fa-shopping-cart" class="fa">
                                        &#xf07a;
                                    </option>
                                    <option value="fa fa-signal" class="fa">
                                        &#xf012;
                                    </option>
                                    <option value="fa fa-sitemap" class="fa">
                                        &#xf0e8;
                                    </option>
                                    <option value="fa fa-smile-o" class="fa">
                                        &#xf118;
                                    </option>
                                    <option value="fa fa-spinner" class="fa">
                                        &#xf110;
                                    </option>
                                    <option value="fa fa-star" class="fa">
                                        &#xf005;
                                    </option>
                                    <option value="fa fa-suitcase" class="fa">
                                        &#xf0f2;
                                    </option>
                                    <option value="fa fa-sun-o" class="fa">
                                        &#xf185;
                                    </option>
                                    <option value="fa fa-tag" class="fa">
                                        &#xf02b;
                                    </option>
                                    <option value="fa fa-terminal" class="fa">
                                        &#xf120;
                                    </option>
                                    <option value="fa fa-thumb-tack" class="fa">
                                        &#xf08d;
                                    </option>
                                    <option value="fa fa-thumbs-o-down" class="fa">
                                        &#xf165;
                                    </option>
                                    <option value="fa fa-thumbs-o-up" class="fa">
                                        &#xf164;
                                    </option>
                                    <option value="fa fa-ticket" class="fa">
                                        &#xf145;
                                    </option>
                                    <option value="fa fa-tint" class="fa">
                                        &#xf043;
                                    </option>
                                    <option value="fa fa-trophy" class="fa">
                                        &#xf091;
                                    </option>
                                    <option value="fa fa-truck" class="fa">
                                        &#xf0d1;
                                    </option>
                                    <option value="fa fa-umbrella" class="fa">
                                        &#xf0e9;
                                    </option>
                                    <option value="fa fa-unlock" class="fa">
                                        &#xf09c;
                                    </option>
                                    <option value="fa fa-video-camera" class="fa">
                                        &#xf03d;
                                    </option>
                                    <option value="fa fa-volume-up" class="fa">
                                        &#xf028;
                                    </option>
                                    <option value="fa fa-wrench" class="fa">
                                        &#xf0ad;
                                    </option>
                                    <option value="fa fa-usd" class="fa">
                                        &#xf155;
                                    </option>
                                    <option value="fa fa-adn" class="fa">
                                        &#xf170;
                                    </option>
                                    <option value="fa fa-android" class="fa">
                                        &#xf17b;
                                    </option>
                                    <option value="fa fa-apple" class="fa">
                                        &#xf179;
                                    </option>
                                    <option value="fa fa-bitbucket" class="fa">
                                        &#xf171;
                                    </option>
                                    <option value="fa fa-css3" class="fa">
                                        &#xf13c;
                                    </option>
                                    <option value="fa fa-dribbble" class="fa">
                                        &#xf17d;
                                    </option>
                                    <option value="fa fa-dropbox" class="fa">
                                        &#xf16b;
                                    </option>
                                    <option value="fa fa-facebook" class="fa">
                                        &#xf09a;
                                    </option>
                                    <option value="fa fa-flickr" class="fa">
                                        &#xf16e;
                                    </option>
                                    <option value="fa fa-foursquare" class="fa">
                                        &#xf180;
                                    </option>
                                    <option value="fa fa-github-alt" class="fa">
                                        &#xf113;
                                    </option>
                                    <option value="fa fa-google-plus" class="fa">
                                        &#xf0d5;
                                    </option>
                                    <option value="fa fa-html5" class="fa">
                                        &#xf13b;
                                    </option>
                                    <option value="fa fa-instagram" class="fa">
                                        &#xf16d;
                                    </option>
                                    <option value="fa fa-linkedin" class="fa">
                                        &#xf0e1;
                                    </option>
                                    <option value="fa fa-linux" class="fa">
                                        &#xf17c;
                                    </option>
                                    <option value="fa fa-maxcdn" class="fa">
                                        &#xf136;
                                    </option>
                                    <option value="fa fa-pinterest" class="fa">
                                        &#xf231;
                                    </option>
                                    <option value="fa fa-renren" class="fa">
                                        &#xf18b;
                                    </option>
                                    <option value="fa fa-skype" class="fa">
                                        &#xf17e;
                                    </option>
                                    <option value="fa fa-stack-overflow" class="fa">
                                        &#xf16c;
                                    </option>
                                    <option value="fa fa-tumblr" class="fa">
                                        &#xf173;
                                    </option>
                                    <option value="fa fa-twitter" class="fa">
                                        &#xf099;
                                    </option>
                                    <option value="fa fa-vk" class="fa">
                                        &#xf189;
                                    </option>
                                    <option value="fa fa-weibo" class="fa">
                                        &#xf18a;
                                    </option>
                                    <option value="fa fa-windows" class="fa">
                                        &#xf17a;
                                    </option>
                                    <option value="fa fa-xing" class="fa">
                                        &#xf168;
                                    </option>
                                    <option value="fa fa-youtube-play" class="fa">
                                        &#xf167;
                                    </option>
                                    <option value="fa fa-ambulance" class="fa">
                                        &#xf0f9;
                                    </option>
                                    <option value="fa fa-hospital-o" class="fa">
                                        &#xf0f8;
                                    </option>
                                    <option value="fa fa-user-md" class="fa">
                                        &#xf0f0;
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12 row">
                            <label class="col-sm-4 col-form-label">Titulo del Boton</label>
                            <div class="col-sm-12">
                                <input type="text" placeholder="Asignar un titulo al botón" class="form-control" id="btnAsignar" name="btnAsignar" required>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label class="col-sm-2 col-form-label">A donde dirigiar</label>
                            <div class="col-sm-12">
                                <select class="form-control m-b" id="asignarUrl" name="asignarUrl">
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
                                <input type="text" placeholder="Ingrese una descripción" class="form-control" id="eRDescripcion" name="descripcion" required>
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
                            <label class="col-sm-2 col-form-label">Icono</label>
                            <div class="col-sm-12">
                                <select class="form-control m-b fa" id="eIcono" name="icono">
                                    <option>Seleccione un icono...</option>
                                    
                                    <option value="fa fa-address-book" class="fa">
                                        &#xf2b9;
                                    </option>
                                    <option value="fa fa-address-card" class="fa">
                                        &#xf2bb;
                                    </option>
                                    <option value="fa fa-envelope-open" class="fa">
                                        &#xf2b6;
                                    </option>
                                    <option value="fa fa-etsy" class="fa">
                                        &#xf2d7;  
                                    </option>
                                    <option value="fa fa-grav" class="fa">
                                        &#xf2d6;
                                    </option>
                                    <option value="fa fa-handshake-o" class="fa">
                                        &#xf2b5;
                                    </option>
                                    <option value="fa fa-id-badge" class="fa">
                                        &#xf2c1;
                                    </option>
                                    <option value="fa fa-linode" class="fa">
                                        &#xf2b8;
                                    </option>
                                    <option value="fa fa-meetup" class="fa">
                                        &#xf2e0;
                                    </option>
                                    <option value="fa fa-microchip" class="fa">
                                        &#xf2db;
                                    </option>
                                    <option value="fa fa-podcast" class="fa">
                                        &#xf2ce;
                                    </option>
                                    <option value="fa fa-quora" class="fa">
                                        &#xf2c4;
                                    </option>
                                    <option value="fa fa-ravelry" class="fa">
                                        &#xf2d9;
                                    </option>
                                    <option value="fa fa-snowflake-o" class="fa">
                                        &#xf2dc;
                                    </option>
                                    <option value="fa fa-telegram" class="fa">
                                        &#xf2c6;
                                    </option>
                                    <option value="fa fa-times-rectangle" class="fa">
                                        &#xf2d3;
                                    </option>
                                    <option value="fa fa-user-circle" class="fa">
                                        &#xf2bd;
                                    </option>
                                    <option value="fa fa-user-o" class="fa">
                                        &#xf007;
                                    </option>
                                    <option value="fa fa-window-maximize" class="fa">
                                        &#xf2d0;
                                    </option>
                                    <option value="fa fa-window-minimize" class="fa">
                                        &#xf2d1;
                                    </option>
                                    <option value="fa fa-window-restore" class="fa">
                                        &#xf2d2;
                                    </option>
                                    <option value="fa fa-wpexplorer" class="fa">
                                        &#xf2b9;
                                    </option>
                                    <option value="fa fa-angellist" class="fa">
                                        &#xf2de;
                                    </option>
                                    <option value="fa fa-area-chart" class="fa">
                                        &#xf1fe;
                                    </option>
                                    <option value="fa fa-at" class="fa">
                                        &#xf1fa;
                                    </option>
                                    <option value="fa fa-bell-slash" class="fa">
                                        &#xf1f6;
                                    </option>
                                    <option value="fa fa-bicycle" class="fa">
                                        &#xf206;
                                    </option>
                                    <option value="fa fa-binoculars" class="fa">
                                        &#xf1e5;
                                    </option>
                                    <option value="fa fa-birthday-cake" class="fa">
                                        &#xf1fd;
                                    </option>
                                    <option value="fa fa-bus" class="fa">
                                        &#xf207;
                                    </option>
                                    <option value="fa fa-calculador" class="fa">
                                        &#xf1ec;
                                    </option>
                                    <option value="fa fa-cc-mastercard" class="fa">
                                        &#xf1f1;
                                    </option>
                                    <option value="fa fa-cc-paypal" class="fa">
                                        &#xf1f4;
                                    </option>
                                    <option value="fa fa-cc-visa" class="fa">
                                        &#xf1f0;
                                    </option>
                                    <option value="fa fa-copyright" class="fa">
                                        &#xf1f9;
                                    </option>
                                    <option value="fa fa-futbol-o" class="fa">
                                        &#xf1e3;
                                    </option>
                                    <option value="fa fa-line-chart" class="fa">
                                        &#xf201;
                                    </option>
                                    <option value="fa fa-newspaper-o" class="fa">
                                        &#xf1ea;
                                    </option>
                                    <option value="fa fa-paint-brush" class="fa">
                                        &#xf1fc;
                                    </option>
                                    <option value="fa fa-pie-chart" class="fa">
                                        &#xf200;
                                    </option>
                                    <option value="fa fa-plug" class="fa">
                                        &#xf1e6;
                                    </option>
                                    <option value="fa fa-slideshare" class="fa">
                                        &#xf1e7;
                                    </option>
                                    <option value="fa fa-trash" class="fa">
                                        &#xf1f8;
                                    </option>
                                    <option value="fa fa-tty" class="fa">
                                        &#xf1e4;
                                    </option>
                                    <option value="fa fa-wifi" class="fa">
                                        &#xf1eb;
                                    </option>
                                    <option value="fa fa-yelp" class="fa">
                                        &#xf1e9;
                                    </option>
                                    <option value="fa fa-pagelines" class="fa">
                                        &#xf18c;
                                    </option>
                                    <option value="fa fa-stack-exchange" class="fa">
                                        &#xf18d;
                                    </option>
                                    <option value="fa fa-wheelchair" class="fa">
                                        &#xf193;
                                    </option>
                                    <option value="fa fa-vimeo-square" class="fa">
                                        &#xf194;
                                    </option>
                                    <option value="fa fa-plus-square-o" class="fa">
                                        &#xf0fe;
                                    </option>
                                    <option value="fa fa-automobile" class="fa">
                                        &#xf1b9;
                                    </option>
                                    <option value="fa fa-bank" class="fa">
                                        &#xf19c;
                                    </option>
                                    <option value="fa fa-behance-square" class="fa">
                                        &#xf1b5;
                                    </option>
                                    <option value="fa fa-bomb" class="fa">
                                        &#xf1e2;
                                    </option>
                                    <option value="fa fa-building" class="fa">
                                        &#xf1ad;
                                    </option>
                                    <option value="fa fa-child" class="fa">
                                        &#xf1ae;
                                    </option>
                                    <option value="fa fa-codepen" class="fa">
                                        &#xf1cb;
                                    </option>
                                    <option value="fa fa-cube" class="fa">
                                        &#xf1b2;
                                    </option>
                                    <option value="fa fa-cubes" class="fa">
                                        &#xf1b3;
                                    </option>
                                    <option value="fa fa-database" class="fa">
                                        &#xf1c0;
                                    </option>
                                    <option value="fa fa-delicious" class="fa">
                                        &#xf1a5;
                                    </option>
                                    <option value="fa fa-deviantart" class="fa">
                                        &#xf1bd;
                                    </option>
                                    <option value="fa fa-digg" class="fa">
                                        &#xf1a6;
                                    </option>
                                    <option value="fa fa-drupal" class="fa">
                                        &#xf1a9;
                                    </option>
                                    <option value="fa fa-empire" class="fa">
                                        &#xf1d1;
                                    </option>
                                    <option value="fa fa-fax" class="fa">
                                        &#xf1ac;
                                    </option>
                                    <option value="fa fa-file-archive-o" class="fa">
                                        &#xf1c6;
                                    </option>
                                    <option value="fa fa-file-audio-o" class="fa">
                                        &#xf1c7;
                                    </option>
                                    <option value="fa fa-file-code-o" class="fa">
                                        &#xf1c9;
                                    </option>
                                    <option value="fa fa-file-excel-o" class="fa">
                                        &#xf1c3;
                                    </option>
                                    <option value="fa fa-file-image-o" class="fa">
                                        &#xf1c5;
                                    </option>
                                    <option value="fa fa-file-movie-o" class="fa">
                                        &#xf1c8;
                                    </option>
                                    <option value="fa fa-file-pdf-o" class="fa">
                                        &#xf1c1;
                                    </option>
                                    <option value="fa fa-file-photo-o" class="fa">
                                        &#xf1c5;
                                    </option>
                                    <option value="fa fa-google" class="fa">
                                        &#xf1a0;
                                    </option>
                                    <option value="fa fa-graduation-cap" class="fa">
                                        &#xf19d;
                                    </option>
                                    <option value="fa fa-hacker-news" class="fa">
                                        &#xf1d4;
                                    </option>
                                    <option value="fa fa-header" class="fa">
                                        &#xf1dc;
                                    </option>
                                    <option value="fa fa-history" class="fa">
                                        &#xf1da;
                                    </option>
                                    <option value="fa fa-institution" class="fa">
                                        &#xf19c;
                                    </option>
                                    <option value="fa fa-joomla" class="fa">
                                        &#xf1aa;
                                    </option>
                                    <option value="fa fa-jsfiddle" class="fa">
                                        &#xf1cc;
                                    </option>
                                    <option value="fa fa-language" class="fa">
                                        &#xf1ab;
                                    </option>
                                    <option value="fa fa-life-ring" class="fa">
                                        &#xf1cd;
                                    </option>
                                    <option value="fa fa-openid" class="fa">
                                        &#xf19b;
                                    </option>
                                    <option value="fa fa-paper-plane" class="fa">
                                        &#xf1d8;
                                    </option>
                                    <option value="fa fa-paragraph" class="fa">
                                        &#xf1dd;
                                    </option>
                                    <option value="fa fa-paw" class="fa">
                                        &#xf1b0;
                                    </option>
                                    <option value="fa fa-pied-piper-alt" class="fa">
                                        &#xf1a8;
                                    </option>
                                    <option value="fa fa-qq" class="fa">
                                        &#xf1d6;
                                    </option>
                                    <option value="fa fa-rebel" class="fa">
                                        &#xf1d0;
                                    </option>
                                    <option value="fa fa-recycle" class="fa">
                                        &#xf1b8;
                                    </option>
                                    <option value="fa fa-reddit" class="fa">
                                        &#xf1a1;
                                    </option>
                                    <option value="fa fa-share-alt" class="fa">
                                        &#xf1e0;
                                    </option>
                                    <option value="fa fa-slack" class="fa">
                                        &#xf198;
                                    </option>
                                    <option value="fa fa-sliders" class="fa">
                                        &#xf1de;
                                    </option>
                                    <option value="fa fa-soundcloud" class="fa">
                                        &#xf1be;
                                    </option>
                                    <option value="fa fa-space-shuttle" class="fa">
                                        &#xf197;
                                    </option>
                                    <option value="fa fa-spotify" class="fa">
                                        &#xf1bc;
                                    </option>
                                    <option value="fa fa-steam" class="fa">
                                        &#xf1b6;
                                    </option>
                                    <option value="fa fa-stumbleupon" class="fa">
                                        &#xf1a4;
                                    </option>
                                    <option value="fa fa-taxi" class="fa">
                                        &#xf1ba;
                                    </option>
                                    <option value="fa fa-tencent-weibo" class="fa">
                                        &#xf1d5;
                                    </option>
                                    <option value="fa fa-tree" class="fa">
                                        &#xf1bb;
                                    </option>
                                    <option value="fa fa-weixin" class="fa">
                                        &#xf1d7;
                                    </option>
                                    <option value="fa fa-wordpress" class="fa">
                                        &#xf19a;
                                    </option>
                                    <option value="fa fa-yahoo" class="fa">
                                        &#xf19e;
                                    </option>
                                    <option value="fa fa-anchor" class="fa">
                                        &#xf13d;
                                    </option>
                                    <option value="fa fa-archive" class="fa">
                                        &#xf187;
                                    </option>
                                    <option value="fa fa-asterisk" class="fa">
                                        &#xf069;
                                    </option>
                                    <option value="fa fa-ban" class="fa">
                                        &#xf05e;
                                    </option>
                                    <option value="fa fa-bar-chart-o" class="fa">
                                        &#xf080;
                                    </option>
                                    <option value="fa fa-barcode" class="fa">
                                        &#xf02a;
                                    </option>
                                    <option value="fa fa-beer" class="fa">
                                        &#xf0fc;
                                    </option>
                                    <option value="fa fa-bell" class="fa">
                                        &#xf0f3;
                                    </option>
                                    <option value="fa fa-bolt" class="fa">
                                        &#xf0e7;
                                    </option>
                                    <option value="fa fa-book" class="fa">
                                        &#xf02d;
                                    </option>
                                    <option value="fa fa-bookmark" class="fa">
                                        &#xf02e;
                                    </option>
                                    <option value="fa fa-briefcase" class="fa">
                                        &#xf0b1;
                                    </option>
                                    <option value="fa fa-bug" class="fa">
                                        &#xf188;
                                    </option>
                                    <option value="fa fa-bullhorn" class="fa">
                                        &#xf0a1;
                                    </option>
                                    <option value="fa fa-calendar" class="fa">
                                        &#xf073;
                                    </option>
                                    <option value="fa fa-camera" class="fa">
                                        &#xf030;
                                    </option>
                                    <option value="fa fa-certificate" class="fa">
                                        &#xf0a3;
                                    </option>
                                    <option value="fa fa-check" class="fa">
                                        &#xf00c;
                                    </option>
                                    <option value="fa fa-clock-o" class="fa">
                                        &#xf017;
                                    </option>
                                    <option value="fa fa-cloud" class="fa">
                                        &#xf0c2;
                                    </option>
                                    <option value="fa fa-code" class="fa">
                                        &#xf121;
                                    </option>
                                    <option value="fa fa-code-fork" class="fa">
                                        &#xf126;
                                    </option>
                                    <option value="fa fa-coffee" class="fa">
                                        &#xf0f4;
                                    </option>
                                    <option value="fa fa-cog" class="fa">
                                        &#xf013;
                                    </option>
                                    <option value="fa fa-cogs" class="fa">
                                        &#xf085;
                                    </option>
                                    <option value="fa fa-comments" class="fa">
                                        &#xf086;
                                    </option>
                                    <option value="fa fa-compass" class="fa">
                                        &#xf14e;
                                    </option>
                                    <option value="fa fa-crosshairs" class="fa">
                                        &#xf05b;
                                    </option>
                                    <option value="fa fa-desktop" class="fa">
                                        &#xf108;
                                    </option>
                                    <option value="fa fa-download" class="fa">
                                        &#xf019;
                                    </option>
                                    <option value="fa fa-edit" class="fa">
                                        &#xf044;
                                    </option>
                                    <option value="fa fa-eraser" class="fa">
                                        &#xf12d;
                                    </option>
                                    <option value="fa fa-exclamation-triangle" class="fa">
                                        &#xf071;
                                    </option>
                                    <option value="fa fa-eye" class="fa">
                                        &#xf06e;
                                    </option>
                                    <option value="fa fa-female" class="fa">
                                        &#xf182;
                                    </option>
                                    <option value="fa fa-fire" class="fa">
                                        &#xf06d;
                                    </option>
                                    <option value="fa fa-fire-extinguisher" class="fa">
                                        &#xf134;
                                    </option>
                                    <option value="fa fa-flag" class="fa">
                                        &#xf024;
                                    </option>
                                    <option value="fa fa-flask" class="fa">
                                        &#xf0c3;
                                    </option>
                                    <option value="fa fa-folder" class="fa">
                                        &#xf07b;
                                    </option>
                                    <option value="fa fa-folder-open" class="fa">
                                        &#xf07c;
                                    </option>
                                    <option value="fa fa-frown-o" class="fa">
                                        &#xf119;
                                    </option>
                                    <option value="fa fa-gamepad" class="fa">
                                        &#xf11b;
                                    </option>
                                    <option value="fa fa-gavel" class="fa">
                                        &#xf0e3;
                                    </option>
                                    <option value="fa fa-gift" class="fa">
                                        &#xf06b;
                                    </option>
                                    <option value="fa fa-glass" class="fa">
                                        &#xf000;
                                    </option>
                                    <option value="fa fa-globe" class="fa">
                                        &#xf0ac;
                                    </option>
                                    <option value="fa fa-group" class="fa">
                                        &#xf0c0;
                                    </option>
                                    <option value="fa fa-hdd-o" class="fa">
                                        &#xf0a0;
                                    </option>
                                    <option value="fa fa-headphones" class="fa">
                                        &#xf025;
                                    </option>
                                    <option value="fa fa-heart" class="fa">
                                        &#xf21e;
                                    </option>
                                    <option value="fa fa-home" class="fa">
                                        &#xf015;
                                    </option>
                                    <option value="fa fa-inbox" class="fa">
                                        &#xf01c;
                                    </option>
                                    <option value="fa fa-info" class="fa">
                                        &#xf129;
                                    </option>
                                    <option value="fa fa-key" class="fa">
                                        &#xf084;
                                    </option>
                                    <option value="fa fa-keyboard-o" class="fa">
                                        &#xf11c;
                                    </option>
                                    <option value="fa fa-laptop" class="fa">
                                        &#xf109;
                                    </option>
                                    <option value="fa fa-leaf" class="fa">
                                        &#xf06c;
                                    </option>
                                    <option value="fa fa-lemon-o" class="fa">
                                        &#xf094;
                                    </option>
                                    <option value="fa fa-lightbulb-o" class="fa">
                                        &#xf0eb;
                                    </option>
                                    <option value="fa fa-lock" class="fa">
                                        &#xf023;
                                    </option>
                                    <option value="fa fa-magic" class="fa">
                                        &#xf0d0;
                                    </option>
                                    <option value="fa fa-magnet" class="fa">
                                        &#xf076;
                                    </option>
                                    <option value="fa fa-map-marker" class="fa">
                                        &#xf041;
                                    </option>
                                    <option value="fa fa-meh-o" class="fa">
                                        &#xf11a;
                                    </option>
                                    <option value="fa fa-microphone" class="fa">
                                        &#xf130;
                                    </option>
                                    <option value="fa fa-minus" class="fa">
                                        &#xf068;
                                    </option>
                                    <option value="fa fa-money" class="fa">
                                        &#xf0d6;
                                    </option>
                                    <option value="fa fa-moon-o" class="fa">
                                        &#xf186;
                                    </option>
                                    <option value="fa fa-music" class="fa">
                                        &#xf001;
                                    </option>
                                    <option value="fa fa-pencil" class="fa">
                                        &#xf040;
                                    </option>
                                    <option value="fa fa-phone" class="fa">
                                        &#xf095;
                                    </option>
                                    <option value="fa fa-picture-o" class="fa">
                                        &#xf03e;
                                    </option>
                                    <option value="fa fa-plus" class="fa">
                                        &#xf067;
                                    </option>
                                    <option value="fa fa-power-off" class="fa">
                                        &#xf011;
                                    </option>
                                    <option value="fa fa-print" class="fa">
                                        &#xf02f;
                                    </option>
                                    <option value="fa fa-puzzle-piece" class="fa">
                                        &#xf12e;
                                    </option>
                                    <option value="fa fa-qrcode" class="fa">
                                        &#xf029;
                                    </option>
                                    <option value="fa fa-question" class="fa">
                                        &#xf128;
                                    </option>
                                    <option value="fa fa-road" class="fa">
                                        &#xf018;
                                    </option>
                                    <option value="fa fa-rocket" class="fa">
                                        &#xf135;
                                    </option>
                                    <option value="fa fa-rss" class="fa">
                                        &#xf09e;
                                    </option>
                                    <option value="fa fa-search" class="fa">
                                        &#xf00e;
                                    </option>
                                    <option value="fa fa-shield" class="fa">
                                        &#xf132;
                                    </option>

                                    <option value="fa fa-shopping-cart" class="fa">
                                        &#xf07a;
                                    </option>
                                    <option value="fa fa-signal" class="fa">
                                        &#xf012;
                                    </option>
                                    <option value="fa fa-sitemap" class="fa">
                                        &#xf0e8;
                                    </option>
                                    <option value="fa fa-smile-o" class="fa">
                                        &#xf118;
                                    </option>
                                    <option value="fa fa-spinner" class="fa">
                                        &#xf110;
                                    </option>
                                    <option value="fa fa-star" class="fa">
                                        &#xf005;
                                    </option>
                                    <option value="fa fa-suitcase" class="fa">
                                        &#xf0f2;
                                    </option>
                                    <option value="fa fa-sun-o" class="fa">
                                        &#xf185;
                                    </option>
                                    <option value="fa fa-tag" class="fa">
                                        &#xf02b;
                                    </option>
                                    <option value="fa fa-terminal" class="fa">
                                        &#xf120;
                                    </option>
                                    <option value="fa fa-thumb-tack" class="fa">
                                        &#xf08d;
                                    </option>
                                    <option value="fa fa-thumbs-o-down" class="fa">
                                        &#xf165;
                                    </option>
                                    <option value="fa fa-thumbs-o-up" class="fa">
                                        &#xf164;
                                    </option>
                                    <option value="fa fa-ticket" class="fa">
                                        &#xf145;
                                    </option>
                                    <option value="fa fa-tint" class="fa">
                                        &#xf043;
                                    </option>
                                    <option value="fa fa-trophy" class="fa">
                                        &#xf091;
                                    </option>
                                    <option value="fa fa-truck" class="fa">
                                        &#xf0d1;
                                    </option>
                                    <option value="fa fa-umbrella" class="fa">
                                        &#xf0e9;
                                    </option>
                                    <option value="fa fa-unlock" class="fa">
                                        &#xf09c;
                                    </option>
                                    <option value="fa fa-video-camera" class="fa">
                                        &#xf03d;
                                    </option>
                                    <option value="fa fa-volume-up" class="fa">
                                        &#xf028;
                                    </option>
                                    <option value="fa fa-wrench" class="fa">
                                        &#xf0ad;
                                    </option>
                                    <option value="fa fa-usd" class="fa">
                                        &#xf155;
                                    </option>
                                    <option value="fa fa-adn" class="fa">
                                        &#xf170;
                                    </option>
                                    <option value="fa fa-android" class="fa">
                                        &#xf17b;
                                    </option>
                                    <option value="fa fa-apple" class="fa">
                                        &#xf179;
                                    </option>
                                    <option value="fa fa-bitbucket" class="fa">
                                        &#xf171;
                                    </option>
                                    <option value="fa fa-css3" class="fa">
                                        &#xf13c;
                                    </option>
                                    <option value="fa fa-dribbble" class="fa">
                                        &#xf17d;
                                    </option>
                                    <option value="fa fa-dropbox" class="fa">
                                        &#xf16b;
                                    </option>
                                    <option value="fa fa-facebook" class="fa">
                                        &#xf09a;
                                    </option>
                                    <option value="fa fa-flickr" class="fa">
                                        &#xf16e;
                                    </option>
                                    <option value="fa fa-foursquare" class="fa">
                                        &#xf180;
                                    </option>
                                    <option value="fa fa-github-alt" class="fa">
                                        &#xf113;
                                    </option>
                                    <option value="fa fa-google-plus" class="fa">
                                        &#xf0d5;
                                    </option>
                                    <option value="fa fa-html5" class="fa">
                                        &#xf13b;
                                    </option>
                                    <option value="fa fa-instagram" class="fa">
                                        &#xf16d;
                                    </option>
                                    <option value="fa fa-linkedin" class="fa">
                                        &#xf0e1;
                                    </option>
                                    <option value="fa fa-linux" class="fa">
                                        &#xf17c;
                                    </option>
                                    <option value="fa fa-maxcdn" class="fa">
                                        &#xf136;
                                    </option>
                                    <option value="fa fa-pinterest" class="fa">
                                        &#xf231;
                                    </option>
                                    <option value="fa fa-renren" class="fa">
                                        &#xf18b;
                                    </option>
                                    <option value="fa fa-skype" class="fa">
                                        &#xf17e;
                                    </option>
                                    <option value="fa fa-stack-overflow" class="fa">
                                        &#xf16c;
                                    </option>
                                    <option value="fa fa-tumblr" class="fa">
                                        &#xf173;
                                    </option>
                                    <option value="fa fa-twitter" class="fa">
                                        &#xf099;
                                    </option>
                                    <option value="fa fa-vk" class="fa">
                                        &#xf189;
                                    </option>
                                    <option value="fa fa-weibo" class="fa">
                                        &#xf18a;
                                    </option>
                                    <option value="fa fa-windows" class="fa">
                                        &#xf17a;
                                    </option>
                                    <option value="fa fa-xing" class="fa">
                                        &#xf168;
                                    </option>
                                    <option value="fa fa-youtube-play" class="fa">
                                        &#xf167;
                                    </option>
                                    <option value="fa fa-ambulance" class="fa">
                                        &#xf0f9;
                                    </option>
                                    <option value="fa fa-hospital-o" class="fa">
                                        &#xf0f8;
                                    </option>
                                    <option value="fa fa-user-md" class="fa">
                                        &#xf0f0;
                                    </option>
                                </select>
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

<!-- Por que elegirnos -->
<!-- Crear -->

<div class="modal inmodal fade" id="porQueElegirnos" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Subir Por que Elegirnos</h4>
            </div>
            <form id="fporQueElegirnos" name="fporQueElegirnos" method="post" action="guardarPorQueElegirnos" class="formPorQueElegirnos" enctype="multipart/form-data">
            <div class="modal-body">
                
                    <div class="form-group row">
                        <input type="text" name="_token" id="_token" hidden value="{{ csrf_token() }}">
                        <div class="col-md-12 row">
                            <label class="col-sm-4 col-form-label">Titulo</label>
                            <div class="col-sm-12">
                                <input type="text" placeholder="Asignar un titulo al por que elegirnos" class="form-control" id="titulo" name="titulo" required>
                            </div>
                        </div>

                        <div class="col-md-12 row">
                            <label class="col-sm-4 col-form-label">Descripción</label>
                            <div class="col-sm-12">
                                <input type="text" placeholder="Ingrese una descripción" class="form-control" id="descripcion" name="descripcion" required>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label class="col-sm-2 col-form-label">Icono</label>
                            <div class="col-sm-12">
                                <select class="form-control m-b fa" id="icono" name="icono">
                                    <option>Seleccione un icono...</option>
                                    <option value="fa fa-address-book" class="fa">
                                        &#xf2b9;
                                    </option>
                                    <option value="fa fa-address-card" class="fa">
                                        &#xf2bb;
                                    </option>
                                    <option value="fa fa-envelope-open" class="fa">
                                        &#xf2b6;
                                    </option>
                                    <option value="fa fa-etsy" class="fa">
                                        &#xf2d7;  
                                    </option>
                                    <option value="fa fa-grav" class="fa">
                                        &#xf2d6;
                                    </option>
                                    <option value="fa fa-handshake-o" class="fa">
                                        &#xf2b5;
                                    </option>
                                    <option value="fa fa-id-badge" class="fa">
                                        &#xf2c1;
                                    </option>
                                    <option value="fa fa-linode" class="fa">
                                        &#xf2b8;
                                    </option>
                                    <option value="fa fa-meetup" class="fa">
                                        &#xf2e0;
                                    </option>
                                    <option value="fa fa-microchip" class="fa">
                                        &#xf2db;
                                    </option>
                                    <option value="fa fa-podcast" class="fa">
                                        &#xf2ce;
                                    </option>
                                    <option value="fa fa-quora" class="fa">
                                        &#xf2c4;
                                    </option>
                                    <option value="fa fa-ravelry" class="fa">
                                        &#xf2d9;
                                    </option>
                                    <option value="fa fa-snowflake-o" class="fa">
                                        &#xf2dc;
                                    </option>
                                    <option value="fa fa-telegram" class="fa">
                                        &#xf2c6;
                                    </option>
                                    <option value="fa fa-times-rectangle" class="fa">
                                        &#xf2d3;
                                    </option>
                                    <option value="fa fa-user-circle" class="fa">
                                        &#xf2bd;
                                    </option>
                                    <option value="fa fa-user-o" class="fa">
                                        &#xf007;
                                    </option>
                                    <option value="fa fa-window-maximize" class="fa">
                                        &#xf2d0;
                                    </option>
                                    <option value="fa fa-window-minimize" class="fa">
                                        &#xf2d1;
                                    </option>
                                    <option value="fa fa-window-restore" class="fa">
                                        &#xf2d2;
                                    </option>
                                    <option value="fa fa-wpexplorer" class="fa">
                                        &#xf2b9;
                                    </option>
                                    <option value="fa fa-angellist" class="fa">
                                        &#xf2de;
                                    </option>
                                    <option value="fa fa-area-chart" class="fa">
                                        &#xf1fe;
                                    </option>
                                    <option value="fa fa-at" class="fa">
                                        &#xf1fa;
                                    </option>
                                    <option value="fa fa-bell-slash" class="fa">
                                        &#xf1f6;
                                    </option>
                                    <option value="fa fa-bicycle" class="fa">
                                        &#xf206;
                                    </option>
                                    <option value="fa fa-binoculars" class="fa">
                                        &#xf1e5;
                                    </option>
                                    <option value="fa fa-birthday-cake" class="fa">
                                        &#xf1fd;
                                    </option>
                                    <option value="fa fa-bus" class="fa">
                                        &#xf207;
                                    </option>
                                    <option value="fa fa-calculador" class="fa">
                                        &#xf1ec;
                                    </option>
                                    <option value="fa fa-cc-mastercard" class="fa">
                                        &#xf1f1;
                                    </option>
                                    <option value="fa fa-cc-paypal" class="fa">
                                        &#xf1f4;
                                    </option>
                                    <option value="fa fa-cc-visa" class="fa">
                                        &#xf1f0;
                                    </option>
                                    <option value="fa fa-copyright" class="fa">
                                        &#xf1f9;
                                    </option>
                                    <option value="fa fa-futbol-o" class="fa">
                                        &#xf1e3;
                                    </option>
                                    <option value="fa fa-line-chart" class="fa">
                                        &#xf201;
                                    </option>
                                    <option value="fa fa-newspaper-o" class="fa">
                                        &#xf1ea;
                                    </option>
                                    <option value="fa fa-paint-brush" class="fa">
                                        &#xf1fc;
                                    </option>
                                    <option value="fa fa-pie-chart" class="fa">
                                        &#xf200;
                                    </option>
                                    <option value="fa fa-plug" class="fa">
                                        &#xf1e6;
                                    </option>
                                    <option value="fa fa-slideshare" class="fa">
                                        &#xf1e7;
                                    </option>
                                    <option value="fa fa-trash" class="fa">
                                        &#xf1f8;
                                    </option>
                                    <option value="fa fa-tty" class="fa">
                                        &#xf1e4;
                                    </option>
                                    <option value="fa fa-wifi" class="fa">
                                        &#xf1eb;
                                    </option>
                                    <option value="fa fa-yelp" class="fa">
                                        &#xf1e9;
                                    </option>
                                    <option value="fa fa-pagelines" class="fa">
                                        &#xf18c;
                                    </option>
                                    <option value="fa fa-stack-exchange" class="fa">
                                        &#xf18d;
                                    </option>
                                    <option value="fa fa-wheelchair" class="fa">
                                        &#xf193;
                                    </option>
                                    <option value="fa fa-vimeo-square" class="fa">
                                        &#xf194;
                                    </option>
                                    <option value="fa fa-plus-square-o" class="fa">
                                        &#xf0fe;
                                    </option>
                                    <option value="fa fa-automobile" class="fa">
                                        &#xf1b9;
                                    </option>
                                    <option value="fa fa-bank" class="fa">
                                        &#xf19c;
                                    </option>
                                    <option value="fa fa-behance-square" class="fa">
                                        &#xf1b5;
                                    </option>
                                    <option value="fa fa-bomb" class="fa">
                                        &#xf1e2;
                                    </option>
                                    <option value="fa fa-building" class="fa">
                                        &#xf1ad;
                                    </option>
                                    <option value="fa fa-child" class="fa">
                                        &#xf1ae;
                                    </option>
                                    <option value="fa fa-codepen" class="fa">
                                        &#xf1cb;
                                    </option>
                                    <option value="fa fa-cube" class="fa">
                                        &#xf1b2;
                                    </option>
                                    <option value="fa fa-cubes" class="fa">
                                        &#xf1b3;
                                    </option>
                                    <option value="fa fa-database" class="fa">
                                        &#xf1c0;
                                    </option>
                                    <option value="fa fa-delicious" class="fa">
                                        &#xf1a5;
                                    </option>
                                    <option value="fa fa-deviantart" class="fa">
                                        &#xf1bd;
                                    </option>
                                    <option value="fa fa-digg" class="fa">
                                        &#xf1a6;
                                    </option>
                                    <option value="fa fa-drupal" class="fa">
                                        &#xf1a9;
                                    </option>
                                    <option value="fa fa-empire" class="fa">
                                        &#xf1d1;
                                    </option>
                                    <option value="fa fa-fax" class="fa">
                                        &#xf1ac;
                                    </option>
                                    <option value="fa fa-file-archive-o" class="fa">
                                        &#xf1c6;
                                    </option>
                                    <option value="fa fa-file-audio-o" class="fa">
                                        &#xf1c7;
                                    </option>
                                    <option value="fa fa-file-code-o" class="fa">
                                        &#xf1c9;
                                    </option>
                                    <option value="fa fa-file-excel-o" class="fa">
                                        &#xf1c3;
                                    </option>
                                    <option value="fa fa-file-image-o" class="fa">
                                        &#xf1c5;
                                    </option>
                                    <option value="fa fa-file-movie-o" class="fa">
                                        &#xf1c8;
                                    </option>
                                    <option value="fa fa-file-pdf-o" class="fa">
                                        &#xf1c1;
                                    </option>
                                    <option value="fa fa-file-photo-o" class="fa">
                                        &#xf1c5;
                                    </option>
                                    <option value="fa fa-google" class="fa">
                                        &#xf1a0;
                                    </option>
                                    <option value="fa fa-graduation-cap" class="fa">
                                        &#xf19d;
                                    </option>
                                    <option value="fa fa-hacker-news" class="fa">
                                        &#xf1d4;
                                    </option>
                                    <option value="fa fa-header" class="fa">
                                        &#xf1dc;
                                    </option>
                                    <option value="fa fa-history" class="fa">
                                        &#xf1da;
                                    </option>
                                    <option value="fa fa-institution" class="fa">
                                        &#xf19c;
                                    </option>
                                    <option value="fa fa-joomla" class="fa">
                                        &#xf1aa;
                                    </option>
                                    <option value="fa fa-jsfiddle" class="fa">
                                        &#xf1cc;
                                    </option>
                                    <option value="fa fa-language" class="fa">
                                        &#xf1ab;
                                    </option>
                                    <option value="fa fa-life-ring" class="fa">
                                        &#xf1cd;
                                    </option>
                                    <option value="fa fa-openid" class="fa">
                                        &#xf19b;
                                    </option>
                                    <option value="fa fa-paper-plane" class="fa">
                                        &#xf1d8;
                                    </option>
                                    <option value="fa fa-paragraph" class="fa">
                                        &#xf1dd;
                                    </option>
                                    <option value="fa fa-paw" class="fa">
                                        &#xf1b0;
                                    </option>
                                    <option value="fa fa-pied-piper-alt" class="fa">
                                        &#xf1a8;
                                    </option>
                                    <option value="fa fa-qq" class="fa">
                                        &#xf1d6;
                                    </option>
                                    <option value="fa fa-rebel" class="fa">
                                        &#xf1d0;
                                    </option>
                                    <option value="fa fa-recycle" class="fa">
                                        &#xf1b8;
                                    </option>
                                    <option value="fa fa-reddit" class="fa">
                                        &#xf1a1;
                                    </option>
                                    <option value="fa fa-share-alt" class="fa">
                                        &#xf1e0;
                                    </option>
                                    <option value="fa fa-slack" class="fa">
                                        &#xf198;
                                    </option>
                                    <option value="fa fa-sliders" class="fa">
                                        &#xf1de;
                                    </option>
                                    <option value="fa fa-soundcloud" class="fa">
                                        &#xf1be;
                                    </option>
                                    <option value="fa fa-space-shuttle" class="fa">
                                        &#xf197;
                                    </option>
                                    <option value="fa fa-spotify" class="fa">
                                        &#xf1bc;
                                    </option>
                                    <option value="fa fa-steam" class="fa">
                                        &#xf1b6;
                                    </option>
                                    <option value="fa fa-stumbleupon" class="fa">
                                        &#xf1a4;
                                    </option>
                                    <option value="fa fa-taxi" class="fa">
                                        &#xf1ba;
                                    </option>
                                    <option value="fa fa-tencent-weibo" class="fa">
                                        &#xf1d5;
                                    </option>
                                    <option value="fa fa-tree" class="fa">
                                        &#xf1bb;
                                    </option>
                                    <option value="fa fa-weixin" class="fa">
                                        &#xf1d7;
                                    </option>
                                    <option value="fa fa-wordpress" class="fa">
                                        &#xf19a;
                                    </option>
                                    <option value="fa fa-yahoo" class="fa">
                                        &#xf19e;
                                    </option>
                                    <option value="fa fa-anchor" class="fa">
                                        &#xf13d;
                                    </option>
                                    <option value="fa fa-archive" class="fa">
                                        &#xf187;
                                    </option>
                                    <option value="fa fa-asterisk" class="fa">
                                        &#xf069;
                                    </option>
                                    <option value="fa fa-ban" class="fa">
                                        &#xf05e;
                                    </option>
                                    <option value="fa fa-bar-chart-o" class="fa">
                                        &#xf080;
                                    </option>
                                    <option value="fa fa-barcode" class="fa">
                                        &#xf02a;
                                    </option>
                                    <option value="fa fa-beer" class="fa">
                                        &#xf0fc;
                                    </option>
                                    <option value="fa fa-bell" class="fa">
                                        &#xf0f3;
                                    </option>
                                    <option value="fa fa-bolt" class="fa">
                                        &#xf0e7;
                                    </option>
                                    <option value="fa fa-book" class="fa">
                                        &#xf02d;
                                    </option>
                                    <option value="fa fa-bookmark" class="fa">
                                        &#xf02e;
                                    </option>
                                    <option value="fa fa-briefcase" class="fa">
                                        &#xf0b1;
                                    </option>
                                    <option value="fa fa-bug" class="fa">
                                        &#xf188;
                                    </option>
                                    <option value="fa fa-bullhorn" class="fa">
                                        &#xf0a1;
                                    </option>
                                    <option value="fa fa-calendar" class="fa">
                                        &#xf073;
                                    </option>
                                    <option value="fa fa-camera" class="fa">
                                        &#xf030;
                                    </option>
                                    <option value="fa fa-certificate" class="fa">
                                        &#xf0a3;
                                    </option>
                                    <option value="fa fa-check" class="fa">
                                        &#xf00c;
                                    </option>
                                    <option value="fa fa-clock-o" class="fa">
                                        &#xf017;
                                    </option>
                                    <option value="fa fa-cloud" class="fa">
                                        &#xf0c2;
                                    </option>
                                    <option value="fa fa-code" class="fa">
                                        &#xf121;
                                    </option>
                                    <option value="fa fa-code-fork" class="fa">
                                        &#xf126;
                                    </option>
                                    <option value="fa fa-coffee" class="fa">
                                        &#xf0f4;
                                    </option>
                                    <option value="fa fa-cog" class="fa">
                                        &#xf013;
                                    </option>
                                    <option value="fa fa-cogs" class="fa">
                                        &#xf085;
                                    </option>
                                    <option value="fa fa-comments" class="fa">
                                        &#xf086;
                                    </option>
                                    <option value="fa fa-compass" class="fa">
                                        &#xf14e;
                                    </option>
                                    <option value="fa fa-crosshairs" class="fa">
                                        &#xf05b;
                                    </option>
                                    <option value="fa fa-desktop" class="fa">
                                        &#xf108;
                                    </option>
                                    <option value="fa fa-download" class="fa">
                                        &#xf019;
                                    </option>
                                    <option value="fa fa-edit" class="fa">
                                        &#xf044;
                                    </option>
                                    <option value="fa fa-eraser" class="fa">
                                        &#xf12d;
                                    </option>
                                    <option value="fa fa-exclamation-triangle" class="fa">
                                        &#xf071;
                                    </option>
                                    <option value="fa fa-eye" class="fa">
                                        &#xf06e;
                                    </option>
                                    <option value="fa fa-female" class="fa">
                                        &#xf182;
                                    </option>
                                    <option value="fa fa-fire" class="fa">
                                        &#xf06d;
                                    </option>
                                    <option value="fa fa-fire-extinguisher" class="fa">
                                        &#xf134;
                                    </option>
                                    <option value="fa fa-flag" class="fa">
                                        &#xf024;
                                    </option>
                                    <option value="fa fa-flask" class="fa">
                                        &#xf0c3;
                                    </option>
                                    <option value="fa fa-folder" class="fa">
                                        &#xf07b;
                                    </option>
                                    <option value="fa fa-folder-open" class="fa">
                                        &#xf07c;
                                    </option>
                                    <option value="fa fa-frown-o" class="fa">
                                        &#xf119;
                                    </option>
                                    <option value="fa fa-gamepad" class="fa">
                                        &#xf11b;
                                    </option>
                                    <option value="fa fa-gavel" class="fa">
                                        &#xf0e3;
                                    </option>
                                    <option value="fa fa-gift" class="fa">
                                        &#xf06b;
                                    </option>
                                    <option value="fa fa-glass" class="fa">
                                        &#xf000;
                                    </option>
                                    <option value="fa fa-globe" class="fa">
                                        &#xf0ac;
                                    </option>
                                    <option value="fa fa-group" class="fa">
                                        &#xf0c0;
                                    </option>
                                    <option value="fa fa-hdd-o" class="fa">
                                        &#xf0a0;
                                    </option>
                                    <option value="fa fa-headphones" class="fa">
                                        &#xf025;
                                    </option>
                                    <option value="fa fa-heart" class="fa">
                                        &#xf21e;
                                    </option>
                                    <option value="fa fa-home" class="fa">
                                        &#xf015;
                                    </option>
                                    <option value="fa fa-inbox" class="fa">
                                        &#xf01c;
                                    </option>
                                    <option value="fa fa-info" class="fa">
                                        &#xf129;
                                    </option>
                                    <option value="fa fa-key" class="fa">
                                        &#xf084;
                                    </option>
                                    <option value="fa fa-keyboard-o" class="fa">
                                        &#xf11c;
                                    </option>
                                    <option value="fa fa-laptop" class="fa">
                                        &#xf109;
                                    </option>
                                    <option value="fa fa-leaf" class="fa">
                                        &#xf06c;
                                    </option>
                                    <option value="fa fa-lemon-o" class="fa">
                                        &#xf094;
                                    </option>
                                    <option value="fa fa-lightbulb-o" class="fa">
                                        &#xf0eb;
                                    </option>
                                    <option value="fa fa-lock" class="fa">
                                        &#xf023;
                                    </option>
                                    <option value="fa fa-magic" class="fa">
                                        &#xf0d0;
                                    </option>
                                    <option value="fa fa-magnet" class="fa">
                                        &#xf076;
                                    </option>
                                    <option value="fa fa-map-marker" class="fa">
                                        &#xf041;
                                    </option>
                                    <option value="fa fa-meh-o" class="fa">
                                        &#xf11a;
                                    </option>
                                    <option value="fa fa-microphone" class="fa">
                                        &#xf130;
                                    </option>
                                    <option value="fa fa-minus" class="fa">
                                        &#xf068;
                                    </option>
                                    <option value="fa fa-money" class="fa">
                                        &#xf0d6;
                                    </option>
                                    <option value="fa fa-moon-o" class="fa">
                                        &#xf186;
                                    </option>
                                    <option value="fa fa-music" class="fa">
                                        &#xf001;
                                    </option>
                                    <option value="fa fa-pencil" class="fa">
                                        &#xf040;
                                    </option>
                                    <option value="fa fa-phone" class="fa">
                                        &#xf095;
                                    </option>
                                    <option value="fa fa-picture-o" class="fa">
                                        &#xf03e;
                                    </option>
                                    <option value="fa fa-plus" class="fa">
                                        &#xf067;
                                    </option>
                                    <option value="fa fa-power-off" class="fa">
                                        &#xf011;
                                    </option>
                                    <option value="fa fa-print" class="fa">
                                        &#xf02f;
                                    </option>
                                    <option value="fa fa-puzzle-piece" class="fa">
                                        &#xf12e;
                                    </option>
                                    <option value="fa fa-qrcode" class="fa">
                                        &#xf029;
                                    </option>
                                    <option value="fa fa-question" class="fa">
                                        &#xf128;
                                    </option>
                                    <option value="fa fa-road" class="fa">
                                        &#xf018;
                                    </option>
                                    <option value="fa fa-rocket" class="fa">
                                        &#xf135;
                                    </option>
                                    <option value="fa fa-rss" class="fa">
                                        &#xf09e;
                                    </option>
                                    <option value="fa fa-search" class="fa">
                                        &#xf00e;
                                    </option>
                                    <option value="fa fa-shield" class="fa">
                                        &#xf132;
                                    </option>

                                    <option value="fa fa-shopping-cart" class="fa">
                                        &#xf07a;
                                    </option>
                                    <option value="fa fa-signal" class="fa">
                                        &#xf012;
                                    </option>
                                    <option value="fa fa-sitemap" class="fa">
                                        &#xf0e8;
                                    </option>
                                    <option value="fa fa-smile-o" class="fa">
                                        &#xf118;
                                    </option>
                                    <option value="fa fa-spinner" class="fa">
                                        &#xf110;
                                    </option>
                                    <option value="fa fa-star" class="fa">
                                        &#xf005;
                                    </option>
                                    <option value="fa fa-suitcase" class="fa">
                                        &#xf0f2;
                                    </option>
                                    <option value="fa fa-sun-o" class="fa">
                                        &#xf185;
                                    </option>
                                    <option value="fa fa-tag" class="fa">
                                        &#xf02b;
                                    </option>
                                    <option value="fa fa-terminal" class="fa">
                                        &#xf120;
                                    </option>
                                    <option value="fa fa-thumb-tack" class="fa">
                                        &#xf08d;
                                    </option>
                                    <option value="fa fa-thumbs-o-down" class="fa">
                                        &#xf165;
                                    </option>
                                    <option value="fa fa-thumbs-o-up" class="fa">
                                        &#xf164;
                                    </option>
                                    <option value="fa fa-ticket" class="fa">
                                        &#xf145;
                                    </option>
                                    <option value="fa fa-tint" class="fa">
                                        &#xf043;
                                    </option>
                                    <option value="fa fa-trophy" class="fa">
                                        &#xf091;
                                    </option>
                                    <option value="fa fa-truck" class="fa">
                                        &#xf0d1;
                                    </option>
                                    <option value="fa fa-umbrella" class="fa">
                                        &#xf0e9;
                                    </option>
                                    <option value="fa fa-unlock" class="fa">
                                        &#xf09c;
                                    </option>
                                    <option value="fa fa-video-camera" class="fa">
                                        &#xf03d;
                                    </option>
                                    <option value="fa fa-volume-up" class="fa">
                                        &#xf028;
                                    </option>
                                    <option value="fa fa-wrench" class="fa">
                                        &#xf0ad;
                                    </option>
                                    <option value="fa fa-usd" class="fa">
                                        &#xf155;
                                    </option>
                                    <option value="fa fa-adn" class="fa">
                                        &#xf170;
                                    </option>
                                    <option value="fa fa-android" class="fa">
                                        &#xf17b;
                                    </option>
                                    <option value="fa fa-apple" class="fa">
                                        &#xf179;
                                    </option>
                                    <option value="fa fa-bitbucket" class="fa">
                                        &#xf171;
                                    </option>
                                    <option value="fa fa-css3" class="fa">
                                        &#xf13c;
                                    </option>
                                    <option value="fa fa-dribbble" class="fa">
                                        &#xf17d;
                                    </option>
                                    <option value="fa fa-dropbox" class="fa">
                                        &#xf16b;
                                    </option>
                                    <option value="fa fa-facebook" class="fa">
                                        &#xf09a;
                                    </option>
                                    <option value="fa fa-flickr" class="fa">
                                        &#xf16e;
                                    </option>
                                    <option value="fa fa-foursquare" class="fa">
                                        &#xf180;
                                    </option>
                                    <option value="fa fa-github-alt" class="fa">
                                        &#xf113;
                                    </option>
                                    <option value="fa fa-google-plus" class="fa">
                                        &#xf0d5;
                                    </option>
                                    <option value="fa fa-html5" class="fa">
                                        &#xf13b;
                                    </option>
                                    <option value="fa fa-instagram" class="fa">
                                        &#xf16d;
                                    </option>
                                    <option value="fa fa-linkedin" class="fa">
                                        &#xf0e1;
                                    </option>
                                    <option value="fa fa-linux" class="fa">
                                        &#xf17c;
                                    </option>
                                    <option value="fa fa-maxcdn" class="fa">
                                        &#xf136;
                                    </option>
                                    <option value="fa fa-pinterest" class="fa">
                                        &#xf231;
                                    </option>
                                    <option value="fa fa-renren" class="fa">
                                        &#xf18b;
                                    </option>
                                    <option value="fa fa-skype" class="fa">
                                        &#xf17e;
                                    </option>
                                    <option value="fa fa-stack-overflow" class="fa">
                                        &#xf16c;
                                    </option>
                                    <option value="fa fa-tumblr" class="fa">
                                        &#xf173;
                                    </option>
                                    <option value="fa fa-twitter" class="fa">
                                        &#xf099;
                                    </option>
                                    <option value="fa fa-vk" class="fa">
                                        &#xf189;
                                    </option>
                                    <option value="fa fa-weibo" class="fa">
                                        &#xf18a;
                                    </option>
                                    <option value="fa fa-windows" class="fa">
                                        &#xf17a;
                                    </option>
                                    <option value="fa fa-xing" class="fa">
                                        &#xf168;
                                    </option>
                                    <option value="fa fa-youtube-play" class="fa">
                                        &#xf167;
                                    </option>
                                    <option value="fa fa-ambulance" class="fa">
                                        &#xf0f9;
                                    </option>
                                    <option value="fa fa-hospital-o" class="fa">
                                        &#xf0f8;
                                    </option>
                                    <option value="fa fa-user-md" class="fa">
                                        &#xf0f0;
                                    </option>
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

<div class="modal inmodal fade" id="ePorQueElegirnos" tabindex="-1" role="dialog"  aria-hidden="true">
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
                            <label class="col-sm-2 col-form-label">Icono</label>
                            <div class="col-sm-12">
                                <select class="form-control m-b fa" id="ePqEIcono" name="icono">
                                    <option>Seleccione un icono...</option>
                                    <option value="fa fa-address-book" class="fa">
                                        &#xf2b9;
                                    </option>
                                    <option value="fa fa-address-card" class="fa">
                                        &#xf2bb;
                                    </option>
                                    <option value="fa fa-envelope-open" class="fa">
                                        &#xf2b6;
                                    </option>
                                    <option value="fa fa-etsy" class="fa">
                                        &#xf2d7;  
                                    </option>
                                    <option value="fa fa-grav" class="fa">
                                        &#xf2d6;
                                    </option>
                                    <option value="fa fa-handshake-o" class="fa">
                                        &#xf2b5;
                                    </option>
                                    <option value="fa fa-id-badge" class="fa">
                                        &#xf2c1;
                                    </option>
                                    <option value="fa fa-linode" class="fa">
                                        &#xf2b8;
                                    </option>
                                    <option value="fa fa-meetup" class="fa">
                                        &#xf2e0;
                                    </option>
                                    <option value="fa fa-microchip" class="fa">
                                        &#xf2db;
                                    </option>
                                    <option value="fa fa-podcast" class="fa">
                                        &#xf2ce;
                                    </option>
                                    <option value="fa fa-quora" class="fa">
                                        &#xf2c4;
                                    </option>
                                    <option value="fa fa-ravelry" class="fa">
                                        &#xf2d9;
                                    </option>
                                    <option value="fa fa-snowflake-o" class="fa">
                                        &#xf2dc;
                                    </option>
                                    <option value="fa fa-telegram" class="fa">
                                        &#xf2c6;
                                    </option>
                                    <option value="fa fa-times-rectangle" class="fa">
                                        &#xf2d3;
                                    </option>
                                    <option value="fa fa-user-circle" class="fa">
                                        &#xf2bd;
                                    </option>
                                    <option value="fa fa-user-o" class="fa">
                                        &#xf007;
                                    </option>
                                    <option value="fa fa-window-maximize" class="fa">
                                        &#xf2d0;
                                    </option>
                                    <option value="fa fa-window-minimize" class="fa">
                                        &#xf2d1;
                                    </option>
                                    <option value="fa fa-window-restore" class="fa">
                                        &#xf2d2;
                                    </option>
                                    <option value="fa fa-wpexplorer" class="fa">
                                        &#xf2b9;
                                    </option>
                                    <option value="fa fa-angellist" class="fa">
                                        &#xf2de;
                                    </option>
                                    <option value="fa fa-area-chart" class="fa">
                                        &#xf1fe;
                                    </option>
                                    <option value="fa fa-at" class="fa">
                                        &#xf1fa;
                                    </option>
                                    <option value="fa fa-bell-slash" class="fa">
                                        &#xf1f6;
                                    </option>
                                    <option value="fa fa-bicycle" class="fa">
                                        &#xf206;
                                    </option>
                                    <option value="fa fa-binoculars" class="fa">
                                        &#xf1e5;
                                    </option>
                                    <option value="fa fa-birthday-cake" class="fa">
                                        &#xf1fd;
                                    </option>
                                    <option value="fa fa-bus" class="fa">
                                        &#xf207;
                                    </option>
                                    <option value="fa fa-calculador" class="fa">
                                        &#xf1ec;
                                    </option>
                                    <option value="fa fa-cc-mastercard" class="fa">
                                        &#xf1f1;
                                    </option>
                                    <option value="fa fa-cc-paypal" class="fa">
                                        &#xf1f4;
                                    </option>
                                    <option value="fa fa-cc-visa" class="fa">
                                        &#xf1f0;
                                    </option>
                                    <option value="fa fa-copyright" class="fa">
                                        &#xf1f9;
                                    </option>
                                    <option value="fa fa-futbol-o" class="fa">
                                        &#xf1e3;
                                    </option>
                                    <option value="fa fa-line-chart" class="fa">
                                        &#xf201;
                                    </option>
                                    <option value="fa fa-newspaper-o" class="fa">
                                        &#xf1ea;
                                    </option>
                                    <option value="fa fa-paint-brush" class="fa">
                                        &#xf1fc;
                                    </option>
                                    <option value="fa fa-pie-chart" class="fa">
                                        &#xf200;
                                    </option>
                                    <option value="fa fa-plug" class="fa">
                                        &#xf1e6;
                                    </option>
                                    <option value="fa fa-slideshare" class="fa">
                                        &#xf1e7;
                                    </option>
                                    <option value="fa fa-trash" class="fa">
                                        &#xf1f8;
                                    </option>
                                    <option value="fa fa-tty" class="fa">
                                        &#xf1e4;
                                    </option>
                                    <option value="fa fa-wifi" class="fa">
                                        &#xf1eb;
                                    </option>
                                    <option value="fa fa-yelp" class="fa">
                                        &#xf1e9;
                                    </option>
                                    <option value="fa fa-pagelines" class="fa">
                                        &#xf18c;
                                    </option>
                                    <option value="fa fa-stack-exchange" class="fa">
                                        &#xf18d;
                                    </option>
                                    <option value="fa fa-wheelchair" class="fa">
                                        &#xf193;
                                    </option>
                                    <option value="fa fa-vimeo-square" class="fa">
                                        &#xf194;
                                    </option>
                                    <option value="fa fa-plus-square-o" class="fa">
                                        &#xf0fe;
                                    </option>
                                    <option value="fa fa-automobile" class="fa">
                                        &#xf1b9;
                                    </option>
                                    <option value="fa fa-bank" class="fa">
                                        &#xf19c;
                                    </option>
                                    <option value="fa fa-behance-square" class="fa">
                                        &#xf1b5;
                                    </option>
                                    <option value="fa fa-bomb" class="fa">
                                        &#xf1e2;
                                    </option>
                                    <option value="fa fa-building" class="fa">
                                        &#xf1ad;
                                    </option>
                                    <option value="fa fa-child" class="fa">
                                        &#xf1ae;
                                    </option>
                                    <option value="fa fa-codepen" class="fa">
                                        &#xf1cb;
                                    </option>
                                    <option value="fa fa-cube" class="fa">
                                        &#xf1b2;
                                    </option>
                                    <option value="fa fa-cubes" class="fa">
                                        &#xf1b3;
                                    </option>
                                    <option value="fa fa-database" class="fa">
                                        &#xf1c0;
                                    </option>
                                    <option value="fa fa-delicious" class="fa">
                                        &#xf1a5;
                                    </option>
                                    <option value="fa fa-deviantart" class="fa">
                                        &#xf1bd;
                                    </option>
                                    <option value="fa fa-digg" class="fa">
                                        &#xf1a6;
                                    </option>
                                    <option value="fa fa-drupal" class="fa">
                                        &#xf1a9;
                                    </option>
                                    <option value="fa fa-empire" class="fa">
                                        &#xf1d1;
                                    </option>
                                    <option value="fa fa-fax" class="fa">
                                        &#xf1ac;
                                    </option>
                                    <option value="fa fa-file-archive-o" class="fa">
                                        &#xf1c6;
                                    </option>
                                    <option value="fa fa-file-audio-o" class="fa">
                                        &#xf1c7;
                                    </option>
                                    <option value="fa fa-file-code-o" class="fa">
                                        &#xf1c9;
                                    </option>
                                    <option value="fa fa-file-excel-o" class="fa">
                                        &#xf1c3;
                                    </option>
                                    <option value="fa fa-file-image-o" class="fa">
                                        &#xf1c5;
                                    </option>
                                    <option value="fa fa-file-movie-o" class="fa">
                                        &#xf1c8;
                                    </option>
                                    <option value="fa fa-file-pdf-o" class="fa">
                                        &#xf1c1;
                                    </option>
                                    <option value="fa fa-file-photo-o" class="fa">
                                        &#xf1c5;
                                    </option>
                                    <option value="fa fa-google" class="fa">
                                        &#xf1a0;
                                    </option>
                                    <option value="fa fa-graduation-cap" class="fa">
                                        &#xf19d;
                                    </option>
                                    <option value="fa fa-hacker-news" class="fa">
                                        &#xf1d4;
                                    </option>
                                    <option value="fa fa-header" class="fa">
                                        &#xf1dc;
                                    </option>
                                    <option value="fa fa-history" class="fa">
                                        &#xf1da;
                                    </option>
                                    <option value="fa fa-institution" class="fa">
                                        &#xf19c;
                                    </option>
                                    <option value="fa fa-joomla" class="fa">
                                        &#xf1aa;
                                    </option>
                                    <option value="fa fa-jsfiddle" class="fa">
                                        &#xf1cc;
                                    </option>
                                    <option value="fa fa-language" class="fa">
                                        &#xf1ab;
                                    </option>
                                    <option value="fa fa-life-ring" class="fa">
                                        &#xf1cd;
                                    </option>
                                    <option value="fa fa-openid" class="fa">
                                        &#xf19b;
                                    </option>
                                    <option value="fa fa-paper-plane" class="fa">
                                        &#xf1d8;
                                    </option>
                                    <option value="fa fa-paragraph" class="fa">
                                        &#xf1dd;
                                    </option>
                                    <option value="fa fa-paw" class="fa">
                                        &#xf1b0;
                                    </option>
                                    <option value="fa fa-pied-piper-alt" class="fa">
                                        &#xf1a8;
                                    </option>
                                    <option value="fa fa-qq" class="fa">
                                        &#xf1d6;
                                    </option>
                                    <option value="fa fa-rebel" class="fa">
                                        &#xf1d0;
                                    </option>
                                    <option value="fa fa-recycle" class="fa">
                                        &#xf1b8;
                                    </option>
                                    <option value="fa fa-reddit" class="fa">
                                        &#xf1a1;
                                    </option>
                                    <option value="fa fa-share-alt" class="fa">
                                        &#xf1e0;
                                    </option>
                                    <option value="fa fa-slack" class="fa">
                                        &#xf198;
                                    </option>
                                    <option value="fa fa-sliders" class="fa">
                                        &#xf1de;
                                    </option>
                                    <option value="fa fa-soundcloud" class="fa">
                                        &#xf1be;
                                    </option>
                                    <option value="fa fa-space-shuttle" class="fa">
                                        &#xf197;
                                    </option>
                                    <option value="fa fa-spotify" class="fa">
                                        &#xf1bc;
                                    </option>
                                    <option value="fa fa-steam" class="fa">
                                        &#xf1b6;
                                    </option>
                                    <option value="fa fa-stumbleupon" class="fa">
                                        &#xf1a4;
                                    </option>
                                    <option value="fa fa-taxi" class="fa">
                                        &#xf1ba;
                                    </option>
                                    <option value="fa fa-tencent-weibo" class="fa">
                                        &#xf1d5;
                                    </option>
                                    <option value="fa fa-tree" class="fa">
                                        &#xf1bb;
                                    </option>
                                    <option value="fa fa-weixin" class="fa">
                                        &#xf1d7;
                                    </option>
                                    <option value="fa fa-wordpress" class="fa">
                                        &#xf19a;
                                    </option>
                                    <option value="fa fa-yahoo" class="fa">
                                        &#xf19e;
                                    </option>
                                    <option value="fa fa-anchor" class="fa">
                                        &#xf13d;
                                    </option>
                                    <option value="fa fa-archive" class="fa">
                                        &#xf187;
                                    </option>
                                    <option value="fa fa-asterisk" class="fa">
                                        &#xf069;
                                    </option>
                                    <option value="fa fa-ban" class="fa">
                                        &#xf05e;
                                    </option>
                                    <option value="fa fa-bar-chart-o" class="fa">
                                        &#xf080;
                                    </option>
                                    <option value="fa fa-barcode" class="fa">
                                        &#xf02a;
                                    </option>
                                    <option value="fa fa-beer" class="fa">
                                        &#xf0fc;
                                    </option>
                                    <option value="fa fa-bell" class="fa">
                                        &#xf0f3;
                                    </option>
                                    <option value="fa fa-bolt" class="fa">
                                        &#xf0e7;
                                    </option>
                                    <option value="fa fa-book" class="fa">
                                        &#xf02d;
                                    </option>
                                    <option value="fa fa-bookmark" class="fa">
                                        &#xf02e;
                                    </option>
                                    <option value="fa fa-briefcase" class="fa">
                                        &#xf0b1;
                                    </option>
                                    <option value="fa fa-bug" class="fa">
                                        &#xf188;
                                    </option>
                                    <option value="fa fa-bullhorn" class="fa">
                                        &#xf0a1;
                                    </option>
                                    <option value="fa fa-calendar" class="fa">
                                        &#xf073;
                                    </option>
                                    <option value="fa fa-camera" class="fa">
                                        &#xf030;
                                    </option>
                                    <option value="fa fa-certificate" class="fa">
                                        &#xf0a3;
                                    </option>
                                    <option value="fa fa-check" class="fa">
                                        &#xf00c;
                                    </option>
                                    <option value="fa fa-clock-o" class="fa">
                                        &#xf017;
                                    </option>
                                    <option value="fa fa-cloud" class="fa">
                                        &#xf0c2;
                                    </option>
                                    <option value="fa fa-code" class="fa">
                                        &#xf121;
                                    </option>
                                    <option value="fa fa-code-fork" class="fa">
                                        &#xf126;
                                    </option>
                                    <option value="fa fa-coffee" class="fa">
                                        &#xf0f4;
                                    </option>
                                    <option value="fa fa-cog" class="fa">
                                        &#xf013;
                                    </option>
                                    <option value="fa fa-cogs" class="fa">
                                        &#xf085;
                                    </option>
                                    <option value="fa fa-comments" class="fa">
                                        &#xf086;
                                    </option>
                                    <option value="fa fa-compass" class="fa">
                                        &#xf14e;
                                    </option>
                                    <option value="fa fa-crosshairs" class="fa">
                                        &#xf05b;
                                    </option>
                                    <option value="fa fa-desktop" class="fa">
                                        &#xf108;
                                    </option>
                                    <option value="fa fa-download" class="fa">
                                        &#xf019;
                                    </option>
                                    <option value="fa fa-edit" class="fa">
                                        &#xf044;
                                    </option>
                                    <option value="fa fa-eraser" class="fa">
                                        &#xf12d;
                                    </option>
                                    <option value="fa fa-exclamation-triangle" class="fa">
                                        &#xf071;
                                    </option>
                                    <option value="fa fa-eye" class="fa">
                                        &#xf06e;
                                    </option>
                                    <option value="fa fa-female" class="fa">
                                        &#xf182;
                                    </option>
                                    <option value="fa fa-fire" class="fa">
                                        &#xf06d;
                                    </option>
                                    <option value="fa fa-fire-extinguisher" class="fa">
                                        &#xf134;
                                    </option>
                                    <option value="fa fa-flag" class="fa">
                                        &#xf024;
                                    </option>
                                    <option value="fa fa-flask" class="fa">
                                        &#xf0c3;
                                    </option>
                                    <option value="fa fa-folder" class="fa">
                                        &#xf07b;
                                    </option>
                                    <option value="fa fa-folder-open" class="fa">
                                        &#xf07c;
                                    </option>
                                    <option value="fa fa-frown-o" class="fa">
                                        &#xf119;
                                    </option>
                                    <option value="fa fa-gamepad" class="fa">
                                        &#xf11b;
                                    </option>
                                    <option value="fa fa-gavel" class="fa">
                                        &#xf0e3;
                                    </option>
                                    <option value="fa fa-gift" class="fa">
                                        &#xf06b;
                                    </option>
                                    <option value="fa fa-glass" class="fa">
                                        &#xf000;
                                    </option>
                                    <option value="fa fa-globe" class="fa">
                                        &#xf0ac;
                                    </option>
                                    <option value="fa fa-group" class="fa">
                                        &#xf0c0;
                                    </option>
                                    <option value="fa fa-hdd-o" class="fa">
                                        &#xf0a0;
                                    </option>
                                    <option value="fa fa-headphones" class="fa">
                                        &#xf025;
                                    </option>
                                    <option value="fa fa-heart" class="fa">
                                        &#xf21e;
                                    </option>
                                    <option value="fa fa-home" class="fa">
                                        &#xf015;
                                    </option>
                                    <option value="fa fa-inbox" class="fa">
                                        &#xf01c;
                                    </option>
                                    <option value="fa fa-info" class="fa">
                                        &#xf129;
                                    </option>
                                    <option value="fa fa-key" class="fa">
                                        &#xf084;
                                    </option>
                                    <option value="fa fa-keyboard-o" class="fa">
                                        &#xf11c;
                                    </option>
                                    <option value="fa fa-laptop" class="fa">
                                        &#xf109;
                                    </option>
                                    <option value="fa fa-leaf" class="fa">
                                        &#xf06c;
                                    </option>
                                    <option value="fa fa-lemon-o" class="fa">
                                        &#xf094;
                                    </option>
                                    <option value="fa fa-lightbulb-o" class="fa">
                                        &#xf0eb;
                                    </option>
                                    <option value="fa fa-lock" class="fa">
                                        &#xf023;
                                    </option>
                                    <option value="fa fa-magic" class="fa">
                                        &#xf0d0;
                                    </option>
                                    <option value="fa fa-magnet" class="fa">
                                        &#xf076;
                                    </option>
                                    <option value="fa fa-map-marker" class="fa">
                                        &#xf041;
                                    </option>
                                    <option value="fa fa-meh-o" class="fa">
                                        &#xf11a;
                                    </option>
                                    <option value="fa fa-microphone" class="fa">
                                        &#xf130;
                                    </option>
                                    <option value="fa fa-minus" class="fa">
                                        &#xf068;
                                    </option>
                                    <option value="fa fa-money" class="fa">
                                        &#xf0d6;
                                    </option>
                                    <option value="fa fa-moon-o" class="fa">
                                        &#xf186;
                                    </option>
                                    <option value="fa fa-music" class="fa">
                                        &#xf001;
                                    </option>
                                    <option value="fa fa-pencil" class="fa">
                                        &#xf040;
                                    </option>
                                    <option value="fa fa-phone" class="fa">
                                        &#xf095;
                                    </option>
                                    <option value="fa fa-picture-o" class="fa">
                                        &#xf03e;
                                    </option>
                                    <option value="fa fa-plus" class="fa">
                                        &#xf067;
                                    </option>
                                    <option value="fa fa-power-off" class="fa">
                                        &#xf011;
                                    </option>
                                    <option value="fa fa-print" class="fa">
                                        &#xf02f;
                                    </option>
                                    <option value="fa fa-puzzle-piece" class="fa">
                                        &#xf12e;
                                    </option>
                                    <option value="fa fa-qrcode" class="fa">
                                        &#xf029;
                                    </option>
                                    <option value="fa fa-question" class="fa">
                                        &#xf128;
                                    </option>
                                    <option value="fa fa-road" class="fa">
                                        &#xf018;
                                    </option>
                                    <option value="fa fa-rocket" class="fa">
                                        &#xf135;
                                    </option>
                                    <option value="fa fa-rss" class="fa">
                                        &#xf09e;
                                    </option>
                                    <option value="fa fa-search" class="fa">
                                        &#xf00e;
                                    </option>
                                    <option value="fa fa-shield" class="fa">
                                        &#xf132;
                                    </option>

                                    <option value="fa fa-shopping-cart" class="fa">
                                        &#xf07a;
                                    </option>
                                    <option value="fa fa-signal" class="fa">
                                        &#xf012;
                                    </option>
                                    <option value="fa fa-sitemap" class="fa">
                                        &#xf0e8;
                                    </option>
                                    <option value="fa fa-smile-o" class="fa">
                                        &#xf118;
                                    </option>
                                    <option value="fa fa-spinner" class="fa">
                                        &#xf110;
                                    </option>
                                    <option value="fa fa-star" class="fa">
                                        &#xf005;
                                    </option>
                                    <option value="fa fa-suitcase" class="fa">
                                        &#xf0f2;
                                    </option>
                                    <option value="fa fa-sun-o" class="fa">
                                        &#xf185;
                                    </option>
                                    <option value="fa fa-tag" class="fa">
                                        &#xf02b;
                                    </option>
                                    <option value="fa fa-terminal" class="fa">
                                        &#xf120;
                                    </option>
                                    <option value="fa fa-thumb-tack" class="fa">
                                        &#xf08d;
                                    </option>
                                    <option value="fa fa-thumbs-o-down" class="fa">
                                        &#xf165;
                                    </option>
                                    <option value="fa fa-thumbs-o-up" class="fa">
                                        &#xf164;
                                    </option>
                                    <option value="fa fa-ticket" class="fa">
                                        &#xf145;
                                    </option>
                                    <option value="fa fa-tint" class="fa">
                                        &#xf043;
                                    </option>
                                    <option value="fa fa-trophy" class="fa">
                                        &#xf091;
                                    </option>
                                    <option value="fa fa-truck" class="fa">
                                        &#xf0d1;
                                    </option>
                                    <option value="fa fa-umbrella" class="fa">
                                        &#xf0e9;
                                    </option>
                                    <option value="fa fa-unlock" class="fa">
                                        &#xf09c;
                                    </option>
                                    <option value="fa fa-video-camera" class="fa">
                                        &#xf03d;
                                    </option>
                                    <option value="fa fa-volume-up" class="fa">
                                        &#xf028;
                                    </option>
                                    <option value="fa fa-wrench" class="fa">
                                        &#xf0ad;
                                    </option>
                                    <option value="fa fa-usd" class="fa">
                                        &#xf155;
                                    </option>
                                    <option value="fa fa-adn" class="fa">
                                        &#xf170;
                                    </option>
                                    <option value="fa fa-android" class="fa">
                                        &#xf17b;
                                    </option>
                                    <option value="fa fa-apple" class="fa">
                                        &#xf179;
                                    </option>
                                    <option value="fa fa-bitbucket" class="fa">
                                        &#xf171;
                                    </option>
                                    <option value="fa fa-css3" class="fa">
                                        &#xf13c;
                                    </option>
                                    <option value="fa fa-dribbble" class="fa">
                                        &#xf17d;
                                    </option>
                                    <option value="fa fa-dropbox" class="fa">
                                        &#xf16b;
                                    </option>
                                    <option value="fa fa-facebook" class="fa">
                                        &#xf09a;
                                    </option>
                                    <option value="fa fa-flickr" class="fa">
                                        &#xf16e;
                                    </option>
                                    <option value="fa fa-foursquare" class="fa">
                                        &#xf180;
                                    </option>
                                    <option value="fa fa-github-alt" class="fa">
                                        &#xf113;
                                    </option>
                                    <option value="fa fa-google-plus" class="fa">
                                        &#xf0d5;
                                    </option>
                                    <option value="fa fa-html5" class="fa">
                                        &#xf13b;
                                    </option>
                                    <option value="fa fa-instagram" class="fa">
                                        &#xf16d;
                                    </option>
                                    <option value="fa fa-linkedin" class="fa">
                                        &#xf0e1;
                                    </option>
                                    <option value="fa fa-linux" class="fa">
                                        &#xf17c;
                                    </option>
                                    <option value="fa fa-maxcdn" class="fa">
                                        &#xf136;
                                    </option>
                                    <option value="fa fa-pinterest" class="fa">
                                        &#xf231;
                                    </option>
                                    <option value="fa fa-renren" class="fa">
                                        &#xf18b;
                                    </option>
                                    <option value="fa fa-skype" class="fa">
                                        &#xf17e;
                                    </option>
                                    <option value="fa fa-stack-overflow" class="fa">
                                        &#xf16c;
                                    </option>
                                    <option value="fa fa-tumblr" class="fa">
                                        &#xf173;
                                    </option>
                                    <option value="fa fa-twitter" class="fa">
                                        &#xf099;
                                    </option>
                                    <option value="fa fa-vk" class="fa">
                                        &#xf189;
                                    </option>
                                    <option value="fa fa-weibo" class="fa">
                                        &#xf18a;
                                    </option>
                                    <option value="fa fa-windows" class="fa">
                                        &#xf17a;
                                    </option>
                                    <option value="fa fa-xing" class="fa">
                                        &#xf168;
                                    </option>
                                    <option value="fa fa-youtube-play" class="fa">
                                        &#xf167;
                                    </option>
                                    <option value="fa fa-ambulance" class="fa">
                                        &#xf0f9;
                                    </option>
                                    <option value="fa fa-hospital-o" class="fa">
                                        &#xf0f8;
                                    </option>
                                    <option value="fa fa-user-md" class="fa">
                                        &#xf0f0;
                                    </option>
                                </select>
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

<!-- Caracteristicas -->
<!-- Crear -->
<div class="modal inmodal fade" id="caracteristicas" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Subir Caracterisitcas</h4>
            </div>
            <form id="fcaracteristica" name="fcaracteristica" method="post" action="guardarCaracteristica" class="formCaracteristica" enctype="multipart/form-data">
            <div class="modal-body">
                
                    <div class="form-group row">
                        <input type="text" name="_token" id="_token" hidden value="{{ csrf_token() }}">
                        <div class="col-md-12 row">
                            <label class="col-sm-4 col-form-label">Titulo</label>
                            <div class="col-sm-12">
                                <input type="text" placeholder="Asignar un titulo de caracteristicas" class="form-control" id="tituloCaracteristica" name="tituloCaracteristica" required>
                            </div>
                        </div>

                        <div class="col-md-12 row">
                            <label class="col-sm-4 col-form-label">Descripción</label>
                            <div class="col-sm-12">
                                <input type="text" placeholder="Ingrese una descripción" class="form-control" id="descripcionCaracteristica" name="descripcionCaracteristica" required>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label class="col-sm-2 col-form-label">Icono</label>
                            <div class="col-sm-12">
                                <select class="form-control m-b fa" id="iconoCaracteristica" name="iconoCaracteristica">
                                    <option>Seleccione un icono...</option>
                                    <option value="fa fa-address-book" class="fa">
                                        &#xf2b9;
                                    </option>
                                    <option value="fa fa-address-card" class="fa">
                                        &#xf2bb;
                                    </option>
                                    <option value="fa fa-envelope-open" class="fa">
                                        &#xf2b6;
                                    </option>
                                    <option value="fa fa-etsy" class="fa">
                                        &#xf2d7;  
                                    </option>
                                    <option value="fa fa-grav" class="fa">
                                        &#xf2d6;
                                    </option>
                                    <option value="fa fa-handshake-o" class="fa">
                                        &#xf2b5;
                                    </option>
                                    <option value="fa fa-id-badge" class="fa">
                                        &#xf2c1;
                                    </option>
                                    <option value="fa fa-linode" class="fa">
                                        &#xf2b8;
                                    </option>
                                    <option value="fa fa-meetup" class="fa">
                                        &#xf2e0;
                                    </option>
                                    <option value="fa fa-microchip" class="fa">
                                        &#xf2db;
                                    </option>
                                    <option value="fa fa-podcast" class="fa">
                                        &#xf2ce;
                                    </option>
                                    <option value="fa fa-quora" class="fa">
                                        &#xf2c4;
                                    </option>
                                    <option value="fa fa-ravelry" class="fa">
                                        &#xf2d9;
                                    </option>
                                    <option value="fa fa-snowflake-o" class="fa">
                                        &#xf2dc;
                                    </option>
                                    <option value="fa fa-telegram" class="fa">
                                        &#xf2c6;
                                    </option>
                                    <option value="fa fa-times-rectangle" class="fa">
                                        &#xf2d3;
                                    </option>
                                    <option value="fa fa-user-circle" class="fa">
                                        &#xf2bd;
                                    </option>
                                    <option value="fa fa-user-o" class="fa">
                                        &#xf007;
                                    </option>
                                    <option value="fa fa-window-maximize" class="fa">
                                        &#xf2d0;
                                    </option>
                                    <option value="fa fa-window-minimize" class="fa">
                                        &#xf2d1;
                                    </option>
                                    <option value="fa fa-window-restore" class="fa">
                                        &#xf2d2;
                                    </option>
                                    <option value="fa fa-wpexplorer" class="fa">
                                        &#xf2b9;
                                    </option>
                                    <option value="fa fa-angellist" class="fa">
                                        &#xf2de;
                                    </option>
                                    <option value="fa fa-area-chart" class="fa">
                                        &#xf1fe;
                                    </option>
                                    <option value="fa fa-at" class="fa">
                                        &#xf1fa;
                                    </option>
                                    <option value="fa fa-bell-slash" class="fa">
                                        &#xf1f6;
                                    </option>
                                    <option value="fa fa-bicycle" class="fa">
                                        &#xf206;
                                    </option>
                                    <option value="fa fa-binoculars" class="fa">
                                        &#xf1e5;
                                    </option>
                                    <option value="fa fa-birthday-cake" class="fa">
                                        &#xf1fd;
                                    </option>
                                    <option value="fa fa-bus" class="fa">
                                        &#xf207;
                                    </option>
                                    <option value="fa fa-calculador" class="fa">
                                        &#xf1ec;
                                    </option>
                                    <option value="fa fa-cc-mastercard" class="fa">
                                        &#xf1f1;
                                    </option>
                                    <option value="fa fa-cc-paypal" class="fa">
                                        &#xf1f4;
                                    </option>
                                    <option value="fa fa-cc-visa" class="fa">
                                        &#xf1f0;
                                    </option>
                                    <option value="fa fa-copyright" class="fa">
                                        &#xf1f9;
                                    </option>
                                    <option value="fa fa-futbol-o" class="fa">
                                        &#xf1e3;
                                    </option>
                                    <option value="fa fa-line-chart" class="fa">
                                        &#xf201;
                                    </option>
                                    <option value="fa fa-newspaper-o" class="fa">
                                        &#xf1ea;
                                    </option>
                                    <option value="fa fa-paint-brush" class="fa">
                                        &#xf1fc;
                                    </option>
                                    <option value="fa fa-pie-chart" class="fa">
                                        &#xf200;
                                    </option>
                                    <option value="fa fa-plug" class="fa">
                                        &#xf1e6;
                                    </option>
                                    <option value="fa fa-slideshare" class="fa">
                                        &#xf1e7;
                                    </option>
                                    <option value="fa fa-trash" class="fa">
                                        &#xf1f8;
                                    </option>
                                    <option value="fa fa-tty" class="fa">
                                        &#xf1e4;
                                    </option>
                                    <option value="fa fa-wifi" class="fa">
                                        &#xf1eb;
                                    </option>
                                    <option value="fa fa-yelp" class="fa">
                                        &#xf1e9;
                                    </option>
                                    <option value="fa fa-pagelines" class="fa">
                                        &#xf18c;
                                    </option>
                                    <option value="fa fa-stack-exchange" class="fa">
                                        &#xf18d;
                                    </option>
                                    <option value="fa fa-wheelchair" class="fa">
                                        &#xf193;
                                    </option>
                                    <option value="fa fa-vimeo-square" class="fa">
                                        &#xf194;
                                    </option>
                                    <option value="fa fa-plus-square-o" class="fa">
                                        &#xf0fe;
                                    </option>
                                    <option value="fa fa-automobile" class="fa">
                                        &#xf1b9;
                                    </option>
                                    <option value="fa fa-bank" class="fa">
                                        &#xf19c;
                                    </option>
                                    <option value="fa fa-behance-square" class="fa">
                                        &#xf1b5;
                                    </option>
                                    <option value="fa fa-bomb" class="fa">
                                        &#xf1e2;
                                    </option>
                                    <option value="fa fa-building" class="fa">
                                        &#xf1ad;
                                    </option>
                                    <option value="fa fa-child" class="fa">
                                        &#xf1ae;
                                    </option>
                                    <option value="fa fa-codepen" class="fa">
                                        &#xf1cb;
                                    </option>
                                    <option value="fa fa-cube" class="fa">
                                        &#xf1b2;
                                    </option>
                                    <option value="fa fa-cubes" class="fa">
                                        &#xf1b3;
                                    </option>
                                    <option value="fa fa-database" class="fa">
                                        &#xf1c0;
                                    </option>
                                    <option value="fa fa-delicious" class="fa">
                                        &#xf1a5;
                                    </option>
                                    <option value="fa fa-deviantart" class="fa">
                                        &#xf1bd;
                                    </option>
                                    <option value="fa fa-digg" class="fa">
                                        &#xf1a6;
                                    </option>
                                    <option value="fa fa-drupal" class="fa">
                                        &#xf1a9;
                                    </option>
                                    <option value="fa fa-empire" class="fa">
                                        &#xf1d1;
                                    </option>
                                    <option value="fa fa-fax" class="fa">
                                        &#xf1ac;
                                    </option>
                                    <option value="fa fa-file-archive-o" class="fa">
                                        &#xf1c6;
                                    </option>
                                    <option value="fa fa-file-audio-o" class="fa">
                                        &#xf1c7;
                                    </option>
                                    <option value="fa fa-file-code-o" class="fa">
                                        &#xf1c9;
                                    </option>
                                    <option value="fa fa-file-excel-o" class="fa">
                                        &#xf1c3;
                                    </option>
                                    <option value="fa fa-file-image-o" class="fa">
                                        &#xf1c5;
                                    </option>
                                    <option value="fa fa-file-movie-o" class="fa">
                                        &#xf1c8;
                                    </option>
                                    <option value="fa fa-file-pdf-o" class="fa">
                                        &#xf1c1;
                                    </option>
                                    <option value="fa fa-file-photo-o" class="fa">
                                        &#xf1c5;
                                    </option>
                                    <option value="fa fa-google" class="fa">
                                        &#xf1a0;
                                    </option>
                                    <option value="fa fa-graduation-cap" class="fa">
                                        &#xf19d;
                                    </option>
                                    <option value="fa fa-hacker-news" class="fa">
                                        &#xf1d4;
                                    </option>
                                    <option value="fa fa-header" class="fa">
                                        &#xf1dc;
                                    </option>
                                    <option value="fa fa-history" class="fa">
                                        &#xf1da;
                                    </option>
                                    <option value="fa fa-institution" class="fa">
                                        &#xf19c;
                                    </option>
                                    <option value="fa fa-joomla" class="fa">
                                        &#xf1aa;
                                    </option>
                                    <option value="fa fa-jsfiddle" class="fa">
                                        &#xf1cc;
                                    </option>
                                    <option value="fa fa-language" class="fa">
                                        &#xf1ab;
                                    </option>
                                    <option value="fa fa-life-ring" class="fa">
                                        &#xf1cd;
                                    </option>
                                    <option value="fa fa-openid" class="fa">
                                        &#xf19b;
                                    </option>
                                    <option value="fa fa-paper-plane" class="fa">
                                        &#xf1d8;
                                    </option>
                                    <option value="fa fa-paragraph" class="fa">
                                        &#xf1dd;
                                    </option>
                                    <option value="fa fa-paw" class="fa">
                                        &#xf1b0;
                                    </option>
                                    <option value="fa fa-pied-piper-alt" class="fa">
                                        &#xf1a8;
                                    </option>
                                    <option value="fa fa-qq" class="fa">
                                        &#xf1d6;
                                    </option>
                                    <option value="fa fa-rebel" class="fa">
                                        &#xf1d0;
                                    </option>
                                    <option value="fa fa-recycle" class="fa">
                                        &#xf1b8;
                                    </option>
                                    <option value="fa fa-reddit" class="fa">
                                        &#xf1a1;
                                    </option>
                                    <option value="fa fa-share-alt" class="fa">
                                        &#xf1e0;
                                    </option>
                                    <option value="fa fa-slack" class="fa">
                                        &#xf198;
                                    </option>
                                    <option value="fa fa-sliders" class="fa">
                                        &#xf1de;
                                    </option>
                                    <option value="fa fa-soundcloud" class="fa">
                                        &#xf1be;
                                    </option>
                                    <option value="fa fa-space-shuttle" class="fa">
                                        &#xf197;
                                    </option>
                                    <option value="fa fa-spotify" class="fa">
                                        &#xf1bc;
                                    </option>
                                    <option value="fa fa-steam" class="fa">
                                        &#xf1b6;
                                    </option>
                                    <option value="fa fa-stumbleupon" class="fa">
                                        &#xf1a4;
                                    </option>
                                    <option value="fa fa-taxi" class="fa">
                                        &#xf1ba;
                                    </option>
                                    <option value="fa fa-tencent-weibo" class="fa">
                                        &#xf1d5;
                                    </option>
                                    <option value="fa fa-tree" class="fa">
                                        &#xf1bb;
                                    </option>
                                    <option value="fa fa-weixin" class="fa">
                                        &#xf1d7;
                                    </option>
                                    <option value="fa fa-wordpress" class="fa">
                                        &#xf19a;
                                    </option>
                                    <option value="fa fa-yahoo" class="fa">
                                        &#xf19e;
                                    </option>
                                    <option value="fa fa-anchor" class="fa">
                                        &#xf13d;
                                    </option>
                                    <option value="fa fa-archive" class="fa">
                                        &#xf187;
                                    </option>
                                    <option value="fa fa-asterisk" class="fa">
                                        &#xf069;
                                    </option>
                                    <option value="fa fa-ban" class="fa">
                                        &#xf05e;
                                    </option>
                                    <option value="fa fa-bar-chart-o" class="fa">
                                        &#xf080;
                                    </option>
                                    <option value="fa fa-barcode" class="fa">
                                        &#xf02a;
                                    </option>
                                    <option value="fa fa-beer" class="fa">
                                        &#xf0fc;
                                    </option>
                                    <option value="fa fa-bell" class="fa">
                                        &#xf0f3;
                                    </option>
                                    <option value="fa fa-bolt" class="fa">
                                        &#xf0e7;
                                    </option>
                                    <option value="fa fa-book" class="fa">
                                        &#xf02d;
                                    </option>
                                    <option value="fa fa-bookmark" class="fa">
                                        &#xf02e;
                                    </option>
                                    <option value="fa fa-briefcase" class="fa">
                                        &#xf0b1;
                                    </option>
                                    <option value="fa fa-bug" class="fa">
                                        &#xf188;
                                    </option>
                                    <option value="fa fa-bullhorn" class="fa">
                                        &#xf0a1;
                                    </option>
                                    <option value="fa fa-calendar" class="fa">
                                        &#xf073;
                                    </option>
                                    <option value="fa fa-camera" class="fa">
                                        &#xf030;
                                    </option>
                                    <option value="fa fa-certificate" class="fa">
                                        &#xf0a3;
                                    </option>
                                    <option value="fa fa-check" class="fa">
                                        &#xf00c;
                                    </option>
                                    <option value="fa fa-clock-o" class="fa">
                                        &#xf017;
                                    </option>
                                    <option value="fa fa-cloud" class="fa">
                                        &#xf0c2;
                                    </option>
                                    <option value="fa fa-code" class="fa">
                                        &#xf121;
                                    </option>
                                    <option value="fa fa-code-fork" class="fa">
                                        &#xf126;
                                    </option>
                                    <option value="fa fa-coffee" class="fa">
                                        &#xf0f4;
                                    </option>
                                    <option value="fa fa-cog" class="fa">
                                        &#xf013;
                                    </option>
                                    <option value="fa fa-cogs" class="fa">
                                        &#xf085;
                                    </option>
                                    <option value="fa fa-comments" class="fa">
                                        &#xf086;
                                    </option>
                                    <option value="fa fa-compass" class="fa">
                                        &#xf14e;
                                    </option>
                                    <option value="fa fa-crosshairs" class="fa">
                                        &#xf05b;
                                    </option>
                                    <option value="fa fa-desktop" class="fa">
                                        &#xf108;
                                    </option>
                                    <option value="fa fa-download" class="fa">
                                        &#xf019;
                                    </option>
                                    <option value="fa fa-edit" class="fa">
                                        &#xf044;
                                    </option>
                                    <option value="fa fa-eraser" class="fa">
                                        &#xf12d;
                                    </option>
                                    <option value="fa fa-exclamation-triangle" class="fa">
                                        &#xf071;
                                    </option>
                                    <option value="fa fa-eye" class="fa">
                                        &#xf06e;
                                    </option>
                                    <option value="fa fa-female" class="fa">
                                        &#xf182;
                                    </option>
                                    <option value="fa fa-fire" class="fa">
                                        &#xf06d;
                                    </option>
                                    <option value="fa fa-fire-extinguisher" class="fa">
                                        &#xf134;
                                    </option>
                                    <option value="fa fa-flag" class="fa">
                                        &#xf024;
                                    </option>
                                    <option value="fa fa-flask" class="fa">
                                        &#xf0c3;
                                    </option>
                                    <option value="fa fa-folder" class="fa">
                                        &#xf07b;
                                    </option>
                                    <option value="fa fa-folder-open" class="fa">
                                        &#xf07c;
                                    </option>
                                    <option value="fa fa-frown-o" class="fa">
                                        &#xf119;
                                    </option>
                                    <option value="fa fa-gamepad" class="fa">
                                        &#xf11b;
                                    </option>
                                    <option value="fa fa-gavel" class="fa">
                                        &#xf0e3;
                                    </option>
                                    <option value="fa fa-gift" class="fa">
                                        &#xf06b;
                                    </option>
                                    <option value="fa fa-glass" class="fa">
                                        &#xf000;
                                    </option>
                                    <option value="fa fa-globe" class="fa">
                                        &#xf0ac;
                                    </option>
                                    <option value="fa fa-group" class="fa">
                                        &#xf0c0;
                                    </option>
                                    <option value="fa fa-hdd-o" class="fa">
                                        &#xf0a0;
                                    </option>
                                    <option value="fa fa-headphones" class="fa">
                                        &#xf025;
                                    </option>
                                    <option value="fa fa-heart" class="fa">
                                        &#xf21e;
                                    </option>
                                    <option value="fa fa-home" class="fa">
                                        &#xf015;
                                    </option>
                                    <option value="fa fa-inbox" class="fa">
                                        &#xf01c;
                                    </option>
                                    <option value="fa fa-info" class="fa">
                                        &#xf129;
                                    </option>
                                    <option value="fa fa-key" class="fa">
                                        &#xf084;
                                    </option>
                                    <option value="fa fa-keyboard-o" class="fa">
                                        &#xf11c;
                                    </option>
                                    <option value="fa fa-laptop" class="fa">
                                        &#xf109;
                                    </option>
                                    <option value="fa fa-leaf" class="fa">
                                        &#xf06c;
                                    </option>
                                    <option value="fa fa-lemon-o" class="fa">
                                        &#xf094;
                                    </option>
                                    <option value="fa fa-lightbulb-o" class="fa">
                                        &#xf0eb;
                                    </option>
                                    <option value="fa fa-lock" class="fa">
                                        &#xf023;
                                    </option>
                                    <option value="fa fa-magic" class="fa">
                                        &#xf0d0;
                                    </option>
                                    <option value="fa fa-magnet" class="fa">
                                        &#xf076;
                                    </option>
                                    <option value="fa fa-map-marker" class="fa">
                                        &#xf041;
                                    </option>
                                    <option value="fa fa-meh-o" class="fa">
                                        &#xf11a;
                                    </option>
                                    <option value="fa fa-microphone" class="fa">
                                        &#xf130;
                                    </option>
                                    <option value="fa fa-minus" class="fa">
                                        &#xf068;
                                    </option>
                                    <option value="fa fa-money" class="fa">
                                        &#xf0d6;
                                    </option>
                                    <option value="fa fa-moon-o" class="fa">
                                        &#xf186;
                                    </option>
                                    <option value="fa fa-music" class="fa">
                                        &#xf001;
                                    </option>
                                    <option value="fa fa-pencil" class="fa">
                                        &#xf040;
                                    </option>
                                    <option value="fa fa-phone" class="fa">
                                        &#xf095;
                                    </option>
                                    <option value="fa fa-picture-o" class="fa">
                                        &#xf03e;
                                    </option>
                                    <option value="fa fa-plus" class="fa">
                                        &#xf067;
                                    </option>
                                    <option value="fa fa-power-off" class="fa">
                                        &#xf011;
                                    </option>
                                    <option value="fa fa-print" class="fa">
                                        &#xf02f;
                                    </option>
                                    <option value="fa fa-puzzle-piece" class="fa">
                                        &#xf12e;
                                    </option>
                                    <option value="fa fa-qrcode" class="fa">
                                        &#xf029;
                                    </option>
                                    <option value="fa fa-question" class="fa">
                                        &#xf128;
                                    </option>
                                    <option value="fa fa-road" class="fa">
                                        &#xf018;
                                    </option>
                                    <option value="fa fa-rocket" class="fa">
                                        &#xf135;
                                    </option>
                                    <option value="fa fa-rss" class="fa">
                                        &#xf09e;
                                    </option>
                                    <option value="fa fa-search" class="fa">
                                        &#xf00e;
                                    </option>
                                    <option value="fa fa-shield" class="fa">
                                        &#xf132;
                                    </option>

                                    <option value="fa fa-shopping-cart" class="fa">
                                        &#xf07a;
                                    </option>
                                    <option value="fa fa-signal" class="fa">
                                        &#xf012;
                                    </option>
                                    <option value="fa fa-sitemap" class="fa">
                                        &#xf0e8;
                                    </option>
                                    <option value="fa fa-smile-o" class="fa">
                                        &#xf118;
                                    </option>
                                    <option value="fa fa-spinner" class="fa">
                                        &#xf110;
                                    </option>
                                    <option value="fa fa-star" class="fa">
                                        &#xf005;
                                    </option>
                                    <option value="fa fa-suitcase" class="fa">
                                        &#xf0f2;
                                    </option>
                                    <option value="fa fa-sun-o" class="fa">
                                        &#xf185;
                                    </option>
                                    <option value="fa fa-tag" class="fa">
                                        &#xf02b;
                                    </option>
                                    <option value="fa fa-terminal" class="fa">
                                        &#xf120;
                                    </option>
                                    <option value="fa fa-thumb-tack" class="fa">
                                        &#xf08d;
                                    </option>
                                    <option value="fa fa-thumbs-o-down" class="fa">
                                        &#xf165;
                                    </option>
                                    <option value="fa fa-thumbs-o-up" class="fa">
                                        &#xf164;
                                    </option>
                                    <option value="fa fa-ticket" class="fa">
                                        &#xf145;
                                    </option>
                                    <option value="fa fa-tint" class="fa">
                                        &#xf043;
                                    </option>
                                    <option value="fa fa-trophy" class="fa">
                                        &#xf091;
                                    </option>
                                    <option value="fa fa-truck" class="fa">
                                        &#xf0d1;
                                    </option>
                                    <option value="fa fa-umbrella" class="fa">
                                        &#xf0e9;
                                    </option>
                                    <option value="fa fa-unlock" class="fa">
                                        &#xf09c;
                                    </option>
                                    <option value="fa fa-video-camera" class="fa">
                                        &#xf03d;
                                    </option>
                                    <option value="fa fa-volume-up" class="fa">
                                        &#xf028;
                                    </option>
                                    <option value="fa fa-wrench" class="fa">
                                        &#xf0ad;
                                    </option>
                                    <option value="fa fa-usd" class="fa">
                                        &#xf155;
                                    </option>
                                    <option value="fa fa-adn" class="fa">
                                        &#xf170;
                                    </option>
                                    <option value="fa fa-android" class="fa">
                                        &#xf17b;
                                    </option>
                                    <option value="fa fa-apple" class="fa">
                                        &#xf179;
                                    </option>
                                    <option value="fa fa-bitbucket" class="fa">
                                        &#xf171;
                                    </option>
                                    <option value="fa fa-css3" class="fa">
                                        &#xf13c;
                                    </option>
                                    <option value="fa fa-dribbble" class="fa">
                                        &#xf17d;
                                    </option>
                                    <option value="fa fa-dropbox" class="fa">
                                        &#xf16b;
                                    </option>
                                    <option value="fa fa-facebook" class="fa">
                                        &#xf09a;
                                    </option>
                                    <option value="fa fa-flickr" class="fa">
                                        &#xf16e;
                                    </option>
                                    <option value="fa fa-foursquare" class="fa">
                                        &#xf180;
                                    </option>
                                    <option value="fa fa-github-alt" class="fa">
                                        &#xf113;
                                    </option>
                                    <option value="fa fa-google-plus" class="fa">
                                        &#xf0d5;
                                    </option>
                                    <option value="fa fa-html5" class="fa">
                                        &#xf13b;
                                    </option>
                                    <option value="fa fa-instagram" class="fa">
                                        &#xf16d;
                                    </option>
                                    <option value="fa fa-linkedin" class="fa">
                                        &#xf0e1;
                                    </option>
                                    <option value="fa fa-linux" class="fa">
                                        &#xf17c;
                                    </option>
                                    <option value="fa fa-maxcdn" class="fa">
                                        &#xf136;
                                    </option>
                                    <option value="fa fa-pinterest" class="fa">
                                        &#xf231;
                                    </option>
                                    <option value="fa fa-renren" class="fa">
                                        &#xf18b;
                                    </option>
                                    <option value="fa fa-skype" class="fa">
                                        &#xf17e;
                                    </option>
                                    <option value="fa fa-stack-overflow" class="fa">
                                        &#xf16c;
                                    </option>
                                    <option value="fa fa-tumblr" class="fa">
                                        &#xf173;
                                    </option>
                                    <option value="fa fa-twitter" class="fa">
                                        &#xf099;
                                    </option>
                                    <option value="fa fa-vk" class="fa">
                                        &#xf189;
                                    </option>
                                    <option value="fa fa-weibo" class="fa">
                                        &#xf18a;
                                    </option>
                                    <option value="fa fa-windows" class="fa">
                                        &#xf17a;
                                    </option>
                                    <option value="fa fa-xing" class="fa">
                                        &#xf168;
                                    </option>
                                    <option value="fa fa-youtube-play" class="fa">
                                        &#xf167;
                                    </option>
                                    <option value="fa fa-ambulance" class="fa">
                                        &#xf0f9;
                                    </option>
                                    <option value="fa fa-hospital-o" class="fa">
                                        &#xf0f8;
                                    </option>
                                    <option value="fa fa-user-md" class="fa">
                                        &#xf0f0;
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label class="col-sm-2 col-form-label">Estado</label>
                            <div class="col-sm-12">
                                <select class="form-control m-b" id="estadoCaracteristica" name="estadoCaracteristica">
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

<div class="modal inmodal fade" id="caracteristicasEc" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Editar Caracterisitcas</h4>
            </div>
            <form id="fcaracteristicaEc" name="fcaracteristicaEc" method="post" action="editarCaracteristica" class="formCaracteristicaEc" enctype="multipart/form-data">
            <div class="modal-body">
                
                    <div class="form-group row">
                        <input type="text" name="_token" id="_token" hidden value="{{ csrf_token() }}">
                        <input type="text" name="idEc" id="idEc" hidden>
                        <div class="col-md-12 row">
                            <label class="col-sm-4 col-form-label">Titulo</label>
                            <div class="col-sm-12">
                                <input type="text" placeholder="Asignar un titulo de caracteristicas" class="form-control" id="tituloEc" name="tituloEc" required>
                            </div>
                        </div>

                        <div class="col-md-12 row">
                            <label class="col-sm-4 col-form-label">Descripción</label>
                            <div class="col-sm-12">
                                <input type="text" placeholder="Ingrese una descripción" class="form-control" id="descripcionEc" name="descripcionEc" required>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label class="col-sm-2 col-form-label">Icono</label>
                            <div class="col-sm-12">
                                <select class="form-control m-b fa" id="iconoEc" name="iconoEc">
                                    <option>Seleccione un icono...</option>
                                    <option value="fa fa-address-book" class="fa">
                                        &#xf2b9;
                                    </option>
                                    <option value="fa fa-address-card" class="fa">
                                        &#xf2bb;
                                    </option>
                                    <option value="fa fa-envelope-open" class="fa">
                                        &#xf2b6;
                                    </option>
                                    <option value="fa fa-etsy" class="fa">
                                        &#xf2d7;  
                                    </option>
                                    <option value="fa fa-grav" class="fa">
                                        &#xf2d6;
                                    </option>
                                    <option value="fa fa-handshake-o" class="fa">
                                        &#xf2b5;
                                    </option>
                                    <option value="fa fa-id-badge" class="fa">
                                        &#xf2c1;
                                    </option>
                                    <option value="fa fa-linode" class="fa">
                                        &#xf2b8;
                                    </option>
                                    <option value="fa fa-meetup" class="fa">
                                        &#xf2e0;
                                    </option>
                                    <option value="fa fa-microchip" class="fa">
                                        &#xf2db;
                                    </option>
                                    <option value="fa fa-podcast" class="fa">
                                        &#xf2ce;
                                    </option>
                                    <option value="fa fa-quora" class="fa">
                                        &#xf2c4;
                                    </option>
                                    <option value="fa fa-ravelry" class="fa">
                                        &#xf2d9;
                                    </option>
                                    <option value="fa fa-snowflake-o" class="fa">
                                        &#xf2dc;
                                    </option>
                                    <option value="fa fa-telegram" class="fa">
                                        &#xf2c6;
                                    </option>
                                    <option value="fa fa-times-rectangle" class="fa">
                                        &#xf2d3;
                                    </option>
                                    <option value="fa fa-user-circle" class="fa">
                                        &#xf2bd;
                                    </option>
                                    <option value="fa fa-user-o" class="fa">
                                        &#xf007;
                                    </option>
                                    <option value="fa fa-window-maximize" class="fa">
                                        &#xf2d0;
                                    </option>
                                    <option value="fa fa-window-minimize" class="fa">
                                        &#xf2d1;
                                    </option>
                                    <option value="fa fa-window-restore" class="fa">
                                        &#xf2d2;
                                    </option>
                                    <option value="fa fa-wpexplorer" class="fa">
                                        &#xf2b9;
                                    </option>
                                    <option value="fa fa-angellist" class="fa">
                                        &#xf2de;
                                    </option>
                                    <option value="fa fa-area-chart" class="fa">
                                        &#xf1fe;
                                    </option>
                                    <option value="fa fa-at" class="fa">
                                        &#xf1fa;
                                    </option>
                                    <option value="fa fa-bell-slash" class="fa">
                                        &#xf1f6;
                                    </option>
                                    <option value="fa fa-bicycle" class="fa">
                                        &#xf206;
                                    </option>
                                    <option value="fa fa-binoculars" class="fa">
                                        &#xf1e5;
                                    </option>
                                    <option value="fa fa-birthday-cake" class="fa">
                                        &#xf1fd;
                                    </option>
                                    <option value="fa fa-bus" class="fa">
                                        &#xf207;
                                    </option>
                                    <option value="fa fa-calculador" class="fa">
                                        &#xf1ec;
                                    </option>
                                    <option value="fa fa-cc-mastercard" class="fa">
                                        &#xf1f1;
                                    </option>
                                    <option value="fa fa-cc-paypal" class="fa">
                                        &#xf1f4;
                                    </option>
                                    <option value="fa fa-cc-visa" class="fa">
                                        &#xf1f0;
                                    </option>
                                    <option value="fa fa-copyright" class="fa">
                                        &#xf1f9;
                                    </option>
                                    <option value="fa fa-futbol-o" class="fa">
                                        &#xf1e3;
                                    </option>
                                    <option value="fa fa-line-chart" class="fa">
                                        &#xf201;
                                    </option>
                                    <option value="fa fa-newspaper-o" class="fa">
                                        &#xf1ea;
                                    </option>
                                    <option value="fa fa-paint-brush" class="fa">
                                        &#xf1fc;
                                    </option>
                                    <option value="fa fa-pie-chart" class="fa">
                                        &#xf200;
                                    </option>
                                    <option value="fa fa-plug" class="fa">
                                        &#xf1e6;
                                    </option>
                                    <option value="fa fa-slideshare" class="fa">
                                        &#xf1e7;
                                    </option>
                                    <option value="fa fa-trash" class="fa">
                                        &#xf1f8;
                                    </option>
                                    <option value="fa fa-tty" class="fa">
                                        &#xf1e4;
                                    </option>
                                    <option value="fa fa-wifi" class="fa">
                                        &#xf1eb;
                                    </option>
                                    <option value="fa fa-yelp" class="fa">
                                        &#xf1e9;
                                    </option>
                                    <option value="fa fa-pagelines" class="fa">
                                        &#xf18c;
                                    </option>
                                    <option value="fa fa-stack-exchange" class="fa">
                                        &#xf18d;
                                    </option>
                                    <option value="fa fa-wheelchair" class="fa">
                                        &#xf193;
                                    </option>
                                    <option value="fa fa-vimeo-square" class="fa">
                                        &#xf194;
                                    </option>
                                    <option value="fa fa-plus-square-o" class="fa">
                                        &#xf0fe;
                                    </option>
                                    <option value="fa fa-automobile" class="fa">
                                        &#xf1b9;
                                    </option>
                                    <option value="fa fa-bank" class="fa">
                                        &#xf19c;
                                    </option>
                                    <option value="fa fa-behance-square" class="fa">
                                        &#xf1b5;
                                    </option>
                                    <option value="fa fa-bomb" class="fa">
                                        &#xf1e2;
                                    </option>
                                    <option value="fa fa-building" class="fa">
                                        &#xf1ad;
                                    </option>
                                    <option value="fa fa-child" class="fa">
                                        &#xf1ae;
                                    </option>
                                    <option value="fa fa-codepen" class="fa">
                                        &#xf1cb;
                                    </option>
                                    <option value="fa fa-cube" class="fa">
                                        &#xf1b2;
                                    </option>
                                    <option value="fa fa-cubes" class="fa">
                                        &#xf1b3;
                                    </option>
                                    <option value="fa fa-database" class="fa">
                                        &#xf1c0;
                                    </option>
                                    <option value="fa fa-delicious" class="fa">
                                        &#xf1a5;
                                    </option>
                                    <option value="fa fa-deviantart" class="fa">
                                        &#xf1bd;
                                    </option>
                                    <option value="fa fa-digg" class="fa">
                                        &#xf1a6;
                                    </option>
                                    <option value="fa fa-drupal" class="fa">
                                        &#xf1a9;
                                    </option>
                                    <option value="fa fa-empire" class="fa">
                                        &#xf1d1;
                                    </option>
                                    <option value="fa fa-fax" class="fa">
                                        &#xf1ac;
                                    </option>
                                    <option value="fa fa-file-archive-o" class="fa">
                                        &#xf1c6;
                                    </option>
                                    <option value="fa fa-file-audio-o" class="fa">
                                        &#xf1c7;
                                    </option>
                                    <option value="fa fa-file-code-o" class="fa">
                                        &#xf1c9;
                                    </option>
                                    <option value="fa fa-file-excel-o" class="fa">
                                        &#xf1c3;
                                    </option>
                                    <option value="fa fa-file-image-o" class="fa">
                                        &#xf1c5;
                                    </option>
                                    <option value="fa fa-file-movie-o" class="fa">
                                        &#xf1c8;
                                    </option>
                                    <option value="fa fa-file-pdf-o" class="fa">
                                        &#xf1c1;
                                    </option>
                                    <option value="fa fa-file-photo-o" class="fa">
                                        &#xf1c5;
                                    </option>
                                    <option value="fa fa-google" class="fa">
                                        &#xf1a0;
                                    </option>
                                    <option value="fa fa-graduation-cap" class="fa">
                                        &#xf19d;
                                    </option>
                                    <option value="fa fa-hacker-news" class="fa">
                                        &#xf1d4;
                                    </option>
                                    <option value="fa fa-header" class="fa">
                                        &#xf1dc;
                                    </option>
                                    <option value="fa fa-history" class="fa">
                                        &#xf1da;
                                    </option>
                                    <option value="fa fa-institution" class="fa">
                                        &#xf19c;
                                    </option>
                                    <option value="fa fa-joomla" class="fa">
                                        &#xf1aa;
                                    </option>
                                    <option value="fa fa-jsfiddle" class="fa">
                                        &#xf1cc;
                                    </option>
                                    <option value="fa fa-language" class="fa">
                                        &#xf1ab;
                                    </option>
                                    <option value="fa fa-life-ring" class="fa">
                                        &#xf1cd;
                                    </option>
                                    <option value="fa fa-openid" class="fa">
                                        &#xf19b;
                                    </option>
                                    <option value="fa fa-paper-plane" class="fa">
                                        &#xf1d8;
                                    </option>
                                    <option value="fa fa-paragraph" class="fa">
                                        &#xf1dd;
                                    </option>
                                    <option value="fa fa-paw" class="fa">
                                        &#xf1b0;
                                    </option>
                                    <option value="fa fa-pied-piper-alt" class="fa">
                                        &#xf1a8;
                                    </option>
                                    <option value="fa fa-qq" class="fa">
                                        &#xf1d6;
                                    </option>
                                    <option value="fa fa-rebel" class="fa">
                                        &#xf1d0;
                                    </option>
                                    <option value="fa fa-recycle" class="fa">
                                        &#xf1b8;
                                    </option>
                                    <option value="fa fa-reddit" class="fa">
                                        &#xf1a1;
                                    </option>
                                    <option value="fa fa-share-alt" class="fa">
                                        &#xf1e0;
                                    </option>
                                    <option value="fa fa-slack" class="fa">
                                        &#xf198;
                                    </option>
                                    <option value="fa fa-sliders" class="fa">
                                        &#xf1de;
                                    </option>
                                    <option value="fa fa-soundcloud" class="fa">
                                        &#xf1be;
                                    </option>
                                    <option value="fa fa-space-shuttle" class="fa">
                                        &#xf197;
                                    </option>
                                    <option value="fa fa-spotify" class="fa">
                                        &#xf1bc;
                                    </option>
                                    <option value="fa fa-steam" class="fa">
                                        &#xf1b6;
                                    </option>
                                    <option value="fa fa-stumbleupon" class="fa">
                                        &#xf1a4;
                                    </option>
                                    <option value="fa fa-taxi" class="fa">
                                        &#xf1ba;
                                    </option>
                                    <option value="fa fa-tencent-weibo" class="fa">
                                        &#xf1d5;
                                    </option>
                                    <option value="fa fa-tree" class="fa">
                                        &#xf1bb;
                                    </option>
                                    <option value="fa fa-weixin" class="fa">
                                        &#xf1d7;
                                    </option>
                                    <option value="fa fa-wordpress" class="fa">
                                        &#xf19a;
                                    </option>
                                    <option value="fa fa-yahoo" class="fa">
                                        &#xf19e;
                                    </option>
                                    <option value="fa fa-anchor" class="fa">
                                        &#xf13d;
                                    </option>
                                    <option value="fa fa-archive" class="fa">
                                        &#xf187;
                                    </option>
                                    <option value="fa fa-asterisk" class="fa">
                                        &#xf069;
                                    </option>
                                    <option value="fa fa-ban" class="fa">
                                        &#xf05e;
                                    </option>
                                    <option value="fa fa-bar-chart-o" class="fa">
                                        &#xf080;
                                    </option>
                                    <option value="fa fa-barcode" class="fa">
                                        &#xf02a;
                                    </option>
                                    <option value="fa fa-beer" class="fa">
                                        &#xf0fc;
                                    </option>
                                    <option value="fa fa-bell" class="fa">
                                        &#xf0f3;
                                    </option>
                                    <option value="fa fa-bolt" class="fa">
                                        &#xf0e7;
                                    </option>
                                    <option value="fa fa-book" class="fa">
                                        &#xf02d;
                                    </option>
                                    <option value="fa fa-bookmark" class="fa">
                                        &#xf02e;
                                    </option>
                                    <option value="fa fa-briefcase" class="fa">
                                        &#xf0b1;
                                    </option>
                                    <option value="fa fa-bug" class="fa">
                                        &#xf188;
                                    </option>
                                    <option value="fa fa-bullhorn" class="fa">
                                        &#xf0a1;
                                    </option>
                                    <option value="fa fa-calendar" class="fa">
                                        &#xf073;
                                    </option>
                                    <option value="fa fa-camera" class="fa">
                                        &#xf030;
                                    </option>
                                    <option value="fa fa-certificate" class="fa">
                                        &#xf0a3;
                                    </option>
                                    <option value="fa fa-check" class="fa">
                                        &#xf00c;
                                    </option>
                                    <option value="fa fa-clock-o" class="fa">
                                        &#xf017;
                                    </option>
                                    <option value="fa fa-cloud" class="fa">
                                        &#xf0c2;
                                    </option>
                                    <option value="fa fa-code" class="fa">
                                        &#xf121;
                                    </option>
                                    <option value="fa fa-code-fork" class="fa">
                                        &#xf126;
                                    </option>
                                    <option value="fa fa-coffee" class="fa">
                                        &#xf0f4;
                                    </option>
                                    <option value="fa fa-cog" class="fa">
                                        &#xf013;
                                    </option>
                                    <option value="fa fa-cogs" class="fa">
                                        &#xf085;
                                    </option>
                                    <option value="fa fa-comments" class="fa">
                                        &#xf086;
                                    </option>
                                    <option value="fa fa-compass" class="fa">
                                        &#xf14e;
                                    </option>
                                    <option value="fa fa-crosshairs" class="fa">
                                        &#xf05b;
                                    </option>
                                    <option value="fa fa-desktop" class="fa">
                                        &#xf108;
                                    </option>
                                    <option value="fa fa-download" class="fa">
                                        &#xf019;
                                    </option>
                                    <option value="fa fa-edit" class="fa">
                                        &#xf044;
                                    </option>
                                    <option value="fa fa-eraser" class="fa">
                                        &#xf12d;
                                    </option>
                                    <option value="fa fa-exclamation-triangle" class="fa">
                                        &#xf071;
                                    </option>
                                    <option value="fa fa-eye" class="fa">
                                        &#xf06e;
                                    </option>
                                    <option value="fa fa-female" class="fa">
                                        &#xf182;
                                    </option>
                                    <option value="fa fa-fire" class="fa">
                                        &#xf06d;
                                    </option>
                                    <option value="fa fa-fire-extinguisher" class="fa">
                                        &#xf134;
                                    </option>
                                    <option value="fa fa-flag" class="fa">
                                        &#xf024;
                                    </option>
                                    <option value="fa fa-flask" class="fa">
                                        &#xf0c3;
                                    </option>
                                    <option value="fa fa-folder" class="fa">
                                        &#xf07b;
                                    </option>
                                    <option value="fa fa-folder-open" class="fa">
                                        &#xf07c;
                                    </option>
                                    <option value="fa fa-frown-o" class="fa">
                                        &#xf119;
                                    </option>
                                    <option value="fa fa-gamepad" class="fa">
                                        &#xf11b;
                                    </option>
                                    <option value="fa fa-gavel" class="fa">
                                        &#xf0e3;
                                    </option>
                                    <option value="fa fa-gift" class="fa">
                                        &#xf06b;
                                    </option>
                                    <option value="fa fa-glass" class="fa">
                                        &#xf000;
                                    </option>
                                    <option value="fa fa-globe" class="fa">
                                        &#xf0ac;
                                    </option>
                                    <option value="fa fa-group" class="fa">
                                        &#xf0c0;
                                    </option>
                                    <option value="fa fa-hdd-o" class="fa">
                                        &#xf0a0;
                                    </option>
                                    <option value="fa fa-headphones" class="fa">
                                        &#xf025;
                                    </option>
                                    <option value="fa fa-heart" class="fa">
                                        &#xf21e;
                                    </option>
                                    <option value="fa fa-home" class="fa">
                                        &#xf015;
                                    </option>
                                    <option value="fa fa-inbox" class="fa">
                                        &#xf01c;
                                    </option>
                                    <option value="fa fa-info" class="fa">
                                        &#xf129;
                                    </option>
                                    <option value="fa fa-key" class="fa">
                                        &#xf084;
                                    </option>
                                    <option value="fa fa-keyboard-o" class="fa">
                                        &#xf11c;
                                    </option>
                                    <option value="fa fa-laptop" class="fa">
                                        &#xf109;
                                    </option>
                                    <option value="fa fa-leaf" class="fa">
                                        &#xf06c;
                                    </option>
                                    <option value="fa fa-lemon-o" class="fa">
                                        &#xf094;
                                    </option>
                                    <option value="fa fa-lightbulb-o" class="fa">
                                        &#xf0eb;
                                    </option>
                                    <option value="fa fa-lock" class="fa">
                                        &#xf023;
                                    </option>
                                    <option value="fa fa-magic" class="fa">
                                        &#xf0d0;
                                    </option>
                                    <option value="fa fa-magnet" class="fa">
                                        &#xf076;
                                    </option>
                                    <option value="fa fa-map-marker" class="fa">
                                        &#xf041;
                                    </option>
                                    <option value="fa fa-meh-o" class="fa">
                                        &#xf11a;
                                    </option>
                                    <option value="fa fa-microphone" class="fa">
                                        &#xf130;
                                    </option>
                                    <option value="fa fa-minus" class="fa">
                                        &#xf068;
                                    </option>
                                    <option value="fa fa-money" class="fa">
                                        &#xf0d6;
                                    </option>
                                    <option value="fa fa-moon-o" class="fa">
                                        &#xf186;
                                    </option>
                                    <option value="fa fa-music" class="fa">
                                        &#xf001;
                                    </option>
                                    <option value="fa fa-pencil" class="fa">
                                        &#xf040;
                                    </option>
                                    <option value="fa fa-phone" class="fa">
                                        &#xf095;
                                    </option>
                                    <option value="fa fa-picture-o" class="fa">
                                        &#xf03e;
                                    </option>
                                    <option value="fa fa-plus" class="fa">
                                        &#xf067;
                                    </option>
                                    <option value="fa fa-power-off" class="fa">
                                        &#xf011;
                                    </option>
                                    <option value="fa fa-print" class="fa">
                                        &#xf02f;
                                    </option>
                                    <option value="fa fa-puzzle-piece" class="fa">
                                        &#xf12e;
                                    </option>
                                    <option value="fa fa-qrcode" class="fa">
                                        &#xf029;
                                    </option>
                                    <option value="fa fa-question" class="fa">
                                        &#xf128;
                                    </option>
                                    <option value="fa fa-road" class="fa">
                                        &#xf018;
                                    </option>
                                    <option value="fa fa-rocket" class="fa">
                                        &#xf135;
                                    </option>
                                    <option value="fa fa-rss" class="fa">
                                        &#xf09e;
                                    </option>
                                    <option value="fa fa-search" class="fa">
                                        &#xf00e;
                                    </option>
                                    <option value="fa fa-shield" class="fa">
                                        &#xf132;
                                    </option>

                                    <option value="fa fa-shopping-cart" class="fa">
                                        &#xf07a;
                                    </option>
                                    <option value="fa fa-signal" class="fa">
                                        &#xf012;
                                    </option>
                                    <option value="fa fa-sitemap" class="fa">
                                        &#xf0e8;
                                    </option>
                                    <option value="fa fa-smile-o" class="fa">
                                        &#xf118;
                                    </option>
                                    <option value="fa fa-spinner" class="fa">
                                        &#xf110;
                                    </option>
                                    <option value="fa fa-star" class="fa">
                                        &#xf005;
                                    </option>
                                    <option value="fa fa-suitcase" class="fa">
                                        &#xf0f2;
                                    </option>
                                    <option value="fa fa-sun-o" class="fa">
                                        &#xf185;
                                    </option>
                                    <option value="fa fa-tag" class="fa">
                                        &#xf02b;
                                    </option>
                                    <option value="fa fa-terminal" class="fa">
                                        &#xf120;
                                    </option>
                                    <option value="fa fa-thumb-tack" class="fa">
                                        &#xf08d;
                                    </option>
                                    <option value="fa fa-thumbs-o-down" class="fa">
                                        &#xf165;
                                    </option>
                                    <option value="fa fa-thumbs-o-up" class="fa">
                                        &#xf164;
                                    </option>
                                    <option value="fa fa-ticket" class="fa">
                                        &#xf145;
                                    </option>
                                    <option value="fa fa-tint" class="fa">
                                        &#xf043;
                                    </option>
                                    <option value="fa fa-trophy" class="fa">
                                        &#xf091;
                                    </option>
                                    <option value="fa fa-truck" class="fa">
                                        &#xf0d1;
                                    </option>
                                    <option value="fa fa-umbrella" class="fa">
                                        &#xf0e9;
                                    </option>
                                    <option value="fa fa-unlock" class="fa">
                                        &#xf09c;
                                    </option>
                                    <option value="fa fa-video-camera" class="fa">
                                        &#xf03d;
                                    </option>
                                    <option value="fa fa-volume-up" class="fa">
                                        &#xf028;
                                    </option>
                                    <option value="fa fa-wrench" class="fa">
                                        &#xf0ad;
                                    </option>
                                    <option value="fa fa-usd" class="fa">
                                        &#xf155;
                                    </option>
                                    <option value="fa fa-adn" class="fa">
                                        &#xf170;
                                    </option>
                                    <option value="fa fa-android" class="fa">
                                        &#xf17b;
                                    </option>
                                    <option value="fa fa-apple" class="fa">
                                        &#xf179;
                                    </option>
                                    <option value="fa fa-bitbucket" class="fa">
                                        &#xf171;
                                    </option>
                                    <option value="fa fa-css3" class="fa">
                                        &#xf13c;
                                    </option>
                                    <option value="fa fa-dribbble" class="fa">
                                        &#xf17d;
                                    </option>
                                    <option value="fa fa-dropbox" class="fa">
                                        &#xf16b;
                                    </option>
                                    <option value="fa fa-facebook" class="fa">
                                        &#xf09a;
                                    </option>
                                    <option value="fa fa-flickr" class="fa">
                                        &#xf16e;
                                    </option>
                                    <option value="fa fa-foursquare" class="fa">
                                        &#xf180;
                                    </option>
                                    <option value="fa fa-github-alt" class="fa">
                                        &#xf113;
                                    </option>
                                    <option value="fa fa-google-plus" class="fa">
                                        &#xf0d5;
                                    </option>
                                    <option value="fa fa-html5" class="fa">
                                        &#xf13b;
                                    </option>
                                    <option value="fa fa-instagram" class="fa">
                                        &#xf16d;
                                    </option>
                                    <option value="fa fa-linkedin" class="fa">
                                        &#xf0e1;
                                    </option>
                                    <option value="fa fa-linux" class="fa">
                                        &#xf17c;
                                    </option>
                                    <option value="fa fa-maxcdn" class="fa">
                                        &#xf136;
                                    </option>
                                    <option value="fa fa-pinterest" class="fa">
                                        &#xf231;
                                    </option>
                                    <option value="fa fa-renren" class="fa">
                                        &#xf18b;
                                    </option>
                                    <option value="fa fa-skype" class="fa">
                                        &#xf17e;
                                    </option>
                                    <option value="fa fa-stack-overflow" class="fa">
                                        &#xf16c;
                                    </option>
                                    <option value="fa fa-tumblr" class="fa">
                                        &#xf173;
                                    </option>
                                    <option value="fa fa-twitter" class="fa">
                                        &#xf099;
                                    </option>
                                    <option value="fa fa-vk" class="fa">
                                        &#xf189;
                                    </option>
                                    <option value="fa fa-weibo" class="fa">
                                        &#xf18a;
                                    </option>
                                    <option value="fa fa-windows" class="fa">
                                        &#xf17a;
                                    </option>
                                    <option value="fa fa-xing" class="fa">
                                        &#xf168;
                                    </option>
                                    <option value="fa fa-youtube-play" class="fa">
                                        &#xf167;
                                    </option>
                                    <option value="fa fa-ambulance" class="fa">
                                        &#xf0f9;
                                    </option>
                                    <option value="fa fa-hospital-o" class="fa">
                                        &#xf0f8;
                                    </option>
                                    <option value="fa fa-user-md" class="fa">
                                        &#xf0f0;
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label class="col-sm-2 col-form-label">Estado</label>
                            <div class="col-sm-12">
                                <select class="form-control m-b" id="estadoEc" name="estadoEc">
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

<!-- Fin Caracteristicas -->


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

    function mostrarBaner(){
        $('#banner').modal('show');
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
/*
    function editarResumenEmpresa(id, nombre, descripcion, estado, imagen){
        $('#idBanner').val(id);
        $('#eNombre').val(nombre);
        $('#eDescripcion').val(descripcion);
        $('#eIBanner').val(imagen);
        $('#eLBanner').val(imagen);
        $('#eEstado').val(estado);
        $('#ebanner').modal('show');
    }
    */

    $(document).on("submit",".formeBanner",function(e){
        e.preventDefault();
        var formu = $(this);
        var nombreform = $(this).attr("id");
        
        if (nombreform == "febanner") {
            var miurl = "{{ Route('editarBanner') }}";
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
        $('#eRDescripcion').val(descripcion);
        $('#eIcono').val(icono);
        $('#eFoto').val(imagen);
        $('#eBtnAsignar').val(tituloboton);
        $('#eAsignarUrl').val(urlboton);
        $('#eResumenEstado').val(estado);
        $('#eResumenEmpresa').modal('show');

    }

    $(document).on("submit",".formeResumenEmpresa",function(e){
        e.preventDefault();
        var formu = $(this);
        var nombreform = $(this).attr("id");
        
        if (nombreform == "efresumenEmpresa") {
            var miurl = "{{ Route('editarResumenEmpresa') }}";
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

    function mostrarResumenEmpresa(){
        $('#resumenEmpresa').modal('show');
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

    function editarCaracteristica(id, titulo, descripcion, icono, estado){
        $('#idEc').val(id);
        $('#tituloEc').val(titulo);
        $('#descripcionEc').val(descripcion);
        $('#iconoEc').val(icono);
        $('#estadoEc').val(estado);
        $('#caracteristicasEc').modal('show');
    }

    $(document).on("submit",".formCaracteristicaEc",function(e){
        e.preventDefault();
        var formu = $(this);
        var nombreform = $(this).attr("id");
        
        if (nombreform == "fcaracteristicaEc") {
            var miurl = "{{ Route('editarCaracteristica') }}";
        }
        var formData = new FormData($("#"+nombreform+"")[0]);
        
        $.ajax({ url: miurl, type: 'POST', data: formData, cache: false, contentType: false, processData: false,
                beforeSend: function(){
                    toastr.success('Espere', 'Subiendo Archivos, por favor espere');
                    $('#caracteristicasEc').modal('hide');
                },
                success: function(data){
                    toastr.success('Correcto', 'Se Subio Correctamente');
                    $("#tblCaracteristica").empty();
                    $("#tblCaracteristica").html(data.view);
                },
                error: function(data) {
                    toastr.error('Error', 'Error al subir archivos');
                }
        });
    });

    function eliminarCaracteristica(id, titulo){

        swal({
            title: titulo,
            text: "¿Desea eliminar esta caracteristica?",
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

                $.post( "{{ Route('eliminarCaracteristica') }}", {id: id, _token:'{{csrf_token()}}'}).done(function(data) {
                    $("#tblPorQueElegirnos").empty();
                    $("#tblPorQueElegirnos").html(data.view);
        
                    if(data.res == "1"){
                        swal("Eliminado!", "La caracteristica se eliminó", "success");
                    }else{
                        swal("Error!", "Hubo un problema al eliminar la característica", "error");
                    }
        
        
                });

              
            } else {
              swal("Cancelado", "Siga trabajando :)", "error");
            }
          });
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

    $(document).on("submit",".formBanner",function(e){
        e.preventDefault();
        var formu = $(this);
        var nombreform = $(this).attr("id");
        
        if (nombreform == "fbanner") {
            var miurl = "{{ Route('guardarBanner') }}";
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
