<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $table = 'empleado';
    protected $fillable = ['id', 'nombre', 'apellido', 'dni', 'fecnac', 'edad', 'telefono', 'referencia', 'whatsapp', 'tipodocide_id', 'estado', 'direccion_id', 'genero', 'turno_id', 'planilla_id', 'valoracion', 'users_id', 'foto'];

    public static function empTdi($id){
    	return Empleado::where('tipodocide_id', '=', $id) -> get();
    }
    public static function empDir($id){
    	return Empleado::where('direccion_id', '=', $id) -> get();
    }
    public static function empTur($id){
    	return Empleado::where('turno_id', '=', $id) -> get();
    }
    public static function empPla($id){
    	return Empleado::where('planilla_id', '=', $id) -> get();
    }
    public static function empUse($id){
        return Empleado::where('users_id', '=', $id) -> get();
    }
}
