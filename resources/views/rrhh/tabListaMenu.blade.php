<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th>Cod.</th>
            <th>Menu</th>
            <th>Rol</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($menuRols as $pe)
        <tr>
            <td>
                <input type="checkbox" class="i-checks flat chekboxses" name="idMenuRol[]" value="{{ $pe->menurol_id }}" id="idMenuRol">
            </td>
            <td> {{ $pe->menurol_id }} </td>
            <td> {{ $pe->menu }} </td>
            <td>{{ $pe->rol }}</td>
        </tr>        
        @endforeach
    </tbody>
</table>