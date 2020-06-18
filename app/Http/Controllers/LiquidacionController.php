<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Movimiento;
use App\Prestamo;
use App\Casillero;
use App\Caja;

class LiquidacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function producto()
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

        $listLiquidacion = \DB::SELECT('SELECT p.id AS prestamo_id, cl.nombre, cl.apellido, cl.dni, g.nombre AS garantia, p.monto, p.intpagar*2 AS interes, m.mora*15 AS mora, p.monto+m.mora*15+p.intpagar*2 AS total, cl.id AS cliente_id
                                         FROM prestamo p, cotizacion c, cliente cl, garantia g, mora m
                                         WHERE p.cotizacion_id = c.id AND c.cliente_id = cl.id AND c.garantia_id = g.id AND p.mora_id = m.id AND p.estado = "LIQUIDACION"');

        return view('liquidacion.producto', compact('usuario', 'listLiquidacion', 'notificacion', 'cantNotificaciones'));
    }

    public function venderGarantia(Request $request)
    {
        $total = $request->total;
        $importe = $request->importe;
        $idPrestamo = $request->idPrestamo;
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
        
        $prestamo = \DB::SELECT('SELECT * FROM prestamo WHERE id = "'.$idPrestamo.'"');
        $caja = \DB::SELECT('SELECT MAX(id) AS id FROM caja WHERE estado = "ABIERTA"');
        $garantia = \DB::SELECT('SELECT g.id AS garantia_id, g.nombre AS garantia FROM prestamo p, cotizacion c, garantia g WHERE p.cotizacion_id = c.id AND c.garantia_id = g.id AND p.id = "'.$idPrestamo.'"');
                                
        $calc = \DB::SELECT('SELECT p.monto, i.porcentaje, m.mora 
                             FROM prestamo p, tipocredito_interes tci, interes i, mora m
                             WHERE p.tipocredito_interes_id = tci.id AND tci.interes_id = i.id AND p.mora_id = m.id AND p.id = "'.$idPrestamo.'"');
        
        if ($total > $importe) {

            $listLiquidacion = \DB::SELECT('SELECT p.id AS prestamo_id, cl.nombre, cl.apellido, cl.dni, g.nombre AS garantia, p.monto, p.intpagar*2 AS interes, m.mora*15 AS mora, p.monto+m.mora*15+p.intpagar*2 AS total
                                            FROM prestamo p, cotizacion c, cliente cl, garantia g, mora m
                                            WHERE p.cotizacion_id = c.id AND c.cliente_id = cl.id AND c.garantia_id = g.id AND p.mora_id = m.id AND p.estado = "LIQUIDACION"');

            $aux = "0";


            return response()->json(["view"=>view('liquidacion.tabLiquidacion',compact('listLiquidacion', 'aux', 'notificacion', 'cantNotificaciones'))->render()]);
        }else {
            //dd("Se puede Comprar");
            $tipocaja = \DB::SELECT('SELECT * FROM tipocaja WHERE codigo = "cg"');
            $cajaGrande = \DB::SELECT('SELECT MAX(id) AS id, monto FROM caja WHERE tipocaja_id = "'.$tipocaja[0]->id.'"');

            $mov = new Movimiento();
            $mov->estado = "CAJA PRINCIPAL";
            $mov->monto = $request->total;
            $mov->concepto = "VENTA GARANTIA";
            $mov->tipo = "INGRESO";
            $mov->empleado = $usuario[0]->nombre." ".$usuario[0]->apellido;
            $mov->importe = $request->importe;
            $mov->codigo = "V";
            $mov->serie = $garantia[0]->garantia_id;
            $mov->caja_id = $caja[0]->id;
            $mov->codprestamo = $idPrestamo;
            $mov->condesembolso = "1";
            $mov->codgarantia = $garantia[0]->garantia_id;
            $mov->garantia = $garantia[0]->garantia;
            $mov->interesPagar = ($calc[0]->porcentaje/100)*$calc[0]->monto;
            $mov->moraPagar = $calc[0]->mora*15;
            $mov->caja_id = $cajaGrande[0]->id;

            if ($mov->save()) {
                $pre = Prestamo::where('id', '=', $idPrestamo)->first();
                $pre->estado = "VENDIDO";

                if ($pre->save()) { 

                    
                    $actualizarCaja = $cajaGrande[0]->monto + $request->importe;

                    $ca = Caja::where('id', '=', $cajaGrande[0]->id)->first();
                    $ca->monto = $actualizarCaja;
                    if ($ca->save()) {
                        
                        $garantia_casillero = \DB::SELECT('SELECT casillero_id FROM garantia_casillero WHERE garantia_id = "'.$garantia[0]->garantia_id.'"');
                            
                        $cas = Casillero::where('id', '=',  $garantia_casillero[0]->casillero_id)->first();
                        $cas->estado = "RECOGER";

                        $cas->save();

                        $aux = "1";

                        $listLiquidacion = \DB::SELECT('SELECT p.id AS prestamo_id, cl.nombre, cl.apellido, cl.dni, g.nombre AS garantia, p.monto, p.intpagar*2 AS interes, m.mora*15 AS mora, p.monto+m.mora*15+p.intpagar*2 AS total
                                            FROM prestamo p, cotizacion c, cliente cl, garantia g, mora m
                                            WHERE p.cotizacion_id = c.id AND c.cliente_id = cl.id AND c.garantia_id = g.id AND p.mora_id = m.id AND p.estado = "LIQUIDACION"');

                        return response()->json(["view"=>view('liquidacion.tabLiquidacion',compact('listLiquidacion', 'aux'))->render()]);
                        
                    }

                    
                }
            }

            
        }

        
    }

    public function vendido()
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

        $listVendido = \DB::SELECT('SELECT p.id AS prestamo_id, p.monto AS montoPrestamo, (i.porcentaje*p.monto/100)*2 AS porcentajeInteres, m.mora*15 AS moraPrestamo, (p.monto + (i.porcentaje*p.monto/100)*2 +  m.mora*15) AS totalPrestamo, mo.importe AS pago, g.id AS garantia_id, g.nombre AS garantia
        FROM prestamo p, cotizacion c, garantia g, tipocredito_interes tci, interes i, mora m, movimiento mo
        WHERE p.cotizacion_id = c.id AND c.garantia_id = g.id AND p.tipocredito_interes_id = tci.id AND tci.interes_id = i.id AND p.mora_id = m.id AND mo.codprestamo = p.id AND p.estado = "VENDIDO" AND mo.codigo = "V"');

        return view('liquidacion.vendido', compact('usuario', 'listVendido', 'notificacion', 'cantNotificaciones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
