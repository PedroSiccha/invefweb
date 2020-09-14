<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    protected $table = 'servicio';
    protected $fillable = ['id', 'titulo', 'descripcion', 'foto', 'icono', 'ubicacion', 'estado'];
}
