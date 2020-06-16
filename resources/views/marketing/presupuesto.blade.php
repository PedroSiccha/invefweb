@extends('layouts.app')
@section('pagina')
    Control de Presupuesto
@endsection
@section('contenido')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Presupuesto</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">Inicio</a>
            </li>
            <li class="breadcrumb-item">
                <a>Marketing</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Presupuesto</strong>
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
                    <h5>Presupuesto</h5>
                    <div class="ibox-tools">
                        <button type="button" class="btn btn-outline btn-success" onclick="nuevoPresupuesto()">
                            <i class="fa fa-plus"></i>
                        </button> 
                    </div>
                </div>
                <div class="ibox-content" id="tabPresupuesto">

                    <table class="table">
                        <thead>
                        <tr>
                            <th>Mes</th>
                            <th>Monto</th>
                            <th>Gestión</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($presMensual as $pm)
                                <tr>
                                    <td>{{ $pm->mes }}</td>
                                    <td>{{ $pm->monto }} </td>
                                    <td>@mdo</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal inmodal fade" id="nuevoPresupuesto" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Presupuesto</h4>
                <small class="font-bold">Registrar Nuevo Presupuesto.</small>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-sm-12 form-group row">
                        <label class="col-sm-3 col-form-label">Presupuesto</label>
                        <div class="input-group m-b col-sm-9">
                            <div class="input-group-prepend">
                                <span class="input-group-addon">S/.</span>
                            </div>
                            <input type="text" placeholder="Registrar Presupuesto" class="form-control" id="presupuesto">
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="guardarPresupuesto()">Guardar</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
    <script>
        function nuevoPresupuesto() {
            $('#nuevoPresupuesto').modal('show');
        }

        function guardarPresupuesto() {
            var monto = $("#presupuesto").val();

            $.post( "{{ Route('guardarPresupuesto') }}", {monto: monto, _token:'{{csrf_token()}}'}).done(function(data) {
                $('#nuevoPresupuesto').modal('hide');
                $("#tabPresupuesto").empty();
                $("#tabPresupuesto").html(data.presupuesto);
                toastr.success("Presupuesto Registrado Satisfactoriamente", "CORRECTO");

            });
        }
    </script>
@endsection
