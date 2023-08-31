<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResumenEmpresa extends Model
{
    use HasFactory;
    protected $table = 'resumenempresa';
    protected $fillable = ['id', 'titulo', 'descripcion', 'icono', 'estado', 'fecinicio', 'fecfin'];
}
