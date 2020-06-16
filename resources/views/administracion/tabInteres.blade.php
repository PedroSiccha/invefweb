<table class="table table-striped">
    <thead>
    <tr>
        <th>#</th>
        <th>Interes</th>
        <th>Gestion</th>
    </tr>
    </thead>
    <tbody>
        @foreach ($interes as $it)
            <tr>
                <td>{{ $it->id }}</td>
                <td>{{ $it->porcentaje }}</td>
                <td>
                    <button type="button" class="btn btn-warning btn-xs" onclick="editarInteres({{ $it->id }}, {{ $it->porcentaje }})"><i class="fa fa-edit"></i></button>
                    <button type="button" class="btn btn-danger btn-xs" onclick="elininarInteres({{ $it->id }})"><i class="fa fa-trash"></i></button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>