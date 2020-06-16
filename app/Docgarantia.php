<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Docgarantia extends Model
{
    protected $table = 'docgarantia';
    protected $fillable = ['id', 'nombre', 'ruta', 'garantia_id'];

    public static function dgaGar($id){
    	return Docgarantia::where('garantia_id', '=', $id) -> get();
    }
}
