<?php

namespace App\Http\Controllers;

use App\Models\Proceso;
use App\Models\Semaforo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SemaforoController extends Controller
{
    public function actualizarSemaforo(Request $request)
    {
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        
        $cliente_id = $request->cliente_id;
        
        $semaforo = DB::SELECT('SELECT cliente_id, rojo, ambar, verde, estado FROM semaforo WHERE cliente_id = "'.$request->cliente_id.'"');
        
        $colorRed = DB::SELECT('SELECT COUNT(c.cliente_id) AS cantidad, c.cliente_id, DATEDIFF(DATE(NOW()), p.fecfin) AS dias 
                                 FROM `prestamo` p, `cotizacion` c 
                                 WHERE p.cotizacion_id = c.id AND c.cliente_id = "'.$cliente_id.'" AND p.estado = "VENDIDO" AND p.sede_id = "'.$idSucursal.'"');
        
        $colorAmbar = DB::SELECT('SELECT COUNT(c.cliente_id) AS cantidad, c.cliente_id, DATEDIFF(DATE(NOW()), p.fecfin) AS dias, DATEDIFF(DATE(NOW()), p.fecinicio) AS dias_created 
                                   FROM `prestamo` p, `cotizacion` c 
                                   WHERE p.cotizacion_id = c.id AND c.cliente_id = "'.$cliente_id.'" AND p.estado = "LIQUIDACION" AND p.sede_id = "'.$idSucursal.'"');
                                 
        $colorGreen = DB::SELECT('SELECT COUNT(c.cliente_id) AS cantidad, c.cliente_id, DATEDIFF(DATE(NOW()), p.fecfin) AS dias, DATEDIFF(DATE(NOW()), p.fecinicio) AS dias_created 
                                   FROM `prestamo` p, `cotizacion` c 
                                   WHERE p.cotizacion_id = c.id AND c.cliente_id = "'.$cliente_id.'" AND (p.estado != "LIQUIDACION" OR p.estado != "VENDIDO") AND p.estado = "ACTIVO DESEMBOLSADO" AND p.sede_id = "'.$idSucursal.'";');
        
        $listGreen = DB::SELECT('SELECT MAX(DATEDIFF(DATE(NOW()), p.fecinicio)) AS max_list, c.cliente_id, DATEDIFF(DATE(NOW()), p.fecfin) AS dias, DATEDIFF(DATE(NOW()), p.fecinicio) AS dias_created 
                                  FROM `prestamo` p, `cotizacion` c 
                                  WHERE p.cotizacion_id = c.id AND c.cliente_id = "'.$cliente_id.'" AND (p.estado != "LIQUIDACION" OR p.estado != "VENDIDO") AND p.estado = "ACTIVO DESEMBOLSADO" AND p.sede_id = "'.$idSucursal.'"');
        
        $semaforoRojo = 0;
        $semaforoAmbar = 0;
        $semaforoVerde = 0;
        
        if ($colorRed[0]->cantidad == null){
            $colorRed[0]->cantidad = 0;
        }
        
        if ($colorAmbar[0]->cantidad == null){
            $colorAmbar[0]->cantidad = 0;
        }
        
        if ($colorGreen[0]->cantidad == null){
            $colorGreen[0]->cantidad = 0;
        }
        
        if ($colorGreen[0]->dias_created > 45) {
            $colorGreen[0]->cantidad = 0;
            $colorAmbar[0]->cantidad = 1;
        }
        
        if ($listGreen[0]->max_list > 45) {
            $colorGreen[0]->cantidad = 0;
            $colorAmbar[0]->cantidad = 1;
        }
        
        if ($semaforo != null){
            $semaforoRojo = $semaforo[0]->rojo;
            $semaforoAmbar = $semaforo[0]->ambar;
            $semaforoVerde = $semaforo[0]->verde;
        }
        
        if ($colorRed[0]->cantidad <= $semaforoRojo) {
            $colorRed[0]->cantidad = $semaforoRojo;
        }
        
        if ($colorAmbar[0]->cantidad <= $semaforoAmbar) {
            $colorAmbar[0]->cantidad = $semaforoAmbar;
        }
        
        if ($colorGreen[0]->cantidad <= $semaforoVerde) {
            $colorGreen[0]->cantidad = $semaforoVerde;
        }
        
        $aux = 0;
        
        $resultSemaforo = "VERDE";
        
        if ($semaforo != null) {
            
            if ($semaforo[0]->estado == "PERSONALIZADO") {
                $aux = 1;
            } else {
                $sem = Semaforo::where('cliente_id', '=', $cliente_id)->first();
                $sem->cliente_id = $cliente_id;
                $sem->rojo = $colorRed[0]->cantidad;
                $sem->ambar = $colorAmbar[0]->cantidad;
                $sem->verde = $colorGreen[0]->cantidad;
                if($sem->save()){
                    $aux = 1;
                }
            }
        } else {
            $sem = new Semaforo();
            $sem->cliente_id = $cliente_id;
            $sem->rojo = $colorRed[0]->cantidad;
            $sem->ambar = $colorAmbar[0]->cantidad;
            $sem->verde = $colorGreen[0]->cantidad;
            $sem->estado = "NUEVO";
            if($sem->save()){
                $aux = 1;
            }
        }
        
        if($aux = 1) {
            $luzSemaforo = DB::SELECT('SELECT * FROM semaforo WHERE cliente_id = "'.$cliente_id.'"');
            
            if($luzSemaforo[0]->rojo >= 1) {
                $resultSemaforo = "ROJO";
            } else {
                if($luzSemaforo[0]->ambar >= 1) {
                    $resultSemaforo = "AMBAR";    
                }
            }
                
        }
        
        return response()->json(["view"=>view('atencioncliente.tabSemaforo',compact('aux', 'resultSemaforo'))->render()]);
    }

    public function obtenerSemaforo(Request $request)
    {
        $cliente_id = $request->cliente_id;
        $resultSemaforo = "VERDE";    
        
        $luzSemaforo = DB::SELECT('SELECT * FROM semaforo WHERE cliente_id = "'.$cliente_id.'"');
        
        if($luzSemaforo != null) {
            if($luzSemaforo[0]->rojo >= 1) {
                $resultSemaforo = "ROJO";
            } else {
                if($luzSemaforo[0]->ambar >= 1) {
                    $resultSemaforo = "AMBAR";    
                } else {
                    $resultSemaforo = "VERDE";    
                }
            }
        }
        
        return response()->json(["view"=>view('atencioncliente.tabSemaforo',compact('resultSemaforo'))->render()]);
    }
    

    public function personalizarSemaforo(Request $request)
    {
        
        $cliente_id = $request->cliente_id;
        
        $color = $request->color;
        
        $estado = $request->estadoVal;
        
        $verde = 0;
        
        $ambar = 0;
        
        $rojo = 0;
        
        $resultSemaforo = "VERDE";   
        
        switch ($color) {
            case "VERDE":
                $verde = 1;
                $ambar = 0;
                $rojo = 0;
                break;
            case "AMBAR":
                $verde = 0;
                $ambar = 1;
                $rojo = 0;
                break;
            case "ROJO":
                $verde = 0;
                $ambar = 0;
                $rojo = 1;
                break;
        }
        
        
        
        $sem = Semaforo::where('cliente_id', '=', $cliente_id)->first();
        $sem->cliente_id = $cliente_id;
        $sem->rojo = $rojo;
        $sem->ambar = $ambar;
        $sem->verde = $verde;
        $sem->estado = $estado;
        if($sem->save()){
            $aux = 1;
        }
        
        if($aux = 1) {
            $luzSemaforo = DB::SELECT('SELECT * FROM semaforo WHERE cliente_id = "'.$cliente_id.'"');
            
            if($luzSemaforo[0]->rojo >= 1) {
                $resultSemaforo = "ROJO";
            } else {
                if($luzSemaforo[0]->ambar >= 1) {
                    $resultSemaforo = "AMBAR";    
                }
            }
                
        }
        
        return response()->json(["view"=>view('atencioncliente.tabSemaforo',compact('aux', 'resultSemaforo'))->render()]);
        
    }

}
