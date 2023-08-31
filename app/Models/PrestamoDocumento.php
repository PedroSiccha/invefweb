<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrestamoDocumento extends Model
{
    use HasFactory;
    protected $table = 'prestamo_documento';
    protected $fillable = ['id', 'asunto', 'detalle', 'estado', 'prestamo_id', 'documento_id'];

    public static function pdoPre($id){
    	return PrestamoDocumento::where('prestamo_id', '=', $id) -> get();
    }
    public static function pdoDoc($id){
    	return PrestamoDocumento::where('documento_id', '=', $id) -> get();
    }
}
