<table class="table table-striped">
    <thead>
    <tr>
        @foreach ($historialMensualUtilidades as $hm)
            <?php
                $mes = "";
                switch ($hm->mes) {
                    case 1:
                        $mes = "ENERO";
                        break;
                    case 2:
                        $mes = "FEBRERO";
                        break;
                    case 3:
                        $mes = "MARZO";
                        break;
                    case 4:
                        $mes = "ABRIL"; 
                        break;
                    case 5:
                        $mes = "MAYO";
                        break;
                    case 6:
                        $mes = "JUNIO";
                        break;
                    case 7:
                        $mes = "JULIO";
                        break;
                    case 8:
                        $mes = "AGOSTO";
                        break;
                    case 9:
                        $mes = "SETIEMBRE";
                        break;
                    case 10:
                        $mes = "OCTUBRE";
                        break;
                    case 11:
                        $mes = "NOVIEMBRE";
                        break;
                    case 12:
                        $mes = "DICIEMBRE";
                        break;
                }
            ?>
            <th>{{ $mes }}</th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    <tr>
        @foreach ($historialMensualUtilidades as $hm)
            <td class="text-navy"> S/. {{ $hm->totalUtilidades }} </td>
        @endforeach
    </tr>
    </tbody>
</table>