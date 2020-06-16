@extends('layouts.app')
@section('pagina')
    Posibles Clientes
@endsection
@section('contenido')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Clientes Potenciales</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">Inicio</a>
            </li>
            <li class="breadcrumb-item">
                <a>Marketing</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Clientes Potenciales</strong>
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
                    <h5>Clientes Potenciales</h5>
                    <div class="ibox-tools">
                    </div>
                </div>
                <div class="ibox-content" id="tabMueble">

                    <table class="table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombres</th>
                            <th>DNI</th>
                            <th>Telefono</th>
                            <th>Whatsapp</th>
                            <th>Correo</th>
                            <th>Facebook</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($clientes as $c)
                                <tr>
                                    <td>{{ $c->id }}</td>
                                    <td><a href="{{ Route('perfilCliente', [$c->id]) }}">{{ $c->nombre }} {{ $c->apellido }}</a> </td>
                                    <td>{{ $c->dni }}</td>
                                    <td><button class="btn btn-primary dim" type="button" onclick="verTelefono('{{ $c->telefono }}', '{{ $c->referencia }}')"><i class="fa fa-mobile"></i></button></td>
                                    <td><button class="btn btn-primary dim" type="button" onclick="verWhatsapp('{{ $c->whatsapp }}')"><i class="fa fa-whatsapp"></i></button></td>
                                    <td><button class="btn btn-warning dim" type="button" onclick="verCorreo('{{ $c->correo }}')"><i class="fa fa-envelope"></i></button></td>
                                    <td><a href="{{ $c->facebook }}" target="_blank"><button class="btn btn-success  dim" type="button" ><i class="fa fa-facebook"></i></button></a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal telefono -->
<div class="modal inmodal fade" id="mTelefono" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Telefonos</h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-sm-12 form-group row">
                        <label class="col-sm-3 col-form-label">Numero de Telefono</label>
                        <div class="input-group m-b col-sm-9">
                            <input type="text" placeholder="Registrar Presupuesto" class="form-control" id="nTelefono" readonly>
                        </div>
                    </div>
                    <div class="col-sm-12 form-group row">
                        <label class="col-sm-3 col-form-label">Numero de Referencia</label>
                        <div class="input-group m-b col-sm-9">
                            <input type="text" placeholder="Registrar Presupuesto" class="form-control" id="nReferencia" readonly>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">ACEPTAR</button>
            </div>
        </div>
    </div>
</div>
<!-- FIN Modal telefono -->

<!-- Modal whatsapp -->
<div class="modal inmodal fade" id="mWhatsapp" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Whatsapp</h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-sm-12 form-group row">
                        <label class="col-sm-3 col-form-label">Numero de Whatsapp</label>
                        <div class="input-group m-b col-sm-9">
                            <input type="text" placeholder="Registrar Presupuesto" class="form-control" id="nWhatsapp" readonly>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">ACEPTAR</button>
            </div>
        </div>
    </div>
</div>
<!-- FIN Modal whatsapp -->

<!-- Modal correo -->
<div class="modal inmodal fade" id="mCorreo" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Correo</h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-sm-12 form-group row">
                        <label class="col-sm-3 col-form-label">Correo</label>
                        <div class="input-group m-b col-sm-9">
                            <input type="text" placeholder="Registrar Presupuesto" class="form-control" id="cCorreo" readonly>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">ACEPTAR</button>
            </div>
        </div>
    </div>
</div>
<!-- FIN Modal correo -->
@endsection
@section('script')
    <script>
        function verTelefono(telefono, referencia) {
            $("#nTelefono").val(telefono);
            $("#nReferencia").val(referencia);
            $('#mTelefono').modal('show');
        }

        function verWhatsapp(whatsapp) {
            $("#nWhatsapp").val(whatsapp);
            $('#mWhatsapp').modal('show');
        }

        function verCorreo(correo) {
            $("#cCorreo").val(correo);
            $('#mCorreo').modal('show');
        }
    </script>
@endsection
