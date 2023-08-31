@php
    $pro = new App\proceso();
@endphp
<span class="float-right small text-muted">{{ $cantPrestamos }} Clientes</span>
<ul class="nav nav-tabs">
    <li><a class="nav-link active" data-toggle="tab" href="#tab-1"><i class="fa fa-user"></i></a></li>
</ul>
<div class="tab-content">
    <div id="tab-1" class="tab-pane active">
        <div class="full-height-scroll">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Cod.</th>
                            <th>Nombres</th>
                            <th>DNI</th>
                            <th>Fecha de Prestamo</th>
                            <th>Entregar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($prestamo as $pr)
                            <tr>
                                <td>{{ $pr->prestamo_id }}</td>
                                <td><a href="{{ Route('perfilCliente', [$pr->cliente_id]) }}">{{ $pr->nombre }} {{ $pr->apellido }}</a></td>
                                <td>{{ $pr->dni }}</td>
                                <td>{{ $pro->cambiaf_a_espanol($pr->created_at) }}</td>
                                <td><button type="button" class="btn btn-xs btn-success" onclick="tipoDesembolso('{{ $pr->prestamo_id }}')"><i class="fa fa-paper-plane-o"></i></button></td>
                            </tr>    
                        @endforeach    
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>