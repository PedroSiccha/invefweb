<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resumen extends Model
{
    use HasFactory;
    protected $table = 'resumen';
    protected $fillable = ['id', 'titulo', 'subtitulo', 'descripcion', 'icono', 'estado', 'imagen', 'tituloboton', 'urlboton'];
}
