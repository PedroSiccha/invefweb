<table class="table table-striped">
    <thead>
    <tr>
        <th>#</th>
        <th>Provincia</th>
        <th>Departamento</th>
        <th>Gestion</th>
    </tr>
    </thead>
    <tbody>
        @foreach ($provincia as $p)
            <tr>
                <td>{{ $p->id }}</td>
                <td>{{ $p->departamento }}</td>
                <td>{{ $p->provincia }}</td>
                <td>
                    <button type="button" class="btn btn-warning btn-xs" onclick="editarProvincia('{{ $p->id }}', '{{ $p->provincia }}', '{{ $p->departamento_id }}')"><i class="fa fa-edit"></i></button>
                    <button type="button" class="btn btn-danger btn-xs" onclick="eliminarProvincia('{{ $p->id }}')"><i class="fa fa-trash"></i></button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>