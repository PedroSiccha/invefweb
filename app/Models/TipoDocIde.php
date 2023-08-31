<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoDocIde extends Model
{
    protected $table = 'tipodocide';
    protected $fillable = ['id', 'nombre', 'descripcion'];
}
