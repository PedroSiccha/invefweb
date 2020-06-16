@extends('layouts.app')
@section('pagina')
    Productos Vendidos
@endsection
@section('contenido')
<div class="wrapper wrapper-content  animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox">
                <div class="ibox-content">
                    <span class="text-muted small float-right">Ultima Modificación: <i class="fa fa-clock-o"></i> {{date( "g:i a") }} - {{ date("d/m/Y")}}</span>
                    <h2>Productos</h2>
                    <p>
                        Productos vendidos.
                    </p>
                    <div class="input-group">
                        <input type="text" placeholder="Buscar producto... " class="input form-control" id="clienteBusqueda" onkeyup="buscarCliente()">
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
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Cod.Producto</th>
                                                <th>Producto</th>
                                                <th>Valor Prestamo</th>
                                                <th>Interes</th>
                                                <th>Mora</th>
                                                <th>Venta</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($listVendido as $lv)
                                                <?php 
                                                   /* if ( $lv->balance > 0 ) {
                                                        $color = "navy-bg"; "bg-warning";
                                                        $imagen = "fa fa-sort-amount-asc";
                                                        
                                                    }else {
                                                        $color = "bg-warning";
                                                        $imagen = "fa fa-sort-amount-desc";
                                                    }
                                                    */
                                                ?>
                                                <tr>
                                                    <td>{{ $lv->garantia_id }}</td>
                                                    <td>{{ $lv->garantia }}</td>
                                                    <td>{{ $lv->montoPrestamo }}</td>
                                                    <td>{{ $lv->porcentajeInteres }}</td>
                                                    <td>{{ $lv->moraPrestamo }}</td>
                                                    <td>{{ $lv->pago }}</td>
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
