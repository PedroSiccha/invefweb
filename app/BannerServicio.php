<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BannerServicio extends Model
{
    protected $table = 'bannerservicios';
    protected $fillable = ['id', 'titulo', 'descripcion', 'imagen', 'estado'];
}
