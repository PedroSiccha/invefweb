<div class="row">
    @foreach ($casillero as $c)
        <?php 
        if ($c->estado == "OCUPADO") {
            $color = "red-bg";
            $animacion = "fa-archive";
        }elseif ($c->estado == "LIBRE") {
            $color = "navy-bg";
            $animacion = "fa-dropbox";
        }else {
            $color = "yellow-bg";
            $animacion = "fa-stack-overflow";
        }
        ?>
        <div class="col-lg-4" onclick="liberarStand('{{ $c->id }}')">
            <div class="ibox-tools">
                <a class="close-link" onclick="eliminarCasillero('{{ $c->id }}')">
                    <i class="fa fa-times"></i>
                </a>
            </div>
            <div class="widget-head-color-box {{ $color }} p-lg text-center">
                <div class="m-b-md">
                <h2 class="font-bold no-margins">
                    {{ $c->nombre }}
                </h2>
                    <small>{{ $c->id }}</small>
                </div>
                <i class="fa {{ $animacion }} fa-4x">

                </i>
                <div>
                    <span>{{ $c->estado }}</span>
                </div>
            </div>
        </div>
    @endforeach
</div>