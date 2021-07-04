<table class="table">
    <thead>
    <tr>
        <th>Cod</th>
        <th>Titulo</th>
        <th>Descripción</th>
        <th>Icono</th>
        <th>Estado</th>
        <th>Gestion</th>
    </tr>
    </thead>
    <tbody>
        @foreach ($caracteristicas as $c)    
        <?php
            if($c->estado == "ACTIVO"){
                $icon = "fa fa-toggle-on";
                $color = "text-info";
            }else{
                $icon = "fa fa-toggle-off";
                $color = "text-danger";
            }
        ?>  
        <tr>
            <td>{{ $c->id }}</td>
            <td>{{ $c->titulo }}</td>
            <td>{{ $c->descripcion }}</td>
            <td><i class="{{ $c->icono }}"></i></td>
            <td onclick="cambiarEstadoCaracteristica('{{ $c->id }}', '{{ $c->estado }}')"><i class="{{ $icon }} {{ $color }}"></i></td>
            <td>
                <button type="button" class="btn btn-warning btn-xs" onclick="editarCaracteristica('{{ $c->id }}', '{{ $c->titulo }}', '{{ $c->descripcion }}', '{{ $c->icono }}', '{{ $c->estado }}')"><i class="fa fa-pencil"></i></button>
                <button type="button" class="btn btn-danger btn-xs" onclick="eliminarCaracteristica('{{ $c->id }}', '{{ $c->titulo }}')"><i class="fa fa-trash"></i></button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>