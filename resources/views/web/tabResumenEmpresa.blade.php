<table class="table">
    <thead>
    <tr>
        <th>Cod</th>
        <th>Titulo</th>
        <th>Sub Titulo</th>
        <th>Descripcion</th>
        <th>Estado</th>
        <th>Icono</th>
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
            <td>{{ $r->subtitulo }}</td>
            <td>{{ $r->descripcion }}</td>
            <td onclick="cambiarEstadoResumenEmpresa('{{ $r->id }}', '{{ $r->estado }}')"><i class="{{ $icon }} {{ $color }}"></i></td>
            <td><i class="{{ $r->icono }}"></i></td>
            <td>
                <button type="button" class="btn btn-warning btn-xs" onclick="editarResumenEmpresa('{{ $r->id }}', '{{ $r->titulo }}', '{{ $r->subtitulo }}', '{{ $r->descripcion }}', '{{ $r->icono }}', '{{ $r->imagen }}', '{{ $r->tituloboton }}', '{{ $r->urlboton }}', '{{ $r->estado }}')"><i class="fa fa-pencil"></i></button>
                <button type="button" class="btn btn-danger btn-xs" onclick="eliminarResumenEmpresa('{{ $r->id }}', '{{ $r->titulo }}')"><i class="fa fa-trash"></i></button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>