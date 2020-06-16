<input type="text" name="caja_id" id="caja_id" value="{{ $capital[0]->caja_id }}" hidden>
        S/.
        @foreach ($capital as $c)
            {{ $c->monto }}
        @endforeach