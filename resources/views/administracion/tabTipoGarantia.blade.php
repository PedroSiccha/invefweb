<table class="table table-striped">
    <thead>
    <tr>
        <th>#</th>
        <th>Nombre</th>
        <th>Precio Minimo</th>
        <th>Precio Maximo</th>
        <th>Tipo Prestamo</th>
        <th>Detalle</th>
        <th>Gestion</th>
    </tr>
    </thead>
    <tbody>
        @foreach ($tipogarantia as $tg)
            <tr>
                <td>{{ $tg->id }}</td>
                <td>{{ $tg->nombre }}</td>
                <td>{{ $tg->precMax }}</td>
                <td>{{ $tg->detalle }}</td>
                <td>{{ $tg->precMin }}</td>
                <td>{{ $tg->pureza }}</td>
                <td>
                    <button type="button" class="btn btn-warning btn-xs" onclick="editarTipoGarantia({{ $tg->id }}, {{ $tg->nombre }}, {{ $tg->precMax }}, {{ $tg->detalle }}, {{ $tg->precMin }}, {{ $tg->pureza }})"><i class="fa fa-edit"></i></button>
                    <button type="button" class="btn btn-danger btn-xs" onclick="eliminarTipoGarantia({{ $tg->id }})"><i class="fa fa-trash"></i></button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>