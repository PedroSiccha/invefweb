<table class="table table-striped">
    <thead>
        <tr>
            <th onclick="verHistorialDia('1')">ENERO</th>
            <th onclick="verHistorialDia('2')">FEBRERO</th>
            <th onclick="verHistorialDia('3')">MARZO</th>
            <th onclick="verHistorialDia('4')">ABRIL</th>
            <th onclick="verHistorialDia('5')">MAYO</th>
            <th onclick="verHistorialDia('6')">JUNIO</th>
            <th onclick="verHistorialDia('7')">JULIO</th>
            <th onclick="verHistorialDia('8')">AGOSTO</th>
            <th onclick="verHistorialDia('9')">SEPTIEMBRE</th>
            <th onclick="verHistorialDia('10')">OCTUBRE</th>
            <th onclick="verHistorialDia('11')">NOVIEMBRE</th>
            <th onclick="verHistorialDia('12')">DICIEMBRE</th>
            <th>TOTAL</th>
        </tr>
    </thead>
    <tbody>
    <tr>
        <td class="text-navy" onclick="verHistorialDia('1')">{{ $montoCaja[1] }}</td>
        <td class="text-navy" onclick="verHistorialDia('2')">{{ $montoCaja[2] }}</td>
        <td class="text-navy" onclick="verHistorialDia('3')">{{ $montoCaja[3] }}</td>
        <td class="text-navy" onclick="verHistorialDia('4')">  {{ $montoCaja[4] }} </td>
        <td class="text-navy" onclick="verHistorialDia('5')">  {{ $montoCaja[5] }} </td>
        <td class="text-navy" onclick="verHistorialDia('6')">  {{ $montoCaja[6] }} </td>
        <td class="text-navy" onclick="verHistorialDia('7')">  {{ $montoCaja[7] }} </td>
        <td class="text-navy" onclick="verHistorialDia('8')">  {{ $montoCaja[8] }} </td>
        <td class="text-navy" onclick="verHistorialDia('9')">  {{ $montoCaja[9] }} </td>
        <td class="text-navy" onclick="verHistorialDia('10')">  {{ $montoCaja[10] }} </td>
        <td class="text-navy" onclick="verHistorialDia('11')">  {{ $montoCaja[11] }} </td>
        <td class="text-navy" onclick="verHistorialDia('12')">  {{ $montoCaja[12] }} </td>
        <td class="text-navy">  {{ $montoCaja[1] + $montoCaja[2] + $montoCaja[3] + $montoCaja[4] + $montoCaja[5] + $montoCaja[6] + $montoCaja[7] + $montoCaja[8] + $montoCaja[9] + $montoCaja[10] + $montoCaja[11] + $montoCaja[12] }} </td>
    </tr>
    </tbody>
</table>