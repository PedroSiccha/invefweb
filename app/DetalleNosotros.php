<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleNosotros extends Model
{
    protected $table = 'detalles_nosotros';
    protected $fillable = ['id', 'subtitulo', 'descripcion', 'imagen', 'nosotros_id'];

    public static function detNos($id){
        return DetalleNosotros::where('nosotros_id', '=', $id) -> get();
    }
}
