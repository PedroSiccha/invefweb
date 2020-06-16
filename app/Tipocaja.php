<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipocaja extends Model
{
    protected $table = 'tipocaja';
    protected $fillable = ['id', 'tipo', 'codigo', 'detalle'];

}
