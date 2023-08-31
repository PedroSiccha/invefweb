<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestamo extends Model
{
    protected $table = 'prestamo';
    protected $fillable = ['id', 'codigo', 'monto', 'fecinicio', 'fecfin', 'total', 'macro', 'intpagar', 'estado', 'tipocredito_interes_id', 'cotizacion_id', 'mora_id', 'empleado_id', 'sede_id', 'color_estado', 'fecagendar', 'orden'];

    public static function preCot($id){
    	return Prestamo::where('cotizacion_id', '=', $id) -> get();
    }
    public static function preEmp($id){
    	return Prestamo::where('empleado_id', '=', $id) -> get();
    }
    public static function preTin($id){
    	return Prestamo::where('tipocredito_interes_id', '=', $id) -> get();
    }
    public static function preMor($id){
    	return Prestamo::where('mora_id', '=', $id) -> get();
    }
    public static function preSed($id){
    	return Prestamo::where('sede_id', '=', $id) -> get();
    }
}
