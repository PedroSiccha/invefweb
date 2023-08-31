<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    use HasFactory;
    protected $table = 'movimiento';
    protected $fillable = ['id', 'codigo', 'serie', 'estado', 'monto', 'concepto', 'tipo', 'empleado', 'importe', 'codprestamo', 'condesembolso', 'codgarantia', 'garantia', 'interesPagar', 'moraPagar', 'caja_id'];

    public static function movCaj($id){
    	return Movimiento::where('caja_id', '=', $id) -> get();
    }
}
