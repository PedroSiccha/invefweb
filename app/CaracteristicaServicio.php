<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CaracteristicaServicio extends Model
{
    protected $table = 'caracteristica_servicio';
    protected $fillable = ['id', 'titulo', 'descripcion', 'estado', 'foto', 'icono'];
}
