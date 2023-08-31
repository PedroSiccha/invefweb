<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    protected $table = 'menu';
    protected $fillable = ['id', 'nombre', 'url', 'orden', 'icono', 'menu_id'];

    public static function menMen($id){
    	return Menu::where('menu_id', '=', $id) -> get();
    }
}
