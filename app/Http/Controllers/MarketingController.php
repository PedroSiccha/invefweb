<?php

namespace App\Http\Controllers;

use App\Models\Caja;
use App\Models\Formulario;
use App\Models\Movimiento;
use App\Models\Proceso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MarketingController extends Controller
{
    public function getUltimoDiaMes($elAnio,$elMes) {
        return date("d",(mktime(0,0,0,$elMes+1,1,$elAnio)-1));
    }
     
    public function cliente()
    {
        $user = Auth::user();
        $usuario = DB::SELECT('SELECT e.nombre, e.apellido, e.id, u.name AS area, e.foto AS foto, e.sede_id AS sede
                                FROM empleado e, users u 
                                WHERE e.users_id = u.id AND u.id = "'.$user->id.'"');
        $Proceso = new Proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;

        $clientes = DB::SELECT('SELECT cl.*,  s.id AS semaforo_id, s.rojo AS rojo, s.ambar AS ambar, s.verde AS verde
                                 FROM cliente cl
                                 RIGHT JOIN semaforo s ON cl.id = s.cliente_id
                                 WHERE cl.sede_id = "'.$idSucursal.'" AND cl.id NOT IN (SELECT c.id FROM cliente c
                                    													 INNER JOIN cotizacion co ON c.id = co.cliente_id
                                    													 INNER JOIN prestamo p ON co.id = p.cotizacion_id
                                    													 WHERE p.sede_id = "'.$idSucursal.'" AND p.estado = "ACTIVOS" OR p.estado = "ACTIVO DESEMBOLSADO" OR p.estado = "RENOVADO" OR p.estado = "LIQUIDACION"
                                    													 GROUP BY c.id ORDER BY cl.nombre)');
		
		$contadorRojo = 0;
        $contadorAmbar = 0;
        $contadorVerde = 0;
        
        foreach ($clientes as $cliente) {
            if ($cliente->rojo > $cliente->ambar) {
                $contadorRojo++;
            } elseif ($cliente->ambar > $cliente->verde) {
                $contadorAmbar++;
            } else {
                $contadorVerde++;
            }
        }
        
        $conteo = COUNT($clientes);
                               
        return view('marketing.cliente', compact('usuario', 'clientes', 'conteo', 'contadorRojo', 'contadorAmbar', 'contadorVerde'));
    }

    public function liquidacion()
    {
        $user = Auth::user();
        $usuario = DB::SELECT('SELECT e.nombre, e.apellido, e.id, u.name AS area, e.foto AS foto, e.sede_id AS sede
                                FROM empleado e, users u 
                                WHERE e.users_id = u.id AND u.id = "'.$user->id.'"');
                                
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;

        return view('marketing.liquidacion', compact('usuario'));
    }

    public function presupuesto()
    {
        $user = Auth::user();
        $usuario = DB::SELECT('SELECT e.nombre, e.apellido, e.id, u.name AS area, e.foto AS foto, e.sede_id AS sede
                                FROM empleado e, users u 
                                WHERE e.users_id = u.id AND u.id = "'.$user->id.'"');
                                
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;

        $presMensual = DB::SELECT('SELECT m.monto, DATE_FORMAT(m.created_at, "%b") AS mes 
                                    FROM movimiento m, caja c 
                                    WHERE m.caja_id = c.id AND c.sede_id = "'.$idSucursal.'" AND m.concepto = "publicidad"');

        return view('marketing.presupuesto', compact('usuario', 'presMensual'));
    }

    public function guardarPresupuesto(Request $request)
    {
        $resp = "0";
        $monto = $request->monto;
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $user_id = Auth::user()->id;
        $cajaG = DB::SELECT('SELECT MAX(id) AS id, montofin 
                             FROM caja 
                             WHERE sede_id = "'.$idSucursal.'" AND tipocaja_id = "2"');
                             
        $sede = DB::SELECT('SELECT sede_id 
                             FROM empleado 
                             WHERE sede_id = "'.$idSucursal.'" AND users_id = "'.$user_id.'"');

        $actualizarCaja = $cajaG[0]->montofin - $monto;

        $mov = new Movimiento();
        $mov->codigo = "GA";
        $mov->estado = "ACTIVO";
        $mov->monto = $monto;
        $mov->concepto = "Publicidad";
        $mov->tipo = "EGRESO";
        $mov->empleado = $idEmpleado;
        $mov->importe = $monto;
        $mov->codprestamo = "0";
        $mov->condesembolso = "0";
        $mov->codgarantia = "0";
        $mov->garantia = "PUBLICIDAD";
        $mov->interesPagar = "0.00";
        $mov->moraPagar = "0.00";
        $mov->caja_id = $cajaG[0]->id;
        if ($mov->save()) {
            $caja = Caja::where('id', '=', $cajaG[0]->id)->first();
            $caja->monto = $cajaG[0]->montofin;
            $caja->fecha = date('d-m-Y');
            $caja->inicio = date('H:i:s');
            $caja->fin = date('H:i:s');
            $caja->montofin = $actualizarCaja;
            $caja->empleado = $idEmpleado;
            $caja->sede_id = $idSucursal;

            if ($caja->save()) {
                $resp = "1";
            }

        }
        $presMensual = DB::SELECT('SELECT m.monto, DATE_FORMAT(m.created_at, "%b") AS mes 
                                    FROM movimiento m, caja c 
                                    WHERE m.caja_id = c.id AND c.sede_id = "'.$idSucursal.'" AND m.concepto = "publicidad"');

        return response()->json(["presupuesto"=>view('marketing.tabPresupuesto',compact('presMensual'))->render(), 'resp'=>$resp]);

    }

    public function reportes()
    {
        $user = Auth::user();
        $usuario = DB::SELECT('SELECT e.nombre, e.apellido, e.id, u.name AS area, e.foto AS foto, e.sede_id AS sede
                                FROM empleado e, users u 
                                WHERE e.users_id = u.id AND u.id = "'.$user->id.'"');
                                
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;
        
        $recomendacion = DB::SELECT('SELECT * FROM recomendacion');
        
        $anio = DB::SELECT('SELECT YEAR(created_at) AS anio 
                             FROM cliente
                             WHERE sede_id = "'.$idSucursal.'"
                             GROUP BY YEAR(created_at)');

        return view('marketing.reportes', compact('usuario', 'recomendacion', 'anio'));
    }

    public function graficoMarketing(Request $request)
    {
        
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;

        for($a=1; $a<=12 ;$a++){
            $cliActivo[$a]=0;
            $cliInac[$a] = 0;
            $mes[$a] = 0;
        }
        

        $clientesActivos = DB::SELECT('SELECT COUNT(c.id) AS clientesActivos, MONTH(p.fecinicio) AS mes
                                        FROM cliente c, cotizacion co, prestamo p
                                        WHERE c.id = co.cliente_id AND p.cotizacion_id = co.id AND c.sede_id = "'.$idSucursal.'" AND p.estado = "ACTIVO DESEMBOLSADO"
                                        GROUP BY MONTH(p.fecinicio)');

        foreach ($clientesActivos as $ca) {
            $mes = $ca->mes;
            $cliActivo[$mes] = $ca->clientesActivos;
        }

        $cantClienteActivo = DB::SELECT('SELECT COUNT(c.id) AS cantidad
                                          FROM cliente c, cotizacion co, prestamo p
                                          WHERE c.id = co.cliente_id AND p.cotizacion_id = co.id AND c.sede_id = "'.$idSucursal.'" AND p.estado = "ACTIVO DESEMBOLSADO"');

        $clientesInActivos = DB::SELECT('SELECT COUNT(c.id) AS clientesInActivos, MONTH(p.fecinicio) AS mes
                                        FROM cliente c, cotizacion co, prestamo p
                                        WHERE c.id = co.cliente_id AND p.cotizacion_id = co.id AND c.sede_id = "'.$idSucursal.'" AND p.estado != "ACTIVO DESEMBOLSADO"
                                        GROUP BY MONTH(p.fecinicio)');

        foreach ($clientesInActivos as $cia) {
            $mes = $cia->mes;
            $cliInac[$mes] = $cia->clientesInActivos;
        }

        $cantClienteInActivo = DB::SELECT('SELECT COUNT(c.id) AS cantidad
                                            FROM cliente c, cotizacion co, prestamo p
                                            WHERE c.id = co.cliente_id AND p.cotizacion_id = co.id AND c.sede_id = "'.$idSucursal.'" AND p.estado != "ACTIVO DESEMBOLSADO"');

        $ocupacion = DB::SELECT('SELECT COUNT(c.id) AS cantidad, o.id AS ocupacion  
                                  FROM cliente c, ocupacion o 
                                  WHERE c.ocupacion_id = o.id c.sede_id = "'.$idSucursal.'" 
                                  GROUP BY ocupacion_id');

        $nomOcupacion = DB::SELECT('SELECT nombre, id FROM ocupacion');

        $numOcupa = COUNT($ocupacion);

        foreach ($ocupacion as $o) {
            $ocupa = $o->ocupacion;
            $ocupaCant[$ocupa] = $o->cantidad;
        }

        foreach ($nomOcupacion as $no) {
            $idocupa = $no->id;
            $nombreOcupacion[$idocupa] = $no->nombre;
        }

        $recomendacion = DB::SELECT('SELECT COUNT(c.id) AS cantidad, r.id AS idRecomendacion
                                      FROM cliente c, recomendacion r
                                      WHERE c.recomendacion_id = r.id AND c.sede_id = "'.$idSucursal.'" AND GROUP BY r.id');

        $nomRecomendacion = DB::SELECT('SELECT recomendacion, id FROM recomendacion');

        $numRecomendaciones = COUNT($recomendacion);

        foreach ($recomendacion as $r) {
            $indexRecomendacion = $r->idRecomendacion;
            $asignaRecomendacion[$indexRecomendacion] = $r->cantidad;
        }

        foreach ($nomRecomendacion as $nr) {
            $idrecomendacion = $nr->id;
            $nombreRecomendacion[$idrecomendacion] = $nr->recomendacion;
        }

        $data = array( "cliActivo" =>$cliActivo, "cliInac" => $cliInac, "canCliActivo" => $cantClienteActivo[0]->cantidad, "canCliInActuvi" => $cantClienteInActivo[0]->cantidad, "ocupacion" => $numOcupa, "cantidadOcupa" => $ocupaCant, "nomOcupacion" => $nombreOcupacion, "asignaRecomendacion" => $asignaRecomendacion, "numRecomendaciones" => $numRecomendaciones, "nombreRecomendacion" => $nombreRecomendacion );
        
        return json_encode($data);

    }
    
    public function graficoRecomendaciones(Request $request) {
        
            $Proceso = new proceso();
            $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
            $idEmpleado = $Proceso->obtenerSucursal()->id;
            $users_id = Auth::user()->id;
        
            $recomendacion = DB::SELECT('SELECT COUNT(c.id) AS cantidad, YEAR(c.created_at) AS anio, r.id AS idRecomendacion
                                          FROM cliente c
                                          JOIN recomendacion r ON c.recomendacion_id = r.id
                                          WHERE c.sede_id = "'.$idSucursal.'"
                                          GROUP BY r.id, YEAR(c.created_at)');

            $nomRecomendacion = DB::SELECT('SELECT recomendacion, id FROM recomendacion');
        
            $numRecomendaciones = count($recomendacion);
        
            $asignaRecomendacion = [];
            $nombreRecomendacion = [];
        
            foreach ($recomendacion as $r) {
                $indexRecomendacion = $r->idRecomendacion;
                $indexAnio = $r->anio;
                $asignaRecomendacion[$indexRecomendacion][$indexAnio] = $r->cantidad;
            }
        
            foreach ($nomRecomendacion as $nr) {
                $idrecomendacion = $nr->id;
                $nombreRecomendacion[$idrecomendacion] = $nr->recomendacion;
            }
        
            $data = array(
                "asignaRecomendacion" => $asignaRecomendacion,
                "numRecomendaciones" => $numRecomendaciones,
                "nombreRecomendacion" => $nombreRecomendacion
            );
        
            return json_encode($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function guardarFormulario(Request $request)
    {
        $nombre = $request->nombre;
        $apellido = $request->apellido;
        $celular = $request->celular;
        $correo = $request->correo;

        $f = new Formulario(); 
        $f->nombre = $nombre;
        $f->apellido = $apellido;
        $f->celular = $celular;
        $f->correo = $correo;
        $f->save();       

    }
    
    public function busquedaClientePotencial(Request $request)
    {
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;
        
        $dato = $request->datoCliente;
        $clientes = DB::SELECT('SELECT cl.*, s.id AS semaforo_id, s.rojo AS rojo, s.ambar AS ambar, s.verde AS verde
                                FROM cliente cl
                                LEFT JOIN semaforo s ON cl.id = s.cliente_id
                                WHERE cl.sede_id = "'.$idSucursal.'" AND
                                    cl.id NOT IN (
                                                 SELECT c.id FROM cliente c
                                                 INNER JOIN cotizacion co ON c.id = co.cliente_id
                                                 INNER JOIN prestamo p ON co.id = p.cotizacion_id
                                                 WHERE c.sede_id = "'.$idSucursal.'" AND p.estado = "ACTIVOS" OR p.estado = "ACTIVO DESEMBOLSADO" OR p.estado = "RENOVADO" OR p.estado = "LIQUIDACION" AND (c.nombre LIKE "%'.$dato.'%" OR c.apellido LIKE "%'.$dato.'%" OR c.dni LIKE "%'.$dato.'%")
                                                 GROUP BY c.id
                                                 )
                                    AND (cl.nombre LIKE "%'.$dato.'%" OR cl.apellido LIKE "%'.$dato.'%" OR cl.dni LIKE "%'.$dato.'%")');

        return response()->json(["view"=>view('marketing.listClientesPotenciales',compact('clientes'))->render()]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function busquedaSemaforo(Request $request)
    {
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;
        
        $color = $request->color;
        
        $clientes = DB::SELECT('SELECT cl.*, s.id AS semaforo_id, s.rojo AS rojo, s.ambar AS ambar, s.verde AS verde
                                FROM cliente cl
                                LEFT JOIN semaforo s ON cl.id = s.cliente_id
                                WHERE cl.sede_id = "'.$idSucursal.'" AND cl.id NOT IN (
                                  SELECT c.id FROM cliente c
                                  INNER JOIN cotizacion co ON c.id = co.cliente_id
                                  INNER JOIN prestamo p ON co.id = p.cotizacion_id
                                  WHERE c.sede_id = "'.$idSucursal.'" AND p.estado = "ACTIVOS" OR p.estado = "ACTIVO DESEMBOLSADO" OR p.estado = "RENOVADO" OR p.estado = "LIQUIDACION"
                                  GROUP BY c.id
                                )
                                AND (
                                  SELECT IF(MAX(s.rojo) > MAX(s.ambar), "RED", IF(MAX(s.ambar) > MAX(s.verde), "AMBAR", "VERDE"))
                                  FROM semaforo s
                                  WHERE cl.id = s.cliente_id
                                ) = "'.$color.'"');

        return response()->json(["view"=>view('marketing.listClientesPotenciales',compact('clientes'))->render()]);
    }

    public function reportesCliente()
    {
        $user = Auth::user();
        $usuario = DB::select('SELECT e.nombre, e.apellido, e.id, u.name AS area, e.foto AS foto, e.sede_id AS sede
                                FROM empleado e, users u 
                                WHERE e.users_id = u.id AND u.id = ?', [$user->id]);
                                
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;
    
        $anio = DB::select('SELECT YEAR(created_at) AS anio 
                             FROM cliente 
                             WHERE sede_id = "'.$idSucursal.'"
                             GROUP BY YEAR(created_at)');
    
        $clientes = DB::select('SELECT COUNT(*) AS cant, YEAR(cl.created_at) AS anio  
                                 FROM cliente cl
                                 INNER JOIN cotizacion c ON cl.id = c.cliente_id
                                 INNER JOIN prestamo p ON p.cotizacion_id = c.id
                                 WHERE p.codigo = "n" AND cl.sede_id = "'.$idSucursal.'"
                                 GROUP BY YEAR(cl.created_at)');
    
        $clientesRenovaciones = DB::select('SELECT COUNT(*) AS cant, YEAR(m.created_at) AS anio  
                                             FROM cliente cl
                                             INNER JOIN cotizacion c ON cl.id = c.cliente_id
                                             INNER JOIN prestamo p ON p.cotizacion_id = c.id
                                             INNER JOIN movimiento m ON m.codprestamo = p.id
                                             WHERE m.concepto LIKE "%RENOVACION%" AND cl.sede_id = "'.$idSucursal.'"
                                             GROUP BY YEAR(m.created_at)');
    
        $clientesPresGenerales = DB::select('SELECT COUNT(*) AS cant, YEAR(m.created_at) AS anio  
                                              FROM movimiento m, caja c
                                              WHERE m.caja_id = c.id AND c.sede_id = "'.$idSucursal.'" AND m.tipo = "EGRESO" AND m.codprestamo != 0
                                              GROUP BY YEAR(m.created_at)');
    
        $listClientes = DB::select('SELECT cl.*
                                     FROM cliente cl
                                     INNER JOIN cotizacion c ON cl.id = c.cliente_id
                                     INNER JOIN prestamo p ON p.cotizacion_id = c.id
                                     WHERE cl.sede_id = "'.$idSucursal.'" AND p.codigo = "n"
                                     GROUP BY cl.id');
    
        $listClientesRenovaciones = DB::select('SELECT cl.*
                                                 FROM cliente cl
                                                 INNER JOIN cotizacion c ON cl.id = c.cliente_id
                                                 INNER JOIN prestamo p ON p.cotizacion_id = c.id
                                                 INNER JOIN movimiento m ON m.codprestamo = p.id
                                                 WHERE cl.sede_id = "'.$idSucursal.'" AND m.concepto LIKE "%RENOVACION%"
                                                 GROUP BY YEAR(cl.created_at)');
    
        $listClientesPresGenerales = DB::select('SELECT cl.*
                                                  FROM cliente cl
                                                  INNER JOIN cotizacion c ON cl.id = c.cliente_id
                                                  INNER JOIN prestamo p ON p.cotizacion_id = c.id
                                                  INNER JOIN movimiento m ON m.codprestamo = p.id
                                                  WHERE cl.sede_id = "'.$idSucursal.'" AND m.tipo = "EGRESO" AND m.codprestamo != 0
                                                  GROUP BY cl.id');
    
        $registros = [];
        foreach ($clientes as $cl) {
            $registros[$cl->anio] = $cl->cant;
        }
    
        $registrosRenovaciones = [];
        foreach ($clientesRenovaciones as $clR) {
            $registrosRenovaciones[$clR->anio] = $clR->cant;
        }
    
        $registrosPresGenerales = [];
        foreach ($clientesPresGenerales as $clPg) {
            $registrosPresGenerales[$clPg->anio] = $clPg->cant;
        }
    
        return view('marketing.reporteCliente', compact(
            'usuario', 'anio',
            'registros', 'registrosRenovaciones', 'registrosPresGenerales',
            'listClientes', 'listClientesRenovaciones', 'listClientesPresGenerales'
        ));
    }
    
    public function listaClientesNuevosAnio()
    {
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;
        $fecha_inicial = "2023-01-01";
        $fecha_final = "2023-12-31";
        
        $clientes = DB::SELECT('SELECT cl.*  
                                 FROM cliente cl
                                 LEFT JOIN cotizacion c ON cl.id = c.cliente_id
                                 LEFT JOIN prestamo p ON p.cotizacion_id = c.id
                                 WHERE cl.sede_id = "'.$idSucursal.'" AND (p.codigo = "n") AND cl.created_at BETWEEN "'.$fecha_inicial.'" AND "'.$fecha_final.'"
                                 GROUP BY cl.id');

        return response()->json(["view"=>view('marketing.listClientesNuevoMes',compact('clientes'))->render()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function graficoLineaClienteNuevo(Request $request)
    {
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;
        
        $anio = $request->anio;
        $mes = $request->mes;

        $primer_dia=1;
        $ultimo_dia=$this->getUltimoDiaMes($anio,$mes);
        $fecha_inicial=date("Y-m-d H:i:s", strtotime($anio."-".$mes."-".$primer_dia) );
        $fecha_final=date("Y-m-d H:i:s", strtotime($anio."-".$mes."-".$ultimo_dia) );

        $clientes = DB::SELECT('SELECT cl.*  
                                 FROM cliente cl
                                 JOIN cotizacion c ON cl.id = c.cliente_id
                                 JOIN prestamo p ON p.cotizacion_id = c.id
                                 WHERE cl.sede_id = "'.$idSucursal.'" AND (p.codigo = "n") AND DATE_FORMAT(STR_TO_DATE(cl.created_at, "%Y-%m-%d %H:%i:%s"), "%Y-%m-%d") BETWEEN "'.$fecha_inicial.'" AND "'.$fecha_final.'"');
           
        $cli = count($clientes);

        for($d=1;$d<=$ultimo_dia;$d++){
            $registros[$d]=0;      
        }

        foreach($clientes as $cl){
            $diasel = intval(date("d",strtotime($cl->created_at) ) );
            $registros[$diasel]++;    
        }

        $data = array("totaldias"=>$ultimo_dia, "registrosdia" =>$registros);

        return json_encode($data);
    }
    
    public function graficoLineaRenovacionesDia(Request $request)
    {
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;
        
        $anio = $request->anio;
        $mes = $request->mes;

        $primer_dia=1;
        $ultimo_dia=$this->getUltimoDiaMes($anio,$mes);
        $fecha_inicial=date("Y-m-d H:i:s", strtotime($anio."-".$mes."-".$primer_dia) );
        $fecha_final=date("Y-m-d H:i:s", strtotime($anio."-".$mes."-".$ultimo_dia) );

        $clientes = DB::SELECT('SELECT m.*  
                                 FROM cliente cl
                                 INNER JOIN cotizacion c ON cl.id = c.cliente_id
                                 INNER JOIN prestamo p ON p.cotizacion_id = c.id
                                 INNER JOIN movimiento m ON m.codprestamo = p.id
                                 WHERE cl.sede_id = "'.$idSucursal.'" AND (m.concepto LIKE "%RENOVACION%") AND DATE_FORMAT(STR_TO_DATE(m.created_at, "%Y-%m-%d %H:%i:%s"), "%Y-%m-%d") BETWEEN "'.$fecha_inicial.'" AND "'.$fecha_final.'"');
           
        $cli = count($clientes);

        for($d=1;$d<=$ultimo_dia;$d++){
            $registros[$d]=0;      
        }

        foreach($clientes as $cl){
            $diasel = intval(date("d",strtotime($cl->created_at) ) );
            $registros[$diasel]++;    
        }

        $data = array("totaldias"=>$ultimo_dia, "registrosdia" =>$registros);

        return json_encode($data);
    }
    
    public function graficoLineaPresGenerales(Request $request)
    {
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;
        
        $anio = $request->anio;
        $mes = $request->mes;

        $primer_dia=1;
        $ultimo_dia=$this->getUltimoDiaMes($anio,$mes);
        $fecha_inicial=date("Y-m-d H:i:s", strtotime($anio."-".$mes."-".$primer_dia) );
        $fecha_final=date("Y-m-d H:i:s", strtotime($anio."-".$mes."-".$ultimo_dia) );

        $clientes = DB::SELECT('SELECT m.*  
                                 FROM movimiento m, caja c
                                 WHERE m.caja_id = c.id AND c.sede_id = "'.$idSucursal.'" AND (m.tipo = "EGRESO" AND m.codprestamo != 0) AND DATE_FORMAT(STR_TO_DATE(m.created_at, "%Y-%m-%d %H:%i:%s"), "%Y-%m-%d") BETWEEN "'.$fecha_inicial.'" AND "'.$fecha_final.'"');
           
        $cli = count($clientes);

        for($d=1;$d<=$ultimo_dia;$d++){
            $registros[$d]=0;      
        }

        foreach($clientes as $cl){
            $diasel = intval(date("d",strtotime($cl->created_at) ) );
            $registros[$diasel]++;    
        }

        $data = array("totaldias"=>$ultimo_dia, "registrosdia" =>$registros);

        return json_encode($data);
    }
    
    public function listaClienteNuevoDia(Request $request)
    {
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;
        
        $anio = $request->anio;
        $mes = $request->mes;

        $primer_dia=1;
        $ultimo_dia=$this->getUltimoDiaMes($anio,$mes);
        $fecha_inicial=date("Y-m-d H:i:s", strtotime($anio."-".$mes."-".$primer_dia) );
        $fecha_final=date("Y-m-d H:i:s", strtotime($anio."-".$mes."-".$ultimo_dia) );

        $clientes = DB::SELECT('SELECT cl.*  
                                 FROM cliente cl
                                 LEFT JOIN cotizacion c ON cl.id = c.cliente_id
                                 LEFT JOIN prestamo p ON p.cotizacion_id = c.id
                                 WHERE cl.sede_id = "'.$idSucursal.'" AND (p.codigo = "n") AND DATE_FORMAT(STR_TO_DATE(cl.created_at, "%Y-%m-%d %H:%i:%s"), "%Y-%m-%d") BETWEEN "'.$fecha_inicial.'" AND "'.$fecha_final.'"');
           
        $cli = count($clientes);

        return response()->json(["view"=>view('marketing.listClientesNuevoDia',compact('clientes', 'cli'))->render()]);
    }
    
    public function listaRenovacionesDia(Request $request)
    {
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;
        
        $anio = $request->anio;
        $mes = $request->mes;

        $primer_dia=1;
        $ultimo_dia=$this->getUltimoDiaMes($anio,$mes);
        $fecha_inicial=date("Y-m-d H:i:s", strtotime($anio."-".$mes."-".$primer_dia) );
        $fecha_final=date("Y-m-d H:i:s", strtotime($anio."-".$mes."-".$ultimo_dia) );

        $clientes = DB::SELECT('SELECT cl.*, m.created_at AS fecha  
                                 FROM cliente cl
                                 INNER JOIN cotizacion c ON cl.id = c.cliente_id
                                 INNER JOIN prestamo p ON p.cotizacion_id = c.id
                                 INNER JOIN movimiento m ON m.codprestamo = p.id
                                 WHERE cl.sede_id = "'.$idSucursal.'" AND (m.concepto LIKE "%RENOVACION%") AND DATE_FORMAT(STR_TO_DATE(m.created_at, "%Y-%m-%d %H:%i:%s"), "%Y-%m-%d") BETWEEN "'.$fecha_inicial.'" AND "'.$fecha_final.'"');
           
        $cli = count($clientes);

        return response()->json(["view"=>view('marketing.listRenovaciones',compact('clientes', 'cli'))->render()]);
    }
    
    public function listaPresGeneralesDia(Request $request)
    {
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;
        
        $anio = $request->anio;
        $mes = $request->mes;

        $primer_dia=1;
        $ultimo_dia=$this->getUltimoDiaMes($anio,$mes);
        $fecha_inicial=date("Y-m-d H:i:s", strtotime($anio."-".$mes."-".$primer_dia) );
        $fecha_final=date("Y-m-d H:i:s", strtotime($anio."-".$mes."-".$ultimo_dia) );

        $clientes = DB::SELECT('SELECT cl.*  
                                 FROM cliente cl
                                 LEFT JOIN cotizacion c ON cl.id = c.cliente_id
                                 LEFT JOIN prestamo p ON p.cotizacion_id = c.id
                                 LEFT JOIN movimiento m ON m.codprestamo = p.id
                                 WHERE cl.sede_id = "'.$idSucursal.'" AND (m.tipo = "EGRESO" AND m.codprestamo != 0) AND DATE_FORMAT(STR_TO_DATE(m.created_at, "%Y-%m-%d %H:%i:%s"), "%Y-%m-%d") BETWEEN "'.$fecha_inicial.'" AND "'.$fecha_final.'"');
           
        $cli = count($clientes);

        return response()->json(["view"=>view('marketing.listPresGenerales',compact('clientes', 'cli'))->render()]);
    }

    public function graficoLineaClientesNuevosMes(Request $request)
    {
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;
        
        $anio = $request->anio;
        $fecha_inicial=date("Y-m-d H:i:s", strtotime($anio."-01-01") );
        $fecha_final=date("Y-m-d H:i:s", strtotime($anio."-12-31") );

        $clientes = DB::SELECT('SELECT cl.*
                                 FROM cliente cl
                                 INNER JOIN cotizacion c ON cl.id = c.cliente_id
                                 INNER JOIN prestamo p ON p.cotizacion_id = c.id
                                 WHERE cl.sede_id = "'.$idSucursal.'" AND (p.codigo = "n") AND cl.created_at BETWEEN "'.$fecha_inicial.'" AND "'.$fecha_final.'"');

        $cli = count($clientes);

        for($m=1; $m<=12; $m++){
            $registros[$m]=0;
        }

        foreach($clientes as $cl){
            $messel = intval(date("m",strtotime($cl->created_at) ) );
            $registros[$messel]++;          
  
        }

        $data = array("registrosmes"=>$registros);

        return json_encode($data);
    }
    
    public function graficoLineaRenovacionesMes(Request $request)
    {
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;
        
        $anio = $request->anio;
        $fecha_inicial=date("Y-m-d H:i:s", strtotime($anio."-01-01") );
        $fecha_final=date("Y-m-d H:i:s", strtotime($anio."-12-31") );

        $clientes = DB::SELECT('SELECT m.*
                                 FROM cliente cl
                                 INNER JOIN cotizacion c ON cl.id = c.cliente_id
                                 INNER JOIN prestamo p ON p.cotizacion_id = c.id
                                 INNER JOIN movimiento m ON m.codprestamo = p.id
                                 WHERE cl.sede_id = "'.$idSucursal.'" AND (m.concepto LIKE "%RENOVACION%") AND m.created_at BETWEEN "'.$fecha_inicial.'" AND "'.$fecha_final.'"');

        $cli = count($clientes);

        for($m=1; $m<=12; $m++){
            $registros[$m]=0;
        }

        foreach($clientes as $cl){
            $messel = intval(date("m",strtotime($cl->created_at) ) );
            $registros[$messel]++;          
  
        }

        $data = array("registrosmes"=>$registros);

        return json_encode($data);
    }
    
    public function graficoLineaPresGeneralesMes(Request $request)
    {
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;
        
        $anio = $request->anio;
        $fecha_inicial=date("Y-m-d H:i:s", strtotime($anio."-01-01") );
        $fecha_final=date("Y-m-d H:i:s", strtotime($anio."-12-31") );

        $clientes = DB::SELECT('SELECT m.*
                                 FROM movimiento m, caja c
                                 WHERE m.caja_id = c.id AND c.sede_id = "'.$idSucursal.'" AND (m.tipo = "EGRESO" AND m.codprestamo != 0) AND m.created_at BETWEEN "'.$fecha_inicial.'" AND "'.$fecha_final.'"');

        $cli = count($clientes);

        for($m=1; $m<=12; $m++){
            $registros[$m]=0;
        }

        foreach($clientes as $cl){
            $messel = intval(date("m",strtotime($cl->created_at) ) );
            $registros[$messel]++;          
  
        }

        $data = array("registrosmes"=>$registros);

        return json_encode($data);
    }
    
    public function listaClientesNuevosMes(Request $request)
    {
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;
        
        $anio = $request->anio;
        $fecha_inicial=date("Y-m-d H:i:s", strtotime($anio."-01-01") );
        $fecha_final=date("Y-m-d H:i:s", strtotime($anio."-12-31") );

        $clientes = DB::SELECT('SELECT cl.*
                                 FROM cliente cl
                                 INNER JOIN cotizacion c ON cl.id = c.cliente_id
                                 INNER JOIN prestamo p ON p.cotizacion_id = c.id
                                 WHERE cl.sede_id = "'.$idSucursal.'" AND (p.codigo = "n") AND cl.created_at BETWEEN "'.$fecha_inicial.'" AND "'.$fecha_final.'"');

        $cli = count($clientes);

        return response()->json(["view"=>view('marketing.listClientesNuevoMes',compact('clientes', 'cli'))->render()]);
    }
    
    public function listaRenovacionesMes(Request $request)
    {
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;
        
        $anio = $request->anio;
        $fecha_inicial=date("Y-m-d H:i:s", strtotime($anio."-01-01") );
        $fecha_final=date("Y-m-d H:i:s", strtotime($anio."-12-31") );

        $clientes = DB::SELECT('SELECT cl.*
                                 FROM cliente cl
                                 INNER JOIN cotizacion c ON cl.id = c.cliente_id
                                 INNER JOIN prestamo p ON p.cotizacion_id = c.id
                                 INNER JOIN movimiento m ON m.codprestamo = p.id
                                 WHERE cl.sede_id = "'.$idSucursal.'" AND (m.concepto LIKE "%RENOVACION%") AND m.created_at BETWEEN "'.$fecha_inicial.'" AND "'.$fecha_final.'"');

        $cli = count($clientes);

        return response()->json(["view"=>view('marketing.listRenovacionesMes',compact('clientes', 'cli'))->render()]);
    }
    
    public function listaPresGeneralesMes(Request $request)
    {
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;
        
        $anio = $request->anio;
        $fecha_inicial=date("Y-m-d H:i:s", strtotime($anio."-01-01") );
        $fecha_final=date("Y-m-d H:i:s", strtotime($anio."-12-31") );

        $clientes = DB::SELECT('SELECT cl.*
                                 FROM cliente cl
                                 INNER JOIN cotizacion c ON cl.id = c.cliente_id
                                 INNER JOIN prestamo p ON p.cotizacion_id = c.id
                                 INNER JOIN movimiento m ON m.codprestamo = p.id
                                 WHERE cl.sede_id = "'.$idSucursal.'" AND (m.tipo = "EGRESO" AND m.codprestamo != 0) AND m.created_at BETWEEN "'.$fecha_inicial.'" AND "'.$fecha_final.'"');
                                 

        $cli = count($clientes);

        return response()->json(["view"=>view('marketing.listPresGeneralesMes',compact('clientes', 'cli'))->render()]);
    }
    
    public function reportesRecomendacion()
    {
        $user = Auth::user();
        $usuario = DB::SELECT('SELECT e.nombre, e.apellido, e.id, u.name AS area, e.foto AS foto, e.sede_id AS sede
                                FROM empleado e, users u 
                                WHERE e.users_id = u.id AND u.id = "'.$user->id.'"');
                                
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;
        
        $recomendacion = DB::SELECT('SELECT * FROM recomendacion');
        
        $anio = DB::SELECT('SELECT YEAR(created_at) AS anio 
                             FROM cliente
                             WHERE sede_id = "'.$idSucursal.'"
                             GROUP BY YEAR(created_at)');

        return view('marketing.reporteRecomendacion', compact('usuario', 'recomendacion', 'anio'));
    }
    
    public function mostrarRecomendacion(Request $request)
    {
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;
        
        $idRecomendacion = $request->recomendacion_id;
        $anio = DB::SELECT('SELECT YEAR(created_at) AS anio 
                             FROM cliente 
                             WHERE sede_id = "'.$idSucursal.'"
                             GROUP BY YEAR(created_at)');

        return response()->json(["view"=>view('marketing.mostrarRecomendacion',compact('anio', 'idRecomendacion'))->render()]);
    }
    
    public function graficoLineaRecomendacion(Request $request)
    {
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;
        
        $anio = $request->anio;
        $mes = $request->mes;
        $idRecomendacion = $request->idRecomendacion;

        $primer_dia=1;
        $ultimo_dia=$this->getUltimoDiaMes($anio,$mes);
        $fecha_inicial=date("Y-m-d H:i:s", strtotime($anio."-".$mes."-".$primer_dia) );
        $fecha_final=date("Y-m-d H:i:s", strtotime($anio."-".$mes."-".$ultimo_dia) );

        $recomendaciones = DB::SELECT('SELECT cl.*  
                                        FROM cliente cl
                                        WHERE cl.sede_id = "'.$idSucursal.'" AND (cl.recomendacion_id = "'.$idRecomendacion.'") AND DATE_FORMAT(STR_TO_DATE(cl.created_at, "%Y-%m-%d %H:%i:%s"), "%Y-%m-%d") BETWEEN "'.$fecha_inicial.'" AND "'.$fecha_final.'"');
           
        $cli = count($recomendaciones);

        for($d=1;$d<=$ultimo_dia;$d++){
            $registros[$d]=0;      
        }

        foreach($recomendaciones as $cl){
            $diasel = intval(date("d",strtotime($cl->created_at) ) );
            $registros[$diasel]++;    
        }

        $data = array("totaldias"=>$ultimo_dia, "registrosdia" =>$registros);

        return json_encode($data);
    }
    
    public function graficoLineaRecomendacionMes(Request $request)
    {
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;
        
        $anio = $request->anio;
        $idRecomendacion = $request->idRecomendacion;
        $fecha_inicial=date("Y-m-d H:i:s", strtotime($anio."-01-01") );
        $fecha_final=date("Y-m-d H:i:s", strtotime($anio."-12-31") );

        $recomendaciones = DB::SELECT('SELECT cl.*
                                        FROM cliente cl
                                        WHERE cl.sede_id = "'.$idSucursal.'" AND (cl.recomendacion_id = "'.$idRecomendacion.'") AND cl.created_at BETWEEN "'.$fecha_inicial.'" AND "'.$fecha_final.'"');

        $cli = count($recomendaciones);

        for($m=1; $m<=12; $m++){
            $registros[$m]=0;
        }

        foreach($recomendaciones as $cl){
            $messel = intval(date("m",strtotime($cl->created_at) ) );
            $registros[$messel]++;          
  
        }

        $data = array("registrosmes"=>$registros);

        return json_encode($data);
    }
    
    public function graficoLineaRecomendacionAnual(Request $request)
    {
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;
        
        $idRecomendacion = $request->idRecomendacion;
        
        $registros = [];
        
        $clientes = DB::SELECT('SELECT COUNT(*) AS cant, YEAR(cl.created_at) AS anio  
                                 FROM cliente cl
                                 WHERE cl.sede_id = "'.$idSucursal.'" AND (cl.recomendacion_id = "'.$idRecomendacion.'")
                                 GROUP BY YEAR(cl.created_at)');
                             
        foreach($clientes as $cl){
            $registros[$cl->anio++] = $cl->cant;
        }
        
        $data = array("registros"=>$registros);

        return json_encode($data);
        
    }
    
    public function graficoMarketingRecomendaciones(Request $request)
    {
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;
        
        $recomendacion = DB::SELECT('SELECT COUNT(c.id) AS cantidad, r.recomendacion AS metodoRecomendacion, YEAR(c.created_at) AS anioRecomendacion
                                      FROM cliente c
                                      JOIN recomendacion r ON c.recomendacion_id = r.id
                                      WHERE c.sede_id = "'.$idSucursal.'"
                                      GROUP BY r.recomendacion, YEAR(c.created_at)');
    
        $asignaRecomendacion = [];
        $nombreRecomendacion = [];
        
        $anios = range(min(array_column($recomendacion, 'anioRecomendacion')), max(array_column($recomendacion, 'anioRecomendacion')));
    
        foreach ($recomendacion as $r) {
            $metodoRecomendacion = $r->metodoRecomendacion;
            $anioRecomendacion = $r->anioRecomendacion;
    
            if (!isset($asignaRecomendacion[$metodoRecomendacion])) {
                $asignaRecomendacion[$metodoRecomendacion] = [];
            }
    
            $asignaRecomendacion[$metodoRecomendacion][$anioRecomendacion] = $r->cantidad;
    
            $nombreRecomendacion[$metodoRecomendacion] = $metodoRecomendacion;
        }
        
        foreach ($asignaRecomendacion as &$recomendacion) {
            $recomendacion = array_replace(array_fill_keys($anios, 0), $recomendacion);
        }
        
        $recomendacionAnio = DB::SELECT('SELECT COUNT(c.id) AS cantidad, r.id AS idRecomendacion
                                      FROM cliente c, recomendacion r
                                      WHERE c.sede_id = "'.$idSucursal.'" AND c.recomendacion_id = r.id GROUP BY r.id');

        $nomRecomendacionAnio = DB::SELECT('SELECT recomendacion, id FROM recomendacion');

        $numRecomendacionesAnio = COUNT($recomendacion);

        foreach ($recomendacionAnio as $r) {
            $indexRecomendacionAnio = $r->idRecomendacion;
            $asignaRecomendacionAnio[$indexRecomendacionAnio] = $r->cantidad;
        }

        foreach ($nomRecomendacionAnio as $nr) {
            $idrecomendacionAnio = $nr->id;
            $nombreRecomendacionAnio[$idrecomendacionAnio] = $nr->recomendacion;
        }
    
        $data = [
            "asignaRecomendacion" => $asignaRecomendacion,
            "numRecomendaciones" => count($recomendacion),
            "nombreRecomendacion" => $nombreRecomendacion,
            "asignaRecomendacionAnio" => $asignaRecomendacionAnio,
            "numRecomendacionesAnio" => $numRecomendacionesAnio, 
            "nombreRecomendacionAnio" => $nombreRecomendacionAnio
        ];
        
        return json_encode($data);
    }
    
    public function graficoMarketingRecomendacionesDias(Request $request)
    {
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;
        
        $mes = $request->input('mes'); // Obtener el mes ingresado manualmente
        $anio = $request->input('anio'); // Obtener el año ingresado manualmente
        
        $primer_dia=1;
        $ultimo_dia=$this->getUltimoDiaMes($anio,$mes);
        $fecha_inicial=date("Y-m-d H:i:s", strtotime($anio."-".$mes."-".$primer_dia) );
        $fecha_final=date("Y-m-d H:i:s", strtotime($anio."-".$mes."-".$ultimo_dia) );
    
        $recomendacion = DB::SELECT('SELECT COUNT(c.id) AS cantidad, r.recomendacion AS metodoRecomendacion, YEAR(c.created_at) AS anioRecomendacion, MONTH(c.created_at) AS mesRecomendacion, DAY(c.created_at) AS dayRecomendacion
                                      FROM cliente c
                                      JOIN recomendacion r ON c.recomendacion_id = r.id
                                      WHERE c.sede_id = "'.$idSucursal.'" AND DATE_FORMAT(STR_TO_DATE(c.created_at, "%Y-%m-%d %H:%i:%s"), "%Y-%m-%d") BETWEEN "'.$fecha_inicial.'" AND "'.$fecha_final.'"
                                      GROUP BY r.recomendacion, YEAR(c.created_at), MONTH(c.created_at), DAY(c.created_at)');
    
        $asignaRecomendacion = [];
        $nombreRecomendacion = [];
    
        foreach ($recomendacion as $r) {
            $metodoRecomendacion = $r->metodoRecomendacion;
            $diaRecomendacion = $r->dayRecomendacion;
    
            if (!isset($asignaRecomendacion[$metodoRecomendacion])) {
                $asignaRecomendacion[$metodoRecomendacion] = [];
            }
    
            $asignaRecomendacion[$metodoRecomendacion][$diaRecomendacion] = $r->cantidad;
    
            $nombreRecomendacion[$metodoRecomendacion] = $metodoRecomendacion;
        }
        
        for ($i = 1; $i <= $ultimo_dia; $i++) {
            foreach ($nombreRecomendacion as $metodoRecomendacion) {
                if (!isset($asignaRecomendacion[$metodoRecomendacion][$i])) {
                    $asignaRecomendacion[$metodoRecomendacion][$i] = 0;
                }
            }
        }
    
        $data = [
            "asignaRecomendacion" => $asignaRecomendacion,
            "numRecomendaciones" => count($recomendacion),
            "nombreRecomendacion" => $nombreRecomendacion
        ];
    
        return json_encode($data);
    }
    
    public function graficoMarketingRecomendacionMes(Request $request)
    {
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;
        
        $anio = $request->input('anio'); // Obtener el año ingresado manualmente
    
        $fecha_inicial = date("Y-m-d H:i:s", strtotime($anio . "-01-01"));
        $fecha_final = date("Y-m-d H:i:s", strtotime($anio . "-12-31"));
    
                                        
        $recomendacion = DB::SELECT('SELECT COUNT(c.id) AS cantidad, r.recomendacion AS metodoRecomendacion, YEAR(c.created_at) AS anioRecomendacion, MONTH(c.created_at) AS mesRecomendacion
                                      FROM cliente c
                                      JOIN recomendacion r ON c.recomendacion_id = r.id
                                      WHERE c.sede_id = "'.$idSucursal.'" AND c.created_at BETWEEN "'.$fecha_inicial.'" AND "'.$fecha_final.'"
                                      GROUP BY r.recomendacion, YEAR(c.created_at), MONTH(c.created_at)');
                                      
        $asignaRecomendacion = [];
        $nombreRecomendacion = [];
        
        foreach ($recomendacion as $r) {
            $metodoRecomendacion = $r->metodoRecomendacion;
            $mesRecomendacion = $r->mesRecomendacion;
    
            if (!isset($asignaRecomendacion[$metodoRecomendacion])) {
                $asignaRecomendacion[$metodoRecomendacion] = [];
            }
    
            $asignaRecomendacion[$metodoRecomendacion][$mesRecomendacion] = $r->cantidad;
    
            $nombreRecomendacion[$metodoRecomendacion] = $metodoRecomendacion;
        }
        
        for ($i = 1; $i <= 12; $i++) {
            foreach ($nombreRecomendacion as $metodoRecomendacion) {
                if (!isset($asignaRecomendacion[$metodoRecomendacion][$i])) {
                    $asignaRecomendacion[$metodoRecomendacion][$i] = 0;
                }
            }
        }
        
        $data = [
            "asignaRecomendacion" => $asignaRecomendacion,
            "numRecomendaciones" => count($recomendacion),
            "nombreRecomendacion" => $nombreRecomendacion
        ];
    
        return json_encode($data);
    }
}
