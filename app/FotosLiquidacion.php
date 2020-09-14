<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FotosLiquidacion extends Model
{
    protected $table = 'fotosliquidacion';
    protected $fillable = ['id', 'url', 'detalle', 'estado', 'liquidacion_web'];

    public static function fliLwe($id){
        return FotosLiquidacion::where('liquidacion_web', '=', $id) -> get();
    }
}
