<table class="table">
    <thead>
    <tr>
        <th>Cantidad</th>
        <th>Detalles</th>
        <th>Valor</th>
        <th>Gestión</th>
    </tr>
    </thead>
    <tbody>
        @foreach ($equipo as $e)
            <tr>
                <td>{{ $e->unidad }}</td>
                <td>{{ $e->nombre }} {{ $e->marca }}</td>
                <td>{{ $e->valor }}</td>
                <td>
                    <button type="button" class="btn btn-warning" onclick="editarInventario('{{ $e->id }}', '{{ $e->unidad }}', '{{ $e->nombre }}', '{{ $e->marca }}', '{{ $e->valor }}')">
                        <i class="fa fa-pencil"></i>
                    </button>
                    <button type="button" class="btn btn-danger" onclick="bajaInventario('{{ $e->id }}', '{{ $e->unidad }}', '{{ $e->nombre }}', '{{ $e->marca }}')">
                        <i class="fa fa-trash"></i>
                    </button>
                </td>
            </tr>
        @endforeach
        <tr>
            <td></td>
            <td>TOTAL</td>
            <td>S/. {{ $totalInventario->total }} </td>
            <td></td>
        </tr>
    </tbody>
</table>