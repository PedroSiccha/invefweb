<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recibe extends Model
{
    use HasFactory;
    protected $table = 'recibe';
    protected $fillable = ['id', 'empleado_id'];

    public static function recEmp($id){
    	return Recibe::where('empleado_id', '=', $id) -> get();
    }
}
