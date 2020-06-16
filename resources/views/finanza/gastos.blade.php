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
                <h5>All form elements <small>With custom checbox and radion elements.</small></h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-wrench"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#" class="dropdown-item">Config option 1</a>
                        </li>
                        <li><a href="#" class="dropdown-item">Config option 2</a>
                        </li>
                    </ul>
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
                                                    <td>
                                                        <a href="{{ $cg->documento }}" title="{{ $cg->concepto }}" data-gallery="" >
                                                            <img src="{{ $cg->documento }}"  width="60" height="60">
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div id="blueimp-gallery" class="blueimp-gallery">
                                    <div class="slides"></div>
                                    <h3 class="title"></h3>
                                    <a class="prev">‹</a>
                                    <a class="next">›</a>
                                    <a class="close">×</a>
                                    <a class="play-pause"></a>
                                    <ol class="indicator"></ol>
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

        function guardarGasto() {
            var serie = $("#serComprobante").val();
            var monto = $("#monto").val();
            var concepto = $("#concepto").val();

            $.post( "{{ Route('guardarGasto') }}", {serie: serie, monto: monto, concepto: concepto, _token:'{{csrf_token()}}'}).done(function(data) {
                $("#gastosCc").empty();
                $("#gastosCc").html(data.pagos);
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
    </script>
@endsection