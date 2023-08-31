<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlmacenSede extends Model
{
    protected $table = 'almacen_sede';
    protected $fillable = ['id', 'detalle', 'sede_id', 'almacen_id'];

    public static function almSed($id){
    	return AlmacenSede::where('sede_id', '=', $id) -> get();
    }
    
    public static function almAlm($id){
    	return AlmacenSede::where('almacen_id', '=', $id) -> get();
    }
}
