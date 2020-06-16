<div id="tab-1" class="tab-pane active">
    <div class="full-height-scroll">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Cod</th>
                        <th>Cliente</th>
                        <th>DNI</th>
                        <th>Garantia</th>
                        <th>Monto Prestamo</th>
                        <th>Valor Venta</th>
                        <th>Administración</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($listLiquidacion as $ll)
                    <tr>
                        <td>{{ $ll->prestamo_id }}</td>
                        <td>{{ $ll->nombre }}{{ $ll->apellido }}</td>
                        <td>{{ $ll->dni }}</td>
                        <td>{{ $ll->garantia }}</td>
                        <td>{{ $ll->monto }}</td>
                        <td>{{ $ll->total }}</td>
                        <td>
                            <button type="button" class="btn btn-success btn-xs" onclick="Vender(' {{ $ll->prestamo_id }} ', ' {{ $ll->monto }} ', ' {{ $ll->interes }} ', ' {{ $ll->mora }} ', ' {{ $ll->total }} ')" data-toggle="tooltip" data-placement="top" title="VENDER GARANTÍA"><i class="fa fa-money"></i></button><button type="button" class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="top" title="HISTORIAL DEL PRESTAMO" onclick="Detalle(' {{ $ll->prestamo_id }} ', '{{ $ll->nombre }} {{ $ll->apellido }}', '{{ $ll->dni }}', '{{ $ll->garantia }}', '{{ $ll->monto }}', '{{ $ll->interes }}', '{{ $ll->mora }}', ' {{ $ll->total }} ')"><i class="fa fa-desktop"></i></button>    
                        </td> 
                    </tr>     
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>