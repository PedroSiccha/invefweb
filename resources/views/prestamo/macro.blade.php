@extends('layouts.app')
@section('pagina')
    Lista de Macro
@endsection
@section('contenido')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Generar Macro</h5>
                <a class="btn btn-warning btn-facebook btn-outline" >
                    <i class="fa fa-file-excel-o"> </i>
                </a>
                <a class="btn btn-warning btn-facebook btn-outline" >
                    <i class="fa fa-file-pdf-o"> </i>
                </a>
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
            <div class="ibox-content" id="divTipoPrestamo">
                <table class="footable table table-stripped toggle-arrow-tiny">
                    <thead>
                    <tr>
                        <th data-toggle="true">Código del Depositante</th>
                        <th>Nombre</th>
                        <th>Fecha de Inicio</th>
                        <th>Fecha de Vencimiento</th>
                        <th>Monto a Pagar</th>
                        <th>Monto Mínimo</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($sinMacro as $sm)
                        <tr>
                            <td>{{ $sm->dni }}</td>
                            <td>{{ $sm->apellido }} {{ $sm->nombre }}</td>
                            <td>{{ $sm->fecinicio }}</td>
                            <td>{{ $sm->fecfin }}</td>
                            <td>S/. {{ $sm->monto + $sm->intpagar }}</td>
                            <td>S/. {{ $sm->intpagar }}</td>
                            <td><button type="button" class="btn btn-outline btn-link"><i class="fa fa-file-excel-o"></i></button><button type="button" class="btn btn-outline btn-link"><i class="fa fa-file-pdf-o"></i></button></td>
                        </tr>
                    @endforeach    
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="5">
                            <ul class="pagination float-right"></ul>
                        </td>
                    </tr>
                    </tfoot>
                </table>

            </div>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Eliminar Macro</h5>
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
            <div class="ibox-content" id="divTipoPrestamo">
                <table class="footable table table-stripped toggle-arrow-tiny">
                    <h5>Generar Macro</h5>
                    <thead>
                    <tr>
                        <th data-toggle="true">Código del Depositante</th>
                        <th>Nombre</th>
                        <th>Fecha de Inicio</th>
                        <th>Fecha de Vencimiento</th>
                        <th>Monto a Pagar</th>
                        <th>Monto Mínimo</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($conMacro as $sm)
                            <tr>
                                <td>{{ $sm->dni }}</td>
                                <td>{{ $sm->apellido }} {{ $sm->nombre }}</td>
                                <td>{{ $sm->fecinicio }}</td>
                                <td>{{ $sm->fecfin }}</td>
                                <td>S/. {{ $sm->monto + $sm->intpagar }}</td>
                                <td>S/. {{ $sm->intpagar }}</td>
                                <td><button type="button" class="btn btn-outline btn-link"><i class="fa fa-file-excel-o"></i></button><button type="button" class="btn btn-outline btn-link"><i class="fa fa-file-pdf-o"></i></button></td>
                            </tr>
                        @endforeach    
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="5">
                            <ul class="pagination float-right"></ul>
                        </td>
                    </tr>
                    </tfoot>
                </table>

            </div>
        </div>
    </div>
</div>
@endsection
