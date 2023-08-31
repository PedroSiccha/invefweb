<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reuniones extends Model
{
    protected $table = 'reuniones';
    protected $fillable = ['id', 'nombre', 'motivo', 'detalle', 'estado', 'fecha', 'inicio', 'fin', 'asistentes_id', 'encargado_id'];

    public static function reuAsi($id){
    	return Reuniones::where('asistentes_id', '=', $id) -> get();
    }
    public static function reuEnc($id){
    	return Reuniones::where('encargado_id', '=', $id) -> get();
    }
}
