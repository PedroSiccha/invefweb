<?php 
    use App\proceso; 
    $pro = new proceso();
?>

<!DOCTYPE html>
<html>

<head> 

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>INVEF | Registrar</title>

    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('font-awesome/css/font-awesome.css')}}" rel="stylesheet">

    <!-- Toastr style -->
    <link href="{{asset('css/plugins/toastr/toastr.min.css')}}" rel="stylesheet">

    <!-- Gritter -->
    <link href="{{asset('js/plugins/gritter/jquery.gritter.css')}}" rel="stylesheet">

    <link href="{{asset('css/animate.css')}}" rel="stylesheet">
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
    <link href="{{asset('css/plugins/sweetalert/sweetalert.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css')}}">

</head>

<body>
    <div id="wrapper">
        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav metismenu" id="side-menu">
                    <li class="nav-header">
                        <div class="dropdown profile-element">
                            <img src="{{ asset('img/log.png') }}" width="150">
                        </div>
                        <div class="logo-element">
                            INVEF
                        </div>
                    </li>
                    <li>
                        <a href="{{ Route('web') }}"><i class="fa fa-th-large"></i> <span class="nav-label">Inicio</span></a>
                    </li>
                </ul>
            </div>
        </nav>

        <div id="page-wrapper" class="gray-bg dashbard-1">
        <div class="row border-bottom">
        <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
        </div>
            <ul class="nav navbar-top-links navbar-right">
                <li style="padding: 20px">
                    <span class="m-r-sm text-muted welcome-message">Bienvenido al Invef.</span>
                </li>
            </ul>

        </nav>
        </div>
        
        <div >
            
            <div class="row" >
                <div class="col-lg-12">
                    <div class="ibox ">
                        <div class="ibox-title">
                            <h5>Nuevo Cliente</h5>
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
                        <div class="ibox-content">
                          <form id="fcliente" name="fcliente" method="post" action="guardarCliente" class="formCliente" enctype="multipart/form-data">
                            <div class="form-group row">
            
                                <div class="col-sm-10">
                                    <div class="row">
                                        <input type="text" name="_token" id="_token" hidden value="{{ csrf_token() }}">
                                        <div class="col-md-6">
                                            <label class="col-sm-2 col-form-label">Nombres</label>
                                            <input type="text" placeholder="Ingrese los Nombres" class="form-control" id="nombre" name="nombre" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="col-sm-2 col-form-label">Apellidos</label>
                                            <input type="text" placeholder="Ingrese los Apellidos" class="form-control" id="apellido" name="apellido" required>
                                        </div>
                                        <!--
                                        <div class="col-md-6" id="divTipoDoc">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <label class="col-sm-6 col-form-label">Tipo de Documento</label>
                                                </div>
                                            </div>
                                            <select class="form-control m-b" name="tipodoc_id" id="tipodoc_id">
                                                <option>Seleccionar Tipo de Documentación...</option>
                                                @foreach ($tipodoc as $td)
                                                    <option value="{{ $td->id }}">{{ $td->nombre }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        -->
                                        <div class="col-md-6">
                                            <label class="col-sm-2 col-form-label">DNI</label>
                                            <input type="text" placeholder="Ingrese el DNI" class="form-control" id="dni" name="dni" required maxlength="8" onkeypress="return event.charCode >= 48 && event.charCode <= 57" onkeyup="verificarDNI()">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="col-sm-2 col-form-label">Correo</label>
                                            <input type="email" placeholder="Ingrese el Correo" class="form-control" id="correo" name="correo">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="col-sm-2 col-form-label">Teléfono</label>
                                            <div class="btn-group">
                                            <button type="button" class="btn btn-default btn-xs" data-toggle="dropdown"><i class="fa fa-plus"></i></button>
                                                <ul class="dropdown-menu">
                                                    <li><input type="text" placeholder="Telf de Referencia" class="form-control" id="tlfReferencia" name="tlfReferencia"></li>
                                                </ul>
                                            </div>
                                            <div class="btn-group">
                                            <button type="button" class="btn btn-primary btn-xs" data-toggle="dropdown"><i class="fa fa-whatsapp"></i></button>
                                                <ul class="dropdown-menu">
                                                    <li><input type="text" placeholder="Num de Whatsapp" class="form-control" id="whastapp" name="whastapp"></li>
                                                </ul>
                                            </div>
                                            <div class="col-md-12">
                                                <input type="text" placeholder="Ingrese un número de telefono" class="form-control" id="telefono" name="telefono">    
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="col-sm-2 col-form-label">Dirección</label>
                                            <div class="col-md-12 row">
                                                <div class="col-sm-4" id="listDepartamento">
                                                    <select class="form-control m-b" name="departamento_id" id="departamento_id" onchange="mostrarProvincia()" onclick="mostrarProvincia()">
                                                        <option>Departamento</option>
                                                        @foreach ($departamento as $de)
                                                            <option value="{{ $de->id }}">{{ $de->departamento }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-sm-4" id="listProvincia">
                                                    <select class="form-control m-b" name="provincia_id" id="provincia_id">
                                                        <option>Provincia</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-4" id="listDistrito">
                                                    <select class="form-control m-b" name="distrito_id" id="distrito_id">
                                                        <option>Distrito</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-12">
                                                <input type="text" placeholder="Ingrese una Dirección" class="form-control" id="direccion" required name="direccion">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="col-sm-4 col-form-label">Fecha de Nacimiento</label>
                                            <input type="date" class="form-control" id="fechanacimiento" required onchange="calcularEdadInput()" name="fecnacimiento">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="col-sm-2 col-form-label">Edad</label>
                                            <input type="text" placeholder="Edad Del Cliente" class="form-control" id="edad" required readonly="readonly" name="edad">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="col-sm-2 col-form-label">Género</label>
                                            <div class="i-checks">
                                                <label> 
                                                    <input type="radio" value="Masculino" name="a" id="genMasculino"> 
                                                    <i></i> Masculino 
                                                </label>
                                            </div>
                                            <div class="i-checks">
                                                <label> 
                                                    <input type="radio" checked="" value="Femenino" name="a" id="genFemenino"> 
                                                    <i></i> Femenino 
                                                </label>
                                            </div>
                                        </div>
                                        <!--
                                        <div class="col-md-6">
                                            <label class="col-sm-2 col-form-label">Foto</label>
                                            <div class="custom-file">
                                                <input id="logo" type="file" class="custom-file-input" id="foto" name="foto">
                                                <label for="logo" class="custom-file-label">Seleccionar...</label>
                                        </div>
                                    </div>
                                    -->
                                    <div class="col-md-6">
                                        <label class="col-sm-2 col-form-label">Facebook</label>
                                        <input type="text" placeholder="Ingrese una cuenta de Facebook" class="form-control" id="facebook" name="facebook">
                                    </div>
                                    <!--
                                    <div class="col-md-6">
                                        <label class="col-sm-4 col-form-label">Nivel de Ingresos</label>
                                        <div class="col-sm-10">
                                            <select class="form-control m-b" id="nIMax" name="ingmax">
                                                <option>Max.</option>
                                                <option value="0">S/. 0.00</option>
                                                <option value="500">S/. 500.00</option>
                                                <option value="1000">S/. 1000.00</option>
                                                <option value="1500">S/. 1500.00</option>
                                                <option value="2000">S/. 2000.00</option>
                                                <option value="2500">S/. 2500.00</option>
                                                <option value="3000">S/. 3000.00</option>
                                                <option value="3500">S/. 3500.00</option>
                                                <option value="4000">S/. 4000.00</option>
                                                <option value="4500">S/. 4500.00</option>
                                                <option value="5000">S/. 5000.00</option>
                                            </select>
                                            <select class="form-control m-b" name="ingmin" id="nIMin">
                                                <option>Min</option>
                                                <option value="0">S/. 0.00</option>
                                                <option value="500">S/. 500.00</option>
                                                <option value="1000">S/. 1000.00</option>
                                                <option value="1500">S/. 1500.00</option>
                                                <option value="2000">S/. 2000.00</option>
                                                <option value="2500">S/. 2500.00</option>
                                                <option value="3000">S/. 3000.00</option>
                                                <option value="3500">S/. 3500.00</option>
                                                <option value="4000">S/. 4000.00</option>
                                                <option value="4500">S/. 4500.00</option>
                                                <option value="5000">S/. 5000.00</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="col-sm-4 col-form-label">Nivel de Gastos</label>
                                        <div class="col-sm-10">
                                            <select class="form-control m-b" name="gasmax" id="nGMax">
                                                <option>Max.</option>
                                                <option value="0">S/. 0.00</option>
                                                <option value="500">S/. 500.00</option>
                                                <option value="1000">S/. 1000.00</option>
                                                <option value="1500">S/. 1500.00</option>
                                                <option value="2000">S/. 2000.00</option>
                                                <option value="2500">S/. 2500.00</option>
                                                <option value="3000">S/. 3000.00</option>
                                                <option value="3500">S/. 3500.00</option>
                                                <option value="4000">S/. 4000.00</option>
                                                <option value="4500">S/. 4500.00</option>
                                                <option value="5000">S/. 5000.00</option>
                                            </select>
                                            <select class="form-control m-b" name="gasmin" id="nGMin">
                                                <option>Min</option>
                                                <option value="0">S/. 0.00</option>
                                                <option value="500">S/. 500.00</option>
                                                <option value="1000">S/. 1000.00</option>
                                                <option value="1500">S/. 1500.00</option>
                                                <option value="2000">S/. 2000.00</option>
                                                <option value="2500">S/. 2500.00</option>
                                                <option value="3000">S/. 3000.00</option>
                                                <option value="3500">S/. 3500.00</option>
                                                <option value="4000">S/. 4000.00</option>
                                                <option value="4500">S/. 4500.00</option>
                                                <option value="5000">S/. 5000.00</option>
                                            </select>
                                        </div>
                                    </div>
                                    -->
                                    <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <label class="col-sm-2 col-form-label">Ocupación</label>
                                                </div>
                                            </div>
                                        <div class="col-sm-10" id="listOcupacion">
                                            <select class="form-control m-b" name="ocupacion_id" id="ocupacion_id">
                                                <option>Seleccionar Una Ocupación...</option>
                                                @foreach ($ocupacion as $o)
                                                    <option value="{{ $o->id }}">{{ $o->nombre }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <label class="col-sm-2 col-form-label">Recomendacion</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-10" id="listRecomendacion">
                                            <select class="form-control m-b" name="recomendado_id" id="recomendado_id">
                                                <option>Seleccionar un Tipo de Recomendación...</option>
                                                @foreach ($recomendacion as $r)
                                                    <option value="{{ $r->id }}">{{ $r->recomendacion }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary" data-dismiss="modal">Guardar</button>
                        </div>
                    </form>
                    </div>
                    </div>
                </div>
            </div>
            
            <!-- Modal Crear Ocupacion -->
            <div class="modal inmodal fade" id="mOcupacion" tabindex="-1" role="dialog"  aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <h4 class="modal-title">Registra Ocupación</h4>
                        </div>
                        <div class="modal-body">
                            <label class="col-sm-2 col-form-label">Nueva Ocupación</label>
                            <input type="text" placeholder="Ingrese nueva ocupación" class="form-control" id="nOcupacion" name="nOcupacion">
                        </div>
            
                        <div class="modal-footer">
                            <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-primary" onclick="GuardarOcupacion()">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Fin del Modal Ocupacion-->
            <!-- Modal Crear Recomendacion -->
            <div class="modal inmodal fade" id="mRecomendacion" tabindex="-1" role="dialog"  aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <h4 class="modal-title">Registrar Recomendación</h4>
                        </div>
                        <div class="modal-body">
                            <label class="col-sm-2 col-form-label">Nueva Recomendacion</label>
                            <input type="text" placeholder="Ingrese nueva recomendación" class="form-control" id="nRecomendacion" name="nRecomendacion">
                        </div>
            
                        <div class="modal-footer">
                            <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-primary" onclick="GuardarRecomendacion()">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Fin Modal Recomendacion -->
            <!-- Modal Crear TipoDocumento -->
            <div class="modal inmodal fade" id="mTipoDocumento" tabindex="-1" role="dialog"  aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <h4 class="modal-title">Registrar Nuevo Tipo de Documento</h4>
                        </div>
                        <div class="modal-body">
                            <label class="col-sm-2 col-form-label">Nuevo Tipo de Documento</label>
                            <input type="text" placeholder="Ingrese nueva recomendación" class="form-control" id="nTipoDocumento" name="nTipoDocumento">
                        </div>
            
                        <div class="modal-footer">
                            <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-primary" onclick="GuardarTipoDocumento()">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        

        <div class="footer">
            <div class="float-right">
                
            </div>
            <div>
                <strong>InfoRAD</strong> Desarrollado en 2019
            </div>
        </div>
        </div>
        <div class="small-chat-box fadeInRight animated">

            <div class="heading" draggable="true">
                <small class="chat-date float-right">
                    02.19.2015
                </small>
                Small chat
            </div>

            <div class="content">

                <div class="left">
                    <div class="author-name">
                        Monica Jackson <small class="chat-date">
                        10:02 am
                    </small>
                    </div>
                    <div class="chat-message active">
                        Lorem Ipsum is simply dummy text input.
                    </div>

                </div>
                <div class="right">
                    <div class="author-name">
                        Mick Smith
                        <small class="chat-date">
                            11:24 am
                        </small>
                    </div>
                    <div class="chat-message">
                        Lorem Ipsum is simpl.
                    </div>
                </div>
                <div class="left">
                    <div class="author-name">
                        Alice Novak
                        <small class="chat-date">
                            08:45 pm
                        </small>
                    </div>
                    <div class="chat-message active">
                        Check this stock char.
                    </div>
                </div>
                <div class="right">
                    <div class="author-name">
                        Anna Lamson
                        <small class="chat-date">
                            11:24 am
                        </small>
                    </div>
                    <div class="chat-message">
                        The standard chunk of Lorem Ipsum
                    </div>
                </div>
                <div class="left">
                    <div class="author-name">
                        Mick Lane
                        <small class="chat-date">
                            08:45 pm
                        </small>
                    </div>
                    <div class="chat-message active">
                        I belive that. Lorem Ipsum is simply dummy text.
                    </div>
                </div>


            </div>
            <div class="form-chat">
                <div class="input-group input-group-sm">
                    <input type="text" class="form-control">
                    <span class="input-group-btn"> <button
                        class="btn btn-primary" type="button">Send
                </button> </span></div>
            </div>

        </div>
        <div id="right-sidebar" class="animated">
            <div class="sidebar-container">

                <ul class="nav nav-tabs navs-3">
                    <li>
                        <a class="nav-link active" data-toggle="tab" href="#tab-1"> Correos </a>
                    </li>
                    <li>
                        <a class="nav-link" data-toggle="tab" href="#tab-2"> Reuniones </a>
                    </li>
                </ul>

                <div class="tab-content">


                    <div id="tab-1" class="tab-pane active">

                        <div class="sidebar-title">
                            <h3> <i class="fa fa-comments-o"></i> Latest Notes</h3>
                            <small><i class="fa fa-tim"></i> You have 10 new message.</small>
                        </div>

                        <div>

                            <div class="sidebar-message">
                                <a href="#">
                                    <div class="float-left text-center">
                                        <img alt="image" class="rounded-circle message-avatar" src="img/a1.jpg">

                                        <div class="m-t-xs">
                                            <i class="fa fa-star text-warning"></i>
                                            <i class="fa fa-star text-warning"></i>
                                        </div>
                                    </div>
                                    <div class="media-body">

                                        There are many variations of passages of Lorem Ipsum available.
                                        <br>
                                        <small class="text-muted">Today 4:21 pm</small>
                                    </div>
                                </a>
                            </div>
                            <div class="sidebar-message">
                                <a href="#">
                                    <div class="float-left text-center">
                                        <img alt="image" class="rounded-circle message-avatar" src="img/a2.jpg">
                                    </div>
                                    <div class="media-body">
                                        The point of using Lorem Ipsum is that it has a more-or-less normal.
                                        <br>
                                        <small class="text-muted">Yesterday 2:45 pm</small>
                                    </div>
                                </a>
                            </div>
                            <div class="sidebar-message">
                                <a href="#">
                                    <div class="float-left text-center">
                                        <img alt="image" class="rounded-circle message-avatar" src="img/a3.jpg">

                                        <div class="m-t-xs">
                                            <i class="fa fa-star text-warning"></i>
                                            <i class="fa fa-star text-warning"></i>
                                            <i class="fa fa-star text-warning"></i>
                                        </div>
                                    </div>
                                    <div class="media-body">
                                        Mevolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).
                                        <br>
                                        <small class="text-muted">Yesterday 1:10 pm</small>
                                    </div>
                                </a>
                            </div>
                            <div class="sidebar-message">
                                <a href="#">
                                    <div class="float-left text-center">
                                        <img alt="image" class="rounded-circle message-avatar" src="img/a4.jpg">
                                    </div>

                                    <div class="media-body">
                                        Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the
                                        <br>
                                        <small class="text-muted">Monday 8:37 pm</small>
                                    </div>
                                </a>
                            </div>
                            <div class="sidebar-message">
                                <a href="#">
                                    <div class="float-left text-center">
                                        <img alt="image" class="rounded-circle message-avatar" src="img/a8.jpg">
                                    </div>
                                    <div class="media-body">

                                        All the Lorem Ipsum generators on the Internet tend to repeat.
                                        <br>
                                        <small class="text-muted">Today 4:21 pm</small>
                                    </div>
                                </a>
                            </div>
                            <div class="sidebar-message">
                                <a href="#">
                                    <div class="float-left text-center">
                                        <img alt="image" class="rounded-circle message-avatar" src="img/a7.jpg">
                                    </div>
                                    <div class="media-body">
                                        Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.
                                        <br>
                                        <small class="text-muted">Yesterday 2:45 pm</small>
                                    </div>
                                </a>
                            </div>
                            <div class="sidebar-message">
                                <a href="#">
                                    <div class="float-left text-center">
                                        <img alt="image" class="rounded-circle message-avatar" src="img/a3.jpg">

                                        <div class="m-t-xs">
                                            <i class="fa fa-star text-warning"></i>
                                            <i class="fa fa-star text-warning"></i>
                                            <i class="fa fa-star text-warning"></i>
                                        </div>
                                    </div>
                                    <div class="media-body">
                                        The standard chunk of Lorem Ipsum used since the 1500s is reproduced below.
                                        <br>
                                        <small class="text-muted">Yesterday 1:10 pm</small>
                                    </div>
                                </a>
                            </div>
                            <div class="sidebar-message">
                                <a href="#">
                                    <div class="float-left text-center">
                                        <img alt="image" class="rounded-circle message-avatar" src="img/a4.jpg">
                                    </div>
                                    <div class="media-body">
                                        Uncover many web sites still in their infancy. Various versions have.
                                        <br>
                                        <small class="text-muted">Monday 8:37 pm</small>
                                    </div>
                                </a>
                            </div>
                        </div>

                    </div>

                    <div id="tab-2" class="tab-pane">

                        <div class="sidebar-title">
                            <h3> <i class="fa fa-cube"></i> Latest projects</h3>
                            <small><i class="fa fa-tim"></i> You have 14 projects. 10 not completed.</small>
                        </div>

                        <ul class="sidebar-list">
                            <li>
                                <a href="#">
                                    <div class="small float-right m-t-xs">9 hours ago</div>
                                    <h4>Business valuation</h4>
                                    It is a long established fact that a reader will be distracted.

                                    <div class="small">Completion with: 22%</div>
                                    <div class="progress progress-mini">
                                        <div style="width: 22%;" class="progress-bar progress-bar-warning"></div>
                                    </div>
                                    <div class="small text-muted m-t-xs">Project end: 4:00 pm - 12.06.2014</div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="small float-right m-t-xs">9 hours ago</div>
                                    <h4>Contract with Company </h4>
                                    Many desktop publishing packages and web page editors.

                                    <div class="small">Completion with: 48%</div>
                                    <div class="progress progress-mini">
                                        <div style="width: 48%;" class="progress-bar"></div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="small float-right m-t-xs">9 hours ago</div>
                                    <h4>Meeting</h4>
                                    By the readable content of a page when looking at its layout.

                                    <div class="small">Completion with: 14%</div>
                                    <div class="progress progress-mini">
                                        <div style="width: 14%;" class="progress-bar progress-bar-info"></div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="label label-primary float-right">NEW</span>
                                    <h4>The generated</h4>
                                    There are many variations of passages of Lorem Ipsum available.
                                    <div class="small">Completion with: 22%</div>
                                    <div class="small text-muted m-t-xs">Project end: 4:00 pm - 12.06.2014</div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="small float-right m-t-xs">9 hours ago</div>
                                    <h4>Business valuation</h4>
                                    It is a long established fact that a reader will be distracted.

                                    <div class="small">Completion with: 22%</div>
                                    <div class="progress progress-mini">
                                        <div style="width: 22%;" class="progress-bar progress-bar-warning"></div>
                                    </div>
                                    <div class="small text-muted m-t-xs">Project end: 4:00 pm - 12.06.2014</div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="small float-right m-t-xs">9 hours ago</div>
                                    <h4>Contract with Company </h4>
                                    Many desktop publishing packages and web page editors.

                                    <div class="small">Completion with: 48%</div>
                                    <div class="progress progress-mini">
                                        <div style="width: 48%;" class="progress-bar"></div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="small float-right m-t-xs">9 hours ago</div>
                                    <h4>Meeting</h4>
                                    By the readable content of a page when looking at its layout.

                                    <div class="small">Completion with: 14%</div>
                                    <div class="progress progress-mini">
                                        <div style="width: 14%;" class="progress-bar progress-bar-info"></div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="label label-primary float-right">NEW</span>
                                    <h4>The generated</h4>
                                    <!--<div class="small float-right m-t-xs">9 hours ago</div>-->
                                    There are many variations of passages of Lorem Ipsum available.
                                    <div class="small">Completion with: 22%</div>
                                    <div class="small text-muted m-t-xs">Project end: 4:00 pm - 12.06.2014</div>
                                </a>
                            </li>

                        </ul>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal inmodal" id="dniEvaluacion" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content animated flipInY">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Ingrese DNI</h4>
                    <small class="font-bold">Ingrese un dni para su evaluación.</small>
                </div>
                <div class="modal-body">
                    <input type="text" placeholder="Ingrese dni" class="form-control" id="dniEvaluacionHome" name="dniEvaluacionHome">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="buscarClienteE()">Aceptar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal inmodal" id="dniPrestamo" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content animated flipInY">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Ingrese DNI</h4>
                    <small class="font-bold">Ingrese un dni para realizar su prestamo.</small>
                </div>
                <div class="modal-body">
                    <input type="text" placeholder="Ingrese dni" class="form-control" id="dniPrestamoHome" name="dniPrestamoHome">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="buscarClienteP()">Aceptar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal inmodal" id="abrirCaja" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content animated flipInY">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">ABRIR CAJA</h4>
                    <small class="font-bold">Haga click para abrir la caja de la fecha {{ date('Y-m-d') }}.</small>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="buscarClienteP()">Aceptar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="{{asset('js/jquery-3.1.1.min.js')}}"></script>
    <script src="{{asset('js/popper.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.js')}}"></script>
    <script src="{{asset('js/plugins/metisMenu/jquery.metisMenu.js')}}"></script>
    <script src="{{asset('js/plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>

    <!-- Flot -->
    <script src="{{asset('js/plugins/flot/jquery.flot.js')}}"></script>
    <script src="{{asset('js/plugins/flot/jquery.flot.tooltip.min.js')}}"></script>
    <script src="{{asset('js/plugins/flot/jquery.flot.spline.js')}}"></script>
    <script src="{{asset('js/plugins/flot/jquery.flot.resize.js')}}"></script>
    <script src="{{asset('js/plugins/flot/jquery.flot.pie.js')}}"></script>

    <!-- Peity -->
    <script src="{{asset('js/plugins/peity/jquery.peity.min.js')}}"></script>
    <script src="{{asset('js/demo/peity-demo.js')}}"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{asset('js/inspinia.js')}}"></script>
    <script src="{{asset('js/plugins/pace/pace.min.js')}}"></script>

    <!-- jQuery UI -->
    <script src="{{asset('js/plugins/jquery-ui/jquery-ui.min.js')}}"></script>

    <!-- GITTER -->
    <script src="{{asset('js/plugins/gritter/jquery.gritter.min.js')}}"></script>

    <!-- Sparkline -->
    <script src="{{asset('js/plugins/sparkline/jquery.sparkline.min.js')}}"></script>

    <!-- Sparkline demo data  -->
    <script src="{{asset('js/demo/sparkline-demo.js')}}"></script>

    <!-- ChartJS-->
    <script src="{{asset('js/plugins/chartJs/Chart.min.js')}}"></script>

    <!-- Toastr -->
    <script src="{{asset('js/plugins/toastr/toastr.min.js')}}"></script>
    <script src="{{asset('js/plugins/sweetalert/sweetalert.min.js')}}"></script>
   

    @yield('script')
    <script>
        function evaluacionHome() {
            $('#dniEvaluacion').modal('show');
        }
        
        function prestamoHome() {
            $('#dniPrestamo').modal('show');
        }

        function buscarClienteE(){
            var dni = $("#dniEvaluacionHome").val();

            $.post( "{{ Route('buscarClienteH') }}", {dni: dni, _token:'{{csrf_token()}}'}).done(function(data) {
                if (data.estado == 1) {
                    window.location="/perfilCliente/"+data.id;
                }else{
                    window.location="{{ Route('cliente') }}";
                }
            });
        }

        function buscarClienteP(){
            var dni = $("#dniPrestamoHome").val();

            $.post( "{{ Route('buscarClienteHP') }}", {dni: dni, _token:'{{csrf_token()}}'}).done(function(data) {
                if (data.estado == 1) {
                    window.location="/perfilCliente/"+data.id;
                }else if(data.estado == 2){
                    window.location="/prestamo/"+data.id;
                }else if(data.estado == 0){
                    window.location="{{ Route('cliente') }}";
                }
            });
        }

        
    </script>
</body>
</html>
<script> 

    $(document).ready(function(){
        $('.custom-file-input').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        });
    });
    
    function calcularEdadInput() {
        var birthday = $("#fechanacimiento").val();
        var fechaNace = new Date(birthday);
        var fechaActual = new Date()
        var mes = fechaActual.getMonth();
        var dia = fechaActual.getDate();
        var año = fechaActual.getFullYear();
        fechaActual.setDate(dia);
        fechaActual.setMonth(mes);
        fechaActual.setFullYear(año);
        edad = Math.floor(((fechaActual - fechaNace) / (1000 * 60 * 60 * 24) / 365));
        $("#edad").val(edad);
        
    }
    $(document).on("submit",".formCliente",function(e){
        
        e.preventDefault();
        var formu = $(this);
        var nombreform = $(this).attr("id");
        
        if ($('#genMasculino').is(":checked"))
        {
            var genero = "Masculino";
        }else{
            var genero = "Femenino";
        }
        
        if (nombreform == "fcliente") {
            var miurl = "{{ Route('guardarCliente') }}";
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
                        title: "Cliente",
                        text: "Se guardó exitosamente",
                        type: "success",
                        showCancelButton: true,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "Finalizar",
                        closeOnConfirm: false
                    },
                    function(isConfirm){
                        if (isConfirm) {            
                        window.location="{{ Route('web') }}";
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
                        toastr.error('Error al registrar el cliente');

                    }, 1300);
                }
        });
    });

    function verModalOcupacion() {
        $('#mOcupacion').modal('show');
    }
    function GuardarOcupacion(){
        var ocupacion=$("#nOcupacion").val();
        $.post( "{{ Route('guardarOcupacion') }}", {ocupacion: ocupacion, _token:'{{csrf_token()}}'}).done(function(data) {
            $("#listOcupacion").empty();
            $("#listOcupacion").html(data.view);
            $('#mOcupacion').modal('hide');
            setTimeout(function() {
                toastr.options = {
                    closeButton: true,
                    progressBar: true,
                    showMethod: 'slideDown',
                    timeOut: 4000,
                    positionClass: 'toast-top-center'
                };
                toastr.success(data.ocupa, 'Ocupacion Registrada');

            }, 1300);

        });
    }

    function verModalRecomendacion() {
        $('#mRecomendacion').modal('show');
    }
    function GuardarRecomendacion(){
        var recomendacion=$("#nRecomendacion").val();
        $.post( "{{ Route('guardarRecomendacion') }}", {recomendacion: recomendacion, _token:'{{csrf_token()}}'}).done(function(data) {
            $("#listRecomendacion").empty();
            $("#listRecomendacion").html(data.view);
            $('#mRecomendacion').modal('hide');
            setTimeout(function() {
                toastr.options = {
                    closeButton: true,
                    progressBar: true,
                    showMethod: 'slideDown',
                    timeOut: 4000,
                    positionClass: 'toast-top-center'
                };
                toastr.success(data.recu, 'Recomendacion Registrada');

            }, 1300);

        });
    }

    function verModalTipoDocumento(){
        $('#mTipoDocumento').modal('show');
    }

    function GuardarTipoDocumento(){
        var tipodocumento=$("#nTipoDocumento").val();
        $.post( "{{ Route('guardarTipoDocumento') }}", {tipodocumento: tipodocumento, _token:'{{csrf_token()}}'}).done(function(data) {
            $("#divTipoDoc").empty();
            $("#divTipoDoc").html(data.view);
            $('#mTipoDocumento').modal('hide');
            setTimeout(function() {
                toastr.options = {
                    closeButton: true,
                    progressBar: true,
                    showMethod: 'slideDown',
                    timeOut: 4000,
                    positionClass: 'toast-top-center'
                };
                toastr.success(data.recu, 'TIpo de Documento Guardado Correctamente');

            }, 1300);

        });
    }

    function mostrarProvincia(){
        var departamento_id = $("#departamento_id").val();
        
        $.post( "{{ Route('mostrarProvincia') }}", {departamento_id: departamento_id, _token:'{{csrf_token()}}'}).done(function(data) {
            $("#listProvincia").empty();
            $("#listProvincia").html(data.view);
        });
    }

    function mostrarDistrito(){
        var provincia_id = $("#provincia_id").val();
        
        $.post( "{{ Route('mostrarDistrito') }}", {provincia_id: provincia_id, _token:'{{csrf_token()}}'}).done(function(data) {
            $("#listDistrito").empty();
            $("#listDistrito").html(data.view);
        });
    }

    function verificarDNI() {
        var dni = $("#dni").val();

        $.post( "{{ Route('verificarDNI') }}", {dni: dni, _token:'{{csrf_token()}}'}).done(function(data) {
            
            if (data.resp == 1) {
                    setTimeout(function() {
                    toastr.options = {
                        closeButton: true,
                        progressBar: true,
                        showMethod: 'slideDown',
                        timeOut: 4000,
                        positionClass: 'toast-top-center'
                    };
                    toastr.error('VERIFICAR DNI', 'El Dni Ingresado ya existe');

                }, 1300);
            }
        });
    }

</script>