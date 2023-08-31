<table class="footable table table-stripped toggle-arrow-tiny">
    <thead>
    <tr>
        <th data-toggle="true">Código de Almacen</th>
        <th>Nombre</th>
        <th>Dirección</th>
        <th>Cant. Stands</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($almacen as $al)
        <tr>
            <td>{{ $al->almacen_id }}</td>
            <td>{{ $al->nombre }}</td>
            <td>{{ $al->direccion }}</td>
            <td>{{ $al->cantstand }}</td>
            <td>
                <button type="button" class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="top" title="AGREGAR STAND" onclick="nuevoStand(' {{ $al->cantstand }} ', ' {{ $al->direccion }} ', '{{ $al->almacen_id }}')"><i class="fa fa-columns"></i></button>
                <button type="button" class="btn btn-primary btn-xs" data-toggle="tooltip" data-placement="top" title="AGREGAR CASILLERO" onclick="nuevoCasillero(' {{ $al->cantstand }} ', ' {{ $al->direccion }} ', '{{ $al->almacen_id }}')"><i class="fa fa-archive"></i></button>
                <button type="button" class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="top" title="ELIMINAR"><i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-warning btn-xs" data-toggle="tooltip" data-placement="top" title="EDITAR" onclick="editarAlmacen('{{ $al->almacen_id }}')"><i class="fa fa-pencil"></i></button>
            </td>
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