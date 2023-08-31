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