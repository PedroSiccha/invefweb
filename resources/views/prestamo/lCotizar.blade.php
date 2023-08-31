@foreach ($cotizacion as $ct)
<div class="vertical-timeline-block">
    <div class="vertical-timeline-icon navy-bg">
        <i class="fa fa-briefcase"></i>
    </div>
    
    <div class="vertical-timeline-content">
        <h2>{{ $ct->garantia }}</h2>
        <p>Rango de Cotizacion: {{ $ct->max }} - {{ $ct->min }}
        </p>
        <p>Tipo de Prestamo: {{ $ct->tipoPrestamo }}
        </p>
        <a onclick="verCasillerosAlmacen('{{ $ct->garantia_id }}', '{{ $ct->cotizacion_id }}')" class="btn btn-sm btn-primary"> <p style="color:#FFFFFF";>Asignar Almacen</p></a>
            <span class="vertical-date">
                Fecha de Solicitud <br>
                <small>{{ $ct->created_at }}</small>
            </span>
    </div>
</div>
@endforeach
