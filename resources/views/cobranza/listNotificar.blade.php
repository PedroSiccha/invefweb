<?php 
use App\proceso; 
$pro = new proceso();
?>
<table class="table table-striped table-hover" >
    <thead>
        <tr>
            <th>Cod.</th>
            <th>Nombres</th>
            <th>DNI</th>
            <th>Garantía</th>
            <th>Fec Fin</th>
            <th>Dias</th>
            <th>Monto</th>
            <th>Interes</th>
            <th>Mora Actual</th>
            <th>Total</th>
            <th>Herramientas</th>
        </tr>
    </thead>
    <tbody>
        
        @foreach($listNotificar as $ln)
        <?php
            $color = "bg-secondary";
            $botonWhats1 = "hidden";
            $botonWhats2 = "hidden";
            $botonWhats3 = "hidden";
            $botonWhats4 = "hidden";
            $botonWhats5 = "hidden";
            $botonWhats6 = "hidden";
            $mora = ($ln->dia - 30)*$ln->mora; 
            if ( $ln->dia < 31 and $ln->dia > 28) {
                //2 dias antes hasta la fecha
                $botonWhats1 = "";
                $botonWhats2 = "hidden";
                $botonWhats3 = "hidden";
                $botonWhats4 = "hidden";
                $botonWhats5 = "hidden";
                $botonWhats6 = "hidden";
                $color = "bg-secondary";
            }elseif ( 30 < $ln->dia and $ln->dia < 38) {
                //De la fecha hasta 7 dias despues
                $botonWhats1 = "hidden";
                $botonWhats2 = "";
                $botonWhats3 = "hidden";
                $botonWhats4 = "hidden";
                $botonWhats5 = "hidden";
                $botonWhats6 = "hidden";
                $color = "bg-secondary";
            }elseif (37 < $ln->dia and $ln->dia < 41) {
                //De 7 dias despues hasta los 10 dias
                $botonWhats1 = "hidden";
                $botonWhats2 = "hidden";
                $botonWhats3 = "";
                $botonWhats4 = "hidden";
                $botonWhats5 = "hidden";
                $botonWhats6 = "hidden";
                $color = "bg-secondary";
            }elseif (39 < $ln->dia and $ln->dia < 46) {
                //De 10 dias despues hasta 15 dias
                $botonWhats1 = "hidden";
                $botonWhats2 = "hidden";
                $botonWhats3 = "hidden";
                $botonWhats4 = "";
                $botonWhats5 = "hidden";
                $botonWhats6 = "hidden";
                $color = "bg-warning";
            }elseif (50 < $ln->dia and $ln->dia < 55) {
                //Despues de los 21 dias 
                $botonWhats1 = "hidden";
                $botonWhats2 = "hidden";
                $botonWhats3 = "hidden";
                $botonWhats4 = "hidden";
                $botonWhats5 = "";
                $botonWhats6 = "hidden";
                $color = "bg-warning";
            }elseif (54 < $ln->dia and $ln->dia < 61) {
                //Despues de los 25 dias
                $botonWhats1 = "hidden";
                $botonWhats2 = "hidden";
                $botonWhats3 = "hidden";
                $botonWhats4 = "hidden";
                $botonWhats5 = "";
                $color = "bg-danger";
            }elseif (59 < $ln->dia) {
                // Despues de los 30 dias pasar a liquidacion
                $botonWhats1 = "hidden";
                $botonWhats2 = "hidden";
                $botonWhats3 = "hidden";
                $botonWhats4 = "hidden";
                $botonWhats5 = "hidden";
                $color = "bg-secondary";
            }
        ?>
            
            <tr  class="{{ $color }}" >
                <td>{{ $ln->prestamo_id }}</td>
                <td><a class="text-info" href="{{ Route('perfilCliente', [$ln->cliente_id]) }}">{{ $ln->nombre }} {{ $ln->apellido }}</a></td>
                <td class="text-white">{{ $ln->dni }}</td> 
                <td class="text-white">{{ $ln->garantia }}</td>
                <td class="text-white">{{ cambiaf_a_espanol($ln->fecfin) }}</td>
                <td class="text-white">{{ $ln->dia }}</td>
                <td class="text-white">{{ $ln->monto }}</td>
                <td class="text-white">{{ $pro->interesActual($ln->dia,  $ln->monto, $ln->porcentaje, $ln->mora)[0] }}</td>
                <td class="text-white">{{ $pro->calcularMora($ln->fecfin, $ln->mora) }}</td>
                <td class="text-white">{{ $pro->interesActual($ln->dia,  $ln->monto, $ln->porcentaje, $ln->mora)[2] }}</td>
                <td class="client-status">
                    <a class="btn btn-success btn-facebook btn-outline btn-xs" href ="{{ $ln->facebook }}" target="_blank" data-toggle="tooltip" data-placement="top" title="Facebook">
                        <i class="fa fa-facebook"> </i>
                    </a>
                    
                    
                    <a class="btn btn-primary btn-outline btn-xs" {{ $botonWhats1 }} href="https://api.whatsapp.com/send?phone=51{{ $ln->whatsapp }}&text=Estimado%20{{ $ln->nombre }}%20{{ $ln->apellido }},%20le%20saludamos%20cordialmente%20de%20INVERSIONES%20INVEF%20SAC.%20Le%20enviamos%20los%20detalles%20de%20si%20crédito.%20Prestamo:%20S/.%20{{ $ln->monto }}.%20Interes:%20S/.%20{{ $pro->interesActual($ln->dia,  $ln->monto, $ln->porcentaje, $ln->mora)[0] }}.%20Vence%20el%20día:%20{{ cambiaf_a_espanol($ln->fecfin) }}.%20*Medios%20de%20pago:*%20En%20nuestra%20oficina%20dentro%20de%20los%20horarios%20establecidos.%20Cuenta%20BCP:%20375-30500414-0-56.%20Gerente%20Kelvin%20Javier%20R.%20Sin%20comisiones%20ni%20recargos%20en%20Agentes%20BCP.%20RECUERDE%20QUE%20USTED%20PUEDE:%20CANCELAR%20-%20RENOVAR%20-%20AMORTIZAR,%20SUS%20DEUDAS%20VENCIDAS.%20A%20si%20mismo%20informarle%20que%20usted%20tiene%20el%20derecho%20de%20poder%20realizar%20amortizaciones%20de%20capital%20con%20la%20siguiente%20reduccion%20de%20su%20monto%20de%20prestamo%20y%20su%20interes%20al%20siguiente%20mes." target="_blank" data-toggle="tooltip" data-placement="top" title="Whatsapp">
                        <i class="fa fa-whatsapp"></i>
                    </a>
                    <a class="btn btn-primary btn-outline btn-xs"  {{ $botonWhats2 }} href="https://api.whatsapp.com/send?phone=51{{ $ln->whatsapp }}&text=Estimado%20cliente%20{{ $ln->nombre }}%20{{ $ln->apellido }},%20le%20saludamos%20cordialmente%20de%20INVERSIONES%20INVEF%20SAC.%20Por%20que%20nos%20preocupamos%20por%20su%20credito%20y%20su%20pronta%20cancelacion%20o%20renovacion%20le%20enviamos%20los%20detalles%20de%20su%20credito.%20Prestamo:%20S/.%20{{ $ln->monto }}.%20Interes:%20S/.%20{{ $pro->interesActual($ln->dia,  $ln->monto, $ln->porcentaje, $ln->mora)[0] }}.%20Mora:%20S/.%20{{ $pro->calcularMora($ln->fecfin, $ln->mora) }}.%20Vencio%20el%20dia:%20{{ cambiaf_a_espanol($ln->fecfin) }}.%20Medios%20de%20Pago:%20En%20nuestra%20oficina%20dentro%20de%20los%20horarios%20establecidos.%20Cuenta%20BCP:%20375-30500414-0-56.%20Gerente:%20Kelvin%20Javier%20R.%20RECUERDE%20QUE%20USTEDE%20PUEDE:%20CANCELAR%20-%20RENOVAR%20-%20AMORTIZAR,%20SUS%20DEUDAS%20VENCIDAS.%20Las%20moras%20estan%20sujetas%20de%20acuerdo%20al%20contrato%20entre%20la%20empresa%20y%20el%20cliente%20prestatario.%20Servicio%20de%20atencion:%20043-634749.%20Pagina%20web:%20www.invef.tk" target="_blank" data-toggle="tooltip" data-placement="top" title="Whatsapp">
                        <i class="fa fa-whatsapp"></i>
                    </a>
                    <a class="btn btn-primary btn-outline btn-xs" {{ $botonWhats3 }} href="https://api.whatsapp.com/send?phone=51{{ $ln->whatsapp }}&text=DEUDA%20ATRASADA%20INVERSIONES%20INVEF%20SAC.%20Le%20recordamos%20que%20su%20contrato%20tiene%20fecha%20limite,%20despues%20de%20la%20fecha%20de%20vencimiento%20segun%20estipulado%20su%20contrato,%20con%20el%20plazo%20maximo%20de%2015%20dias.%20Prestamo:%20S/.%20{{ $ln->monto }}.%20Interes:%20S/.%20{{ $pro->interesActual($ln->dia,  $ln->monto, $ln->porcentaje, $ln->mora)[0] }}.%20Mora:%20S/.%20{{ $pro->calcularMora($ln->fecfin, $ln->mora) }}.%20({{ $ln->dia }}%20dias%20de%20retraso).%20Vencio%20el%20dia:%20{{ cambiaf_a_espanol($ln->fecfin) }}.%20Medios%20de%20Pago:%20En%20nuestra%20oficina%20dentro%20de%20los%20horarios%20establecidos.%20Cuenta%20BCP:%20375-30500414-0-56.%20Gerente:%20Kelvin%20Javier%20R.%20RECUERDE%20QUE%20USTED%20PUEDE:%20CANCELAR%20-%20RENOVAR%20-%20AMORTIZAR,%20SUS%20DEUDAS%20VENCIDAS.%20Las%20moras%20estan%20sujetas%20de%20acuerdo%20al%20contrato%20entre%20la%20empresa%20y%20el%20cliente%20prestatario.%20Servicio%20de%20atencion:%20043-634749.%%20web:%20www.invef.tk." target="_blank" data-toggle="tooltip" data-placement="top" title="Whatsapp">
                        <i class="fa fa-whatsapp"></i>
                    </a>
                    <a class="btn btn-primary btn-outline btn-xs" {{ $botonWhats4 }} href="https://api.whatsapp.com/send?phone=51{{ $ln->whatsapp }}&text=DEUDA%20ATRASADA%20INVERSIONES%20INVEF%20SAC.%20Es%20nuestro%20deber%20notificarle%20que%20su%20contrato%20ya%20venció%20su%20último%20día%20de%20plazo,%20pasado%20dicha%20fecha%20la%20empresa%20pondrá%20a%20su%20elección%20y%20ejecutar%20la%20liquidación%20de%20la%20garantía%20que%20fue%20constituido%20a%20su%20favor.%20Prestamo:%20S/.%20{{ $ln->monto }}.%20Interes:%20S/.%20{{ $pro->interesActual($ln->dia,  $ln->monto, $ln->porcentaje, $ln->mora)[0] }}.%20Mora:%20S/.%20{{ $pro->calcularMora($ln->fecfin, $ln->mora) }}.%20({{ $ln->dia }}%20dias%20de%20retraso).%20Vencio%20el%20dia:%20{{ cambiaf_a_espanol($ln->fecfin) }}.%20Medios%20de%20Pago:%20En%20nuestra%20oficina%20dentro%20de%20los%20horarios%20establecidos.%20Cuenta%20BCP:%20375-30500414-0-56.%20Gerente:%20Kelvin%20Javier%20R.%20RECUERDE%20QUE%20USTED%20PUEDE:%20CANCELAR%20-%20RENOVAR%20-%20AMORTIZAR,%20SUS%20DEUDAS%20VENCIDAS.%20Las%20moras%20estan%20sujetas%20de%20acuerdo%20al%20contrato%20entre%20la%20empresa%20y%20el%20cliente%20prestatario.NOTA:%20último%20día%20de%20plazo%EDITARFECHA.%20Con%20dos%20meses%20En%20caso%20que%20incumpla%20con%20su%20obligación%20de%20pago,%20la%20empresa%20pondrá%20a%20su%20disposición%20ejecutar%20las%20garantías%20que%20fueron%20constituido%20a%20su%20favor%20Servicio%20de%20atencion:%20043-634749.%%20web:%20www.invef.tk." target="_blank" data-toggle="tooltip" data-placement="top" title="Whatsapp">
                        <i class="fa fa-whatsapp"></i>
                    </a>
                    <a class="btn btn-primary btn-outline btn-xs" {{ $botonWhats5 }} href="https://api.whatsapp.com/send?phone=51{{ $ln->whatsapp }}&text=DEUDA%20ATRAZADA%20EJECUTACION%20DE%20CONTRATO%20INVERSIONES%20“INVEF”%20SAC.%20Es%20nuestro%20deber%20notificarle%20que%20el%20día%20de%20hoy%20venció%20su%20último%20día%20de%20plazo,%20pasado%20dicha%20fecha%20la%20empresa%20pone%20a%20su%20disposición%20y%20ejecutar%20de%20su%20garantía%20que%20fue%20constituido%20a%20su%20favor.%20%20Prestamo:%20S/.%20{{ $ln->monto }}.%20Interes:%20S/.%20{{ $pro->interesActual($ln->dia,  $ln->monto, $ln->porcentaje, $ln->mora)[0] }}.%20Mora:%20S/.%20{{ $pro->calcularMora($ln->fecfin, $ln->mora) }}.%20({{ $ln->dia }}%20dias%20de%20retraso).%20Vencio%20el%20dia:%20{{ cambiaf_a_espanol($ln->fecfin) }}.%20Medios%20de%20Pago:%20En%20nuestra%20oficina%20dentro%20de%20los%20horarios%20establecidos.%20Cuenta%20BCP:%20375-30500414-0-56.%20Gerente:%20Kelvin%20Javier%20R.%20RECUERDE%20QUE%20USTED%20PUEDE:%20CANCELAR%20-%20RENOVAR%20-%20AMORTIZAR,%20SUS%20DEUDAS%20VENCIDAS.%20Las%20moras%20estan%20sujetas%20de%20acuerdo%20al%20contrato%20entre%20la%20empresa%20y%20el%20cliente%20prestatario.%20NOTA:%20el%20día%20de%20mañana%20por%20incumplimiento%20de%20contrato%20la%20empresa%20pone%20a%20disposición%20y%20venta%20de%20su%20garantía%20para%20su%20recuperación%20de%20capital.%20ATT:%20%20LA%20GERENCIA.%20Servicio%20de%20atención:%20043-634749.%20Página%20web:%20invef.tk" target="_blank" data-toggle="tooltip" data-placement="top" title="Whatsapp">
                        <i class="fa fa-whatsapp"></i>
                    </a>
                    <button class="btn btn-warning btn-outline btn-xs" data-toggle="tooltip" data-placement="top" title="Correo" onclick="correo('{{ $ln->nombre }}', '{{ $ln->apellido }}', '{{ $ln->correo }}')"><i class="fa fa-envelope-o"></i></button>
                    <button type="button" class="btn btn-default btn-xs" data-toggle="tooltip" data-placement="top" title="Mensaje de Text"><i class="fa fa-comment-o"></i></button>
                    <button type="button" class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="top" title="Números Telefónicos" onclick="Numeros(' {{ $ln->prestamo_id }} ', '{{ $ln->nombre }} {{ $ln->apellido }}', '{{ $ln->dni }}', '{{ $ln->telefono }}', '{{ $ln->whatsapp }}', '{{ $ln->referencia }}')"><i class="fa fa-phone"></i></button>
                    <button type="button" class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="top" title="INFORMACIÓN DEL PRESTAMO" onclick="Detalle(' {{ $ln->prestamo_id }} ', '{{ $ln->nombre }} {{ $ln->apellido }}', '{{ $ln->dni }}', '{{ $ln->garantia }}', '{{ cambiaf_a_espanol($ln->fecinicio) }}', '{{ cambiaf_a_espanol($ln->fecfin) }}', '{{ $ln->dia }}', ' {{ $ln->monto }} ', ' {{ $pro->interesActual($ln->dia,  $ln->monto, $ln->porcentaje, $ln->mora)[0] }} ', ' {{ $pro->calcularMora($ln->fecfin, $ln->mora) }} ', ' {{ $pro->interesActual($ln->dia,  $ln->monto, $ln->porcentaje, $ln->mora)[2] }} ')"><i class="fa fa-desktop"></i></button>
                    <button type="button" class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="top" title="Subir Notificacion" onclick="subirNotificacion(' {{ $ln->prestamo_id }} ')"><i class="fa fa-cloud-upload"></i></button>
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