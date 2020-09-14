<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nosotros extends Model
{
    protected $table = 'nosotros';
    protected $fillable = ['id', 'seccion', 'titulo', 'descripcion', 'foto', 'ubicacion', 'estado'];
}
