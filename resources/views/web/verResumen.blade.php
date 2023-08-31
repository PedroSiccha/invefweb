@foreach ($resumen as $r)
    <?php
            $view = "";

            if( $r->tituloboton == null){
                $view = "hidden";
            }

        ?>
    <div class="tab-pane active animated fadeInRight" id="tab_a">
        <img alt="{{ $r->titulo }}" src="{{ $r->imagen }}" width="300" height="300">
        <h3>{{ $r->subtitulo }}</h3> 
        <p>{{ $r->descripcion }}</p>
        
        <a href="{{ $r->urlboton }}" class="btn btn-primary solid cd-btn {{ $view }}">{{ $r->tituloboton }}</a>
    </div>
@endforeach