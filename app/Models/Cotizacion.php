<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cotizacion extends Model
{
    protected $table = 'cotizacion';
    protected $fillable = ['id', 'cliente_id', 'empleado_id', 'garantia_id', 'max', 'min', 'estado', 'tipoprestamo_id', 'precio', 'sede_id'];

    public static function cotCli($id){
    	return Cotizacion::where('cliente_id', '=', $id) -> get();
    }
    public static function cotEmp($id){
    	return Cotizacion::where('empleado_id', '=', $id) -> get();
    }
    public static function cotGar($id){
    	return Cotizacion::where('garantia_id', '=', $id) -> get();
    }
    public static function cotTpr($id){
    	return Cotizacion::where('tipoprestamo_id', '=', $id) -> get();
    }
    public static function cotSed($id){
    	return Cotizacion::where('sede_id', '=', $id) -> get();
    }
}
