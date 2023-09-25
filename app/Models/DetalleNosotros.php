<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleNosotros extends Model
{
    use HasFactory;
    protected $table = 'detallenostros';
    protected $fillable = ['id', 'subtitulo', 'descripcion', 'imagen', 'nosotros_id'];

    public static function detNos($id){
    	return Nosotros::where('nosotros_id', '=', $id) -> get();
    }
}
