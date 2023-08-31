<strong>Stand: </strong>
<select class="form-control m-b" name="stand_id" id="stand_id" onclick="buscarCasillero()" onchange="buscarCasillero()">
    <option>Seleccione un almacen...</option>
    @foreach ($stand as $st)
    <option value=" {{ $st->id }} ">{{ $st->nombre }}</option>
    @endforeach
</select>