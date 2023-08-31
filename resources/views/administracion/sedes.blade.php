@extends('layouts.app')
@section('pagina')
    Gestión de Sedes
@endsection
@section('contenido')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Gestión de Sedes</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ Route('home') }}">Inicio</a>
            </li>
            <li class="breadcrumb-item">
                <a>Administración</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Gestión de Sedes</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>

<div class="row">
    
    <div class="col-lg-12">
        <div class="wrapper wrapper-content animated fadeInRight">

            <div class="vote-item">
                <div class="row">
                    <div class="col-md-10">
                        
                    </div>
                    <div class="col-md-2 ">
                            <button class="btn btn-default" onclick="modalNuevaSede()"><i class="fa fa-plus"> </i> Generar Nueva Sede</button>
                    </div>
                </div>

                
            </div>


        </div>

        
    </div>


    <div class="col-lg-12" id="listSede">
        <div class="wrapper wrapper-content animated fadeInRight">
            @foreach ($sede as $s)
            <div class="vote-item">
                <div class="row">
                    <div class="col-md-10">
                        <div class="vote-actions">
                            <a href="#">
                                <i class="fa fa-chevron-up"> </i>
                            </a>
                            <div>{{ $s->sede_id }}</div>
                            <a href="#">
                                <i class="fa fa-chevron-down"> </i>
                            </a>
                        </div>
                        <a href="#" class="vote-title">
                            {{ $s->nombre }}
                        </a>
                        <div class="vote-info">
                            <i class="fa fa-user"></i> <a href="#">{{ $s->telefono }}</a>
                            <i class="fa fa-users"></i> <a href="#">{{ $s->telfreferencia }}</a>
                            <i class="fa fa-mony"></i> <a href="#">{{ $s->direccion }} - {{ $s->distrito }} - {{ $s->provincia }} - {{ $s->departamento }}</a>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-lg btn-warning" onclick="actualizar('{{ $s->sede_id }}', '{{ $s->nombre }}', '{{ $s->detalle }}', '{{ $s->referencia }}', '{{ $s->telefono }}', '{{ $s->telfreferencia }}', '{{ $s->direccion_id }}', '{{ $s->direccion }}','{{ $s->distrito_id }}', '{{ $s->provincia_id }}', '{{ $s->departamento_id }}')"><i class="fa fa-refresh"></i></button>
                        <button type="button" class="btn btn-lg btn-danger eliminar" onclick="baja('{{ $s->sede_id }}')"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        
    </div>
</div>

<!-- Modal Nueva Sede -->
<div class="modal inmodal fade" id="nSede" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated flipInY">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Nueva Sede</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <input type="text" name="_token" id="_token" hidden value="{{ csrf_token() }}">
                <div class="col-lg-6">
                    <div class="ibox-content">
                            <div class="form-group row">
                                <label class="col-lg-12 col-form-label">Nombre</label>
                                <div class="col-lg-12">
                                    <input type="text" placeholder="Asignar un Nombre a la Sede" class="form-control" id="nombre" name="nombre">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-12 col-form-label">Detalle</label>
                                <div class="col-lg-12">
                                    <input type="text" placeholder="Ingrese algún detalle de la sede" id="detalle" class="form-control" name="detalle">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-12 col-form-label">Teléfono</label>
                                <div class="col-lg-12">
                                    <input type="text" placeholder="Registre el telefono de la sede" id="telefono" class="form-control" name="telefono">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-12 col-form-label">Telefono de Referencia</label>
                                <div class="col-lg-12">
                                    <input type="text" placeholder="Telefono de Referencia" id="telfReferencia" class="form-control" name="telfReferencia">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-12 col-form-label">Abrir Caja Chica</label>
                                <div class="col-lg-12">
                                    <input type="text" placeholder="Abrir Caja Chica" id="montoCajaChica" class="form-control" name="montoCajaChica">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-12 col-form-label">Abrir Caja Grande</label>
                                <div class="col-lg-12">
                                    <input type="text" placeholder="Abrir Caja Grande" id="montoCajaGrande" class="form-control" name="montoCajaGrande">
                                </div>
                            </div>
                            
                            
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="ibox-content">
                            <div class="form-group row">
                                <label class="col-lg-12 col-form-label">Departamento</label>
                                <div class="col-lg-12">
                                    <select class="form-control m-b" name="Departamento" id="Departamento">
                                        <option>Seleccionar un Departamento...</option>
                                        @foreach ($departamento as $de)
                                            <option value="{{ $de->id }}">{{ $de->departamento }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-12 col-form-label">Provincia</label>
                                <div class="col-lg-12">
                                    <select class="form-control m-b" name="Provincia" id="Provincia">
                                        <option>Seleccionar un Provincia...</option>
                                        @foreach ($provincia as $pr)
                                            <option value="{{ $pr->id }}">{{ $pr->provincia }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-12 col-form-label">Distrito</label>
                                <div class="col-lg-12">
                                    <select class="form-control m-b" name="distrito_id" id="distrito_id">
                                        <option>Seleccionar un Distrito...</option>
                                        @foreach ($distrito as $di)
                                            <option value="{{ $di->id }}">{{ $di->distrito }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-12 col-form-label">Dirección</label>
                                <div class="col-lg-12">
                                    <input type="text" placeholder="Dirección" id="direccion" class="form-control" name="direccion">
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label class="col-lg-12 col-form-label">Referencia</label>
                                <div class="col-lg-12">
                                    <input type="text" placeholder="Referencia de Llegada" id="referencia" class="form-control" name="referencia">
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="guardarSede()">Guardar</button>
            </div>
        </div>
    </div>
</div>
<!-- Fin Modal Nueva Sede -->


<!-- Modal Actualizar Sede -->
<div class="modal inmodal fade" id="actuazlizarSede" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated flipInY">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Nueva Sede</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <input type="text" name="sede_id" id="sede_id" hidden>
                <div class="col-lg-6">
                    <div class="ibox-content">
                            <div class="form-group row">
                                <label class="col-lg-12 col-form-label">Nombre</label>
                                <div class="col-lg-12">
                                    <input type="text" placeholder="Asignar un Nombre a la Sede" class="form-control" id="nombreS" name="nombreS">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-12 col-form-label">Detalle</label>
                                <div class="col-lg-12">
                                    <input type="text" placeholder="Ingrese algún detalle de la sede" id="detalleS" class="form-control" name="detalleS">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-12 col-form-label">Teléfono</label>
                                <div class="col-lg-12">
                                    <input type="text" placeholder="Registre el telefono de la sede" id="telefonoA" class="form-control" name="telefonoA">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-12 col-form-label">Telefono de Referencia</label>
                                <div class="col-lg-12">
                                    <input type="text" placeholder="Telefono de Referencia" id="telfreferenciaA" class="form-control" name="telfreferenciaA">
                                </div>
                            </div>
                            
                            
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="ibox-content">
                            <div class="form-group row">
                                <label class="col-lg-12 col-form-label">Departamento</label>
                                <div class="col-lg-12">
                                    <select class="form-control m-b" name="departamento_id" id="departamento_id">
                                        <option>Seleccionar un Departamento...</option>
                                        @foreach ($departamento as $de)
                                            <option value="{{ $de->id }}">{{ $de->departamento }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-12 col-form-label">Provincia</label>
                                <div class="col-lg-12">
                                    <select class="form-control m-b" name="provincia_id" id="provincia_id">
                                        <option>Seleccionar un Provincia...</option>
                                        @foreach ($provincia as $pr)
                                            <option value="{{ $pr->id }}">{{ $pr->provincia }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-12 col-form-label">Distrito</label>
                                <div class="col-lg-12">
                                    <select class="form-control m-b" name="distritoA_id" id="distritoA_id">
                                        <option>Seleccionar un Distrito...</option>
                                        @foreach ($distrito as $di)
                                            <option value="{{ $di->id }}">{{ $di->distrito }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-12 col-form-label">Dirección</label>
                                <div class="col-lg-12">
                                    <input type="text" placeholder="Dirección" id="direccion_id" class="form-control" name="direccion_id">
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label class="col-lg-12 col-form-label">Referencia</label>
                                <div class="col-lg-12">
                                    <input type="text" placeholder="Referencia de Llegada" id="referenciaA" class="form-control" name="referenciaA">
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="guardarActualizar()">Guardar</button>
            </div>
        </div>
    </div>
</div>
<!-- Fin Modal Nueva Sede -->
@endsection
@section('script')
    <script>
        function modalNuevaSede() {
            $('#nSede').modal('show');
        }

        function guardarSede() {
            var nombre = $("#nombre").val();
            var detalle = $("#detalle").val();
            var telefono = $("#telefono").val();
            var telfReferencia = $("#telfReferencia").val();
            var direccion = $("#direccion").val();
            var distrito_id = $("#distrito_id").val();
            var referencia = $("#referencia").val();
            var cajaChica = $("#montoCajaChica").val();
            var cajaGrande = $("#montoCajaGrande").val();
            $.post( "{{ Route('guardarSede') }}", {nombre: nombre, detalle: detalle, telefono: telefono, telfReferencia: telfReferencia, direccion: direccion, distrito_id: distrito_id, referencia: referencia, cajaChica: cajaChica, cajaGrande: cajaGrande, _token:'{{csrf_token()}}'}).done(function(data) {
                $('#nSede').modal('hide');
                if (data.code) {
                    setTimeout(function() {
                        toastr.options = {
                            closeButton: true,
                            progressBar: true,
                            showMethod: 'slideDown',
                            timeOut: 4000,
                            positionClass: 'toast-top-center'
                        };
                        toastr.success("Todo Bien", data.message);
    
                    }, 1300);    
                } else {
                    setTimeout(function() {
                        toastr.options = {
                            closeButton: true,
                            progressBar: true,
                            showMethod: 'slideDown',
                            timeOut: 4000,
                            positionClass: 'toast-top-center'
                        };
                        toastr.error("Algo Salió Mal", data.message);
    
                    }, 1300);    
                }
                
                $("#listSede").empty();
                $("#listSede").html(data.view);
            });
        }

        function actualizar(sede_id, nombreS, detalleS, referencia, telefono, telfreferencia, direccion_id, direccion, distrito_id, provincia_id, departamento_id) {
            $('#actuazlizarSede').modal('show');
            $("#sede_id").val(sede_id);
            $("#nombreS").val(nombreS);
            $("#detalleS").val(detalleS);
            $("#referencia").val(referencia);
            $("#telefonoA").val(telefono);
            $("#telfreferenciaA").val(telfreferencia);
            $("#direccion_id").val(direccion);
            $("#distritoA_id").val(distrito_id);
            $("#provincia_id").val(provincia_id);
            $("#departamento_id").val(departamento_id);
        }

        function guardarActualizar() {
            var sede_id = $("#sede_id").val();
            var nombre = $("#nombreS").val();
            var detalle = $("#detalleS").val();
            var telefono = $("#telefonoA").val();
            var telfreferencia = $("#telfreferenciaA").val();
            var direccion = $("#direccion_id").val();
            var distrito_id = $("#distritoA_id").val();
            var referencia = $("#referencia").val();

            $.post( "{{ Route('actualizarSede') }}", {sede_id: sede_id, nombre: nombre, detalle: detalle, telefono: telefono, telfreferencia: telfreferencia, direccion: direccion, distrito_id: distrito_id, referencia: referencia, _token:'{{csrf_token()}}'}).done(function(data) {
                $('#actuazlizarSede').modal('hide');
                toastr.success('Sede Registrada');
                $("#listSede").empty();
                $("#listSede").html(data.view);
            });
        }
        
        function baja(id) {
            swal({
                title: "ELIMINAR",
                text: "Seguro que deséa dar de baja esta sede?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Si, dar de baja!",
                closeOnConfirm: false
            }, function () {
                $.post( "{{ Route('eliminarSede') }}", {sede_id: id, _token:'{{csrf_token()}}'}).done(function(data) {
                    swal("Correcto!", "Se dio de baja correctamente.", "success");
                    $("#listSede").empty();
                    $("#listSede").html(data.view);
                });
                
            });
        }
    </script>
@endsection
