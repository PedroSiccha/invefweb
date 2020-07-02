@extends('layouts.app')
@section('pagina')
    Control Patrimonial
@endsection
@section('contenido')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Control Patrimonial</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">Inicio</a>
            </li>
            <li class="breadcrumb-item">
                <a>Finanzas</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Control Patrimonial</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">
        
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Inventario de Equipos y Muebles</h5>
                    <div class="ibox-tools">
                        <button type="button" class="btn btn-outline btn-success" onclick="nuevoInventario()">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="ibox-content" id="tabMueble">

                    <table class="table">
                        <thead>
                        <tr>
                            <th>Cantidad</th>
                            <th>Detalles</th>
                            <th>Valor</th>
                            <th>Gestión</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($equipo as $e)
                                <tr>
                                    <td>{{ $e->unidad }}</td>
                                    <td>{{ $e->nombre }} {{ $e->marca }}</td>
                                    <td>{{ $e->valor }}</td>
                                    <td>
                                        <button type="button" class="btn btn-warning" onclick="editarInventario('{{ $e->idinventario }}', '{{ $e->unidad }}', '{{ $e->nombre }}', '{{ $e->marca }}', '{{ $e->valor }}')">
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger" onclick="bajaInventario('{{ $e->idinventario }}', '{{ $e->unidad }}', '{{ $e->nombre }}', '{{ $e->marca }}', '{{ $e->valor }}')">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <td></td>
                                <td>TOTAL</td>
                                <td>S/. {{ $totalInventario[0]->total }} </td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>ACTIVOS</h5>
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

                    <table class="table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Categoria</th>
                            <th>Artículo</th>
                            <th>Valor</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>1</td>
                            <td>Inversiones</td>
                            <td>Prestamos Colocados</td>
                            <td>S/. 
                                <?php 
                                    if ($prestamoColocado[0]->monto == null) {
                                        echo("0.00");
                                    }else {
                                        echo($prestamoColocado[0]->monto);
                                    }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Inversiones</td>
                            <td>Liquidaciones en Venta</td>
                            <td>S/. 
                                <?php 
                                    if ($liquidacion[0]->monto == null) {
                                        echo("0.00");
                                    }else {
                                        echo($liquidacion[0]->monto);
                                    }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Efectivo</td>
                            <td>Caja Chica</td>
                            <td>S/. {{ $cajaChica[0]->monto }} </td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Efectivo</td>
                            <td>Caja Grande</td>
                            <td>S/. {{ $cajaGrande[0]->monto }} </td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>Efectivo</td>
                            <td>Bancos BCP</td>
                            <td>S/. {{ $cajaBanco[0]->monto }} </td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td>Propiedad Personal</td>
                            <td>Equipos y Muebles</td>
                            <td id="activosMueble">S/. 
                                <?php 
                                    if ($totalInventario[0]->total == null) {
                                        echo("0.00");
                                    }else {
                                        echo($totalInventario[0]->total);
                                    }
                                ?>
                        </tr>
                        <tr>
                            <td>7</td>
                            <td>Propiedad de la Empresa</td>
                            <td>Software de Sistema</td>
                            <td>S/. 
                                <?php 
                                    if ($software[0]->valor == null) {
                                        echo("0.00");
                                    }else {
                                        echo($software[0]->valor);
                                    }
                                ?>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>DEUDAS</h5>
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

                    <table class="table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Categoría</th>
                            <th>Concepto</th>
                            <th>Valor</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>1</td>
                            <td>Gastos Administrativos</td>
                            <td>Pago de Personal</td>
                            <td>S/. {{ $pagoPersonal[0]->monto }}</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Gastos Administrativos</td>
                            <td>Pago de Alquiler</td>
                            <td>S/. {{ $pagoAlquiler[0]->monto }}</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Gastos Administrativos</td>
                            <td>Pago de Servicio de Internet</td>
                            <td>S/. {{ $pagoInternet[0]->monto }}</td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Gastos Administrativos</td>
                            <td>Utilides de Escritorio y Otros</td>
                            <td>S/. {{ $utilesEscritorio[0]->monto }}</td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>Gastos Administrativos</td>
                            <td>Publicidad</td>
                            <td>S/. {{ $publicidad[0]->monto }}</td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td>Gastos Administrativos</td>
                            <td>Tarjeta de Crédito BCP</td>
                            <td>S/. {{ $tarjetaBCP[0]->monto }}</td>
                        </tr>
                        <tr>
                            <td>7</td>
                            <td>Gastos Administrativos</td>
                            <td>Servicio de Luz y Mantenimiento</td>
                            <td>S/. {{ $luz[0]->monto }}</td>
                        </tr>
                        <tr>
                            <td>8</td>
                            <td>Gastos Administrativos</td>
                            <td>SUNAT</td>
                            <td>S/. {{ $impuesto[0]->monto }}</td>
                        </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>PATRIMONIO NETO</h5>
                </div>
                <div class="ibox-content">

                    <table class="table">
                        <tbody>
                            <?php
                                $activosTotales = $prestamoColocado[0]->monto + $liquidacion[0]->monto + $cajaChica[0]->monto + $totalInventario[0]->total + $software[0]->valor + $cajaGrande[0]->monto + $cajaBanco[0]->monto;
                                $deudasTotales = $pagoPersonal[0]->monto + $pagoAlquiler[0]->monto + $pagoInternet[0]->monto + $utilesEscritorio[0]->monto + $publicidad[0]->monto + $tarjetaBCP[0]->monto + $luz[0]->monto + $impuesto[0]->monto;
                                $patrimonioNeto = $activosTotales - $deudasTotales;
                            ?>
                            <tr>
                                <td>ACTIVOS TOTALES</td>
                                <td>S/. {{ $activosTotales }}</td>
                                <input type="text" id="activosTotales" value="{{ $activosTotales }}" hidden>
                            </tr>
                            <tr>
                                <td>DEUDAS TOTALES</td>
                                <td>S/. {{ $deudasTotales }}</td>
                                <input type="text" id="deudasTotales" value="{{ $deudasTotales }}" hidden>
                            </tr>
                            <tr>
                                <td>PATRIMONIO NETO</td>
                                <td>S/. {{ $patrimonioNeto }}</td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
        <canvas id="pie-chart" width="800" height="300"></canvas>
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-content">

                    <table class="table">
                        <tbody>
                            <tr>
                                <td>PRECIO POR ACTIVO</td>
                                <td>S/. {{ ROUND($patrimonioNeto/100, 2) }}</td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal inmodal fade" id="nuevoInventario" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">INVENTARIO</h4>
                <small class="font-bold">Registrar Nuevo.</small>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Tipo de Inventario</label>
                    <div class="col-sm-9">
                        <select class="form-control m-b" name="account" id="tipoinventario">
                            <option value="0">Seleccionar...</option>
                            @foreach ($tipoinventario as $ti)
                                <option value="{{ $ti->id }}">{{ $ti->tipo }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-12 form-group row">
                        <label class="col-sm-3 col-form-label">Nombre</label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="Nombre" class="form-control" id="nombreP">
                        </div>
                    </div>
                    <div class="col-sm-12 form-group row">
                        <label class="col-sm-3 col-form-label">Marca</label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="Marca" class="form-control" id="marcaP">
                        </div>
                    </div>
                    <div class="col-sm-12 form-group row">
                        <label class="col-sm-3 col-form-label">Unidad</label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="Cantidad de Muebles" class="form-control" id="unidadP">
                        </div>
                    </div>
                    <div class="col-sm-12 form-group row">
                        <label class="col-sm-3 col-form-label">Valor</label>
                        <div class="input-group m-b col-sm-9">
                            <div class="input-group-prepend">
                                <span class="input-group-addon">S/.</span>
                            </div>
                            <input type="text" placeholder="Valor por Unidad" class="form-control" id="valorP">
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="guardarPatrimonio()">Guardar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal inmodal fade" id="editInventario" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">INVENTARIO</h4>
                <small class="font-bold">Registrar Nuevo.</small>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-sm-12 form-group row">
                        <label class="col-sm-3 col-form-label">Nombre</label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="Nombre" class="form-control" id="nombreE">
                            <input type="text" placeholder="Nombre" class="form-control" id="idE" hidden>
                        </div>
                    </div>
                    <div class="col-sm-12 form-group row">
                        <label class="col-sm-3 col-form-label">Marca</label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="Marca" class="form-control" id="marcaE">
                        </div>
                    </div>
                    <div class="col-sm-12 form-group row">
                        <label class="col-sm-3 col-form-label">Unidad</label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="Cantidad de Muebles" class="form-control" id="unidadE">
                        </div>
                    </div>
                    <div class="col-sm-12 form-group row">
                        <label class="col-sm-3 col-form-label">Valor</label>
                        <div class="input-group m-b col-sm-9">
                            <div class="input-group-prepend">
                                <span class="input-group-addon">S/.</span>
                            </div>
                            <input type="text" placeholder="Valor por Unidad" class="form-control" id="valorE">
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="editarPatrimonio()">Guardar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal inmodal fade" id="elimInventario" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">INVENTARIO</h4>
                <small class="font-bold">Registrar Nuevo.</small>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-sm-12 form-group row">
                        <label class="col-sm-3 col-form-label">Nombre</label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="Nombre" class="form-control" id="nombreEl" readonly>
                            <input type="text" placeholder="Nombre" class="form-control" id="idEl" hidden>
                        </div>
                    </div>
                    <div class="col-sm-12 form-group row">
                        <label class="col-sm-3 col-form-label">Marca</label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="Marca" class="form-control" id="marcaEl" readonly>
                        </div>
                    </div>
                    <div class="col-sm-12 form-group row">
                        <label class="col-sm-3 col-form-label">Unidad</label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="Cantidad de Muebles" class="form-control" id="unidadEl">
                        </div>
                    </div>
                    <div class="col-sm-12 form-group row">
                        <label class="col-sm-3 col-form-label">Valor</label>
                        <div class="input-group m-b col-sm-9">
                            <div class="input-group-prepend">
                                <span class="input-group-addon">S/.</span>
                            </div>
                            <input type="text" placeholder="Valor por Unidad" class="form-control" id="valorEl" readonly>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="eliminPatrimonio()">ACEPTAR</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
    <script>
        $(document).ready(graficoPatrimonio);
        
        function graficoPatrimonio() {
            var activosTotales = $('#activosTotales').val();
            var deudasTotales = $('#deudasTotales').val();

            new Chart(document.getElementById("pie-chart"), {
                    type: 'pie',
                    data: {
                        labels: ["ACTIVOS", "DEUDAS"],
                        datasets: [{
                            label: "Population (millions)",
                            backgroundColor: ["#3e95cd", "#8e5ea2"],
                            data: [activosTotales,deudasTotales]
                        }]
                    },
                    options: {
                        title: {
                            display: true,
                            text: 'PATRIMONIO'
                        }
                    }
                });

        }


        function nuevoInventario() {
            $('#nuevoInventario').modal('show');

            
        }

        function editarInventario(id, unidad, nombre, marca, valor){
            $('#editInventario').modal('show');
            $('#idE').val(id);
            $('#unidadE').val(unidad);
            $('#nombreE').val(nombre);
            $('#marcaE').val(marca);
            $('#valorE').val(valor);
        }

        function bajaInventario(id, unidad, nombre, marca, valor){
            $('#elimInventario').modal('show');
            $('#idEl').val(id);
            $('#unidadEl').val(unidad);
            $('#nombreEl').val(nombre);
            $('#marcaEl').val(marca);
            $('#valorEl').val(valor);
        }

        function guardarPatrimonio() {
            
            var tipoinventario_id = $("#tipoinventario").val();
            var nombre = $("#nombreP").val();
            var marca = $("#marcaP").val();
            var unidad = $("#unidadP").val();
            var valor = $("#valorP").val();
            
            $.post( "{{ Route('registrarInventario') }}", {tipoinventario_id: tipoinventario_id, nombre: nombre, marca: marca, unidad: unidad, valor: valor, _token:'{{csrf_token()}}'}).done(function(data) {
                $('#nuevoInventario').modal('hide');
                if (data.resp == 1 ) {
                    toastr.success('Actualizacion de Inventario', 'CORRECTO');
                    $("#tabMueble").empty();
                    $("#tabMueble").html(data.view);
                    $("#activosMueble").empty();
                    $("#activosMueble").html(data.viewTi);
                }else{
                    toastr.error('No se pudo Actualizar el Inventario', 'ERROR');
                }
            });
            
        }
    </script>
@endsection
