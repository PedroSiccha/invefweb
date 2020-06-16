<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th>Cod.</th>
            <th>Tipo de Usuario</th>
            <th>Administración</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($roles as $ro)
        <tr>
            <td> {{ $ro->id }} </td>
            <td> {{ $ro->nombre }} </td>
            <td></td>
        </tr>            
        @endforeach
    </tbody>
</table>