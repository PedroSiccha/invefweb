<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipocreditoInteres extends Model
{
    protected $table = 'tipocredito_interes';
    protected $fillable = ['id', 'tipocredito_id', 'interes_id'];

    public static function tinTcr($id){
    	return TipocreditoInteres::where('tipocredito_id', '=', $id) -> get();
    }
    public static function tinInt($id){
    	return TipocreditoInteres::where('interes_id', '=', $id) -> get();
    }
}
