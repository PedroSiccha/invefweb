<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BannerPregunta extends Model
{
    protected $table = 'bannerpreguntafrecuenta';
    protected $fillable = ['id', 'titulo', 'descripcion', 'imagen', 'estado'];
}
