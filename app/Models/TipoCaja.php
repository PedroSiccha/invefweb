<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoCaja extends Model
{
    use HasFactory;
    protected $table = 'tipocaja';
    protected $fillable = ['id', 'tipo', 'codigo', 'detalle', 'categoria'];
}
