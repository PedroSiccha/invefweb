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

<div class="ibox ">
    <div class="ibox-title">
        <h5>CAPITAL ACTUAL</h5>
        <div class="ibox-tools">
            <a class="collapse-link" href="">
                <i class="fa fa-chevron-up"></i>
            </a>
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-wrench"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">
                <li><a href="#" class="dropdown-item">Config option 1</a>
                </li>
                <li><a href="#" class="dropdown-item">Config option 2</a>
                </li>
            </ul>
            <a class="close-link" href="">
                <i class="fa fa-times"></i>
            </a>
        </div>
    </div>
    <div class="ibox-content">
        <div>

            <div class="float-right text-right">

                <span class="bar_dashboard">
                    <!-- codigo para poner foreach con comas -->
                    <?php $count = count($listCaja); ?>
                    @foreach ($listCaja as $i => $lc)
                          {{ $lc->monto }}
                          <?php 
                          if ($i < $count - 1) {
                              echo ", ";
                          } 
                          ?>
                    @endforeach    
                </span>
                
                <br/>
            </div>
            <div class="row">
                @foreach ($capital as $c)
                <div class="col-lg-4" onclick="editarCapital('{{$c->caja_id}}')">
                    <div class="widget style1 navy-bg">
                        <div class="row vertical-align">
                            <div class="col-3">
                                {{ $c->tipocaja }}
                            </div>
                            <div class="col-9 text-right">
                                <h2 class="font-bold">{{ $c->monto }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
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
                </div>
                <div class="ibox-content" id="listPrestamo">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Fecha</th>
                            <th>Hora Apertura</th>
                            <th>Hora de Cierre</th>
                            <th>Monto de Inicio</th>
                            <th>Monto de Fin</th>
                            <th>Sede</th>
                            <th>Estado</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($listCaja as $lc)
                                <tr>
                                    <td>{{ $lc->caja_id }}</td>
                                    <td>{{ $lc->fecha }}</td>
                                    <td>{{ $lc->inicio }}</td>
                                    <td>{{ $lc->fin }}</td>
                                    <td>{{ $lc->monto }}</td>
                                    <td>{{ $lc->montofin }}</td>
                                    <td>{{ $lc->nombre }}</td>
                                    <td>{{ $lc->estado }}</td>
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
<div class="modal inmodal fade" id="eCapital" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated flipInY">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">CAJA</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    
                <div class="col-lg-12">
                    <div class="ibox-content">
                        <div class="form-group row">
                            <label class="col-lg-12 col-form-label">Capital Actual</label>
                            <div class="col-lg-12">
                                <input type="text" placeholder="Nuevo Monto de Prestamo" class="form-control" id="monto" name="monto">
                                <input type="text" placeholder="Nuevo Monto de Prestamo" class="form-control" id="caja_id" name="caja_id" hidden>
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
        function editarCapital(id) {

            $.post( "{{ Route('mostrarCaja') }}", {id: id, _token:'{{csrf_token()}}'}).done(function(data) {
                    $('#eCapital').modal('show');
                    $("#caja_id").val(data.caja_id);
                    $("#monto").val(data.monto);
                }); 
        }
        function validarPass() {
            $('#modalValidar').modal('show');
        }

        function validar() {
            var pass = $("#dniVerificacion").val();

            $.post( "{{ Route('verifGestionPrestamo') }}", {pass: pass, _token:'{{csrf_token()}}'}).done(function(data) {
                $('#modalValidar').modal('hide');
                $('#eCapital').modal('hide');
                if (data.resp == 1) {
                    var monto = $("#monto").val();
                    var caja_id = $("#caja_id").val();

                    $.post( "{{ Route('editarCapital') }}", {monto: monto, caja_id: caja_id, _token:'{{csrf_token()}}'}).done(function(data) {
                        setTimeout(function() {
                            toastr.options = {
                                closeButton: true,
                                progressBar: true,
                                showMethod: 'slideDown',
                                timeOut: 4000,
                                positionClass: 'toast-top-center'
                            };
                            toastr.success('CORRECTO', 'Capital Actualizado');
                        }, 1300);
                        $("#listCapital").empty();
                        $("#listCapital").html(data.view);
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
                
            });
            
        }
        
    </script>
@endsection
