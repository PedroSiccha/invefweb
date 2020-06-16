<div class="tab-content">
    @foreach ($clientes as $cl)
        <div id="contact-{{ $cl->cliente_id }}" class="tab-pane active">
            <div class="row m-b-lg">
                <div class="col-lg-4 text-center">
                    <h2>{{ $cl->nombre }} {{ $cl->apellido }}</h2>

                    <div class="m-b-sm">
                        <img alt="image" class="rounded-circle" src="{{ $cl->foto }}"
                                style="width: 62px">
                    </div>
                </div>
                <div class="col-lg-8">
                    <a class="btn btn-success btn-facebook btn-outline" href ="{{ $cl->facebook }}" target="_blank">
                        <i class="fa fa-facebook"> </i> {{ $cl->nombre }}
                    </a>
                    <a class="btn btn-success btn-facebook btn-outline" href ="{{ Route('perfilCliente', [ $cl->cliente_id ]) }}">
                        <i class="fa fa-user-o"> </i> 
                    </a>
                    <a class="btn btn-primary btn-facebook btn-outline" href="https://api.whatsapp.com/send?phone=51{{ $cl->whatsapp }}&text=Hola%21%20Bienvenido%20a%20Invef." target="_blank">
                        <i class="fa fa-whatsapp my-float"></i>
                    </a>
                </div>
            </div>
            <div class="client-detail">
            <div class="full-height-scroll">

                <strong>Datos Principales</strong>

                <ul class="list-group clear-list">
                    <li class="list-group-item fist-item">
                        <span class="float-right"> {{ $cl->direccion }} </span>
                        Dirección
                    </li>
                    <li class="list-group-item">
                        <span class="float-right"> {{ $cl->edad }} </span>
                        Edad
                    </li>
                    <li class="list-group-item">
                        <span class="float-right">  </span>
                        Telefono
                    </li>
                    <li class="list-group-item">
                        <span class="float-right"> {{ $cl->ocupacion }} </span>
                        Ocupación
                    </li>
                    <li class="list-group-item">
                        <span class="float-right"> {{ $cl->recomendacion }} </span>
                        Recomendación
                    </li>
                </ul>
                <strong data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">Datos Secundarios</strong>
                <div id="collapseTwo" class="panel-collapse collapse">
                    <div class="panel-body">
                        <li class="list-group-item fist-item">
                            <span class="float-right"> {{ $cl->cliente_id }} </span>
                            Código de Cliente
                        </li>
                        <li class="list-group-item">
                            <span class="float-right"> {{ $cl->fecnac }} </span>
                            Fecha de Nacimiento
                        </li>
                        <li class="list-group-item">
                            <span class="float-right"> {{ $cl->genero }} </span>
                            Genero
                        </li>
                        <li class="list-group-item">
                            <span class="float-right"> {{ $cl->ingmax }} - {{ $cl->ingmin }} </span>
                            Rango de Ingresos
                        </li>
                        <li class="list-group-item">
                            <span class="float-right"> {{ $cl->gasmax }} - {{ $cl->gasmin }} </span>
                            Rango de Gastos
                        </li>
                    </div>
                </div>
                <hr/>
            </div>
            </div>
        </div>
    @endforeach
</div>