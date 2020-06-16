<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Garantia;
use App\Cotizacion;
use App\Prestamo;
use App\Casillero;
use App\Movcaja;
use App\GarantiaCasillero;
use App\Cliente;
use App\Notificacion;
use Barryvdh\DomPDF\Facade as PDF;

class PrestamoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function evaluacion()
    {
        return view('prestamo.evaluacion');
    }

    public function valorJoyas(Request $request)
    {
        $id = $request->idTipoGarantia;

        $precios = \DB::SELECT('SELECT precMax, precMin FROM tipogarantia WHERE id = "'.$id.'"');

        $precMax = $precios[0]->precMax;
        $precMin = $precios[0]->precMin;

        return response()->json(['precMax'=>$precMax, 'precMin'=>$precMin]);
    }

    public function generarCotizacion(Request $request)
    {
        $tipoPrestamo = $request->tipoPrestamoCp;
        $cliente_id = $request->cliente_id;
        $users_id = Auth::user()->id;
        $empleado = \DB::SELECT('SELECT e.id AS id, e.sede_id AS sede_id FROM empleado e WHERE e.users_id = "'.$users_id.'"');
        $empleado_id = $empleado[0]->id;
        $cliente = \DB::SELECT('SELECT * FROM cliente WHERE id = "'.$cliente_id.'"');

        if($tipoPrestamo == "1"){

            $garantiaCP = new Garantia();
            $garantiaCP->nombre = $request->nomGarantiaCp;
            $garantiaCP->detalle = $request->detGarantiaCp;
            $garantiaCP->estado = "ACTIVO";
            $garantiaCP->tipogarantia_id = $request->tipoGarantiaCp;

            if ($garantiaCP->save()) {
                $garantia = \DB::SELECT('SELECT MAX(id) AS id FROM garantia');

                if ($request->casillero != null) {
                    $garcas = new GarantiaCasillero();
                    $garcas->garantia_id = $garantia[0]->id;
                    $garcas->casillero_id = $request->casillero;
                    $garcas->estado = "OCUPADO";
                    if ($garcas->save()) {
                        $cotizacionCp = new Cotizacion();
                        $cotizacionCp->max = $request->maxCp;
                        $cotizacionCp->min = $request->minCp;
                        $cotizacionCp->estado = "PRESTAMO";
                        $cotizacionCp->precio = $request->precRealCp;
                        $cotizacionCp->cliente_id = $cliente_id;
                        $cotizacionCp->empleado_id = $empleado_id;
                        $cotizacionCp->garantia_id = $garantia[0]->id;
                        $cotizacionCp->tipoprestamo_id = $tipoPrestamo;
                        $cotizacionCp->sede_id = $empleado[0]->sede_id;

                        if ($cotizacionCp->save()) {

                            $not = new Notificacion();
                            $not->mensaje = "El clinete: ".$cliente[0]->nombre." ".$cliente[0]->apellido.", realizó una cotización con la garantia ".$request->nomGarantiaCp;
                            $not->tiempo = date("H:m:s");
                            $not->asunto = "Nueva Cotización del cliente ".$cliente[0]->nombre." ".$cliente[0]->apellido;
                            $not->estado = "PENDIENTE";
                            $not->sede =  $empleado[0]->sede_id;
                            $not->tipo = "COTIZACION";
                            $not->tipo = $users_id;
                            $not->icono = "fa-archive";
                            if ($not->save()) {

                                $cas = Casillero::where('id', '=', $request->casillero)->first();
                                $cas->estado = "OCUPADO";
                                if ($cas->save()) {

                                    $cotizacion = \DB::SELECT('SELECT c.id AS cotizacion_id, c.max, c.min, c.created_at, c.estado, tp.nombre AS tipoPrestamo, g.nombre AS garantia
                                                            FROM cotizacion c, tipoprestamo tp, garantia g
                                                            WHERE c.garantia_id = g.id AND c.tipoprestamo_id = tp.id AND c.estado = "PRESTAMO" AND c.cliente_id = "'.$cliente_id.'"');

                                    $listCotizaciones = \DB::SELECT('SELECT c.id AS cotizacion_id, tp.nombre AS tipoPrestamo, g.nombre AS garantia, g.detalle AS detalleGarantia, c.max, c.min, CONCAT(e.nombre, " ", e.apellido) AS empleado 
                                                                    FROM cotizacion c, tipoprestamo tp, garantia g, empleado e 
                                                                    WHERE c.tipoprestamo_id = tp.id AND c.garantia_id = g.id AND c.empleado_id = e.id AND c.estado = "PRESTAMO" AND c.cliente_id = "'.$cliente_id.'"');

                                    $notificacion = \DB::SELECT('SELECT * FROM  notificacion WHERE estado = "PENDIENTE" AND sede = "'.$empleado[0]->sede_id.'"');

                                    if ($notificacion == null) {
                                        $notificacion = \DB::SELECT('SELECT "" AS icono, "" AS asunto, "00:00:00" AS tiempo');
                                    }

                                    $cantNotificaciones = \DB::SELECT('SELECT COUNT(*) AS cant FROM notificacion WHERE estado = "PENDIENTE" AND sede = "'.$empleado[0]->sede_id.'"');

                                    if($cantNotificaciones == null){
                                        $cantNotificaciones = \DB::SELECT('SELECT "0" AS cant');
                                    }

                                    return response()->json(["view"=>view('prestamo.lCotizar',compact('cotizacion'))->render(), "view2"=>view('prestamo.listaCotizaciones', compact('listCotizaciones'))->render(), "notificacion"=>view('notificaciones.areaNotificaciones', compact('notificacion', 'cantNotificaciones'))->render()]);
                                }
                            } 
                        }
                    }
                    

                    

                }else {
                    $cotizacionCp = new Cotizacion();
                    $cotizacionCp->max = $request->maxCp;
                    $cotizacionCp->min = $request->minCp;
                    $cotizacionCp->estado = "PENDIENTE";
                    $cotizacionCp->precio = $request->precRealCp;
                    $cotizacionCp->cliente_id = $cliente_id;
                    $cotizacionCp->empleado_id = $empleado_id;
                    $cotizacionCp->garantia_id = $garantia[0]->id;
                    $cotizacionCp->tipoprestamo_id = $tipoPrestamo;
                    $cotizacionCp->sede_id = $empleado[0]->sede_id;

                    if ($cotizacionCp->save()) {

                        $not = new Notificacion();
                        $not->mensaje = "El clinete: ".$cliente[0]->nombre." ".$cliente[0]->apellido.", realizó una cotización con la garantia ".$request->nomGarantiaCp;
                        $not->tiempo = date("H:m:s");
                        $not->asunto = "Nueva Cotización del cliente ".$cliente[0]->nombre." ".$cliente[0]->apellido;
                        $not->estado = "PENDIENTE";
                        $not->sede =  $empleado[0]->sede_id;
                        $not->tipo = "COTIZACION";
                        $not->tipo = $users_id;
                        $not->icono = "fa-archive";
                        if ($not->save()) {
                            $resultado = "Todo bien";
                            $notificacion = \DB::SELECT('SELECT * FROM  notificacion WHERE estado = "PENDIENTE" AND sede = "'.$empleado[0]->sede_id.'"');

                            if ($notificacion == null) {
                                $notificacion = \DB::SELECT('SELECT "" AS icono, "" AS asunto, "00:00:00" AS tiempo');
                            }

                            $cantNotificaciones = \DB::SELECT('SELECT COUNT(*) AS cant FROM notificacion WHERE estado = "PENDIENTE" AND sede = "'.$empleado[0]->sede_id.'"');

                            if($cantNotificaciones == null){
                                $cantNotificaciones = \DB::SELECT('SELECT "0" AS cant');
                            }

                            return response()->json(["view"=>view('prestamo.lCotizar')->render(), "view2"=>view('prestamo.listaCotizaciones')->render(), "notificacion"=>view('notificaciones.areaNotificaciones', compact('notificacion', 'cantNotificaciones'))->render()]);
                        }
                    }
                }
                

                
            }

        }elseif ($tipoPrestamo == "2") {
            
            $joya = \DB::SELECT('SELECT CONCAT(nombre, " ", pureza) AS nombre FROM tipogarantia WHERE id = "'.$request->tipoJoya.'"');

            $detalleCj = $request->pesoCj." gr, ".$request->detalleCj;

            $garantiaCJ = new Garantia();
            $garantiaCJ->nombre = $joya[0]->nombre;
            $garantiaCJ->detalle = $detalleCj;
            $garantiaCJ->estado = "ACTIVO";
            $garantiaCJ->tipogarantia_id = $request->tipoJoya;

            if ($garantiaCJ->save()) {
                $garantia = \DB::SELECT('SELECT MAX(id) AS id FROM garantia');

                /*Revisar Cotizacion */

                if ($request->casillero != null) {
                    $garcas = new GarantiaCasillero();
                    $garcas->garantia_id = $garantia[0]->id;
                    $garcas->casillero_id = $request->casillero;
                    $garcas->estado = "OCUPADO";
                    if ($garcas->save()) {
                        $cotizacionCj = new Cotizacion();
                        $cotizacionCj->max = $request->valorCj;
                        $cotizacionCj->min = "0";
                        $cotizacionCj->estado = "PRESTAMO";
                        $cotizacionCj->precio = $request->valorCj;
                        $cotizacionCj->cliente_id = $cliente_id;
                        $cotizacionCj->empleado_id = $empleado_id;
                        $cotizacionCj->garantia_id = $garantia[0]->id;
                        $cotizacionCj->tipoprestamo_id = $tipoPrestamo;
                        $cotizacionCj->sede_id = $empleado[0]->sede_id;
                        if ($cotizacionCj->save()) {

                            $not = new Notificacion();
                            $not->mensaje = "El clinete: ".$cliente[0]->nombre." ".$cliente[0]->apellido.", realizó una cotización con la garantia ".$request->nomGarantiaCp;
                            $not->tiempo = date("H:m:s");
                            $not->asunto = "Nueva Cotización del cliente ".$cliente[0]->nombre." ".$cliente[0]->apellido;
                            $not->estado = "PENDIENTE";
                            $not->sede =  $empleado[0]->sede_id;
                            $not->tipo = "COTIZACION";
                            $not->tipo = $users_id;
                            $not->icono = "fa-archive";
                            if ($not->save()) {
                                $cas = Casillero::where('id', '=', $request->casillero)->first();
                                $cas->estado = "OCUPADO";
                                if ($cas->save()) {

                                    $cotizacion = \DB::SELECT('SELECT c.id AS cotizacion_id, c.max, c.min, c.created_at, c.estado, tp.nombre AS tipoPrestamo, g.nombre AS garantia
                                                            FROM cotizacion c, tipoprestamo tp, garantia g
                                                            WHERE c.garantia_id = g.id AND c.tipoprestamo_id = tp.id AND c.estado = "PRESTAMO" AND c.cliente_id = "'.$cliente_id.'"');

                                    $listCotizaciones = \DB::SELECT('SELECT c.id AS cotizacion_id, tp.nombre AS tipoPrestamo, g.nombre AS garantia, g.detalle AS detalleGarantia, c.max, c.min, CONCAT(e.nombre, " ", e.apellido) AS empleado 
                                                                    FROM cotizacion c, tipoprestamo tp, garantia g, empleado e 
                                                                    WHERE c.tipoprestamo_id = tp.id AND c.garantia_id = g.id AND c.empleado_id = e.id AND c.estado = "PRESTAMO" AND c.cliente_id = "'.$cliente_id.'"');

                                    $notificacion = \DB::SELECT('SELECT * FROM  notificacion WHERE estado = "PENDIENTE" AND sede = "'.$empleado[0]->sede_id.'"');

                                    if ($notificacion == null) {
                                        $notificacion = \DB::SELECT('SELECT "" AS icono, "" AS asunto, "00:00:00" AS tiempo');
                                    }

                                    $cantNotificaciones = \DB::SELECT('SELECT COUNT(*) AS cant FROM notificacion WHERE estado = "PENDIENTE" AND sede = "'.$empleado[0]->sede_id.'"');

                                    if($cantNotificaciones == null){
                                        $cantNotificaciones = \DB::SELECT('SELECT "0" AS cant');
                                    }

                                    return response()->json(["view"=>view('prestamo.lCotizar',compact('cotizacion'))->render(), "view2"=>view('prestamo.listaCotizaciones', compact('listCotizaciones'))->render(), "notificacion"=>view('notificaciones.areaNotificaciones', compact('notificacion', 'cantNotificaciones'))->render()]);
                                }
                            }
                        }
                    }
                    

                    

                }else {
                    $cotizacionCp = new Cotizacion();
                    $cotizacionCp->max = $request->maxCp;
                    $cotizacionCp->min = $request->minCp;
                    $cotizacionCp->estado = "PENDIENTE";
                    $cotizacionCp->precio = $request->precRealCp;
                    $cotizacionCp->cliente_id = $cliente_id;
                    $cotizacionCp->empleado_id = $empleado_id;
                    $cotizacionCp->garantia_id = $garantia[0]->id;
                    $cotizacionCp->tipoprestamo_id = $tipoPrestamo;
                    $cotizacionCp->sede_id = $empleado[0]->sede_id;
                    if ($cotizacionCp->save()) {

                            $not = new Notificacion();
                            $not->mensaje = "El clinete: ".$cliente[0]->nombre." ".$cliente[0]->apellido.", realizó una cotización con la garantia ".$request->nomGarantiaCp;
                            $not->tiempo = date("H:m:s");
                            $not->asunto = "Nueva Cotización del cliente ".$cliente[0]->nombre." ".$cliente[0]->apellido;
                            $not->estado = "PENDIENTE";
                            $not->sede =  $empleado[0]->sede_id;
                            $not->tipo = "COTIZACION";
                            $not->tipo = $users_id;
                            $not->icono = "fa-archive";
                            if ($not->save()) {
                                $resultado = "Todo bien";

                                $notificacion = \DB::SELECT('SELECT * FROM  notificacion WHERE estado = "PENDIENTE" AND sede = "'.$empleado[0]->sede_id.'"');

                                if ($notificacion == null) {
                                    $notificacion = \DB::SELECT('SELECT "" AS icono, "" AS asunto, "00:00:00" AS tiempo');
                                }

                                $cantNotificaciones = \DB::SELECT('SELECT COUNT(*) AS cant FROM notificacion WHERE estado = "PENDIENTE" AND sede = "'.$empleado[0]->sede_id.'"');

                                if($cantNotificaciones == null){
                                    $cantNotificaciones = \DB::SELECT('SELECT "0" AS cant');
                                }

                                return response()->json(["view"=>view('prestamo.lCotizar')->render(), "view2"=>view('prestamo.listaCotizaciones')->render(), "notificacion"=>view('notificaciones.areaNotificaciones', compact('notificacion', 'cantNotificaciones'))->render()]);
                            }
                    }
                }
                /*Fin revisar Cotizacion */
            }

        }elseif ($tipoPrestamo == "3") {
            
            $garantiaCu = new Garantia();
            $garantiaCu->nombre = $request->nomGarantiaCu;
            $garantiaCu->detalle = $request->detGarantiaCu;
            $garantiaCu->estado = "ACTIVO";
            $garantiaCu->tipogarantia_id = $request->tipoGarantiaCu;

            if ($garantiaCu->save()) {
                $garantia = \DB::SELECT('SELECT MAX(id) AS id FROM garantia');

                /* Prueba */

                if ($request->casillero != null) {
                    $garcas = new GarantiaCasillero();
                    $garcas->garantia_id = $garantia[0]->id;
                    $garcas->casillero_id = $request->casillero;
                    $garcas->estado = "OCUPADO";
                    if ($garcas->save()) {
                        $cotizacionCj = new Cotizacion();
                        $cotizacionCj->max = $request->maxCu;
                        $cotizacionCj->min = $request->minCu;
                        $cotizacionCj->estado = "PRESTAMO";
                        $cotizacionCj->precio = $request->precRealCU;
                        $cotizacionCj->cliente_id = $cliente_id;
                        $cotizacionCj->empleado_id = $empleado_id;
                        $cotizacionCj->garantia_id = $garantia[0]->id;
                        $cotizacionCj->tipoprestamo_id = $tipoPrestamo;
                        $cotizacionCj->sede_id = $empleado[0]->sede_id;
                        if ($cotizacionCj->save()) {

                            $not = new Notificacion();
                            $not->mensaje = "El clinete: ".$cliente[0]->nombre." ".$cliente[0]->apellido.", realizó una cotización con la garantia ".$request->nomGarantiaCp;
                            $not->tiempo = date("H:m:s");
                            $not->asunto = "Nueva Cotización del cliente ".$cliente[0]->nombre." ".$cliente[0]->apellido;
                            $not->estado = "PENDIENTE";
                            $not->sede =  $empleado[0]->sede_id;
                            $not->tipo = "COTIZACION";
                            $not->tipo = $users_id;
                            $not->icono = "fa-archive";
                            if ($not->save()) {

                                $cas = Casillero::where('id', '=', $request->casillero)->first();
                                $cas->estado = "OCUPADO";
                                if ($cas->save()) {

                                    $cotizacion = \DB::SELECT('SELECT c.id AS cotizacion_id, c.max, c.min, c.created_at, c.estado, tp.nombre AS tipoPrestamo, g.nombre AS garantia
                                                            FROM cotizacion c, tipoprestamo tp, garantia g
                                                            WHERE c.garantia_id = g.id AND c.tipoprestamo_id = tp.id AND c.estado = "PRESTAMO" AND c.cliente_id = "'.$cliente_id.'"');

                                    $listCotizaciones = \DB::SELECT('SELECT c.id AS cotizacion_id, tp.nombre AS tipoPrestamo, g.nombre AS garantia, g.detalle AS detalleGarantia, c.max, c.min, CONCAT(e.nombre, " ", e.apellido) AS empleado 
                                                                    FROM cotizacion c, tipoprestamo tp, garantia g, empleado e 
                                                                    WHERE c.tipoprestamo_id = tp.id AND c.garantia_id = g.id AND c.empleado_id = e.id AND c.estado = "PRESTAMO" AND c.cliente_id = "'.$cliente_id.'"');

                                    $notificacion = \DB::SELECT('SELECT * FROM  notificacion WHERE estado = "PENDIENTE" AND sede = "'.$empleado[0]->sede_id.'"');

                                    if ($notificacion == null) {
                                        $notificacion = \DB::SELECT('SELECT "" AS icono, "" AS asunto, "00:00:00" AS tiempo');
                                    }

                                    $cantNotificaciones = \DB::SELECT('SELECT COUNT(*) AS cant FROM notificacion WHERE estado = "PENDIENTE" AND sede = "'.$empleado[0]->sede_id.'"');

                                    if($cantNotificaciones == null){
                                        $cantNotificaciones = \DB::SELECT('SELECT "0" AS cant');
                                    }

                                    return response()->json(["view"=>view('prestamo.lCotizar',compact('cotizacion'))->render(), "view2"=>view('prestamo.listaCotizaciones', compact('listCotizaciones'))->render(), "notificacion"=>view('notificaciones.areaNotificaciones', compact('notificacion', 'cantNotificaciones'))->render()]);
                                }
                            }
                        }
                    }
                    

                    

                }else {
                    $cotizacionCp = new Cotizacion();
                    $cotizacionCp->max = $request->maxCp;
                    $cotizacionCp->min = $request->minCp;
                    $cotizacionCp->estado = "PENDIENTE";
                    $cotizacionCp->precio = $request->precRealCp;
                    $cotizacionCp->cliente_id = $cliente_id;
                    $cotizacionCp->empleado_id = $empleado_id;
                    $cotizacionCp->garantia_id = $garantia[0]->id;
                    $cotizacionCp->tipoprestamo_id = $tipoPrestamo;
                    $cotizacionCp->sede_id = $empleado[0]->sede_id;
                    if ($cotizacionCp->save()) {

                        $not = new Notificacion();
                        $not->mensaje = "El clinete: ".$cliente[0]->nombre." ".$cliente[0]->apellido.", realizó una cotización con la garantia ".$request->nomGarantiaCp;
                        $not->tiempo = date("H:m:s");
                        $not->asunto = "Nueva Cotización del cliente ".$cliente[0]->nombre." ".$cliente[0]->apellido;
                        $not->estado = "PENDIENTE";
                        $not->sede =  $empleado[0]->sede_id;
                        $not->tipo = "COTIZACION";
                        $not->tipo = $users_id;
                        $not->icono = "fa-archive";
                        if ($not->save()) {
                            $resultado = "Todo bien";

                            $notificacion = \DB::SELECT('SELECT * FROM  notificacion WHERE estado = "PENDIENTE" AND sede = "'.$empleado[0]->sede_id.'"');

                            if ($notificacion == null) {
                                $notificacion = \DB::SELECT('SELECT "" AS icono, "" AS asunto, "00:00:00" AS tiempo');
                            }

                            $cantNotificaciones = \DB::SELECT('SELECT COUNT(*) AS cant FROM notificacion WHERE estado = "PENDIENTE" AND sede = "'.$empleado[0]->sede_id.'"');

                            if($cantNotificaciones == null){
                                $cantNotificaciones = \DB::SELECT('SELECT "0" AS cant');
                            }

                            return response()->json(["view"=>view('prestamo.lCotizar')->render(), "view2"=>view('prestamo.listaCotizaciones')->render(), "notificacion"=>view('notificaciones.areaNotificaciones', compact('notificacion', 'cantNotificaciones'))->render()]);
                        }
                    }
                }

                /* Fin Prueba */
            }

        }else {
            $aux = "Aun no establecido";
        }

        return response()->json(['resultado'=>$resultado]);
    }

    public function garantia()
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

        $garantia = \DB::SELECT('SELECT p.id AS prestamo_id, g.id AS garantia_id, g.nombre AS garantia, g.detalle AS detgarantia, CONCAT(ca.nombre, " - ", s.nombre, " - ", a.nombre) AS casillero, ca.estado
                                 FROM garantia g, cotizacion c, prestamo p, casillero ca, stand s, almacen a, garantia_casillero ga
                                 WHERE c.garantia_id = g.id AND p.cotizacion_id = c.id AND ga.garantia_id = g.id AND ga.casillero_id = ca.id AND ca.Stand_id = s.id AND s.Almacen_id = a.id AND ca.estado != "LIBRE"');
        return view('prestamo.garantia', compact('garantia', 'usuario', 'notificacion', 'cantNotificaciones'));
    }

    public function listcontrato()
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

        $prestamo = \DB::SELECT('SELECT p.id AS prestamo_id, cl.nombre, cl.apellido, cl.dni, g.nombre AS garantia, p.fecfin, cl.id AS cliente_id, p.fecinicio
                                 FROM prestamo p, cotizacion c, cliente cl, garantia g
                                 WHERE p.cotizacion_id = c.id AND c.cliente_id = cl.id AND c.garantia_id = g.id');
        return view('prestamo.listcontrato', compact('prestamo', 'usuario', 'notificacion', 'cantNotificaciones'));
    }

    public function macro()
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

        $sinMacro = \DB::SELECT('SELECT p.id AS prestamo_id, cl.dni, cl.nombre, cl.apellido, p.fecinicio, p.fecfin, p.monto, p.intpagar, m.mora
                                FROM prestamo p, cotizacion c, garantia g, cliente cl, mora m
                                WHERE p.cotizacion_id = c.id AND c.garantia_id = g.id AND p.mora_id = m.id AND c.cliente_id = cl.id AND p.estado = "ACTIVO DESEMBOLSADO" AND p.macro = "SIN MACRO" 
                                ORDER BY p.fecfin ASC');

        $conMacro = \DB::SELECT('SELECT p.id AS prestamo_id, cl.dni, cl.nombre, cl.apellido, p.fecinicio, p.fecfin, p.monto, p.intpagar, m.mora
                                 FROM prestamo p, cotizacion c, garantia g, cliente cl, mora m
                                 WHERE p.cotizacion_id = c.id AND c.garantia_id = g.id AND p.mora_id = m.id AND c.cliente_id = cl.id AND p.estado = "ACTIVO DESEMBOLSADO" AND p.macro = "CON MACRO"
                                 ORDER BY p.fecfin ASC');

        return view('prestamo.macro', compact('sinMacro', 'usuario', 'conMacro', 'notificacion', 'cantNotificaciones'));
    }

    public function prestamo($id)
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

        $cliente = \DB::SELECT('SELECT c.id, c.nombre, c.apellido, c.dni, CONCAT(d.direccion, " - ", di.distrito, " - ", p.provincia, " - ", de.departamento) AS direccion, c.evaluacion 
                                FROM cliente c, cotizacion co, direccion d, distrito di, provincia p, departamento de 
                                WHERE co.cliente_id = c.id AND c.direccion_id = d.id AND d.distrito_id = di.id AND di.provincia_id = p.id AND p.departamento_id = de.id AND co.id = "'.$id.'"');

        $cotizacion = \DB::SELECT('SELECT g.nombre AS producto, g.id AS garantia_id, c.id AS cotizacion_id, c.precio AS valorreal, c.max AS presmax, c.min AS presmin 
                                   FROM cotizacion c, garantia g 
                                   WHERE c.garantia_id = g.id AND c.id = "'.$id.'"');

        

        $interes = \DB::SELECT('SELECT i.* FROM tipocredito_interes ti
                                INNER JOIN interes i ON ti.interes_id = i.id
                                INNER JOIN tipoprestamo t ON ti.tipocredito_id = t.id
                                INNER JOIN cotizacion c ON c.tipoprestamo_id = t.id
                                WHERE c.id = "'.$id.'"');

        $mora = \DB::SELECT('SELECT * FROM mora');

        $almacen = \DB::SELECT('SELECT ca.nombre AS casillero, s.nombre AS stand, a.nombre AS almacen FROM garantia_casillero gc
                                INNER JOIN garantia g ON gc.garantia_id = g.id
                                INNER JOIN cotizacion c ON c.garantia_id = g.id
                                INNER JOIN casillero ca ON gc.casillero_id = ca.id
                                INNER JOIN stand s ON ca.stand_id = s.id
                                INNER JOIN almacen a ON s.almacen_id = a.id
                                WHERE c.id = "'.$id.'"');

        return view('prestamo.prestamo', compact('cliente', 'cotizacion', 'interes', 'mora', 'almacen', 'usuario', 'notificacion', 'cantNotificaciones'));
    }

    public function generarPrestamo(Request $request)
    {
        $users_id = Auth::user()->id;
        $empleado = \DB::SELECT('SELECT e.id AS id, e.sede_id AS sede_id 
                                 FROM empleado e 
                                 WHERE e.users_id = "'.$users_id.'"');
        $empleado_id = $empleado[0]->id;
        $tipocredito_interes = \DB::SELECT('SELECT id 
                                            FROM tipocredito_interes 
                                            WHERE interes_id = "'.$request->tipocredito_interes_id.'"');
        $cliente = \DB::SELECT('SELECT c.cliente_id, cl.evaluacion, cl.nombre, cl.apellido 
                                FROM cotizacion c, cliente cl 
                                WHERE c.cliente_id = cl.id AND c.id = "'.$request->cotizacion_id.'"');

        $nEvaluacion = $cliente[0]->evaluacion - 30;

        $result = "";

        if ($cliente[0]->evaluacion >= 30) {
            $prestamo = new Prestamo();
            $prestamo->codigo = "n";
            $prestamo->monto = $request->monto;
            $prestamo->fecinicio = $request->fecinicio;
            $prestamo->fecfin = $request->fecfin;
            $prestamo->total = $request->total;
            $prestamo->estado = "ACTIVO";
            $prestamo->cotizacion_id = $request->cotizacion_id;
            $prestamo->empleado_id = $empleado_id;
            $prestamo->tipocredito_interes_id = $tipocredito_interes[0]->id;
            $prestamo->mora_id = $request->mora_id;
            $prestamo->macro = "SIN MACRO";
            $prestamo->intpagar = $request->intpagar;
            $prestamo->sede_id = $empleado[0]->sede_id;

            if ($prestamo->save()) {
                $not = new Notificacion();
                $not->mensaje = "Se autorizó el prestamo del cliente: ".$cliente[0]->nombre." ".$cliente[0]->apellido.", con la garantia ".$request->nomGarantiaCp. ", y un monto de : ".$request->monto;
                $not->tiempo = date("H:m:s");
                $not->asunto = "Nueva Prestamo del cliente ".$cliente[0]->nombre." ".$cliente[0]->apellido;
                $not->estado = "PENDIENTE";
                $not->sede =  $empleado[0]->sede_id;
                $not->tipo = "PRESTAMO";
                $not->usuario = $users_id;
                $not->icono = "fa-check";
                if ($not->save()) {

                    $cotizacion = Cotizacion::where('id', '=', $request->cotizacion_id)->first();
                    $cotizacion->estado = "FINAL";
                    if ($cotizacion->save()) {

                        $cli = Cliente::where('id', '=', $cliente[0]->cliente_id)->first();
                        $cli->evaluacion = $nEvaluacion;
                        if ($cli->save()) {

                            

                                
                                $result = "1";
                            
                        }
                    }
                }
            }
        }else {
            $result = "2";
        }
        $notificacion = \DB::SELECT('SELECT * FROM  notificacion WHERE estado = "PENDIENTE" AND sede = "'.$empleado[0]->sede_id.'"');

        if ($notificacion == null) {
            $notificacion = \DB::SELECT('SELECT "" AS icono, "" AS asunto, "00:00:00" AS tiempo');
        }

        $cantNotificaciones = \DB::SELECT('SELECT COUNT(*) AS cant FROM notificacion WHERE estado = "PENDIENTE" AND sede = "'.$empleado[0]->sede_id.'"');

        if($cantNotificaciones == null){
            $cantNotificaciones = \DB::SELECT('SELECT "0" AS cant');
        }

        return response()->json(["view"=>view('atencioncliente.divValoracion', compact('cliente'))->render(), "notificacion"=>view('notificaciones.areaNotificaciones', compact('notificacion', 'cantNotificaciones'))->render(), '$result'=>$result]);

        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function printContrato()
    {
        $idContrato = \DB::SELECT('SELECT MAX(id) AS id FROM prestamo');

        $contrato = \DB::SELECT('SELECT p.id AS prestamo_id, cl.nombre, cl.apellido, cl.dni, CONCAT(d.direccion, " - ", di.distrito, " - ", pr.provincia, " - ", de.departamento) AS direccion, p.monto, p.fecfin, p.total, g.nombre AS garantia, g.detalle AS detgarantia, m.mora AS mora, p.intpagar
                                 FROM prestamo p, cotizacion c, cliente cl, garantia g, mora m, direccion d, distrito di, provincia pr, departamento de
                                 WHERE c.cliente_id = cl.id AND c.garantia_id = g.id AND p.mora_id = m.id AND p.cotizacion_id = c.id AND cl.direccion_id = d.id AND d.distrito_id = di.id AND di.provincia_id = pr.id AND pr.departamento_id = de.id AND p.id = "'.$idContrato[0]->id.'"');

        return view('prestamo.printContrato', compact('contrato'));
    }

    public function buscarClienteContrato(Request $request)
    {

        $prestamo = \DB::SELECT('SELECT p.id AS prestamo_id, cl.nombre, cl.apellido, cl.dni, g.nombre AS garantia, p.fecfin, cl.id AS cliente_id, p.fecinicio
                                 FROM prestamo p, cotizacion c, cliente cl, garantia g
                                 WHERE p.cotizacion_id = c.id AND c.cliente_id = cl.id AND c.garantia_id = g.id AND (cl.nombre LIKE "%'.$request->dato.'%" OR cl.apellido LIKE "%'.$request->dato.'%" OR cl.dni LIKE "%'.$request->dato.'%")');

        return response()->json(["view"=>view('prestamo.tabListContrato',compact('prestamo'))->render()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function descargarPdfContrato($id)
    {

        $contrato = \DB::SELECT('SELECT p.id AS prestamo_id, cl.nombre, cl.apellido, cl.dni, CONCAT(d.direccion, " - ", di.distrito, " - ", pr.provincia, " - ", de.departamento) AS direccion, p.monto, p.fecfin, p.total, g.nombre AS garantia, g.detalle AS detgarantia, m.mora AS mora
                                 FROM prestamo p, cotizacion c, cliente cl, garantia g, mora m, direccion d, distrito di, provincia pr, departamento de
                                 WHERE c.cliente_id = cl.id AND c.garantia_id = g.id AND p.mora_id = m.id AND p.cotizacion_id = c.id AND cl.direccion_id = d.id AND d.distrito_id = di.id AND di.provincia_id = pr.id AND pr.departamento_id = de.id AND p.id = "'.$id.'"');
     
        return PDF::loadView('prestamo.pdfcontrato', compact('contrato'))
            ->stream('archivo.pdf');
    }

    public function imprimirContrato($id)
    {

        $contrato = \DB::SELECT('SELECT p.id AS prestamo_id, cl.nombre, cl.apellido, cl.dni, CONCAT(d.direccion, " - ", di.distrito, " - ", pr.provincia, " - ", de.departamento) AS direccion, p.monto, p.fecfin, p.total, g.nombre AS garantia, g.detalle AS detgarantia, m.mora AS mora
                                 FROM prestamo p, cotizacion c, cliente cl, garantia g, mora m, direccion d, distrito di, provincia pr, departamento de
                                 WHERE c.cliente_id = cl.id AND c.garantia_id = g.id AND p.mora_id = m.id AND p.cotizacion_id = c.id AND cl.direccion_id = d.id AND d.distrito_id = di.id AND di.provincia_id = pr.id AND pr.departamento_id = de.id AND p.id = "'.$id.'"');

        return view('prestamo.printContrato', compact('contrato'));
    }

    public function verCorreo(Request $request)
    {
        $verCorreo = \DB::SELECT('SELECT cl.correo FROM prestamo p, cotizacion c, cliente cl
                               WHERE p.cotizacion_id = c.id AND c.cliente_id = cl.id AND p.id = "'.$request->id.'"');

        $correo = $verCorreo[0]->correo;

        return response()->json(['correo'=>$correo]);
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
