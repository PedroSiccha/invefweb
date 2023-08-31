<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocNotificacion extends Model
{
    protected $table = 'docnotificacion';
    protected $fillable = ['id', 'nombre', 'descripcion', 'ruta', 'prestamo_notificacion_id'];

    public static function dnoPno($id){
    	return Docnotificacion::where('prestamo_notificacion_id', '=', $id) -> get();
    }
}
