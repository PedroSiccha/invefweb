@extends('layouts.app')
@section('pagina')
    Rendimiento de Personal
@endsection
@section('contenido')
<div class="wrapper wrapper-content  animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Rendimiento de Personal</h5>
                    <div class="ibox-tools">
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row m-b-sm m-t-sm">
                        <div class="col-md-11">
                            <div class="input-group"><input type="text" placeholder="Buscar por DNI o nombres" class="form-control-sm form-control"> <span class="input-group-btn">
                                <button type="button" class="btn btn-sm btn-primary"> Buscar!</button> </span></div>
                        </div>
                    </div>

                    <div class="project-list">

                        <table class="table table-hover">
                            <tbody>
                                @foreach ($empleado as $e)
                                    <tr>
                                        <td class="project-status">
                                            <span class="label label-primary">Active</span>
                                        </td>
                                        <td class="project-title">
                                            <a href="project_detail.html">{{ $e->nombre }} {{ $e->apellido }}</a>
                                            <br/>
                                            <small>{{ $e->dni }}</small>
                                        </td>
                                        <td class="project-completion">
                                                <small>Evaluacion: {{ $e->valoracion }}%</small>
                                                <div class="progress progress-mini">
                                                    <div style="width: {{ $e->valoracion }}%;" class="progress-bar"></div>
                                                </div>
                                        </td>
                                        <td class="project-people">
                                            <a href=""><img alt="image" class="rounded-circle" src="{{ $e->foto }}"></a>
                                        </td>
                                        <td class="project-actions">
                                            <a class="btn btn-white btn-sm" href ="{{ Route('perfilEmpleadoRendimiento', [ $e->empleado_id ]) }}"><i class="fa fa-profile"></i> Perfil </a>
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
@endsection
@section('script')
    <script>
    </script>
@endsection
