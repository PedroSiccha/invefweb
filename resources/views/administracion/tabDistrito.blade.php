<table class="table table-striped">
    <thead>
    <tr>
        <th>#</th>
        <th>Distrito</th>
        <th>Provincia</th>
        <th>Departamento</th>
        <th>Gestion</th>
    </tr>
    </thead>
    <tbody>
        @foreach ($distrito as $d)
            <tr>
                <td>{{ $d->id }}</td>
                <td>{{ $d->distrito }}</td>
                <td>{{ $d->provincia }}</td>
                <td>{{ $d->departamento }}</td>
                <td>
                    <button type="button" class="btn btn-warning btn-xs" onclick="editarDistrito('{{ $d->id }}', '{{ $d->distrito }}', '{{ $d->provincia_id }}', '{{ $d->departamento_id}}')"><i class="fa fa-edit"></i></button>
                    <button type="button" class="btn btn-danger btn-xs" onclick="eliminarDistrito('{{ $d->id }}')"><i class="fa fa-trash"></i></button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>