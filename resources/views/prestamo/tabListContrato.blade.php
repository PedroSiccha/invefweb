<table class="footable table table-stripped toggle-arrow-tiny">
    <thead>
    <tr>
        <th data-toggle="true">Código de Préstamo</th>
        <th>Nombres</th>
        <th>DNI</th>
        <th>Garantia</th>
        <th>Fecha de Inicio</th>
        <th>Action</th>
    </tr> 
    </thead>
    <tbody>
    @foreach ($prestamo as $pr)
        <tr>
            <td>{{ $pr->prestamo_id }}</td>
            <td>{{ $pr->nombre }} {{ $pr->apellido }}</td>
            <td>{{ $pr->dni }}</td>
            <td>{{ $pr->garantia }}</td>
            <td>{{ $pr->fecinicio }}</td>
            <td><a type="button" class="btn btn-xs btn-primary" href="{{ route('descargarPdfContrato', ["$pr->prestamo_id"]) }}" target="_blank"><i class="fa fa-download"></i></a><button type="button" class="btn btn-xs btn-success" onclick="verCorreo('{{ $pr->prestamo_id }}', '{{ $pr->nombre }} {{ $pr->apellido }}')" ><i class="fa fa-envelope-o"></i></button><a type="button" class="btn btn-xs btn-info" href="{{ route('imprimirContrato', ["$pr->prestamo_id"]) }}" target="_blank"><i class="fa fa-print"></i></a></td>
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