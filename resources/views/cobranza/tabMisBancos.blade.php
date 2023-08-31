<table class="footable table table-stripped toggle-arrow-tiny">
                    <thead>
                    <tr>
                        <th data-toggle="true">Cod</th>
                        <th>Banco</th>
                        <th>Cuenta</th>
                        <th>Monto</th>
                    </tr> 
                    </thead>
                    <tbody>
                        
                    @foreach ($misBancos as $mb)
                        <tr>
                            <td>{{ $mb->id }}</td>
                            <td>{{ $mb->tipo }}</td>
                            <td>{{ $mb->detalle }}</td>
                            <td>{{ $mb->monto }}</td>
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