@extends('layouts.app')
@section('pagina')
    Cartera de Clientes
@endsection
@section('contenido')
<div class="clearfix"></div>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Cartera de Clientes</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ Route('home') }}">Inicio</a>
            </li>
            <li class="breadcrumb-item">
                <a>Atención al cliente</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Cartera de Clientes</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>

<div class="wrapper wrapper-content  animated fadeInRight">
    <div class="row">
        <div class="col-sm-8">
            <div class="ibox">
                <div class="ibox-content">
                    <span class="text-muted small float-right">Ultima Actualización: <i class="fa fa-clock-o"></i> {{ date('H:m') }} - {{ date('d/m/Y') }}</span>
                    <h2>Clientes</h2>
                    <div class="input-group">
                        <input type="text" placeholder="Busqueda de Clientes " class="input form-control" id="clienteBusqueda" onkeyup="buscarCliente()">
                        <span class="input-group-append">
                                <button type="button" class="btn btn btn-primary"> <i class="fa fa-search"></i> Buscar</button>
                        </span>
                    </div>
                    <div class="clients-list">
                    <span class="float-right small text-muted">{{ $cantClientes }} Clientes</span>
                    <ul class="nav nav-tabs">
                        <li><a class="nav-link active" data-toggle="tab" href="#tab-1"><i class="fa fa-user"></i> Clientes</a></li>
                    </ul>
                    <div class="tab-content" id="tabCliente">
                        <div id="tab-1" class="tab-pane active">
                            <div class="full-height-scroll">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <tbody>
                                            @foreach ($clientes as $cl)
                                                <tr onclick="direCliente('{{ $cl->cliente_id }}')">
                                                    <td class="client-avatar"><img alt="image" src="{{ $cl->foto }}"> </td>
                                                    <td><a href="#contact-{{ $cl->cliente_id }}" class="client-link">{{ $cl->nombre }} {{ $cl->apellido }}</a></td>
                                                    <td> {{ $cl->dni }}</td>
                                                    <td class="contact-type"><i class="fa fa-envelope"> </i></td>
                                                    <td> {{ $cl->correo }}</td>
                                                    <td class="client-status"><span class="label label-primary">Active</span></td>
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
        <div class="col-sm-4">
            <div class="ibox selected">

                <div class="ibox-content" id="direCliente">
                    
                </div>
            </div> 
        </div>
    </div>
</div>

@endsection
@section('script')
    <script src="{{ asset('js/plugins/footable/footable.all.min.js') }}"></script>
    <script>
        function buscarCliente() {
            var dato = $("#clienteBusqueda").val();
            
            $.post( "{{ Route('buscarCliente') }}", {dato: dato, _token:'{{csrf_token()}}'}).done(function(data) {
                $("#tabCliente").empty();
                $("#tabCliente").html(data.view);
            });
            
        }

        $(document).ready(function(){

            $(document.body).on("click",".client-link",function(e){
                e.preventDefault()
                $(".selected .tab-pane").removeClass('active');
                $($(this).attr('href')).addClass("active");
            });

        });

        function direCliente(id) {
            
            $.post( "{{ Route('direCliente') }}", {id: id, _token:'{{csrf_token()}}'}).done(function(data) {
                $("#direCliente").empty();
                $("#direCliente").html(data.view);
            });
        }
        
    </script>
@endsection
