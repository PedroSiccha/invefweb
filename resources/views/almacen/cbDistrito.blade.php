<select class="form-control m-b" name="cbDistrito" id="cbDistrito">
    <option>Seleccione Distrito ...</option>
    @foreach ($distrito as $di)
    <option value="{{ $di->id }}">{{ $di->distrito }}</option>
    @endforeach
</select>