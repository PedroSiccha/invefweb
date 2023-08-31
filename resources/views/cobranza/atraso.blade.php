@extends('layouts.app')
@section('pagina')
    Préstamos Atrasados
@endsection
@section('contenido')
<div class="wrapper wrapper-content  animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox">
                <div class="ibox-content">
                    <span class="text-muted small float-right">Ultima Modificación: <i class="fa fa-clock-o"></i> {{date( "g:i a") }} - {{ date("d/m/Y")}}</span>
                    <h2>Clientes</h2>
                    <p>
                        Clientes con deudas vencidas.
                    </p>
                    <div class="input-group">
                        <input type="text" placeholder="Buscar cliente... " class="input form-control" id="clienteBusqueda" onkeyup="buscarCliente()">
                        <span class="input-group-append">
                                <button type="button" class="btn btn btn-primary"> <i class="fa fa-search"></i> Buscar</button>
                        </span>
                    </div>
                    <div class="clients-list">
                    <span class="float-right small text-muted">0 Clientes</span>
                    <ul class="nav nav-tabs">
                        <li><a class="nav-link active" data-toggle="tab" href="#tab-1"><i class="fa fa-user"></i></a></li>
                    </ul>   
                    <div class="tab-content" id="tabCliente">
                        <div id="tab-1" class="tab-pane active">
                            <div class="full-height-scroll">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Cod.</th>
                                                <th>Nombres</th>
                                                <th>DNI</th>
                                                <th>Garantía</th>
                                                <th>Fec Fin</th>
                                                <th>Dias</th>
                                                <th>Monto</th>
                                                <th>Interes</th>
                                                <th>Mora Actual</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($listAtrasos as $la)
                                                <tr>
                                                    <td>{{ $la->prestamo_id }}</td>
                                                    <td><a href="{{ Route('perfilCliente', [$la->cliente_id]) }}">{{ $la->nombre }} {{ $la->apellido }}</a></td>
                                                    <td>{{ $la->dni }}</td>
                                                    <td>{{ $la->garantia }}</td>
                                                    <td>{{ $la->fecfin }}</td>
                                                    <td>{{ $la->dia }}</td>
                                                    <td>{{ $la->monto }}</td>
                                                    <td>{{ $la->intpagar }}</td>
                                                    <td>{{ $la->mora*$la->dia }}</td>
                                                    <td>{{ $la->monto + $la->intpagar + $la->mora*$la->dia }}</td>
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
@endsection
