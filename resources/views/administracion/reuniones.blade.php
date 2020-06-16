@extends('layouts.app')
@section('pagina')
    Gestión de Reuniones
@endsection
@section('contenido')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Gestion de Reuniones</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ Route('home') }}">Inicio</a>
            </li>
            <li class="breadcrumb-item">
                <a>Administración</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Gestión de Reuniones</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-10">
            @foreach ($reuniones as $r)
            <div class="ibox">
                <div class="ibox-title">
                    <span class="label label-primary float-right">{{ $r->estado }}</span>
                    <h5>{{ $r->nombrereunion }}</h5>
                </div>
                <div class="ibox-content">
                    <h4>{{ $r->motivoreunion }}</h4>
                    <p>
                       {{ $r->detallereunion }}.
                    </p>
                    <div>
                        <span>Fechas de la reunion:</span>
                    </div>
                    <div class="row  m-t-sm">
                        <div class="col-sm-4">
                            <div class="font-bold">Fecha</div>
                            {{ $r->fecha }}
                        </div>
                        <div class="col-sm-4">
                            <div class="font-bold">Hora de Inicio</div>
                            {{ $r->inicio }}
                        </div>
                        <div class="col-sm-4 text-right">
                            <div class="font-bold">Hora de Fin</div>
                            {{ $r->fin }}
                        </div>
                    </div>

                </div>
            </div>
            @endforeach
        </div>
        
        
    </div>


</div>
@endsection
