<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recomendacion extends Model
{
    protected $table = 'recomendacion';
    protected $fillable = ['id', 'recomendacion', 'detalle'];
}
