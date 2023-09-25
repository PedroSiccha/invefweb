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
    
    public function __construct(CreateDesembolsoUseCase $createDesembolsoUseCase, GetCajaByTipoUseCase $getCajaByTipoUseCase, GetGarantiaByPrestamoUseCase $getGarantiaByPrestamoUseCase, GetBancoByIdUseCase $getBancoByIdUseCase)
    {
        $this->middleware('auth');
        $this->createDesembolsoUseCase = $createDesembolsoUseCase;
        $this->getCajaByTipoUseCase = $getCajaByTipoUseCase;
        $this->getGarantiaByPrestamoUseCase = $getGarantiaByPrestamoUseCase;
        $this->getBancoByIdUseCase = $getBancoByIdUseCase;
    }
    
    public function desembolso()
    {
        $Proceso = new proceso();
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function desembolsar(Request $request)
    {
        
        $Proceso = new proceso();
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

        $nuevoMonto = proceso::actualizarCaja($caja->monto, $prestamo->monto, 1);

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
        
        $Proceso = new proceso();
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

        $nuevoMonto = proceso::actualizarCaja($banco->caja_monto, $prestamo->monto, 1);
        
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
        
        // $Proceso = new proceso();
        // $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        // $idEmpleado = $Proceso->obtenerSucursal()->id;
        // $users_id = Auth::user()->id;
        
        // $cuenta = $request->cuenta;
        // $banco = $request->banco;
        // $descuento = $request->descuento;

        // if ($banco == "bn") {
        //     $defBanco = "BANCO NACION";
        // }else if ($banco == "i") {
        //     $defBanco = "INTERBANK";
        // }else {
        //     $defBanco = "BCP";
        // }

        // if ($descuento == 0) {
        //     $concepto = "DESEMBOLSO POR DEPÓSITO, ".$defBanco." \nCodigo: ".$request->id.". \nSin Descuento.";
        // }else{
        //     $concepto = "DESEMBOLSO POR DEPÓSITO, ".$defBanco." \nCodigo: ".$request->id.". \nDescuento: ".$descuento.".";
        // }
        

        // $desm = \DB::SELECT('SELECT MAX(id) AS id 
        //                      FROM desembolso
        //                      WHERE sede_id = "'.$idSucursal.'"');
                             
        // $prestamo = \DB::SELECT('SELECT * 
        //                          FROM prestamo 
        //                          WHERE id = "'.$request->id.'"');
                                 
        // $tipocaja = \DB::SELECT('SELECT * 
        //                          FROM tipocaja 
        //                          WHERE codigo = "'.$banco.'"');
                   
        // $caja = \DB::SELECT('SELECT MAX(id) AS id 
        //                      FROM caja 
        //                      WHERE tipocaja_id = "'.$tipocaja[0]->id.'" AND sede_id = "'.$idSucursal.'"');

        // $garantia = \DB::SELECT('SELECT g.* FROM prestamo p
        //                          INNER JOIN cotizacion c ON p.cotizacion_id = c.id
        //                          INNER JOIN garantia g ON c.garantia_id = g.id
        //                          WHERE p.id = "'.$request->id.'"');

        // $maxCaja = \DB::SELECT('SELECT MAX(id) AS id, monto 
        //                         FROM caja 
        //                         WHERE estado = "abierta" AND tipocaja_id = "'.$tipocaja[0]->id.'" AND sede_id = "'.$idSucursal.'" group by id');

        // $nuevoMonto = $maxCaja[0]->monto - $prestamo[0]->monto - $descuento;
    

        // $des = new Desembolso();
        // $des->numero = $cuenta;
        // $des->estado = "DESEMBOLSADO";
        // $des->monto = $prestamo[0]->monto + $descuento;
        // $des->prestamo_id = $request->id;
        // $des->empleado_id = $idEmpleado;
        // $des->sede_id = $idSucursal;
        // if ($des->save()) {
            
        //     $idDesembolso = $des->id;

        //     $pre = Prestamo::where('id', '=', $request->id)->first();
        //     $pre->estado = "ACTIVO DESEMBOLSADO";
        //     if ($pre->save()) {

        //         $mov = new Movimiento();
        //         $mov->estado = "ACTIVO";
        //         $mov->monto = $prestamo[0]->monto + $descuento;
        //         $mov->concepto = $concepto;
        //         $mov->tipo = "EGRESO";
        //         $mov->empleado = $idEmpleado;
        //         $mov->importe = $prestamo[0]->monto;
        //         $mov->codigo = "N";
        //         $mov->serie = $banco."-".$cuenta;
        //         $mov->caja_id = $caja[0]->id;
        //         $mov->codprestamo = $request->id;
        //         $mov->condesembolso = $idDesembolso;
        //         $mov->codgarantia = $garantia[0]->id;
        //         $mov->garantia = $garantia[0]->nombre;

        //         if ($mov->save()) {
                    
        //             $caja = Caja::where('id', '=', $maxCaja[0]->id)->first();
        //             $caja->monto = $nuevoMonto;
        //             $caja->save();

        //             $prestamo = \DB::SELECT('SELECT p.id AS prestamo_id, cl.nombre, cl.apellido, cl.dni, p.created_at  
        //                          FROM prestamo p, cotizacion c, cliente cl
        //                          WHERE p.cotizacion_id = c.id AND c.cliente_id = cl.id AND p.estado = "ACTIVO" AND cl.sede_id = "'.$idSucursal.'"');
                                 
        //             $cantPrestamos = COUNT($prestamo);

        //             // return response()->json(["view"=>view('desembolso.tabDesembolso',compact('prestamo', 'cantPrestamos'))->render()]);
        //             return response()->json(["view"=>view('desembolso.tabDesembolso',compact('prestamo', 'cantPrestamos'))->render(), "desembolso"=>$desembolso]);
        //         }
        //     }
        // }

        return response()->json(["view"=>view('desembolso.tabDesembolso',compact('prestamo', 'cantPrestamos', ))->render(), "desembolso"=>$desembolso]);
    }

    public function printBoucherDesembolso($id)
    {
        
        $desembolso = DB::SELECT('SELECT d.estado, d.monto, d.numero, d.created_at, cl.nombre, cl.apellido, cl.dni, g.nombre AS garantia 
                                   FROM desembolso d, prestamo p, empleado e, cotizacion c, cliente cl, garantia g
                                   WHERE d.prestamo_id = p.id AND d.empleado_id = e.id AND p.cotizacion_id = c.id AND c.cliente_id = cl.id AND c.garantia_id = g.id AND d.id = "'.$id.'"');

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
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        
        $prestamo = DB::SELECT('SELECT p.id AS prestamo_id, cl.nombre, cl.apellido, cl.dni, p.created_at, cl.id AS cliente_id
                                 FROM prestamo p, cotizacion c, cliente cl
                                 WHERE p.cotizacion_id = c.id AND c.cliente_id = cl.id AND p.estado = "ACTIVO" AND cl.sede_id = "'.$idSucursal.'" AND (cl.nombre LIKE "%'.$dato.'%" OR cl.apellido LIKE "%'.$dato.'%" OR cl.dni LIKE "%'.$dato.'%")');
                                 
        $cantPrestamos = COUNT($prestamo);

        return response()->json(["view"=>view('desembolso.tabDesembolso',compact('prestamo', 'cantPrestamos'))->render()]);


    }

}
