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
        <a href="#" class="btn btn-sm btn-primary"> Más Información</a>
            <span class="vertical-date">
                Fecha de Solicitud <br>
                <small>{{ $ct->created_at }}</small>
            </span>
    </div>
</div>
@endforeach
