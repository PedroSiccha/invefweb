<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Direccion extends Model
{
    use HasFactory;
    protected $table = 'direccion';
    protected $fillable = ['id', 'direccion', 'referencia', 'distrito_id'];

    public static function dirDis($id){
    	return Direccion::where('distrito_id', '=', $id) -> get();
    }
}
