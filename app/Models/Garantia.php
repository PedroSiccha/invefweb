<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Garantia extends Model
{
    use HasFactory;
    protected $table = 'garantia';
    protected $fillable = ['id', 'nombre', 'detalle', 'estado', 'tipogarantia_id'];

    public static function garTga($id){
    	return Garantia::where('tipogarantia_id', '=', $id) -> get();
    }
}
