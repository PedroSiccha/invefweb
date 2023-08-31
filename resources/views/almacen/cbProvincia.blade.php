<select class="form-control m-b" name="cbProvincia" id="cbProvincia" onclick="verDistrito()" onchange="verDistrito()">
    <option>Seleccione Provincia ...</option>
    @foreach ($provincia as $pr)
    <option value="{{ $pr->id }}">{{ $pr->provincia }}</option>
    @endforeach
</select>