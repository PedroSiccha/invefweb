<select class="form-control m-b" name="recomendado_id" id="recomendado_id">
    <option>Seleccionar un Tipo de Recomendación...</option>
    @foreach ($recomendacion as $r)
        <option value="{{ $r->id }}">{{ $r->nombre }}</option>
    @endforeach
</select>