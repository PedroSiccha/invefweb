<select class="select2_demo_1 form-control" id="tipoGarantiaCp">
    <option>Seleccione un tipo de Garantia...</option>
    @foreach ($tipoGarantia as $tg)
        <option value="{{ $tg->id }}">{{ $tg->nombre }}</option>
    @endforeach
</select>