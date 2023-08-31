<table class="table table-striped">
    <thead>
    <tr>
        <th>Tipo de Prestamo</th>
        <th>Garantía</th>
        <th>Rango de Prestamo</th>
        <th>Empleado</th>
        <th>Generar</th>
    </tr>
    </thead>
    <tbody>
        @foreach ($listCotizaciones as $lc)
            <tr>
                <td>{{ $lc->tipoPrestamo }}</td>
                <td>{{ $lc->garantia }}</td>
                <td>{{ $lc->max }} - {{ $lc->min }}</td>
                <td> {{ $lc->empleado }} </td>
                <td> <a href="{{ Route('prestamo', [$lc->cotizacion_id]) }}"><i class="fa fa-plus"></i></a> </td>
            </tr>        
        @endforeach
    </tbody>
</table>