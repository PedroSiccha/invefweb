<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GarantiaCasillero extends Model
{
    protected $table = 'garantia_casillero';
    protected $fillable = ['id', 'detalle', 'estado', 'garantia_id', 'casillero_id'];

    public static function gcaGar($id){
    	return GarantiaCasillero::where('garantia_id', '=', $id) -> get();
    }
    public static function gcaCas($id){
    	return GarantiaCasillero::where('casillero_id', '=', $id) -> get();
    }
}
