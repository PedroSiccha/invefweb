<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Garantia extends Model
{
    protected $table = 'garantia';
    protected $fillable = ['id', 'nombre', 'detalle', 'estado', 'tipogarantia_id'];

    public static function garTga($id){
    	return Garantia::where('tipogarantia_id', '=', $id) -> get();
    }
}
