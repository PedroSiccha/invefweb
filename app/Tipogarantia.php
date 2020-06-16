<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipogarantia extends Model
{
    protected $table = 'tipogarantia';
    protected $fillable = ['id', 'nombre', 'precMax', 'precMin', 'detalle', 'pureza'];

}
