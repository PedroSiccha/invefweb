<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleResumenEmpresa extends Model
{
    protected $table = 'detalle_resumenempresa';
    protected $fillable = ['id', 'titulo', 'detalle', 'imagen', 'icono', 'estado', 'resumenEmpresa_id'];

    public static function detEmp($id){
        return DetalleResumenEmpresa::where('resumenEmpresa_id', '=', $id) -> get();
    }
}
