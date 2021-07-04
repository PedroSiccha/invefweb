<div id="tab-1" class="tab-pane active">
    <div class="full-height-scroll">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Cod.Prestamo</th>
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
                            <td>{{ $pr->nombre }} {{ $pr->apellido }}</td>
                            <td>{{ $pr->dni }}</td>
                            <td>{{ $pr->created_at }}</td>
                            <td><button type="button" class="btn btn-xs btn-success" onclick="tipoDesembolso('{{ $pr->prestamo_id }}')"><i class="fa fa-paper-plane-o"></i></button></td>
                        </tr>    
                    @endforeach    
                </tbody>
            </table>
        </div>
    </div>
</div>