<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Desembolso extends Model
{
    use HasFactory;
    protected $table = 'desembolso';
    protected $fillable = ['id', 'numero', 'estado', 'monto', 'prestamo_id', 'empleado_id'];

    public static function desPre($id){
    	return Desembolso::where('prestamo_id', '=', $id) -> get();
    }
    public static function desEmp($id){
    	return Desembolso::where('empleado_id', '=', $id) -> get();
    }
}
