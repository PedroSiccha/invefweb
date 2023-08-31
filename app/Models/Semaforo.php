<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semaforo extends Model
{
    protected $table = 'semaforo';
    protected $fillable = ['id', 'cliente_id', 'rojo', 'ambar', 'verde', 'estado'];
}
