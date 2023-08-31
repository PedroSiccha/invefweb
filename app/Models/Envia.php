<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Envia extends Model
{
    use HasFactory;
    protected $table = 'envia';
    protected $fillable = ['id', 'empleado_id'];

    public static function envEmp($id){
    	return Envia::where('empleado_id', '=', $id) -> get();
    }
}
