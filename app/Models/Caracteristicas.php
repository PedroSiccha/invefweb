<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caracteristicas extends Model
{
    protected $table = 'caracteristicas';
    protected $fillable = ['id', 'titulo', 'descripcion', 'icono', 'estado'];
}
