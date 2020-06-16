<div class="wrapper wrapper-content animated fadeInRight">
    @foreach ($sede as $s)
    <div class="vote-item">
        <div class="row">
            <div class="col-md-10">
                <div class="vote-actions">
                    <a href="#">
                        <i class="fa fa-chevron-up"> </i>
                    </a>
                    <div>{{ $s->sede_id }}</div>
                    <a href="#">
                        <i class="fa fa-chevron-down"> </i>
                    </a>
                </div>
                <a href="#" class="vote-title">
                    {{ $s->nombre }}
                </a>
                <div class="vote-info">
                    <i class="fa fa-user"></i> <a href="#">{{ $s->telefono }}</a>
                    <i class="fa fa-users"></i> <a href="#">{{ $s->telfreferencia }}</a>
                    <i class="fa fa-mony"></i> <a href="#">{{ $s->direccion }} - {{ $s->distrito }} - {{ $s->provincia }} - {{ $s->departamento }}</a>
                </div>
            </div>
            <div class="col-md-2 ">
                <button type="button" class="btn btn-lg btn-warning" onclick="actualizar('{{ $s->sede_id }}', '{{ $s->nombre }}', '{{ $s->detalle }}', '{{ $s->referencia }}', '{{ $s->telefono }}', '{{ $s->telfreferencia }}', '{{ $s->direccion_id }}', '{{ $s->direccion }}','{{ $s->distrito_id }}', '{{ $s->provincia_id }}', '{{ $s->departamento_id }}')"><i class="fa fa-refresh"></i></button>
                <button type="button" class="btn btn-lg btn-danger" onclick="baja('{{ $s->sede_id }}')"><i class="fa fa-minus"></i></button>
            </div>
        </div>
    </div>
    @endforeach
</div>