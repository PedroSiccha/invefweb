<table class="table table-striped">
    <thead>
    <tr>
        <th>#</th>
        <th>SERIE</th>
        <th>TIPO DE PAGO</th>
        <th>DETALLE</th>
        <th>MONTO</th>
        <th>RECIBO</th>
    </tr>
    </thead>
    <tbody>
        @foreach ($cajaGrande as $cg)
            <tr>
                <td>{{ $cg->codigo }}</td>
                <td>{{ $cg->serie }}</td>
                <td>{{ $cg->concepto }}</td>
                <td>{{ $cg->garantia }}</td>
                <td class="text-navy"> <i class="fa fa-level-up"></i> {{ $cg->monto }} </td>
                <td>
                    <a href="{{ $cg->documento }}" title="{{ $cg->concepto }}" data-gallery="" >
                        <img src="{{ $cg->documento }}"  width="60" height="60">
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>