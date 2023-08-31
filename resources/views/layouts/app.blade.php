@php
    $pro = app('App\Models\Proceso');
@endphp
<!DOCTYPE html>
<html>

<head> 

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>INVEF | @yield('pagina')</title>

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
    <link href="{{asset('css/plugins/iCheck/custom.css')}}" rel="stylesheet">
</head>

<body>
    <div id="wrapper">
        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav metismenu" id="side-menu">
                    <li class="nav-header">
                        <div class="dropdown profile-element">
                            <img alt="image" class="rounded-circle" src="{{ Auth::user()->empleado->foto }}" width="35%"/>
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <span class="block m-t-xs font-bold">{{ Auth::user()->empleado->nombre }} {{ Auth::user()->empleado->apellido }}</span>
                                
                            </a>
                            <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                @if ($pro->validarPermiso("perfil-empleado"))
                                    <li><a class="dropdown-item" href="{{ Route('perfilEmpleado') }}">Perfil</a></li>
                                @endif
                                @if ($pro->validarPermiso("manual"))
                                    <li><a class="dropdown-item" href="{{ Route('manual') }}">Manuales</a></li>
                                @endif
                                @if ($pro->validarPermiso("correo"))
                                    <li><a class="dropdown-item" href="{{ Route('correo') }}">Correos</a></li>
                                @endif
                                <li class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="{{ Route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Salir</a></li>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </ul>
                        </div>
                        <div class="logo-element">
                            INVEF
                        </div>
                    </li>
                    <li>
                        <a href="{{ Route('home') }}"><i class="fa fa-th-large"></i> <span class="nav-label">Inicio</span></a>
                    </li>
                    @if ($pro->validarPermiso("administrador"))
                        <li>
                            <a href="#"><i class="fa fa-id-badge"></i> <span class="nav-label">Atencion al Cliente</span><span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level collapse">
                                @if ($pro->validarPermiso("gestion-cliente"))
                                    <li><a href="{{ Route('cliente') }}">Gestión de Clientes</a></li>
                                @endif
                                @if ($pro->validarPermiso("cartera-clientes"))
                                    <li><a href="{{ Route('cartera') }}">Cartera de Clientes</a></li>
                                @endif
                            </ul>
                        </li>
                    @endif
                    @if ($pro->validarPermiso("prestamo"))
                        <li>
                            <a href="#"><i class="fa fa-handshake-o"></i> <span class="nav-label">Préstamos</span><span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level collapse">
                                @if ($pro->validarPermiso("evaluacion-home"))
                                    <li><a onclick="evaluacionHome()">Evaluación</a></li>
                                @endif
                                @if ($pro->validarPermiso("prestamo-home"))
                                    <li><a onclick="prestamoHome()">Prestamo</a></li>
                                @endif
                                @if ($pro->validarPermiso("lista-cotizacion"))
                                    <li><a href="{{ Route('listaCotizacion') }}">Lista Cotizaciones</a></li>
                                @endif
                                
                                @if ($pro->validarPermiso("macro"))
                                    <li><a href="{{ Route('macro') }}">Control de Macro BCP</a></li>
                                @endif
                                @if ($pro->validarPermiso("lista-contratos"))
                                    <li><a href="{{ Route('listContrato') }}">Contratos de Préstamos</a></li>
                                @endif
                                @if ($pro->validarPermiso("cronograma-pago"))
                                    <li><a href="{{ Route('listContrato') }}">Cronogramas de Pago</a></li>
                                @endif
                            </ul>
                        </li>
                    @endif
                    @if ($pro->validarPermiso("desembolso"))
                        <li>
                            <a href="#"><i class="fa fa-money"></i> <span class="nav-label">Desembolso</span><span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level collapse">
                                <li><a href="{{ Route('desembolso') }}">Cola Espera</a></li>
                            </ul>
                        </li>
                    @endif
                    @if ($pro->validarPermiso("almacen"))
                        <li>
                            <a href="#"><i class="fa fa-building-o"></i> <span class="nav-label">Almacén</span><span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level collapse">
                                @if ($pro->validarPermiso("gestion-almacen"))
                                    <li><a href="{{ Route('almacen') }}">Gestión de Almacenes</a></li>
                                @endif
                                @if ($pro->validarPermiso("garantia"))
                                    <li><a href="{{ Route('garantia') }}">Buscar Garantías</a></li>
                                @endif
                                @if ($pro->validarPermiso("buscar-garantia"))
                                    <li><a href="{{ Route('buscarGarantia') }}">Inventario</a></li>
                                @endif
                                
                            </ul>
                        </li>
                    @endif
                    @if ($pro->validarPermiso("cobranza"))
                        <li>
                            <a href="#"><i class="fa fa-credit-card"></i> <span class="nav-label">Cobranzas</span><span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level collapse">
                                @if ($pro->validarPermiso("pagos"))
                                    <li><a href="{{ Route('pago') }}">Pagos</a></li>
                                @endif
                                @if ($pro->validarPermiso("renovar"))
                                    <li><a href="{{ Route('renovar') }}">Renovar</a></li>
                                @endif
                                @if ($pro->validarPermiso("notificar"))
                                    <li><a href="{{ Route('notificar') }}">Notificar</a></li>
                                @endif
                                @if ($pro->validarPermiso("prestamo-atrasados"))
                                    <li><a href="{{ Route('atraso') }}">Prestamos Atrasados</a></li>
                                @endif
                                @if ($pro->validarPermiso("gestion-caja"))
                                    <li><a href="{{ Route('cajaCobranza') }}">Gestion de Caja</a></li>
                                @endif
                            </ul>
                        </li>
                    @endif
                    @if ($pro->validarPermiso("liquidacion"))
                        <li>
                            <a href="#"><i class="fa fa-ticket"></i> <span class="nav-label">Liquidación</span><span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level collapse">
                                @if ($pro->validarPermiso("productos"))
                                    <li><a href="{{ Route('producto') }}">Productos</a></li>
                                @endif
                                @if ($pro->validarPermiso("vendidos"))
                                    <li><a href="{{ Route('vendido') }}">Vendidos</a></li>
                                @endif
                            </ul>
                        </li>
                    @endif
                    @if ($pro->validarPermiso("recursos-humanos"))
                        <li>
                            <a href="#"><i class="fa fa-users"></i> <span class="nav-label">Recursos Humanos</span><span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level collapse">
                                @if ($pro->validarPermiso("gestion-empleados"))
                                    <li><a href="{{ Route('empleado') }}">Gestion de Empleados</a></li>
                                @endif
                                @if ($pro->validarPermiso("pagos-personal"))
                                    <li><a href="{{ Route('pagoPersonal') }}">Pagos de Personal</a></li>
                                @endif
                                @if ($pro->validarRol("ROOT"))
                                    <li {{ $pro->validarPermiso("Seguridad") }}><a href="{{ Route('seguridad') }}">Seguridad</a></li>
                                @endif
                                @if ($pro->validarPermiso("rendimiento-personal"))
                                    <li><a href="{{ Route('rendimientoPersonal') }}">Rendimiento de Personal</a></li>
                                @endif
                            </ul>
                        </li>
                    @endif
                    @if ($pro->validarPermiso("administracion"))
                        <li>
                            <a href="#"><i class="fa fa-laptop"></i> <span class="nav-label">Administración</span><span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level collapse">
                                <!--
                                <li {{ $pro->validarPermiso("gestion-reuniones") }}><a href="{{ Route('reuniones') }}">Gestión de Reuniones</a></li>
                                -->
                                @if ($pro->validarRol("ROOT"))
                                    <li><a href="{{ Route('sedes') }}">Gestión de Sedes</a></li>
                                @endif
                                @if ($pro->validarPermiso("gestion-prestamo"))
                                    <li><a href="{{ Route('gestionPrestamo') }}">Gestión de Prestamos</a></li>
                                @endif
                                @if ($pro->validarPermiso("gestion-capital"))
                                    <li><a href="{{ Route('gestionCapital') }}">Gestión de Capital</a></li>
                                @endif
                                @if ($pro->validarPermiso("gastos"))
                                    <li><a href="{{ Route('gastos') }}">Gastos Administrativos</a></li>
                                @endif
                                @if ($pro->validarPermiso("configuracion"))
                                    <li><a href="{{ Route('configuracion') }}">Configuraciones Generales</a></li>
                                @endif
                                @if ($pro->validarPermiso("gestion-banco"))
                                    <li><a href="{{ Route('gestionBanco') }}">Gestion de Bancos</a></li>
                                @endif
                            </ul>
                        </li>
                    @endif
                    @if ($pro->validarPermiso("finanzas"))
                        <li>
                            <a href="#"><i class="fa fa-line-chart"></i> <span class="nav-label">Finanzas</span><span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level collapse">
                                @if ($pro->validarPermiso("estadistica-prestamos"))
                                    <li><a href="{{ Route('estPrestamo') }}">Estadísticas de Préstamos</a></li>
                                @endif
                                @if ($pro->validarPermiso("analisis-resultados"))
                                    <li><a href="{{ Route('analisisResult') }}">Análisis de Resultados</a></li>
                                @endif
                                @if ($pro->validarPermiso("flujo-caja"))
                                    <li><a href="{{ Route('flujoCaja') }}">Flujo de Caja</a></li>
                                @endif
                                @if ($pro->validarPermiso("control-patrimonial"))
                                    <li><a href="{{ Route('patrimonio') }}">Control Patrimonial</a></li>
                                @endif
                            </ul>
                        </li>
                    @endif
                    @if ($pro->validarPermiso("marketing"))
                        <li>
                            <a href="#"><i class="fa fa-newspaper-o"></i> <span class="nav-label">Marketing</span><span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level collapse">
                                @if ($pro->validarPermiso("clientes-potenciales"))
                                    <li><a href="{{ Route('clienteMarketing') }}">Clientes Inactivos</a></li>
                                @endif
                                @if ($pro->validarPermiso("presupuestos"))
                                    <li><a href="{{ Route('presupuesto') }}">Presupuesto</a></li>
                                @endif
                                @if ($pro->validarPermiso("reportes"))
                                    <li><a href="{{ Route('reportes') }}">Reportes</a></li>
                                @endif
                                @if ($pro->validarPermiso("reportes-recomendacion"))
                                    <li><a href="{{ Route('reportesRecomendacion') }}">Reportes de Recomendación</a></li>
                                @endif
                                @if ($pro->validarPermiso("reportes-cliente"))
                                    <li><a href="{{ Route('reportesCliente') }}">Reportes de Clientes</a></li>
                                @endif
                            </ul>
                        </li>
                    @endif
                    @if ($pro->validarPermiso("pagina-web"))
                        <li>
                            <a href="#"><i class="fa fa-html5"></i> <span class="nav-label">Página Web</span><span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level collapse">
                                @if ($pro->validarPermiso("noticias"))
                                    <li><a href="{{ Route('noticia') }}">Pagina Inicio</a></li>
                                @endif
                                @if ($pro->validarPermiso("configuracion-nosotros"))
                                    <li><a href="{{ Route('configNosotros') }}">Nosotros</a></li>
                                @endif
                                @if ($pro->validarPermiso("configuracion-servicios"))
                                    <li><a href="{{ Route('configServicios') }}">Servicios</a></li>
                                @endif
                                @if ($pro->validarPermiso("configuracion-preguntas-frecuentes"))
                                    <li><a href="{{ Route('configPregFrecuentes') }}">Preguntas Frecuentes</a></li>
                                @endif
                                @if ($pro->validarPermiso("configuracion-productos"))
                                    <li><a href="{{ Route('configProductos') }}">Productos</a></li>
                                @endif
                                @if ($pro->validarPermiso("configuracion-areas"))
                                    <li><a href="{{ Route('configAreas') }}">Equipos de Trabajo</a></li>
                                @endif
                                @if ($pro->validarPermiso("configuracion-promociones"))
                                    <li><a href="{{ Route('configPromociones') }}">Promociones y Sorteos</a></li>
                                @endif
                            </ul>
                        </li>
                    @endif
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
                    <span class="m-r-sm text-muted welcome-message">Bienvenido a {{ $pro->obtenerSucursal()->sucursal }}.</span>
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                        <i class="fa fa-envelope"></i>  <span class="label label-warning">1</span>
                    </a>
                    <ul class="dropdown-menu dropdown-messages dropdown-menu-right">
                        <!--<li>-->
                        <!--    <div class="dropdown-messages-box">-->
                        <!--        <a class="dropdown-item float-left" href="profile.html">-->
                        <!--            <img alt="image" class="rounded-circle" src="img/a7.jpg">-->
                        <!--        </a>-->
                        <!--        <div class="media-body">-->
                        <!--            <small class="float-right">46h ago</small>-->
                        <!--            <strong>Mike Loreipsum</strong> started following <strong>Monica Smith</strong>. <br>-->
                        <!--            <small class="text-muted">3 days ago at 7:58 pm - 10.06.2014</small>-->
                        <!--        </div>-->
                        <!--    </div>-->
                        <!--</li>-->
                        <li class="dropdown-divider"></li>
                        <li>
                            <div class="text-center link-block">
                                <a href="mailbox.html" class="dropdown-item">
                                    <i class="fa fa-envelope"></i> <strong>Read All Messages</strong>
                                </a>
                            </div>
                        </li>
                    </ul>
                </li>
                <li class="dropdown" id="areaNotificaciones">
                    <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                        <i class="fa fa-bell"></i>  
                        <?php 
                            $ver = "";
                            $notificaciones = $pro->obtenerNotificaciones();
                            
                            if (empty($notificaciones)) {
                                $ver = "hidden";
                            }
                        ?>
                        <span class="label label-primary" {{ $ver }}>{{ COUNT($pro->obtenerNotificaciones()) }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-alerts">
                        <li>
                            @foreach ($notificaciones as $n)
                                <a href="mailbox.html" class="dropdown-item" {{ $ver }}>
                                    <div>
                                        <i class="fa {{ $n->icono }} fa-fw"></i> {{ $n->asunto }}
                                        <span class="float-right text-muted small">
                                            <?php
                                            $horaInicio = new DateTime(date("H:m:s"));
                                            $horaTermino = new DateTime($n->tiempo);

                                            $interval = $horaInicio->diff($horaTermino);

                                            echo $interval->format('%H:%i:%s');

                                            ?> minutos antes
                                        </span>
                                    </div>
                                </a>
                            @endforeach
                        </li>
                        <li class="dropdown-divider"></li>
                    </ul>
                </li>


                <li>
                    <a class="dropdown-item" href="{{ Route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fa fa-sign-out"></i> Salir
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </li>
                <li>
                    <a class="right-sidebar-toggle">
                        <i class="fa fa-tasks"></i>
                    </a>
                </li>
            </ul>

        </nav>
        </div>
        
        <div >@yield('contenido')</div>
        

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
        <div id="small-chat">

            <span class="badge badge-warning float-right">5</span>
            <a class="open-small-chat" href="">
                <i class="fa fa-comments"></i>

            </a>
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

                            <!--<div class="sidebar-message">-->
                            <!--    <a href="#">-->
                            <!--        <div class="float-left text-center">-->
                            <!--            <img alt="image" class="rounded-circle message-avatar" src="img/a1.jpg">-->

                            <!--            <div class="m-t-xs">-->
                            <!--                <i class="fa fa-star text-warning"></i>-->
                            <!--                <i class="fa fa-star text-warning"></i>-->
                            <!--            </div>-->
                            <!--        </div>-->
                            <!--        <div class="media-body">-->

                            <!--            There are many variations of passages of Lorem Ipsum available.-->
                            <!--            <br>-->
                            <!--            <small class="text-muted">Today 4:21 pm</small>-->
                            <!--        </div>-->
                            <!--    </a>-->
                            <!--</div>-->
                            <!--<div class="sidebar-message">-->
                            <!--    <a href="#">-->
                            <!--        <div class="float-left text-center">-->
                            <!--            <img alt="image" class="rounded-circle message-avatar" src="img/a2.jpg">-->
                            <!--        </div>-->
                            <!--        <div class="media-body">-->
                            <!--            The point of using Lorem Ipsum is that it has a more-or-less normal.-->
                            <!--            <br>-->
                            <!--            <small class="text-muted">Yesterday 2:45 pm</small>-->
                            <!--        </div>-->
                            <!--    </a>-->
                            <!--</div>-->
                            <!--<div class="sidebar-message">-->
                            <!--    <a href="#">-->
                            <!--        <div class="float-left text-center">-->
                            <!--            <img alt="image" class="rounded-circle message-avatar" src="img/a3.jpg">-->

                            <!--            <div class="m-t-xs">-->
                            <!--                <i class="fa fa-star text-warning"></i>-->
                            <!--                <i class="fa fa-star text-warning"></i>-->
                            <!--                <i class="fa fa-star text-warning"></i>-->
                            <!--            </div>-->
                            <!--        </div>-->
                            <!--        <div class="media-body">-->
                            <!--            Mevolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).-->
                            <!--            <br>-->
                            <!--            <small class="text-muted">Yesterday 1:10 pm</small>-->
                            <!--        </div>-->
                            <!--    </a>-->
                            <!--</div>-->
                            <!--<div class="sidebar-message">-->
                            <!--    <a href="#">-->
                            <!--        <div class="float-left text-center">-->
                            <!--            <img alt="image" class="rounded-circle message-avatar" src="img/a4.jpg">-->
                            <!--        </div>-->

                            <!--        <div class="media-body">-->
                            <!--            Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the-->
                            <!--            <br>-->
                            <!--            <small class="text-muted">Monday 8:37 pm</small>-->
                            <!--        </div>-->
                            <!--    </a>-->
                            <!--</div>-->
                            <!--<div class="sidebar-message">-->
                            <!--    <a href="#">-->
                            <!--        <div class="float-left text-center">-->
                            <!--            <img alt="image" class="rounded-circle message-avatar" src="img/a8.jpg">-->
                            <!--        </div>-->
                            <!--        <div class="media-body">-->

                            <!--            All the Lorem Ipsum generators on the Internet tend to repeat.-->
                            <!--            <br>-->
                            <!--            <small class="text-muted">Today 4:21 pm</small>-->
                            <!--        </div>-->
                            <!--    </a>-->
                            <!--</div>-->
                            <!--<div class="sidebar-message">-->
                            <!--    <a href="#">-->
                            <!--        <div class="float-left text-center">-->
                            <!--            <img alt="image" class="rounded-circle message-avatar" src="img/a7.jpg">-->
                            <!--        </div>-->
                            <!--        <div class="media-body">-->
                            <!--            Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.-->
                            <!--            <br>-->
                            <!--            <small class="text-muted">Yesterday 2:45 pm</small>-->
                            <!--        </div>-->
                            <!--    </a>-->
                            <!--</div>-->
                            <!--<div class="sidebar-message">-->
                            <!--    <a href="#">-->
                            <!--        <div class="float-left text-center">-->
                            <!--            <img alt="image" class="rounded-circle message-avatar" src="img/a3.jpg">-->

                            <!--            <div class="m-t-xs">-->
                            <!--                <i class="fa fa-star text-warning"></i>-->
                            <!--                <i class="fa fa-star text-warning"></i>-->
                            <!--                <i class="fa fa-star text-warning"></i>-->
                            <!--            </div>-->
                            <!--        </div>-->
                            <!--        <div class="media-body">-->
                            <!--            The standard chunk of Lorem Ipsum used since the 1500s is reproduced below.-->
                            <!--            <br>-->
                            <!--            <small class="text-muted">Yesterday 1:10 pm</small>-->
                            <!--        </div>-->
                            <!--    </a>-->
                            <!--</div>-->
                            <!--<div class="sidebar-message">-->
                            <!--    <a href="#">-->
                            <!--        <div class="float-left text-center">-->
                            <!--            <img alt="image" class="rounded-circle message-avatar" src="img/a4.jpg">-->
                            <!--        </div>-->
                            <!--        <div class="media-body">-->
                            <!--            Uncover many web sites still in their infancy. Various versions have.-->
                            <!--            <br>-->
                            <!--            <small class="text-muted">Monday 8:37 pm</small>-->
                            <!--        </div>-->
                            <!--    </a>-->
                            <!--</div>-->
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
    
    <div class="modal inmodal" id="listCotizaciones" tabindex="-1" role="dialog" aria-hidden="true">
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
    <script src="{{asset('js/plugins/iCheck/icheck.min.js')}}"></script>
    
    
    
   

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
                switch (data.estado) {
                    case 500:
                        window.location = "{{ Route('cliente') }}";
                        break;
                    case 400:
                        swal({
                            title: "Cliente",
                            text: data.message,
                            type: "error",
                            showCancelButton: true,
                            confirmButtonClass: "btn-danger",
                            closeOnConfirm: false
                        }); 
                        break;
                    case 200:
                        window.location = "/perfilCliente/" + data.message;
                        break;
                    default:
                        break;
                }
            });
        }

        function buscarClienteP(){
            var dni = $("#dniPrestamoHome").val();
            $('#dniPrestamo').modal('hide');
            $.post( "{{ Route('buscarClienteHP') }}", {dni: dni, _token:'{{csrf_token()}}'}).done(function(data) {
                console.log("DATOS", data);
                
                if (data.data.estado == 0) {
                    window.location = "{{ Route('cliente') }}";
                } else if (data.data.estado == 1) {
                    
                    swal({
                            title: "Verifique?",
                            text: "Por favor verifique si el cliente cuenta con una cotización o si ya se le asignó un casillero",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: "Si, Continuar!",
                            closeOnConfirm: false
                        }, function () {
                            window.location = "/perfilCliente/" + data.data.id;
                        });
                } else if (data.data.estado == 2) {
                    window.location = "/prestamo/" + data.data.cotizacion.cotizacion_id;
                } else if (data.data.estado == 3) {
                    swal({
                            title: "Desea Continuar?",
                            text: data.message,
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: "Si, Continuar!",
                            closeOnConfirm: false
                        }, function () {
                            window.location = "/prestamo/" + data.data.cotizacion.cotizacion_id;
                        });
                }
                
                
            });
        }

        
    </script>
</body>
</html>
