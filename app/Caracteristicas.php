<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Caracteristicas extends Model
{
    protected $table = 'caracteristicas';
    protected $fillable = ['id', 'titulo', 'descripcion', 'icono', 'estado'];
}
