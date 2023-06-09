<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PermisoRol extends Model
{
    protected $table = 'permisorol';
    protected $fillable = ['id', 'permiso_id', 'roles_id'];

    public static function rusPer($id){
    	return PermisoRol::where('permiso_id', '=', $id) -> get();
    }
    public static function rusRol($id){
    	return PermisoRol::where('roles_id', '=', $id) -> get();
    }
}
