<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Inventario;

class FinanzaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function analisisresult()
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

        $utilidades = \DB::SELECT('SELECT SUM(intpago) AS utilidades 
                                   FROM pago 
                                   WHERE MONTH(created_at) = MONTH(now())');

        $mora = \DB::SELECT('SELECT SUM(mora) AS mora 
                                    FROM pago 
                                    WHERE MONTH(created_at) = MONTH(now())');

        $venta = \DB::SELECT('SELECT SUM(importe - monto) AS venta 
                              FROM movimiento 
                              WHERE codigo = "V" AND MONTH(created_at) = MONTH(now())');

        $gastosadministrativos = \DB::SELECT('SELECT SUM(importe) AS gasto 
                                              FROM movimiento 
                                              WHERE codigo = "GA" AND MONTH(created_at) = MONTH(NOW())');

        return view('finanza.analisisresult', compact('usuario', 'utilidades', 'mora', 'venta', 'gastosadministrativos', 'notificacion', 'cantNotificaciones'));
    }

    public function caja()
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

        $anio = \DB::SELECT('SELECT YEAR(fecinicio) AS anio 
                             FROM prestamo 
                             GROUP BY YEAR(fecinicio)');

        return view('finanza.caja', compact('usuario', 'anio', 'notificacion', 'cantNotificaciones'));
    }

    public function graficoLineaFlujoCaja(Request $request)
    {
        $anio = $request->anio;
        $mes = $request->mes;

        $primer_dia=1;
        $ultimo_dia=$this->getUltimoDiaMes($anio,$mes);
        $fecha_inicial=date("Y-m-d H:i:s", strtotime($anio."-".$mes."-".$primer_dia) );
        $fecha_final=date("Y-m-d H:i:s", strtotime($anio."-".$mes."-".$ultimo_dia) );

        $egreso = \DB::SELECT('SELECT SUM(importe) AS monto, DATE(created_at) AS fecinicio
                                FROM movimiento
                                WHERE tipo = "EGRESO" AND (created_at BETWEEN "'.$fecha_inicial.'" AND "'.$fecha_final.'")
                                GROUP BY DATE(created_at)');

        $ingreso = \DB::SELECT('SELECT SUM(importe) AS monto, DATE(created_at) AS fecinicio
                               FROM movimiento
                               WHERE tipo = "INGRESO" AND (created_at BETWEEN "'.$fecha_inicial.'" AND "'.$fecha_final.'")
                               GROUP BY DATE(created_at)');

        $pt = count($egreso);

        $pt = count($ingreso);

        for($d=1;$d<=$ultimo_dia;$d++){
            $registros[$d]=0;
            $registroEgreso[$d]=0;
            $registroIngreso[$d]=0;
        }

        foreach($egreso as $e){
            $diasel = intval(date("d",strtotime($e->fecinicio) ) );
            $registroEgreso[$diasel++] = $e->monto;
        }

        foreach($ingreso as $i){
            $diasel = intval(date("d",strtotime($i->fecinicio) ) );
            $registroIngreso[$diasel++] = $i->monto;
        }

        $data = array("totaldias"=>$ultimo_dia, "registroEgreso"=>$registroEgreso, "registroIngreso" => $registroIngreso);

        return json_encode($data);
    }

    public function graficoLineaFlujoCajaMes(Request $request)
    {
        $anio = $request->anio;

        $primer_dia=1;

        $fecha_inicial=date("Y-m-d H:i:s", strtotime($anio."-01-01") );
        $fecha_final=date("Y-m-d H:i:s", strtotime($anio."-12-31") );

        $egreso = \DB::SELECT('SELECT SUM(importe) AS monto, MONTH(created_at) AS fecinicio
                                FROM movimiento
                                WHERE tipo = "EGRESO" AND (created_at BETWEEN "'.$fecha_inicial.'" AND "'.$fecha_final.'")
                                GROUP BY MONTH(created_at)');

                                

        $ingreso = \DB::SELECT('SELECT SUM(importe) AS monto, MONTH(created_at) AS fecinicio
                               FROM movimiento
                               WHERE tipo = "INGRESO" AND (created_at BETWEEN "'.$fecha_inicial.'" AND "'.$fecha_final.'")
                               GROUP BY MONTH(created_at)');

                               

        $pt = count($egreso);

        $pt2 = count($ingreso);

        for($m=1; $m<=12; $m++){
            $registros[$m]=0;
            $registroEgreso[$m]=0;
            $registroIngreso[$m]=0;
        }

        foreach($egreso as $e){
            $diasel = intval(date("m",strtotime($e->fecinicio) ) );
            $registroEgreso[$diasel++] = $e->monto;
        }

        foreach($ingreso as $i){
            $diasel = intval(date("m",strtotime($i->fecinicio) ) );
            $registroIngreso[$diasel++] = $i->monto;
        }

        $data = array("registrosmes"=>"12", "registroEgreso"=>$registroEgreso, "registroIngreso" => $registroIngreso);

        return json_encode($data);
    }

    public function estprestamo()
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

        $anio = \DB::SELECT('SELECT YEAR(fecinicio) AS anio 
                             FROM prestamo 
                             GROUP BY YEAR(fecinicio)');

        $estado = \DB::SELECT('SELECT estado 
                               FROM prestamo 
                               GROUP BY estado');                     

        return view('finanza.estprestamo', compact('usuario', 'anio', 'estado', 'notificacion', 'cantNotificaciones'));
    }

    public function gastos()
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

        $cajaChica = \DB::SELECT('SELECT * 
                                  FROM movimiento 
                                  WHERE codigo <> "GA" AND MONTH(NOW()) = MONTH(created_at)');

        $cajaGrande = \DB::SELECT('SELECT m.*, d.url AS documento 
                                   FROM movimiento m, movimiento_documento md, documento d 
                                   WHERE md.movimiento_id = m.id AND md.documento_id = d.id AND codigo = "GA" AND MONTH(NOW()) = MONTH(m.created_at)');

        return view('finanza.gastos', compact('usuario', 'cajaChica', 'cajaGrande', 'notificacion', 'cantNotificaciones'));
    }

    public function patrimonio()
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

        $prestamoColocado = \DB::SELECT('SELECT SUM(monto) AS monto
                                         FROM prestamo 
                                         WHERE estado = "ACTIVO DESEMBOLSADO"');

        if ($prestamoColocado == null) {
            $prestamoColocado = \DB::SELECT('SELECT "0.00" AS monto');
        }

        $liquidacion = \DB::SELECT('SELECT SUM(monto) AS monto
                                    FROM prestamo
                                    WHERE estado = "LIQUIDACION"');

        if ($liquidacion == null) {
            $liquidacion = \DB::SELECT('SELECT "0.00" AS monto');
        }

        $tipocaja = \DB::SELECT('SELECT * FROM tipocaja');

        $cajaChica = \DB::SELECT('SELECT monto 
                                  FROM caja 
                                  WHERE id = (SELECT MAX(id) FROM caja WHERE tipocaja_id = "'.$tipocaja[0]->id.'") AND tipocaja_id = "'.$tipocaja[0]->id.'"');

        if ($cajaChica == null) {
            $cajaChica = \DB::SELECT('SELECT "0.00" AS monto');
        }

        

        $cajaGrande = \DB::SELECT('SELECT monto AS monto 
                                    FROM caja 
                                    WHERE tipocaja_id = "'.$tipocaja[1]->id.'"');

        if ($cajaGrande == null) {
            $cajaGrande = \DB::SELECT('SELECT "0.00" AS monto');
        }

        $cajaBanco = \DB::SELECT('SELECT monto 
                                  FROM caja 
                                  WHERE tipocaja_id = "'.$tipocaja[2]->id.'"');

        if ($cajaBanco == null) {
            $cajaBanco = \DB::SELECT('SELECT "0.00" AS monto');
        }

        $equipo = \DB::SELECT('SELECT * FROM inventario 
                               WHERE tipoinventario_id = "1" AND estado = "ACTIVO"');

        $software = \DB::SELECT('SELECT * FROM inventario 
                                 WHERE tipoinventario_id = "2" AND marca = "SOFTWARE"');

        if ($software == null) {
            $software = \DB::SELECT('SELECT "0" AS idinventario, "0" AS unidad, "Sin Detallar" AS nombre, "0.00" AS valor, "Sin Detallar" AS marca, "ACTIVO" AS estado, "0" AS tipoinventario_id');
        }

        $tipoinventario = \DB::SELECT('SELECT * FROM tipoinventario');

        $totalInventario = \DB::SELECT('SELECT ROUND(SUM(unidad*valor),2) AS total 
                                            FROM inventario 
                                            WHERE tipoinventario_id = "1" AND estado = "ACTIVO"');

        if ($totalInventario == null) {
            $totalInventario = \DB::SELECT('SELECT "0.00" AS total');
        }

        $pagoPersonal = \DB::SELECT('SELECT SUM(monto) AS monto
                                     FROM movimiento 
                                     WHERE codigo = "GA" AND concepto = "Pago Personal" AND MONTH(created_at) = MONTH(NOW())');

        if ($pagoPersonal == null) {
            $pagoPersonal = \DB::SELECT('SELECT "0.00" AS monto');
        }

        $pagoAlquiler = \DB::SELECT('SELECT SUM(monto) AS monto
                                    FROM movimiento 
                                    WHERE codigo = "GA" AND concepto = "Pago Alquiler" AND MONTH(created_at) = MONTH(NOW())');

        if ($pagoAlquiler == null) {
            $pagoAlquiler = \DB::SELECT('SELECT "0.00" AS monto');
        }

        $pagoInternet = \DB::SELECT('SELECT SUM(monto) AS monto
                                     FROM movimiento 
                                     WHERE codigo = "GA" AND concepto = "Pago Internet" AND MONTH(created_at) = MONTH(NOW())');

        if ($pagoInternet == null) {
            $pagoInternet = \DB::SELECT('SELECT "0.00" AS monto');
        }

        $utilesEscritorio = \DB::SELECT('SELECT SUM(monto) AS monto
                                         FROM movimiento 
                                         WHERE codigo = "GA" AND concepto = "Utiles Escritorio" AND MONTH(created_at) = MONTH(NOW())');

        if ($utilesEscritorio == null) {
            $utilesEscritorio = \DB::SELECT('SELECT "0.00" AS monto');
        }

        $publicidad = \DB::SELECT('SELECT ROUND(SUM(monto),2) AS monto 
                                   FROM movimiento 
                                   WHERE codigo = "GA" AND concepto = "Publicidad" AND MONTH(created_at) = MONTH(NOW())');

        if ($publicidad == null) {
            $publicidad = \DB::SELECT('SELECT "0.00" AS monto');
        }

        $tarjetaBCP = \DB::SELECT('SELECT SUM(monto) AS monto
                                   FROM movimiento 
                                   WHERE codigo = "GA" AND concepto = "Tarjeta BCP" AND MONTH(created_at) = MONTH(NOW())');

        if ($tarjetaBCP == null) {
            $tarjetaBCP = \DB::SELECT('SELECT "0.00" AS monto');
        }

        $luz = \DB::SELECT('SELECT SUM(monto) AS monto
                            FROM movimiento 
                            WHERE codigo = "GA" AND concepto = "Luz" AND MONTH(created_at) = MONTH(NOW())');

        if ($luz == null) {
            $luz = \DB::SELECT('SELECT "0.00" AS monto');
        }

        $impuesto = \DB::SELECT('SELECT SUM(monto) AS monto
                                 FROM movimiento 
                                 WHERE codigo = "GA" AND concepto = "Impuesto" AND MONTH(created_at) = MONTH(NOW())');

        if ($impuesto == null) {
            $impuesto = \DB::SELECT('SELECT "0.00" AS monto');
        }

        return view('finanza.patrimonio', compact('usuario', 'prestamoColocado', 'liquidacion', 'cajaChica', 'equipo', 'software', 'tipoinventario', 'totalInventario', 'cajaGrande', 'cajaBanco', 'pagoPersonal', 'pagoAlquiler', 'pagoInternet', 'utilesEscritorio', 'publicidad', 'tarjetaBCP', 'luz', 'impuesto', 'notificacion', 'cantNotificaciones'));
    }

    public function getUltimoDiaMes($elAnio,$elMes) {
        return date("d",(mktime(0,0,0,$elMes+1,1,$elAnio)-1));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function graficoLineaPrestamo(Request $request)
    {
        $anio = $request->anio;
        $mes = $request->mes;

        $primer_dia=1;
        $ultimo_dia=$this->getUltimoDiaMes($anio,$mes);
        $fecha_inicial=date("Y-m-d H:i:s", strtotime($anio."-".$mes."-".$primer_dia) );
        $fecha_final=date("Y-m-d H:i:s", strtotime($anio."-".$mes."-".$ultimo_dia) );

        $prestamos = \DB::SELECT('SELECT * FROM prestamo WHERE fecinicio BETWEEN "'.$fecha_inicial.'" AND "'.$fecha_final.'"');
           
        $pt = count($prestamos);

        for($d=1;$d<=$ultimo_dia;$d++){
            $registros[$d]=0;      
        }

        foreach($prestamos as $pts){
            $diasel = intval(date("d",strtotime($pts->fecinicio) ) );
            $registros[$diasel]++;    
        }

        $data = array("totaldias"=>$ultimo_dia, "registrosdia" =>$registros);

        //return response()->json([$data]);
        return json_encode($data);
    }

    public function graficoLineaBienesDia(Request $request)
    {

        $anio = $request->anio;
        $mes = $request->mes;

        $primer_dia=1;
        $ultimo_dia=$this->getUltimoDiaMes($anio,$mes);
        $fecha_inicial=date("Y-m-d H:i:s", strtotime($anio."-".$mes."-".$primer_dia) );
        $fecha_final=date("Y-m-d H:i:s", strtotime($anio."-".$mes."-".$ultimo_dia) );

        $prestamos = \DB::SELECT('SELECT * FROM prestamo WHERE fecinicio BETWEEN "'.$fecha_inicial.'" AND "'.$fecha_final.'"');

        $pt = count($prestamos);

        for($d=1;$d<=$ultimo_dia;$d++){
            $registros[$d]=0;      
        }

        foreach($prestamos as $pts){
            $diasel = intval(date("d",strtotime($pts->fecinicio) ) );
            $registros[$diasel]++;    
        }

        $data = array("totaldias"=>$ultimo_dia, "registrosdia" =>$registros);

        return json_encode($data);

        //dd($fecha_inicial. " ".$fecha_final);

    }

    public function graficoLineaLiquidacionDia(Request $request)
    {

        $anio = $request->anio;
        $mes = $request->mes;

        $primer_dia=1;
        $ultimo_dia=$this->getUltimoDiaMes($anio,$mes);
        $fecha_inicial=date("Y-m-d H:i:s", strtotime($anio."-".$mes."-".$primer_dia) );
        $fecha_final=date("Y-m-d H:i:s", strtotime($anio."-".$mes."-".$ultimo_dia) );

        $liquidacion = \DB::SELECT('SELECT * FROM prestamo WHERE estado = "LIQUIDACION" AND fecinicio BETWEEN "'.$fecha_inicial.'" AND "'.$fecha_final.'"');

        $pt = count($liquidacion);

        for($d=1;$d<=$ultimo_dia;$d++){
            $registros[$d]=0;      
        }

        foreach($liquidacion as $lq){
            $diasel = intval(date("d",strtotime($lq->fecinicio) ) );
            $registros[$diasel]++;    
        }

        $data = array("totaldias"=>$ultimo_dia, "registrosdia" =>$registros);

        return json_encode($data);

        //dd($fecha_inicial. " ".$fecha_final);
        
    }

    public function graficoLineaVendidoDia(Request $request)
    {

        $anio = $request->anio;
        $mes = $request->mes;

        $primer_dia=1;
        $ultimo_dia=$this->getUltimoDiaMes($anio,$mes);
        $fecha_inicial=date("Y-m-d H:i:s", strtotime($anio."-".$mes."-".$primer_dia) );
        $fecha_final=date("Y-m-d H:i:s", strtotime($anio."-".$mes."-".$ultimo_dia) );

        $vendido = \DB::SELECT('SELECT * FROM prestamo WHERE estado = "VENDIDO" AND fecinicio BETWEEN "'.$fecha_inicial.'" AND "'.$fecha_final.'"');

        $pt = count($vendido);

        for($d=1;$d<=$ultimo_dia;$d++){
            $registros[$d]=0;      
        }

        foreach($vendido as $v){
            $diasel = intval(date("d",strtotime($v->fecinicio) ) );
            $registros[$diasel]++;    
        }

        $data = array("totaldias"=>$ultimo_dia, "registrosdia" =>$registros);

        return json_encode($data);
        
    }

    public function graficoLineaClienteDia(Request $request)
    {

        $anio = $request->anio;
        $mes = $request->mes;

        $primer_dia=1;
        $ultimo_dia=$this->getUltimoDiaMes($anio,$mes);
        $fecha_inicial=date("Y-m-d H:i:s", strtotime($anio."-".$mes."-".$primer_dia) );
        $fecha_final=date("Y-m-d H:i:s", strtotime($anio."-".$mes."-".$ultimo_dia) );

        $cliente = \DB::SELECT('SELECT * FROM cliente WHERE created_at BETWEEN "'.$fecha_inicial.'" AND "'.$fecha_final.'"');

        $pt = count($cliente);

        for($d=1;$d<=$ultimo_dia;$d++){
            $registros[$d]=0;      
        }

        foreach($cliente as $cl){
            $diasel = intval(date("d",strtotime($cl->created_at) ) );
            $registros[$diasel]++;    
        }

        $data = array("totaldias"=>$ultimo_dia, "registrosdia" =>$registros);

        return json_encode($data);
        
    }

    public function graficoLineaEfectivoDia(Request $request)
    {

        $anio = $request->anio;
        $mes = $request->mes;

        $primer_dia=1;
        $ultimo_dia=$this->getUltimoDiaMes($anio,$mes);
        $fecha_inicial=date("Y-m-d H:i:s", strtotime($anio."-".$mes."-".$primer_dia) );
        $fecha_final=date("Y-m-d H:i:s", strtotime($anio."-".$mes."-".$ultimo_dia) );

        $efectivo = \DB::SELECT('SELECT sum(monto) AS monto, fecinicio 
                                 FROM prestamo 
                                 WHERE fecinicio BETWEEN "'.$fecha_inicial.'" AND "'.$fecha_final.'" 
                                 GROUP BY fecinicio');

        $pt = count($efectivo);

        for($d=1;$d<=$ultimo_dia;$d++){
            $registros[$d]=0;
            $monto[$d]=0;      
        }

        foreach($efectivo as $ef){
            $diasel = intval(date("d",strtotime($ef->fecinicio) ) );
            $registros[$diasel]++;
            $monto[$diasel++] = $ef->monto;
  
        }

        $data = array("totaldias"=>$ultimo_dia, "registrosdia"=>$registros, "monto" => $monto);

        return json_encode($data);
        
    }

    public function graficoLineaInteresDia(Request $request)
    {

        $anio = $request->anio;
        $mes = $request->mes;

        $primer_dia=1;
        $ultimo_dia=$this->getUltimoDiaMes($anio,$mes);
        $fecha_inicial=date("Y-m-d H:i:s", strtotime($anio."-".$mes."-".$primer_dia) );
        $fecha_final=date("Y-m-d H:i:s", strtotime($anio."-".$mes."-".$ultimo_dia) );

        $interes = \DB::SELECT('SELECT SUM(intpago) AS interes, DATE(created_at) AS created_at
                                FROM pago
                                WHERE created_at BETWEEN "'.$fecha_inicial.'" AND "'.$fecha_final.'"
                                GROUP BY DATE(created_at)');

        $pt = count($interes);

        for($d=1;$d<=$ultimo_dia;$d++){
            $registros[$d]=0;
            $totalInteres[$d]=0;      
        }

        foreach($interes as $it){
            $diasel = intval(date("d",strtotime($it->created_at) ) );
            $registros[$diasel]++;
            $totalInteres[$diasel++] = $it->interes;
  
        }

        $data = array("totaldias"=>$ultimo_dia, "registrosdia"=>$registros, "interes" => $totalInteres);

        return json_encode($data);
        
    }

    public function graficoLineaMoraDia(Request $request)
    {

        $anio = $request->anio;
        $mes = $request->mes;

        $primer_dia=1;
        $ultimo_dia=$this->getUltimoDiaMes($anio,$mes);
        $fecha_inicial=date("Y-m-d H:i:s", strtotime($anio."-".$mes."-".$primer_dia) );
        $fecha_final=date("Y-m-d H:i:s", strtotime($anio."-".$mes."-".$ultimo_dia) );

        $mora = \DB::SELECT('SELECT SUM(mora) AS mora, DATE(created_at) AS created_at
                                FROM pago
                                WHERE created_at BETWEEN "'.$fecha_inicial.'" AND "'.$fecha_final.'"
                                GROUP BY DATE(created_at)');

        $pt = count($mora);

        for($d=1;$d<=$ultimo_dia;$d++){
            $registros[$d]=0;
            $totalMoras[$d]=0;      
        }

        foreach($mora as $mo){
            $diasel = intval(date("d",strtotime($mo->created_at) ) );
            $registros[$diasel]++;
            $totalMoras[$diasel++] = $mo->mora;
  
        }

        $data = array("totaldias"=>$ultimo_dia, "registrosdia"=>$registros, "mora" => $totalMoras);

        return json_encode($data);
        
    }

    public function graficoLineaVentaDia(Request $request)
    {

        $anio = $request->anio;
        $mes = $request->mes;

        $primer_dia=1;
        $ultimo_dia=$this->getUltimoDiaMes($anio,$mes);
        $fecha_inicial=date("Y-m-d H:i:s", strtotime($anio."-".$mes."-".$primer_dia) );
        $fecha_final=date("Y-m-d H:i:s", strtotime($anio."-".$mes."-".$ultimo_dia) );

        $venta = \DB::SELECT('SELECT SUM(importe - interesPagar - moraPagar - monto) AS venta, date(created_at) AS fecVenta
                             FROM movimiento 
                             WHERE codigo = "V" AND created_at BETWEEN "'.$fecha_inicial.'" AND "'.$fecha_final.'"
                             GROUP BY DATE(created_at)');

        $pt = count($venta);

        for($d=1;$d<=$ultimo_dia;$d++){
            $registros[$d]=0;
            $gananciaVenta[$d]=0;      
        }

        foreach($venta as $ve){
            $diasel = intval(date("d",strtotime($ve->fecVenta) ) );
            $registros[$diasel]++;
            $gananciaVenta[$diasel++] = $ve->venta;
  
        }

        $data = array("totaldias"=>$ultimo_dia, "registrosdia"=>$registros, "venta" => $gananciaVenta);

        return json_encode($data);
        
    }

    public function graficoLineaAdministrativoDia(Request $request)
    {

        $anio = $request->anio;
        $mes = $request->mes;

        $primer_dia=1;
        $ultimo_dia=$this->getUltimoDiaMes($anio,$mes);
        $fecha_inicial=date("Y-m-d H:i:s", strtotime($anio."-".$mes."-".$primer_dia) );
        $fecha_final=date("Y-m-d H:i:s", strtotime($anio."-".$mes."-".$ultimo_dia) );

        $gastoAdmin = \DB::SELECT('SELECT SUM(monto) AS gasto, DATE(created_at) AS created_at 
                              FROM movimiento 
                              WHERE codigo = "GA" AND (created_at BETWEEN "'.$fecha_inicial.'" AND "'.$fecha_final.'")
                              GROUP BY MONTH(created_at)');

        $pt = count($gastoAdmin);

        for($d=1;$d<=$ultimo_dia;$d++){
            $registros[$d]=0;
            $gastoAdministrativo[$d]=0;      
        }

        foreach($gastoAdmin as $ga){
            $diasel = intval(date("d",strtotime($ga->created_at) ) );
            $registros[$diasel]++;
            $gastoAdministrativo[$diasel++] = $ga->gasto;
  
        }

        $data = array("totaldias"=>$ultimo_dia, "registrosdia"=>$registros, "administrativo" => $gastoAdministrativo);

        return json_encode($data);
        
    }

    public function graficoLineaPrestamoActivoDia(Request $request)
    {

        $anio = $request->anio;
        $mes = $request->mes;

        $primer_dia=1;
        $ultimo_dia=$this->getUltimoDiaMes($anio,$mes);
        $fecha_inicial=date("Y-m-d H:i:s", strtotime($anio."-".$mes."-".$primer_dia) );
        $fecha_final=date("Y-m-d H:i:s", strtotime($anio."-".$mes."-".$ultimo_dia) );

        $prestamo = \DB::SELECT('SELECT * 
                                 FROM prestamo 
                                 WHERE codigo = "N" AND estado = "ACTIVO DESEMBOLSADO" AND (fecinicio BETWEEN "'.$fecha_inicial.'" AND "'.$fecha_final.'")');

        $renovacion = \DB::SELECT('SELECT * 
                                   FROM prestamo 
                                   WHERE codigo = "R" AND estado = "ACTIVO DESEMBOLSADO" AND (fecinicio BETWEEN "'.$fecha_inicial.'" AND "'.$fecha_final.'")');

        $pt = count($prestamo);

        $pt2 = count($renovacion);

        for($d=1;$d<=$ultimo_dia;$d++){
            $registros[$d]=0;
            $registrosPrestamo[$d]=0;      
            $registrosRenovacion[$d]=0;      
        }

        foreach($prestamo as $p){
            $diasel = intval(date("d",strtotime($p->fecinicio) ) );
            $registrosPrestamo[$diasel]++;
        }

        foreach($renovacion as $r){
            $diasel = intval(date("d",strtotime($r->fecinicio) ) );
            $registrosRenovacion[$diasel]++;
            //$gastoAdministrativo[$diasel++] = $ga->gasto;
  
        }

        $data = array("totaldias"=>$ultimo_dia, "registrosPrestamo"=>$registrosPrestamo, "registrosRenovacion" => $registrosRenovacion);

        return json_encode($data);

    }

    public function graficoLineaPrestamoMes(Request $request)
    {
        $anio = $request->anio;
        $fecha_inicial=date("Y-m-d H:i:s", strtotime($anio."-01-01") );
        $fecha_final=date("Y-m-d H:i:s", strtotime($anio."-12-31") );

        $prestamos = \DB::SELECT('SELECT * FROM prestamo WHERE fecinicio BETWEEN "'.$fecha_inicial.'" AND "'.$fecha_final.'"');

        $pt = count($prestamos);

        for($m=1; $m<=12; $m++){
            $registros[$m]=0;
        }

        foreach($prestamos as $pr){
            $messel = intval(date("m",strtotime($pr->fecinicio) ) );
            $registros[$messel]++;          
  
        }

        $data = array("registrosmes"=>$registros);

        return json_encode($data);
    }

    public function graficoLineaBienesMes(Request $request)
    {
        $anio = $request->anio;

        $fecha_inicial=date("Y-m-d H:i:s", strtotime($anio."-01-01") );
        $fecha_final=date("Y-m-d H:i:s", strtotime($anio."-12-31") );

        $prestamos = \DB::SELECT('SELECT * FROM prestamo WHERE fecinicio BETWEEN "'.$fecha_inicial.'" AND "'.$fecha_final.'"');

        $pt = count($prestamos);

        for($m=1; $m<=12; $m++){
            $registros[$m]=0;
        }

        foreach($prestamos as $pr){
            $messel = intval(date("m",strtotime($pr->fecinicio) ) );
            $registros[$messel]++;          
  
        }

        $data = array("registrosmes"=>$registros);

        return json_encode($data);
    }

    public function graficoLineaLiquidacionMes(Request $request)
    {
        $anio = $request->anio;

        $fecha_inicial=date("Y-m-d H:i:s", strtotime($anio."-01-01") );
        $fecha_final=date("Y-m-d H:i:s", strtotime($anio."-12-31") );

        $liquidacion = \DB::SELECT('SELECT * FROM prestamo WHERE estado = "LIQUIDACION" AND fecinicio BETWEEN "'.$fecha_inicial.'" AND "'.$fecha_final.'"');

        $pt = count($liquidacion);

        for($m=1; $m<=12; $m++){
            $registros[$m]=0;      
        }

        foreach($liquidacion as $lq){
            $messel = intval(date("m",strtotime($lq->fecinicio) ) );
            $registros[$messel]++;    
        }

        $data = array("registrosmes" =>$registros);

        return json_encode($data);
    }

    public function graficoLineaVendidoMes(Request $request)
    {
        $anio = $request->anio;
        $fecha_inicial=date("Y-m-d H:i:s", strtotime($anio."-01-01") );
        $fecha_final=date("Y-m-d H:i:s", strtotime($anio."-12-31") );

        $vendido = \DB::SELECT('SELECT * FROM prestamo WHERE estado = "VENDIDO" AND fecinicio BETWEEN "'.$fecha_inicial.'" AND "'.$fecha_final.'"');

        $pt = count($vendido);

        for($m=1; $m<=12; $m++){
            $registros[$m]=0;      
        }

        foreach($vendido as $v){
            $messel = intval(date("m",strtotime($v->fecinicio) ) );
            $registros[$messel]++;    
        }

        $data = array("registrosmes" =>$registros);

        return json_encode($data);
    }

    public function graficoLineaClienteMes(Request $request)
    {
        $anio = $request->anio;

        $primer_dia=1;

        $fecha_inicial=date("Y-m-d H:i:s", strtotime($anio."-01-01") );
        $fecha_final=date("Y-m-d H:i:s", strtotime($anio."-12-31") );

        $cliente = \DB::SELECT('SELECT * FROM cliente WHERE created_at BETWEEN "'.$fecha_inicial.'" AND "'.$fecha_final.'"');

        $pt = count($cliente);

        for($m=1 ;$m<=12 ;$m++){
            $registros[$m]=0;      
        }

        foreach($cliente as $cl){
            $messel = intval(date("m",strtotime($cl->created_at) ) );
            $registros[$messel]++;    
        }

        $data = array("registrosmes" =>$registros);

        return json_encode($data);
    }

    public function graficoLineaEfectivoMes(Request $request)
    {
        $anio = $request->anio;
        $fecha_inicial=date("Y-m-d H:i:s", strtotime($anio."-01-01") );
        $fecha_final=date("Y-m-d H:i:s", strtotime($anio."-12-31") );

        $efectivo = \DB::SELECT('SELECT sum(monto) AS monto, fecinicio 
                                 FROM prestamo 
                                 WHERE fecinicio BETWEEN "'.$fecha_inicial.'" AND "'.$fecha_final.'" 
                                 GROUP BY MONTH(fecinicio)');

        $pt = count($efectivo);

        for($m=1; $m<=12 ;$m++){
            $registros[$m]=0;
            $monto[$m]=0;      
        }

        foreach($efectivo as $ef){
            $messel = intval(date("m",strtotime($ef->fecinicio) ) );
            $registros[$messel]++;
            $monto[$messel++] = $ef->monto;
  
        }

        

        $data = array("registrosmes"=>$registros, "monto" => $monto);

        return json_encode($data);
    }

    public function graficoLineaInteresMes(Request $request)
    {
        $anio = $request->anio;
        $fecha_inicial=date("Y-m-d H:i:s", strtotime($anio."-01-01") );
        $fecha_final=date("Y-m-d H:i:s", strtotime($anio."-12-31") );

        $interes = \DB::SELECT('SELECT SUM(intpago) AS interes, DATE(created_at) AS created_at
                                FROM pago
                                WHERE created_at BETWEEN "'.$fecha_inicial.'" AND "'.$fecha_final.'"
                                GROUP BY MONTH(created_at)');

        $pt = count($interes);

        for($m=1; $m<=12; $m++){
            $registros[$m]=0;
            $totalInteres[$m]=0;      
        }

        foreach($interes as $it){
            $messel = intval(date("m",strtotime($it->created_at) ) );
            $registros[$messel]++;
            $totalInteres[$messel++] = $it->interes;
  
        }

        $data = array("registrosmes"=>$registros, "interes" => $totalInteres);

        return json_encode($data);
    }

    public function graficoLineaMoraMes(Request $request)
    {
        $anio = $request->anio;
        $fecha_inicial=date("Y-m-d H:i:s", strtotime($anio."-01-01") );
        $fecha_final=date("Y-m-d H:i:s", strtotime($anio."-12-31") );

        $mora = \DB::SELECT('SELECT SUM(mora) AS mora, DATE(created_at) AS created_at
                                FROM pago
                                WHERE created_at BETWEEN "'.$fecha_inicial.'" AND "'.$fecha_final.'"
                                GROUP BY MONTH(created_at)');

        $pt = count($mora);

        for($m=1; $m<=12; $m++){
            $registros[$m]=0;
            $totalMoras[$m]=0;      
        }

        foreach($mora as $mo){
            $messel = intval(date("m",strtotime($mo->created_at) ) );
            $registros[$messel]++;
            $totalMoras[$messel++] = $mo->mora;
  
        }

        $data = array("registrosmes"=>$registros, "mora" => $totalMoras);

        return json_encode($data);
    }

    public function graficoLineaVentaMes(Request $request)
    {
        $anio = $request->anio;

        $primer_dia=1;

        $fecha_inicial=date("Y-m-d H:i:s", strtotime($anio."-01-01") );
        $fecha_final=date("Y-m-d H:i:s", strtotime($anio."-12-31") );

        $venta = \DB::SELECT('SELECT SUM(importe - interesPagar - moraPagar - monto) AS venta, date(created_at) AS fecVenta
                             FROM movimiento 
                             WHERE codigo = "V" AND created_at BETWEEN "'.$fecha_inicial.'" AND "'.$fecha_final.'"
                             GROUP BY MONTH(created_at)');

        $pt = count($venta);

        for($m=1; $m<=12; $m++){
            $registros[$m]=0;
            $gananciaVenta[$m]=0;      
        }

        foreach($venta as $ve){
            $messel = intval(date("m",strtotime($ve->fecVenta) ) );
            $registros[$messel]++;
            $gananciaVenta[$messel++] = $ve->venta;
  
        }

        $data = array("registrosmes"=>$registros, "venta" => $gananciaVenta);

        return json_encode($data);
    }

    public function graficoLineaAdministrativoMes(Request $request)
    {
        $anio = $request->anio;

        $primer_dia=1;

        $fecha_inicial=date("Y-m-d H:i:s", strtotime($anio."-01-01") );
        $fecha_final=date("Y-m-d H:i:s", strtotime($anio."-12-31") );

        $gastoAdmin = \DB::SELECT('SELECT SUM(monto) AS gasto, DATE(created_at) AS created_at 
                              FROM movimiento 
                              WHERE codigo = "GA" AND (created_at BETWEEN "'.$fecha_inicial.'" AND "'.$fecha_final.'")
                              GROUP BY MONTH(created_at)');

        $pt = count($gastoAdmin);

        for($m=1; $m<=12; $m++){
            $registros[$m]=0;
            $gastosAdministrativos[$m]=0;      
        }

        foreach($gastoAdmin as $ga){
            $messel = intval(date("m",strtotime($ga->created_at) ) );
            $registros[$messel]++;
            $gastosAdministrativos[$messel++] = $ga->gasto;
  
        }

        $data = array("registrosmes"=>$registros, "administrativo" => $gastosAdministrativos);

        return json_encode($data);
    }

    public function graficoLineaPrestamoActivoMes(Request $request)
    {
        $anio = $request->anio;

        $primer_dia=1;

        $fecha_inicial=date("Y-m-d H:i:s", strtotime($anio."-01-01") );
        $fecha_final=date("Y-m-d H:i:s", strtotime($anio."-12-31") );

        $prestamo = \DB::SELECT('SELECT * 
                                 FROM prestamo 
                                 WHERE codigo = "N" AND estado = "ACTIVO DESEMBOLSADO" AND (fecinicio BETWEEN "'.$fecha_inicial.'" AND "'.$fecha_final.'")');

        $renovacion = \DB::SELECT('SELECT * 
                                   FROM prestamo 
                                   WHERE codigo = "R" AND estado = "ACTIVO DESEMBOLSADO" AND (fecinicio BETWEEN "'.$fecha_inicial.'" AND "'.$fecha_final.'")');

        $pt = count($prestamo);

        $pt2 = count($renovacion);

        for($m=1; $m<=12; $m++){
            $registros[$m]=0;
            $registrosPrestamo[$m]=0;
            $registrosRenovacion[$m]=0;
        }

        foreach($prestamo as $p){
            $messel = intval(date("m",strtotime($p->fecinicio) ) );
            $registrosPrestamo[$messel]++;
        }

        foreach($renovacion as $r){
            $messel = intval(date("m",strtotime($r->fecinicio) ) );
            $registrosRenovacion[$messel]++;
        }

        $data = array("registrosmes"=>$registros, "prestamo" => $registrosPrestamo, "renovacion" => $registrosRenovacion);

        return json_encode($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function graficoLineaPrestamoEstado(Request $request)
    {
        $anio = $request->anio;
        $mes = $request->mes;
        $estado = $request->estado;

        $primer_dia=1;
        $ultimo_dia=$this->getUltimoDiaMes($anio,$mes);
        $fecha_inicial=date("Y-m-d H:i:s", strtotime($anio."-".$mes."-".$primer_dia) );
        $fecha_final=date("Y-m-d H:i:s", strtotime($anio."-".$mes."-".$ultimo_dia) );

        $prestamos = \DB::SELECT('SELECT * 
                                  FROM prestamo 
                                  WHERE estado = "'.$estado.'" AND fecinicio BETWEEN "'.$fecha_inicial.'" AND "'.$fecha_final.'"');
           
        $pt = count($prestamos);

        for($d=1;$d<=$ultimo_dia;$d++){
            $registros[$d]=0;     
        }

        foreach($prestamos as $pts){
            $diasel = intval(date("d",strtotime($pts->fecinicio) ) );
            $registros[$diasel]++;    
        }
        


        $data = array("totaldias"=>$ultimo_dia, "registrosdia" =>$registros);
        

        //dd(json_encode($data));
        return json_encode($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function graficoAnual(Request $request)
    {
        $anio = \DB::SELECT('SELECT YEAR(fecinicio) AS anio 
                             FROM prestamo 
                             GROUP BY YEAR(fecinicio)');

        $prestamo = \DB::SELECT('SELECT COUNT(*) AS cantidadPrestamo, YEAR(fecinicio) AS fecinicio FROM prestamo WHERE estado = "ACTIVO DESEMBOLSADO" GROUP BY YEAR(fecinicio)');

        $bienes = \DB::SELECT('SELECT COUNT(*) AS cantidadBienes FROM prestamo GROUP BY YEAR(fecinicio)');

        $liquidacion = \DB::SELECT('SELECT COUNT(*) AS cantLiquidacion FROM prestamo WHERE estado = "LIQUIDACION" GROUP BY YEAR(fecinicio)');

        $vendido = \DB::SELECT('SELECT COUNT(*) AS cantVendido  FROM prestamo WHERE estado = "VENDIDO" GROUP BY YEAR(fecinicio)');

        $cliente = \DB::SELECT('SELECT COUNT(*) AS contCliente FROM cliente GROUP BY YEAR(created_at)');

        $efectivo = \DB::SELECT('SELECT sum(monto) AS monto, YEAR(fecinicio) fecinicio
                                 FROM prestamo 
                                 GROUP BY YEAR(fecinicio)');

        $interes = \DB::SELECT('SELECT SUM(intpago) AS interes, YEAR(created_at) AS created_at
                                FROM pago
                                GROUP BY YEAR(created_at)');

        $mora = \DB::SELECT('SELECT SUM(mora) AS mora, YEAR(created_at) AS created_at
                             FROM pago
                             GROUP BY YEAR(created_at)');

        $venta = \DB::SELECT('SELECT SUM(importe - interesPagar - moraPagar - monto) AS venta, YEAR(created_at) AS fecVenta
                              FROM movimiento 
                              WHERE codigo = "V"
                              GROUP BY YEAR(created_at)');

        $gastoAdmin = \DB::SELECT('SELECT SUM(monto) AS gasto, YEAR(created_at) AS created_at 
                                   FROM movimiento 
                                   WHERE codigo = "GA"
                                   GROUP BY YEAR(created_at)');

        $prestamoActivo = \DB::SELECT('SELECT COUNT(*) AS cantPrestamoActivo 
                                       FROM prestamo 
                                       WHERE codigo = "N" AND estado = "ACTIVO DESEMBOLSADO"
                                       GROUP BY YEAR(fecinicio)');

        $renovacionActivo = \DB::SELECT('SELECT COUNT(*) AS cantRenovacionActivo 
                                         FROM prestamo 
                                         WHERE codigo = "R" AND estado = "ACTIVO DESEMBOLSADO" 
                                         GROUP BY YEAR(fecinicio)');

        $totAnio = COUNT($anio);

        for($a=1; $a<=$totAnio ;$a++){
            $registros[$a]=0;
            $monto[$a]=0;
            $veranio[$a] = 0;
            $cantidadPrestamo[$a] = 0;
            $cantidadBienes[$a] = 0;
            $cantidadLiquidacion[$a] = 0;
            $cantidadVendido[$a] = 0;
            $cantidadCliente[$a] = 0;
            $montoEfectivo[$a] = 0;
            $montoInteres[$a] = 0;
            $montoMora[$a] = 0;
            $montoVenta[$a] = 0;      
            $gastoAdministrativo[$a] = 0;
            $presActivo[$a] = 0;
            $renActivo[$a] = 0;
        }
                                         


        foreach($prestamo as $pts){
            $veranio[] = $pts->fecinicio;
            $cantidadPrestamo[] = $pts->cantidadPrestamo;
        }

        foreach ($bienes as $bi) {
            $cantidadBienes[] = $bi->cantidadBienes;
        }

        foreach ($liquidacion as $li) {
            $cantidadLiquidacion[] = $li->cantLiquidacion;
        }

        foreach ($vendido as $ve) {
            $cantidadVendido[] = $ve->cantVendido;
        }

        foreach ($cliente as $cl) {
            $cantidadCliente[] = $cl->contCliente;
        }

        foreach ($efectivo as $ef) {
            $montoEfectivo[] = $ef->monto;
        }

        foreach ($interes as $in) {
            $montoInteres[] = $in->interes;
        }

        foreach ($mora as $mo) {
            $montoMora[] = $mo->mora;
        }

        foreach ($venta as $vt) {
            $montoVenta[] = $vt->venta;
        }

        foreach ($gastoAdmin as $ga){
            $gastoAdministrativo[] = $ga->gasto;
        }

        foreach ($prestamoActivo as $pa) {
            $presActivo[] = $pa->cantPrestamoActivo;
        }

        foreach ($renovacionActivo as $ra) {
            $renActivo[] = $ra->cantRenovacionActivo;
        }

        

        $data = array("totalanio" => $totAnio, "anio"=>$veranio , "cantprestamo" =>$cantidadPrestamo, "cantbienes" => $cantidadBienes, "cantliquidacion" => $cantidadLiquidacion, "cantvendido" => $cantidadVendido, "cantcliente" => $cantidadCliente, "montefectivo" => $montoEfectivo, "montinteres" => $montoInteres, "monmora" => $montoMora, "monventa" => $montoVenta, "gastoAdmin" => $gastoAdministrativo, "prestamoactivo" => $presActivo, "renovacionactivo" => $renActivo);
        

        //dd(json_encode($data));
        return json_encode($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function graficoFlujoCajaAnual(Request $request)
    {
        $anio = \DB::SELECT('SELECT YEAR(fecinicio) AS anio 
                             FROM prestamo 
                             GROUP BY YEAR(fecinicio)');

        $egreso = \DB::SELECT('SELECT SUM(importe) AS monto, YEAR(created_at) AS fecinicio
                               FROM movimiento
                               WHERE tipo = "EGRESO"
                               GROUP BY YEAR(created_at)');

        $ingreso = \DB::SELECT('SELECT SUM(importe) AS monto, YEAR(created_at) AS fecinicio
                                FROM movimiento
                                WHERE tipo = "INGRESO"
                                GROUP BY YEAR(created_at)');

        $cantAnio = COUNT($anio);

        for($a=1; $a<=$cantAnio ;$a++){
            $registros[$a]=0;
            //$montoEgreso[$a]=0;
            //$montoIngreso[$a] = 0;
            //$veranio[$a] = 0;
        }

        foreach($egreso as $e){
            $veranio[] = $e->fecinicio;
            $montoEgreso[] = $e->monto;
        }

        foreach($ingreso as $i){
            $montoIngreso[] = $i->monto;
        }

        $data = array("totalanio" => $cantAnio, "numanio"=>$veranio , "egreso" =>$montoEgreso, "ingreso" => $montoIngreso);
        

        //dd(json_encode($data));
        return json_encode($data);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function registrarInventario(Request $request)
    {
        $tipoinventario_id = $request->tipoinventario_id;
        $nombre = $request->nombre;
        $marca = $request->marca;
        $unidad = $request->unidad;
        $valor = $request->valor;
        $estado = "ACTIVO";
        $resp = "0";

        $in = new Inventario();
        $in->unidad = $unidad;
        $in->nombre = $nombre;
        $in->valor = $valor;
        $in->marca = $marca;
        $in->estado = $estado;
        $in->tipoinventario_id = $tipoinventario_id;
        if ($in->save()) {
            $resp = "1";

            $equipo = \DB::SELECT('SELECT * FROM inventario 
                               WHERE tipoinventario_id = "1" AND estado = "ACTIVO"');
            
            $totalInventario = \DB::SELECT('SELECT ROUND(SUM(unidad*valor),2) AS total 
                                            FROM inventario 
                                            WHERE tipoinventario_id = "1" AND estado = "ACTIVO"');

            if ($totalInventario == null) {
                $totalInventario = \DB::SELECT('SELECT "0.00" AS total');
            }
        }

        return response()->json(["view"=>view('finanza.tabMueble',compact('equipo', 'totalInventario'))->render(), "viewTi"=>view('finanza.activosMueble',compact('totalInventario'))->render(), 'resp'=>$resp]);
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
