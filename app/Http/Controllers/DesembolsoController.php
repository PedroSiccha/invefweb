<?php

namespace App\Http\Controllers;

use App\Application\UseCases\Banco\GetBancoByIdUseCase;
use App\Application\UseCases\Caja\GetCajaByTipoUseCase;
use App\Application\UseCases\Desembolso\CreateDesembolsoUseCase;
use App\Application\UseCases\Garantia\GetGarantiaByPrestamoUseCase;
use App\Models\Desembolso;
use App\Models\Prestamo;
use App\Models\Proceso;
use App\Models\TipoCaja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DesembolsoController extends Controller
{
    protected $createDesembolsoUseCase;
    protected $getCajaByTipoUseCase;
    protected $getGarantiaByPrestamoUseCase;
    protected $getBancoByIdUseCase;
    
    public function __construct(
        CreateDesembolsoUseCase $createDesembolsoUseCase, 
        GetCajaByTipoUseCase $getCajaByTipoUseCase, 
        GetGarantiaByPrestamoUseCase $getGarantiaByPrestamoUseCase, 
        GetBancoByIdUseCase $getBancoByIdUseCase
        )
    {
        $this->middleware('auth');
        $this->createDesembolsoUseCase = $createDesembolsoUseCase;
        $this->getCajaByTipoUseCase = $getCajaByTipoUseCase;
        $this->getGarantiaByPrestamoUseCase = $getGarantiaByPrestamoUseCase;
        $this->getBancoByIdUseCase = $getBancoByIdUseCase;
    }
    
    public function desembolso()
    {
        $Proceso = new Proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;

        $prestamo = Prestamo::select('prestamo.id AS prestamo_id', 'cliente.nombre', 'cliente.apellido', 'cliente.dni', 'prestamo.created_at', 'cliente.id AS cliente_id')
                            ->join('cotizacion', 'prestamo.cotizacion_id', '=', 'cotizacion.id')
                            ->join('cliente', 'cotizacion.cliente_id', '=', 'cliente.id')
                            ->where('prestamo.estado', 'ACTIVO')
                            ->where('prestamo.sede_id', $idSucursal)
                            ->get();
                                 
        $cantPrestamos = COUNT($prestamo);
        
        $bancos = TipoCaja::select('tipocaja.*')
                            ->join('caja', 'caja.tipocaja_id', '=', 'tipocaja.id')
                            ->where('caja.estado', 'abierta')
                            ->where('tipocaja.categoria', 'banco')
                            ->where('caja.sede_id', $idSucursal)
                            ->get();

        return view('desembolso.desembolso', compact('prestamo', 'bancos', 'cantPrestamos'));
    }

    public function desembolsar(Request $request)
    {
        
        $Proceso = new Proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        
        $desm = Desembolso::max('id');
                             
        $prestamo = Prestamo::find($request->id);
        
        $dataCaja = [
                'estadoCaja' => "abierta",
                'tipoCaja' => "caja chica",
                'idSucursal' => $idSucursal
            ];
                    
        $caja = $this->getCajaByTipoUseCase->execute($dataCaja);
        
        $garantia = $this->getGarantiaByPrestamoUseCase->execute($request->id);

        $nuevoMonto = Proceso::actualizarCaja($caja->monto, $prestamo->monto, 1);

        $numero = $desm->id ?? 1;
        $numero++;
        
        $data = [
                'numeroDesembolso' => $numero,
                'estadoDesembolso' => "DESEMBOLSADO",
                'montoPrestamo' => $prestamo->monto,
                'idPrestamo' => $request->id,
                'idEmpleado' => $idEmpleado,
                'idSucursal' => $idSucursal,
                'idCaja' => $caja->id,
                'nuevoMontoCaja' => $nuevoMonto,
                'estadoMovimiento' => "ACTIVO",
                'conceptoMovimiento' => "DESEMBOLSO EN EFECTIVO. CODIGO: ".$request->id,
                'tipoMovimiento' => "EGRESO",
                'importeMovimiento' => $prestamo->monto,
                'codigoOrigenMovimiento' => "N",
                'codigoSerieMovimiento' => "cc",
                'idGarantia' => $garantia->id,
                'nombreGarantia' => $garantia->nombre,
                'estadoPrestamo' => "ACTIVO DESEMBOLSADO",
                'mensajeNotificacion' => "El cliente: ".Auth::user()->cliente->nombre." ".Auth::user()->cliente->apellido.", se le realizó el desembolso  del monto S/. ".$prestamo->monto,
                'asuntoNotificacion' => "Desembolso realizado al cliente ".Auth::user()->cliente->nombre." ".Auth::user()->cliente->apellido,
                'estadoNotificacion' => "PENDIENTE",
                'tipoNotificacion' => "DESEMBOLSO",
                'idUser' => Auth::user()->id,
                'iconNotificacion' => "fa-archive",
            ];
            
        $desembolso = $this->createDesembolsoUseCase->execute($data);
        
        $prestamo = Prestamo::select('prestamo.id AS prestamo_id', 'cliente.nombre', 'cliente.apellido', 'cliente.dni', 'prestamo.created_at', 'cliente.id AS cliente_id')
                            ->join('cotizacion', 'prestamo.cotizacion_id', '=', 'cotizacion.id')
                            ->join('cliente', 'cotizacion.cliente_id', '=', 'cliente.id')
                            ->where('prestamo.estado', 'ACTIVO')
                            ->where('prestamo.sede_id', $idSucursal)
                            ->get();
                                 
        $cantPrestamos = COUNT($prestamo);

        return response()->json(["view"=>view('desembolso.tabDesembolso',compact('prestamo', 'cantPrestamos', ))->render(), "desembolso"=>$desembolso]);
        
    }

    public function desembolsarDeposito(Request $request)
    {
        
        $Proceso = new Proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $desm = Desembolso::max('id');
        $prestamo = Prestamo::find($request->id);
        $cuenta = $request->cuenta;
        $idBanco = $request->banco;
        $descuento = $request->descuento;
        
        $dataBanco = [
            'estadoCaja' => "abierta",
            'idSucursal' => $idSucursal,
            'idTipoCaja' => $idBanco
            ];
        
        $banco = $this->getBancoByIdUseCase->execute($dataBanco);
        
        $banco = $banco[0];
        
        if ($descuento == 0) {
            $concepto = "DESEMBOLSO POR DEPÓSITO, ".$banco->tipocaja_banco." \nCodigo: ".$request->id.". \nSin Descuento.";
        }else{
            $concepto = "DESEMBOLSO POR DEPÓSITO, ".$banco->tipocaja_banco." \nCodigo: ".$request->id.". \nDescuento: ".$descuento.".";
        }
        
        $garantia = $this->getGarantiaByPrestamoUseCase->execute($request->id);

        $nuevoMonto = Proceso::actualizarCaja($banco->caja_monto, $prestamo->monto, 1);
        
        $data = [
                'numeroDesembolso' => $cuenta,
                'estadoDesembolso' => "DESEMBOLSADO",
                'montoPrestamo' => $prestamo->monto + $descuento,
                'idPrestamo' => $request->id,
                'idEmpleado' => $idEmpleado,
                'idSucursal' => $idSucursal,
                'idCaja' => $banco->caja_id,
                'nuevoMontoCaja' => $nuevoMonto - $descuento,
                'estadoMovimiento' => "ACTIVO",
                'conceptoMovimiento' => $concepto,
                'tipoMovimiento' => "EGRESO",
                'importeMovimiento' => $prestamo->monto,
                'codigoOrigenMovimiento' => "N",
                'codigoSerieMovimiento' => $banco->tipocaja_banco."-".$cuenta,
                'idGarantia' => $garantia->id,
                'nombreGarantia' => $garantia->nombre,
                'estadoPrestamo' => "ACTIVO DESEMBOLSADO",
                'mensajeNotificacion' => "El cliente: ".Auth::user()->cliente->nombre." ".Auth::user()->cliente->apellido.", se le realizó el desembolso  del monto S/. ".$prestamo->monto,
                'asuntoNotificacion' => "Desembolso realizado al cliente ".Auth::user()->cliente->nombre." ".Auth::user()->cliente->apellido,
                'estadoNotificacion' => "PENDIENTE",
                'tipoNotificacion' => "DESEMBOLSO",
                'idUser' => Auth::user()->id,
                'iconNotificacion' => "fa-archive",
            ];
            
        $desembolso = $this->createDesembolsoUseCase->execute($data);
        
        $prestamo = Prestamo::select('prestamo.id AS prestamo_id', 'cliente.nombre', 'cliente.apellido', 'cliente.dni', 'prestamo.created_at', 'cliente.id AS cliente_id')
                            ->join('cotizacion', 'prestamo.cotizacion_id', '=', 'cotizacion.id')
                            ->join('cliente', 'cotizacion.cliente_id', '=', 'cliente.id')
                            ->where('prestamo.estado', 'ACTIVO')
                            ->where('prestamo.sede_id', $idSucursal)
                            ->get();
                                 
        $cantPrestamos = COUNT($prestamo);

        return response()->json(["view"=>view('desembolso.tabDesembolso',compact('prestamo', 'cantPrestamos', ))->render(), "desembolso"=>$desembolso]);
    }

    public function printBoucherDesembolso($id)
    {
        
        $desembolso = DB::SELECT('SELECT d.estado, d.monto, d.numero, d.created_at, cl.nombre, cl.apellido, cl.dni, g.nombre AS garantia 
                                   FROM desembolso d, prestamo p, empleado e, cotizacion c, cliente cl, garantia g
                                   WHERE d.prestamo_id = p.id AND d.empleado_id = e.id AND p.cotizacion_id = c.id AND c.cliente_id = cl.id AND c.garantia_id = g.id AND d.id = "'.$id.'"');

        return view('desembolso.printBoucherDesembolso', compact('desembolso'));
    }

    public function buscarDesembolso(Request $request)
    {
        $dato = $request->dato;
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        
        $prestamo = DB::SELECT('SELECT p.id AS prestamo_id, cl.nombre, cl.apellido, cl.dni, p.created_at, cl.id AS cliente_id
                                 FROM prestamo p, cotizacion c, cliente cl
                                 WHERE p.cotizacion_id = c.id AND c.cliente_id = cl.id AND p.estado = "ACTIVO" AND cl.sede_id = "'.$idSucursal.'" AND (cl.nombre LIKE "%'.$dato.'%" OR cl.apellido LIKE "%'.$dato.'%" OR cl.dni LIKE "%'.$dato.'%")');
                                 
        $cantPrestamos = COUNT($prestamo);

        return response()->json(["view"=>view('desembolso.tabDesembolso',compact('prestamo', 'cantPrestamos'))->render()]);

    }
}
