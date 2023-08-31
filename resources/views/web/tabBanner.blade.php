<table class="table">
    <thead>
    <tr>
        <th>Cod</th>
        <th>Titulo</th>
        <th>Descripción</th>
        <th>Fec Publicacion</th>
        <th>Fec Baja</th>
        <th>Estado</th>
        <th>Banner</th>
        <th>Gestion</th>
    </tr>
    </thead>
    <tbody>
        @foreach ($banner as $b)
        <?php
            if($b->estado == "ACTIVO"){
                $icon = "fa fa-toggle-on";
                $color = "text-info";
            }else{
                $icon = "fa fa-toggle-off";
                $color = "text-danger";
            }
        ?>
        <tr>
            <td>{{ $b->id }}</td>
            <td>{{ $b->nombre }}</td>
            <td>{{ $b->descripcion }}</td>
            <td>{{ $b->fecinicio }}</td>
            <td>{{ $b->fecfin }}</td>
            <td onclick="cambiarEstadoBanners('{{ $b->id }}', '{{ $b->estado }}')"><i class="{{ $icon }} {{ $color }}"></i></td>
            <td><img alt="{{ $b->nombre }}" src="{{ $b->imagen }}" width="50" height="50"></td>
            <td>
                <button type="button" class="btn btn-warning btn-xs" onclick="editarBanner('{{ $b->id }}', '{{ $b->nombre }}', '{{ $b->descripcion }}', '{{ $b->estado }}', '{{ $b->imagen }}')"><i class="fa fa-pencil"></i></button>
                <button type="button" class="btn btn-danger btn-xs" onclick="eliminarBanner('{{ $b->id }}', '{{ $b->nombre }}')"><i class="fa fa-trash"></i></button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>