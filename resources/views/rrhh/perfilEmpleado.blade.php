@extends('layouts.app')
@section('pagina')
    Perfil de Usuario
@endsection 
@section('contenido')
<div class="wrapper wrapper-content">
    <div class="row animated fadeInRight">
        <div class="col-md-4">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Detalles del Perfil</h5>
                </div> 
                <div>
                    @foreach ($empleado as $em)
                    <div class="ibox-content no-padding border-left-right">
                        <img alt="image" class="img-fluid" src="{{ $em->foto }}">
                    </div>
                        <div class="ibox-content profile-content">
                            <h4><strong>{{ $em->nombre }} {{ $em->apellido }}</strong></h4>
                            <p><i class="fa fa-map-marker"></i> {{ $em->direccion }} - {{ $em->distrito }} - {{ $em->provincia }} - {{ $em->departamento }}</p>
                            <h5>
                                DNI
                            </h5>
                            <p>
                                {{ $em->dni }}
                            </p>
                            <h5>
                                Edad
                            </h5>
                            <p>
                                {{ $em->edad }}
                            </p>
                            <h5>
                                Telefono
                            </h5>
                            <p>
                                    {{ $em->telefono }}
                            </p>
                            <div class="user-button">
                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="button" class="btn btn-warning btn-sm btn-block" onclick="editarEmpleado('{{ $em->empleado_id }}')"><i class="fa fa-pencil"></i> Editar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
            </div>
        </div>
            </div>
        <div class="col-md-8">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Resumen de Actividades</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
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
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">

                    <div class="tabs-container">
                        <ul class="nav nav-tabs" role="tablist">
                            <li><a class="nav-link active" data-toggle="tab" href="#cEvaluacion">Evaluaciones</a></li>
                            <li><a class="nav-link" data-toggle="tab" href="#cPrestamo">Prestamos</a></li>
                            <li><a class="nav-link" data-toggle="tab" href="#cPago">Pagos</a></li>
                        </ul>
                        <div class="tab-content">
                            <div role="tabpanel" id="cEvaluacion" class="tab-pane active">
                                <div class="panel-body">

                                    <strong>Historial de Evaluaciones</strong>
                                    @foreach ($listCotizacion as $lc)
                                        <div class="timeline-item">
                                            <div class="row">
                                                <div class="col-3 date">
                                                    <i class="fa fa-briefcase"></i>
                                                    S/. {{ $lc->max }}
                                                    <br/>
                                                    <small class="text-navy">S/. {{ $lc->min }}</small>
                                                </div>
                                                <div class="col-7 content no-top-border">
                                                    <p class="m-b-xs"><strong>{{ $lc->estado }}</strong></p>
            
                                                    <p>{{ $lc->garantia }}.</p>
            
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    
                                </div>
                            </div>
                            <div role="tabpanel" id="cPrestamo" class="tab-pane">
                                <div class="panel-body">
                                    <strong>Historial de Prestamos</strong>
                                    @foreach ($listPrestamos as $lp)
                                    <div class="timeline-item">
                                        <div class="row">
                                            <div class="col-3 date">
                                                <i class="fa fa-briefcase"></i>
                                                {{ $lp->fecinicio }}
                                                <br/>
                                                <small class="text-navy">{{ $lp->fecfin }}</small>
                                            </div>
                                            <div class="col-7 content no-top-border">
                                                <p class="m-b-xs"><strong>{{ $lp->estado }}</strong></p>
        
                                                <p>S/. {{ $lp->monto }}, monto de prestamo.</p>
        
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                </div>
                            </div>
                            <div role="tabpanel" id="cPago" class="tab-pane">
                                <div class="panel-body">
                                    <strong>Historial de Pagos</strong>
                                    @foreach ($listPago as $p)
                                    <div class="timeline-item">
                                        <div class="row">
                                            <div class="col-3 date">
                                                <i class="fa fa-briefcase"></i>
                                                S/. {{ $p->importe }}
                                                <br/>
                                                <small class="text-navy">S/. {{ $p->monto }}</small>
                                            </div>
                                            <div class="col-7 content no-top-border">
                                                <p class="m-b-xs"><strong>Codigo de Prestamo: {{ $p->prestamo_id }}</strong></p>
        
                                                <p>Se realizó el pago.</p>
        
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                </div>
                            </div>
                        </div>


                    </div>

                </div>
            </div>

        </div>
    </div>
</div>


<!-- Editar Empleado -->
<div class="modal inmodal fade" id="mEditar" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Editar el Empleado</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <input type="text" name="_token" id="_token" hidden value="{{ csrf_token() }}">
                    <input type="text" class="form-control" id="editId" name="editId" hidden>
                <div class="col-lg-12">
                    <div class="ibox-content">
                        <form>
                            <div class="form-group row">
                                <label class="col-lg-12 col-form-label">Estado</label>
                                <div class="col-lg-12">
                                    <select class="form-control m-b" name="editEstado" id="editEstado">
                                        <option>Seleccionar un Estado...</option>
                                            <option value="ACTIVADO">Contratado</option>
                                            <option value="DESACTIVADO">Dar de Baja</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-12 col-form-label">Turno</label>
                                <div class="col-lg-12">
                                    <select class="form-control m-b" name="editTurno" id="editTurno">
                                        <option>Seleccionar un Turno...</option>
                                        @foreach ($turno as $t)
                                            <option value="{{ $t->id }}">{{ $t->turno }} - De {{ $t->horainicio }} hasta {{ $t->horafin }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-12 col-form-label">Sede</label>
                                <div class="col-lg-12">
                                    <select class="form-control m-b" name="editSede" id="editSede">
                                        <option>Seleccionar una Sede...</option>
                                        @foreach ($sede as $s)
                                            <option value="{{ $s->id }}">{{ $s->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="guardarEmpleado()">Guardar</button>
            </div>
        </div>
    </div>
</div>
<!-- Fin Editar -->
@endsection
@section('script')
    <script src="{{asset('js/jquery-3.1.1.min.js')}}"></script>
    <script src="{{asset('js/popper.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.js')}}"></script>
    <script src="{{asset('js/plugins/metisMenu/jquery.metisMenu.js')}}"></script>
    <script src="{{asset('js/plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{asset('js/inspinia.js')}}"></script>
    <script src="{{asset('js/plugins/pace/pace.min.js')}}"></script>

    <!-- Peity -->
    <script src="{{asset('js/plugins/peity/jquery.peity.min.js')}}"></script>

    <!-- Peity -->
    <script src="{{asset('js/demo/peity-demo.js')}}"></script>

    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('font-awesome/css/font-awesome.css')}}" rel="stylesheet">
    <link href="{{asset('css/animate.css')}}" rel="stylesheet">
    <link href="{{asset('css/style.css')}}" rel="stylesheet">

    <script>

        function editarEmpleado(id) {
            $('#editId').val(id);
            $('#mEditar').modal('show');
            $.post( "{{ Route('verEmpleadoRendimiento') }}", {id: id, _token:'{{csrf_token()}}'}).done(function(data) {
                $('#editEstado').val(data.estado);
                $('#editTurno').val(data.turno_id);
                $('#editSede').val(data.sede_id);

            });
        }

        function guardarEmpleado() {
            var empleado_id = $('#editId').val();
            var estado = $('#editEstado').val();
            var turno_id = $('#editTurno').val();
            var sede_id = $('#editSede').val();

            $.post( "{{ Route('guardarEmpleadoRendimiento') }}", {empleado_id: empleado_id, estado: estado, turno_id: turno_id, sede_id: sede_id, _token:'{{csrf_token()}}'}).done(function(data) {
                $('#mEditar').modal('hide');
                if (data.resp == 1) {
                    toastr.success('Se actualizaron los datos correctamente');
                }else{
                    toastr.error('Error al actualizar los datos');
                }

            });
            
        }

    </script>
@endsection
