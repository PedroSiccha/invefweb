<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provincia extends Model
{
    use HasFactory;
    protected $table = 'provincia';
    protected $fillable = ['id', 'provincia', 'departamento_id'];

    public static function proDep($id){
    	return Provincia::where('departamento_id', '=', $id) -> get();
    }
}
