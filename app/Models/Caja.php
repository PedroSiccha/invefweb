<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{
    use HasFactory;
    protected $table = 'caja';
    protected $fillable = ['id', 'estado', 'monto', 'fecha', 'inicio', 'fin', 'montofin', 'empleado', 'sede_id', 'tipocaja_id'];

    public static function cajSed($id){
    	return Caja::where('sede_id', '=', $id) -> get();
    }

    public static function cajTca($id){
    	return Caja::where('tipocaja_id', '=', $id) -> get();
    }
}
