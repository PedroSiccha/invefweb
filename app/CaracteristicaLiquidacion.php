<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CaracteristicaLiquidacion extends Model
{
    protected $table = 'caracteristicas_liquidacion';
    protected $fillable = ['id', 'descripcion', 'unidad', 'estado', 'liquidacion_web'];

    public static function cliLiq($id){
        return CaracteristicaLiquidacion::where('liquidacion_web', '=', $id) -> get();
    }
}
