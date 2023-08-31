<div role="tabpanel" id="cSalida" class="tab-pane active">
    <div class="panel-body">
        <div class="ibox-content">
            <table class="footable table table-stripped toggle-arrow-tiny">
                <thead>
                <tr>
                    <th data-toggle="true">Código</th>
                    <th>Concepto</th>
                    <th>Cliente</th>
                    <th>Fecha de Transcaccion</th>
                    <th>Monto</th>
                    <th>Usuario</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($egresoCd as $eg)
                    <tr>
                        <td>{{ $eg->id }}</td>
                        <td>{{ $eg->concepto }}</td>
                        <td>{{ $eg->nombreCl }} {{ $eg->apellidoCl }}</td>
                        <td>{{ $eg->created_at }}</td>
                        <td>{{ $eg->monto }}</td>
                        <td>{{ $eg->nombreEm }} {{ $eg->apellidoEm }}</td>
                    </tr>    
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="5">
                        <ul class="pagination float-right"></ul>
                    </td>
                </tr>
                </tfoot>
            </table>

        </div>
    </div>
</div>
<div role="tabpanel" id="cEntrada" class="tab-pane">
    <div class="panel-body">
        <div class="ibox-content">
            <table class="footable table table-stripped toggle-arrow-tiny">
                <thead>
                    <tr>
                        <th data-toggle="true">Código</th>
                        <th>Concepto</th>
                        <th>Cliente</th>
                        <th>Fecha de Transcaccion</th>
                        <th>Monto</th>
                        <th>Usuario</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($ingresoCd as $ing)
                    <tr>
                        <td>{{ $ing->id }}</td>
                        <td>{{ $ing->concepto }}</td>
                        <td>{{ $ing->nombreCl }} {{ $ing->apellidoCl }}</td>
                        <td>{{ $ing->created_at }}</td>
                        <td>{{ $ing->monto }}</td>
                        <td>{{ $ing->nombreEm }} {{ $ing->apellidoEm }}</td>
                    </tr>    
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="5">
                        <ul class="pagination float-right"></ul>
                    </td>
                </tr>
                </tfoot>
            </table>

        </div>
    </div>
</div>