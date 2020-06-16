<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menu';
    protected $fillable = ['id', 'nombre', 'url', 'orden', 'icono', 'menu_id'];

    public static function menMen($id){
    	return Menu::where('menu_id', '=', $id) -> get();
    }
}
