<?php

namespace App\Http\Controllers;

use App\Models\Caja;
use App\Models\Casillero;
use App\Models\Movimiento;
use App\Models\Pago;
use App\Models\Prestamo;
use App\Models\Proceso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LiquidacionController extends Controller
{
    public function producto()
    {
        $user = Auth::user();
        $usuario = DB::SELECT('SELECT e.nombre, e.apellido, e.id, u.name AS area, e.foto AS foto, e.sede_id AS sede
                                FROM empleado e, users u 
                                WHERE e.users_id = u.id AND u.id = "' . $user->id . '"');
                                
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;

        $listLiquidacion = DB::SELECT('SELECT p.id AS prestamo_id, p.fecinicio, p.fecfin, p.color_estado AS color_estado, p.fecagendar AS fecagendar, cl.nombre, cl.apellido, cl.dni, cl.facebook, cl.correo, g.nombre AS garantia, p.monto, p.intpagar*2 AS interes, m.mora*15 AS mora, p.monto+m.mora*15+p.intpagar*2 AS total, cl.id AS cliente_id
                                         FROM prestamo p, cotizacion c, cliente cl, garantia g, mora m
                                         WHERE p.cotizacion_id = c.id AND c.cliente_id = cl.id AND c.garantia_id = g.id AND p.mora_id = m.id AND p.estado = "LIQUIDACION" AND p.sede_id = "' . $idSucursal . '" ORDER BY p.orden ASC');

        return view('liquidacion.producto', compact('usuario', 'listLiquidacion'));
    }
    
    public function buscarProdLiquidacion(Request $request)
    {
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;
        
        $user = Auth::user();
        $usuario = DB::SELECT('SELECT e.nombre, e.apellido, e.id, u.name AS area, e.foto AS foto, e.sede_id AS sede
                                FROM empleado e, users u 
                                WHERE e.users_id = u.id AND u.id = "' . $user->id . '"');
        
        $dato = $request->dato;
        
        $listLiquidacion = DB::SELECT('SELECT p.id AS prestamo_id, p.fecinicio, p.fecfin, p.color_estado AS color_estado, p.fecagendar AS fecagendar, cl.nombre, cl.apellido, cl.dni, cl.facebook, cl.correo, g.nombre AS garantia, p.monto, p.intpagar*2 AS interes, m.mora*15 AS mora, p.monto+m.mora*15+p.intpagar*2 AS total, cl.id AS cliente_id
                                         FROM prestamo p, cotizacion c, cliente cl, garantia g, mora m
                                         WHERE p.cotizacion_id = c.id AND c.cliente_id = cl.id AND c.garantia_id = g.id AND p.mora_id = m.id AND p.estado = "LIQUIDACION" AND p.sede_id = "' . $idSucursal . '" AND (cl.nombre LIKE "%'.$dato.'%" OR cl.apellido LIKE "%'.$dato.'%" OR cl.dni LIKE "%'.$dato.'%" OR p.id LIKE "%'.$dato.'%") ');
                                         
        $cantLiquidacion = COUNT($listLiquidacion);

        return response()->json(["view" => view('liquidacion.tabLiquidacion', compact('listLiquidacion'))->render(), "cont" => view('liquidacion.cantLiquidacion', compact('cantLiquidacion'))->render()]);
    }

    public function venderGarantia(Request $request)
    {
        
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;
        
        $montoExtra = 0;
        $total = $request->total;
        $importe = $request->importe;
        $idPrestamo = $request->idPrestamo;
        $interes = $request->interes;
        $user = Auth::user();
        $usuario = DB::SELECT('SELECT e.nombre, e.apellido, e.id, u.name AS area, e.foto AS foto, e.sede_id AS sede
                                FROM empleado e, users u 
                                WHERE e.users_id = u.id AND e.sede_id = "'.$idSucursal.'" AND u.id = "' . $user->id . '"');
                                
        $respuesta = "";
                                
        if ($importe > $total) {
            $montoExtra = $importe - $total;
        }

        $prestamo = DB::SELECT('SELECT * FROM prestamo WHERE sede_id = "'.$idSucursal.'" AND id = "' . $idPrestamo . '"');
        $caja = DB::SELECT('SELECT MAX(id) AS id FROM caja WHERE sede_id = "'.$idSucursal.'" AND estado = "ABIERTA"');
        $garantia = DB::SELECT('SELECT g.id AS garantia_id, g.nombre AS garantia FROM prestamo p, cotizacion c, garantia g WHERE p.sede_id = "'.$idSucursal.'" AND p.cotizacion_id = c.id AND c.garantia_id = g.id AND p.id = "' . $idPrestamo . '"');

        $calc = DB::SELECT('SELECT p.monto, i.porcentaje, m.mora 
                             FROM prestamo p, tipocredito_interes tci, interes i, mora m
                             WHERE p.sede_id = "'.$idSucursal.'" AND p.tipocredito_interes_id = tci.id AND tci.interes_id = i.id AND p.mora_id = m.id AND p.id = "' . $idPrestamo . '"');

        if ($total > $importe) {

            $listLiquidacion = DB::SELECT('SELECT p.id AS prestamo_id, p.fecinicio, p.fecfin, p.color_estado AS color_estado, p.fecagendar AS fecagendar, cl.nombre, cl.apellido, cl.dni, cl.facebook, cl.correo, g.nombre AS garantia, p.monto, p.intpagar*2 AS interes, m.mora*15 AS mora, p.monto+m.mora*15+p.intpagar*2 AS total, cl.id AS cliente_id
                                            FROM prestamo p, cotizacion c, cliente cl, garantia g, mora m
                                            WHERE p.sede_id = "'.$idSucursal.'" AND p.cotizacion_id = c.id AND c.cliente_id = cl.id AND c.garantia_id = g.id AND p.mora_id = m.id AND p.estado = "LIQUIDACION"');
                                            
            $respuesta = "El monto de la compra no puede ser menor al pago total";

            $aux = "0";
            
        } else {
            
            //if ($montoExtra > 0) {
                
                $pag = new Pago();
                $pag->codigo = "V";
                $pag->serie = $idPrestamo;
                $pag->monto = $total;
                $pag->importe = $importe;
                $pag->vuelto = 0;
                $pag->intpago = $interes;
                $pag->mora = $calc[0]->mora * 15;
                $pag->diaspasados = 0;
                $pag->tipocomprobante_id = 1;
                $pag->prestamo_id = $idPrestamo;
                $pag->empleado_id = $idEmpleado;
                $pag->sede_id = $idSucursal;
                $pag->save();
                
            //}
            
            $tipocaja = DB::SELECT('SELECT * FROM tipocaja WHERE codigo = "cc"');
            $cajaGrande = DB::SELECT('SELECT MAX(id) AS id FROM caja WHERE sede_id = "'.$idSucursal.'" AND tipocaja_id = "' . $tipocaja[0]->id . '"');

            $mov = new Movimiento();
            $mov->estado = "CAJA PRINCIPAL";
            $mov->monto = $request->total;
            $mov->concepto = "VENTA GARANTIA";
            $mov->tipo = "INGRESO";
            $mov->empleado = $usuario[0]->nombre . " " . $usuario[0]->apellido;
            $mov->importe = $request->importe;
            $mov->codigo = "V";
            $mov->serie = $garantia[0]->garantia_id;
            $mov->caja_id = $caja[0]->id;
            $mov->codprestamo = $idPrestamo;
            $mov->condesembolso = "1";
            $mov->codgarantia = $garantia[0]->garantia_id;
            $mov->garantia = $garantia[0]->garantia;
            $mov->interesPagar = $interes;
            $mov->moraPagar = $calc[0]->mora * 15;
            $mov->caja_id = $cajaGrande[0]->id;

            if ($mov->save()) {
                $pre = Prestamo::where('id', '=', $idPrestamo)->first();
                $pre->estado = "VENDIDO";

                if ($pre->save()) {

                    $cajaMonto = DB::SELECT('SELECT monto FROM caja WHERE sede_id = "'.$idSucursal.'" AND id = "'.$cajaGrande[0]->id.'"');
                    $actualizarCaja = $cajaMonto[0]->monto + $request->importe;

                    $ca = Caja::where('id', '=', $cajaGrande[0]->id)->first();
                    $ca->monto = $actualizarCaja;
                    if ($ca->save()) {

                        $garantia_casillero = DB::SELECT('SELECT casillero_id FROM garantia_casillero WHERE garantia_id = "' . $garantia[0]->garantia_id . '"');

                        $cas = Casillero::where('id', '=',  $garantia_casillero[0]->casillero_id)->first();
                        $cas->estado = "RECOGER";

                        $cas->save();

                        $aux = "1";
                        
                        $respuesta = "Venta realizada correctamente";

                        $listLiquidacion = DB::SELECT('SELECT p.id AS prestamo_id, p.fecinicio, p.fecfin, p.color_estado AS color_estado, p.fecagendar AS fecagendar, cl.nombre, cl.apellido, cl.dni, cl.facebook, cl.correo, g.nombre AS garantia, p.monto, p.intpagar*2 AS interes, m.mora*15 AS mora, p.monto+m.mora*15+p.intpagar*2 AS total, cl.id AS cliente_id
                                            FROM prestamo p, cotizacion c, cliente cl, garantia g, mora m
                                            WHERE p.sede_id = "'.$idSucursal.'" AND p.cotizacion_id = c.id AND c.cliente_id = cl.id AND c.garantia_id = g.id AND p.mora_id = m.id AND p.estado = "LIQUIDACION" ORDER BY p.orden ASC');
                    }
                }
            }
        }

        return response()->json(["view" => view('liquidacion.tabLiquidacion', compact('listLiquidacion',))->render(), "aux" => $aux, "respuesta" => $respuesta]);
    }

    public function vendido()
    {
        $user = Auth::user();
        $usuario = DB::SELECT('SELECT e.nombre, e.apellido, e.id, u.name AS area, e.foto AS foto, e.sede_id AS sede
                                FROM empleado e, users u 
                                WHERE e.users_id = u.id AND u.id = "' . $user->id . '"');
                                
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;

        $listVendido = DB::SELECT('SELECT p.id AS prestamo_id, p.monto AS montoPrestamo, (i.porcentaje*p.monto/100)*2 AS porcentajeInteres, m.mora*15 AS moraPrestamo, (p.monto + (i.porcentaje*p.monto/100)*2 +  m.mora*15) AS totalPrestamo, mo.importe AS pago, g.id AS garantia_id, g.nombre AS garantia
        FROM prestamo p, cotizacion c, garantia g, tipocredito_interes tci, interes i, mora m, movimiento mo
        WHERE p.cotizacion_id = c.id AND c.garantia_id = g.id AND p.tipocredito_interes_id = tci.id AND tci.interes_id = i.id AND p.mora_id = m.id AND mo.codprestamo = p.id AND p.estado = "VENDIDO" AND mo.codigo = "V" AND p.sede_id = "' . $idSucursal . '"');

        return view('liquidacion.vendido', compact('usuario', 'listVendido'));
    }

    public function agendarRecojo(Request $request)
    {
        $aux = "0";
        $idPrestamo = $request->idPrestamo;
        $fecAgendar = $request->fecAgendar;
        $color_estado = "bg-warning";
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;
        
        if($fecAgendar != null){
            
            $pre = Prestamo::where('id', '=', $idPrestamo)->first();
            $pre->fecagendar = $fecAgendar;
            $pre->color_estado = $color_estado;
            $pre->orden = "1";
    
            if ($pre->save()) {
    
                $user = Auth::user();
                $usuario = DB::SELECT('SELECT e.nombre, e.apellido, e.id, u.name AS area, e.foto AS foto, e.sede_id AS sede
                                        FROM empleado e, users u 
                                        WHERE e.users_id = u.id AND u.id = "' . $user->id . '"');
        
                $listLiquidacion = DB::SELECT('SELECT p.id AS prestamo_id, p.color_estado AS color_estado, p.fecagendar AS fecagendar, cl.nombre, cl.apellido, cl.dni, cl.facebook, g.nombre AS garantia, p.monto, p.intpagar*2 AS interes, m.mora*15 AS mora, p.monto+m.mora*15+p.intpagar*2 AS total, cl.id AS cliente_id
                                                 FROM prestamo p, cotizacion c, cliente cl, garantia g, mora m
                                                 WHERE p.cotizacion_id = c.id AND c.cliente_id = cl.id AND c.garantia_id = g.id AND p.mora_id = m.id AND p.estado = "LIQUIDACION" AND p.sede_id = "' . $idSucursal . '" ORDER BY p.orden ASC');
                                                 
                $aux = "1";
                
            }
            
        }

        return response()->json(["view" => view('liquidacion.tabLiquidacion', compact('listLiquidacion', 'aux', 'fecAgendar'))->render()]);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ponerVendido(Request $request)
    {
        
        $aux = "0";
        $idPrestamo = $request->idPrestamo;
        $color_estado = $request->colorEstado;
        $pre = Prestamo::where('id', '=', $idPrestamo)->first();
        $pre->fecagendar = null;
        $pre->color_estado = "bg-danger";
        $pre->orden = "2";
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;

        if ($pre->save()) {

            $user = Auth::user();
            $usuario = DB::SELECT('SELECT e.nombre, e.apellido, e.id, u.name AS area, e.foto AS foto, e.sede_id AS sede
                                    FROM empleado e, users u 
                                    WHERE e.users_id = u.id AND u.id = "' . $user->id . '"');
    
            $listLiquidacion = DB::SELECT('SELECT p.id AS prestamo_id, p.color_estado AS color_estado, p.fecagendar AS fecagendar, cl.nombre, cl.apellido, cl.dni, cl.facebook, g.nombre AS garantia, p.monto, p.intpagar*2 AS interes, m.mora*15 AS mora, p.monto+m.mora*15+p.intpagar*2 AS total, cl.id AS cliente_id
                                             FROM prestamo p, cotizacion c, cliente cl, garantia g, mora m
                                             WHERE p.cotizacion_id = c.id AND c.cliente_id = cl.id AND c.garantia_id = g.id AND p.mora_id = m.id AND p.estado = "LIQUIDACION" AND p.sede_id = "' . $idSucursal . '" ORDER BY p.orden ASC');
                                             
            $aux = "1";
        }

        return response()->json(["view" => view('liquidacion.tabLiquidacion', compact('listLiquidacion', 'aux'))->render()]);
    }

    public function listaAgendados()
    {
        $aux = "0";
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;
    
        $listAgendado = DB::SELECT('SELECT p.id AS prestamo_id, p.color_estado AS color_estado, p.fecagendar AS fecagendar, cl.nombre, cl.apellido, cl.dni, cl.facebook, g.nombre AS garantia, p.monto, p.intpagar*2 AS interes, m.mora*15 AS mora, p.monto+m.mora*15+p.intpagar*2 AS total, cl.id AS cliente_id 
                                     FROM prestamo p, cotizacion c, cliente cl, garantia g, mora m 
                                     WHERE p.sede_id = "'.$idSucursal.'" AND p.cotizacion_id = c.id AND c.cliente_id = cl.id AND c.garantia_id = g.id AND p.mora_id = m.id AND p.estado = "LIQUIDACION" AND (p.fecagendar BETWEEN DATE(NOW()) AND DATE(NOW()))');
                                             
        $aux = COUNT($listAgendado);
        
        return response()->json(["view" => view('liquidacion.tabAgendado', compact('listAgendado', 'aux'))->render()]);
        
    }

}