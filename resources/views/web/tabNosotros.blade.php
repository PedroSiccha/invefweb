<table class="table">
    <thead>
    <tr>
        <th>Cod</th>
        <th>Titulo</th>
        <th>Descripcion</th>
        <th>Imagen</th>
        <th>Estado</th>
        <th>Posición</th>
        <th>Gestion</th>
    </tr>
    </thead>
    <tbody>
        @foreach ($nosotros as $n) 
        <?php
            if($n->estado == "ACTIVO"){
                $icon = "fa fa-toggle-on";
                $color = "text-info";
            }else{
                $icon = "fa fa-toggle-off";
                $color = "text-danger";
            }
        ?>   
        <tr>
            <td>{{ $n->id }}</td>
            <td>{{ $n->titulo }}</td>
            <td>{{ $n->descripcion }}</td>
            <td><img alt="{{ $n->titulo }}" src="{{ $n->imagen }}" width="50" height="50"></td>
            <td>{{ $n->posicion }}</td>
            <td onclick="cambiarEstadoResumenEmpresa('{{ $n->id }}', '{{ $n->estado }}')"><i class="{{ $icon }} {{ $color }}"></i></td>
            <td>
                <button type="button" class="btn btn-warning btn-xs" onclick="editarResumenEmpresa('{{ $n->id }}', '{{ $n->titulo }}', '{{ $n->posicion }}', '{{ $n->estado }}')"><i class="fa fa-pencil"></i></button>
                <button type="button" class="btn btn-danger btn-xs" onclick="eliminarResumenEmpresa('{{ $n->id }}', '{{ $n->titulo }}')"><i class="fa fa-trash"></i></button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>