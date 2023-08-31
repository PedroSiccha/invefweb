 <table class="footable table table-stripped toggle-arrow-tiny">
                    <thead>
                    <tr>
                        <th data-toggle="true">Cod</th>
                        <th>Garantia</th>
                        <th>Cliente</th>
                        <th>Tipo de Prestammo</th>
                        <th>Precio</th>
                        <th>Cot. Maximo</th>
                        <th>Cot. Minimo</th>
                        <th>Fecha de Cotizacion</th>
                        <th>Action</th>
                    </tr> 
                    </thead>
                    <tbody>
                        
                    @foreach ($listCotizacion as $ls)
                        <tr>
                            <td>{{ $ls->cotizacion_id }}</td>
                            <td>{{ $ls->g_nombre }}</td>
                            <td><a class="text-blue" href="{{ Route('perfilCliente', [$ls->cliente_id]) }}">{{ $ls->cl_nombre }} {{ $ls->cl_apellido }}</a></td>
                            <td>{{ $ls->tp_nombre }}</td>
                            <td>{{ $ls->precio }}</td>
                            <td>{{ $ls->max }}</td>
                            <td>{{ $ls->min }}</td>
                            <td>{{ $ls->created_at }}</td>
                            <td>
                                
                                
                                <button type="button" class="btn btn-xs btn-danger" title="Eliminar Cotización"><i class="fa fa-trash"></i> </button>
                                
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