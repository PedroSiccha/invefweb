<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreguntaFrecuente extends Model
{
    use HasFactory;
    protected $table = 'preguntafrecuente';
    protected $fillable = ['id', 'pregunta', 'respuesta', 'area', 'contacto', 'estado'];
}
