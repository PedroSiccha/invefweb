<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoCreditoRequisito extends Model
{
    use HasFactory;
    protected $table = 'tipocredito_requisito';
    protected $fillable = ['id', 'tipocredito_id', 'requisitos_id'];

    public static function treTcr($id){
    	return TipocreditoRequisito::where('tipocredito_id', '=', $id) -> get();
    }
    public static function treReq($id){
    	return TipocreditoRequisito::where('requisitos_id', '=', $id) -> get();
    }
}
