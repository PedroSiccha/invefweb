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
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-primary btn-sm btn-block" onclick="mostrarPass('{{ $em->empleado_id }}')"><i class="fa fa-refresh"></i> Actualizar Contraseña</button>
                                    </div>
                                    <div class="col-md-6">
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

<!-- Modal Combio Contrasela -->

<div class="modal inmodal" id="mCambioPass" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Cambiar Contraseña</h4>
                <small class="font-bold">Verifique su contraseña actual.</small>
                <input type="text" class="form-control" id="codCambioPass" name="codCambioPass" hidden>
            </div>
            <div class="modal-body">
                <label class="modal-title">Contraseña Actual</label>
                <input type="password" placeholder="Ingrese Contraseña Actual" class="form-control" id="passActual" name="passActual">
                <label class="modal-title">Nueva Contraseña</label>
                <input type="password" placeholder="Ingrese la Nueva Contraseña" class="form-control" id="passNueva" name="passNueva">
                <label class="modal-title">Verificar Nueva Contraseña</label>
                <input type="password" placeholder="Repita la Nueva Contraseña" class="form-control" id="passVerificar" name="passVerificar" onkeyup="">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="cambiarPass()">Enviar</button>
            </div>
        </div>
    </div>
</div>

<!-- FIN Modal Cambio Contraseña -->

<!-- Editar Empleado -->
<div class="modal inmodal fade" id="mEditar" tabindex="-1" role="dialog"  aria-hidden="true">
    <form id="fempleado" name="fempleado" method="post" action="editarEmpleado" class="formEmpleado" enctype="multipart/form-data">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Editar el Cliente</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <input type="text" name="_token" id="_token" hidden value="{{ csrf_token() }}">
                    <input type="text" class="form-control" id="editId" name="editId" hidden>
                <div class="col-lg-6">
                    <div class="ibox-content">
                        <form>
                            <div class="form-group row">
                                <label class="col-lg-12 col-form-label">Nombre</label>
                                <div class="col-lg-12">
                                    <input type="text" placeholder="Nombres" class="form-control" id="editNombre" name="editNombre">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-12 col-form-label">Tipo Documento</label>
                                <div class="col-lg-12">
                                    <select class="form-control m-b" name="editTipoDocIde" id="editTipoDocIde">
                                        <option>Seleccionar un Tipo de Documento...</option>
                                        @foreach ($tipodocumento as $td)
                                            <option value="{{ $td->id }}">{{ $td->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-12 col-form-label">Num Referencia</label>
                                <div class="col-lg-12">
                                    <input type="text" placeholder="Número de Referencia" id="editNumReferencia" class="form-control" name="editNumReferencia">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-12 col-form-label">Fecha de Nacimiento</label>
                                <div class="col-lg-12">
                                    <input type="date" placeholder="Fecha de Nacimiento" id="editFecNac" class="form-control" name="editFecNac">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-12 col-form-label">Genero</label>
                                <div class="col-lg-12">
                                    <input type="text" placeholder="Género" id="editGenero" class="form-control" name="editGenero">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-12 col-form-label">Dirección</label>
                                <div class="col-lg-12">
                                    <input type="text" placeholder="Dirección" id="editDireccion" class="form-control" name="editDireccion">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-12 col-form-label">Distrito</label>
                                <div class="col-lg-12">
                                    <select class="form-control m-b" name="editDistrito" id="editDistrito">
                                        <option>Seleccionar un Distrito...</option>
                                        @foreach ($distrito as $di)
                                            <option value="{{ $di->id }}">{{ $di->distrito }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="ibox-content">
                            <div class="form-group row">
                                <label class="col-lg-12 col-form-label">Apellido</label>
                                <div class="col-lg-12">
                                    <input type="text" placeholder="Apellidos" id="editApellido" class="form-control" name="editApellido">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-12 col-form-label">DNI</label>
                                <div class="col-lg-12">
                                    <input type="text" placeholder="DNI" id="editDNI" class="form-control" name="editDNI">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-12 col-form-label">Telefono</label>
                                <div class="col-lg-12">
                                    <input type="text" placeholder="Teléfono" id="editTelefono" class="form-control" name="editTelefono">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-12 col-form-label">Whatsapp</label>
                                <div class="col-lg-12">
                                    <input type="text" placeholder="Whatsapp" id="editWhatsapp" class="form-control" name="editWhatsapp">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-12 col-form-label">Edad</label>
                                <div class="col-lg-12">
                                    <input type="text" placeholder="Edad" id="editEdad" class="form-control" name="editEdad">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-12 col-form-label">Foto</label>
                                <div class="col-lg-12">
                                    <input id="editFotoA" placeholder="Foto" type="file" class="form-control" name="editFotoA">
                                    <input id="editFoto" placeholder="Foto" type="text" class="form-control" hidden name="editFoto">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-12 col-form-label">Provincia</label>
                                <div class="col-lg-12">
                                    <select class="form-control m-b" name="editProvincia" id="editProvincia">
                                        <option>Seleccionar un Provincia...</option>
                                        @foreach ($provincia as $pr)
                                            <option value="{{ $pr->id }}">{{ $pr->provincia }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-12 col-form-label">Departamento</label>
                                <div class="col-lg-12">
                                    <select class="form-control m-b" name="editDepartamento" id="editDepartamento">
                                        <option>Seleccionar un Departamento...</option>
                                        @foreach ($departamento as $de)
                                            <option value="{{ $de->id }}">{{ $de->departamento }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</form>
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
        function mostrarPass(id) {
            $('#codCambioPass').val(id);
            $('#mCambioPass').modal('show');
        }

        function cambiarPass() {
            var id = $('#codCambioPass').val();
            var passActual = $('#passActual').val();
            var passNueva = $('#passNueva').val();
            
            $.post( "{{ Route('cambiarPass') }}", {id: id, passActual: passActual, passNueva: passNueva, _token:'{{csrf_token()}}'}).done(function(data) {
                if (data.resp == 1) {
                    toastr.success('Contraseña actulizada, cierre secion');
                    $('#mCambioPass').modal('hide');
                }else{
                    toastr.error('Error al actualizar contraseña');
                }

            });
        }

        function editarEmpleado(id) {
            $('#editId').val(id);
            $('#mEditar').modal('show');
            $.post( "{{ Route('verEmpleado') }}", {id: id, _token:'{{csrf_token()}}'}).done(function(data) {
                $('#editNombre').val(data.nombre);
                $('#editTipoDocIde').val(data.tipodocide_id);
                $('#editNumReferencia').val(data.referencia);
                $('#editFecNac').val(data.fecnac);
                $('#editGenero').val(data.genero);
                $('#editDireccion').val(data.direccion);
                $('#editDistrito').val(data.distrito_id);
                $('#editApellido').val(data.apellido);
                $('#editDNI').val(data.dni);
                $('#editTelefono').val(data.telefono);
                $('#editWhatsapp').val(data.whatsapp);
                $('#editEdad').val(data.edad);
                $('#editFoto').val(data.foto);
                $('#editProvincia').val(data.provincia_id);
                $('#editDepartamento').val(data.departamento_id);

            });
        }

        $(document).on("submit",".formEmpleado",function(e){
            
            e.preventDefault();
            var formu = $(this);
            var nombreform = $(this).attr("id");
            
            if ($('#genMasculino').is(":checked"))
            {
                var genero = "Masculino";
            }else{
                var genero = "Femenino";
            }
            
            if (nombreform == "fempleado") {
                var miurl = "{{ Route('editarEmpleado') }}";
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
                            title: "Empleado",
                            text: "Se actualizó exitosamente",
                            type: "success",
                            showCancelButton: true,
                            confirmButtonClass: "btn-danger",
                            confirmButtonText: "Finalizar",
                            closeOnConfirm: false
                        },
                        function(isConfirm){
                            if (isConfirm) {            
                            //window.location="{{ Route('home') }}";
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
                            toastr.error('Error al actualizar el empleado');

                        }, 1300);
                    }
            });
        });
    </script>
@endsection
