<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Planilla extends Model
{
    protected $table = 'planilla';
    protected $fillable = ['id', 'fecinicio', 'fecfin', 'monto'];

}
