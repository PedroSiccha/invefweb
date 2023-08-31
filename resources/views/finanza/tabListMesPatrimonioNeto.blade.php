<table class="table table-striped">
        <thead>
        <tr>
            @foreach ($listPatrimonioNetoMes AS $lpnm)
            <th>{{ $lpnm->mes }}</th>
            @endforeach
        </tr>
        </thead>
        <tbody>
        <tr>
            @foreach ($listPatrimonioNetoMes AS $lpnm)
            <th>S/. {{ number_format($lpnm->total_general, 2) }}</th>
            @endforeach
        </tr>
    </tbody>
</table>