<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sede extends Model
{
    protected $table = 'sede';
    protected $fillable = ['id', 'nombre', 'detalle', 'referencia', 'estado', 'telefono', 'telfreferencia', 'direccion_id'];

    public static function sedDir($id){
    	return Sede::where('direccion_id', '=', $id) -> get();
    }
}
