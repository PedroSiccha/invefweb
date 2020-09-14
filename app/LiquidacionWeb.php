<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LiquidacionWeb extends Model
{
    protected $table = 'liquidacionweb';
    protected $fillable = ['id', 'titulo', 'descripcion', 'estado'];
}
