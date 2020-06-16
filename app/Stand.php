<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stand extends Model
{
    protected $table = 'stand';
    protected $fillable = ['id', 'nombre', 'detalle', 'almacen_id', 'estado'];

    public static function staAlm($id){
    	return Stand::where('almacen_id', '=', $id) -> get();
    }
}
