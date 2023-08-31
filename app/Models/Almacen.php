<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Almacen extends Model
{
    use HasFactory;
    protected $table = 'almacen';
    protected $fillable = ['id', 'nombre', 'estado', 'direccion_id'];

    public static function almDir($id){
    	return Almacen::where('direccion_id', '=', $id) -> get();
    }
}
