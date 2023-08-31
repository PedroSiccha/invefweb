<table class="footable table table-stripped toggle-arrow-tiny">
                    <thead>
                    <tr>
                        <th data-toggle="true">Cod</th>
                        <th>Banco</th>
                        <th>Cuenta</th>
                        <th>Action</th>
                    </tr> 
                    </thead>
                    <tbody>
                        
                    @foreach ($listBanco as $lb)
                        <tr>
                            <td>{{ $lb->id }}</td>
                            <td>{{ $lb->tipo }}</td>
                            <td>{{ $lb->detalle }}</td>
                            <td>
                                
                                <button type="button" class="btn btn-xs btn-warning" title="Editar Banco" onclick="verBanco('{{ $lb->id }}', '{{ $lb->tipo }}', '{{ $lb->detalle }}')"><i class="fa fa-pencil"></i> </button>
                                
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