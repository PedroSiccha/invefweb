<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    protected $table = 'movimiento';
    protected $fillable = ['id', 'codigo', 'serie', 'estado', 'monto', 'concepto', 'tipo', 'empleado', 'importe', 'codprestamo', 'condesembolso', 'codgarantia', 'garantia', 'interesPagar', 'moraPagar', 'caja_id'];

    public static function movCaj($id){
    	return Movimiento::where('caja_id', '=', $id) -> get();
    }
}
