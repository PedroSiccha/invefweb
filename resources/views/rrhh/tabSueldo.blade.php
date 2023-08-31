<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th>Cod. Empleado</th>
            <th>Empleado</th>
            <th>Turno</th>
            <th>Saldo Mensual</th>
            <th>Administración</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($empleado as $em)
            <tr>
                <td>{{ $em->empleado_id}}</td>
                <td>{{ $em->nombre}} {{ $em->apellido}}</td>
                <td>{{ $em->turno}}</td>
                <td>S/. {{ $em->monto}}</td>
                <td><button type="button" class="btn btn btn-warning" onclick="mostrarSueldo('{{ $em->empleado_id }}', '{{ $em->monto }}')"> <i class="fa fa-pencil"></i></button></td>
            </tr>            
        @endforeach
    </tbody>
</table>