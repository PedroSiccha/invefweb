@extends('layouts.app')
@section('pagina')
    Configuraciones
@endsection
@section('contenido')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Configuraciones del Sistema</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ Route('home') }}">Inicio</a>
            </li>
            <li class="breadcrumb-item">
                <a>Administración</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Configuraciones</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-6">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Gestión de Intereses</h5>
                    <a class="btn btn-white btn-bitbucket" onclick="nuevoInteres()">
                        <i class="fa fa-plus"></i>
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
                </div>
                <div class="ibox-content" id="tabInteres">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Interes</th>
                            <th>Tipo Credito</th>
                            <th>Gestion</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($interes as $it)
                                <tr>
                                    <td>{{ $it->interes_id }}</td>
                                    <td>{{ $it->porcentaje }}</td>
                                    <td>{{ $it->tipocredito_id }}</td>
                                    <td>
                                        <button type="button" class="btn btn-warning btn-xs" onclick="editarInteres({{ $it->interes_id }}, {{ $it->porcentaje }}, {{ $it->tipocredito_id }})"><i class="fa fa-edit"></i></button>
                                        <button type="button" class="btn btn-danger btn-xs" onclick="elininarInteres({{ $it->interes_id }})"><i class="fa fa-trash"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Gestión de Moras</h5>
                    <a class="btn btn-white btn-bitbucket" onclick="nuevaMora()">
                        <i class="fa fa-plus"></i>
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
                </div>
                <div class="ibox-content" id="tabMora">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Moras</th>
                            <th>Gestion</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($mora as $mo)
                                <tr>
                                    <td>{{ $mo->id }}</td>
                                    <td>{{ $mo->mora }}</td>
                                    <td>
                                        <button type="button" class="btn btn-warning btn-xs" onclick="editarMora({{ $mo->id }}, {{ $mo->mora }})"><i class="fa fa-edit"></i></button>
                                        <button type="button" class="btn btn-danger btn-xs" onclick="eliminarMora({{ $mo->id }})"><i class="fa fa-trash"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Gestión de Artículos</h5>
                    <a class="btn btn-white btn-bitbucket" onclick="nuevaArticulo()">
                        <i class="fa fa-plus"></i>
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
                </div>
                <div class="ibox-content" id="tabTipoGarantia">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Precio Minimo</th>
                            <th>Precio Maximo</th>
                            <th>Detalle</th>
                            <th>Gestion</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($tipogarantia as $tg)
                                <tr>
                                    <td>{{ $tg->id }}</td>
                                    <td>{{ $tg->nombre }}</td>
                                    <td>{{ $tg->precMax }}</td>
                                    <td>{{ $tg->detalle }}</td>
                                    <td>{{ $tg->pureza }}</td>
                                    <td>
                                        <button type="button" class="btn btn-warning btn-xs" onclick="editarTipoGarantia('{{ $tg->id }}', '{{ $tg->nombre }}', '{{ $tg->precMax }}', '{{ $tg->detalle }}', '{{ $tg->pureza }}')"><i class="fa fa-edit"></i></button>
                                        <button type="button" class="btn btn-danger btn-xs" onclick="eliminarTipoGarantia('{{ $tg->id }}')"><i class="fa fa-trash"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Gestión de Departamentos</h5>
                    <a class="btn btn-white btn-bitbucket" onclick="nuevaDepartamento()">
                        <i class="fa fa-plus"></i>
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
                </div>
                <div class="ibox-content" id="tabDepartamento">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Departamento</th>
                            <th>Gestion</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($departamento as $d)
                                <tr>
                                    <td>{{ $d->id }}</td>
                                    <td>{{ $d->departamento }}</td>
                                    <td>
                                        <button type="button" class="btn btn-warning btn-xs" onclick="editarDepartamento('{{ $d->id }}', '{{ $d->departamento }}')"><i class="fa fa-edit"></i></button>
                                        <button type="button" class="btn btn-danger btn-xs" onclick="eliminarDepartamento('{{ $d->id }}')"><i class="fa fa-trash"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Gestión de Provincias</h5>
                    <a class="btn btn-white btn-bitbucket" onclick="nuevaProvincia()">
                        <i class="fa fa-plus"></i>
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
                </div>
                <div class="ibox-content" id="tabProvincia">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Provincia</th>
                            <th>Departamento</th>
                            <th>Gestion</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($provincia as $p)
                                <tr>
                                    <td>{{ $p->id }}</td>
                                    <td>{{ $p->departamento }}</td>
                                    <td>{{ $p->provincia }}</td>
                                    <td>
                                        <button type="button" class="btn btn-warning btn-xs" onclick="editarProvincia('{{ $p->id }}', '{{ $p->provincia }}', '{{ $p->departamento_id }}')"><i class="fa fa-edit"></i></button>
                                        <button type="button" class="btn btn-danger btn-xs" onclick="eliminarProvincia('{{ $p->id }}')"><i class="fa fa-trash"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Gestión de Distritos</h5>
                    <a class="btn btn-white btn-bitbucket" onclick="nuevaDistrito()">
                        <i class="fa fa-plus"></i>
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
                </div>
                <div class="ibox-content" id="tabDistrito">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Distrito</th>
                            <th>Provincia</th>
                            <th>Departamento</th>
                            <th>Gestion</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($distrito as $d)
                                <tr>
                                    <td>{{ $d->id }}</td>
                                    <td>{{ $d->distrito }}</td>
                                    <td>{{ $d->provincia }}</td>
                                    <td>{{ $d->departamento }}</td>
                                    <td>
                                        <button type="button" class="btn btn-warning btn-xs" onclick="editarDistrito('{{ $d->id }}', '{{ $d->distrito }}', '{{ $d->provincia_id }}', '{{ $d->departamento_id}}')"><i class="fa fa-edit"></i></button>
                                        <button type="button" class="btn btn-danger btn-xs" onclick="eliminarDistrito('{{ $d->id }}')"><i class="fa fa-trash"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="col-lg-6">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Gestión de Recomendaciones</h5>
                    <a class="btn btn-white btn-bitbucket" onclick="nuevaRecomendacion()">
                        <i class="fa fa-plus"></i>
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
                </div>
                <div class="ibox-content" id="tabRecomendacion">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Tipo de Recomendación</th>
                            <th>Detalle</th>
                            <th>Gestion</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($recomendacion as $r)
                                <tr>
                                    <td>{{ $r->id }}</td>
                                    <td>{{ $r->recomendacion }}</td>
                                    <td>{{ $r->detalle }}</td>
                                    <td>
                                        <button type="button" class="btn btn-warning btn-xs" onclick="editarRecomendacion('{{ $r->id }}', '{{ $r->recomendacion }}', '{{ $r->detalle }}')"><i class="fa fa-edit"></i></button>
                                        <button type="button" class="btn btn-danger btn-xs" onclick="eliminarRecomendacion('{{ $r->id }}')"><i class="fa fa-trash"></i></button>
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

<!-- Inicio de Modal -->
<!-- Modal Nuevo Interes -->
<div class="modal inmodal" id="nInteres" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated flipInY">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Nuevo Interes</h4>
            </div>
            <div class="modal-body">
                <br>
                <select class="form-control m-b" name="tipoPrestamo_interes" id="tipoPrestamo_interes">
                    <option>Seleccionar un Tipo de Credito...</option>
                    <option value="cp">Credito Prendario</option>
                    <option value="cj">Credito Joyas</option>
                    <option value="cu">Credito Universitario</option>
                </select>
                <br>
                <input type="text" class="form-control has-feedback-left" id="nuevoInteresTxt" placeholder="Ingrese el nuevo interes en porcentajes">
                <br>
                <input type="text" class="form-control has-feedback-left" id="nuevoDiaTxt" placeholder="Dias">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="guardarInteres()">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Editar Interes -->
<div class="modal inmodal" id="eInteres" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated flipInY">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Editar Interes</h4>
            </div>
            <div class="modal-body">
                <input type="text" class="form-control has-feedback-left" id="eIdInteresTxt" hidden>
                <br>
                <select class="form-control m-b" name="eTipoPrestamo_interes" id="eTipoPrestamo_interes">
                    <option>Seleccionar un Tipo de Credito...</option>
                    <option value="cp">Credito Prendario</option>
                    <option value="cj">Credito Joyas</option>
                    <option value="cu">Credito Universitario</option>
                </select>
                <br>
                <input type="text" class="form-control has-feedback-left" id="editarInteresTxt">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="guardarEInteres()">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Nueva Mora -->
<div class="modal inmodal" id="nMora" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated flipInY">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Nueva Mora</h4>
            </div>
            <div class="modal-body">
                <input type="text" class="form-control has-feedback-left" id="nuevaMoraTxt" placeholder="Ingrese la nueva mora">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="guardarMora()">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Editar Mora -->
<div class="modal inmodal" id="eMora" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated flipInY">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Editar Mora</h4>
            </div>
            <div class="modal-body">
                <input type="text" class="form-control has-feedback-left" id="eIdMora" hidden>
                <input type="text" class="form-control has-feedback-left" id="editarMoraTxt">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="guardarEMora()">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Nuevo Tipo de Garantia -->
<div class="modal inmodal" id="nTipoGarantia" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated flipInY">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Nuevo Artículo</h4>
            </div>
            <div class="modal-body">
                <input type="text" class="form-control has-feedback-left" id="nuevoNombre" placeholder="Ingrese el nuevo artículo">
                <br>
                <input type="text" class="form-control has-feedback-left" id="nuevoPrecMinimo" placeholder="Ingrese el precio minimo">
                <br>
                <input type="text" class="form-control has-feedback-left" id="nuevoPrecMax" placeholder="Ingrese el precio maximo">
                <br>
                <select class="form-control m-b" name="tipoPrestamo" id="tipoPrestamo">
                    <option>Seleccionar un Tipo de Credito...</option>
                    <option value="cp">Credito Prendario</option>
                    <option value="cj">Credito Joyas</option>
                    <option value="cu">Credito Universitario</option>
                </select>
                <br>
                <input type="text" class="form-control has-feedback-left" id="nuevoDetalle" placeholder="Ingrese un detalle del artículo">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="guardarTipoGarantia()">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Nuevo Departamento -->
<div class="modal inmodal" id="nDepartamento" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated flipInY">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Nuevo Departamento</h4>
            </div>
            <div class="modal-body">
                <input type="text" class="form-control has-feedback-left" id="nuevoDepartamento" placeholder="Ingrese el nuevo departamento">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="guardarDepartamento()">Guardar</button>
            </div>
        </div>
    </div>
</div>
<!-- Fin Modal Nuevo Departamento -->

<!-- Modal Nueva Provincia -->
<div class="modal inmodal" id="nProvincia" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated flipInY">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Nueva Provincia</h4>
            </div>
            <div class="modal-body">
                <select class="form-control m-b" name="departamento_id" id="departamento_id">
                    <option>Seleccionar un Departamento...</option>
                    @foreach ($departamento as $d)
                    <option value="{{ $d->id }}">{{ $d->departamento }}</option>    
                    @endforeach
                </select>
                <br>
                <input type="text" class="form-control has-feedback-left" id="nuevaProvincia" placeholder="Ingrese la nueva provincia">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="guardarProvincia()">Guardar</button>
            </div>
        </div>
    </div>
</div>
<!-- Fin Modal Nueva Provincia -->

<!-- Modal Nuevo Distrito -->
<div class="modal inmodal" id="nDistrito" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated flipInY">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Nuevo Distrito</h4>
            </div>
            <div class="modal-body">
                <select class="form-control m-b" name="provincia_id" id="provincia_id">
                    <option>Seleccionar una Provincia...</option>
                    @foreach ($provincia as $p)
                    <option value="{{ $p->id }}">{{ $p->provincia }}</option>    
                    @endforeach
                </select>
                <br>
                <input type="text" class="form-control has-feedback-left" id="nuevoDistrito" placeholder="Ingrese el nuevo distrito">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="guardarDistrito()">Guardar</button>
            </div>
        </div>
    </div>
</div>
<!-- Fin Modal Nuevo Distrito -->

<!-- Modal Editar Tipo Garantia -->
<div class="modal inmodal" id="eTipoGarantia" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated flipInY">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Editar el Tipo de Garantía</h4>
            </div>
            <div class="modal-body">
                <input type="text" class="form-control has-feedback-left" id="eIdTipoGarantia" hidden>
                <br>
                <input type="text" class="form-control has-feedback-left" id="enombreTipoGarantia" placeholder="Actualizar el tipo de garantia">
                <br>
                <input type="text" class="form-control has-feedback-left" id="eprecMaximo" placeholder="Actualizar el précio máximo">
                <br>
                <input type="text" class="form-control has-feedback-left" id="eprecMinimo" placeholder="Actualizar el precio mímino">
                <br>
                <input type="text" class="form-control has-feedback-left" id="epureza" placeholder="Actualizar caracterísitca">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="guardarETipoGarnatia()">Guardar</button>
            </div>
        </div>
    </div>
</div>
<!-- Fin Editar Tipo Garantia -->

<!-- Modal Editar Departamento -->
<div class="modal inmodal" id="eDepartamento" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated flipInY">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Actualizar Departamento</h4>
            </div>
            <div class="modal-body">
                <input type="text" class="form-control has-feedback-left" id="eIdDepartamento" hidden>
                <br>
                <input type="text" class="form-control has-feedback-left" id="enomDepartamento" placeholder="Actualizar Departamento">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="guardarEDepartamento()">Guardar</button>
            </div>
        </div>
    </div>
</div>
<!-- Fin Modal Editar Departamento -->

<!-- Modal Editar Provincia -->
<div class="modal inmodal" id="eProvincia" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated flipInY">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Actualizar Provincia</h4>
            </div>
            <div class="modal-body">
                <input type="text" class="form-control has-feedback-left" id="eIdProvincia" hidden>
                <select class="form-control m-b" name="eDepartamento_id" id="eDepartamento_id">
                    <option>Seleccionar un Departamento...</option>
                    @foreach ($departamento as $d)
                    <option value="{{ $d->id }}">{{ $d->departamento }}</option>    
                    @endforeach
                </select>
                <br>
                <input type="text" class="form-control has-feedback-left" id="enombreProvincia" placeholder="Actualizar la provincia">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="guardarEProvincia()">Guardar</button>
            </div>
        </div>
    </div>
</div>
<!-- Fin Modal Editar Provincia -->

<!-- Modal Editar Distrito -->
<div class="modal inmodal" id="edistrito" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated flipInY">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Actualizar Distrito</h4>
            </div>
            <div class="modal-body">
                <input type="text" class="form-control has-feedback-left" id="eIdDistrito" hidden>
                <select class="form-control m-b" name="eProvincia_id" id="eProvincia_id">
                    <option>Seleccionar una Provincia...</option>
                    @foreach ($provincia as $p)
                    <option value="{{ $p->id }}">{{ $p->provincia }}</option>    
                    @endforeach
                </select>
                <br>
                <input type="text" class="form-control has-feedback-left" id="enombreDistrito" placeholder="Actualizar el distrito">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="guardarEDistrito()">Guardar</button>
            </div>
        </div>
    </div>
</div>
<!-- Fin Modal Editar Distrito -->

<!-- Modal Nueva Recomendación -->
<div class="modal inmodal" id="nRecomendacion" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated flipInY">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Nueva Recomendación</h4>
            </div>
            <div class="modal-body">
                <br>
                <input type="text" class="form-control has-feedback-left" id="nuevaRecomendacion" placeholder="Ingrese nueva recomendación">
                <br>
                <input type="text" class="form-control has-feedback-left" id="nuevoDetalleRecomendacion" placeholder="Ingrese detalle">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="guardarRecomendacion()">Guardar</button>
            </div>
        </div>
    </div>
</div>
<!-- Fin Modal Nueva Recomendación -->

<!-- Modal Editar Recomendacion -->
<div class="modal inmodal" id="eRecomendacion" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated flipInY">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Actualizar Recomendacion</h4>
            </div>
            <div class="modal-body">
                <input type="text" class="form-control has-feedback-left" id="eIdRecomendacion" hidden>
                <br>
                <input type="text" class="form-control has-feedback-left" id="eNombreRecomendacion" placeholder="Actualizar recomendacion">
                <br>
                <input type="text" class="form-control has-feedback-left" id="eDetalleRecomendacion" placeholder="Actualizar recomendacion">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="guardarERecomendacion()">Guardar</button>
            </div>
        </div>
    </div>
</div>
<!-- Fin Modal Editar Recomendacion -->

@endsection
@section('script')
    <script>
        function nuevoInteres() {
            $('#nInteres').modal('show');
        }
        function nuevaMora() {
            $('#nMora').modal('show');
        }
        function nuevaArticulo() {
            $('#nTipoGarantia').modal('show');
        }
        function nuevaDepartamento() {
            $('#nDepartamento').modal('show');
        }
        function nuevaProvincia() {
            $('#nProvincia').modal('show');
        }
        function nuevaDistrito() {
            $('#nDistrito').modal('show');
        }
        function nuevaRecomendacion() {
            $('#nRecomendacion').modal('show');
        }
        function editarInteres(id, porcentaje, tipocredito_id) {
            switch (tipocredito_id) {
              case 1:
                var tc = "cp";
                break;
              case 2:
                var tc = "cj";
                break;
              case 3:
                var tc = "cu";
                break;
              default:
                var tc = "cp";
                break;
            }
            
            $("#eTipoPrestamo_interes").val(tc);
            $('#eInteres').modal('show');
            $("#eIdInteresTxt").val(id);
            $("#editarInteresTxt").val(porcentaje);
            
            
            
        }
        function editarMora(id, valor) {
            $('#eMora').modal('show');
            $("#eIdMora").val(id);
            $("#editarMoraTxt").val(valor);
        }
        function editarTipoGarantia(id, nombre, precMaximo, precMinimo, pureza) {
            $('#eTipoGarantia').modal('show');
            $("#eIdTipoGarantia").val(id);
            $("#enombreTipoGarantia").val(nombre);
            $("#eprecMaximo").val(precMaximo);
            $("#eprecMinimo").val(precMinimo);
            $("#epureza").val(pureza);
        }

        function editarDepartamento(id, departamento) {
            $('#eDepartamento').modal('show');
            $("#eIdDepartamento").val(id);
            $("#enomDepartamento").val(departamento);
        }

        function editarProvincia(id, provincia, departamento_id) {
            $('#eProvincia').modal('show');
            $("#eIdProvincia").val(id);
            $("#enombreProvincia").val(provincia);
            $("#eDepartamento_id").val(departamento_id);
        }

        function editarDistrito(id, distrito, provincia_id) {
            $('#edistrito').modal('show');
            $("#eIdDistrito").val(id);
            $("#enombreDistrito").val(distrito);
            $("#eProvincia_id").val(provincia_id);
        }
        function editarRecomendacion(id, nombre, detalle) {
            $('#eRecomendacion').modal('show');
            $("#eIdRecomendacion").val(id);
            $("#eNombreRecomendacion").val(nombre);
            $("#eDetalleRecomendacion").val(detalle);
        }
        function guardarInteres() {
            var interes = $("#nuevoInteresTxt").val();
            var dias = $("#nuevoDiaTxt").val();
            var tipoCredito = $("#tipoPrestamo_interes").val();
            $.post( "{{ Route('guardarInteres') }}", {interes: interes, dias: dias, tipoCredito: tipoCredito, _token:'{{csrf_token()}}'}).done(function(data) {
                $('#nInteres').modal('hide');
                setTimeout(function() {
                    toastr.options = {
                        closeButton: true,
                        progressBar: true,
                        showMethod: 'slideDown',
                        timeOut: 4000,
                        positionClass: 'toast-top-center'
                    };
                    toastr.success(data.inte, 'Interes Registrado');

                }, 1300);
                $("#tabInteres").empty();
                $("#tabInteres").html(data.view);
            });
        }
        function guardarMora() {
            var mora = $("#nuevaMoraTxt").val();
            $.post( "{{ Route('guardarMora') }}", {mora: mora, _token:'{{csrf_token()}}'}).done(function(data) {
                $('#nMora').modal('hide');
                setTimeout(function() {
                    toastr.options = {
                        closeButton: true,
                        progressBar: true,
                        showMethod: 'slideDown',
                        timeOut: 4000,
                        positionClass: 'toast-top-center'
                    };
                    toastr.success(data.mor, 'Mora Registrada');

                }, 1300);

                $("#tabMora").empty();
                $("#tabMora").html(data.view);
            });
        }
        function guardarTipoGarantia() {
            var nombre = $("#nuevoNombre").val();
            var precminimo = $("#nuevoPrecMinimo").val();
            var precmaximo = $("#nuevoPrecMax").val();
            var tipoGarantia = $("#tipoPrestamo").val();
            var detalle = $("#nuevoDetalle").val();
            
            $.post( "{{ Route('guardarTipoGarantia') }}", {nombre: nombre, precminimo: precminimo, precmaximo: precmaximo, tipoGarantia: tipoGarantia, detalle: detalle, _token:'{{csrf_token()}}'}).done(function(data) {
                $('#nTipoGarantia').modal('hide');
                setTimeout(function() {
                    toastr.options = {
                        closeButton: true,
                        progressBar: true,
                        showMethod: 'slideDown',
                        timeOut: 4000,
                        positionClass: 'toast-top-center'
                    };
                    toastr.success(data.inte, 'Articulo Registrado');

                }, 1300);
                $("#tabTipoGarantia").empty();
                $("#tabTipoGarantia").html(data.view);
            });
        }

        function guardarDepartamento() {
            var nombre = $("#nuevoDepartamento").val();
            
            $.post( "{{ Route('guardarDepartamento') }}", {nombre: nombre, _token:'{{csrf_token()}}'}).done(function(data) {
                $('#nDepartamento').modal('hide');
                
                if (data.resp == 1) {
                    toastr.success('Departamento Registrado Correctamente');
                    $("#tabDepartamento").empty();
                    $("#tabDepartamento").html(data.view);
                }else{
                    toastr.error('Error al Registrar el Departamento');
                }

                
            });
        }

        function guardarProvincia() {
            var nombre = $("#nuevaProvincia").val();
            var departamento_id = $("#departamento_id").val();
            
            $.post( "{{ Route('guardarProvincia') }}", {nombre: nombre, departamento_id: departamento_id, _token:'{{csrf_token()}}'}).done(function(data) {
                $('#nProvincia').modal('hide');
                if (data.resp == 1) {
                    toastr.success('Provincia Registrado Correctamente');
                    $("#tabProvincia").empty();
                    $("#tabProvincia").html(data.view);
                }else{
                    toastr.error('Error al Registrar la Provincia');
                }
            });
        }

        function guardarDistrito() {
            var nombre = $("#nuevoDistrito").val();
            var provincia_id = $("#provincia_id").val();
            
            $.post( "{{ Route('guardarDistrito') }}", {nombre: nombre, provincia_id: provincia_id, _token:'{{csrf_token()}}'}).done(function(data) {
                $('#nDistrito').modal('hide');
                if (data.resp == 1) {
                    toastr.success('Distrito Registrado Correctamente');
                    $("#tabDistrito").empty();
                    $("#tabDistrito").html(data.view);
                }else{
                    toastr.error('Error al Registrar el Distrito');
                }
            });
        }
        
        function guardarRecomendacion() {
            var nombre = $("#nuevaRecomendacion").val();
            var detalle = $("#nuevoDetalleRecomendacion").val();
            $.post( "{{ Route('guardarRecomendacion') }}", {nombre: nombre, detalle: detalle, _token:'{{csrf_token()}}'}).done(function(data) {
                $('#nRecomendacion').modal('hide');
                setTimeout(function() {
                    toastr.options = {
                        closeButton: true,
                        progressBar: true,
                        showMethod: 'slideDown',
                        timeOut: 4000,
                        positionClass: 'toast-top-center'
                    };
                    toastr.success(data.rec, 'Recomendacion registrada correctamente');

                }, 1300);

                $("#tabRecomendacion").empty();
                $("#tabRecomendacion").html(data.view);
            });
        }

        function guardarEInteres() {
            var id = $("#eIdInteresTxt").val();
            var interes = $("#editarInteresTxt").val();
            var tipoGarantia = $("#eTipoPrestamo_interes").val();
            $.post( "{{ Route('editarInteres') }}", {id: id, interes: interes, tipoGarantia: tipoGarantia, _token:'{{csrf_token()}}'}).done(function(data) {
                $('#eInteres').modal('hide');
                setTimeout(function() {
                    toastr.options = {
                        closeButton: true,
                        progressBar: true,
                        showMethod: 'slideDown',
                        timeOut: 4000,
                        positionClass: 'toast-top-center'
                    };
                    toastr.warning(data.inte, 'Interes Editado');

                }, 1300);
                $("#tabInteres").empty();
                $("#tabInteres").html(data.view);
            });
        }
        function guardarEMora() {
            var id = $("#eIdMora").val();
            var mora = $("#editarMoraTxt").val();
            $.post( "{{ Route('editarMora') }}", {id: id, mora: mora, _token:'{{csrf_token()}}'}).done(function(data) {
                $('#eMora').modal('hide');
                setTimeout(function() {
                    toastr.options = {
                        closeButton: true,
                        progressBar: true,
                        showMethod: 'slideDown',
                        timeOut: 4000,
                        positionClass: 'toast-top-center'
                    };
                    toastr.warning(data.mor, 'Mora Editada');

                }, 1300);
                $("#tabMora").empty();
                $("#tabMora").html(data.view);
            });
        }

        function guardarETipoGarnatia() {
            
            var tipogarantia_id = $("#eIdTipoGarantia").val();
            var nombre = $("#enombreTipoGarantia").val();
            var precmaximo = $("#eprecMaximo").val();
            var precminimo = $("#eprecMinimo").val();
            var pureza = $("#epureza").val();

            $.post( "{{ Route('editarTipoGarantia') }}", {tipogarantia_id: tipogarantia_id, nombre: nombre, precmaximo: precmaximo, precminimo: precminimo, pureza: pureza, _token:'{{csrf_token()}}'}).done(function(data) {
                $('#eTipoGarantia').modal('hide');
                toastr.warning('Tipo de Garantia Actualizado');
                $("#tabTipoGarantia").empty();
                $("#tabTipoGarantia").html(data.view);
            });
        }

        function guardarEDepartamento() {
            var departamento_id = $("#eIdDepartamento").val();
            var nombre = $("#enomDepartamento").val();

            $.post( "{{ Route('editarDepartamento') }}", {departamento_id: departamento_id, nombre: nombre, _token:'{{csrf_token()}}'}).done(function(data) {
                $('#eDepartamento').modal('hide');
                toastr.warning('Departamento Editado');
                $("#tabDepartamento").empty();
                $("#tabDepartamento").html(data.view);
            });
            
        }

        function guardarEProvincia() {
            var provincia_id = $("#eIdProvincia").val();
            var nombre = $("#enombreProvincia").val();
            var departamento_id = $("#eDepartamento_id").val();

            $.post( "{{ Route('editarProvincia') }}", {provincia_id: provincia_id, nombre: nombre, departamento_id: departamento_id, _token:'{{csrf_token()}}'}).done(function(data) {
                $('#eProvincia').modal('hide');
                toastr.warning('Provincia Editado');
                $("#tabProvincia").empty();
                $("#tabProvincia").html(data.view);
            });
            
        }

        function guardarEDistrito() {
            var distrito_id = $("#eIdDistrito").val();
            var nombre = $("#enombreDistrito").val();
            var provincia_id = $("#eProvincia_id").val();

            $.post( "{{ Route('editarDistrito') }}", {distrito_id: distrito_id, nombre: nombre, provincia_id: provincia_id, _token:'{{csrf_token()}}'}).done(function(data) {
                $('#edistrito').modal('hide');
                toastr.warning('Distrito Editado');
                $("#tabDistrito").empty();
                $("#tabDistrito").html(data.view);
            });
            
        }
        
        function guardarERecomendacion() {
            var id = $("#eIdRecomendacion").val();
            var nombre = $("#eNombreRecomendacion").val();
            var detalle = $("#eDetalleRecomendacion").val();
            $.post( "{{ Route('editarRecomendacion') }}", {id: id, nombre: nombre, detalle: detalle, _token:'{{csrf_token()}}'}).done(function(data) {
                $('#eRecomendacion').modal('hide');
                setTimeout(function() {
                    toastr.options = {
                        closeButton: true,
                        progressBar: true,
                        showMethod: 'slideDown',
                        timeOut: 4000,
                        positionClass: 'toast-top-center'
                    };
                    toastr.warning(data.rec, 'Recomendacion editada');

                }, 1300);
                $("#tabRecomendacion").empty();
                $("#tabRecomendacion").html(data.view);
            });
        }

        function elininarInteres(id) {

            swal({
                title: "Eliminar",
                text: "Seguro que desea elimiar el interes: "+id,
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Si, Eliminar!",
                closeOnConfirm: false
            }, function () {
                $.post( "{{ Route('eliminarInteres') }}", {id: id, _token:'{{csrf_token()}}'}).done(function(data) {
                    swal("Eliminado!", "Se eliminó correctamente.", "success");
                    $("#tabInteres").empty();
                    $("#tabInteres").html(data.view);
                }); 
            });
        }
        function eliminarTipoGarantia(id) {

            swal({
                title: "Eliminar",
                text: "Seguro que desea elimiar el tipo de garantia: "+id,
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Si, Eliminar!",
                closeOnConfirm: false
            }, function () {
                $.post( "{{ Route('eliminarTipoGarantia') }}", {id: id, _token:'{{csrf_token()}}'}).done(function(data) {
                    swal("Eliminado!", "Se eliminó correctamente.", "success");
                    $("#tabTipoGarantia").empty();
                    $("#tabTipoGarantia").html(data.view);
                }); 
            });
        }

        function eliminarDepartamento(id) {

            swal({
                title: "Eliminar",
                text: "Seguro que desea elimiar el departamento: "+id,
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Si, Eliminar!",
                closeOnConfirm: false
            }, function () {
                $.post( "{{ Route('eliminarDepartamento') }}", {id: id, _token:'{{csrf_token()}}'}).done(function(data) {
                    swal("Eliminado!", "Se eliminó correctamente.", "success");
                    $("#tabDepartamento").empty();
                    $("#tabDepartamento").html(data.view);
                }); 
            });
        }

        function eliminarProvincia(id) {

        swal({
                title: "Eliminar",
                text: "Seguro que desea elimiar el provincia: "+id,
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Si, Eliminar!",
                closeOnConfirm: false
            }, function () {
                $.post( "{{ Route('eliminarProvincia') }}", {id: id, _token:'{{csrf_token()}}'}).done(function(data) {
                    swal("Eliminado!", "Se eliminó correctamente.", "success");
                    $("#tabProvincia").empty();
                    $("#tabProvincia").html(data.view);
                }); 
            });
        }

        function eliminarDistrito(id) {

            swal({
                title: "Eliminar",
                text: "Seguro que desea elimiar el distrito: "+id,
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Si, Eliminar!",
                closeOnConfirm: false
            }, function () {
                $.post( "{{ Route('eliminarDistrito') }}", {id: id, _token:'{{csrf_token()}}'}).done(function(data) {
                    swal("Eliminado!", "Se eliminó correctamente.", "success");
                    $("#tabDistrito").empty();
                    $("#tabDistrito").html(data.view);
                }); 
            });
        }

        function eliminarMora(id) {

            swal({
                title: "Eliminar",
                text: "Seguro que desea elimiar la mora: "+id,
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Si, Eliminar!",
                closeOnConfirm: false
            }, function () {
                $.post( "{{ Route('eliminarMora') }}", {id: id, _token:'{{csrf_token()}}'}).done(function(data) {
                    swal("Eliminado!", "Se eliminó correctamente.", "success");
                    $("#tabMora").empty();
                    $("#tabMora").html(data.view);
                }); 
            });
        }
        
        function eliminarRecomendacion(id) {

            swal({
                title: "Eliminar",
                text: "Seguro que desea elimiar la recomendacion: "+id,
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Si, Eliminar!",
                closeOnConfirm: false
            }, function () {
                $.post( "{{ Route('eliminarRecomendacion') }}", {id: id, _token:'{{csrf_token()}}'}).done(function(data) {
                    swal("Eliminado!", "La recomendacion se eliminó correctamente.", "success");
                    $("#tabRecomendacion").empty();
                    $("#tabRecomendacion").html(data.view);
                }); 
            });
        }

    </script>
@endsection
