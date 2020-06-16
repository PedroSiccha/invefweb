<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Distrito extends Model
{
    protected $table = 'distrito';
    protected $fillable = ['id', 'distrito', 'provincia_id'];

    public static function disPro($id){
    	return Distrito::where('provincia_id', '=', $id) -> get();
    }
}
