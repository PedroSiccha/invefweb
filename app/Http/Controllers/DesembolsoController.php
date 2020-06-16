<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Desembolso;
use App\Prestamo;
use App\Movimiento;
use App\Caja;

class DesembolsoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response    
     */
    public function desembolso()
    {
        $user = Auth::user();
        $usuario = \DB::SELECT('SELECT e.nombre, e.apellido, e.id, u.name AS area, e.foto AS foto, e.sede_id AS sede
                                FROM empleado e, users u 
                                WHERE e.users_id = u.id AND u.id = "'.$user->id.'"');

        $notificacion = \DB::SELECT('SELECT * FROM  notificacion WHERE estado = "PENDIENTE" AND sede = "'.$usuario[0]->sede.'"');

        if ($notificacion == null) {
            $notificacion = \DB::SELECT('SELECT "" AS icono, "" AS asunto, "00:00:00" AS tiempo');
        }

        $cantNotificaciones = \DB::SELECT('SELECT COUNT(*) AS cant FROM notificacion WHERE estado = "PENDIENTE" AND sede = "'.$usuario[0]->sede.'"');

        if($cantNotificaciones == null){
            $cantNotificaciones = \DB::SELECT('SELECT "0" AS cant');
        }

        $prestamo = \DB::SELECT('SELECT p.id AS prestamo_id, cl.nombre, cl.apellido, cl.dni, p.created_at  
                                 FROM prestamo p, cotizacion c, cliente cl
                                 WHERE p.cotizacion_id = c.id AND c.cliente_id = cl.id AND p.estado = "ACTIVO"');

        return view('desembolso.desembolso', compact('prestamo', 'usuario', 'notificacion', 'cantNotificaciones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function desembolsar(Request $request)
    {
        
        $desm = \DB::SELECT('SELECT MAX(id) AS id 
                             FROM desembolso');
        $prestamo = \DB::SELECT('SELECT * 
                                 FROM prestamo 
                                 WHERE id = "'.$request->id.'"');
        $users_id = Auth::user()->id;
        $empleado = \DB::SELECT('SELECT e.id AS id 
                                 FROM empleado e 
                                 WHERE e.users_id = "'.$users_id.'"');
        $empleado_id = $empleado[0]->id;
        $tipocaja = \DB::SELECT('SELECT * 
                                 FROM tipocaja 
                                 WHERE tipo = "caja chica"');
        $caja = \DB::SELECT('SELECT MAX(id) AS id 
                FROM caja 
                WHERE estado = "ABIERTA" AND tipocaja_id = "'.$tipocaja[0]->id.'" AND sede_id = "'.$prestamo[0]->sede_id.'"');
        $garantia = \DB::SELECT('SELECT g.* FROM prestamo p
                    INNER JOIN cotizacion c ON p.cotizacion_id = c.id
                    INNER JOIN garantia g ON c.garantia_id = g.id
                    WHERE p.id = "'.$request->id.'"');
        $maxCaja = \DB::SELECT('SELECT MAX(id) AS id, monto 
                FROM caja 
                WHERE estado = "abierta" AND tipocaja_id = "'.$tipocaja[0]->id.'" AND sede_id = "'.$prestamo[0]->sede_id.'"');
        $nuevoMonto = $maxCaja[0]->monto - $prestamo[0]->monto;

        if ($desm[0]->id == null) {
            $numero = "1";  
        }else {
            $numero = $desm[0]->id + 1;
        }

        $des = new Desembolso();
        $des->numero = $numero;
        $des->estado = "DESEMBOLSADO";
        $des->monto = $prestamo[0]->monto;
        $des->prestamo_id = $request->id;
        $des->empleado_id = $empleado_id;
        $des->sede_id = $prestamo[0]->sede_id;

        if ($des->save()) {
            $pre = Prestamo::where('id', '=', $request->id)->first();
            $pre->estado = "ACTIVO DESEMBOLSADO";

            if ($pre->save()) {

                $desembolso = \DB::SELECT('SELECT MAX(id) AS id FROM desembolso WHERE estado = "DESEMBOLSADO"');

                $mov = new Movimiento();
                $mov->estado = "ACTIVO";
                $mov->monto = $prestamo[0]->monto;
                $mov->concepto = "DESEMBOLSO EN EFECTIVO. CODIGI: ".$request->id;
                $mov->tipo = "EGRESO";
                $mov->empleado = $empleado_id;
                $mov->importe = $prestamo[0]->monto;
                $mov->codigo = "N";
                $mov->serie = "cc";
                $mov->caja_id = $caja[0]->id;
                $mov->codprestamo = $request->id;
                $mov->condesembolso = $desembolso[0]->id;
                $mov->codgarantia = $garantia[0]->id;
                $mov->garantia = $garantia[0]->nombre;

                if ($mov->save()) {

                    

                    $caja = Caja::where('id', '=', $maxCaja[0]->id)->first();
                    $caja->monto = $nuevoMonto;
                    $caja->save();

                    $prestamo = \DB::SELECT('SELECT p.id AS prestamo_id, cl.nombre, cl.apellido, cl.dni, p.created_at  
                                 FROM prestamo p, cotizacion c, cliente cl
                                 WHERE p.cotizacion_id = c.id AND c.cliente_id = cl.id AND p.estado = "ACTIVO"');

                    return response()->json(["view"=>view('desembolso.tabDesembolso',compact('prestamo'))->render()]);
                }
            }
        }
    }

    public function desembolsarDeposito(Request $request)
    {
        $cuenta = $request->numCuenta;
        $banco = $request->banco;
        $descuento = $request->descuento;

        $desm = \DB::SELECT('SELECT MAX(id) AS id 
                             FROM desembolso');
        $prestamo = \DB::SELECT('SELECT * 
                                 FROM prestamo 
                                 WHERE id = "'.$request->id.'"');
        $users_id = Auth::user()->id;
        $empleado = \DB::SELECT('SELECT e.id AS id 
                                 FROM empleado e 
                                 WHERE e.users_id = "'.$users_id.'"');
        $empleado_id = $empleado[0]->id;
        $tipocaja = \DB::SELECT('SELECT * 
                                 FROM tipocaja 
                                 WHERE codigo = "b"');
                   
        $caja = \DB::SELECT('SELECT MAX(id) AS id 
                             FROM caja 
                             WHERE tipocaja_id = "'.$tipocaja[0]->id.'" AND sede_id = "'.$prestamo[0]->sede_id.'"');

        $garantia = \DB::SELECT('SELECT g.* FROM prestamo p
                                 INNER JOIN cotizacion c ON p.cotizacion_id = c.id
                                 INNER JOIN garantia g ON c.garantia_id = g.id
                                 WHERE p.id = "'.$request->id.'"');
        $maxCaja = \DB::SELECT('SELECT MAX(id) AS id, monto 
                                FROM caja 
                                WHERE estado = "abierta" AND tipocaja_id = "'.$tipocaja[0]->id.'" AND sede_id = "'.$prestamo[0]->sede_id.'"');
        $nuevoMonto = $maxCaja[0]->monto - $prestamo[0]->monto - $descuento;
        
        if ($desm[0]->id == null) {
            $numero = "1";  
        }else {
            $numero = $desm[0]->id + 1;
        }
        $des = new Desembolso();
        $des->numero = $numero;
        $des->estado = "DESEMBOLSADO";
        $des->monto = $prestamo[0]->monto;
        $des->prestamo_id = $request->id;
        $des->empleado_id = $empleado_id;
        $des->sede_id = $prestamo[0]->sede_id;
        if ($des->save()) {

            $pre = Prestamo::where('id', '=', $request->id)->first();
            $pre->estado = "ACTIVO DESEMBOLSADO";
            if ($pre->save()) {

                $desembolso = \DB::SELECT('SELECT MAX(id) AS id FROM desembolso WHERE estado = "DESEMBOLSADO"');

                $mov = new Movimiento();
                $mov->estado = "ACTIVO";
                $mov->monto = $prestamo[0]->monto;
                $mov->concepto = "DESEMBOLSO POR DEPÓSITO, ".$banco." Codigo: ".$request->id;
                $mov->tipo = "EGRESO";
                $mov->empleado = $empleado_id;
                $mov->importe = $prestamo[0]->monto;
                $mov->codigo = "N";
                $mov->serie = $banco."-".$cuenta;
                $mov->caja_id = $caja[0]->id;
                $mov->codprestamo = $request->id;
                $mov->condesembolso = $desembolso[0]->id;
                $mov->codgarantia = $garantia[0]->id;
                $mov->garantia = $garantia[0]->nombre;

                if ($mov->save()) {
                    
                    $caja = Caja::where('id', '=', $maxCaja[0]->id)->first();
                    $caja->monto = $nuevoMonto;
                    $caja->save();

                    $prestamo = \DB::SELECT('SELECT p.id AS prestamo_id, cl.nombre, cl.apellido, cl.dni, p.created_at  
                                 FROM prestamo p, cotizacion c, cliente cl
                                 WHERE p.cotizacion_id = c.id AND c.cliente_id = cl.id AND p.estado = "ACTIVO"');

                    return response()->json(["view"=>view('desembolso.tabDesembolso',compact('prestamo'))->render()]);
                }
            }
        }

        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function printBoucherDesembolso()
    {
        $maxDesembolso = \DB::SELECT('SELECT MAX(id) AS id FROM desembolso WHERE estado = "DESEMBOLSADO"');

        $desembolso = \DB::SELECT('SELECT d.estado, d.monto, d.created_at, cl.nombre, cl.apellido, cl.dni, g.nombre AS garantia 
                                   FROM desembolso d, prestamo p, empleado e, cotizacion c, cliente cl, garantia g
                                   WHERE d.prestamo_id = p.id AND d.empleado_id = e.id AND p.cotizacion_id = c.id AND c.cliente_id = cl.id AND c.garantia_id = g.id AND d.id = "'.$maxDesembolso[0]->id.'"');

        return view('desembolso.printBoucherDesembolso', compact('desembolso'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function buscarDesembolso(Request $request)
    {
        $dato = $request->dato;

        $prestamo = \DB::SELECT('SELECT p.id AS prestamo_id, cl.nombre, cl.apellido, cl.dni, p.created_at  
                                 FROM prestamo p, cotizacion c, cliente cl
                                 WHERE p.cotizacion_id = c.id AND c.cliente_id = cl.id AND p.estado = "ACTIVO" AND (cl.nombre LIKE "%'.$dato.'%" OR cl.apellido LIKE "%'.$dato.'%" OR cl.dni LIKE "%'.$dato.'%")');

        return response()->json(["view"=>view('desembolso.tabDesembolso',compact('prestamo'))->render()]);


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
