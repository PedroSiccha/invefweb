<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PreguntaFrecuente extends Model
{
    protected $table = 'preguntafrecuente';
    protected $fillable = ['id', 'pregunta', 'respuesta', 'area', 'contacto', 'estado'];
}
