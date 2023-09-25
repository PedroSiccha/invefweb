<?php

namespace App\Http\Controllers;

use App\Application\UseCases\Banco\CreateBancoUseCase;
use App\Application\UseCases\Banco\GetBancoByIdUseCase;
use App\Application\UseCases\Banco\GetBancoUseCase;
use App\Application\UseCases\Caja\GetCajaByTipoUseCase;
use App\Application\UseCases\Cliente\GetClienteByPrestamoUseCase;
use App\Application\UseCases\Cliente\UpdatePuntajeClienteUseCase;
use App\Application\UseCases\Garantia\GetGarantiaByPrestamoUseCase;
use App\Application\UseCases\Pago\CreatePagoUseCase;
use App\Application\UseCases\Prestamo\CreatePrestamoUseCase;
use App\Models\Caja;
use App\Models\Casillero;
use App\Models\Cliente;
use App\Models\Documento;
use App\Models\Empleado;
use App\Models\Garantia;
use App\Models\GarantiaCasillero;
use App\Models\Movimiento;
use App\Models\Pago;
use App\Models\Prestamo;
use App\Models\PrestamoDocumento;
use App\Models\Proceso;
use App\Models\TipoCaja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class CobranzaClienteController extends Controller
{
    protected $getCajaByTipoUseCase;
    protected $getGarantiaByPrestamoUseCase;
    protected $getClienteByPrestamoUseCase;
    protected $updatePuntajeClienteUseCase;
    protected $createPrestamoUseCase;
    protected $createPagoUseCase;
    protected $getBancoUseCase;
    protected $createBancoUseCase;
    protected $getBancoByIdUseCase;
    
    public function __construct(GetCajaByTipoUseCase $getCajaByTipoUseCase, GetGarantiaByPrestamoUseCase $getGarantiaByPrestamoUseCase, GetClienteByPrestamoUseCase $getClienteByPrestamoUseCase, UpdatePuntajeClienteUseCase $updatePuntajeClienteUseCase, CreatePrestamoUseCase $createPrestamoUseCase, CreatePagoUseCase $createPagoUseCase, GetBancoUseCase $getBancoUseCase, CreateBancoUseCase $createBancoUseCase, GetBancoByIdUseCase $getBancoByIdUseCase)
    {
        $this->middleware('auth');
        $this->getCajaByTipoUseCase = $getCajaByTipoUseCase;
        $this->getGarantiaByPrestamoUseCase = $getGarantiaByPrestamoUseCase;
        $this->getClienteByPrestamoUseCase = $getClienteByPrestamoUseCase;
        $this->updatePuntajeClienteUseCase = $updatePuntajeClienteUseCase;
        $this->createPrestamoUseCase = $createPrestamoUseCase;
        $this->createPagoUseCase = $createPagoUseCase;
        $this->getBancoUseCase = $getBancoUseCase;
        $this->createBancoUseCase = $createBancoUseCase;
        $this->getBancoByIdUseCase = $getBancoByIdUseCase;
    }
    
    public function renovarPrestamo(Request $request)
    {
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $idUsuario = Auth::user()->id;
        $idPrestamo = $request->idPrestamo;
        $pago = $request->importe; 
        $monto = $request->monto;
        $dias = $request->dia;
        $mora = $request->mora;
        $interes = $request->interes;
        $pagoMinimo = $mora + $interes;
        $totalPago = $pagoMinimo + $monto;
        $nuevoMontoPrestamo = $monto + $interes + $mora - $pago;
        
        $code = 500;
        $messaje = "";
        $data = "";
        
        $prestamo = Prestamo::where('id', $idPrestamo)->first();
        
        $dataCaja = [
                'estadoCaja' => "abierta",
                'tipoCaja' => "caja chica",
                'idSucursal' => $idSucursal
            ];
                    
        $caja = $this->getCajaByTipoUseCase->execute($dataCaja);
        
        $garantia = $this->getGarantiaByPrestamoUseCase->execute($idPrestamo);
        
        $cliente = $this->getClienteByPrestamoUseCase->execute($idPrestamo);

        $fechaInicio = $prestamo->fecinicio;
        $nuevaFechaInicio = date("Y-m-d", strtotime($fechaInicio."+ 1 month"));
        $fechaFin = $prestamo->fecfin;
        $nuevaFechaFin = date("Y-m-d", strtotime($fechaFin."+1 month"));
        
        if ($pago == $pagoMinimo) {
            
            $nuevoMonto = $monto;
            
            $nuevoMonto = proceso::actualizarCaja($caja->monto, $pago, 2);
            
            $nuevaEvaluacio = $cliente->evaluacion + 5;

            if ( $nuevaEvaluacio >= 100) {
                $nuevaEvaluacio = 100;
            }

            $aux = 1;
            
        }elseif ($pago > $pagoMinimo) {
            
            $nuevoMonto = $totalPago - $pago;
            
            $nuevoMonto = proceso::actualizarCaja($caja->monto, $pago, 2);
            
            $nuevaEvaluacio = $cliente->evaluacion + 5;

            if ( $nuevaEvaluacio >= 100) {
                $nuevaEvaluacio = 100;
            }
           
            $aux = "1";

        }else {
            $aux = "2";
        }
        
        $dataPag = [
            'idPrestamo' => $idPrestamo,
            'estadoPrestamo' => "RENOVADO",
            
            'codigoPago' => "R",
            'monto' => $monto,
            'montoPago' => $pago,
            'vueltoPago' => "0.00",
            'interesPago' => $interes,
            'moraPago' => $mora,
            'diasPago' => $dias,
            'idTipoComprobante' => "1",
            'idEmpleado' => $idEmpleado,
            'idSucursal' => $idSucursal,
            
            'idCaja' => $caja->id,
            'nuevoMontoCaja' => $nuevoMonto,
            'estadoMovimiento' => "ACTIVO",
            'montoPrestamo' => $pago,
            'conceptoMovimiento' => "EFECTIVO RENOVACION-".$idPrestamo,
            'tipoMovimiento' => "INGRESO",
            'importeMovimiento' => $pago,
            'codigoOrigenMovimiento' => "R",
            'codigoSerieMovimiento' => "cc",
            'idGarantia' => $garantia->id,
            'nombreGarantia' => $garantia->nombre,
        ];
            
        $pago = $this->createPagoUseCase->execute($dataPag);
        
        $data = [
            'mensajeNotificacion' => "El cliente ".$cliente->nombre." ".$cliente->apellido.", renovó su prestamo",
            'asuntoNotificacion' => "Renovacion de Prestamo",
            'estadoNotificacion' => "PENDIENTE",
            'tipoNotificacion' => "PAGO",
            'idUser' => $idUsuario,
            'iconNotificacion' => "fa-archive",
            
            'codigoOrigenPrestamo' => "R",
            'monto' => $nuevoMontoPrestamo,
            'fechaInicio' => $nuevaFechaInicio,
            'fechaFin' => $nuevaFechaFin,
            'precioTotal' => $totalPago,
            'estadoPrestamo' => "ACTIVO DESEMBOLSADO",
            'idCotizacion' => $prestamo->cotizacion_id,
            'estadoCotizacion' => "FINAL",
            'idEmpleado' => $idEmpleado,
            'idTipoCreditoInteres' => $prestamo->tipocredito_interes_id,
            'idMora' => $prestamo->mora_id,
            'estadoMacro' => "SIN MACRO",
            'interesPagar' => $interes,
            'idSucursal' => $idSucursal
        ];
            
        $prestamo = $this->createPrestamoUseCase->execute($data);
        
        $dataCliente = [
            'idCliente' => $cliente->cliente_id,
            'puntajeCliente' => $nuevaEvaluacio
        ];
                
        $cliente = $this->updatePuntajeClienteUseCase->execute($dataCliente);
            

        $prestamo = DB::SELECT('SELECT p.id AS prestamo_id, p.monto, p.fecinicio, p.fecfin, p.total, cl.id AS cliente_id, cl.nombre, cl.apellido, cl.dni, g.nombre AS garantia, p.intpagar, m.mora AS morapagar, i.porcentaje
                                 FROM prestamo p, cotizacion c, cliente cl, garantia g, mora m, tipocredito_interes tci, interes i
                                 WHERE c.cliente_id = cl.id AND p.cotizacion_id = c.id AND c.garantia_id = g.id AND p.mora_id = m.id AND p.estado = "ACTIVO DESEMBOLSADO" AND p.tipocredito_interes_id = tci.id AND tci.interes_id = i.id AND p.sede_id = "'.$idSucursal.'"
                                 ORDER BY p.fecfin ASC');
                                 
        $code = 200;
        $message = "Renovacion exitosa";
        $data = $pago;

        return response()->json(["view"=>view('cobranza.tabCliente',compact('prestamo', 'aux'))->render(), "code" => $code, "message" => $message, "data" => $data]);
    } 
     
    public function atraso()
    {
        $user = Auth::user();
        $usuario = DB::SELECT('SELECT e.nombre, e.apellido, e.id, u.name AS area, e.foto AS foto, e.sede_id AS sede
                                FROM empleado e, users u 
                                WHERE e.users_id = u.id AND u.id = "'.$user->id.'"');
                                
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;

        $listAtrasos = DB::SELECT('SELECT p.id AS prestamo_id, cl.nombre, cl.apellido, cl.dni, g.nombre AS garantia, p.fecfin, DATEDIFF(CURDATE(), p.fecinicio) AS dia, p.monto, p.intpagar, p.estado, cl.facebook, cl.whatsapp, cl.correo, cl.telefono, m.mora, cl.referencia, p.fecinicio, cl.id AS cliente_id
                                      FROM prestamo p, cotizacion c, cliente cl, garantia g, mora m
                                      WHERE p.cotizacion_id = c.id AND c.cliente_id = cl.id AND c.garantia_id = g.id AND DATEDIFF(CURDATE(), p.fecinicio) > 30 AND p.estado = "ACTIVO DESEMBOLSADO" AND p.mora_id = m.id AND p.sede_id = "'.$idSucursal.'"');


        return view('cobranza.atraso', compact('usuario', 'listAtrasos'));
    }

    public function caja()
    {
        $user = Auth::user();
        $usuario = DB::SELECT('SELECT e.nombre, e.apellido, e.id, u.name AS area, e.foto AS foto, e.sede_id AS sede
                                FROM empleado e, users u 
                                WHERE e.users_id = u.id AND u.id = "'.$user->id.'"');
                                
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        
        $dataCajaChica = [
                'estadoCaja' => "abierta",
                'tipoCaja' => "caja chica",
                'idSucursal' => $idSucursal
            ];
            
        $dataCajaGrande = [
            'estadoCaja' => "abierta",
            'tipoCaja' => "Caja Grande",
            'idSucursal' => $idSucursal
        ];
        
        $dataBanco = [
            'estadoCaja' => "abierta",
            'idSucursal' => $idSucursal
        ];
                    
        $cajaGrande = $this->getCajaByTipoUseCase->execute($dataCajaGrande);
                    
        $cajaChica = $this->getCajaByTipoUseCase->execute($dataCajaChica);
        
        $cajaBancos = $this->getBancoUseCase->execute($dataBanco);

        $ingreso = Movimiento::select('movimiento.*', 'cl.nombre AS nombreCl', 'cl.apellido AS apellidoCl', 'e.nombre AS nombreEm', 'e.apellido AS apellidoEm')
                            ->join('caja as c', 'movimiento.caja_id', '=', 'c.id')
                            ->leftJoin('empleado as e', 'movimiento.empleado', '=', 'e.id')
                            ->leftJoin('prestamo as p', 'movimiento.codprestamo', '=', 'p.id')
                            ->leftJoin('cotizacion as co', 'p.cotizacion_id', '=', 'co.id')
                            ->leftJoin('cliente as cl', 'co.cliente_id', '=', 'cl.id')
                            ->where('movimiento.tipo', 'INGRESO')
                            ->where('c.estado', 'ABIERTA')
                            ->whereDate('movimiento.created_at', DB::raw('DATE(DATE_SUB(NOW(), INTERVAL 5 HOUR))'))
                            ->where('c.sede_id', $idSucursal)
                            ->orderBy('movimiento.created_at', 'DESC')
                            ->get();

        $cantIngreso = Movimiento::join('caja as c', 'movimiento.caja_id', '=', 'c.id')
                                ->leftJoin('empleado as e', 'movimiento.empleado', '=', 'e.id')
                                ->leftJoin('prestamo as p', 'movimiento.codprestamo', '=', 'p.id')
                                ->leftJoin('cotizacion as co', 'p.cotizacion_id', '=', 'co.id')
                                ->leftJoin('cliente as cl', 'co.cliente_id', '=', 'cl.id')
                                ->where('movimiento.tipo', 'INGRESO')
                                ->where('c.estado', 'ABIERTA')
                                ->whereDate('movimiento.created_at', DB::raw('DATE(DATE_SUB(NOW(), INTERVAL 5 HOUR))'))
                                ->where('c.sede_id', $idSucursal)
                                ->orderBy('movimiento.created_at', 'DESC')
                                ->selectRaw('SUM(movimiento.importe) AS monto')
                                ->first();
        
        if ($cantIngreso->monto === null) {
            $cantIngreso = (object) ['monto' => '0.00'];
        }
        
        $egreso = Movimiento::select('movimiento.*', 'cl.nombre AS nombreCl', 'cl.apellido AS apellidoCl', 'e.nombre AS nombreEm', 'e.apellido AS apellidoEm')
                            ->join('caja as c', 'movimiento.caja_id', '=', 'c.id')
                            ->leftJoin('empleado as e', 'movimiento.empleado', '=', 'e.users_id')
                            ->leftJoin('prestamo as p', 'movimiento.codprestamo', '=', 'p.id')
                            ->leftJoin('cotizacion as co', 'p.cotizacion_id', '=', 'co.id')
                            ->leftJoin('cliente as cl', 'co.cliente_id', '=', 'cl.id')
                            ->where('movimiento.tipo', 'EGRESO')
                            ->where('c.estado', 'ABIERTA')
                            ->whereDate('movimiento.created_at', DB::raw('DATE(DATE_SUB(NOW(), INTERVAL 5 HOUR))'))
                            ->where('c.sede_id', $idSucursal)
                            ->orderBy('movimiento.created_at', 'DESC')
                            ->get();


        $cantEgreso = Movimiento::join('caja as c', 'movimiento.caja_id', '=', 'c.id')
                                ->leftJoin('empleado as e', 'movimiento.empleado', '=', 'e.users_id')
                                ->leftJoin('prestamo as p', 'movimiento.codprestamo', '=', 'p.id')
                                ->leftJoin('cotizacion as co', 'p.cotizacion_id', '=', 'co.id')
                                ->leftJoin('cliente as cl', 'co.cliente_id', '=', 'cl.id')
                                ->where('movimiento.tipo', 'EGRESO')
                                ->where('c.estado', 'ABIERTA')
                                ->whereDate('movimiento.created_at', DB::raw('DATE(DATE_SUB(NOW(), INTERVAL 5 HOUR))'))
                                ->where('c.sede_id', $idSucursal)
                                ->orderBy('movimiento.created_at', 'DESC')
                                ->selectRaw('SUM(movimiento.monto) AS monto')
                                ->first();
        
        if ($cantEgreso->monto === null) {
            $cantEgreso = (object) ['monto' => '0.00'];
        }

        $controlCaja = Caja::where('estado', 'CERRADA')
                            ->where('sede_id', $idSucursal)
                            ->get();
        
        $listaBancos = Caja::rightJoin('tipocaja as tc', 'caja.tipocaja_id', '=', 'tc.id')
                            ->select('caja.id as caja_id', 'caja.estado', 'caja.monto', 'caja.fecha', 'caja.inicio', 'caja.fin', 'caja.montofin', 'caja.empleado as empleado_id', 'caja.sede_id', 'tc.id as banco_id', 'tc.tipo', 'tc.codigo', 'tc.detalle', 'tc.categoria')
                            ->where('tc.categoria', 'banco')
                            ->where('caja.sede_id', $idSucursal)
                            ->get();
                                    
        $cantBancos = Caja::rightJoin('tipocaja as tc', 'caja.tipocaja_id', '=', 'tc.id')
                            ->where('tc.categoria', 'banco')
                            ->where('caja.sede_id', $idSucursal)
                            ->selectRaw('SUM(caja.monto) AS monto')
                            ->first();
                        
        if ($cantBancos->monto === null) {
            $cantBancos = (object) ['monto' => '0.00'];
        }
 
        return view('cobranza.caja',compact('cajaChica', 'ingreso', 'egreso', 'usuario', 'controlCaja', 'cajaGrande', 'cajaBancos', 'cantIngreso', 'cantEgreso', 'listaBancos', 'cantBancos'));
        
    }

    public function detalleCajaDia(Request $request)
    {
        $id = $request->id;

        $ingresoCd = DB::SELECT('SELECT m.*, cl.nombre AS nombreCl, cl.apellido AS apellidoCl, e.nombre AS nombreEm, e.apellido AS apellidoEm
                                  FROM movimiento m, caja c, prestamo p, cotizacion co, cliente cl, empleado e
                                  WHERE m.caja_id = c.id AND m.codprestamo = p.id AND p.cotizacion_id = co.id AND m.empleado = e.id AND co.cliente_id = cl.id AND m.tipo = "INGRESO" AND c.estado = "CERRADA" AND caja_id = "'.$id.'"');//Muestra los ingresos de la caja abierta actualmente

        $egresoCd = DB::SELECT('SELECT m.*, cl.nombre AS nombreCl, cl.apellido AS apellidoCl, e.nombre AS nombreEm, e.apellido AS apellidoEm
                                 FROM movimiento m, caja c, prestamo p, cotizacion co, cliente cl, empleado e
                                 WHERE m.caja_id = c.id AND m.codprestamo = p.id AND p.cotizacion_id = co.id AND m.empleado = e.id AND co.cliente_id = cl.id AND m.tipo = "EGRESO" AND c.estado = "CERRADA" AND caja_id = "'.$id.'"');//Muestra los egresos de la caja abierta actualmente

        return response()->json(["view"=>view('cobranza.divDetalleCaja',compact('ingresoCd', 'egresoCd'))->render()]);
    } 

    public function buscarFechaDiaCaja(Request $request){
        $FechaInicio = $request->FechaInicio;
        $FechaFin = $request->FechaFin;
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;

        $controlCaja = DB::SELECT('SELECT * 
                                    FROM caja 
                                    WHERE sede_id = "'.$idSucursal.'" AND ESTADO = "CERRADA" AND created_at BETWEEN "'.$FechaInicio.'" AND "'.$FechaFin.'"');

        $montoIni = DB::SELECT('SELECT SUM(monto) AS MontoInicial 
                                 FROM caja 
                                 WHERE sede_id = "'.$idSucursal.'" AND ESTADO = "CERRADA" AND created_at BETWEEN "'.$FechaInicio.'" AND "'.$FechaFin.'"');

        $montoFin = DB::SELECT('SELECT SUM(montofin) AS MontoFinal 
                                 FROM caja 
                                 WHERE sede_id = "'.$idSucursal.'" AND ESTADO = "CERRADA" AND created_at BETWEEN "'.$FechaInicio.'" AND "'.$FechaFin.'"');

        $variacion = $montoFin[0]->MontoFinal - $montoIni[0]->MontoInicial;

        return response()->json(["view"=>view('cobranza.divCajaDia',compact('controlCaja', 'variacion'))->render()]);
    }

    public function buscarFechaMesCaja(Request $request){
        $FechaInicio = $request->FechaInicio;
        $FechaFin = $request->FechaFin;
    }

    public function buscarDepositoCliente(Request $request){
        $datoCliente = $request->cliente;
        
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        
        $cliente = DB::SELECT('SELECT p.id AS prestamo_id, p.monto, p.fecinicio, p.fecfin, p.total, cl.id AS cliente_id, cl.nombre, cl.apellido, cl.dni, g.nombre AS garantia, p.intpagar, m.mora AS morapagar, i.porcentaje
                                FROM prestamo p, cotizacion c, cliente cl, garantia g, mora m, tipocredito_interes tci, interes i
                                WHERE c.cliente_id = cl.id AND p.cotizacion_id = c.id AND c.garantia_id = g.id AND p.mora_id = m.id AND p.sede_id = "'.$idSucursal.'" AND p.estado = "ACTIVO DESEMBOLSADO" AND p.tipocredito_interes_id = tci.id AND tci.interes_id = i.id AND (cl.nombre LIKE "%'.$datoCliente.'%" OR cl.apellido LIKE "%'.$datoCliente.'%" OR cl.dni LIKE "%'.$datoCliente.'%")
                                ORDER BY p.fecfin ASC');

        return response()->json(["view"=>view('cobranza.listDepositoCliente',compact('cliente'))->render()]);
    }

    public function notificar()
    {
        $user = Auth::user();
        $usuario = DB::SELECT('SELECT e.nombre, e.apellido, e.id, u.name AS area, e.foto AS foto, e.sede_id AS sede
                                FROM empleado e, users u 
                                WHERE e.users_id = u.id AND u.id = "'.$user->id.'"');
                                
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;

        $listTipoArch = DB::SELECT('SELECT * FROM tipodocumento');

        $listNotificar = DB::SELECT('SELECT p.id AS prestamo_id, cl.nombre, cl.apellido, cl.dni, g.nombre AS garantia, p.fecfin, DATEDIFF(CURDATE(), p.fecinicio) AS dia, p.monto, p.intpagar, p.estado, cl.facebook, cl.whatsapp, cl.correo, cl.telefono, m.mora, cl.referencia, p.fecinicio, i.porcentaje, cl.id AS cliente_id
                                      FROM prestamo p, cotizacion c, cliente cl, garantia g, mora m, tipocredito_interes tci, interes i
                                      WHERE p.cotizacion_id = c.id AND c.cliente_id = cl.id AND c.garantia_id = g.id AND DATEDIFF(CURDATE(), p.fecinicio) > 24 AND p.estado = "ACTIVO DESEMBOLSADO" AND p.mora_id = m.id AND tci.id = p.tipocredito_interes_id AND tci.interes_id = i.id AND p.sede_id = "'.$idSucursal.'"
                                      ORDER BY DATEDIFF(NOW(), p.fecinicio) DESC');

        $countNotificar = COUNT($listNotificar);

        return view('cobranza.notificar', compact('listNotificar', 'usuario', 'listTipoArch', 'countNotificar'));
    }

    public function pasarLiquidacion(Request $request)
    {
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        
        $prestamos = DB::SELECT('SELECT p.id AS prestamo_id, DATEDIFF(CURDATE(), p.fecinicio) AS dia
                                  FROM prestamo p
                                  WHERE p.estado = "ACTIVO DESEMBOLSADO" AND DATEDIFF(CURDATE(), p.fecinicio) > 59');

        for ($i=0; $i < COUNT($prestamos); $i++) { 
            $pre = Prestamo::where('id', '=', $prestamos[$i]->prestamo_id)->first();
            $pre->estado = "LIQUIDACION";
            $pre->save();
        }

        $listNotificar = DB::SELECT('SELECT p.id AS prestamo_id, cl.nombre, cl.apellido, cl.dni, g.nombre AS garantia, p.fecfin, DATEDIFF(CURDATE(), p.fecinicio) AS dia, p.monto, p.intpagar, p.estado, cl.facebook, cl.whatsapp, cl.correo, cl.telefono, m.mora, cl.referencia, p.fecinicio, i.porcentaje
                                      FROM prestamo p, cotizacion c, cliente cl, garantia g, mora m, tipocredito_interes tci, interes i
                                      WHERE p.cotizacion_id = c.id AND c.cliente_id = cl.id AND c.garantia_id = g.id AND DATEDIFF(CURDATE(), p.fecinicio) > 24 AND p.estado = "ACTIVO DESEMBOLSADO" AND p.mora_id = m.id AND tci.id = p.tipocredito_interes_id AND tci.interes_id = i.id AND p.sede_id = "'.$idSucursal.'" 
                                      ORDER BY p.fecfin ASC');

        return response()->json(["view"=>view('cobranza.listNotificar',compact('listNotificar'))->render()]);
    }
    

    public function busquedaClienteNotifi(Request $request)
    {
        $dato = $request->datoCliente; 
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        
        $listNotificar = DB::SELECT('SELECT p.id AS prestamo_id, cl.nombre, cl.apellido, cl.dni, g.nombre AS garantia, p.fecfin, DATEDIFF(CURDATE(), p.fecinicio) AS dia, p.monto, p.intpagar, p.estado, cl.facebook, cl.whatsapp, cl.correo, cl.telefono, m.mora, cl.referencia, p.fecinicio, i.porcentaje, cl.id AS cliente_id
                                      FROM prestamo p, cotizacion c, cliente cl, garantia g, mora m, tipocredito_interes tci, interes i
                                      WHERE p.cotizacion_id = c.id AND c.cliente_id = cl.id AND c.garantia_id = g.id AND DATEDIFF(CURDATE(), p.fecinicio) > 24 AND p.estado = "ACTIVO DESEMBOLSADO" AND p.mora_id = m.id AND tci.id = p.tipocredito_interes_id AND tci.interes_id = i.id  AND (cl.nombre LIKE "%'.$dato.'%" OR cl.apellido LIKE "%'.$dato.'%" OR cl.dni LIKE "%'.$dato.'%") AND cl.sede_id = "'.$idSucursal.'"
                                      ORDER BY DATEDIFF(NOW(), p.fecinicio) DESC');

        return response()->json(["view"=>view('cobranza.listNotificar',compact('listNotificar'))->render()]);
    }

    public function pago()
    { 
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;

        $prestamo = DB::table('prestamo as p')
                        ->select('p.id as prestamo_id', 'p.monto', 'p.fecinicio', 'p.fecfin', 'p.total', 'cl.id as cliente_id', 'cl.nombre', 'cl.apellido', 'cl.dni', 'g.nombre as garantia', 'p.intpagar', 'm.mora as morapagar', 'i.porcentaje')
                        ->join('cotizacion as c', 'p.cotizacion_id', '=', 'c.id')
                        ->join('cliente as cl', 'c.cliente_id', '=', 'cl.id')
                        ->join('garantia as g', 'c.garantia_id', '=', 'g.id')
                        ->join('mora as m', 'p.mora_id', '=', 'm.id')
                        ->join('tipocredito_interes as tci', 'p.tipocredito_interes_id', '=', 'tci.id')
                        ->join('interes as i', 'tci.interes_id', '=', 'i.id')
                        ->where('p.estado', 'ACTIVO DESEMBOLSADO')
                        ->where('p.sede_id', $idSucursal)
                        ->orderByRaw('DATEDIFF(NOW(), p.fecinicio) DESC')
                        ->get();


        $cantPrestamo = COUNT($prestamo);
        
        $listaBancos = Caja::rightJoin('tipocaja as tc', 'caja.tipocaja_id', '=', 'tc.id')
                            ->select('caja.id as caja_id', 'caja.estado', 'caja.monto', 'caja.fecha', 'caja.inicio', 'caja.fin', 'caja.montofin', 'caja.empleado as empleado_id', 'caja.sede_id', 'tc.id as banco_id', 'tc.tipo', 'tc.codigo', 'tc.detalle', 'tc.categoria')
                            ->where('tc.categoria', 'banco')
                            ->where('caja.sede_id', $idSucursal)
                            ->get();
                            
        

        return view('cobranza.pago', compact('prestamo', 'cantPrestamo', 'listaBancos'));
    }

    public function buscarClientePago(Request $request)
    {
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;

        $prestamo = DB::SELECT('SELECT p.id AS prestamo_id, p.monto, p.fecinicio, p.fecfin, p.total, cl.id AS cliente_id, cl.nombre, cl.apellido, cl.dni, g.nombre AS garantia, p.intpagar, m.mora AS morapagar, i.porcentaje
                                 FROM prestamo p, cotizacion c, cliente cl, garantia g, mora m, tipocredito_interes tci, interes i
                                 WHERE c.cliente_id = cl.id AND p.cotizacion_id = c.id AND c.garantia_id = g.id AND p.mora_id = m.id AND p.estado = "ACTIVO DESEMBOLSADO" AND p.tipocredito_interes_id = tci.id AND tci.interes_id = i.id AND (cl.nombre LIKE "%'.$request->dato.'%" OR cl.apellido LIKE "%'.$request->dato.'%" OR cl.dni LIKE "%'.$request->dato.'%")
                                 ORDER BY DATEDIFF(NOW(), p.fecinicio) DESC');

        return response()->json(["view"=>view('cobranza.tabCliente',compact('prestamo'))->render()]);
    }

    public function renovar()
    {
        $user = Auth::user();
        $usuario = DB::SELECT('SELECT e.nombre, e.apellido, e.id, u.name AS area, e.foto AS foto, e.sede_id AS sede
                                FROM empleado e, users u 
                                WHERE e.users_id = u.id AND u.id = "'.$user->id.'"');

        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;

        $prestamo = DB::SELECT('SELECT p.id AS prestamo_id, p.monto, p.fecinicio, p.fecfin, p.total, cl.id AS cliente_id, cl.nombre, cl.apellido, cl.dni, g.nombre AS garantia, p.intpagar, m.mora AS morapagar, i.porcentaje
                                 FROM prestamo p, cotizacion c, cliente cl, garantia g, mora m, tipocredito_interes tci, interes i
                                 WHERE c.cliente_id = cl.id AND p.cotizacion_id = c.id AND c.garantia_id = g.id AND p.mora_id = m.id AND p.estado = "ACTIVO DESEMBOLSADO" AND p.tipocredito_interes_id = tci.id AND tci.interes_id = i.id AND p.codigo = "R" AND p.sede_id = "'.$idSucursal.'"
                                 ORDER BY p.fecfin ASC');

        return view('cobranza.renovar', compact('prestamo', 'usuario'));
    }

    public function printTicket($id)
    {
        
        $pago = Pago::join('prestamo', 'pago.prestamo_id', '=', 'prestamo.id')
                    ->join('cotizacion', 'prestamo.cotizacion_id', '=', 'cotizacion.id')
                    ->join('cliente', 'cotizacion.cliente_id', '=', 'cliente.id')
                    ->join('garantia', 'cotizacion.garantia_id', '=', 'garantia.id')
                    ->join('garantia_casillero', 'garantia.id', '=', 'garantia_casillero.garantia_id')
                    ->join('casillero', 'garantia_casillero.casillero_id', '=', 'casillero.id')
                    ->join('stand', 'casillero.stand_id', '=', 'stand.id')
                    ->join('almacen', 'stand.almacen_id', '=', 'almacen.id')
                    ->join('mora', 'prestamo.mora_id', '=', 'mora.id')
                    ->where('pago.id', $id)
                    ->select(
                        'cliente.nombre',
                        'cliente.apellido',
                        'cliente.dni',
                        'prestamo.id AS prestamo_id',
                        'garantia.nombre AS garantia',
                        'casillero.nombre AS casillero',
                        'stand.nombre AS stand',
                        'almacen.nombre AS almacen',
                        'prestamo.monto AS montoPrestamo',
                        'pago.intpago AS interes',
                        'pago.mora',
                        DB::raw('(prestamo.monto + pago.intpago + pago.mora) AS total'),
                        'pago.importe',
                        DB::raw('(prestamo.monto + pago.intpago + pago.mora - pago.importe) AS restante'),
                        'prestamo.fecinicio'
                    )
                    ->first();
        // dd($pago);
                             
        return view('cobranza.ticket', compact('pago'));
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function pagoPrestamo(Request $request)
    {
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $idPrestamo = $request->idPrestamo;
        $importe = $request->importe; //Cantidad recibida en físco
        $pago = $request->importeMonto; //Cantidad a cobrar segun indicado por el cliente
        $monto = $request->monto;
        $dias = $request->dia;
        $mora = $request->mora;
        $interes = $request->interes;
        $res = 0; //Codigo Inicial
        $conError = "";
        
        // $prestamo = DB::SELECT('SELECT *
        //                          FROM prestamo p
        //                          WHERE p.id = "'.$idPrestamo.'"');
                                 
        $prestamo = Prestamo::where('id', $idPrestamo)->first();
                                 
        $idSucursalPrestamo = $prestamo->sede_id;
        $tipocaja = TipoCaja::where('tipo', 'caja chica')->first();
        $caja = Caja::selectRaw('MAX(id) AS id')
                    ->where('estado', 'ABIERTA')
                    ->where('tipocaja_id', $tipocaja->id)
                    ->where('sede_id', $idSucursalPrestamo)
                    ->first();
        $users_id = Auth::user()->id;
        $empleado = Empleado::select('id')
                    ->where('users_id', $users_id)
                    ->first();

        $empleado_id = $empleado ? $empleado->id : null;
        
        $garantia = Garantia::select('garantia.*')
                            ->join('cotizacion', 'cotizacion.garantia_id', '=', 'garantia.id')
                            ->join('prestamo', 'prestamo.cotizacion_id', '=', 'cotizacion.id')
                            ->where('prestamo.id', $idPrestamo)
                            ->first();
                            
        $totalPago = $mora + $interes + $monto;
                            
        $maxCaja = Caja::select('id', 'monto')
                       ->where('id', $caja->id)
                       ->where('sede_id', $idSucursalPrestamo)
                       ->first();
                       
        $cliente = Cliente::select('cliente.id AS cliente_id', 'cliente.evaluacion')
                          ->join('cotizacion', 'cliente.id', '=', 'cotizacion.cliente_id')
                          ->join('prestamo', 'cotizacion.id', '=', 'prestamo.cotizacion_id')
                          ->where('prestamo.id', $idPrestamo)
                          ->where('prestamo.sede_id', $idSucursalPrestamo)
                          ->first();

        if($pago > $totalPago){
            $res = 1;
            $conError = "Error PTPx0001";

        }elseif ($pago == $totalPago) {
            
            $pre = Prestamo::where('id', '=', $idPrestamo)->first();
            $pre->estado = "PAGADO";
            if ($pre->save()) {
                $pag = new Pago();
                $pag->codigo = "P"; //PAGADO
                $pag->serie = $idPrestamo;
                $pag->monto = $monto;
                $pag->importe = $pago;
                $pag->vuelto = $importe - $pago;
                $pag->intpago = $interes;
                $pag->mora = $mora;
                $pag->diaspasados = $dias;
                $pag->tipocomprobante_id = 1;
                $pag->prestamo_id = $idPrestamo;
                $pag->empleado_id = $idEmpleado;
                $pag->sede_id = $idSucursalPrestamo;
                if ($pag->save()) {

                    $idPago = $pag->id;

                    $mov = new Movimiento();
                    $mov->codigo = "N";
                    $mov->serie = "cc";
                    $mov->estado = "ACTIVO";
                    $mov->monto = $monto; //Aqui debe guardar el importe
                    $mov->concepto = "EFECTIVO - CANCELACIÓN ".$idPrestamo;
                    $mov->tipo = "INGRESO";
                    $mov->empleado = $idEmpleado;
                    $mov->importe = $pago;
                    $mov->codprestamo = $idPrestamo;
                    $mov->condesembolso = $idPago;
                    $mov->codgarantia = $garantia->id;
                    $mov->garantia = $garantia->nombre;
                    $mov->interesPagar = $interes;
                    $mov->moraPagar = $mora;
                    $mov->caja_id = $caja->id;
                    if ($mov->save()) {
                        $idMovimiento = $mov->id;
                                                              
                        $garantia_casillero = GarantiaCasillero::where('garantia_id', $garantia->id)
                                                         ->value('casillero_id');

                        $cas = Casillero::where('id', '=',  $garantia_casillero)->first();
                        $cas->estado = "RECOGER";
                        if ($cas->save()) {

                            $tipocaja = TipoCaja::where('codigo', 'cc')->first();
                                                    
                            $maxCaja = Caja::select('id', 'monto')
                                           ->where('estado', 'abierta')
                                           ->where('tipocaja_id', $tipocaja->id)
                                           ->where('sede_id', $idSucursalPrestamo)
                                           ->groupBy('id')
                                           ->orderByDesc('id')
                                           ->first();
                            
                            $nuevoMonto = proceso::actualizarCaja($maxCaja->monto, $pago, 2);

                            $caja = Caja::where('id', '=', $maxCaja->id)->first();
                            $caja->monto = $nuevoMonto;
                            if ($caja->save()) {

                                $nuevaEvaluacio = $cliente->evaluacion + 30;
                                if ( $nuevaEvaluacio >= 100) {
                                    $nuevaEvaluacio = 100;
                                }
                                
                                $cli = Cliente::where('id', '=', $cliente->cliente_id)->first();
                                $cli->evaluacion = $nuevaEvaluacio;
                                if ($cli->save()) {
                                    $res = 1;
                                    $conError = "";
                                }else{
                                    $res = 0; //Codigo 
                                    $conError = "Error CCxCl0001";
                                }
                            }else{
                                $res = 0; //Codigo 
                                $conError = "Error CCxCa0001";    
                            }

                        }else{
                            $res = 0; //Codigo 
                            $conError = "Error CCxC0001";    
                        }

                    }else{
                        $res = 0; //Codigo 
                        $conError = "Error CCxM0001";
                    }

                }else{
                    $res = 0; //Codigo 
                    $conError = "Error CCxPa0001";
                }
            }else{
                $res = 0; //Codigo 
                $conError = "Error CCxP0001";
            }

        }elseif ($pago < $totalPago) {

            $pre = Prestamo::where('id', '=',  $idPrestamo)->first();
            $pre->monto = $totalPago - $pago;
            $pre->codigo = "n"; //
            if ($pre->save()) {

                $pag = new Pago();
                $pag->codigo = "A"; //AMORTIZADO
                $pag->serie = $idPrestamo;
                $pag->monto = $monto;
                $pag->importe = $pago;
                $pag->vuelto = $importe - $pago;
                $pag->intpago = $interes;
                $pag->mora = $mora;
                $pag->diaspasados = $dias;
                $pag->tipocomprobante_id = 1;
                $pag->prestamo_id = $idPrestamo;
                $pag->empleado_id = $idEmpleado;
                $pag->sede_id = $idSucursalPrestamo;
                if ($pag->save()) {
                    
                    $idPago = $pag->id;

                    $mov = new Movimiento();
                    $mov->codigo = "N";
                    $mov->serie = "cc";
                    $mov->estado = "ACTIVO";
                    $mov->monto = $monto;
                    $mov->concepto = "EFECTIVO - AMORTIZACIÓN ".$idPrestamo;
                    $mov->tipo = "INGRESO";
                    $mov->empleado = $idEmpleado;
                    $mov->importe = $pago;
                    $mov->codprestamo = $idPrestamo;
                    $mov->condesembolso = $idPago;
                    $mov->codgarantia = $garantia->id;
                    $mov->garantia = $garantia->nombre;
                    $mov->interesPagar = $interes;
                    $mov->moraPagar = $mora;
                    $mov->caja_id = $caja->id;
                    if ($mov->save()) {
                        $idMovimiento = $mov->id;
                        $tipocaja = TipoCaja::where('codigo', 'cc')->first();
                        $maxCaja = Caja::select('id', 'monto')
                                       ->where('estado', 'abierta')
                                       ->where('tipocaja_id', $tipocaja->id)
                                       ->where('sede_id', $idSucursalPrestamo)
                                       ->orderByDesc('id')
                                       ->first();

                        $nuevoMonto = proceso::actualizarCaja($maxCaja->monto, $pago, 2);

                        $caja = Caja::where('id', '=', $maxCaja->id)->first();
                        $caja->monto = $nuevoMonto;
                        if ($caja->save()) {

                            $nuevaEvaluacio = $cliente->evaluacion + 15;

                            if ( $nuevaEvaluacio >= 100) {
                                $nuevaEvaluacio = 100;
                            }

                            $cli = Cliente::where('id', '=', $cliente->cliente_id)->first();
                            $cli->evaluacion = $nuevaEvaluacio;
                            if ($cli->save()) {
                                $res = 1;
                                $conError = "";
                            }else {
                                $res = 0; //Codigo 
                                $conError = "Error CCxCl0001";
                            }
                        }else {
                            $res = 0; //Codigo 
                            $conError = "Error CCxCa0002";    
                        }

                    }else {
                        $res = 0; //Codigo 
                        $conError = "Error CCxM0002";
                    }

                }else {
                    $res = 0; //Codigo 
                    $conError = "Error CCxPa0002";
                }
            }else {
                $res = 0; //Codigo 
                $conError = "Error CCxP0002";
            }
        }

        $prestamo =DB::SELECT('SELECT p.id AS prestamo_id, p.monto, p.fecinicio, p.fecfin, p.total, cl.id AS cliente_id, cl.nombre, cl.apellido, cl.dni, g.nombre AS garantia, p.intpagar, m.mora AS morapagar, i.porcentaje
                                FROM prestamo p, cotizacion c, cliente cl, garantia g, mora m, tipocredito_interes tci, interes i
                                WHERE c.cliente_id = cl.id AND p.cotizacion_id = c.id AND c.garantia_id = g.id AND p.mora_id = m.id AND p.estado = "ACTIVO DESEMBOLSADO" AND p.tipocredito_interes_id = tci.id AND tci.interes_id = i.id AND p.sede_id = "'.$idSucursal.'"
                                ORDER BY p.fecfin ASC');

        return response()->json(["view"=>view('cobranza.tabCliente',compact('prestamo'))->render(), "res" => $res, "conError" => $conError, "idPago" => $idPago]);
    }

    

    public function abrirCaja(Request $request)
    {
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        
        $estado = "abierta";
        $fecinicio = date('Y-m-d');
        $montoInicio = $request->montoInicial;

        $caja = new Caja();
        $caja->estado = $estado;
        $caja->fecha = date('Y-m-d');
        $caja->monto = $montoInicio;
        $caja->empleado = $idEmpleado;
        $caja->sede_id = $idSucursal;
        $caja->tipocaja_id = 1;
        if ($caja->save()) {
            $respuesta = "Caja Generada";
            $idCaja = $caja->id;
            
                $ver = "0";
                $caja = DB::SELECT('SELECT * 
                                     FROM caja 
                                     WHERE id = "'.$idCaja.'" AND sede_id = "'.$idSucursal.'"');
            
            return response()->json(["view"=>view('cobranza.genCaja',compact('ver', 'caja'))->render()]);
        }
    }
    
    public function abrirCajaGrande(Request $request)
    {
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        
        $estado = "abierta";
        $fecinicio = date('Y-m-d');
        $montoInicio = $request->montoInicial;

        $caja = new Caja();
        $caja->estado = $estado;
        $caja->fecha = date('Y-m-d');
        $caja->monto = $montoInicio;
        $caja->empleado = $idEmpleado;
        $caja->sede_id = $idSucursal;
        $caja->tipocaja_id = 2;
        if ($caja->save()) {
            $respuesta = "Caja Generada";
            $idCaja = $caja->id;
            
                $ver = "0";
                $caja = DB::SELECT('SELECT * 
                                     FROM caja 
                                     WHERE id = "'.$idCaja.'" AND sede_id = "'.$idSucursal.'"');
            
            return response()->json(["view"=>view('cobranza.genCaja',compact('ver', 'caja'))->render()]);
        }
    }
    
    public function abrirBanco(Request $request){
        
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $idUser = $Proceso->obtenerSucursal()->user_id;
        $estado = "abierta";
        $fecinicio = date('Y-m-d');
        $montoInicio = $request->imputMontoBanco;
        $banco = $request->imputIdBanco;
        $respuesta = "Ya se encuentra una caja abierta para este banco";
        $aux = 0;
        
        $caja_old = DB::SELECT('SELECT * 
                                 FROM caja c, tipocaja tc 
                                 WHERE c.tipocaja_id = tc.id AND c.estado = "abierta" AND tc.id = "'.$banco.'" AND c.sede_id = "'.$idSucursal.'"');
        
        if ($caja_old == null) {
            $caja = new Caja();
            $caja->estado = $estado;
            $caja->fecha = date('Y-m-d');
            $caja->monto = $montoInicio;
            $caja->empleado = $idEmpleado;
            $caja->tipocaja_id = $banco;
            $caja->sede_id = $idSucursal;
            if ($caja->save()) {
                $respuesta = "Caja Generada";
                $aux = 1;
                $idMax = DB::SELECT('SELECT MAX(id) AS id 
                                      FROM caja 
                                      WHERE estado = "abierta" AND sede_id = "'.$idSucursal.'"');
                if ($idMax[0]->id == null) {
                    $ver = "1";
                    $caja = DB::SELECT('SELECT * 
                                         FROM caja 
                                         WHERE id = "'.$idMax[0]->id.'" AND sede_id = "'.$idSucursal.'"');
                }else {
                    $ver = "0";
                    $caja = DB::SELECT('SELECT * 
                                         FROM caja 
                                         WHERE id = "'.$idMax[0]->id.'" AND sede_id = "'.$idSucursal.'"');
                }
                
                
            }
        }

        $listaBancos = DB::SELECT('SELECT 
                                        c.id AS caja_id, c.estado AS estado, c.monto AS monto, c.fecha AS fecha, c.inicio AS inicio, c.fin AS fin, c.montofin AS montofin, c.empleado AS empleado_id, c.sede_id AS sede_id, 
                                        tc.id AS banco_id, tc.tipo AS tipo, tc.codigo AS codigo, tc.detalle AS detalle, tc.categoria AS categoria 
                                    FROM caja c 
                                    RIGHT JOIN tipocaja tc ON c.tipocaja_id = tc.id 
                                    WHERE tc.categoria = "banco" AND c.sede_id = "'.$idSucursal.'"');
                
        return response()->json(["view"=>view('cobranza.tableBanco',compact('listaBancos'))->render(), "respuesta" => $respuesta, "aux" => $aux]);
        
    }

    public function abrirCajaHome(Request $request)
    {
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;
        
        $estado = "abierta";
        $fecinicio = date('Y-m-a');
        $horaInicio = date('h:i:s A');
        $montoInicio = $request->monto;
        $tipocaja = DB::SELECT('SELECT id 
                                 FROM tipocaja 
                                 WHERE codigo = "cc"');

        $caja = new Caja();
        $caja->estado = $estado;
        $caja->monto = $montoInicio;
        $caja->fecha = date('Y-m-a');
        $caja->inicio = $horaInicio;
        $caja->empleado = $idEmpleado;
        $caja->sede_id = $idSucursal;
        $caja->tipocaja_id = $tipocaja[0]->id;

        if ($caja->save()) {
            $resp = "Caja Inicializada";
            return response()->json(['resp'=>$resp]);
        }
    }

    public function crearCaja(Request $request) 
    {
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;
        $estado = "abierta";
        $fecinicio = date('Y-m-a');
        $horaInicio = date('h:i:s A');
        $montoInicio = $request->monto;
        $tipocaja = DB::SELECT('SELECT id 
                                 FROM tipocaja 
                                 WHERE codigo = "cc"');


        $caja = new Caja();
        $caja->estado = $estado;
        $caja->monto = $montoInicio;
        $caja->fecha = date('Y-m-a');
        $caja->inicio = $horaInicio;
        $caja->empleado = $idEmpleado;
        $caja->sede_id = $idSucursal;
        $caja->tipocaja_id = $tipocaja[0]->id;

        if ($caja->save()) {
            $resp = "Caja Inicializada";
            return response()->json(['resp'=>$resp]);
        }
    }

    public function consultarCaja(Request $request) 
    {
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;

        $maxCaja = DB::SELECT('SELECT MAX(id) AS id 
                                FROM caja 
                                WHERE estado = "ABIERTA" AND sede_id = "'.$idSucursal.'"');

        $caja = DB::SELECT('SELECT * 
                             FROM caja 
                             WHERE id = "'.$maxCaja[0]->id.'" AND sede_id = "'.$idSucursal.'"');

        $fecha = $caja[0]->created_at;

        $monto = $caja[0]->monto;

        $id = $caja[0]->id;

        return response()->json(['fecha'=>$fecha, 'monto'=>$monto, 'id'=>$id]);
    }

    public function cerrarCaja(Request $request) 
    {
        $horaFin = date('h:i:s A');
        
        $caja = Caja::where('id', '=',  $request->id)->first();
        $caja->estado = "cerrada";
        $caja->fin = $horaFin;
        $caja->montofin = $request->montoFin;

        if ($caja->save()) {
            $result = "fin";
            return response()->json(['result'=>$result]);
        }

    }

    public function depositarPrestamo(Request $request)
    {
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;
        $idUsuario = Auth::user()->id;
        $idPrestamo = $request->idPrestamo;
        $pago = $request->pago;
        $monto = $request->monto;
        $dias = $request->dia;
        $mora = $request->mora;
        $interes = $request->interes;
        $serie = $request->serie;
        $banco = $request->banco;
        $resp = 0;
        $renovar = $request->renovar;
        // dd($request);
        $prestamo = Prestamo::where('id', $idPrestamo)->first();
        $tipocaja = TipoCaja::where('codigo', $banco)->first();
        $dataBanco = [
                    'estadoCaja' => "abierta",
                    'idSucursal' => $idSucursal,
                    'idTipoCaja' => $banco
                ];
                
        $idSucursalPrestamo = $prestamo->sede_id;
        
        $cliente = Cliente::select('cliente.id AS cliente_id', 'cliente.evaluacion')
                          ->join('cotizacion', 'cliente.id', '=', 'cotizacion.cliente_id')
                          ->join('prestamo', 'cotizacion.id', '=', 'prestamo.cotizacion_id')
                          ->where('prestamo.id', $idPrestamo)
                          ->where('prestamo.sede_id', $idSucursalPrestamo)
                          ->first();
    
        $banco = $this->getBancoByIdUseCase->execute($dataBanco);
        
        $banco = $banco[0];
        
        $garantia = Garantia::join('cotizacion', 'garantia.id', '=', 'cotizacion.garantia_id')
                            ->join('prestamo', 'cotizacion.id', '=', 'prestamo.cotizacion_id')
                            ->where('prestamo.id', $idPrestamo)
                            ->select('garantia.*')
                            ->first();
                            
        $totalPago = $mora + $interes + $monto;
        $pagoMinimo = $mora + $interes;
        $nuevoMontoPrestamo = $monto + $interes + $mora - $pago;
        
        if ($renovar === "PAGAR") {
            if($pago > $totalPago){
                $res = 1;
                $conError = "Error PTPx0001";
    
            } elseif ($pago == $totalPago) {
                $pre = Prestamo::where('id', '=', $idPrestamo)->first();
                $pre->estado = "PAGADO";
                if ($pre->save()) {
                    $pag = new Pago();
                    $pag->codigo = "P"; //PAGADO
                    $pag->serie = $idPrestamo;
                    $pag->monto = $monto;
                    $pag->importe = $pago;
                    $pag->vuelto = "0.00";
                    $pag->intpago = $interes;
                    $pag->mora = $mora;
                    $pag->diaspasados = $dias;
                    $pag->tipocomprobante_id = 1;
                    $pag->prestamo_id = $idPrestamo;
                    $pag->empleado_id = $idEmpleado;
                    $pag->sede_id = $idSucursalPrestamo;
                    if ($pag->save()) {
    
                        $idPago = $pag->id;
    
                        $mov = new Movimiento();
                        $mov->codigo = "N";
                        $mov->serie = $serie;
                        $mov->estado = "ACTIVO";
                        $mov->monto = $monto; //Aqui debe guardar el importe
                        $mov->concepto = "DEPOSITO - CANCELACIÓN ".$idPrestamo;
                        $mov->tipo = "INGRESO";
                        $mov->empleado = $idEmpleado;
                        $mov->importe = $pago;
                        $mov->codprestamo = $idPrestamo;
                        $mov->condesembolso = $idPago;
                        $mov->codgarantia = $garantia->id;
                        $mov->garantia = $garantia->nombre;
                        $mov->interesPagar = $interes;
                        $mov->moraPagar = $mora;
                        $mov->caja_id = $banco->caja_id;
                        if ($mov->save()) {
                            $idMovimiento = $mov->id;
                                                                  
                            $garantia_casillero = GarantiaCasillero::where('garantia_id', $garantia->id)
                                                             ->value('casillero_id');
                                                             
                            // dd($garantia->id);
    
                            $cas = Casillero::where('id', '=',  $garantia_casillero)->first();
                            $cas->estado = "RECOGER";
                            if ($cas->save()) {
    
                                $nuevoMonto = proceso::actualizarCaja($banco->caja_monto, $pago, 2);
    
                                $caja = Caja::where('id', '=', $banco->caja_id)->first();
                                $caja->monto = $nuevoMonto;
                                if ($caja->save()) {
    
                                    $nuevaEvaluacio = $cliente->evaluacion + 30;
                                    if ( $nuevaEvaluacio >= 100) {
                                        $nuevaEvaluacio = 100;
                                    }
                                    
                                    $cli = Cliente::where('id', '=', $cliente->cliente_id)->first();
                                    $cli->evaluacion = $nuevaEvaluacio;
                                    if ($cli->save()) {
                                        $res = 1;
                                        $conError = "";
                                    }else{
                                        $res = 0; //Codigo 
                                        $conError = "Error CCxCl0001";
                                    }
                                }else{
                                    $res = 0; //Codigo 
                                    $conError = "Error CCxCa0001";    
                                }
    
                            }else{
                                $res = 0; //Codigo 
                                $conError = "Error CCxC0001";    
                            }
    
                        }else{
                            $res = 0; //Codigo 
                            $conError = "Error CCxM0001";
                        }
    
                    }else{
                        $res = 0; //Codigo 
                        $conError = "Error CCxPa0001";
                    }
                }else{
                    $res = 0; //Codigo 
                    $conError = "Error CCxP0001";
                }
            } elseif ($pago < $totalPago) {

                $pre = Prestamo::where('id', '=',  $idPrestamo)->first();
                $pre->monto = $totalPago - $pago;
                $pre->codigo = "n"; //
                if ($pre->save()) {
    
                    $pag = new Pago();
                    $pag->codigo = "A"; //AMORTIZADO
                    $pag->serie = $idPrestamo;
                    $pag->monto = $monto;
                    $pag->importe = $pago;
                    $pag->vuelto = "0.00";
                    $pag->intpago = $interes;
                    $pag->mora = $mora;
                    $pag->diaspasados = $dias;
                    $pag->tipocomprobante_id = 1;
                    $pag->prestamo_id = $idPrestamo;
                    $pag->empleado_id = $idEmpleado;
                    $pag->sede_id = $idSucursalPrestamo;
                    if ($pag->save()) {
                        
                        $idPago = $pag->id;
    
                        $mov = new Movimiento();
                        $mov->codigo = "N";
                        $mov->serie = $serie;
                        $mov->estado = "ACTIVO";
                        $mov->monto = $monto;
                        $mov->concepto = "DEPOSITO - AMORTIZACIÓN ".$idPrestamo;
                        $mov->tipo = "INGRESO";
                        $mov->empleado = $idEmpleado;
                        $mov->importe = $pago;
                        $mov->codprestamo = $idPrestamo;
                        $mov->condesembolso = $idPago;
                        $mov->codgarantia = $garantia->id;
                        $mov->garantia = $garantia->nombre;
                        $mov->interesPagar = $interes;
                        $mov->moraPagar = $mora;
                        $mov->caja_id = $banco->caja_id;
                        if ($mov->save()) {
                            $idMovimiento = $mov->id;
                            // $tipocaja = TipoCaja::where('codigo', 'cc')->first();
                            // $maxCaja = Caja::select('id', 'monto')
                            //               ->where('estado', 'abierta')
                            //               ->where('tipocaja_id', $tipocaja->id)
                            //               ->where('sede_id', $idSucursalPrestamo)
                            //               ->orderByDesc('id')
                            //               ->first();
    
                            $nuevoMonto = proceso::actualizarCaja($banco->caja_monto, $pago, 2);
    
                            $caja = Caja::where('id', '=', $banco->caja_id)->first();
                            $caja->monto = $nuevoMonto;
                            if ($caja->save()) {
    
                                $nuevaEvaluacio = $cliente->evaluacion + 15;
    
                                if ( $nuevaEvaluacio >= 100) {
                                    $nuevaEvaluacio = 100;
                                }
    
                                $cli = Cliente::where('id', '=', $cliente->cliente_id)->first();
                                $cli->evaluacion = $nuevaEvaluacio;
                                if ($cli->save()) {
                                    $res = 1;
                                    $conError = "";
                                }else {
                                    $res = 0; //Codigo 
                                    $conError = "Error CCxCl0001";
                                }
                            }else {
                                $res = 0; //Codigo 
                                $conError = "Error CCxCa0002";    
                            }
    
                        }else {
                            $res = 0; //Codigo 
                            $conError = "Error CCxM0002";
                        }
    
                    }else {
                        $res = 0; //Codigo 
                        $conError = "Error CCxPa0002";
                    }
                }else {
                    $res = 0; //Codigo 
                    $conError = "Error CCxP0002";
                }
            }
        } else {
            // Hacer algo si $renovar no es igual a "PAGAR" o no es del mismo tipo de dato (cadena)
            $fechaInicio = $prestamo->fecinicio;
            $nuevaFechaInicio = date("Y-m-d", strtotime($fechaInicio."+ 1 month"));
            $fechaFin = $prestamo->fecfin;
            $nuevaFechaFin = date("Y-m-d", strtotime($fechaFin."+1 month"));
            
            if ($pago == $pagoMinimo) {
            
                $nuevoMonto = proceso::actualizarCaja($banco->caja_monto, $pago, 2);
                
                $nuevaEvaluacio = $cliente->evaluacion + 5;
    
                if ( $nuevaEvaluacio >= 100) {
                    $nuevaEvaluacio = 100;
                }
    
                $aux = 1;
                
            } elseif ($pago > $pagoMinimo) {
            
                $nuevoMonto = $totalPago - $pago;
                
                $nuevoMonto = proceso::actualizarCaja($banco->caja_monto, $pago, 2);
                
                $nuevaEvaluacio = $cliente->evaluacion + 5;
    
                if ( $nuevaEvaluacio >= 100) {
                    $nuevaEvaluacio = 100;
                }
               
                $aux = "1";
    
            }else {
                $aux = "2";
            }
            
            $nuevoMonto = proceso::actualizarCaja($banco->caja_monto, $pago, 2);
            
            $dataPag = [
                'idPrestamo' => $idPrestamo,
                'estadoPrestamo' => "RENOVADO",
                
                'codigoPago' => "R",
                'monto' => $monto,
                'montoPago' => $pago,
                'vueltoPago' => "0.00",
                'interesPago' => $interes,
                'moraPago' => $mora,
                'diasPago' => $dias,
                'idTipoComprobante' => "1",
                'idEmpleado' => $idEmpleado,
                'idSucursal' => $idSucursal,
                
                'idCaja' => $banco->caja_id,
                'nuevoMontoCaja' => $nuevoMonto,
                'estadoMovimiento' => "ACTIVO",
                'montoPrestamo' => $pago,
                'conceptoMovimiento' => "DEPOSITO RENOVACION-".$idPrestamo,
                'tipoMovimiento' => "INGRESO",
                'importeMovimiento' => $pago,
                'codigoOrigenMovimiento' => "R",
                'codigoSerieMovimiento' => $serie,
                'idGarantia' => $garantia->id,
                'nombreGarantia' => $garantia->nombre,
            ];
            
            $pago = $this->createPagoUseCase->execute($dataPag);
            
            $data = [
                'mensajeNotificacion' => "El cliente ".$cliente->nombre." ".$cliente->apellido.", renovó su prestamo",
                'asuntoNotificacion' => "Renovacion de Prestamo",
                'estadoNotificacion' => "PENDIENTE",
                'tipoNotificacion' => "PAGO",
                'idUser' => $idUsuario,
                'iconNotificacion' => "fa-archive",
                
                'codigoOrigenPrestamo' => "R",
                'monto' => $nuevoMontoPrestamo,
                'fechaInicio' => $nuevaFechaInicio,
                'fechaFin' => $nuevaFechaFin,
                'precioTotal' => $totalPago,
                'estadoPrestamo' => "ACTIVO DESEMBOLSADO",
                'idCotizacion' => $prestamo->cotizacion_id,
                'estadoCotizacion' => "FINAL",
                'idEmpleado' => $idEmpleado,
                'idTipoCreditoInteres' => $prestamo->tipocredito_interes_id,
                'idMora' => $prestamo->mora_id,
                'estadoMacro' => "SIN MACRO",
                'interesPagar' => $interes,
                'idSucursal' => $idSucursal
            ];
            
            $prestamo = $this->createPrestamoUseCase->execute($data);
            
            $dataCliente = [
                'idCliente' => $cliente->cliente_id,
                'puntajeCliente' => $nuevaEvaluacio
            ];
                    
            $cliente = $this->updatePuntajeClienteUseCase->execute($dataCliente);
            
            $idPago = $pago->id;
            $res = 1;
            $conError = "";
            
        }
        
        // dd($idPago);

        $prestamo =DB::SELECT('SELECT p.id AS prestamo_id, p.monto, p.fecinicio, p.fecfin, p.total, cl.id AS cliente_id, cl.nombre, cl.apellido, cl.dni, g.nombre AS garantia, p.intpagar, m.mora AS morapagar, i.porcentaje
                                FROM prestamo p, cotizacion c, cliente cl, garantia g, mora m, tipocredito_interes tci, interes i
                                WHERE c.cliente_id = cl.id AND p.cotizacion_id = c.id AND c.garantia_id = g.id AND p.mora_id = m.id AND p.estado = "ACTIVO DESEMBOLSADO" AND p.tipocredito_interes_id = tci.id AND tci.interes_id = i.id AND p.sede_id = "'.$idSucursal.'"
                                ORDER BY p.fecfin ASC');

        return response()->json(["view"=>view('cobranza.tabCliente',compact('prestamo'))->render(), "res" => $res, "conError" => $conError, "idPago" => $idPago]);
    }

    public function ingresarComision(Request $request)
    {
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;
        $idPrestamo = $request->idPrestamo;
        $comision = $request->comision;
        $banco = $request->banco;
        $resp = 0;

        $tipocaja = DB::SELECT('SELECT * FROM tipocaja WHERE codigo = "'.$banco.'"');
        $maxCaja = DB::SELECT('SELECT MAX(id) AS id, monto 
                                FROM caja 
                                WHERE estado = "abierta" AND tipocaja_id = "'.$tipocaja[0]->id.'" AND sede_id = "'.$idSucursal.'"
                                group by id');

        $nuevoMonto = $maxCaja[0]->monto - $comision;

        $caja = Caja::where('id', '=', $maxCaja[0]->id)->first();
        $caja->monto = $nuevoMonto;
        if ($caja->save()) {
            $resp = 1;
        }

        return response()->json(['resp'=>$resp]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function renovarDepositoPrestamo(Request $request)
    {
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;
        
        $idPrestamo = $request->idPrestamo;
        $pago = $request->pago; 
        $monto = $request->monto;
        $dias = $request->dia;
        $mora = $request->mora;
        $interes = $request->interes;
        $serie = $request->serie;
        $banco = $request->banco;
        $pagoMinimo = $mora + $interes;
        $totalPago = $pagoMinimo + $monto;

        $prestamo = DB::SELECT('SELECT *
                                 FROM prestamo p
                                 WHERE p.id = "'.$idPrestamo.'" AND sede_id = "'.$idSucursal.'"');
                                 
        $tipocaja = DB::SELECT('SELECT * 
                                 FROM tipocaja 
                                 WHERE codigo = "'.$banco.'"');
                                 
        $caja = DB::SELECT('SELECT MAX(id) AS id, monto
                             FROM caja 
                             WHERE estado = "ABIERTA" AND tipocaja_id = "'.$tipocaja[0]->id.'" AND sede_id = "'.$idSucursal.'"
                             group by id');

        $garantia = DB::SELECT('SELECT g.* FROM prestamo p
                                INNER JOIN cotizacion c ON p.cotizacion_id = c.id
                                INNER JOIN garantia g ON c.garantia_id = g.id
                                WHERE p.id = "'.$idPrestamo.'"');

        $fechaInicio = $prestamo[0]->fecinicio;
        $nuevaFechaInicio = date("Y-m-d", strtotime($fechaInicio."+ 1 month"));
        $fechaFin = $prestamo[0]->fecfin;
        $nuevaFechaFin = date("Y-m-d", strtotime($fechaFin."+1 month"));

        if ($pago == $pagoMinimo) {
            
            $pre = new Prestamo();
            $pre->codigo = "R";
            $pre->monto = $monto;
            $pre->fecinicio = $nuevaFechaInicio;
            $pre->fecfin = $nuevaFechaFin;
            $pre->total = $totalPago;
            $pre->macro = "SIN MACRO";
            $pre->intpagar = $interes;
            $pre->estado = "ACTIVO DESEMBOLSADO";
            $pre->tipocredito_interes_id = $prestamo[0]->tipocredito_interes_id;
            $pre->cotizacion_id = $prestamo[0]->cotizacion_id;
            $pre->mora_id = $prestamo[0]->mora_id;
            $pre->empleado_id = $idEmpleado;
            $pre->sede_id = $idSucursal;
            if ($pre->save()) {

                $pres = Prestamo::where('id', '=',  $idPrestamo)->first();
                $pres->estado = "RENOVADO";
                if ($pres->save()) {
                    
                    $pag = new Pago();
                    $pag->codigo = "R";
                    $pag->serie = $idPrestamo;
                    $pag->monto = $monto;
                    $pag->importe = $pago;
                    $pag->vuelto = "0.00";
                    $pag->intpago = $interes;
                    $pag->mora = $mora;
                    $pag->diaspasados = $dias;
                    $pag->tipocomprobante_id = "1";
                    $pag->prestamo_id = $idPrestamo;
                    $pag->empleado_id = $idEmpleado;
                    $pag->sede_id = $idSucursal;
                    if ($pag->save()) {
                        
                        $idPago = $pag->id;
                        $des = DB::SELECT('SELECT id FROM desembolso WHERE prestamo_id = "'.$idPrestamo.'"');

                        $mov = new Movimiento();
                        $mov->codigo = "D";
                        $mov->serie = $serie;
                        $mov->estado = "ACTIVO";
                        $mov->monto = $pago;
                        $mov->concepto = "DEPOSITO RENOVACION-".$idPrestamo;
                        $mov->tipo = "INGRESO";
                        $mov->empleado = $idEmpleado;
                        $mov->importe = $pago;
                        $mov->codprestamo = $idPrestamo;
                        $mov->condesembolso = $idPago;
                        $mov->codgarantia = $garantia[0]->id;
                        $mov->garantia = $garantia[0]->nombre;
                        $mov->interesPagar = $interes;
                        $mov->moraPagar = $mora;
                        $mov->caja_id = $caja[0]->id;
                        if ($mov->save()) {
                            
                            $nuevoMonto = $caja[0]->monto + $pago;

                            $caja = Caja::where('id', '=', $caja[0]->id)->first();
                            $caja->monto = $nuevoMonto;
                            if ($caja->save()) {
                                $aux = "1";
                            }
                        }
                    }
                }
            }
        }elseif ($pago > $pagoMinimo) {
            
            $nuevoMonto = $totalPago - $pago;

            $pre = new Prestamo();
            $pre->codigo = "R";
            $pre->monto = $nuevoMonto;
            $pre->fecinicio = $nuevaFechaInicio;
            $pre->fecfin = $nuevaFechaFin;
            $pre->total = $totalPago;
            $pre->macro = "SIN MACRO";
            $pre->intpagar = $interes;
            $pre->estado = "ACTIVO DESEMBOLSADO";
            $pre->tipocredito_interes_id = $prestamo[0]->tipocredito_interes_id;
            $pre->cotizacion_id = $prestamo[0]->cotizacion_id;
            $pre->mora_id = $prestamo[0]->mora_id;
            $pre->empleado_id = $idEmpleado;
            $pre->sede_id = $idSucursal;
            if ($pre->save()) {
                
                $pres = Prestamo::where('id', '=',  $idPrestamo)->first();
                $pres->estado = "RENOVADO";
                if ($pres->save()) {
                    
                    $pag = new Pago();
                    $pag->codigo = "R";
                    $pag->serie = $idPrestamo;
                    $pag->monto = $monto;
                    $pag->importe = $pago;
                    $pag->vuelto = "0.00";
                    $pag->intpago = $interes;
                    $pag->mora = $mora;
                    $pag->diaspasados = $dias;
                    $pag->tipocomprobante_id = "1";
                    $pag->prestamo_id = $idPrestamo;
                    $pag->empleado_id = $idEmpleado;
                    $pag->sede_id = $idSucursal;
                    if ($pag->save()) {
                        
                        $idPago = $pag->id;
                        $des = DB::SELECT('SELECT id FROM desembolso WHERE id = "'.$idPrestamo.'"');

                        $mov = new Movimiento();
                        $mov->codigo = "D";
                        $mov->serie = $serie;
                        $mov->estado = "ACTIVO";
                        $mov->monto = $pago;
                        $mov->concepto = "DEPOSITO RENOVACION-".$idPrestamo;
                        $mov->tipo = "INGRESO";
                        $mov->empleado = $idEmpleado;
                        $mov->importe = $pago;
                        $mov->codprestamo = $idPrestamo;
                        $mov->condesembolso = $idPago;
                        $mov->codgarantia = $garantia[0]->id;
                        $mov->garantia = $garantia[0]->nombre;
                        $mov->interesPagar = $interes;
                        $mov->moraPagar = $mora;
                        $mov->caja_id = $caja[0]->id;
                        if ($mov->save()) {
                            
                            $nuevoMonto = $caja[0]->monto + $pago;

                            $caja = Caja::where('id', '=', $caja[0]->id)->first();
                            $caja->monto = $nuevoMonto;
                            if ($caja->save()) {
                                $aux = "1";
                            }
                        }
                    }
                }
            }
        }else {
            $aux = "2";
        }

        $prestamo = DB::SELECT('SELECT p.id AS prestamo_id, p.monto, p.fecinicio, p.fecfin, p.total, cl.id AS cliente_id, cl.nombre, cl.apellido, cl.dni, g.nombre AS garantia, p.intpagar, m.mora AS morapagar, i.porcentaje
                                 FROM prestamo p, cotizacion c, cliente cl, garantia g, mora m, tipocredito_interes tci, interes i
                                 WHERE c.cliente_id = cl.id AND p.cotizacion_id = c.id AND c.garantia_id = g.id AND p.mora_id = m.id AND p.estado = "ACTIVO DESEMBOLSADO" AND p.tipocredito_interes_id = tci.id AND tci.interes_id = i.id AND p.sede_id = "'.$idSucursal.'"
                                 ORDER BY p.fecfin ASC');

        return response()->json(["view"=>view('cobranza.tabCliente',compact('prestamo', 'aux'))->render(), 'resp'=>$aux, 'idPrestamo'=>$idPrestamo, 'banco'=>$banco]);
    }

    public function guardarNotificar(Request $request)
    {
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;
        $img=$request->archivo;
        $prestamo_id = $request->prestamo_id;
        $nombreArc = $request->nomArchivo;
        $asunto = $request->asunArchivo;
        $tipodocumento_id = $request->tipodocumento_id;
        $subido="";
        $urlGuardar="";
        $resp = "";

        if ($request->hasFile('archivo')) { 
            $nombre=$img->getClientOriginalName();
            $extension=$img->getClientOriginalExtension();
            $nuevoNombre=$nombreArc.$prestamo_id.".".$extension;
            $subido = Storage::disk('notifiPrestamo')->put($nuevoNombre, File::get($img));
            if($subido){
                $urlGuardar='img/notifiPrestamo/'.$nuevoNombre;
            }
        }

        $doc = new Documento();
        $doc->nombre = $nombreArc;
        $doc->asunto = $asunto;
        $doc->url = $urlGuardar;
        $doc->fecha = date('Y-m-d');
        $doc->estado = "NOTIFICACION";
        $doc->tipodocumento_id = $tipodocumento_id;
        if ($doc->save()) {
            $idDocumento = $doc->id;

            $pdoc = new PrestamoDocumento();
            $pdoc->asunto = $asunto;
            $pdoc->detalle = "Notificacion al prestamo ".$prestamo_id;
            $pdoc->estado = "ACTIVO";
            $pdoc->prestamo_id = $prestamo_id;
            $pdoc->documento_id = $idDocumento;
            if ($pdoc->save()) {
                $resp = 1;
            }
        }

        return response()->json([ "resp" => $resp]);
    }

    public function consultarMovimiento(Request $request)
    {
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;
        
        $nombre = $request->nombre;
        $codigo = $request->codigo;
        $fecinicio = $request->fecInicio;
        $fecfin = $request->fecFin;
        $cant = 0;

        $consultaI = DB::SELECT('SELECT m.id AS cod, m.monto AS monto, m.concepto AS concepto, m.tipo AS tipo, DATE(m.created_at) AS fecha, g.nombre
                                 FROM movimiento m, prestamo p, cotizacion c, cliente cl, garantia g
                                 WHERE m.codprestamo = p.id AND p.cotizacion_id = c.id AND c.cliente_id = cl.id AND m.codgarantia = g.id AND m.tipo = "INGRESO" AND p.sede_id = "'.$idSucursal.'" AND (m.id = "'.$codigo.'" AND CONCAT(cl.nombre, " ", cl.apellido) LIKE "%'.$nombre.'%") AND m.created_at BETWEEN "'.$fecinicio.'" AND "'.$fecfin.'"');

        $consultaE = DB::SELECT('SELECT m.id AS cod, m.monto AS monto, m.concepto AS concepto, m.tipo AS tipo, DATE(m.created_at) AS fecha, g.nombre
                                  FROM movimiento m, prestamo p, cotizacion c, cliente cl, garantia g
                                  WHERE m.codprestamo = p.id AND p.cotizacion_id = c.id AND c.cliente_id = cl.id AND m.codgarantia = g.id AND m.tipo = "EGRESO" AND p.sede_id = "'.$idSucursal.'" AND (m.id = "'.$codigo.'" AND CONCAT(cl.nombre, " ", cl.apellido) LIKE "%'.$nombre.'%") AND m.created_at BETWEEN "'.$fecinicio.'" AND "'.$fecfin.'"');

        $cant = COUNT($consultaI) + COUNT($consultaE);

        return response()->json(["view"=>view('cobranza.tabConsulta',compact('consultaI', 'consultaE'))->render(), "cant" => $cant]);
    }

    public function consultarHistorial(Request $request)
    {
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;
        
        $ingreso = DB::SELECT('SELECT m.*, m.created_at AS fecha, cl.nombre AS nomCli, cl.apellido AS apeCli, e.nombre AS nomEmp, e.apellido AS apeEmp FROM movimiento m INNER JOIN caja c ON m.caja_id = c.id LEFT JOIN prestamo p ON m.codprestamo = p.id LEFT JOIN cotizacion co ON p.cotizacion_id = co.id LEFT JOIN cliente cl ON co.cliente_id = cl.id LEFT JOIN empleado e ON m.empleado = e.id WHERE m.tipo = "INGRESO" AND c.estado = "ABIERTA" AND c.sede_id = "'.$idSucursal.'" AND DATE_FORMAT(m.created_at, "%Y-%m-%d") = "'.$request->fecha.'" ORDER BY m.created_at DESC');
                            

        $sumIngreso = DB::SELECT('SELECT SUM(m.importe) monto
                                    FROM movimiento m, caja c, prestamo p, cotizacion co, cliente cl, empleado e
                                    WHERE m.caja_id = c.id AND m.codprestamo = p.id AND p.cotizacion_id = co.id AND m.empleado = e.id AND co.cliente_id = cl.id AND m.tipo = "INGRESO" AND c.estado = "ABIERTA" AND c.sede_id = "'.$idSucursal.'" AND DATE_FORMAT(m.created_at, "%Y-%m-%d") = "'.$request->fecha.'"');

        $egreso = DB::SELECT('SELECT m.*, m.created_at AS fecha, cl.nombre AS nomCli, cl.apellido AS apeCli, e.nombre AS nomEmp, e.apellido AS apeEmp 
                               FROM movimiento m 
                               INNER JOIN caja c ON m.caja_id = c.id 
                               LEFT JOIN prestamo p ON m.codprestamo = p.id 
                               LEFT JOIN cotizacion co ON p.cotizacion_id = co.id 
                               LEFT JOIN cliente cl ON co.cliente_id = cl.id 
                               LEFT JOIN empleado e ON m.empleado = e.id WHERE m.tipo = "EGRESO" AND c.estado = "ABIERTA" AND c.sede_id = "'.$idSucursal.'" AND DATE_FORMAT(m.created_at, "%Y-%m-%d") = "'.$request->fecha.'" ORDER BY m.created_at DESC');
                               
                               

        $sumEgreso = DB::SELECT('SELECT SUM(m.monto) AS monto
                                   FROM movimiento m, caja c
                                   WHERE m.caja_id = c.id AND c.sede_id = "'.$idSucursal.'" AND m.tipo = "EGRESO"  AND DATE_FORMAT(m.created_at, "%Y-%m-%d") = "'.$request->fecha.'"');

        return response()->json(["view"=>view('cobranza.listaHitorial',compact('ingreso', 'egreso', 'sumIngreso', 'sumEgreso'))->render()]);
    }
    
    public function crearBanco(Request $request)
    {
        
        $nombre = $request->nombreBanco;
        $detalle = $request->detalleBanco;
        $palabras = explode(" ", $nombre);
        $siglas = "";
        foreach ($palabras as $palabra) {
            $siglas .= substr($palabra, 0, 1);
        }
        $siglas = strtoupper($siglas);
        $categoria = "banco";
        
        $tCaja = new Tipocaja();
        $tCaja->tipo = $nombre;
        $tCaja->detalle = $detalle;
        $tCaja->codigo = $siglas;
        $tCaja->categoria = $categoria;
        if ($tCaja->save()) {
            
            $listBanco = DB::SELECT('SELECT * FROM tipocaja WHERE categoria = "banco";');

        }

        return response()->json(["view"=>view('cobranza.tabBanco',compact('listBanco'))->render()]);
    }
    
    public function editarBanco(Request $request)
    {
        $nombre = $request->nombreBanco;
        $detalle = $request->detalleBanco;
        $idTipoCaja = $request->banco_id;
        
        $tCaja = Tipocaja::where('id', '=',  $idTipoCaja)->first();
        $tCaja->tipo = $nombre;
        $tCaja->detalle = $detalle;
        if ($tCaja->save()) {
            
        }
        
        $listBanco = DB::SELECT('SELECT * FROM tipocaja WHERE categoria = "banco";');

        return response()->json(["view"=>view('cobranza.tabBanco',compact('listBanco'))->render()]);
    }
    
    public function eliminarBanco(Request $request)
    {
        $idTipoCaja = $request->banco_id;
        $tCaja = Tipocaja::where('id', '=',  $idTipoCaja)->first();
        $tCaja->delete();
        
        $listBanco = DB::SELECT('SELECT * FROM tipocaja WHERE categoria = "banco";');

        return response()->json(["view"=>view('cobranza.tabBanco',compact('listBanco'))->render()]);
    }
    
    public function buscarBanco(Request $request)
    {
        
        $dato = $request->dato;
        
        $listBanco = DB::SELECT('SELECT * FROM tipocaja WHERE categoria = "banco" AND tipo LIKE "%'.$dato.'%";');

        return response()->json(["view"=>view('cobranza.tabBanco',compact('listBanco'))->render()]);
    }
    
    public function asignarCapital(Request $request)
    {
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;
        $idBanco = $request->banco_id;
        $capital = $request->capital;
        
        $resp = 0;
        
        $dataBanco = [
            'estadoCaja' => "abierta",
            'idSucursal' => $idSucursal,
            'idTipoCaja' => $idBanco
            ];
        
        $cajaExist = $this->getBancoByIdUseCase->execute($dataBanco);
        
        if (!count($cajaExist) > 0) {
            
            $resp = 1;
        
            $data = [
                    'estadoBanco' => "abierta",
                    'montoBanco' => $capital,
                    'fechaBanco' => date('Y-m-d'),
                    'inicioBanco' => date('H:i:s'),
                    'finBanco' => "",
                    'montoFinBanco' => 0.00,
                    'idEmpleado' => $idEmpleado,
                    'idSucursal' => $idSucursal,
                    'idTipoCaja' => $idBanco
                ];
                        
            $caja = $this->createBancoUseCase->execute($data);
        
        }
        
        
        $misBancos = DB::table('tipocaja as tc')
                        ->leftJoin('caja as c', 'tc.id', '=', 'c.tipocaja_id')
                        ->where('tc.categoria', 'banco')
                        ->where('c.sede_id', $idSucursal)
                        ->get();
                        
        $listBanco = DB::table('tipocaja as tc')
                        ->leftJoin('caja as c', 'tc.id', '=', 'c.tipocaja_id')
                        ->where('tc.categoria', 'banco')
                        ->groupBy('tc.detalle')
                        ->get();


        return response()->json(["view"=>view('cobranza.tabBanco',compact('listBanco'))->render(), "viewMisBancos"=>view('cobranza.tabMisBancos',compact('misBancos'))->render(), "resp" =>$resp ]);
        
    }
    
    public function asignarCapitalBanco(Request $request)
    {
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;
        $idBanco = $request->banco_id;
        $capital = $request->capital;
        $resp = 0;
        
        $dataBanco = [
            'estadoCaja' => "abierta",
            'idSucursal' => $idSucursal,
            'idTipoCaja' => $idBanco
            ];
        
        $cajaExist = $this->getBancoByIdUseCase->execute($dataBanco);
        
        dd($cajaExist);
        
        if ($cajaExist == null) {
            $resp = 1;
            $data = [
                    'estadoBanco' => "abierta",
                    'montoBanco' => $capital,
                    'fechaBanco' => date('Y-m-d'),
                    'inicioBanco' => date('H:i:s'),
                    'finBanco' => "",
                    'montoFinBanco' => 0.00,
                    'idEmpleado' => $idEmpleado,
                    'idSucursal' => $idSucursal,
                    'idTipoCaja' => $idBanco
                ];
                        
            $caja = $this->createBancoUseCase->execute($data);    
        }
        
        
        
        $misBancos = DB::table('tipocaja as tc')
                        ->leftJoin('caja as c', 'tc.id', '=', 'c.tipocaja_id')
                        ->where('tc.categoria', 'banco')
                        ->where('c.sede_id', $idSucursal)
                        ->get();
                        
        $listBanco = DB::table('tipocaja as tc')
                        ->leftJoin('caja as c', 'tc.id', '=', 'c.tipocaja_id')
                        ->where('tc.categoria', 'banco')
                        ->groupBy('tc.detalle')
                        ->get();

        return response()->json(["view"=>view('cobranza.tabBanco',compact('listBanco'))->render(), "viewMisBancos"=>view('cobranza.tabMisBancos',compact('misBancos'))->render(), "resp" => $resp]);
        
    }
    
    public function gestionBanco()
    {
                                
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;

        $misBancos = DB::table('tipocaja as tc')
                        ->leftJoin('caja as c', 'tc.id', '=', 'c.tipocaja_id')
                        ->where('tc.categoria', 'banco')
                        ->where('c.sede_id', $idSucursal)
                        ->get();
                        
        $listBanco = DB::table('tipocaja as tc')
                        ->leftJoin('caja as c', 'tc.id', '=', 'c.tipocaja_id')
                        ->where('tc.categoria', 'banco')
                        ->groupBy('tc.detalle')
                        ->get();
                        
        return view('cobranza.banco', compact('listBanco', 'misBancos'));
    }
    
}
