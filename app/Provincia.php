<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provincia extends Model
{
    protected $table = 'provincia';
    protected $fillable = ['id', 'provincia', 'departamento_id'];

    public static function proDep($id){
    	return Provincia::where('departamento_id', '=', $id) -> get();
    }
}
