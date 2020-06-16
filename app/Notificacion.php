<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    protected $table = 'notificacion';
    protected $fillable = ['id', 'mensaje', 'tiempo', 'asunto', 'estado', 'sede', 'tipo', 'usuario'];

}
