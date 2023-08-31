<a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
    <i class="fa fa-bell"></i>  
    <?php 
        $ver = "";
        if ($cantNotificaciones[0]->cant == 0) {
            $ver = "hidden";
        }
    ?>
    <span class="label label-primary" {{ $ver }}>{{ $cantNotificaciones[0]->cant }}</span>
</a>
<ul class="dropdown-menu dropdown-alerts">
    <li>
        @foreach ($notificacion as $n)
            <a href="mailbox.html" class="dropdown-item" {{ $ver }}>
                <div>
                    <i class="fa {{ $n->icono }} fa-fw"></i> {{ $n->asunto }}
                    <span class="float-right text-muted small">
                        <?php
                        $horaInicio = new DateTime(date("H:m:s"));
                        $horaTermino = new DateTime($n->tiempo);

                        $interval = $horaInicio->diff($horaTermino);

                        echo $interval->format('%H:%i:%s');

                        ?> minutos antes
                    </span>
                </div>
            </a>
        @endforeach
    </li>
    <li class="dropdown-divider"></li>
</ul>