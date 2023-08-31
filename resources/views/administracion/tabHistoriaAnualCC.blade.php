<table class="table table-striped">
    <thead>
        <tr>
            @foreach($historialAnualCajaChica AS $hacc)
            <th>{{ $hacc->anio }}</th>
            @endforeach()
        </tr>
        
    </thead>
    <tbody>
    <tr>
        @foreach($historialAnualCajaChica AS $hacc)
        <td class="text-navy"> S/. {{ $hacc->monto }} </td>
        @endforeach()
    </tr>
    </tbody>
</table>