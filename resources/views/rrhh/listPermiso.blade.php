<div id="tab-1" class="tab-pane active">
    <div class="full-height-scroll">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Cod.</th>
                        <th>Nombre del Permiso</th>
                        <th>SLUG</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($permisos as $p)
                    <tr>
                        <td> {{ $p->id }} </td>
                        <td> {{ $p->nombre }} </td>
                        <td>{{ $p->slug }}</td>
                    </tr>        
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>