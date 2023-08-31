@extends('layouts.app')
@section('pagina')
    Gestión de Empleados
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
                        Empleados Registrados.  
                    </p>
                    <div class="input-group">
                        <input type="text" placeholder="Buscar emplados... " class="input form-control" id="clienteBusqueda" onkeyup="buscarCliente()">
                        <span class="input-group-append">
                                <button type="button" class="btn btn btn-primary"> <i class="fa fa-search"></i> Buscar</button>
                        </span>
                    </div>
                    <div class="clients-list">
                    <span class="float-right small text-muted">0 Productos</span>
                    <ul class="nav nav-tabs">
                        <li><a class="nav-link active" data-toggle="tab" href="#tab-1"><i class="fa fa-user"></i></a></li>
                        <li><a class="nav-link" data-toggle="tab" href="#tab-2"><i class="fa fa-plus"></i></a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="tab-1" class="tab-pane active">
                            <div class="full-height-scroll">
                                <div class="table-responsive" id="tabEmpleado">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Cod. Empleado</th>
                                                <th>Nombres</th>
                                                <th>DNI</th>
                                                <th>Correo</th>
                                                <th>Administración</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($empleado as $em)
                                                <tr>
                                                    <td>{{ $em->empleado_id }}</td>
                                                    <td>{{ $em->nombre }} {{ $em->apellido }}</td>
                                                    <td>{{ $em->dni }}</td>
                                                    <td>{{ $em->email }}</td>
                                                    <td>
                                                        <?php
                                                            if ($em->estado == "ACTIVO") {
                                                                $actBaja = "";
                                                                $activar = "hidden";
                                                            }else {
                                                                $activar = "";
                                                                $actBaja = "hidden";
                                                            }     
                                                        ?>
                                                        <button {{ $actBaja }} class="btn btn-sm btn-danger float-right m-t-n-xs" onclick="bajaEmpleado('{{ $em->empleado_id }}', '{{ $em->nombre }}', '{{ $em->apellido }}')"><i class="fa fa-minus"></i></button>
                                                        <button {{ $activar }} class="btn btn-sm btn-info float-right m-t-n-xs" onclick="activarEmpleado('{{ $em->empleado_id }}', '{{ $em->nombre }}', '{{ $em->apellido }}')"><i class="fa fa-plus"></i></button>
                                                    </td>
                                                </tr>            
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div id="tab-2" class="tab-pane">
                            <div class="full-height-scroll">
                                <div class="table-responsive">
                                    <div class="ibox-content">
                                        <form id="fempleado" name="fempleado" method="post" action="guardarEmpleado" class="formEmpleado" enctype="multipart/form-data">
                                        <div class="row">
                                            <input type="text" name="_token" id="_token" hidden value="{{ csrf_token() }}">
                                            <div class="col-sm-6 b-r">
                                                <h3 class="m-t-none m-b">Nuevo Empleado</h3>
                                                <p>Datos personales del Empleado.</p>
                                                
                                                    <div class="form-group">
                                                        <label>Nombres</label> 
                                                        <input type="text" placeholder="Ingrese Nombres" class="form-control" id="nombre" name="nombre">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Apellidos</label> 
                                                        <input type="text" placeholder="Ingrese Apellidos" class="form-control" id="apellido" name="apellido">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Tipo Doc. Indentidad</label> 
                                                        <select class="form-control m-b" name="tipodocumento_id" id="tipodocumento_id">
                                                            <option>Seleccionar Tipo de Documento...</option>
                                                            @foreach ($tipodocumento as $tp)
                                                                <option value="{{ $tp->id }}">{{ $tp->nombre }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>DNI</label> 
                                                        <input type="text" placeholder="Ingrese DNI" class="form-control" id="dni" name="dni" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Foto de Perfil</label> 
                                                        <div class="custom-file">
                                                            <input id="logo" type="file" class="custom-file-input" id="foto" name="foto">
                                                            <label for="logo" class="custom-file-label">Seleccionar...</label>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Fecha de Nacimiento</label> 
                                                        <input type="date" placeholder="Ingrese Fecha de Nacimiento" class="form-control" id="fecnacimiento" name="fecnacimiento" onchange="calcularEdadInput()">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Edad</label> 
                                                        <input type="text" placeholder="Ingrese edad" class="form-control" readonly id="edad" name="edad">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Teléfono</label> 
                                                        <input type="text" placeholder="Ingrese Celular" class="form-control" id="telefono" name="telefono">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Telf. Referencia</label> 
                                                        <input type="text" placeholder="Ingrese num. referencial" class="form-control" id="telfreferencia" name="telfreferencia">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Whatsapp</label> 
                                                        <input type="text" placeholder="Ingrese Whatsapp" class="form-control" id="whatsapp" name="whatsapp">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Correo</label> 
                                                        <input type="text" placeholder="Ingrese Correo" class="form-control" id="correo" name="correo">
                                                    </div>
                                                    <div class="form-group" id="listDepartamento">
                                                        <label>Departamento</label>
                                                        <select class="form-control m-b" name="departamento_id" id="departamento_id" onchange="mostrarProvincia()">
                                                            <option>Seleccionar Departamento...</option>
                                                            @foreach ($departamento as $d)
                                                                <option value="{{ $d->id }}">{{ $d->departamento }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group" id="listProvincia">
                                                        <select class="form-control m-b" name="provincia_id" id="provincia_id">
                                                            <option>Seleccionar Provincia...</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group" id="listDistrito">
                                                        <select class="form-control m-b" name="distrito_id" id="distrito_id">
                                                            <option>Seleccionar Distrito...</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Dirección</label> 
                                                        <input type="text" placeholder="Ingrese dirección" class="form-control" id="direccion" name="direccion">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Género</label> 
                                                        <div class="i-checks">
                                                            <label> 
                                                                <input type="radio" checked="" value="Masculino" name="a" id="genMasculino"> 
                                                                <i></i> Masculino 
                                                            </label>
                                                        </div>
                                                        <div class="i-checks">
                                                            <label> 
                                                                <input type="radio" value="Femenino" name="a" id="genFemenino"> 
                                                                <i></i> Femenino 
                                                            </label>
                                                        </div>
                                                    </div>
                                            </div>

                                            <div class="col-sm-6">
                                                <h4>Datos del Empleado</h4>
                                                <div class="form-group">
                                                    <label>Turno</label> 
                                                    <select class="form-control m-b" name="turno_id" id="turno_id">
                                                        <option>Seleccionar Turno...</option>
                                                        @foreach ($turno as $t)
                                                            <option value="{{ $t->id }}">{{ $t->turno }} - {{ $t->horainicio }} Hasta {{ $t->horafin }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Inicio de Contrato</label> 
                                                    <input type="date" placeholder="Ingrese DNI" class="form-control" id="iniContrato" name="iniContrato">
                                                </div>
                                                <div class="form-group">
                                                    <label>Fin de Contrato</label> 
                                                    <input type="date" placeholder="Ingrese DNI" class="form-control" id="finContrato" name="finContrato">
                                                </div>
                                                <div class="form-group">
                                                    <label>Honorarios</label> 
                                                    <input type="text" placeholder="Ingrese un sueldo mensual" class="form-control" id="mensualidad" name="mensualidad">
                                                </div>
                                                <div class="form-group">
                                                    <label>Tipo de Usuario</label> 
                                                    <select class="form-control m-b" name="rol_id" id="rol_id">
                                                        <option>Seleccionar Tipo de Usuario...</option>
                                                        @foreach ($tipoUsuario as $tu)
                                                            <option value="{{ $tu->id }}">{{ $tu->nombre }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Asignar Sede</label> 
                                                    <select class="form-control m-b" name="sede_id" id="sede_id">
                                                        <option>Asignar a una sede...</option>
                                                        @foreach ($sede as $s)
                                                            <option value="{{ $s->id }}">{{ $s->nombre }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div>
                                                <button class="btn btn-sm btn-primary float-right m-t-n-xs" type="submit"><strong>Guardar</strong></button>
                                            </div>
                                        </div>
                                        </form>
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
</div>
@endsection

@section('script')
    <script>
        function calcularEdadInput() {
            var birthday = $("#fecnacimiento").val();
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
                var miurl = "{{ Route('guardarEmpleado') }}";
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
                            text: "Se guardó exitosamente",
                            type: "success",
                            showCancelButton: true,
                            confirmButtonClass: "btn-danger",
                            confirmButtonText: "Finalizar",
                            closeOnConfirm: false
                        },
                        function(isConfirm){
                            if (isConfirm) {            
                                //window.location="{{ Route('home') }}";
                                {
                                    closeOnConfirm: true
                                }
                                        
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
                            toastr.error('Error al registrar el Empleado');

                        }, 1300);
                    }
            });
        });

        function bajaEmpleado(id, nombre, apellido) {
            swal({
                    title: "Dar de Baja",
                    text: "Empleado:"+nombre+ " "+ apellido+"\nEstá seguro que desea dar de baja?.",
                    type: "error",
                    showCancelButton: true, 
                    confirmButtonColor: "#3366FF",
                    confirmButtonText: "Aceptar",
                    closeOnConfirm: false
                }, function () {
                    $.post( "{{ Route('baja') }}", {id: id, _token:'{{csrf_token()}}'}).done(function(data) {
                        if (data.resp == 1) {
                            swal("Correcto", "El empleado: " +nombre+" "+apellido+", se dio de baja correctamente", "success");
                            $("#tabEmpleado").empty();
                            $("#tabEmpleado").html(data.view);
                        }else{
                            swal("Error", "No se pudo dar de baja al empleado: " +nombre+ " "+ apellido+".", "error");
                        }
                        
                    });
                    
                }); 
        }

        function activarEmpleado(id, nombre, apellido) {
            swal({
                    title: "Activar Empleado",
                    text: "Empleado:"+nombre+ " "+ apellido+"\nDesea activar al empleado?.",
                    type: "success",
                    showCancelButton: true, 
                    confirmButtonColor: "#3366FF",
                    confirmButtonText: "Aceptar",
                    closeOnConfirm: false
                }, function () {
                    $.post( "{{ Route('activarEmpleado') }}", {id: id, _token:'{{csrf_token()}}'}).done(function(data) {
                        if (data.resp == 1) {
                            swal("Correcto", "El empleado: " +nombre+" "+apellido+", se activo correctamente", "success");
                            $("#tabEmpleado").empty();
                            $("#tabEmpleado").html(data.view);  
                        }else{
                            swal("Error", "No se pudo activar al empleado: " +nombre+ " "+ apellido+".", "error");
                        }
                        
                    });
                    
                }); 
        }

    </script>
@endsection