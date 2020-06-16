<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ocupacion extends Model
{
    protected $table = 'ocupacion';
    protected $fillable = ['id', 'nombre', 'detalle'];
}
