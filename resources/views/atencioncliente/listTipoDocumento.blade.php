<div class="row">
    <div class="col-md-8">
        <label class="col-sm-6 col-form-label">Tipo de Recomendación</label>
    </div>
    <div class="col-md-4">
        <button type="button" class="btn btn-success btn-xs" onclick="verModalTipoRecomendacion()"><i class="fa fa-plus"></i></button>
    </div>
</div>
<select class="form-control m-b" name="tipodoc_id" id="tipodoc_id">
    <option>Seleccionar Tipo de Documentación...</option>
    @foreach ($tipodoc as $td)
        <option value="{{ $td->id }}">{{ $td->nombre }}</option>
    @endforeach
</select>