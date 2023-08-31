<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BannerNosotros extends Model
{
    use HasFactory;
    protected $table = 'banernosotros';
    protected $fillable = ['id', 'titulo', 'descripcion', 'imagen', 'estado'];
}
