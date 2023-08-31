<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoPrestamo extends Model
{
    protected $table = 'tipoprestamo';
    protected $fillable = ['id', 'nombre', 'detalle', 'imagen'];
}
