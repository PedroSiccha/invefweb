<table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Cod</th>
                                                <th>Cliente</th>
                                                <th>DNI</th>
                                                <th>Garantia</th>
                                                <th>Monto Prestamo</th>
                                                <th>Valor Venta</th>
                                                <th>Fecha Agendada</th>
                                                <th>Administración</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($listLiquidacion as $ll)
                                            <tr class="{{ $ll->color_estado }}">
                                                <td>{{ $ll->prestamo_id }}</td>
                                                <td><a href="{{ Route('perfilCliente', [$ll->cliente_id]) }}">{{ $ll->nombre }}{{ $ll->apellido }}</a></td>
                                                <td>{{ $ll->dni }}</td>
                                                <td>{{ $ll->garantia }}</td>
                                                <td>{{ $ll->monto }}</td>
                                                <td>{{ $ll->total }}</td>
                                                <td>{{ $ll->fecagendar }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-success btn-xs" onclick="Vender(' {{ $ll->prestamo_id }} ', ' {{ $ll->monto }} ', ' {{ $ll->interes }} ', ' {{ $ll->mora }} ', ' {{ $ll->total }} ', ' {{ $ll->fecinicio }} ', ' {{ $ll->fecfin }} ')" data-toggle="tooltip" data-placement="top" title="VENDER GARANTÍA"><i class="fa fa-money"></i></button><button type="button" class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="top" title="HISTORIAL DEL PRESTAMO" onclick="Detalle(' {{ $ll->prestamo_id }} ', '{{ $ll->nombre }} {{ $ll->apellido }}', '{{ $ll->dni }}', '{{ $ll->garantia }}', '{{ $ll->monto }}', '{{ $ll->interes }}', '{{ $ll->mora }}', ' {{ $ll->total }} ', ' {{ $ll->fecinicio }} ', ' {{ $ll->fecfin }} ')"><i class="fa fa-desktop"></i></button>
                                                    <a class="btn btn-success btn-facebook btn-outline btn-xs" href ="{{ $ll->facebook }}" target="_blank" data-toggle="tooltip" data-placement="top" title="Facebook">
                                                        <i class="fa fa-facebook"> </i>
                                                    </a>
                                                    <button class="btn btn-warning btn-outline btn-xs" data-toggle="tooltip" data-placement="top" title="Correo" onclick="correo('{{ $ll->nombre }}', '{{ $ll->apellido }}', '{{ $ll->correo }}')"><i class="fa fa-envelope-o"></i></button>
                                                    <a class="btn btn-warning btn-facebook btn-outline btn-xs" onclick="AgendarRecojo(' {{ $ll->prestamo_id }} ')" data-toggle="tooltip" data-placement="top" title="Agendar">
                                                        <i class="fa fa-calendar">Agendar</i>
                                                    </a>
                                                </td> 
                                            </tr>     
                                            @endforeach
                                        </tbody>
                                    </table>