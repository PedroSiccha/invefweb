<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Turno extends Model
{
    protected $table = 'turno';
    protected $fillable = ['id', 'turno', 'detalle', 'horainicio', 'horafin'];

}
