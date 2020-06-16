<table class="footable table table-stripped toggle-arrow-tiny">
    <thead>
    <tr>
        <th data-toggle="true">Código de Préstamo</th>
        <th>Codigo de Garantía</th>
        <th>Garantía</th>
        <th>Descripción</th>
        <th>Ubicación del Almacén</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($garantia as $ga)
        <?php
            if ($ga->estado == "OCUPADO") {
                $color = "bg-danger";
                $estado = "hidden";
            }elseif ($ga->estado == "LIBRE") {
                $color = "navy-bg";
                $estado = "hidden";
            }elseif ($ga->estado == "RECOGER") {
                $color = "bg-warning";
                $estado = "";
            }
        ?>
        <tr class="{{ $color }}">
            <td>{{ $ga->prestamo_id }}</td>
            <td>{{ $ga->garantia_id }}</td>
            <td>{{ $ga->garantia }}</td>
            <td>{{ $ga->detgarantia }}</td>
            <td>{{ $ga->casillero }}</td>
            <td>
                <button type="button" class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="top" title="Entregar Garantia" {{ $estado }} onclick="verRecoger('{{ $ga->prestamo_id }}', '{{ $ga->garantia_id }}', '{{ $ga->garantia }}')"><i class="fa fa-archive"></i></button>
            </td>
        </tr>    
    @endforeach    
    </tbody>
    <tfoot>
    <tr>
        <td colspan="5">
            <ul class="pagination float-right"></ul>
        </td>
    </tr>
    </tfoot>
</table>