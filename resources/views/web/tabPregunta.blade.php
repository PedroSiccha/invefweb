<table class="table">
    <thead>
    <tr>
        <th>Cod</th>
        <th>Pregunta</th>
        <th>Respuesta</th>
        <th>Area Derivada</th>
        <th>Contacto</th>
        <th>Gestion</th>
    </tr>
    </thead>
    <tbody>
        @foreach ($resumen as $r) 
        <?php
            if($r->estado == "ACTIVO"){
                $icon = "fa fa-toggle-on";
                $color = "text-info";
            }else{
                $icon = "fa fa-toggle-off";
                $color = "text-danger";
            }
        ?>   
        <tr>
            <td>{{ $r->id }}</td>
            <td>{{ $r->pregunta }}</td>
            <td>{{ $r->respuesta }}</td>
            <td> {{ $r->area }}</td>
            <td> {{ $r->contacto }}</td>
            <td onclick="cambiarEstadoServicios('{{ $r->id }}', '{{ $r->estado }}')"><i class="{{ $icon }} {{ $color }}"></i></td>
            <td>
                <button type="button" class="btn btn-warning btn-xs" onclick="editarServicio('{{ $r->id }}', '{{ $r->pregunta }}', '{{ $r->respuesta }}', '{{ $r->area }}', '{{ $r->contacto }}', '{{ $r->estado }}')"><i class="fa fa-pencil"></i></button>
                <button type="button" class="btn btn-danger btn-xs" onclick="eliminarServicio('{{ $r->id }}', '{{ $r->pregunta }}')"><i class="fa fa-trash"></i></button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>