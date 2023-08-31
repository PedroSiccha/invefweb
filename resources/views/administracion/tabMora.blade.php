<table class="table table-striped">
    <thead>
    <tr>
        <th>#</th>
        <th>Moras</th>
        <th>Gestion</th>
    </tr>
    </thead>
    <tbody>
        @foreach ($mora as $mo)
            <tr>
                <td>{{ $mo->id }}</td>
                <td>{{ $mo->valor }}</td>
                <td>
                    <button type="button" class="btn btn-warning btn-xs" onclick="editarMora({{ $mo->id }}, {{ $mo->valor }})"><i class="fa fa-edit"></i></button>
                    <button type="button" class="btn btn-danger btn-xs" onclick="eliminarMora({{ $mo->id }})"><i class="fa fa-trash"></i></button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>