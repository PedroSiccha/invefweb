<table class="table table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Interes</th>
                            <th>Tipo Credito</th>
                            <th>Gestion</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($interes as $it)
                                <tr>
                                    <td>{{ $it->interes_id }}</td>
                                    <td>{{ $it->porcentaje }}</td>
                                    <td>{{ $it->tipocredito_id }}</td>
                                    <td>
                                        <button type="button" class="btn btn-warning btn-xs" onclick="editarInteres({{ $it->interes_id }}, {{ $it->porcentaje }}, {{ $it->tipocredito_id }})"><i class="fa fa-edit"></i></button>
                                        <button type="button" class="btn btn-danger btn-xs" onclick="elininarInteres({{ $it->interes_id }})"><i class="fa fa-trash"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>