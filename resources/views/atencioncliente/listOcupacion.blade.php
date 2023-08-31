<select class="form-control m-b" name="ocupacion_id" id="ocupacion_id">
    <option>Seleccionar Una Ocupación...</option>
    @foreach ($ocupacion as $o)
        <option value="{{ $o->id }}">{{ $o->nombre }}</option>
    @endforeach
</select>