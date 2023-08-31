<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $table = 'pago';
    protected $fillable = ['id', 'codigo', 'serie', 'monto', 'importe', 'vuelto', 'intpago', 'mora', 'diaspasados', 'tipocomprobante_id', 'prestamo_id', 'empleado_id', 'sede_id'];

    public static function pagPre($id){
    	return Pago::where('prestamo_id', '=', $id) -> get();
    }
    public static function pagEmp($id){
    	return Pago::where('empleado_id', '=', $id) -> get();
    }
    public static function pagTco($id){
    	return Pago::where('tipocomprobante_id', '=', $id) -> get();
    }
    public static function pagSed($id){
    	return Pago::where('sede_id', '=', $id) -> get();
    }
}
