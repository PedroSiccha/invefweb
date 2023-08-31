<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Proceso extends Model
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
        }elseif ($dias >= 45 && $dias <= 61) {
            $interesActual = $monto*($porcentaje/100);
            $moraPagar = (15)*$mora;
            $verMora = "";
        }else {
            $interesActual = $monto*($porcentaje/100)*2;
            $moraPagar = (15)*$mora;
            $verMora = "";
        }

        $totalActual = $monto + $interesActual;

        $inter = $nombre_format_francais = number_format($interesActual, 2, ',', ' ');
        $tot = $nombre_format_francais = number_format($totalActual, 2, ',', ' ');

        

        return [$interesActual, $moraPagar, $totalActual, $verMora, $dias, $monto];
    	
    }

    public static function calcularMora($fecFin, $montoMora){
        
        $moraPagar = 0; 
        $verMora = "hidden";

        $fechaActual = date("d-m-Y");
        $dias = (strtotime($fechaActual)-strtotime($fecFin))/86400;
        $dias = $dias;

        if ($dias <= 0) {
            $moraPagar = 0;
        }else if ($dias > 0 && $dias < 15) {
            $moraPagar = $dias*$montoMora;
        }else{
            $moraPagar = 15*$montoMora;
        }

        return $moraPagar;

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
        $estado = false;
        $user = Auth::user()->id;

        $verificar = DB::SELECT('SELECT * 
                                  FROM users u, userrol ur, rol r, menurol mr, menu m
                                  WHERE ur.users_id = u.id AND ur.rol_id = r.id AND mr.rol_id = r.id AND mr.menu_id = m.id AND m.url = "'.$permiso.'" AND u.id = "'.$user.'"');

        if (!empty($verificar)) {
            $estado = true;
        }

        return $estado;
    }
    
    public static function validarRol($rol)
    {
        $estado = false;
        $user = Auth::user()->id;

        $verificar = DB::SELECT('SELECT * FROM userrol ur
                                  JOIN rol r ON r.id = ur.rol_id
                                  WHERE ur.users_id = "'.$user.'" AND r.nombre = "'.$rol.'"');

        if (!empty($verificar)) {
            $estado = true;
        }

        return $estado;
    }
    
    public static function obtenerSucursal() {
        $user = Auth::user();
        $sucursal = Empleado::select('users.id as user_id', 'empleado.nombre', 'empleado.apellido', 'empleado.id', 'users.name as area', 'empleado.foto as foto', 'empleado.sede_id as sucursal_id', 'sede.nombre as sucursal')
                            ->join('users', 'empleado.users_id', '=', 'users.id')
                            ->join('sede', 'empleado.sede_id', '=', 'sede.id')
                            ->join('direccion', 'sede.direccion_id', '=', 'direccion.id')
                            ->join('distrito', 'direccion.distrito_id', '=', 'distrito.id')
                            ->join('provincia', 'distrito.provincia_id', '=', 'provincia.id')
                            ->join('departamento', 'provincia.departamento_id', '=', 'departamento.id')
                            ->selectRaw('CONCAT(direccion.direccion, ", Distrito de ", distrito.distrito, ", Provincia de ", provincia.provincia, ", Departamento de ", departamento.departamento) AS direccion')
                            ->where('users.id', $user->id)
                            ->first();
        return $sucursal;
    }
    
    public static function obtenerNotificaciones() {
        $user = Auth::user();
        $sucursal = DB::SELECT('SELECT e.nombre, e.apellido, e.id, u.name AS area, e.foto AS foto, e.sede_id AS sucursal_id, s.nombre AS sucursal
                                    FROM empleado e, users u, sede s 
                                    WHERE e.users_id = u.id AND e.sede_id = s.id AND u.id = "'.$user->id.'"');
        $idSucursal = $sucursal[0]->sucursal_id;
        $notificacion = DB::SELECT('SELECT * FROM  notificacion WHERE estado = "PENDIENTE" AND sede = "'.$idSucursal.'"');

        if ($notificacion == null) {
            $notificacion = DB::SELECT('SELECT "" AS icono, "" AS asunto, "00:00:00" AS tiempo');
        }

        return $notificacion;
    }

    
}