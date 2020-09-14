<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServicioHasCaracteristica extends Model
{
    protected $table = 'servicio_has_caracteristica';
    protected $fillable = ['id', 'Servicio_id', 'caracterisitica_servicio_id'];

    public static function serCar($id){
        return ServicioHasCaracteristica::where('caracterisitca_servicio_id', '=', $id) -> get();
    }

    public static function serSer($id){
        return ServicioHasCaracteristica::where('Servicio_id', '=', $id) -> get();
    }
}
