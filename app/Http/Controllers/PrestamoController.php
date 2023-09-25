<?php

namespace App\Http\Controllers;

use App\Application\UseCases\Cotizacion\CreateCotizacionUseCase;
use App\Application\UseCases\Cotizacion\GetCotizacionCompletaUseCase;
use App\Application\UseCases\Prestamo\CreatePrestamoUseCase;
use App\Models\Casillero;
use App\Models\Cliente;
use App\Models\Cotizacion;
use App\Models\Garantia;
use App\Models\GarantiaCasillero;
use App\Models\Interes;
use App\Models\Mora;
use App\Models\Notificacion;
use App\Models\Prestamo;
use App\Models\Proceso;
use App\Models\TipoCreditoInteres;
use App\Models\TipoGarantia;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PrestamoController extends Controller
{
    protected $createCotizacionUseCase;
    protected $getCotizacionCompletaUseCase;
    protected $createPrestamoUseCase;
    
    public function __construct(CreateCotizacionUseCase $createCotizacionUseCase, GetCotizacionCompletaUseCase $getCotizacionCompletaUseCase, CreatePrestamoUseCase $createPrestamoUseCase)
    {
        $this->createCotizacionUseCase = $createCotizacionUseCase;
        $this->getCotizacionCompletaUseCase = $getCotizacionCompletaUseCase;
        $this->createPrestamoUseCase = $createPrestamoUseCase;
    }
    
    public function generarCotizacion(Request $request)
    {
        try {
            $Proceso = new proceso();
            $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
            $idEmpleado = $Proceso->obtenerSucursal()->id;
            $cliente = Cliente::where('id', $request->input('cliente_id'))->first();
            $tipoPrestamo = $request->tipoPrestamoCp;
            $nombreGarnatia = "";
            $detalleGarantia = "";
            $tipoGarantia = 0;
            $precioReal = "";
            $precMax = "";
            $precMin = "";
            $code = 500;
            $message = "";
            $data = "";
            
            switch ($tipoPrestamo) {
                case 1:
                    $nombreGarnatia = $request->nomGarantiaCp;
                    $detalleGarantia = $request->detGarantiaCp;
                    $idTipoGarantia = $request->tipoGarantiaCp;
                    $precioReal = $request->precRealCp;
                    $precMax = $request->maxCp;
                    $precMin = $request->minCp;
                    break;
                case 2:
                    $joya = DB::table('tipogarantia')
                                ->select(DB::raw('CONCAT(nombre, " ", pureza) AS nombre'))
                                ->where('id', $request->tipoJoya)
                                ->first();
    
                    $detalleCj = $request->pesoCj." gr, ".$request->detalleCj;
                    
                    $nombreGarnatia = $joya->nombre;
                    $detalleGarantia = $detalleCj;
                    $idTipoGarantia = $request->tipoJoya;
                    $precioReal = $request->precRealCp;
                    $precMax = $request->maxCp;
                    $precMin = $request->minCp;
                    
                    break;
                case 3:
                    $nombreGarnatia = $request->nomGarantiaCu;
                    $detalleGarantia = $request->detGarantiaCu;
                    $idTipoGarantia = $request->tipoGarantiaCu;
                    $precioReal = $request->precRealCp;
                    $precMax = $request->maxCp;
                    $precMin = $request->minCp;
                    
                    break;
                default:
                    $nombreGarnatia = "";
                    $detalleGarantia = "";
                    $idTipoGarantia = 0;
                    $precioReal = "";
                    $precMax = "";
                    $precMin = "";
                    break;
            }
            
            $data = [
                'tipoPrestamoCp' => $request->input('tipoPrestamoCp'),
                'idCliente' => $request->input('cliente_id'),
                
                'idTipoGarantia' => $idTipoGarantia,
                'nombreGarnatia' => $nombreGarnatia,
                'detalleGarantia' => $detalleGarantia,
                'precioReal' => $precioReal,
                'precMax' => $precMax,
                'precMin' => $precMin,
                
                'estadoGarantia' => "ACTIVO",
                'mensajeNotificacion' => "El clinete: ".$cliente->nombre." ".$cliente->apellido.", realizó una cotización con la garantia ".$request->input('nomGarantiaCp'),
                'asuntoNotificacion' => "Nueva Cotización del cliente ".$cliente->nombre." ".$cliente->apellido,
                'estadoNotificacion' => "PENDIENTE",
                
                'idSucursal' => $idSucursal,
                'tipoNotificacion' => "COTIZACION",
                'idUser' => Auth::user()->id,
                'iconNotificacion' => "fa-archive",
                'estadoCotizacion' => "PENDIENTE",
                'idEmpleado' => $idEmpleado,
                'tipoPrestamo' => $tipoPrestamo
            ];
            
            $cotizacions = $this->createCotizacionUseCase->execute($data);
            
            $code = 200;
            $message = "Se generó la cotización correctamente";
            $data = "";
        
        } catch (Exception $e) {  
            
            $code = 500;
            $message = $e->getMessage();
            $data = "";
            
        }
        
        $cotizacion = DB::SELECT('SELECT c.id AS cotizacion_id, c.max, c.min, c.created_at, c.estado, tp.nombre AS tipoPrestamo, g.nombre AS garantia, g.id AS garantia_id
                                                                FROM cotizacion c, tipoprestamo tp, garantia g
                                                                WHERE c.sede_id = "'.$idSucursal.'" AND c.garantia_id = g.id AND c.tipoprestamo_id = tp.id AND c.estado = "PENDIENTE" AND c.cliente_id = "'.$cliente->id.'"');
                                                                
        $listCotizaciones = DB::SELECT('SELECT c.id AS cotizacion_id, tp.nombre AS tipoPrestamo, g.nombre AS garantia, g.detalle AS detalleGarantia, c.max, c.min, CONCAT(e.nombre, " ", e.apellido) AS empleado, g.id AS garantia_id
                                                FROM cotizacion c, tipoprestamo tp, garantia g, empleado e 
                                                WHERE c.sede_id = "'.$idSucursal.'" AND c.tipoprestamo_id = tp.id AND c.garantia_id = g.id AND c.empleado_id = e.id AND c.estado = "PRESTAMO" AND c.cliente_id = "'.$cliente->id.'" ORDER BY c.created_at ASC');

        $notificacion = DB::SELECT('SELECT * FROM  notificacion WHERE estado = "PENDIENTE" AND sede = "'.$idSucursal.'"');

        if ($notificacion == null) {
            $notificacion = DB::SELECT('SELECT "" AS icono, "" AS asunto, "00:00:00" AS tiempo');
        }

        $cantNotificaciones = DB::SELECT('SELECT COUNT(*) AS cant FROM notificacion WHERE estado = "PENDIENTE" AND sede = "'.$idSucursal.'"');

        if($cantNotificaciones == null){
            $cantNotificaciones = DB::SELECT('SELECT "0" AS cant');
        }
            
        return response()->json(["view"=>view('prestamo.lCotizar',compact('cotizacion'))->render(), "view2"=>view('prestamo.listaCotizaciones', compact('listCotizaciones'))->render(), "notificacion"=>view('notificaciones.areaNotificaciones', compact('notificacion', 'cantNotificaciones'))->render(), "code"=>$code, "message"=>$message]);

    }
    
    public function prestamo($id)
    {
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;
        
        $user = Auth::user();
        $usuario = DB::SELECT('SELECT e.nombre, e.apellido, e.id, u.name AS area, e.foto AS foto, e.sede_id AS sede
                                FROM empleado e, users u 
                                WHERE e.users_id = u.id AND u.id = "'.$user->id.'"');
                                
        $data = [
                'idCotizacion' => $id
            ];
            
        $cotizacionCompleta = $this->getCotizacionCompletaUseCase->execute($data);
        
        $cotizacion = $cotizacionCompleta->cotizacion;
        
        $cliente = $cotizacionCompleta->cliente;
        
        $almacen = $cotizacionCompleta->almacen;
        
        $interes = Interes::all();

        $mora = Mora::all();

        return view('prestamo.prestamo', compact('cliente', 'cotizacion', 'interes', 'mora', 'almacen', 'usuario'));
    }
    
    public function generarPrestamo(Request $request)
    {
        try {
            $Proceso = new proceso();
            $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
            $idEmpleado = $Proceso->obtenerSucursal()->id;
            $users_id = Auth::user()->id;
            
            $code = 500;
            $message = "";
            
            $tipocredito_interes = TipoCreditoInteres::where('interes_id', $request->tipocredito_interes_id)
                                                     ->first();
                                                
           $cliente = Cotizacion::join('cliente', 'cotizacion.cliente_id', '=', 'cliente.id')
                                ->where('cotizacion.id', $request->cotizacion_id)
                                ->select('cotizacion.cliente_id', 'cliente.evaluacion', 'cliente.nombre', 'cliente.apellido')
                                ->first();
    
            $nEvaluacion = $cliente->evaluacion - 30;
    
            $result = "";
            
            $data = [
                    'mensajeNotificacion' => "Se autorizó el prestamo del cliente: ".$cliente->nombre." ".$cliente->apellido.", con la garantia ".$request->nomGarantiaCp. ", y un monto de : ".$request->monto,
                    'asuntoNotificacion' => "Nueva Prestamo del cliente ".$cliente->nombre." ".$cliente->apellido,
                    'estadoNotificacion' => "PENDIENTE",
                    'iconNotificacion' => "fa-check",
                    'tipoNotificacion' => "PRESTAMO",
                    'idUser' => $users_id,
                    'codigoOrigenPrestamo' => "n",
                    'monto' => $request->monto,
                    'fechaInicio' => $request->fecinicio,
                    'fechaFin' => $request->fecfin,
                    'precioTotal' => $request->total,
                    'estadoPrestamo' => "ACTIVO",
                    'idCotizacion' => $request->cotizacion_id,
                    'estadoCotizacion' => "FINAL",
                    'idEmpleado' => $idEmpleado,
                    'idTipoCreditoInteres' => $tipocredito_interes->id,
                    'idMora' => $request->mora_id,
                    'estadoMacro' => "SIN MACRO",
                    'interesPagar' => $request->intpagar,
                    'idSucursal' => $idSucursal,
                    'idCliente' => $cliente->cliente_id,
                    'puntajeCliente' => $nEvaluacion
                ];
                
                $prestamo = $this->createPrestamoUseCase->execute($data);
                
                $code = 200;
                $message = "El prestamo se generó correctamente";
                $data = $prestamo;
            
        } catch (Exception $e) {
            throw new Exception("Error al generar el prestamo: " . $e->getMessage());
            $code = 500;
            $message = "Hubo un problema al generar el prestamo";
            $data = "";
        }
            
            $notificacion = DB::SELECT('SELECT * FROM  notificacion WHERE estado = "PENDIENTE" AND sede = "'.$idSucursal.'"');
    
            if ($notificacion == null) {
                $notificacion = DB::SELECT('SELECT "" AS icono, "" AS asunto, "00:00:00" AS tiempo');
            }
    
            $cantNotificaciones = DB::SELECT('SELECT COUNT(*) AS cant FROM notificacion WHERE estado = "PENDIENTE" AND sede = "'.$idSucursal.'"');
    
            if($cantNotificaciones == null){
                $cantNotificaciones = DB::SELECT('SELECT "0" AS cant');
            }

        return response()->json(["view"=>view('atencioncliente.divValoracion', compact('cliente'))->render(), "notificacion"=>view('notificaciones.areaNotificaciones', compact('notificacion', 'cantNotificaciones'))->render(), 'code'=>$code, 'message'=>$message, 'data'=>$data]);
    }
    
    public function printContrato($id)
    {
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $direccion = $Proceso->obtenerSucursal()->direccion;

        $contrato = Prestamo::select('prestamo.id AS prestamo_id', 'cliente.nombre', 'cliente.apellido', 'cliente.dni', DB::raw('CONCAT(direccion.direccion, " - ", distrito.distrito, " - ", provincia.provincia, " - ", departamento.departamento) AS direccion'), 'prestamo.monto', 'prestamo.fecfin', 'prestamo.total', 'garantia.nombre AS garantia', 'garantia.detalle AS detgarantia', 'mora.mora AS mora', 'prestamo.intpagar')
                        ->join('cotizacion', 'prestamo.cotizacion_id', '=', 'cotizacion.id')
                        ->join('cliente', 'cotizacion.cliente_id', '=', 'cliente.id')
                        ->join('garantia', 'cotizacion.garantia_id', '=', 'garantia.id')
                        ->join('mora', 'prestamo.mora_id', '=', 'mora.id')
                        ->join('direccion', 'cliente.direccion_id', '=', 'direccion.id')
                        ->join('distrito', 'direccion.distrito_id', '=', 'distrito.id')
                        ->join('provincia', 'distrito.provincia_id', '=', 'provincia.id')
                        ->join('departamento', 'provincia.departamento_id', '=', 'departamento.id')
                        ->where('prestamo.id', $id)
                        ->first();


        return view('prestamo.printContrato', compact('contrato', 'direccion'));
    }
    
    //Pendiente de refactorización
    
    public function evaluacion()
    {
        return view('prestamo.evaluacion');
    }

    public function valorJoyas(Request $request)
    {
        $id = $request->idTipoGarantia;
        
        $precios = TipoGarantia::select('precMax', 'precMin')
                                ->where('id', $id)
                                ->get();


        $precMax = $precios[0]->precMax;
        $precMin = $precios[0]->precMin;

        return response()->json(['precMax'=>$precMax, 'precMin'=>$precMin]);
    }

    
    
    public function eliminarCotizacion(Request $request)
    {
        $resp = "";
        $aux = 0;
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;
        
        $casillero_id = $request->casillero_id;
        
        if ($casillero_id != null) {
            $garantiaCasillero = DB::SELECT('DELETE FROM garantia_casillero WHERE garantia_id = "'.$request->garantia_id.'" AND casillero_id = "'.$casillero_id.'";');
        }
        
        $cotizacion = Cotizacion::find($request->cotizacion_id);
        if ($cotizacion) {
            if ($cotizacion->delete()) {
                $garantia = Garantia::find($request->garantia_id);
                if ($garantia) {
                    if ($garantia->delete()) {
                        $aux = 1;
                    } else {
                        $resp = "Hubo un error con la garantia";
                    }
                } else {
                    $resp = "No existe la garantia seleccionada";
                }
                
            } else {
                $resp = "Hubo un error con la cotizacion";
            }
            
        } else {
            $resp = "No existe la cotizacion seleccionada";
        }
        
        
        $listCotizacion = DB::SELECT('SELECT c.id AS cotizacion_id, c.max, c.min, c.estado AS cotizacion_estado, c.precio, c.created_at AS created_at, cl.id AS cliente_id, cl.nombre AS cl_nombre, cl.apellido AS cl_apellido, cl.dni AS cl_dni, e.id AS empleado_id, e.nombre AS                               e_nombre, e.apellido AS e_apellido, e.dni AS e_dni, g.id AS garantia_id, g.nombre AS g_nombre, g.detalle AS g_detalle, tp.id AS tipoprestamo_id, tp.nombre AS tp_nombre, tp.detalle AS tp_detalle FROM cotizacion c, cliente cl, empleado e,                               garantia g, tipoprestamo tp WHERE c.cliente_id = cl.id AND c.empleado_id = e.id AND c.garantia_id = g.id AND c.tipoprestamo_id = tp.id AND cl.sede_id = "'.$idSucursal.'" AND c.estado = "PENDIENTE" ORDER BY c.created_at ASC;');
                            
        return response()->json(["view"=>view('prestamo.tabCotizacion',compact('listCotizacion'))->render(), compact('resp', 'aux')]);  
        
    }
    
    public function buscarCotizacion(Request $request)
    {
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;
                                
        $listCotizacion = DB::SELECT('SELECT c.id AS cotizacion_id, c.max, c.min, c.estado AS cotizacion_estado, c.precio, c.created_at AS created_at, cl.id AS cliente_id, cl.nombre AS cl_nombre, cl.apellido AS cl_apellido, cl.dni AS cl_dni, e.id AS empleado_id, e.nombre AS                               e_nombre, e.apellido AS e_apellido, e.dni AS e_dni, g.id AS garantia_id, g.nombre AS g_nombre, g.detalle AS g_detalle, tp.id AS tipoprestamo_id, tp.nombre AS tp_nombre, tp.detalle AS tp_detalle 
                                       FROM cotizacion c, cliente cl, empleado e, garantia g, tipoprestamo tp 
                                       WHERE c.cliente_id = cl.id AND c.empleado_id = e.id AND c.garantia_id = g.id AND c.tipoprestamo_id = tp.id AND c.sede_id = "'.$idSucursal.'" AND c.estado = "PENDIENTE" AND (cl.nombre LIKE "%'.$request->dato.'%" OR cl.apellido LIKE "%'.$request->dato.'%" OR cl.dni LIKE "%'.$request->dato.'%") ORDER BY c.created_at ASC;');
                                
        return response()->json(["view"=>view('prestamo.tabCotizacion',compact('listCotizacion'))->render()]);
    }
    
    public function asignarCasillero(Request $request) {
        
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        
        
        $users_id = Auth::user()->id;
        
        $garcas = new GarantiaCasillero();
        $garcas->garantia_id = $request->garantia_id;
        $garcas->casillero_id = $request->casillero_id;
        $garcas->estado = "OCUPADO";
        if ($garcas->save()) {
            
            $cotizacionCp = Cotizacion::where('id', '=', $request->cotizacion_id)->first();
            $cotizacionCp->estado = "PRESTAMO";
            if ($cotizacionCp->save()) {
                $not = new Notificacion();
                $not->mensaje = "El clinete: , realizó una cotización con la garantia" ;
                $not->tiempo = date("H:m:s");
                $not->asunto = "Nueva Cotización del cliente ";
                $not->estado = "PENDIENTE";
                $not->sede =  $idSucursal;
                $not->tipo = "COTIZACION";
                $not->tipo = $users_id;
                $not->icono = "fa-archive";
                if ($not->save()) {
                    $cas = Casillero::where('id', '=', $request->casillero_id)->first();
                    $cas->estado = "OCUPADO";
                    if ($cas->save()) {
                        $cotizacion = DB::SELECT('SELECT c.id AS cotizacion_id, c.max, c.min, c.created_at, c.estado, tp.nombre AS tipoPrestamo, g.nombre AS garantia, g.id AS garantia_id
                                                FROM cotizacion c, tipoprestamo tp, garantia g
                                                WHERE c.garantia_id = g.id AND c.tipoprestamo_id = tp.id AND c.sede_id = "'.$idSucursal.'" AND c.estado = "PENDIENTE" AND c.cliente_id = "'.$request->cliente_id.'"');

                        $listCotizaciones = DB::SELECT('SELECT c.id AS cotizacion_id, tp.nombre AS tipoPrestamo, g.nombre AS garantia, g.detalle AS detalleGarantia, c.max, c.min, CONCAT(e.nombre, " ", e.apellido) AS empleado 
                                                        FROM cotizacion c, tipoprestamo tp, garantia g, empleado e 
                                                        WHERE c.tipoprestamo_id = tp.id AND c.garantia_id = g.id AND c.empleado_id = e.id AND c.sede_id = "'.$idSucursal.'" AND c.estado = "PENDIENTE" AND c.cliente_id = "'.$request->cliente_id.'"');
                                                        
                        $notificacion = DB::SELECT('SELECT * FROM  notificacion WHERE estado = "PENDIENTE" AND sede = "'.$idSucursal.'"');
                        if ($notificacion == null) {
                            $notificacion = DB::SELECT('SELECT "" AS icono, "" AS asunto, "00:00:00" AS tiempo');
                        }
                        $cantNotificaciones = DB::SELECT('SELECT COUNT(*) AS cant FROM notificacion WHERE estado = "PENDIENTE" AND sede = "'.$idSucursal.'"');
                        if($cantNotificaciones == null){
                            $cantNotificaciones = DB::SELECT('SELECT "0" AS cant');
                        }
                        if($request->vista == 1){
                            
                            $listCotizacion = DB::SELECT('SELECT g.id AS garantia_id, c.id AS cotizacion_id, c.max, c.min, c.estado AS cotizacion_estado, c.precio, c.created_at AS created_at, cl.id AS cliente_id, cl.nombre AS cl_nombre, cl.apellido AS cl_apellido, cl.dni AS cl_dni, e.id AS empleado_id, e.nombre AS                               e_nombre, e.apellido AS e_apellido, e.dni AS e_dni, g.id AS garantia_id, g.nombre AS g_nombre, g.detalle AS g_detalle, tp.id AS tipoprestamo_id, tp.nombre AS tp_nombre, tp.detalle AS tp_detalle FROM cotizacion c, cliente cl, empleado e,                               garantia g, tipoprestamo tp WHERE c.cliente_id = cl.id AND c.empleado_id = e.id AND c.garantia_id = g.id AND c.sede_id = "'.$idSucursal.'" AND c.tipoprestamo_id = tp.id AND c.estado = "PENDIENTE";');
                            
                            return response()->json(["view"=>view('prestamo.tabCotizacion',compact('listCotizacion'))->render()]);
                        }else{
                            return response()->json(["view"=>view('prestamo.lCotizar',compact('cotizacion'))->render(), "view2"=>view('prestamo.listaCotizaciones', compact('listCotizaciones'))->render(), "notificacion"=>view('notificaciones.areaNotificaciones', compact('notificacion', 'cantNotificaciones'))->render()]);    
                        }
                        
                    }
                } 
            }
        }
        
    }

    public function garantia()
    {
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;
        
        $user = Auth::user();
        $usuario = DB::SELECT('SELECT e.nombre, e.apellido, e.id, u.name AS area, e.foto AS foto, e.sede_id AS sede
                                FROM empleado e, users u 
                                WHERE e.users_id = u.id AND u.id = "'.$user->id.'"');

        $garantia = DB::SELECT('SELECT p.id AS prestamo_id, g.id AS garantia_id, g.nombre AS garantia, g.detalle AS detgarantia, CONCAT(ca.nombre, " - ", s.nombre, " - ", a.nombre) AS casillero, ca.estado
                                 FROM garantia g
                                 INNER JOIN cotizacion c ON c.garantia_id = g.id
                                 INNER JOIN garantia_casillero ga ON ga.garantia_id = g.id
                                 INNER JOIN prestamo p ON p.cotizacion_id = c.id
                                 INNER JOIN casillero ca ON ga.casillero_id = ca.id
                                 INNER JOIN stand s ON ca.stand_id = s.id
                                 INNER JOIN almacen a ON s.almacen_id = a.id
                                 INNER JOIN almacen_sede ase ON ase.almacen_id = a.id
                                 WHERE ca.estado != "LIBRE" AND ase.sede_id = "'.$idSucursal.'"');
                                 
        return view('prestamo.garantia', compact('garantia', 'usuario'));
    }

    public function listcontrato()
    {
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;
        
        $user = Auth::user();
        $usuario = DB::SELECT('SELECT e.nombre, e.apellido, e.id, u.name AS area, e.foto AS foto, e.sede_id AS sede
                                FROM empleado e, users u 
                                WHERE e.users_id = u.id AND u.id = "'.$user->id.'"');

        $prestamo = DB::SELECT('SELECT p.id AS prestamo_id, cl.nombre, cl.apellido, cl.dni, g.nombre AS garantia, p.fecfin, cl.id AS cliente_id, p.fecinicio
                                 FROM prestamo p, cotizacion c, cliente cl, garantia g
                                 WHERE p.cotizacion_id = c.id AND c.cliente_id = cl.id AND c.garantia_id = g.id AND cl.sede_id = "'.$idSucursal.'"');

        return view('prestamo.listcontrato', compact('prestamo', 'usuario'));
    }

    public function macro()
    { 
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;
        
        $user = Auth::user();
        $usuario = DB::SELECT('SELECT e.nombre, e.apellido, e.id, u.name AS area, e.foto AS foto, e.sede_id AS sede
                                FROM empleado e, users u 
                                WHERE e.users_id = u.id AND u.id = "'.$user->id.'"');

        $sinMacro = DB::SELECT('SELECT p.id AS prestamo_id, cl.dni, cl.nombre, cl.apellido, p.fecinicio, p.fecfin, p.monto, p.intpagar, m.mora
                                FROM prestamo p, cotizacion c, garantia g, cliente cl, mora m
                                WHERE p.cotizacion_id = c.id AND c.garantia_id = g.id AND p.mora_id = m.id AND c.cliente_id = cl.id AND p.estado = "ACTIVO DESEMBOLSADO" AND p.macro = "SIN MACRO" AND p.sede_id = "'.$idSucursal.'"
                                ORDER BY p.fecfin ASC');

        $conMacro = DB::SELECT('SELECT p.id AS prestamo_id, cl.dni, cl.nombre, cl.apellido, p.fecinicio, p.fecfin, p.monto, p.intpagar, m.mora
                                 FROM prestamo p, cotizacion c, garantia g, cliente cl, mora m
                                 WHERE p.cotizacion_id = c.id AND c.garantia_id = g.id AND p.mora_id = m.id AND c.cliente_id = cl.id AND p.estado = "ACTIVO DESEMBOLSADO" AND p.macro = "CON MACRO" AND p.sede_id = "'.$idSucursal.'"
                                 ORDER BY p.fecfin ASC');

        return view('prestamo.macro', compact('sinMacro', 'usuario', 'conMacro'));
    }

    

    

    /**
     * Show the form for creating a new resource.
     * 
     * @return \Illuminate\Http\Response
     */
    

    public function buscarClienteContrato(Request $request) 
    {
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;

        $prestamo = DB::SELECT('SELECT p.id AS prestamo_id, cl.nombre, cl.apellido, cl.dni, g.nombre AS garantia, p.fecfin, cl.id AS cliente_id, p.fecinicio
                                 FROM prestamo p, cotizacion c, cliente cl, garantia g
                                 WHERE p.cotizacion_id = c.id AND c.cliente_id = cl.id AND c.garantia_id = g.id AND p.sede_id = "'.$idSucursal.'" AND (cl.nombre LIKE "%'.$request->dato.'%" OR cl.apellido LIKE "%'.$request->dato.'%" OR cl.dni LIKE "%'.$request->dato.'%")');

        return response()->json(["view"=>view('prestamo.tabListContrato',compact('prestamo'))->render()]);
    }

    public function descargarPdfContrato($id)
    {
        $Proceso = new proceso();
        $direccion = $Proceso->obtenerSucursal()->direccion;
        
        $contrato = DB::SELECT('SELECT p.id AS prestamo_id, cl.nombre, cl.apellido, cl.dni, CONCAT(d.direccion, " - ", di.distrito, " - ", pr.provincia, " - ", de.departamento) AS direccion, p.monto, p.fecfin, p.total, g.nombre AS garantia, g.detalle AS detgarantia, m.mora AS mora
                                 FROM prestamo p, cotizacion c, cliente cl, garantia g, mora m, direccion d, distrito di, provincia pr, departamento de
                                 WHERE c.cliente_id = cl.id AND c.garantia_id = g.id AND p.mora_id = m.id AND p.cotizacion_id = c.id AND cl.direccion_id = d.id AND d.distrito_id = di.id AND di.provincia_id = pr.id AND pr.departamento_id = de.id AND p.id = "'.$id.'"');
     
        return PDF::loadView('prestamo.pdfcontrato', compact('contrato', 'direccion'))
            ->stream('archivo.pdf');
    }

    public function imprimirContrato($id)
    {
        // dd($id);
        
        $Proceso = new proceso();
        $direccion = $Proceso->obtenerSucursal()->direccion;

        // $contrato = DB::SELECT('SELECT p.id AS prestamo_id, cl.nombre, cl.apellido, cl.dni, CONCAT(d.direccion, " - ", di.distrito, " - ", pr.provincia, " - ", de.departamento) AS direccion, p.monto, p.fecfin, p.total, g.nombre AS garantia, g.detalle AS detgarantia, m.mora AS mora, p.intpagar
        //                          FROM prestamo p, cotizacion c, cliente cl, garantia g, mora m, direccion d, distrito di, provincia pr, departamento de
        //                          WHERE c.cliente_id = cl.id AND c.garantia_id = g.id AND p.mora_id = m.id AND p.cotizacion_id = c.id AND cl.direccion_id = d.id AND d.distrito_id = di.id AND di.provincia_id = pr.id AND pr.departamento_id = de.id AND p.id = "'.$id.'"');
        
        $contrato = Prestamo::select('prestamo.id AS prestamo_id', 'cliente.nombre', 'cliente.apellido', 'cliente.dni', DB::raw('CONCAT(direccion.direccion, " - ", distrito.distrito, " - ", provincia.provincia, " - ", departamento.departamento) AS direccion'), 'prestamo.monto', 'prestamo.fecfin', 'prestamo.total', 'garantia.nombre AS garantia', 'garantia.detalle AS detgarantia', 'mora.mora AS mora', 'prestamo.intpagar')
                        ->join('cotizacion', 'prestamo.cotizacion_id', '=', 'cotizacion.id')
                        ->join('cliente', 'cotizacion.cliente_id', '=', 'cliente.id')
                        ->join('garantia', 'cotizacion.garantia_id', '=', 'garantia.id')
                        ->join('mora', 'prestamo.mora_id', '=', 'mora.id')
                        ->join('direccion', 'cliente.direccion_id', '=', 'direccion.id')
                        ->join('distrito', 'direccion.distrito_id', '=', 'distrito.id')
                        ->join('provincia', 'distrito.provincia_id', '=', 'provincia.id')
                        ->join('departamento', 'provincia.departamento_id', '=', 'departamento.id')
                        ->where('prestamo.id', $id)
                        ->first();

        return view('prestamo.printContrato', compact('contrato', 'direccion'));
    }

    public function verCorreo(Request $request)
    {
        $verCorreo = DB::SELECT('SELECT cl.correo FROM prestamo p, cotizacion c, cliente cl
                               WHERE p.cotizacion_id = c.id AND c.cliente_id = cl.id AND p.id = "'.$request->id.'"');

        $correo = $verCorreo[0]->correo;

        return response()->json(['correo'=>$correo]);
    }

}
