@extends('layouts.app')
@section('pagina')
    Gestión de Prestamos
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
                <strong>Gestión de Prestamo</strong>
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
                    <h5>Gestión de Prestamo</h5>
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
                        <input type="text" placeholder="Buscar Código de Préstamo... " class="input form-control" id="prestamoBusqueda" onkeyup="buscarPrestamo()">
                        <span class="input-group-append">
                                <button type="button" class="btn btn btn-primary"> <i class="fa fa-search"></i> Buscar</button>
                        </span>
                    </div>
                </div>
                
                <div class="ibox-content" id="listPrestamo">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Cliente</th>
                            <th>DNI</th>
                            <th>Garantia</th>
                            <th>Monto de Préstamo</th>
                            <th>Fecha de Inicio</th>
                            <th>Fecha de Fin</th>
                            <th>Administración</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($prestamo as $p)
                                <tr>
                                    <td>{{ $p->prestamo_id }}</td>
                                    <td>{{ $p->nombre }} {{ $p->apellido }}</td>
                                    <td>{{ $p->dni }}</td>
                                    <td>{{ $p->garantia }}</td>
                                    <td>{{ $p->monto }}</td>
                                    <td>{{ $p->fecinicio }}</td>
                                    <td>{{ $p->fecfin }}</td>
                                    <td>
                                        <button type="button" class="btn btn-warning btn-xs" onclick="editarPrestamo('{{ $p->prestamo_id }}')"><i class="fa fa-edit"> EDITAR</i></button>
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

<!-- Modal Editar Prestamo -->
<div class="modal inmodal fade" id="ePrestamo" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated flipInY">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Prestamo</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <input type="text" name="_token" id="_token" hidden value="{{ csrf_token() }}">
                    <input type="text" name="prestamo_id" id="prestamo_id" hidden>
                    
                <div class="col-lg-6">
                    <div class="ibox-content">
                            <div class="form-group row">
                                <label class="col-lg-12 col-form-label">Monto de Prestamo</label>
                                <div class="col-lg-12">
                                    <input type="text" placeholder="Nuevo Monto de Prestamo" class="form-control" id="monto" name="monto">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-12 col-form-label">Fecha de Inicio</label>
                                <div class="col-lg-12">
                                    <input type="date" id="fecinicio" class="form-control" name="fecinicio">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-12 col-form-label">Fecha de Fin</label>
                                <div class="col-lg-12">
                                    <input type="date" id="fecfin" class="form-control" name="fecfin">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-12 col-form-label">Total de Prestamo</label>
                                <div class="col-lg-12">
                                    <input type="text" placeholder="Nuevo Total de Prestamo" id="totalPrestamo" class="form-control" name="totalPrestamo">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-12 col-form-label">Estado de Macro BCP</label>
                                <div class="col-lg-12">
                                    <select class="form-control m-b" name="estadoMacro" id="estadoMacro">
                                        <option>Seleccionar un Estado de Macro...</option>
                                        <option value="CON MACRO">Con Macro</option>
                                        <option value="SIN MACRO">Sin Macro</option>
                                    </select>
                                </div>
                            </div>
                            
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="ibox-content">
                            <div class="form-group row">
                                <label class="col-lg-12 col-form-label">Interes a Pagar</label>
                                <div class="col-lg-12">
                                    <input type="text" placeholder="Nuevo Interes a Pagar" id="intPagar" class="form-control" name="intPagar">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-12 col-form-label">Estado de Prestamo</label>
                                <div class="col-lg-12">
                                    <select class="form-control m-b" name="estado" id="estado">
                                        <option>Seleccionar un Estado de Prestamo...</option>
                                        <option value="PAGADO">Pagado</option>
                                        <option value="VENDIDO">Vendido</option>
                                        <option value="ACTIVADO">Activado</option>
                                        <option value="LIQUIDACION">Liquidacion</option>
                                        <option value="ACTIVO DESEMBOLSADO">Activar Prestamo</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-12 col-form-label">Interes</label>
                                <div class="col-lg-12">
                                    <select class="form-control m-b" name="tipocredito_interes_id" id="tipocredito_interes_id">
                                        <option>Seleccionar un Interes...</option>
                                        @foreach ($interes as $i)
                                        <option value="{{ $i->id }}">{{ $i->porcentaje }} %</option>    
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-12 col-form-label">Mora</label>
                                <div class="col-lg-12">
                                    <select class="form-control m-b" name="mora_id" id="mora_id">
                                        <option>Seleccionar una Mora...</option>
                                        @foreach ($mora as $m)
                                        <option value="{{ $m->id }}">S/. {{ $m->mora }}</option>    
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label class="col-lg-12 col-form-label">Sede</label>
                                <div class="col-lg-12">
                                    <select class="form-control m-b" name="sede_id" id="sede_id">
                                        <option>Seleccionar una Sede...</option>
                                        @foreach ($sede as $s)
                                        <option value="{{ $s->id }}">{{ $s->nombre }}</option>    
                                        @endforeach
                                    </select>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="validarPass()">Guardar</button>
            </div>
        </div>
    </div>
</div>
<!-- Fin Modal Editar Prestamo -->

<!-- Liberar Casillero -->
<div class="modal inmodal fade" id="modalValidar" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Validar Cambios de Prestamo</h4>
                <small class="font-bold"><span id="garantiaR">Ingrese su DNI + Edad</span></small>
            </div>
            <div class="modal-body" id="divModalLiberar">

                <table class="table m-b-xs">
                    <tbody>
                    <tr>
                        <td id="cbStand">
                            <div class="col-sm-10" ><input style="font-size: large;" type="password" class="form-control text-success" id="dniVerificacion" placeholder="*******"></div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-outline btn-success dim" data-dismiss="modal" onclick="validar()"><i class="fa fa-money"></i> ACEPTAR</button>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
    <script>
        function editarPrestamo(id) {
            
            $.post( "{{ Route('mostrarPrestamo') }}", {id: id, _token:'{{csrf_token()}}'}).done(function(data) {
                    $('#ePrestamo').modal('show');

                    $("#monto").val(data.monto);
                    $("#fecinicio").val(data.fecinicio);
                    $("#fecfin").val(data.fecfin);
                    $("#totalPrestamo").val(data.total);
                    $("#estadoMacro").val(data.macro);
                    $("#intPagar").val(data.intpagar);
                    $("#estado").val(data.estado);
                    $("#tipocredito_interes_id").val(data.tipocredito_interes_id);
                    $("#mora_id").val(data.mora_id);
                    $("#sede_id").val(data.sede_id);
                    $("#prestamo_id").val(data.prestamo_id);
                }); 
        }
        function validarPass() {
            $('#modalValidar').modal('show');
        }
        function validar() {
            var pass = $("#dniVerificacion").val();

            $.post( "{{ Route('verifGestionPrestamo') }}", {pass: pass, _token:'{{csrf_token()}}'}).done(function(data) {
                $('#modalValidar').modal('hide');

                if (data.resp == 1) {
                    var monto = $("#monto").val();
                    var fecinicio = $("#fecinicio").val();
                    var fecfin = $("#fecfin").val();
                    var totalPrestamo = $("#totalPrestamo").val();
                    var estadoMacro = $("#estadoMacro").val();
                    var sede_id = $("#sede_id").val();
                    var intPagar = $("#intPagar").val();
                    var estado = $("#estado").val();
                    var tipocredito_interes_id = $("#tipocredito_interes_id").val();
                    var mora_id = $("#mora_id").val();
                    var prestamo_id = $("#prestamo_id").val();

                    $.post( "{{ Route('editarPrestamo') }}", {prestamo_id: prestamo_id, monto: monto, fecinicio: fecinicio, fecfin: fecfin, totalPrestamo: totalPrestamo, estadoMacro: estadoMacro, sede_id: sede_id, intPagar: intPagar, estado: estado, tipocredito_interes_id: tipocredito_interes_id, mora_id: mora_id, _token:'{{csrf_token()}}'}).done(function(data) {
                        setTimeout(function() {
                            toastr.options = {
                                closeButton: true,
                                progressBar: true,
                                showMethod: 'slideDown',
                                timeOut: 4000,
                                positionClass: 'toast-top-center'
                            };
                            toastr.success('CORRECTO', 'Prestamo editado correctamente');
                        }, 1300);
                    });
                }else{
                    toastr.error('Error', 'Datos de validación no coinciden');
                    /*
                    setTimeout(function() {
                            toastr.options = {
                                closeButton: true,
                                progressBar: true,
                                showMethod: 'slideDown',
                                timeOut: 4000,
                                positionClass: 'toast-top-center'
                            };
                            toastr.console.error('Error', 'Datos de validación no coinciden');
                        }, 1300);
                        */
                    
                }
                $("#listPrestamo").empty();
                $("#listPrestamo").html(data.view);
            });
            
        }

        function buscarPrestamo() {
            var dato = $("#prestamoBusqueda").val();
            
            $.post( "{{ Route('buscarPrestamoAdministracion') }}", {dato: dato, _token:'{{csrf_token()}}'}).done(function(data) {
                $("#listPrestamo").empty();
                $("#listPrestamo").html(data.view);
                
            });
            
        }
        
    </script>
@endsection
