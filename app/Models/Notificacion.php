<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    protected $table = 'notificacion';
    protected $fillable = ['id', 'mensaje', 'tiempo', 'asunto', 'estado', 'sede', 'tipo', 'usuario'];
}
