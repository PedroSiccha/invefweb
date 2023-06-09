<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{
    protected $table = 'caja';
    protected $fillable = ['id', 'estado', 'monto', 'fecha', 'inicio', 'fin', 'montofin', 'empleado', 'sede_id', 'tipocaja_id'];

    public static function cajSed($id){
    	return Caja::where('sede_id', '=', $id) -> get();
    }

    public static function cajTca($id){
    	return Caja::where('tipocaja_id', '=', $id) -> get();
    }

}
