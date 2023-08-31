<?php 
    use App\proceso; 
    $pro = new proceso();
?>
<div class="col-lg-6">  
    <div class="ibox ">
        <div class="ibox-title">
            <h5>Caja Salida</h5>
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
        <div class="ibox-content" id="">
            <table class="footable table table-stripped toggle-arrow-tiny">
                <thead>
                <tr>
                    <th>Concepto</th>
                    <th>Cliente</th>
                    <th>Fecha de Transcaccion</th>
                    <th>Monto</th>
                    <th>Usuario</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($egreso as $eg)
                    <tr>
                        <td>{{ $eg->concepto }}</td>
                        <td>{{ $eg->nomCli }} {{ $eg->apeCli }}</td>
                        <td>{{ $pro->cambiaf_a_espanol($eg->fecha) }}</td>
                        <td>{{ $eg->monto }}</td>
                        <td>{{ $eg->nomEmp }} {{ $eg->apeEmp }}</td>
                    </tr>    
                @endforeach
                    <tr>
                        <td></td>
                        <td></td>
                        <td>
                            TOTAL
                        </td>
                        <td>
                            @foreach ($sumEgreso as $se)
                                {{ $se->monto }}
                            @endforeach
                        </td>
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

        </div>
    </div>
</div>

<div class="col-lg-6">
    <div class="ibox ">
        <div class="ibox-title">
            <h5>Caja Entrada</h5>
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
                        <th>Concepto</th>
                        <th>Cliente</th>
                        <th>Fecha de Transcaccion</th>
                        <th>Monto</th>
                        <th>Usuario</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($ingreso as $ing)
                    <tr>
                        <td>{{ $ing->concepto }}</td>
                        <td>{{ $ing->nomCli }} {{ $ing->apeCli }}</td>
                        <td>{{ $pro->cambiaf_a_espanol($ing->fecha) }}</td>
                        <td>{{ $ing->importe }}</td>
                        <td>{{ $ing->nomEmp }} {{ $ing->apeEmp }}</td>
                    </tr>    
                @endforeach
                    <tr>
                        <td></td>
                        <td></td>
                        <td>
                            TOTAL
                        </td>
                        <td>
                            @foreach ($sumIngreso as $si)
                                {{ $si->monto }}
                            @endforeach
                        </td>
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

        </div>
    </div>
</div>