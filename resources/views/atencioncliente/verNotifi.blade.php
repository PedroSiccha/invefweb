<?php 
    use App\proceso; 
    $pro = new proceso();
?>
<table class="table table-striped">
    <thead>
    <tr>
        <th>#</th>
        <th>Nombre</th>
        <th>Asunto</th>
        <th>Fecha</th>
        <th>Archivo</th>
    </tr>
    </thead>
    <tbody>
        @foreach ($notificacion as $n)
            <tr>
                <td>{{ $n->id }}</td>
                <td>{{ $n->nombre }}</td>
                <td>{{ $n->asunto }}</td>
                <td>{{ $pro->cambiaf_a_espanol($n->fecha) }}</td>
                <td>
                    <a href="../{{ $n->url }}" title="{{ $n->nombre }}" data-gallery="" >
                        <img src="../{{ $n->url }}"  width="60" height="60">
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>