<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MovimientoDocumento extends Model
{
    protected $table = 'movimiento_documento';
    protected $fillable = ['id', 'asunto', 'detalle', 'estado', 'movimiento_id', 'documento_id'];

    public static function modMov($id){
    	return MovimientoDocumento::where('movimiento_id', '=', $id) -> get();
    }

    public static function modDoc($id){
    	return MovimientoDocumento::where('documento_id', '=', $id) -> get();
    }
}
