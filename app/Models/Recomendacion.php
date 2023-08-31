<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recomendacion extends Model
{
    protected $table = 'recomendacion';
    protected $fillable = ['id', 'recomendacion', 'detalle'];
}
