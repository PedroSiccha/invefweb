<table class="table table-striped">
    <thead>
    <tr>
        <th>#</th>
        <th>Departamento</th>
        <th>Gestion</th>
    </tr>
    </thead>
    <tbody>
        @foreach ($departamento as $d)
            <tr>
                <td>{{ $d->id }}</td>
                <td>{{ $d->departamento }}</td>
                <td>
                    <button type="button" class="btn btn-warning btn-xs" onclick="editarDepartamento('{{ $d->id }}', '{{ $d->departamento }}')"><i class="fa fa-edit"></i></button>
                    <button type="button" class="btn btn-danger btn-xs" onclick="eliminarDepartamento('{{ $d->id }}')"><i class="fa fa-trash"></i></button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>