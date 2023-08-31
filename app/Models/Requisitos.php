<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requisitos extends Model
{
    protected $table = 'requisitos';
    protected $fillable = ['id', 'requisito', 'descripcion'];
}