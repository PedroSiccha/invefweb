<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequisitoServicio extends Model
{
    protected $table = 'requisitos_servicio';
    protected $fillable = ['idrequisitos_servicio', 'titulo', 'detalle', 'foto', 'icono', 'estado'];
}
