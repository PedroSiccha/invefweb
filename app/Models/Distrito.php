<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Distrito extends Model
{
    use HasFactory;
    protected $table = 'distrito';
    protected $fillable = ['id', 'distrito', 'provincia_id'];

    public static function disPro($id){
    	return Distrito::where('provincia_id', '=', $id) -> get();
    }
}
