<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoGarantia extends Model
{
    protected $table = 'tipogarantia';
    protected $fillable = ['id', 'nombre', 'precMax', 'precMin', 'detalle', 'pureza'];
}
