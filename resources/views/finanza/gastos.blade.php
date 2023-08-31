@extends('layouts.app')
@section('pagina')
    Gastos Administrativos  
@endsection
@section('contenido')       
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Gastos Administrativos</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ Route('home') }}">Inicio</a>
            </li>
            <li class="breadcrumb-item">
                <a>Administración</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Gastos Administrativos</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Historial de gastos</h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                    <a class="close-link">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content">
                <div class="col-lg-12">
                    <div class="tabs-container">
                        <ul class="nav nav-tabs">
                            <li><a class="nav-link active" data-toggle="tab" href="#tab-3"> <i class="fa fa-laptop"></i></a></li>
                            <li><a class="nav-link" data-toggle="tab" href="#tab-4"><i class="fa fa-desktop"></i></a></li>
                            <li><a class="nav-link" data-toggle="tab" href="#tab-5"><i class="fa fa-bank"></i></a></li>
                        </ul>
                        <div class="tab-content">
                            <div id="tab-3" class="tab-pane active">
                                <div class="panel-body">
                                    <strong>Registrar Gastos Caja Chica</strong>
                                    <div class="hr-line-dashed"></div>
                                    <div class="form-group  row">
                                        <div class="col-lg-6 row">
                                            <label class="col-sm-2 col-form-label">Serie de Comprobante</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="serComprobante">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 row">
                                            <label class="col-sm-4 col-form-label">Monto de Comprobante</label>
                                            <div class="input-group m-b col-sm-8">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-addon">S/.</span>
                                                </div>
                                                <input type="num" class="form-control" id="monto">
                                                <div class="input-group-append">
                                                    <span class="input-group-addon">.00</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group  row">
                                        <div class="col-lg-12 row">
                                            <label class="col-sm-4 col-form-label">Concepto de Comprobante</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="concepto">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="hr-line-dashed"></div>
                                    <div class="form-group row">
                                        <div class="col-sm-4 col-sm-offset-2">
                                            <button class="btn btn-white btn-sm" type="submit">Limpiar</button>
                                            <button class="btn btn-primary btn-sm" onclick="guardarGasto()">Registrar</button>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-12">
                                        <div class="ibox ">
                                            <div class="ibox-title">
                                                <h5>Historial ANUAL de Gastos en Caja Chica </h5>
                                                <div class="ibox-tools">
                                                    <a class="collapse-link">
                                                        <i class="fa fa-chevron-up"></i>
                                                    </a>
                                                    <a class="close-link">
                                                        <i class="fa fa-times"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="ibox-content" id="tabHistAnualCajaChica" >
                            
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            @foreach($historialAnualCajaChica AS $hacc)
                                                            <th>{{ $hacc->anio }}</th>
                                                            @endforeach()
                                                        </tr>
                                                        
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        @foreach($historialAnualCajaChica AS $hacc)
                                                        <td class="text-navy"> S/. {{ $hacc->monto }} </td>
                                                        @endforeach()
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="ibox ">
                                            <div class="ibox-title">
                                                <h5>Historial de Gastos en Caja Chica </h5>
                                                <div class="ibox-tools">
                                                    <a class="collapse-link">
                                                        <i class="fa fa-chevron-up"></i>
                                                    </a>
                                                    <a class="close-link">
                                                        <i class="fa fa-times"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="ibox-content" id="tabHistGastoCajaChica">
                            
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th onclick="verHistorialDia('1')">ENERO</th>
                                                            <th onclick="verHistorialDia('2')">FEBRERO</th>
                                                            <th onclick="verHistorialDia('3')">MARZO</th>
                                                            <th onclick="verHistorialDia('4')">ABRIL</th>
                                                            <th onclick="verHistorialDia('5')">MAYO</th>
                                                            <th onclick="verHistorialDia('6')">JUNIO</th>
                                                            <th onclick="verHistorialDia('7')">JULIO</th>
                                                            <th onclick="verHistorialDia('8')">AGOSTO</th>
                                                            <th onclick="verHistorialDia('9')">SEPTIEMBRE</th>
                                                            <th onclick="verHistorialDia('10')">OCTUBRE</th>
                                                            <th onclick="verHistorialDia('11')">NOVIEMBRE</th>
                                                            <th onclick="verHistorialDia('12')">DICIEMBRE</th>
                                                            <th>TOTAL</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td class="text-navy" onclick="verHistorialDia('1')">{{ $montoCaja[1] }}</td>
                                                        <td class="text-navy" onclick="verHistorialDia('2')">{{ $montoCaja[2] }}</td>
                                                        <td class="text-navy" onclick="verHistorialDia('3')">{{ $montoCaja[3] }}</td>
                                                        <td class="text-navy" onclick="verHistorialDia('4')">  {{ $montoCaja[4] }} </td>
                                                        <td class="text-navy" onclick="verHistorialDia('5')">  {{ $montoCaja[5] }} </td>
                                                        <td class="text-navy" onclick="verHistorialDia('6')">  {{ $montoCaja[6] }} </td>
                                                        <td class="text-navy" onclick="verHistorialDia('7')">  {{ $montoCaja[7] }} </td>
                                                        <td class="text-navy" onclick="verHistorialDia('8')">  {{ $montoCaja[8] }} </td>
                                                        <td class="text-navy" onclick="verHistorialDia('9')">  {{ $montoCaja[9] }} </td>
                                                        <td class="text-navy" onclick="verHistorialDia('10')">  {{ $montoCaja[10] }} </td>
                                                        <td class="text-navy" onclick="verHistorialDia('11')">  {{ $montoCaja[11] }} </td>
                                                        <td class="text-navy" onclick="verHistorialDia('12')">  {{ $montoCaja[12] }} </td>
                                                        <td class="text-navy">  {{ $montoCaja[1] + $montoCaja[2] + $montoCaja[3] + $montoCaja[4] + $montoCaja[5] + $montoCaja[6] + $montoCaja[7] + $montoCaja[8] + $montoCaja[9] + $montoCaja[10] + $montoCaja[11] + $montoCaja[12] }} </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="ibox-content" id="gastosCc">

                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>SERIE</th>
                                            <th>CONCEPTO</th>
                                            <th>MONTO</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($cajaChica as $cc)
                                                <tr>
                                                    <td>{{ $cc->codigo }}</td>
                                                    <td>{{ $cc->serie }}</td>
                                                    <td>{{ $cc->concepto }}</td>
                                                    <td class="text-navy"> <i class="fa fa-level-up"></i> {{ $cc->monto }} </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div id="tab-4" class="tab-pane">
                                <div class="panel-body">
                                    <form id="fpagosGa" name="fpagosGa" method="post" action="guardarPagoGa" class="formPagoGa" enctype="multipart/form-data">
                                        <input type="text" name="_token" id="_token" hidden value="{{ csrf_token() }}">
                                    <strong>Registrar Gastos Caja Grande</strong>
                                    <div class="hr-line-dashed"></div>
                                    <div class="col-lg-12 row">
                                        <label class="col-sm-2 col-form-label">Tipo de Pago</label>
                                        <div class="col-sm-10">
                                            <select class="form-control m-b" name="conceptoCG" id="conceptoCG">
                                                <option value="Pago Personal">Pago Personal</option>
                                                <option value="Pago Alquiler">Pago de Alquiler</option>
                                                <option value="Pago Internet">Pago de Servicio de Internet</option>
                                                <option value="Utiles Escritorio">Útiles de Escritorio y Otros</option>
                                                <option value="Tarjeta BCP">Creditos Bancarios</option>
                                                <option value="Luz">Servicio de Luz y Mantenimiento</option>
                                                <option value="Impuesto">Impuestos</option>
                                                <option value="Otro">Otros</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-12 row"> 
                                        <div class="col-lg-6 row">
                                            <label class="col-sm-4 col-form-label">N° Serie</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="comprobanteCG" name="comprobanteCG">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 row">
                                            <label class="col-sm-5 col-form-label">Monto</label>
                                            <div class="input-group m-b col-sm-7">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-addon">S/.</span>
                                                </div>
                                                <input type="num" class="form-control" id="montoCG" name="montoCG">
                                                <div class="input-group-append">
                                                    <span class="input-group-addon">.00</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-6 row">
                                            <label class="col-sm-4 col-form-label">Concepto</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="garantiaCG" name="garantiaCG">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 row">
                                            <div class="col-sm-12">
                                                <div class="custom-file">
                                                    <input id="recibo" type="file" class="custom-file-input" name="recibo">
                                                    <label for="logo" class="custom-file-label">Subir Recibo...</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="hr-line-dashed"></div>
                                    <div class="form-group row">
                                        <div class="col-sm-12 col-sm-offset-2">
                                            <button class="btn btn-white btn-sm" type="submit">Limpiar</button>
                                            <button class="btn btn-primary btn-sm" type="submit">Registrar</button>
                                        </div>
                                    </div>
                                    </form>
                                </div>
                                
                                <div class="col-lg-12">
                                        <div class="ibox ">
                                            <div class="ibox-title">
                                                <h5>Historial ANUAL de Gastos en Caja Grande </h5>
                                                <div class="ibox-tools">
                                                    <a class="collapse-link">
                                                        <i class="fa fa-chevron-up"></i>
                                                    </a>
                                                    <a class="close-link">
                                                        <i class="fa fa-times"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="ibox-content">
                            
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            @foreach($historialAnualCajaGrande AS $hacg)
                                                            <th>{{ $hacg->anio }}</th>
                                                            @endforeach()
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        @foreach($historialAnualCajaGrande AS $hacg)
                                                        <td class="text-navy">S/.  {{ $hacg->monto }} </td>
                                                        @endforeach()
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                <div class="col-lg-12">
                                    <div class="ibox ">
                                        <div class="ibox-title">
                                            <h5>Historial de Gastos en Caja Grande </h5>
                                            <div class="ibox-tools">
                                                <a class="collapse-link">
                                                    <i class="fa fa-chevron-up"></i>
                                                </a>
                                                <a class="close-link">
                                                    <i class="fa fa-times"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="ibox-content">
                        
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th onclick="verHistorialCGDia('1')">ENERO</th>
                                                        <th onclick="verHistorialCGDia('2')">FEBRERO</th>
                                                        <th onclick="verHistorialCGDia('3')">MARZO</th>
                                                        <th onclick="verHistorialCGDia('4')">ABRIL</th>
                                                        <th onclick="verHistorialCGDia('5')">MAYO</th>
                                                        <th onclick="verHistorialCGDia('6')">JUNIO</th>
                                                        <th onclick="verHistorialCGDia('7')">JULIO</th>
                                                        <th onclick="verHistorialCGDia('8')">AGOSTO</th>
                                                        <th onclick="verHistorialCGDia('9')">SEPTIEMBRE</th>
                                                        <th onclick="verHistorialCGDia('10')">OCTUBRE</th>
                                                        <th onclick="verHistorialCGDia('11')">NOVIEMBRE</th>
                                                        <th onclick="verHistorialCGDia('12')">DICIEMBRE</th> 
                                                        <th>TOTAL</th> 
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td class="text-navy" onclick="verHistorialCGDia('1')">{{ $montoCajaGrande[1] }}</td>
                                                    <td class="text-navy" onclick="verHistorialCGDia('2')">{{ $montoCajaGrande[2] }}</td>
                                                    <td class="text-navy" onclick="verHistorialCGDia('3')">{{ $montoCajaGrande[3] }}</td>
                                                    <td class="text-navy" onclick="verHistorialCGDia('4')">  {{ $montoCajaGrande[4] }} </td>
                                                    <td class="text-navy" onclick="verHistorialCGDia('5')">  {{ $montoCajaGrande[5] }} </td>
                                                    <td class="text-navy" onclick="verHistorialCGDia('6')">  {{ $montoCajaGrande[6] }} </td>
                                                    <td class="text-navy" onclick="verHistorialCGDia('7')">  {{ $montoCajaGrande[7] }} </td>
                                                    <td class="text-navy" onclick="verHistorialCGDia('8')">  {{ $montoCajaGrande[8] }} </td>
                                                    <td class="text-navy" onclick="verHistorialCGDia('9')">  {{ $montoCajaGrande[9] }} </td>
                                                    <td class="text-navy" onclick="verHistorialCGDia('10')">  {{ $montoCajaGrande[10] }} </td>
                                                    <td class="text-navy" onclick="verHistorialCGDia('11')">  {{ $montoCajaGrande[11] }} </td>
                                                    <td class="text-navy" onclick="verHistorialCGDia('12')">  {{ $montoCajaGrande[12] }} </td>
                                                    <td class="text-navy">  {{ $montoCajaGrande[1] + $montoCajaGrande[2] + $montoCajaGrande[3] + $montoCajaGrande[4] + $montoCajaGrande[5] + $montoCajaGrande[6] + $montoCajaGrande[7] + $montoCajaGrande[8] + $montoCajaGrande[9] + $montoCajaGrande[10] + $montoCajaGrande[11] + $montoCajaGrande[12] }} </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="ibox-content" id="pagosCg">

                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>SERIE</th>
                                            <th>TIPO DE PAGO</th>
                                            <th>DETALLE</th>
                                            <th>MONTO</th>
                                            <th>RECIBO</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($cajaGrande as $cg)
                                                <tr>
                                                    <td>{{ $cg->codigo }}</td>
                                                    <td>{{ $cg->serie }}</td>
                                                    <td>{{ $cg->concepto }}</td>
                                                    <td>{{ $cg->garantia }}</td>
                                                    <td class="text-navy"> <i class="fa fa-level-up"></i> {{ $cg->monto }} </td>
                                                    
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            
                            
                            <div id="tab-5" class="tab-pane">
                                <div class="panel-body">
                                    <form id="fpagosBa" name="fpagosBa" method="post" action="guardarPagoBa" class="formPagoBa" enctype="multipart/form-data">
                                        <input type="text" name="_token" id="_token" hidden value="{{ csrf_token() }}">
                                    <strong>Registrar Gastos de Bancos</strong>
                                    <div class="hr-line-dashed"></div>
                                    
                                    <div class="col-lg-12 row">
                                        <label class="col-sm-2 col-form-label">Bancos</label>
                                        <div class="col-sm-10">
                                            <select class="form-control m-b" name="codigoBanco" id="codigoBanco">
                                                <option value="Pago Personal">Selecciona un banco...</option>
                                                @foreach($listaBancos as $lb)
                                                <option value="{{ $lb->caja_id }}">{{ $lb->tipo }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group col-lg-12 row"> 
                                        <div class="col-lg-6 row">
                                            <label class="col-sm-4 col-form-label">N° Serie</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="comprobanteBanco" name="comprobanteBanco">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 row">
                                            <label class="col-sm-5 col-form-label">Monto</label>
                                            <div class="input-group m-b col-sm-7">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-addon">S/.</span>
                                                </div>
                                                <input type="num" class="form-control" id="montoBanco" name="montoBanco">
                                                <div class="input-group-append">
                                                    <span class="input-group-addon">.00</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-6 row">
                                            <label class="col-sm-4 col-form-label">Concepto</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="conceptoBanco" name="conceptoBanco">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 row">
                                            <div class="col-sm-12">
                                                <div class="custom-file">
                                                    <input id="reciboBanco" type="file" class="custom-file-input" name="reciboBanco">
                                                    <label for="logo" class="custom-file-label">Subir Recibo...</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="hr-line-dashed"></div>
                                    <div class="form-group row">
                                        <div class="col-sm-12 col-sm-offset-2">
                                            <button class="btn btn-white btn-sm" type="submit">Limpiar</button>
                                            <button class="btn btn-primary btn-sm" type="submit">Registrar</button>
                                        </div>
                                    </div>
                                    </form>
                                </div>
                                
                                <div class="col-lg-12">
                                        <div class="ibox ">
                                            <div class="ibox-title">
                                                <h5>Historial ANUAL de Gastos con Banco </h5>
                                                <div class="ibox-tools">
                                                    <a class="collapse-link">
                                                        <i class="fa fa-chevron-up"></i>
                                                    </a>
                                                    <a class="close-link">
                                                        <i class="fa fa-times"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="ibox-content">
                            
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            @foreach($historialAnualBanco AS $hab)
                                                            <th>{{ $hab->anio }}</th>
                                                            @endforeach()
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        @foreach($historialAnualBanco AS $hab)
                                                        <td class="text-navy">S/.  {{ $hab->monto }} </td>
                                                        @endforeach()
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                <div class="col-lg-12">
                                    <div class="ibox ">
                                        <div class="ibox-title">
                                            <h5>Historial de Gastos con Banco </h5>
                                            <div class="ibox-tools">
                                                <a class="collapse-link">
                                                    <i class="fa fa-chevron-up"></i>
                                                </a>
                                                <a class="close-link">
                                                    <i class="fa fa-times"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="ibox-content">
                        
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th onclick="verHistorialCGDia('1')">ENERO</th>
                                                        <th onclick="verHistorialCGDia('2')">FEBRERO</th>
                                                        <th onclick="verHistorialCGDia('3')">MARZO</th>
                                                        <th onclick="verHistorialCGDia('4')">ABRIL</th>
                                                        <th onclick="verHistorialCGDia('5')">MAYO</th>
                                                        <th onclick="verHistorialCGDia('6')">JUNIO</th>
                                                        <th onclick="verHistorialCGDia('7')">JULIO</th>
                                                        <th onclick="verHistorialCGDia('8')">AGOSTO</th>
                                                        <th onclick="verHistorialCGDia('9')">SEPTIEMBRE</th>
                                                        <th onclick="verHistorialCGDia('10')">OCTUBRE</th>
                                                        <th onclick="verHistorialCGDia('11')">NOVIEMBRE</th>
                                                        <th onclick="verHistorialCGDia('12')">DICIEMBRE</th> 
                                                        <th>TOTAL</th> 
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td class="text-navy" onclick="verHistorialCGDia('1')">{{ $montoBanco[1] }}</td>
                                                    <td class="text-navy" onclick="verHistorialCGDia('2')">{{ $montoBanco[2] }}</td>
                                                    <td class="text-navy" onclick="verHistorialCGDia('3')">{{ $montoBanco[3] }}</td>
                                                    <td class="text-navy" onclick="verHistorialCGDia('4')">  {{ $montoBanco[4] }} </td>
                                                    <td class="text-navy" onclick="verHistorialCGDia('5')">  {{ $montoBanco[5] }} </td>
                                                    <td class="text-navy" onclick="verHistorialCGDia('6')">  {{ $montoBanco[6] }} </td>
                                                    <td class="text-navy" onclick="verHistorialCGDia('7')">  {{ $montoBanco[7] }} </td>
                                                    <td class="text-navy" onclick="verHistorialCGDia('8')">  {{ $montoBanco[8] }} </td>
                                                    <td class="text-navy" onclick="verHistorialCGDia('9')">  {{ $montoBanco[9] }} </td>
                                                    <td class="text-navy" onclick="verHistorialCGDia('10')">  {{ $montoBanco[10] }} </td>
                                                    <td class="text-navy" onclick="verHistorialCGDia('11')">  {{ $montoBanco[11] }} </td>
                                                    <td class="text-navy" onclick="verHistorialCGDia('12')">  {{ $montoBanco[12] }} </td>
                                                    <td class="text-navy">  {{ $montoBanco[1] + $montoBanco[2] + $montoBanco[3] + $montoBanco[4] + $montoBanco[5] + $montoBanco[6] + $montoBanco[7] + $montoBanco[8] + $montoBanco[9] + $montoBanco[10] + $montoBanco[11] + $montoBanco[12] }} </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="ibox-content" id="pagosBa">

                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>SERIE</th>
                                            <th>BANCO</th>
                                            <th>DETALLE</th>
                                            <th>MONTO</th>
                                            <th>RECIBO</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($historialBanco as $hb)
                                                <tr>
                                                    <td>{{ $hb->codigo }}</td>
                                                    <td>{{ $hb->banco }}</td>
                                                    <td>{{ $hb->concepto }}</td>
                                                    <td>{{ $hb->garantia }}</td>
                                                    <td class="text-navy"> <i class="fa fa-level-up"></i> {{ $hb->monto }} </td>
                                                    <td>
                                                        <a href="{{ $hb->documento }}" title="{{ $hb->concepto }}" data-gallery="" >
                                                            <img src="{{ $hb->documento }}"  width="60" height="60">
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
   <script src="js/plugins/blueimp/jquery.blueimp-gallery.min.js"></script>
   <link href="css/plugins/blueimp/css/blueimp-gallery.min.css" rel="stylesheet">
    <script>

        $(document).ready(function(){

            $('.custom-file-input').on('change', function() {
                let fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').addClass("selected").html(fileName);
            });

        });
        
        function verHistorialCGDia(mes){
            $.post( "{{ Route('verHistorialGastosCGDia') }}", {mes: mes, _token:'{{csrf_token()}}'}).done(function(data) {
                $("#pagosCg").empty();
                $("#pagosCg").html(data.view);
            });
        }

        function verHistorialDia(mes){
            $.post( "{{ Route('verHisrialGastosDia') }}", {mes: mes, _token:'{{csrf_token()}}'}).done(function(data) {
                $("#gastosCc").empty();
                $("#gastosCc").html(data.view);
            });
        }

        function guardarGasto() {
            var serie = $("#serComprobante").val();
            var monto = $("#monto").val();
            var concepto = $("#concepto").val();

            $.post( "{{ Route('guardarGasto') }}", {serie: serie, monto: monto, concepto: concepto, _token:'{{csrf_token()}}'}).done(function(data) {
                $("#gastosCc").empty();
                $("#gastosCc").html(data.pagos);
                
                $("#tabHistAnualCajaChica").empty();
                $("#tabHistAnualCajaChica").html(data.hitoriaCaja);
                
                $("#tabHistGastoCajaChica").empty();
                $("#tabHistGastoCajaChica").html(data.historiaMesCaja);
                
                toastr.success('Gasto Registrado Correctamente', 'CORRECTO');
                $("#serComprobante").val("");
                $("#monto").val("");
                $("#concepto").val("");
            });
        }

        $(document).on("submit",".formPagoGa",function(e){
        
            e.preventDefault();
            var formu = $(this);
            var nombreform = $(this).attr("id");
            
            if (nombreform == "fpagosGa") {
                var miurl = "{{ Route('guardarGastosCG') }}";
            }
            var formData = new FormData($("#"+nombreform+"")[0]);
            
            $.ajax({ url: miurl, type: 'POST', data: formData, cache: false, contentType: false, processData: false,
                    beforeSend: function(){
                        toastr.info('Subiendo Archivos, por favor espere', 'ESPERE');
                    },
                    success: function(data){
                        $("#pagosCg").empty();
                        $("#pagosCg").html(data.pagos);
                        toastr.success('Pago registrado correctamente', 'CORRECTO');
                        
                    },
                    error: function(data) {
                        toastr.error('Error al registrar el cliente', 'ERROR');
                    }
            });
        });
        
        $(document).on("submit",".formPagoBa",function(e){
        
            e.preventDefault();
            var formu = $(this);
            var nombreform = $(this).attr("id");
            
            if (nombreform == "fpagosBa") {
                var miurl = "{{ Route('guardarGastosBanco') }}";
            }
            var formData = new FormData($("#"+nombreform+"")[0]);
            
            $.ajax({ url: miurl, type: 'POST', data: formData, cache: false, contentType: false, processData: false,
                    beforeSend: function(){
                        toastr.info('Subiendo Archivos, por favor espere', 'ESPERE');
                    },
                    success: function(data){
                        $("#pagosBa").empty();
                        $("#pagosBa").html(data.pagos);
                        toastr.success('Pago registrado correctamente', 'CORRECTO');
                        
                    },
                    error: function(data) {
                        toastr.error('Error al registrar el cliente', 'ERROR');
                    }
            });
        });
    </script>
@endsection