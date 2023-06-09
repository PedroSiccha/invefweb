<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    protected $table = 'inventario';
    protected $fillable = ['id', 'unidad', 'nombre', 'valor', 'marca', 'estado', 'tipoinventario_id'];

    public static function invTin($id){
    	return Inventario::where('tipoinventario_id', '=', $id) -> get();
    }
}
