<table class="table">
    <thead>
    <tr>
        <th>Código</th>
        <th>Stand</th>
        <th>Numero de Casillero</th>
        <th>VER MÁS</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($numStand as $ns)
        <tr>
            <td>{{ $ns->stand_id }}</td>
            <td>{{ $ns->stand }}</td>
            <td>{{ $ns->cantCasilleros }}</td>
            <td>@mdo</td>
        </tr>
    @endforeach
    </tbody>
</table>