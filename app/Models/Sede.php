<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sede extends Model
{
    use HasFactory;
    protected $table = 'sede';
    protected $fillable = ['id', 'nombre', 'detalle', 'referencia', 'estado', 'telefono', 'telfreferencia', 'direccion_id'];

    public static function sedDir($id){
    	return Sede::where('direccion_id', '=', $id) -> get();
    }
}
