<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Requisitos extends Model
{
    protected $table = 'requisitos';
    protected $fillable = ['id', 'requisito', 'descripcion'];

}
