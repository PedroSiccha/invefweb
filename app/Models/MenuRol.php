<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuRol extends Model
{
    protected $table = 'menurol';
    protected $fillable = ['id', 'menu_id', 'rol_id'];

    public static function mroMen($id){
    	return MenuRol::where('menu_id', '=', $id) -> get();
    }

    public static function mroRol($id){
    	return MenuRol::where('rol_id', '=', $id) -> get();
    }
}
