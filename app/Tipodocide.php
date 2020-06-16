<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipodocide extends Model
{
    protected $table = 'tipodocide';
    protected $fillable = ['id', 'nombre', 'descripcion'];

}
