@extends('layouts.app')
@section('pagina')
    Inicio
@endsection
@section('contenido')

@php
    $pro = app('App\Models\Proceso');
@endphp

@if ($pro->validarRol("ROOT"))
    <div class="row  border-bottom white-bg dashboard-header">
    @foreach ($sucursales as $index => $sucursal)
        <div class="col-lg-4">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>{{ $sucursal->nombre }}</h5>
                    <div class="ibox-tools">
                        <a class="close-link" href="">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row m-t-xs">
                                <div class="col-6">
                                    <h5 class="m-b-xs">Ingresos Caja</h5>
                                    <h1 class="no-margins">{{ $ingresos[$index] }}</h1>
                                    <div class="font-bold text-navy">98% <i class="fa fa-bolt"></i></div>
                                </div>
                                <div class="col-6">
                                    <h5 class="m-b-xs">Egresos Caja</h5>
                                    <h1 class="no-margins">{{ $egresos[$index] }}</h1>
                                    <div class="font-bold text-navy">98% <i class="fa fa-bolt"></i></div>
                                </div>
                            </div>

                            <table class="table small m-t-sm">
                                <tbody>
                                <tr>
                                    <td>
                                        <strong>{{ $clientes[$index] }}</strong> Clientes

                                    </td>
                                    <td>
                                        <strong>{{ $desembolsos[$index] }}</strong> Desembolsos
                                    </td>

                                </tr>
                                <tr>
                                    <td>
                                        <strong>{{ $prestamos[$index] }}</strong> Prestamos
                                    </td>
                                    <td>
                                        <strong>{{ $renovados[$index] }}</strong> Renovaciones
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>{{ $liquidaciones[$index] }}</strong> Liquidaciones
                                    </td>
                                    <td>
                                        <strong>{{ $vendidos[$index] }}</strong> Vendidos
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                </div>
            </div>
        </div>    
    @endforeach
</div>

@endif

<div class="row  border-bottom white-bg dashboard-header">

        

</div>

<div class="modal inmodal" id="crearCaja" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated flipInY">
            <div class="modal-header">
                <h4 class="modal-title">Crear Caja </h4>
                <small class="font-bold">Es la primera vez, que va a configurar la caja.</small>
            </div>
            <div class="modal-body">
                <input type="text" placeholder="S/. 12000.00" class="form-control" id="montoCaja" name="montoCaja">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="crearCaja()">Aceptar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal inmodal" id="abrirCaja" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated flipInY">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Abrir Caja</h4>
                <small class="font-bold">Antes que nada, debe abrir la caja del día.</small>
            </div>
            <div class="modal-body">
                <strong>Fecha de Ultima Caja: </strong>
                <input type="text" placeholder="Ingrese dni" class="form-control" id="fecUltimaCaja" name="fecUltimaCaja" readonly>

                <strong>Monto de Cierre: </strong>
                <input type="text" placeholder="Ingrese dni" class="form-control" id="montoUltimaCaja" name="montoUltimaCaja" readonly>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="abrirCaja()">Abrir</button>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')

    <script src="{{asset('js/plugins/jasny/jasny-bootstrap.min.js')}}"></script>

    <script>

        window.onload = function() {
            verificarUltimoDiaDelMes();
            $.post( "{{ Route('verificarCaja') }}", {_token:'{{csrf_token()}}'}).done(function(data) {
                if (data.resp == "sincaja") {
                    $('#crearCaja').modal('show');
                }else if (data.resp == "cerrada") {
                    $('#abrirCaja').modal('show');
                    $("#fecUltimaCaja").val(data.fecha);
                    $("#montoUltimaCaja").val(data.monto);  
                }else if (data.resp == "abierta") {
                    
                }
            });
        };
        
        setInterval(verificarUltimoDiaDelMes, 3600000); // Ejecutar cada hora (3600 segundos)
        
        function verificarUltimoDiaDelMes() {
          const fechaActual = new Date();
          const ultimoDiaDelMes = new Date(fechaActual.getFullYear(), fechaActual.getMonth() + 1, 0);
          if (fechaActual.getDate() === ultimoDiaDelMes.getDate()) {
            miFuncionMensual();
          } 
        }
        
        function miFuncionMensual() {
          $.post( "{{ Route('cerrarControlPatrimonio') }}", {_token:'{{csrf_token()}}'}).done(function(data) {
                if (data.resp == 1) {
                    toastr.success('Cierre Correcto', 'Control Patrimonial');
                }
            });
        }

        function crearCaja(){
            var monto = $("#montoCaja").val();

            $.post( "{{ Route('crearCaja') }}", {monto: monto, _token:'{{csrf_token()}}'}).done(function(data) {
                $('#crearCaja').modal('hide');
                setTimeout(function() {
                    toastr.options = {
                        closeButton: true,
                        progressBar: true,
                        showMethod: 'slideDown',
                        timeOut: 4000
                    };
                    toastr.success('CAJA inicializada', 'Continue Trabajando');

                }, 1300);

            });
        }

        function abrirCaja(){
            var monto = $("#montoUltimaCaja").val();
            $.post( "{{ Route('abrirCajaHome') }}", { monto: monto, _token:'{{csrf_token()}}'}).done(function(data) {
                $('#abrirCaja').modal('hide');
                setTimeout(function() {
                    toastr.options = {
                        closeButton: true,
                        progressBar: true,
                        showMethod: 'slideDown',
                        timeOut: 4000
                    };
                    toastr.success('CAJA inicializada', 'Continue Trabajando');

                }, 1300);

            });
        }

            
    </script>
@endsection
