<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mora extends Model
{
    protected $table = 'mora';
    protected $fillable = ['id', 'mora', 'max', 'min', 'estado'];
}
