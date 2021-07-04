<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    protected $table = 'servicios';
    protected $fillable = ['id', 'titulo', 'resumen', 'imagen', 'estado', 'desc01', 'desc02', 'desc03', 'desc04', 'desc05'];
}
