<table class="table table-striped">
    <thead>
    <tr>
        <th>#</th>
        <th>SERIE</th>
        <th>CONCEPTO</th>
        <th>MONTO</th>
    </tr>
    </thead>
    <tbody>
        @foreach ($cajaChica as $cc)
            <tr>
                <td>{{ $cc->codigo }}</td>
                <td>{{ $cc->serie }}</td>
                <td>{{ $cc->concepto }}</td>
                <td class="text-navy"> <i class="fa fa-level-up"></i> {{ $cc->monto }} </td>
            </tr>
        @endforeach
    </tbody>
</table>