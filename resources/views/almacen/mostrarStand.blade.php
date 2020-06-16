<div class="col-lg-12">
    <div class="tabs-container">

        <div class="tabs-left">
            <ul class="nav nav-tabs">
                @foreach ($stand as $s)
                <li><a class="nav-link active" data-toggle="tab" href="#tab-{{ $s->stand_id }}" onclick="mostrarCasillero('{{ $s->stand_id }}')"> {{ $s->nombre }}</a></li>    
                @endforeach
            </ul>
            <div class="tab-content ">
                @foreach ($stand as $item)
                    <div id="" class="tab-pane active">
                        <div class="panel-body" id="divMostrarCasilleros_{{ $item->stand_id }}">

                        </div>
                    </div>
                @endforeach
                    
            </div>

        </div>

    </div>
</div>