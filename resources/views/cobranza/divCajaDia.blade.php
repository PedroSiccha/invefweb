<table class="footable table table-stripped toggle-arrow-tiny">
    <thead>
        <tr>
            <th data-toggle="true">Código</th>
            <th>Fecha</th>
            <th>Hora de Apertura</th>
            <th>Hora de Cierre</th>
            <th>Balance del Día</th>
            <th>Monto Final</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($controlCaja as $cc)
        <?php
            $Balance = $cc->montofin - $cc->monto;
            
            if ($Balance < 0) {
                $estado = "red-bg";
                $grafica = "fa fa-angle-double-down fa-1x";
            }else {
                $estado = "navy-bg";
                $grafica = "fa fa-angle-double-up fa-1x";
            }
         ?>
            <tr>
                <td onclick="detalleCajaDia('{{ $cc->id }}')">{{ $cc->id }}</td>
                <td>{{ $cc->fecha }}</td>
                <td>{{ $cc->inicio }}</td>
                <td>{{ $cc->fin }}</td>
                <td class="<?php echo $estado ?>">S/. <?php echo $Balance ?>  <i class="<?php echo $grafica ?>"></i></td>
                <td>S/. {{ $cc->montofin }}</td>
            </tr>    
        @endforeach
        <tr>
            <td>TOTAL:</td>
            <td></td>
            <td></td>
            <td></td>
            <td>{{ $variacion }}</td>
            <td></td>
        </tr>  
    </tbody>
    <tfoot>
        
    <tr>
        <td colspan="5">
            <ul class="pagination float-right"></ul>
        </td>
    </tr>
    </tfoot>
</table>