<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recibe extends Model
{
    protected $table = 'recibe';
    protected $fillable = ['id', 'empleado_id'];

    public static function recEmp($id){
    	return Recibe::where('empleado_id', '=', $id) -> get();
    }
}
