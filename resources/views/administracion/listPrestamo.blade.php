<table class="table table-striped">
    <thead>
    <tr>
        <th>#</th>
        <th>Cliente</th>
        <th>DNI</th>
        <th>Garantia</th>
        <th>Monto de Préstamo</th>
        <th>Fecha de Inicio</th>
        <th>Fecha de Fin</th>
        <th>Administración</th>
    </tr>
    </thead>
    <tbody>
        @foreach ($prestamo as $p)
            <tr>
                <td>{{ $p->prestamo_id }}</td>
                <td>{{ $p->nombre }} {{ $p->apellido }}</td>
                <td>{{ $p->dni }}</td>
                <td>{{ $p->garantia }}</td>
                <td>{{ $p->monto }}</td>
                <td>{{ $p->fecinicio }}</td>
                <td>{{ $p->fecfin }}</td>
                <td>
                    <button type="button" class="btn btn-warning btn-xs" onclick="editarPrestamo('{{ $p->prestamo_id }}')"><i class="fa fa-edit"> EDITAR</i></button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>