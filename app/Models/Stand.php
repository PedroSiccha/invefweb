<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stand extends Model
{
    use HasFactory;
    protected $table = 'stand';
    protected $fillable = ['id', 'nombre', 'detalle', 'almacen_id', 'estado'];

    public static function staAlm($id){
    	return Stand::where('almacen_id', '=', $id) -> get();
    }
}
