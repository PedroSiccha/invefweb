<?php 
    use App\proceso; 
    $pro = new proceso();
?>
<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th>Cod.</th>
            <th>Nombres</th>
            <th>Fecha Inicio</th>
            <th>Fecha Fin</th>
            <th>Dias</th>
            <th>Monto</th>
            <th>Interes</th>
            <th>Mora</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($cliente as $cl)

        <?php

            $inicio = $cl->fecinicio;
            $fechaActual = date("d-m-Y");
            $dias = (strtotime($inicio)-strtotime($fechaActual))/86400;
            
            $dias = abs($dias); 
            $dias = floor($dias);
            
            $inicioF = $cl->fecfin;
            $diaFin = (strtotime($fechaActual) - strtotime($inicioF))/86400;
            $diaFin = abs($diaFin); 
            $diaFin = floor($diaFin);   

        ?>

            <tr>
                <td>{{ $cl->prestamo_id }}</td>
                <td>{{ $cl->nombre }} {{ $cl->apellido }}</td>
                <td>{{ cambiaf_a_espanol($cl->fecinicio) }}</td>
                <td>{{ cambiaf_a_espanol($cl->fecfin) }}</td>
                <td>{{$dias}} días</td>
                <td>S/. {{ $cl->monto }}</td>
                <td>S/. {{ $pro->interesActual($dias, $cl->monto, $cl->porcentaje, $cl->morapagar)[0] }}</td>
                <td>S/. {{ $pro->calcularMora($cl->fecfin, $cl->morapagar) }}</td>
                <td>S/. {{ $pro->interesActual($dias, $cl->monto, $cl->porcentaje, $cl->morapagar)[2] + $pro->calcularMora($cl->fecfin, $cl->morapagar) }}</td>
                <td class="client-status">
                    <button type="button" class="btn btn-success btn-xs" onclick="Pagar(' {{ $cl->prestamo_id }} ', ' {{ $cl->monto }} ', ' {{ $pro->interesActual($dias, $cl->monto, $cl->porcentaje, $cl->morapagar)[0] }} ', ' {{ $pro->calcularMora($cl->fecfin, $cl->morapagar) }} ', ' {{ $pro->interesActual($dias, $cl->monto, $cl->porcentaje, $cl->morapagar)[2] + $pro->calcularMora($cl->fecfin, $cl->morapagar) }} ', '{{ $dias }}' , ' {{ $diaFin }} ')" data-toggle="tooltip" data-placement="top" title="PAGAR PRESTAMO"><i class="fa fa-money"></i></button>
                    <button type="button" class="btn btn-warning btn-xs" onclick="Renovar(' {{ $cl->prestamo_id }} ', ' {{ $cl->monto }} ', ' {{ $pro->interesActual($dias, $cl->monto, $cl->porcentaje, $cl->morapagar)[0] }} ', ' {{ $pro->calcularMora($cl->fecfin, $cl->morapagar) }} ', ' {{ $pro->interesActual($dias, $cl->monto, $cl->porcentaje, $cl->morapagar)[2] + $pro->calcularMora($cl->fecfin, $cl->morapagar) }} ', '{{ $dias }}' , ' {{ $diaFin }} ')" data-toggle="tooltip" data-placement="top" title="RENOVAR PRESTAMO"><i class="fa fa-history"></i></button>
                    <button type="button" class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="top" title="INFORMACIÓN DEL PRESTAMO" onclick="Detalle(' {{ $cl->prestamo_id }} ', '{{ $cl->nombre }} {{ $cl->apellido }}', '{{ cambiaf_a_espanol($cl->fecinicio) }}', '{{ cambiaf_a_espanol($cl->fecfin) }}', '{{ $dias }}', ' {{ $cl->monto }} ', ' {{ $pro->interesActual($dias, $cl->monto, $cl->porcentaje, $cl->morapagar)[0] }} ', ' {{ $pro->calcularMora($cl->fecfin, $cl->morapagar) }} ', ' {{ $pro->interesActual($dias, $cl->monto, $cl->porcentaje, $cl->morapagar)[2] + $pro->calcularMora($cl->fecfin, $cl->morapagar) }} ')"><i class="fa fa-desktop"></i></button>
                </td>
            </tr>        
        @endforeach
    </tbody>
</table>
<?php
function cambiaf_a_espanol($fecha){
    preg_match( '/([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})/', $fecha, $mifecha);
    $lafecha=$mifecha[3]."/".$mifecha[2]."/".$mifecha[1];
    return $lafecha;
}
?>