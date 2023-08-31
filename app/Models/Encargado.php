<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Encargado extends Model
{
    protected $table = 'encargado';
    protected $fillable = ['id', 'empleado_id'];

    public static function encEmp($id){
    	return Encargado::where('empleado_id', '=', $id) -> get();
    }
}
