<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipoprestamo extends Model
{
    protected $table = 'tipoprestamo';
    protected $fillable = ['id', 'nombre', 'detalle', 'imagen'];

}
