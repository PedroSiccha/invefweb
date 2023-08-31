<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asistentes extends Model
{
    use HasFactory;
    protected $table = 'asistentes';
    protected $fillable = ['id', 'empleado_id'];

    public static function asiEmp($id){
    	return Asistentes::where('empleado_id', '=', $id) -> get();
    }
}
