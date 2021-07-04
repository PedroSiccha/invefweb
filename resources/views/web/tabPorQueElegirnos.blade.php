<table class="table" >
    <thead>
    <tr>
        <th>Cod</th>
        <th>Titulo</th>
        <th>Descripción</th>
        <th>Publicacion</th>
        <th>Retirado</th>
        <th>Estado</th>
        <th>Icono</th>
        <th>Gestion</th>
    </tr>
    </thead>
    <tbody>
        @foreach ($resumenEmpresa as $re)
        <?php
            if($re->estado == "ACTIVO"){
                $icon = "fa fa-toggle-on";
                $color = "text-info";
            }else{
                $icon = "fa fa-toggle-off";
                $color = "text-danger";
            }
        ?>     
        <tr>
            <td>{{ $re->id }}</td>
            <td>{{ $re->titulo }}</td>
            <td>{{ $re->descripcion }}</td>
            <td>{{ $re->fecinicio }}</td>
            <td>{{ $re->fecfin }}</td>
            <td onclick="cambiarEstadoPorQueElergirnos('{{ $re->id }}', '{{ $re->estado }}')"><i class="{{ $icon }} {{ $color }}"></i></td>
            <td><i class="{{ $re->icono }}"></i></td>
            <td>
                <button type="button" class="btn btn-warning btn-xs" onclick="editarPorQueElegirnos('{{ $re->id }}', '{{ $re->titulo }}', '{{ $re->descripcion }}', '{{ $re->icono }}', '{{ $re->estado }}')"><i class="fa fa-pencil"></i></button>
                <button type="button" class="btn btn-danger btn-xs" onclick="eliminarPorQueElegirnos('{{ $re->id }}', '{{ $re->titulo }}')"><i class="fa fa-trash"></i></button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>