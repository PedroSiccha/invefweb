<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    protected $table = 'documento';
    protected $fillable = ['id', 'nombre', 'asunto', 'url', 'fecha', 'estado', 'tipodocumento_id'];

    public static function docTdo($id){
    	return Documento::where('tipodocumento_id', '=', $id) -> get();
    }
}
