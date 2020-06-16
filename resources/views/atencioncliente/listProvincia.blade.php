    <select class="form-control m-b" name="provincia_id" id="provincia_id" onchange="mostrarDistrito()">
        <option>Provincia</option>
        @foreach ($provincia as $pr)
            <option value="{{ $pr->id }}">{{ $pr->provincia }}</option>
        @endforeach
    </select>