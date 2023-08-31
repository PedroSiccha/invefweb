<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrestamoNotificacion extends Model
{
    use HasFactory;
    protected $table = 'prestamo_notificacion';
    protected $fillable = ['id', 'estado', 'prestamo_id', 'notificacion_id'];

    public static function pnoPre($id){
    	return PrestamoNotificacion::where('prestamo_id', '=', $id) -> get();
    }
    public static function pnoCot($id){
    	return PrestamoNotificacion::where('notificacion_id', '=', $id) -> get();
    }
}
