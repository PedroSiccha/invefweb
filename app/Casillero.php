<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Casillero extends Model
{
    protected $table = 'casillero';
    protected $fillable = ['id', 'nombre', 'detalle', 'stand_id', 'estado'];

    public static function casSta($id){
    	return Casillero::where('stand_id', '=', $id) -> get();
    }
}
