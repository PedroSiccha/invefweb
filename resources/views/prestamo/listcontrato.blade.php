@extends('layouts.app')
@section('pagina')
    Lista de Contratos
@endsection
@section('contenido')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Gestión de Contratos</h5>
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
                <div class="input-group">
                    <input type="text" placeholder="Buscar clientes" class="input form-control" id="clienteBusqueda" onkeyup="buscarClientes()">
                    <span class="input-group-append">
                            <button type="button" class="btn btn btn-primary"> <i class="fa fa-search"></i> Buscar</button>
                    </span>
                </div>
            </div>
            
            <div class="ibox-content" id="divTipoPrestamo">
                <table class="footable table table-stripped toggle-arrow-tiny">
                    <thead>
                    <tr>
                        <th data-toggle="true">Cód</th>
                        <th>Nombres</th>
                        <th>DNI</th>
                        <th>Garantia</th>
                        <th>Fecha de Inicio</th>
                        <th>Action</th>
                    </tr> 
                    </thead>
                    <tbody>
                    @foreach ($prestamo as $pr)
                        <tr>
                            <td>{{ $pr->prestamo_id }}</td>
                            <td><a href="{{ Route('perfilCliente', [$pr->cliente_id]) }}">{{ $pr->nombre }} {{ $pr->apellido }}</a></td>
                            <td>{{ $pr->dni }}</td>
                            <td>{{ $pr->garantia }}</td>
                            <td>{{ $pr->fecinicio }}</td>
                            <td><a type="button" class="btn btn-xs btn-primary" href="{{ route('descargarPdfContrato', ["$pr->prestamo_id"]) }}" target="_blank"><i class="fa fa-download"></i></a><button type="button" class="btn btn-xs btn-success" onclick="verCorreo('{{ $pr->prestamo_id }}', '{{ $pr->nombre }} {{ $pr->apellido }}')" ><i class="fa fa-envelope-o"></i></button><a type="button" class="btn btn-xs btn-info" href="{{ route('imprimirContrato', ["$pr->prestamo_id"]) }}" target="_blank"><i class="fa fa-print"></i></a></td>
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

<!-- Modal Mostrar Correo -->
<div class="modal inmodal fade" id="verCorreo" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Ver Correo <span id = "detId">Codigo</span></h4>
            </div>
            <div class="modal-body" id="divModalCorreo">
                <table class="table m-b-xs">
                    <tbody>
                    <tr>
                        <td>
                            <strong>Cliente:</strong>
                        </td>
                        <td>
                            <span id="corCliente">Cliente</span>
                        </td>
    
                    </tr>
                    <tr>
                        <td>
                            <strong>Correo:</strong>
                        </td>
                        <td>
                            <span id="corCorreo">Correo</span>
                        </td>
    
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-outline btn-success dim" data-dismiss="modal"> ACEPTAR</button>
            </div>
        </div>
    </div>
</div>
<!-- Fin Detalle -->
@endsection
@section('script')
    <script>
        function buscarClientes() {
            var dato = $("#clienteBusqueda").val();
            
            $.post( "{{ Route('buscarClienteContrato') }}", {dato: dato, _token:'{{csrf_token()}}'}).done(function(data) {
                $("#divTipoPrestamo").empty();
                $("#divTipoPrestamo").html(data.view);
            });
            
        }

        function verCorreo(id, cliente) {
            $('#verCorreo').modal('show');

            document.getElementById("corCliente").innerHTML="<p style='text-align:right;'>"+cliente+"</p>";

            $.post( "{{ Route('verCorreo') }}", {id: id, _token:'{{csrf_token()}}'}).done(function(data) {

                document.getElementById("corCorreo").innerHTML="<p style='text-align:right;'>"+data.correo+"</p>";

            });
        }
    </script>
@endsection
