
    <select class="form-control m-b" name="distrito_id" id="distrito_id">
        <option>Distrito</option>
        @foreach ($distrito as $di)
            <option value="{{ $di->id }}">{{ $di->distrito }}</option>
        @endforeach
    </select>