<strong>Casillero: </strong>
<select class="form-control m-b" name="casillero_id" id="casillero_id">
    <option>Seleccione un casillero...</option>
    @foreach ($casillero as $ca)
    <option value=" {{ $ca->id }} ">{{ $ca->nombre }}</option>
    @endforeach
</select>