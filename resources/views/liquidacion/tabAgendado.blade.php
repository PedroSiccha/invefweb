<div class="tab-content" id="tabAgendado">
                        <div id="tab-1" class="tab-pane active">
                            <div class="full-height-scroll">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Cod</th>
                                                <th>Cliente</th>
                                                <th>DNI</th>
                                                <th>Monto Prestamo</th>
                                                <th>Valor Venta</th>
                                                <th>Fecha Agendada</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($listAgendado as $ll)
                                            <tr class="{{ $ll->color_estado }}">
                                                <td>{{ $ll->prestamo_id }}</td>
                                                <td><a href="{{ Route('perfilCliente', [$ll->cliente_id]) }}">{{ $ll->nombre }}{{ $ll->apellido }}</a></td>
                                                <td>{{ $ll->dni }}</td>
                                                <td>{{ $ll->monto }}</td>
                                                <td>{{ $ll->total }}</td>
                                                <td>{{ $ll->fecagendar }}</td> 
                                            </tr>     
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>