<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipocreditoRequisito extends Model
{
    protected $table = 'tipocredito_requisito';
    protected $fillable = ['id', 'tipocredito_id', 'requisitos_id'];

    public static function treTcr($id){
    	return TipocreditoRequisito::where('tipocredito_id', '=', $id) -> get();
    }
    public static function treReq($id){
    	return TipocreditoRequisito::where('requisitos_id', '=', $id) -> get();
    }
}
