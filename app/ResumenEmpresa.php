<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ResumenEmpresa extends Model
{
    protected $table = 'resumenempresa';
    protected $fillable = ['id', 'titulo', 'descripcion', 'icono', 'estado', 'fecinicio', 'fecfin'];
}
