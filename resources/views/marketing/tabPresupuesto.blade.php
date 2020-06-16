<table class="table">
    <thead>
    <tr>
        <th>Mes</th>
        <th>Monto</th>
        <th>Gestión</th>
    </tr>
    </thead>
    <tbody>
        @foreach ($presMensual as $pm)
            <tr>
                <td>{{ $pm->mes }}</td>
                <td>{{ $pm->monto }} </td>
                <td>@mdo</td>
            </tr>
        @endforeach
    </tbody>
</table>