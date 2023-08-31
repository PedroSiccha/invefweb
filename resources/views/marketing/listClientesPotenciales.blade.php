<?php 
use App\proceso; 
$pro = new proceso();
?>
<table class="table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombres</th>
                            <th>Semaforo</th>
                            <th>DNI</th>
                            <th>Telefono</th>
                            <th>Whatsapp</th>
                            <th>Correo</th>
                            <th>Facebook</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($clientes as $c)
                                <tr>
                                    <td>{{ $c->id }}</td>
                                    <td><a href="{{ Route('perfilCliente', [$c->id]) }}">{{ $c->nombre }} {{ $c->apellido }}</a> </td>
                                    <td>
                                        <?php
                                            $resultVerde = 'btn-default';
                                            $resultAmbar = 'btn-default';
                                            $resultRojo = 'btn-default';
                                            if ($c->rojo > $c->ambar) {
                                                $resultVerde = 'btn-default';
                                                $resultAmbar = 'btn-default';
                                                $resultRojo = 'btn-danger';
                                            } else {
                                                if ($c->ambar > $c->verde) {
                                                    $resultVerde = 'btn-default';
                                                    $resultAmbar = 'btn-warning';
                                                    $resultRojo = 'btn-default';
                                                } else {
                                                    $resultVerde = 'btn-primary';
                                                    $resultAmbar = 'btn-default';
                                                    $resultRojo = 'btn-default';
                                                }
                                            }
                                        ?>
                                        <div>
                                            <button class="btn {{$resultVerde}} btn-circle" type="button"></button>
                                            <button class="btn {{$resultAmbar}} btn-circle" type="button"></button>
                                            <button class="btn {{$resultRojo}} btn-circle" type="button"></button>
                                        </div>
                                    </td>
                                    <td>{{ $c->dni }}</td>
                                    <td><button class="btn btn-primary dim" type="button" onclick="verTelefono('{{ $c->telefono }}', '{{ $c->referencia }}')"><i class="fa fa-mobile"></i></button></td>
                                    <td><button class="btn btn-primary dim" type="button" onclick="verWhatsapp('{{ $c->whatsapp }}')"><i class="fa fa-whatsapp"></i></button></td>
                                    <td><button class="btn btn-warning dim" type="button" onclick="verCorreo('{{ $c->correo }}')"><i class="fa fa-envelope"></i></button></td>
                                    <td><a href="{{ $c->facebook }}" target="_blank"><button class="btn btn-success  dim" type="button" ><i class="fa fa-facebook"></i></button></a></td>
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