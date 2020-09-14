<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class proceso extends Model
{
    public static function interesActual($dias, $monto, $porcentaje, $mora){
        $interesActual = 0;
        $moraPagar = 0;
        $verMora = "hidden";
        $totalActual = 0;
        
        if ($dias >= 0 && $dias <= 7) {
            $interesActual = $monto*0.07;
            $verMora = "hidden";
        }elseif ($dias >= 8 && $dias <= 15) {
            $interesActual = $monto*0.1;
            $verMora = "hidden";
        }elseif ($dias >= 16 && $dias <= 20) {
            $interesActual = $monto*0.15;
            $verMora = "hidden";
        }elseif ($dias >= 21 && $dias <= 31) {
            $interesActual = $monto*($porcentaje/100);
            $verMora = "hidden";
        }elseif ($dias > 31 && $dias <= 45){
            $interesActual = $monto*($porcentaje/100);
            $moraPagar = ($dias-30)*$mora;
            $verMora = "";
        }elseif ($dias >= 45 && $dias <= 62) {
            $interesActual = $monto*($porcentaje/100);
            $moraPagar = (15)*$mora;
            $verMora = "";
        }else {
            $interesActual = $monto*($porcentaje/100)*2;
            $moraPagar = (15)*$mora;
            $verMora = "";
        }

        $totalActual = $monto + $moraPagar + $interesActual;

        $inter = $nombre_format_francais = number_format($interesActual, 2, ',', ' ');
        $tot = $nombre_format_francais = number_format($totalActual, 2, ',', ' ');

        

        return [$interesActual, $moraPagar, $totalActual, $verMora, $dias, $monto];
    	
    }

    function cambiaf_a_espanol($fecha){
        preg_match( '/([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})/', $fecha, $mifecha);
        $lafecha=$mifecha[3]."/".$mifecha[2]."/".$mifecha[1];
        return $lafecha;
    }

    public static function actualizarCaja($caja, $monto, $operacion )
    {
        $actualizar = 0;
        if ($operacion == 1) { //Desembolso
            
            $actualizar = (FLOAT)$caja - (FLOAT)$monto;

        }elseif ($operacion == 2) {

            $actualizar = (FLOAT)$caja + (FLOAT)$monto;

        }

        return $actualizar;
    }

    public static function validarPermiso($permiso)
    {
        $estado = "hidden";
        $user = Auth::user()->id;

        $verificar = \DB::SELECT('SELECT * 
                                  FROM users u, userrol ur, rol r, menurol mr, menu m
                                  WHERE ur.users_id = u.id AND ur.rol_id = r.id AND mr.rol_id = r.id AND mr.menu_id = m.id AND m.nombre = "'.$permiso.'" AND u.id = "'.$user.'"');

        if ($verificar != null) {
            $estado = "";
        }

        return $estado;
    }

    
}
    

?>