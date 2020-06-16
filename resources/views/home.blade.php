@extends('layouts.app')
@section('pagina')
    Inicio
@endsection
@section('contenido')

<div class="row  border-bottom white-bg dashboard-header" >
    @foreach ($informes as $if)
        <div class="col-lg-4" style="background-image: url('img/INVEF.jpg'); background-size: cover;">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>{{ $if->credito }}</h5>
                    <div class="ibox-tools">
                        <a class="close-link" href="">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div>
    
                        <div class="float-right text-right">

                        </div>
                        <h4>Resumen: {{ $if->resumen }}
                            <br/>
                            <small class="m-r">Requerimientos: {{ $if->requisito }},  </small>
                        </h4>
                        </div>
                    </div>
                </div>
        </div>    
    @endforeach
</div>

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


        setTimeout(function() {
                toastr.options = {
                    closeButton: true,
                    progressBar: true,
                    showMethod: 'slideDown',
                    timeOut: 4000
                };
                toastr.success('Admin', 'Bienvendio a Invef');

            }, 1300);

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
