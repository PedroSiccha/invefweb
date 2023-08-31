<div class="panel-group" id="accordion">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h5 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseListaRenovacionesMes">Lista de Renovaciones</a>
                <span style="float: right;">Cantidad de Renovaciones {{$cli}}</span>
            </h5>
        </div>
        <div id="collapseListaRenovacionesMes" class="panel-collapse collapse in">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Cod.</th>
                    <th>Cliente</th>
                    <th>DNI</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($clientes as $lc)
                        <tr>
                            <td>{{ $lc->id }}</td>
                            <td><a class="text-successs" href="{{ Route('perfilCliente', [$lc->id]) }}">{{ $lc->nombre }} - {{ $lc->apellido }}</a></td>
                            <td>{{ $lc->dni }}</td>
                        </tr>        
                    @endforeach
                </tbody>
            </table>
        </div>            
    </div>
</div>