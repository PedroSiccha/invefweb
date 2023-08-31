<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Casillero extends Model
{
    use HasFactory;
    protected $table = 'casillero';
    protected $fillable = ['id', 'nombre', 'detalle', 'stand_id', 'estado'];

    public static function casSta($id){
    	return Casillero::where('stand_id', '=', $id) -> get();
    }
}
