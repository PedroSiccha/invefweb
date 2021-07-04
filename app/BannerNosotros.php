<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BannerNosotros extends Model
{
    protected $table = 'banernosotros';
    protected $fillable = ['id', 'titulo', 'descripcion', 'imagen', 'estado'];
}
