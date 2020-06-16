@extends('layouts.app')
@section('pagina')
    Pagos de Empleados
@endsection
@section('contenido')
<div class="wrapper wrapper-content  animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox">
                <div class="ibox-content">
                    <span class="text-muted small float-right">Ultima Modificación: <i class="fa fa-clock-o"></i> {{date( "g:i a") }} - {{ date("d/m/Y")}}</span>
                    <h2>Empleados</h2>
                    <p>
                        Pagos de empleados.
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
                        <li><a class="nav-link active" data-toggle="tab" href="#tab-1"><i class="fa fa-user"></i></a></li>
                    </ul>
                    <div class="tab-content" id="tabCliente">
                        <div id="tab-1" class="tab-pane active">
                            <div class="full-height-scroll">
                                <div class="table-responsive" id="tabSueldo">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Cod. Empleado</th>
                                                <th>Empleado</th>
                                                <th>Turno</th>
                                                <th>Saldo Mensual</th>
                                                <th>Administración</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($empleado as $em)
                                                <tr>
                                                    <td>{{ $em->empleado_id}}</td>
                                                    <td>{{ $em->nombre}} {{ $em->apellido}}</td>
                                                    <td>{{ $em->turno}}</td>
                                                    <td>S/. {{ $em->monto}}</td>
                                                    <td><button type="button" class="btn btn btn-warning" onclick="mostrarSueldo('{{ $em->empleado_id }}', '{{ $em->monto }}', '{{ $em->fecinicio }}', '{{ $em->fecfin }}')"> <i class="fa fa-pencil"></i></button></td>
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

<!-- Modal Editar Sueldo -->
<div class="modal inmodal" id="mSueldo" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated flipInY">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Editar Sueldo</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="">Ingresar Fecha de Inicio</label>
                    <input type="date" class="form-control has-feedback-left" id="eFecInicio">
                </div>
                <div class="form-group">
                    <label for="">Ingresar Fecha de Fin</label>
                    <input type="date" class="form-control has-feedback-left" id="eFecFin">
                </div>
                <div class="form-group">
                    <label for="">Ingresar Nuevo Monto</label>
                    <input type="text" class="form-control has-feedback-left" id="eIdEmpleado_id" hidden>
                    <input type="text" class="form-control has-feedback-left" id="eSueldo">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="guardarESueldo()">Guardar</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Fin Editar Sueldo -->
@endsection
@section('script')
    <script>
        function mostrarSueldo(id, sueldo, fecinicio, fecfin) {
            $('#eIdEmpleado_id').val(id);
            $('#eSueldo').val(sueldo);
            $('#eFecInicio').val(fecinicio);
            $('#eFecFin').val(fecfin);
            $('#mSueldo').modal('show');
        }

        function guardarESueldo() {
            var empleado_id = $("#eIdEmpleado_id").val();
            var sueldo = $("#eSueldo").val();
            var fecinicio = $("#eFecInicio").val();
            var fecfin = $("#eFecFin").val();

            $.post( "{{ Route('editarSueldo') }}", {empleado_id: empleado_id, sueldo: sueldo, fecinicio: fecinicio, fecfin: fecfin, _token:'{{csrf_token()}}'}).done(function(data) {
                $('#mSueldo').modal('hide');
                if (data.resp == 1) {
                    $("#tabSueldo").empty();
                    $("#tabSueldo").html(data.view);
                    toastr.success('Sueldo Actualizado Correctamente');
                }else{
                    toastr.error('Error al Actualizar el Sueldo');
                }
                
            });
        }
    </script>
@endsection
