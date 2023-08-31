<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    use HasFactory;
    protected $table = 'documento';
    protected $fillable = ['id', 'nombre', 'asunto', 'url', 'fecha', 'estado', 'tipodocumento_id'];

    public static function docTdo($id){
    	return Documento::where('tipodocumento_id', '=', $id) -> get();
    }
}
