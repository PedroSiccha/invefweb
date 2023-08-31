<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formulario extends Model
{
    protected $table = 'formulario';
    protected $fillable = ['id', 'nombre', 'apellido', 'celular', 'correo'];
}
