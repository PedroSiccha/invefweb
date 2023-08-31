<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BannerPregunta extends Model
{
    protected $table = 'bannerpreguntafrecuenta';
    protected $fillable = ['id', 'titulo', 'descripcion', 'imagen', 'estado'];
}
