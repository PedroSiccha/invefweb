<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Direccion extends Model
{
    protected $table = 'direccion';
    protected $fillable = ['id', 'direccion', 'referencia', 'distrito_id'];

    public static function dirDis($id){
    	return Direccion::where('distrito_id', '=', $id) -> get();
    }
}
