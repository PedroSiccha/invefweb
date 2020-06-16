<?php 
    use App\proceso; 
    $pro = new proceso();
?>
<div class="panel-body row">
    <div class="col-lg-6">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>PAGOS</h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-wrench"></i>
                    </a>
                    <a class="close-link">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content" id="divTipoPrestamo">
                <table class="footable table table-stripped toggle-arrow-tiny">
                    <thead>
                    <tr>
                        <th>Cod</th>
                        <th>Concepto</th>
                        <th>Fecha de Transcaccion</th>
                        <th>Monto</th>
                        <th>Garantia</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($consultaI as $ci)
                        <tr>
                            <td>{{ $ci->cod }}</td>
                            <td>{{ $ci->concepto }}</td>
                            <td>{{ $pro->cambiaf_a_espanol($ci->fecha) }}</td>
                            <td>{{ $ci->monto }}</td>
                            <td>{{ $ci->nombre }}</td>
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

    <div class="col-lg-6">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>RETIROS</h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-wrench"></i>
                    </a>
                    <a class="close-link">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content" id="divTipoPrestamo">
                <table class="footable table table-stripped toggle-arrow-tiny">
                    <thead>
                        <tr>
                            <th>Cod</th>
                            <th>Concepto</th>
                            <th>Fecha de Transcaccion</th>
                            <th>Monto</th>
                            <th>Garantia</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($consultaE as $ce)
                        <tr>
                            <td>{{ $ce->cod }}</td>
                            <td>{{ $ce->concepto }}</td>
                            <td>{{ $pro->cambiaf_a_espanol($ce->fecha) }}</td>
                            <td>{{ $ce->monto }}</td>
                            <td>{{ $ce->nombre }}</td>
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

</div>