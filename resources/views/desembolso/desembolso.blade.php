@php
    $pro = new App\proceso();
@endphp
@extends('layouts.app')
@section('pagina')
    DESEMBOLSO
@endsection
@section('contenido')
<div class="wrapper wrapper-content  animated fadeInRight"> 
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox">
                <div class="ibox-content">
                    <span class="text-muted small float-right">Ultima Modificación: <i class="fa fa-clock-o"></i> {{date( "g:i a") }} - {{ date("d/m/Y")}}</span>
                    <h2>Clientes</h2>
                    <p>
                        Clientes en cola de espera.
                    </p>
                    <div class="input-group">
                        <input type="text" placeholder="Buscar cliente... " class="input form-control" id="clienteBusqueda" onkeyup="buscarCliente()">
                        <span class="input-group-append">
                                <button type="button" class="btn btn btn-primary"> <i class="fa fa-search"></i> Buscar</button>
                        </span>
                    </div>
                    <div class="clients-list"  id="tabDesembolso">
                        <span class="float-right small text-muted">{{ $cantPrestamos }} Clientes</span>
                        <ul class="nav nav-tabs">
                            <li><a class="nav-link active" data-toggle="tab" href="#tab-1"><i class="fa fa-user"></i></a></li>
                        </ul>
                        <div class="tab-content">
                            <div id="tab-1" class="tab-pane active">
                                <div class="full-height-scroll">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Cod.</th>
                                                    <th>Nombres</th>
                                                    <th>DNI</th>
                                                    <th>Fecha de Prestamo</th>
                                                    <th>Entregar</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($prestamo as $pr)
                                                    <tr>
                                                        <td>{{ $pr->prestamo_id }}</td>
                                                        <td><a href="{{ Route('perfilCliente', [$pr->cliente_id]) }}">{{ $pr->nombre }} {{ $pr->apellido }}</a></td>
                                                        <td>{{ $pr->dni }}</td>
                                                        <td>{{ $pro->cambiaf_a_espanol($pr->created_at) }}</td>
                                                        <td><button type="button" class="btn btn-xs btn-success" onclick="tipoDesembolso('{{ $pr->prestamo_id }}')"><i class="fa fa-paper-plane-o"></i></button></td>
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
</div>

<div class="modal inmodal fade" id="deposito" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Renovar Prestamo</h4>
                <small class="font-bold">USTED CUENTA CON EL CRÉDITO DE:</small>
                <span id="verIdPrestamo">Modal title</span>
            </div>
            <div class="modal-body">
                <table class="table m-b-xs">
                    <tbody>
                        <tr>
                            <td>
                                <strong>BANCO</strong>
                            </td>
                            <td>
                                <select class="form-control m-b" name="account" id="banco">
                                    <option>Seleccionar Banco</option>
                                    @foreach($bancos as $b)
                                    <option value = "{{ $b->id }}">{{ $b->tipo }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Número de Cuenta</strong>
                            </td>
                            <td>
                                <input style='font-size: large;' type='text' class='form-control text-success' id='numCuenta'>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Descuento por Depósito</strong>
                            </td>
                            <td>
                                <input style='font-size: large;' type='text' class='form-control text-success' id='descCuenta' placeholder="LLenar solo si hay descuento por depósito" value="0.00">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-outline btn-success dim" data-dismiss="modal" onclick="realizarDeposito()"><i class="fa fa-money"></i> ACEPTAR</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>

        function buscarCliente(){   
            var dato = $("#clienteBusqueda").val();

            $.post( "{{ Route('buscarDesembolso') }}", {dato: dato, _token:'{{csrf_token()}}'}).done(function(data) {
                $("#tabDesembolso").empty();
                $("#tabDesembolso").html(data.view);
            });
        }

        function tipoDesembolso(id) {
            swal("Escoja el método de deposito:", {
                buttons: {
                    cancel: "Cancelar",
                    catch: {
                    text: "Efectivo",
                    value: "efectivo",
                    dangerMode: true,
                    },
                    deposito: {
                    text: "Deposito",
                    value: "deposito",
                    },
                    defeat: false,
                },
            })
            .then((value) => {
                switch (value) {
                
                    case "deposito":

                    $('#deposito').modal('show');
                    document.getElementById("verIdPrestamo").innerHTML="<input hidden style='font-size: large;' type='text' class='form-control text-success' id='idPrestamo' value='" +id+"'>";

                    break;
                
                    case "efectivo":
                        $.post( "{{ Route('desembolsar') }}", {id: id, _token:'{{csrf_token()}}'}).done(function(data) {
                            $("#tabDesembolso").empty();
                            $("#tabDesembolso").html(data.view);
                            swal("Desembolso", "Se realizó el desembolso correctamente!", "success");
                            console.log(data);
                            var desembolsoId = data.desembolso.id;
                            var url = '{{ route('printBoucherDesembolso', ['id' => ':id']) }}';
                            url = url.replace(':id', desembolsoId);
                            window.open(url, '_blank');
                        });
                    break;
                
                    default:
                    swal("Gracias!");
                }
            });
        }

        function realizarDeposito(){
           
            var cuenta = $("#numCuenta").val();
            var banco = $("#banco").val();
            var id = $("#idPrestamo").val();
            var descuento = $("#descCuenta").val();

            $.post( "{{ Route('desembolsarDeposito') }}", {cuenta: cuenta, banco: banco, id: id, descuento: descuento, _token:'{{csrf_token()}}'}).done(function(data) {
                $("#tabDesembolso").empty();
                $("#tabDesembolso").html(data.view);
                swal("Se hará el depósito en la cuenta:" + cuenta);
                console.log(data);
                var desembolsoId = data.desembolso.id;
                var url = '{{ route('printBoucherDesembolso', ['id' => ':id']) }}';
                url = url.replace(':id', desembolsoId);
                window.open(url, '_blank');
            });
            
        }
    </script>
@endsection
