<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th>Cod. Empleado</th>
            <th>Nombres</th>
            <th>DNI</th>
            <th>Correo</th>
            <th>Administración</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($empleado as $em)
            <tr>
                <td>{{ $em->empleado_id }}</td>
                <td>{{ $em->nombre }} {{ $em->apellido }}</td>
                <td>{{ $em->dni }}</td>
                <td>{{ $em->email }}</td>
                <td>
                    <?php
                        if ($em->estado == "ACTIVO") {
                            $actBaja = "";
                            $activar = "hidden";
                        }else {
                            $activar = "";
                            $actBaja = "hidden";
                        }     
                    ?>
                    <button {{ $actBaja }} class="btn btn-sm btn-danger float-right m-t-n-xs" onclick="bajaEmpleado('{{ $em->empleado_id }}', '{{ $em->nombre }}', '{{ $em->apellido }}')"><i class="fa fa-minus"></i></button>
                    <button {{ $activar }} class="btn btn-sm btn-info float-right m-t-n-xs" onclick="activarEmpleado('{{ $em->empleado_id }}', '{{ $em->nombre }}', '{{ $em->apellido }}')"><i class="fa fa-plus"></i></button>
                </td>
            </tr>            
        @endforeach
    </tbody>
</table>