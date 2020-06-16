<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Interes extends Model
{
    protected $table = 'interes';
    protected $fillable = ['id', 'porcentaje', 'dias'];

}
