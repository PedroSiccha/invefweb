<strong>Stand: </strong>
<select class="form-control m-b" name="account" id="stand_id" onchange="buscarCasillero()">
    <option>Seleccione un stand...</option>
    @foreach( $stand as $st ) 
        <option value="{{ $st->id }}"> {{ $st->nombre }} - {{ $st->detalle }}</option>
    @endforeach
</select>