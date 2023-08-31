<select class="form-control m-b" name="stand_id" id="sstand_id">
    <option>Seleccionar un Stand...</option>
    @foreach ($stand as $st)
        <option value="{{ $st->id }}">{{ $st->nombre }}</option>
    @endforeach
</select>