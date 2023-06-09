<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Envia extends Model
{
    protected $table = 'envia';
    protected $fillable = ['id', 'empleado_id'];

    public static function envEmp($id){
    	return Envia::where('empleado_id', '=', $id) -> get();
    }
}
