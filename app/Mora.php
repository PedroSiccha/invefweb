<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mora extends Model
{
    protected $table = 'mora';
    protected $fillable = ['id', 'mora', 'max', 'min', 'estado'];

}
