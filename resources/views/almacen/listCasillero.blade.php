<strong>Casillero: </strong>
<select class="form-control m-b" name="account" id="casillero_id">
    <option>Seleccione un casillero...</option>
    @foreach( $casillero as $ca ) 
    <option value="{{ $ca->id }}"> {{ $ca->nombre }} - {{ $ca->detalle }}</option>
    @endforeach
</select>