<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    protected $table = 'inventario';
    protected $fillable = ['id', 'unidad', 'nombre', 'valor', 'marca', 'estado', 'tipoinventario_id', 'sede_id'];

    public static function invTin($id){
    	return Inventario::where('tipoinventario_id', '=', $id) -> get();
    }
    
    public static function invSed($id){
    	return Inventario::where('sede_id', '=', $id) -> get();
    }
}
