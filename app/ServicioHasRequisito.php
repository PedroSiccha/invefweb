<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServicioHasRequisito extends Model
{
    protected $table = 'servicio_has_requisito';
    protected $fillable = ['id', 'Servicio_id', 'requisitos_servicio_idrequisitos_servicio'];

    public static function shrSer($id){
        return ServicioHasRequisito::where('Servicio_id', '=', $id) -> get();
    }

    public static function shrRs($id){
        return ServicioHasRequisito::where('requisitos_servicio_idrequisitos_servicio', '=', $id) -> get();
    }
}
