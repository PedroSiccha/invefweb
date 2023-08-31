<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoCreditoInteres extends Model
{
    use HasFactory;
    protected $table = 'tipocredito_interes';
    protected $fillable = ['id', 'tipocredito_id', 'interes_id'];

    public static function tinTcr($id){
    	return TipocreditoInteres::where('tipocredito_id', '=', $id) -> get();
    }
    public static function tinInt($id){
    	return TipocreditoInteres::where('interes_id', '=', $id) -> get();
    }
}
