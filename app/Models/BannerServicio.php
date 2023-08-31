<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BannerServicio extends Model
{
    use HasFactory;
    protected $table = 'bannerservicios';
    protected $fillable = ['id', 'titulo', 'descripcion', 'imagen', 'estado'];
}
