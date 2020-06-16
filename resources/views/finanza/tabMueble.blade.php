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
                <td>@mdo</td>
            </tr>
        @endforeach
        <tr>
            <td></td>
            <td>TOTAL</td>
            <td>S/. {{ $totalInventario[0]->total }} </td>
            <td></td>
        </tr>
    </tbody>
</table>