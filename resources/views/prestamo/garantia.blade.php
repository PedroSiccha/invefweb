@extends('layouts.app')
@section('pagina')
    Control de Garantía
@endsection
@section('contenido')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Gestión de Garantías</h5>
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
                    <input type="text" placeholder="Busqueda de Garantias " class="input form-control" id="garantiaBusqueda" onkeyup="buscarGarantia()">
                    <span class="input-group-append">
                            <button type="button" class="btn btn btn-primary"> <i class="fa fa-search"></i> Buscar</button>
                    </span>
                </div>
            </div>
            
            <div class="ibox-content" id="divGarantiaAlmacen">
                <table class="footable table table-stripped toggle-arrow-tiny">
                    <thead>
                    <tr>
                        <th data-toggle="true">Código de Préstamo</th>
                        <th>Codigo de Garantía</th>
                        <th>Garantía</th>
                        <th>Descripción</th>
                        <th>Ubicación del Almacén</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($garantia as $ga)
                        <?php
                            if ($ga->estado == "OCUPADO") {
                                $color = "bg-danger";
                                $estado = "hidden";
                            }elseif ($ga->estado == "LIBRE") {
                                $color = "navy-bg";
                                $estado = "hidden";
                            }elseif ($ga->estado == "RECOGER") {
                                $color = "bg-warning";
                                $estado = "";
                            }
                        ?>
                        <tr class="{{ $color }}">
                            <td>{{ $ga->prestamo_id }}</td>
                            <td>{{ $ga->garantia_id }}</td>
                            <td>{{ $ga->garantia }}</td>
                            <td>{{ $ga->detgarantia }}</td>
                            <td>{{ $ga->casillero }}</td>
                            <td>
                                <button type="button" class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="top" title="Entregar Garantia" {{ $estado }} onclick="verRecoger('{{ $ga->prestamo_id }}', '{{ $ga->garantia_id }}', '{{ $ga->garantia }}')"><i class="fa fa-archive"></i></button>
                            </td>
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

<div class="modal inmodal fade" id="recoger" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Recoger Garantia</h4>
                <small class="font-bold"><span id="garantiaR"></span></small>
            </div>
            <div class="modal-body">
                <input type="text" class="form-control text-success" id="idCajaC" hidden>
                <input type="text" class="form-control text-success" id="montoFinC" hidden>
                
                <table class="table m-b-xs">
                    <tbody>
                    <tr>
                        <td>
                            <strong>GARANTIA</strong>
                            <input style="font-size: large;" type="text" class="form-control text-success" id="idR" hidden>
                        </td>
                        <td>
                            <span id="clienteR">almacen</span>
                        </td>
    
                    </tr>
                    <tr>
                        <td>
                            <strong>Ingrese DNI</strong>
                        </td>
                        <td id="cbStand">
                            <div class="col-sm-10" ><input style="font-size: large;" type="text" class="form-control text-success" id="dniR" placeholder="Ingrese DNI"></div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-outline btn-success dim" data-dismiss="modal" onclick="recoger()"><i class="fa fa-money"></i> Recoger</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
    <script>
        function buscarGarantia() {
            var dato = $("#garantiaBusqueda").val();
            
            $.post( "{{ Route('buscarGarantiaPrestamo') }}", {dato: dato, _token:'{{csrf_token()}}'}).done(function(data) {
                $("#divGarantiaAlmacen").empty();
                $("#divGarantiaAlmacen").html(data.view);
            });
            
        }

        function verRecoger(prestamo_id, garantia_id, garantia){
            $("#idR").val(prestamo_id);
            $('#recoger').modal('show');
           // document.getElementById("garantiaR").innerHTML="<p style='text-align:center;'>" +data.garantia+", "+data.detalleGarantia+"</p>";
            document.getElementById("clienteR").innerHTML="<p style='text-align:center;'>"+garantia+"</p>";

           
            
        }

        function recoger(){
            
            var dni = $("#dniR").val();
            var id = $("#idR").val();

            $.post( "{{ Route('recogerGarantia') }}", {dni: dni, id: id, _token:'{{csrf_token()}}'}).done(function(data) {
                
                setTimeout(function() {
                    toastr.options = {
                        closeButton: true,
                        progressBar: true,
                        showMethod: 'slideDown',
                        timeOut: 4000,
                        positionClass: 'toast-top-center'
                    };
                    toastr.info(data.mensaje, "FINALIZAR");
                }, 1300);
                $("#divGarantiaAlmacen").empty();
                $("#divGarantiaAlmacen").html(data.view);
            });
            $('#recoger').modal('hide');
        }

    </script>
@endsection
