<?php 
    use App\proceso; 
    $pro = new proceso();
?>
<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th>Cod.</th>
            <th>Nombres</th>
            <th>Fec Fin</th>
            <th>Dias</th>
            <th>Monto</th>
            <th>Interes</th>
            <th>Interes Actual</th>
            <th>Mora Actual</th>
            <th>Total</th>
            <th>Acción</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($prestamo as $pr)

                <?php

                    $inicio = $pr->fecinicio;
                    $fechaActual = date("d-m-Y");
                    $dias = (strtotime($inicio)-strtotime($fechaActual))/86400;
                    $dias = abs($dias); $dias = floor($dias);

                    $inicioF = $pr->fecfin;
                    $diaFin = (strtotime($fechaActual) - strtotime($inicioF))/86400;
                    $diaFin = abs($diaFin); 
                    $diaFin = floor($diaFin);   

                ?>

            <tr>
                <td>{{ $pr->prestamo_id }}</td>
                <td><a href="{{ Route('perfilCliente', [$pr->cliente_id]) }}">{{ $pr->nombre }} {{ $pr->apellido }}</a></td>
                <td>{{ $pr->fecfin }}</td>
                <td>{{$dias}} días</td>
                <td>S/. {{ $pr->monto }}</td>
                <td>{{ $pr->porcentaje }} %</td>
                <td>S/. {{ $pro->interesActual($dias, $pr->monto, $pr->porcentaje, $pr->morapagar)[0] }}</td>
                <td>S/. {{ $pro->calcularMora($pr->fecfin, $pr->morapagar) }}</td>
                <td>S/. {{ $pro->interesActual($dias, $pr->monto, $pr->porcentaje, $pr->morapagar)[2] + $pro->calcularMora($pr->fecfin, $pr->morapagar) }}</td>
                <td class="client-status">
                    <button type="button" class="btn btn-success btn-xs" onclick="Pagar(' {{ $pr->prestamo_id }} ', ' {{ $pr->monto }} ', ' {{ $pro->interesActual($dias, $pr->monto, $pr->porcentaje, $pr->morapagar)[0] }} ', ' {{ $pro->calcularMora($pr->fecfin, $pr->morapagar) }} ', ' {{ $pro->interesActual($dias, $pr->monto, $pr->porcentaje, $pr->morapagar)[2] + $pro->calcularMora($pr->fecfin, $pr->morapagar) }}', ' {{ $pro->interesActual($dias, $pr->monto, $pr->porcentaje, $pr->morapagar)[2] }} ', '{{ $dias }}' , ' {{ $diaFin }} ', '{{ $pro->interesActual($dias, $pr->monto, $pr->porcentaje, $pr->morapagar)[3] }}')" data-toggle="tooltip" data-placement="top" title="PAGAR PRESTAMO"><i class="fa fa-money"></i></button>
                    <button type="button" class="btn btn-warning btn-xs" onclick="Renovar(' {{ $pr->prestamo_id }} ', ' {{ $pr->monto }} ', ' {{ $pro->interesActual($dias,  $pr->monto, $pr->porcentaje, $pr->morapagar)[0] }} ', '{{ $pro->calcularMora($pr->fecfin, $pr->morapagar) }} ', ' {{ $pro->interesActual($dias, $pr->monto, $pr->porcentaje, $pr->morapagar)[2] + $pro->calcularMora($pr->fecfin, $pr->morapagar) }} ', '{{ $dias }}' , ' {{ $diaFin }} ', '{{ $pro->interesActual($dias, $pr->monto, $pr->porcentaje, $pr->morapagar)[3] }}')" data-toggle="tooltip" data-placement="top" title="RENOVAR PRESTAMO"><i class="fa fa-history"></i></button>
                    <button type="button" class="btn btn-default btn-xs" onclick="PagarDeposito(' {{ $pr->prestamo_id }} ', ' {{ $pr->monto }} ', ' {{ $pro->interesActual($dias, $pr->monto, $pr->porcentaje, $pr->morapagar)[0] }} ', ' {{ $pro->calcularMora($pr->fecfin, $pr->morapagar) }} ', ' {{ $pro->interesActual($dias, $pr->monto, $pr->porcentaje, $pr->morapagar)[2] + $pro->calcularMora($pr->fecfin, $pr->morapagar) }} ', '{{ $dias }}' , ' {{ $diaFin }} ')" data-toggle="tooltip" data-placement="top" title="PAGO DEPOSITO"><i class="fa fa-bank"></i></button>
                    <button type="button" class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="top" title="INFORMACIÓN DEL PRESTAMO" onclick="Detalle(' {{ $pr->prestamo_id }} ', '{{ $pr->nombre }} {{ $pr->apellido }}', '{{ $pr->dni }}', '{{ $pr->garantia }}', '{{ $pr->fecinicio }}', '{{ $pr->fecfin }}', '{{ $dias }}', ' {{ $pr->monto }} ', ' {{ $pro->interesActual($dias, $pr->monto, $pr->porcentaje, $pr->morapagar)[0] }} ', ' {{ $pro->calcularMora($pr->fecfin, $pr->morapagar) }} ', ' {{ $pro->interesActual($dias, $pr->monto, $pr->porcentaje, $pr->morapagar)[2] + $pro->calcularMora($pr->fecfin, $pr->morapagar) }}', ' {{ $pro->interesActual($dias, $pr->monto, $pr->porcentaje, $pr->morapagar)[2] }} ', '{{ $pro->interesActual($dias, $pr->monto, $pr->porcentaje, $pr->morapagar)[3] }}')"><i class="fa fa-desktop"></i></button>
                </td>
            </tr>        
        @endforeach
    </tbody>
</table>
<?php

/*function cambiaf_a_espanol($fecha){
    preg_match( '/([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})/', $fecha, $mifecha);
    $lafecha=$mifecha[3]."/".$mifecha[2]."/".$mifecha[1];
    return $lafecha;
}
*/
?>