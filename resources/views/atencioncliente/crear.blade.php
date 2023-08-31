@extends('layouts.app')
@section('pagina')
    Registrar Clientes
@endsection                                  
@section('contenido')
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
                                    <div class="col-md-4">
                                        <button type="button" class="btn btn-success btn-xs" onclick="verModalTipoDocumento()"><i class="fa fa-plus"></i></button>
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
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-success btn-xs" onclick="verModalOcupacion()"><i class="fa fa-plus"></i></button>
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
                                <div class="col-md-4" hidden>
                                    <button type="button" class="btn btn-success btn-xs" onclick="verModalRecomendacion()"><i class="fa fa-plus"></i></button>
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
<!-- Fin Modal Recomendacion -->
@endsection
@section('script')
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
                    console.log("DATA SUCCESS", data);
                    if (data.code == 500) {
                        swal({
                            title: "Cliente",
                            text: data.message + " \n" + data.data.nombre,
                            type: "error",
                            showCancelButton: true,
                            confirmButtonClass: "btn-danger",
                            closeOnConfirm: false
                        }); 
                    } else {
                       swal({
                            title: "Cliente",
                            text: data.message,
                            type: "success",
                            showCancelButton: true,
                            confirmButtonClass: "btn-danger",
                            confirmButtonText: "Finalizar",
                            closeOnConfirm: false
                        },
                        function(isConfirm){
                            if (isConfirm) {            
                            window.location="{{ Route('home') }}";
                            {closeOnConfirm: true}
                                        
                            }
                        }); 
                    }
                },
                error: function(data) {
                    console.log("DATA ERROR", data);
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

@endsection
