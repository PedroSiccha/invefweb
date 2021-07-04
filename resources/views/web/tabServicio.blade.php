<table class="table">
    <thead>
    <tr>
        <th>Cod</th>
        <th>Titulo</th>
        <th>Resumen</th>
        <th>Descripcion</th>
        <th>Estado</th>
        <th>Imagen</th>
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
            <td>{{ $r->titulo }}</td>
            <td>{{ $r->resumen }}</td>
            <td> 
                - {{ $r->desc01 }}.
                - {{ $r->desc02 }}
                - {{ $r->desc03 }}
                - {{ $r->desc04 }}
                - {{ $r->desc05 }}
            </td>
            <td onclick="cambiarEstadoServicio('{{ $r->id }}', '{{ $r->estado }}')"><i class="{{ $icon }} {{ $color }}"></i></td>
            <td><img alt="{{ $r->titulo }}" src="{{ $r->imagen }}" width="50" height="50"></td>
            <td>
                <button type="button" class="btn btn-warning btn-xs" onclick="editarServicio('{{ $r->id }}', '{{ $r->titulo }}', '{{ $r->resumen }}', '{{ $r->desc01 }}', '{{ $r->desc02 }}', '{{ $r->desc03 }}', '{{ $r->desc04 }}', '{{ $r->desc05 }}', '{{ $r->imagen }}', '{{ $r->estado }}')"><i class="fa fa-pencil"></i></button>
                <button type="button" class="btn btn-danger btn-xs" onclick="eliminarServicio('{{ $r->id }}', '{{ $r->titulo }}')"><i class="fa fa-trash"></i></button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>