<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ControlPatrimonio extends Model
{
    protected $table = 'control_patrimonial';
    protected $fillable = ['id', 'mes', 'numbermes', 'anio', 'monto', 'user_id', 'feccierre', 'horacierre', 'sede_id'];
}
