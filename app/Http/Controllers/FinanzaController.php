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

        $caja = \DB::SELECT('SELECT MAX(c.id) AS id
                             FROM caja c, tipocaja tc 
                             WHERE c.tipocaja_id = tc.id AND tc.codigo = "CG" AND c.empleado = "'.$usuario[0]->id.'"');
                             

        $utilidades = \DB::SELECT('SELECT IF(SUM(intpago) IS NULL, 0.00, SUM(intpago)) AS utilidades
                                   FROM pago 
                                   WHERE CONCAT(MONTH(created_at), "-", YEAR(created_at)) = CONCAT(MONTH(NOW()), "-", YEAR(NOW()))');

        $mora = \DB::SELECT('SELECT IF(SUM(mora) IS NULL, 0.00, SUM(mora)) AS mora
                             FROM pago 
                             WHERE CONCAT(MONTH(created_at), "-", YEAR(created_at)) = CONCAT(MONTH(NOW()), "-", YEAR(NOW()))');

        $venta = \DB::SELECT('SELECT IF(SUM(importe - monto) IS NULL, 0.00, SUM(importe - monto)) AS venta 
                              FROM movimiento 
                              WHERE codigo = "V" AND CONCAT(MONTH(created_at), "-", YEAR(created_at)) = CONCAT(MONTH(NOW()), "-", YEAR(NOW()))');
                              

        $gastosadministrativos = \DB::SELECT('SELECT IF(SUM(m.monto) IS NULL, 0.00, SUM(m.monto)) AS monto FROM movimiento m, caja c, tipocaja tc WHERE m.caja_id = c.id AND c.tipocaja_id = tc.id AND (m.codigo = "GA") AND m.tipo = "EGRESO" AND m.serie != "cc" AND m.concepto != "impuesto" AND CONCAT(MONTH(m.created_at), "-", YEAR(m.created_at)) = CONCAT(MONTH(NOW()), "-", YEAR(NOW())) AND c.id = "'.$caja[0]->id.'"');
        
        $historialCajaGrande = \DB::SELECT('SELECT SUM(monto) AS monto, MONTH(created_at) AS mes
                                            FROM movimiento 
                                            WHERE codigo = "GA" AND CONCAT(MONTH(created_at), "-", YEAR(created_at)) = CONCAT(MONTH(NOW()), "-", YEAR(NOW()))
                                            GROUP BY MONTH(created_at)');
                                            
        if($historialCajaGrande==null){
            $historialCajaGrande = \DB::SELECT('SELECT "0.00" AS monto, MONTH(NOW()) AS mes');
        }
                                            
        //dd($historialCajaGrande);

        $cajaChica = \DB::SELECT('SELECT SUM(m.monto) AS monto 
                                  FROM movimiento m, caja c, tipocaja tc
                                  WHERE m.caja_id = c.id AND c.tipocaja_id = tc.id AND tc.codigo = "cc" AND (MONTH(NOW()) = MONTH(m.created_at) AND YEAR(NOW()) = YEAR(m.created_at)) AND m.tipo = "EGRESO" AND m.codigo = "o"');
                                  
        //dd($cajaChica);

        $historial = \DB::SELECT('SELECT SUM(utilidades) AS monto, anio
                                  FROM(SELECT IF(SUM(intpago) IS NULL, 0.00, SUM(intpago)) AS utilidades, YEAR(created_at) AS anio
                                       FROM pago 
                                       GROUP BY YEAR(created_at)
                                       UNION
                                       SELECT IF(SUM(mora) IS NULL, 0.00, SUM(mora)) AS mora, YEAR(created_at) AS anio
                                       FROM pago 
                                       GROUP BY YEAR(created_at)
                                       UNION
                                       SELECT IF(SUM(importe - monto) IS NULL, 0.00, SUM(importe - monto)) AS venta, YEAR(created_at) AS anio
                                       FROM movimiento 
                                       WHERE codigo = "V"
                                       GROUP BY YEAR(created_at)
                                       UNION
                                       SELECT IF(SUM(m.monto) IS NULL, 0.00, SUM(m.monto))  AS monto, YEAR(m.created_at) AS anio
                                       FROM movimiento m, caja c, tipocaja tc
                                       WHERE m.caja_id = c.id AND c.tipocaja_id = tc.id AND (m.codigo = "GA" OR tc.codigo = "CC") AND m.tipo = "EGRESO" AND m.serie != "cc" AND m.concepto != "impuesto" AND c.id = "'.$caja[0]->id.'"
                                       GROUP BY YEAR(m.created_at)) t
                                       GROUP BY anio');

        $historialMes = \DB::SELECT('SELECT SUM(utilidades) AS monto, mes
                                     FROM(SELECT IF(SUM(intpago) IS NULL, 0.00, SUM(intpago)) AS utilidades, MONTH(created_at) AS mes
                                          FROM pago 
                                          WHERE YEAR(created_at) = YEAR(NOW())
                                          GROUP BY MONTH(created_at)
                                          UNION
                                          SELECT IF(SUM(mora) IS NULL, 0.00, SUM(mora)) AS mora, MONTH(created_at) AS mes
                                          FROM pago 
                                          WHERE YEAR(created_at) = YEAR(NOW())
                                          GROUP BY MONTH(created_at)
                                          UNION
                                          SELECT IF(SUM(importe - monto) IS NULL, 0.00, SUM(importe - monto)) AS venta, MONTH(created_at) AS mes
                                          FROM movimiento 
                                          WHERE YEAR(created_at) = YEAR(NOW())
                                          GROUP BY MONTH(created_at)
                                          UNION
                                          SELECT IF(SUM(m.monto) IS NULL, 0.00, SUM(m.monto))  AS monto, MONTH(m.created_at) AS mes
                                          FROM movimiento m, caja c, tipocaja tc
                                          WHERE m.caja_id = c.id AND c.tipocaja_id = tc.id AND (m.codigo = "GA" OR tc.codigo = "CC") AND m.tipo = "EGRESO" AND m.serie != "cc" AND m.concepto != "impuesto"
                                          AND YEAR(m.created_at) = YEAR(NOW())
                                     GROUP BY MONTH(m.created_at)) t
                                     GROUP BY mes
                                     ORDER BY mes ASC');

        $historialAnual1 = \DB::SELECT('SELECT SUM(intpago) + SUM(mora) AS utilidades, YEAR(created_at) AS anio
                                       FROM pago
                                       GROUP BY YEAR(created_at)');

        $historialAnual2 = \DB::SELECT('SELECT SUM(importe-monto) + SUM(importe) AS utilidades, YEAR(created_at) AS anio
                                        FROM movimiento
                                        WHERE codigo = "V" OR codigo = "GA" 
                                        GROUP BY YEAR(created_at)');

        $historialMes1 = \DB::SELECT('SELECT SUM(intpago) + SUM(mora) AS utilidades, MONTH(created_at) AS mes
                                      FROM pago
                                      WHERE YEAR(created_at) = YEAR(NOW())
                                      GROUP BY MONTH(created_at)');

        $historialMes2 = \DB::SELECT('SELECT SUM(importe-monto) + SUM(importe) AS utilidades, MONTH(created_at) AS mes
                                      FROM movimiento
                                      WHERE codigo = "V" OR codigo = "GA" AND YEAR(created_at) = YEAR(NOW())
                                      GROUP BY MONTH(created_at)');

        $impuesto = \DB::SELECT('SELECT SUM(m.monto) AS monto 
                                 FROM movimiento m, caja c
                                 WHERE m.caja_id = c.id AND m.concepto = "IMPUESTO" AND c.id = "'.$caja[0]->id.'" AND CONCAT(MONTH(m.created_at), "-", YEAR(m.created_at)) = CONCAT(MONTH(NOW()), "-", YEAR(NOW()))');
                                 
        $impuestoHistorial = \DB::SELECT('SELECT IF(SUM(m.monto) IS NULL, 0.00, SUM(m.monto))  AS monto, YEAR(m.created_at) AS anio
                                          FROM movimiento m, caja c
                                          WHERE m.caja_id = c.id AND m.concepto = "IMPUESTO" AND c.id = "'.$caja[0]->id.'"
                                          GROUP BY YEAR(m.created_at)');
                                          
        $historialCajaChica = \DB::SELECT('SELECT SUM(monto) AS monto, MONTH(created_at) AS mes
                                           FROM movimiento 
                                           WHERE codigo = "o" AND YEAR(created_at) = YEAR(NOW())
                                           GROUP BY MONTH(created_at)');
                                           
        //dd($historialCajaChica);
                                          

        return view('finanza.analisisresult', compact('impuesto', 'historialMes1', 'historialMes2', 'historialAnual1', 'historialAnual2', 'usuario', 'utilidades', 'mora', 'venta', 'gastosadministrativos', 'notificacion', 'cantNotificaciones', 'cajaChica', 'historial', 'historialMes', 'impuestoHistorial', 'historialCajaChica', 'historialCajaGrande'));
    }

    public function analisisResultadoMes(Request $request)
    {
        $anio = $request->anio;

        $historialMes = \DB::SELECT('SELECT SUM(utilidades) AS monto, mes
                                     FROM(SELECT IF(SUM(intpago) IS NULL, 0.00, SUM(intpago)) AS utilidades, MONTH(created_at) AS mes
                                          FROM pago 
                                          WHERE YEAR(created_at) = '.$anio.'
                                          GROUP BY MONTH(created_at)
                                          UNION
                                          SELECT IF(SUM(mora) IS NULL, 0.00, SUM(mora)) AS mora, MONTH(created_at) AS mes
                                          FROM pago 
                                          WHERE YEAR(created_at) = '.$anio.'
                                          GROUP BY MONTH(created_at)
                                          UNION
                                          SELECT IF(SUM(importe - monto) IS NULL, 0.00, SUM(importe - monto)) AS venta, MONTH(created_at) AS mes
                                          FROM movimiento 
                                          WHERE YEAR(created_at) = '.$anio.'
                                          GROUP BY MONTH(created_at)
                                          UNION
                                          SELECT IF(SUM(m.monto) IS NULL, 0.00, SUM(m.monto))  AS monto, MONTH(m.created_at) AS mes
                                          FROM movimiento m, caja c, tipocaja tc
                                          WHERE m.caja_id = c.id AND c.tipocaja_id = tc.id AND (m.codigo = "GA" OR tc.codigo = "CC") AND m.tipo = "EGRESO" AND m.serie != "cc" AND m.concepto != "impuesto"
                                          AND YEAR(m.created_at) = '.$anio.'
                                     GROUP BY MONTH(m.created_at)) t
                                     GROUP BY mes
                                     ORDER BY mes ASC');

        return response()->json(["view"=>view('finanza.tabAnalisisResultadoMes',compact('historialMes'))->render()]);

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
        /*Prestmoas*/                       
        $prestamos = \DB::SELECT('SELECT COUNT(*) AS cant, YEAR(fecinicio) AS anio 
                                  FROM prestamo 
                                  GROUP BY YEAR(fecinicio)');

        $efectivo = \DB::SELECT('SELECT sum(monto) AS monto, YEAR(created_at) AS fec
                                 FROM desembolso 
                                 GROUP BY YEAR(created_at)');

        $interes = \DB::SELECT('SELECT SUM(intpago) AS interes, YEAR(created_at) AS created_at
                                FROM pago
                                GROUP BY YEAR(created_at)');

        $mora = \DB::SELECT('SELECT SUM(mora) AS mora, YEAR(created_at) AS created_at
                            FROM pago
                            GROUP BY YEAR(created_at)');

        $venta = \DB::SELECT('SELECT SUM(importe - monto) AS venta, YEAR(created_at) AS fecVenta
                              FROM movimiento 
                              GROUP BY YEAR(created_at)');

        $gastoAdmin = \DB::SELECT('SELECT SUM(monto) AS gasto, YEAR(created_at) AS created_at 
                                FROM movimiento 
                                GROUP BY YEAR(created_at)');

        $balancePrestamo = \DB::SELECT('SELECT COUNT(*) as cant, YEAR(created_at) AS created_at 
                                        FROM prestamo 
                                        WHERE codigo = "N" AND estado = "ACTIVO DESEMBOLSADO"
                                        GROUP BY YEAR(created_at)');

        $balanceRenovacion = \DB::SELECT('SELECT COUNT(*) as cant, YEAR(created_at) AS created_at 
                                          FROM prestamo 
                                          WHERE codigo = "R" AND estado = "ACTIVO DESEMBOLSADO"
                                          GROUP BY YEAR(created_at)');

        foreach($prestamos as $pr){
            $registros[$pr->anio++] = $pr->cant;
        }

        foreach($efectivo as $e){
            $registroEfectivo[$e->fec++] = $e->monto;
        }

        foreach($interes as $i){
            $registroInteres[$i->created_at++] = $i->interes;
        }

        foreach($mora as $m){
            $registroMora[$m->created_at++] = $m->mora;
        }

        foreach($venta as $v){
            $registroVenta[$v->fecVenta++] = $v->venta;
        }

        foreach($gastoAdmin as $ga){
            $registroGastosAdministrativos[$ga->created_at++] = $ga->gasto;
        }

        foreach($balancePrestamo as $bp){
            $registrosBalancePrestamo[$bp->created_at++] = $bp->cant;
        }

        foreach($balanceRenovacion as $br){
            $registrosBalanceRenovacion[$br->created_at++] = $br->cant;
  
        }

        return view('finanza.estprestamo', compact('usuario', 'anio', 'estado', 'notificacion', 'cantNotificaciones', 'registros', 'registroEfectivo', 'registroInteres', 'registroMora', 'registroVenta', 'registroGastosAdministrativos', 'registrosBalancePrestamo', 'registrosBalanceRenovacion'));
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

        $cajaChica = \DB::SELECT('SELECT m.* 
                                  FROM movimiento m, caja c, tipocaja tc
                                  WHERE m.caja_id = c.id AND tc.id = c.tipocaja_id AND tc.codigo = "cc" AND MONTH(NOW()) = MONTH(m.created_at) AND c.sede_id = "'.$usuario[0]->sede.'" AND m.tipo = "EGRESO" AND m.codigo = "o"');

        //dd($cajaChica);

        $cajaGrande = \DB::SELECT('SELECT m.* 
                                   FROM movimiento m, caja c, tipocaja tc
                                   WHERE m.caja_id = c.id AND tc.id = c.tipocaja_id AND tc.codigo = "cg" AND MONTH(NOW()) = MONTH(m.created_at) AND c.sede_id = "'.$usuario[0]->sede.'" AND m.tipo = "EGRESO" AND m.codigo <> "GA"');

        $historialCajaGrande = \DB::SELECT('SELECT SUM(monto) AS monto, MONTH(created_at) AS mes
                                            FROM movimiento 
                                            WHERE codigo = "GA" AND YEAR(created_at) = YEAR(NOW())
                                            GROUP BY MONTH(created_at)');

        $historialCajaChica = \DB::SELECT('SELECT SUM(monto) AS monto, MONTH(created_at) AS mes
                                           FROM movimiento 
                                           WHERE codigo = "o" AND YEAR(created_at) = YEAR(NOW())
                                           GROUP BY MONTH(created_at)');
                                           
        //dd($historialCajaChica);

        for($m=1; $m<=12; $m++){
            $montoCaja[$m]=0;
            $montoCajaGrande[$m]=0;      
        }

        foreach ($historialCajaChica as $hcc) {
            $messel = intval($hcc->mes);
            $montoCaja[$messel++] = $hcc->monto;
        }
        
        

        foreach ($historialCajaGrande as $hcg) {
            $messel = intval($hcg->mes);
            $montoCajaGrande[$messel++] = $hcg->monto;
        }

        return view('finanza.gastos', compact('usuario', 'cajaChica', 'cajaGrande', 'notificacion', 'cantNotificaciones', 'historialCajaChica', 'montoCaja', 'montoCajaGrande'));
    }

    public function verHisrialGastosDia(Request $request)
    {
        $mes = $request->mes;
        $user = Auth::user();
        $usuario = \DB::SELECT('SELECT e.nombre, e.apellido, e.id, u.name AS area, e.foto AS foto, e.sede_id AS sede
                                FROM empleado e, users u 
                                WHERE e.users_id = u.id AND u.id = "'.$user->id.'"');

        $cajaChica = \DB::SELECT('SELECT m.* 
                                  FROM movimiento m, caja c, tipocaja tc
                                  WHERE m.caja_id = c.id AND tc.id = c.tipocaja_id AND tc.codigo = "cc" AND CONCAT(YEAR(m.created_at), "-", MONTH(m.created_at))  = CONCAT(YEAR(NOW()), "-", '.$mes.') AND c.sede_id = "'.$usuario[0]->sede.'" AND m.tipo = "EGRESO" AND m.codigo = "o"');

        return response()->json(["view"=>view('finanza.tabHistorialGastosCC',compact('cajaChica'))->render()]);

    }

    public function verHistorialGastosCGDia(Request $request)
    {
        $mes = $request->mes;
        $user = Auth::user();
        $usuario = \DB::SELECT('SELECT e.nombre, e.apellido, e.id, u.name AS area, e.foto AS foto, e.sede_id AS sede
                                FROM empleado e, users u 
                                WHERE e.users_id = u.id AND u.id = "'.$user->id.'"');

$cajaGrande = \DB::SELECT('SELECT m.*, d.url AS documento 
                           FROM movimiento m, movimiento_documento md, documento d 
                           WHERE md.movimiento_id = m.id AND md.documento_id = d.id AND codigo = "GA" AND CONCAT(YEAR(NOW()), "-", '.$mes.') = CONCAT(YEAR(m.created_at), "-", MONTH(m.created_at))');

        return response()->json(["view"=>view('finanza.tabHistorialGastosCG',compact('cajaGrande'))->render()]);
    }

    public function historialCajaGrande(Request $request)
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

    public function editarInventario(Request $request){

        $id = $request->id;
        $unidad = $request->unidad;
        $nombre = $request->nombre;
        $marca = $request->marca;
        $valor = $request->valor;
        
        $in = Inventario::where('id', '=', $id)->first(); 
        $in->unidad = $unidad;
        $in->nombre = $nombre;
        $in->valor = $valor;
        $in->marca = $marca;
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

    public function eliminarInventario(Request $request)
    {
        $id = $request->id;
        $unidad = $request->unidad;
        $valor = $request->valor;
        $resp = "0";

        //$note = Note::find($id);
        
        //$note->delete();
        
        $in = Inventario::find($id); 
        if ($in->delete()) {
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

        $cajaBancoBN = \DB::SELECT('SELECT monto 
                                    FROM caja 
                                    WHERE tipocaja_id = "'.$tipocaja[2]->id.'"'); 

        $cajaBancoBcp = \DB::SELECT('SELECT monto 
                                     FROM caja 
                                     WHERE tipocaja_id = "'.$tipocaja[3]->id.'"'); 

        $cajaBancoI = \DB::SELECT('SELECT monto 
                                     FROM caja 
                                     WHERE tipocaja_id = "'.$tipocaja[4]->id.'"'); 

        $cajaB = $cajaBancoBN[0]->monto + $cajaBancoBcp[0]->monto + $cajaBancoI[0]->monto;

        $cajaBanco = \DB::SELECT('SELECT '.$cajaB.' AS monto');

        if ($cajaBanco == 0) {
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

        $anio = \DB::SELECT('SELECT YEAR(updated_at) AS anio 
                             FROM caja 
                             GROUP BY YEAR(updated_at)');

        //Historial Patrimonio
        $historialPat = \DB::SELECT('SELECT SUM(monto) AS monto, anio
                                     FROM (SELECT IF(SUM(monto) IS NULL, 0.00, SUM(monto)) AS monto, YEAR(fecha) AS anio
                                           FROM caja 
                                           WHERE id = (SELECT MAX(id) FROM caja WHERE tipocaja_id = "1")
                                                OR tipocaja_id = "2"
                                                OR tipocaja_id = "3"
                                                OR tipocaja_id = "4"
                                                OR tipocaja_id = "5"
                                           GROUP BY YEAR(fecha)
                                           UNION                                
                                           SELECT IF(SUM(unidad*valor) IS NULL, 0.00, SUM(unidad*valor))  AS monto, YEAR(updated_at) AS anio 
                                           FROM inventario 
                                           GROUP BY YEAR(updated_at)
                                           UNION
                                           SELECT IF(SUM(monto) IS NULL, 0.00, SUM(monto)) AS monto, YEAR(updated_at) AS anio
                                           FROM prestamo
                                           WHERE estado = "ACTIVO DESEMBOLSADO" OR estado = "LIQUIDACION" GROUP BY YEAR(updated_at)
                                     ) f
                                     GROUP BY anio
                                     ORDER BY anio ASC');
                                     
        $inventario = \DB::SELECT('SELECT SUM(unidad*valor) AS monto, YEAR(updated_at) AS anio FROM inventario GROUP BY YEAR(updated_at)');
                                     
         for ($i=0; $i < count($inventario) ; $i++) { 
            $monto[$i] = 0;
            $caja[$i]->monto = 0; 
            $inventario[$i]->monto = 0;
            $prestamo[$i]->monto = 0;
            $mostrarAnios[$i] = 0;
            $caja[$i]->anio = 0;
        }

        $caja = \DB::SELECT('SELECT SUM(monto) AS monto, YEAR(fecha) AS anio
                             FROM caja 
                             WHERE id = (SELECT MAX(id) FROM caja WHERE tipocaja_id = "1")
                                OR tipocaja_id = "2"
                                OR tipocaja_id = "3"
                                OR tipocaja_id = "4"
                                OR tipocaja_id = "5"
                                GROUP BY YEAR(fecha)');

        $inventario = \DB::SELECT('SELECT SUM(unidad*valor) AS monto, YEAR(updated_at) AS anio FROM inventario GROUP BY YEAR(updated_at)');

        $prestamo = \DB::SELECT('SELECT SUM(monto) AS monto, YEAR(updated_at) AS anio
                                 FROM prestamo
                                 WHERE estado = "ACTIVO DESEMBOLSADO" OR estado = "LIQUIDACION" GROUP BY YEAR(updated_at)');
                                 
         

        for ($i=0; $i < count($inventario) ; $i++) { 

            $monto[$i] = $caja[$i]->monto + $inventario[$i]->monto + $prestamo[$i]->monto;
            $mostrarAnios[$i] = $caja[$i]->anio;
        }
/*
        for ($j=0; $j < 12; $j++) { 
            $montoMes[$j] = 0;
        }
        */

            $histMes = \DB::SELECT('SELECT SUM(monto) AS monto, mes
                                    FROM (
                                    SELECT IF(SUM(monto) IS NULL, 0.00, SUM(monto)) AS monto, MONTH(fecha) AS mes
                                    FROM caja 
                                    WHERE id = (SELECT MAX(id) FROM caja WHERE tipocaja_id = "1")
                                        OR tipocaja_id = "2"
                                        OR tipocaja_id = "3"
                                        OR tipocaja_id = "4"
                                        OR tipocaja_id = "5"
                                    AND YEAR(fecha) = YEAR(NOW())
                                    GROUP BY MONTH(fecha)
                                    UNION                                
                                    SELECT IF(SUM(unidad*valor) IS NULL, 0.00, SUM(unidad*valor))  AS monto, MONTH(updated_at) AS mes 
                                    FROM inventario 
                                    WHERE YEAR(updated_at) = YEAR(NOW())
                                    GROUP BY MONTH(updated_at)
                                    UNION
                                    SELECT IF(SUM(monto) IS NULL, 0.00, SUM(monto)) AS monto, MONTH(updated_at) AS mes
                                    FROM prestamo
                                    WHERE estado = "ACTIVO DESEMBOLSADO" OR estado = "LIQUIDACION" AND YEAR(updated_at) = YEAR(NOW())
                                    GROUP BY MONTH(updated_at)
                                    ) f
                                    GROUP BY mes
                                    ORDER BY mes ASC');
                                    
            //dd($histMes);

            for ($m=1; $m <= 12; $m++) { 
                $nomMes[$m] = 0;
                $montoMes[$m] = 0;
            }

            foreach($histMes as $hm){
                $messel = intval($hm->mes);
                $montoMes[$messel++] = $hm->monto;
      
            }

        return view('finanza.patrimonio', compact('usuario', 'prestamoColocado', 'liquidacion', 'cajaChica', 'equipo', 'software', 'tipoinventario', 'totalInventario', 'cajaGrande', 'cajaBanco', 'pagoPersonal', 'pagoAlquiler', 'pagoInternet', 'utilesEscritorio', 'publicidad', 'tarjetaBCP', 'luz', 'impuesto', 'notificacion', 'cantNotificaciones', 'anio', 'monto', 'mostrarAnios', 'histMes', 'historialPat', 'montoMes'));
    } 

    public function verHistorialPat(Request $request){
        $anio = $request->anio;

        $histMes = \DB::SELECT('SELECT SUM(monto) AS monto, mes
                                    FROM (
                                    SELECT IF(SUM(monto) IS NULL, 0.00, SUM(monto)) AS monto, MONTH(fecha) AS mes
                                    FROM caja 
                                    WHERE id = (SELECT MAX(id) FROM caja WHERE tipocaja_id = "1")
                                        OR tipocaja_id = "2"
                                        OR tipocaja_id = "3"
                                        OR tipocaja_id = "4"
                                        OR tipocaja_id = "5"
                                    AND YEAR(fecha) = '.$anio.'
                                    GROUP BY MONTH(fecha)
                                    UNION                                
                                    SELECT IF(SUM(unidad*valor) IS NULL, 0.00, SUM(unidad*valor))  AS monto, MONTH(updated_at) AS mes 
                                    FROM inventario 
                                    WHERE YEAR(updated_at) = '.$anio.'
                                    GROUP BY MONTH(updated_at)
                                    UNION
                                    SELECT IF(SUM(monto) IS NULL, 0.00, SUM(monto)) AS monto, MONTH(updated_at) AS mes
                                    FROM prestamo
                                    WHERE estado = "ACTIVO DESEMBOLSADO" OR estado = "LIQUIDACION" AND YEAR(updated_at) = '.$anio.'
                                    GROUP BY MONTH(updated_at)
                                    ) f
                                    GROUP BY mes
                                    ORDER BY mes ASC');

            for ($m=1; $m <= 12; $m++) { 
                $nomMes[$m] = 0;
                $montoMes[$m] = 0;
            }

            foreach($histMes as $hm){
                $messel = intval($hm->mes);
                $montoMes[$messel++] = $hm->monto;
      
            }

            return response()->json(["view"=>view('finanza.tbHistPat', compact('histMes', 'montoMes'))->render()]);

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

    public function graficoPatrimonio(Request $request)
    {
        $anio = $request->anio;

        $fecha_inicial = date("Y-m-d H:i:s", strtotime($anio."-01-01") );
        $fecha_final = date("Y-m-d H:i:s", strtotime($anio."-12-31") );

        $caja = \DB::SELECT('SELECT SUM(monto) AS monto, YEAR(updated_at) AS anio
                             FROM caja 
                             WHERE id = (SELECT MAX(id) FROM caja WHERE tipocaja_id = "1") AND tipocaja_id = "1" 
                                OR tipocaja_id = "2"
                                OR tipocaja_id = "3"
                                OR tipocaja_id = "4"
                                OR tipocaja_id = "5"
                                GROUP BY YEAR(updated_at)');

        $inventario = \DB::SELECT('SELECT SUM(unidad*valor) AS monto, YEAR(updated_at) AS anio FROM inventario GROUP BY YEAR(updated_at)');

        $prestamo = \DB::SELECT('SELECT SUM(monto) AS monto, YEAR(updated_at) AS anio
                                 FROM prestamo
                                 WHERE estado = "ACTIVO DESEMBOLSADO" OR estado = "LIQUIDACION" GROUP BY YEAR(updated_at)');

        

        for ($i=0; $i < count($inventario) ; $i++) { 
            $monto[$i] = $caja[$i]->monto + $inventario[$i]->monto + $prestamo[$i]->monto;
            $anios[$i] = $caja[$i]->anio;
        }

        /*
        $prestamos = \DB::SELECT('SELECT (SUM(monto) + 
                                         (SELECT SUM(monto) 
                                          FROM caja 
                                          WHERE id = (SELECT MAX(id) FROM caja WHERE tipocaja_id = "1") AND tipocaja_id = "1" 
                                                OR tipocaja_id = "2"
                                                OR tipocaja_id = "3"
                                                OR tipocaja_id = "4"
                                                OR tipocaja_id = "5" AND updated_at BETWEEN "'.$fecha_inicial.'" AND "'.$fecha_final.'") + 
                                          (SELECT SUM(unidad*valor) AS monto 
                                           FROM inventario 
                                           WHERE updated_at BETWEEN "'.$fecha_inicial.'" AND "'.$fecha_final.'")) AS monto
                                    FROM prestamo
                                    WHERE estado = "ACTIVO DESEMBOLSADO" OR estado = "LIQUIDACION" AND updated_at BETWEEN "'.$fecha_inicial.'" AND "'.$fecha_final.'"');
        */
/*
        for($m=1; $m<=12; $m++){
            $registros[$m] = 0; 
            $totalPatrimonio[$m] = 0;     
        }
        */
        /*
        foreach($prestamos as $pts){
            $totalPatrimonio[] = $pts->monto;    
        }
        */

        //$data = array("patrimonioMora"=>$totalPatrimonio);

        return response()->json(["view"=>view('finanza.tbAnual', compact('monto', 'anios'))->render()]);
    }

    public function tabMesPatrimonio(Request $request)
    {
        /*
        $anio = $request->anio;

        $fecha_inicial = date("Y-m-d H:i:s", strtotime($anio."-01-01") );
        $fecha_final = date("Y-m-d H:i:s", strtotime($anio."-12-31") );

        $caja = \DB::SELECT('SELECT SUM(monto) AS monto
                             FROM caja 
                             WHERE id = (SELECT MAX(id) FROM caja WHERE tipocaja_id = "1")
                                   OR tipocaja_id = "2"
                                   OR tipocaja_id = "3"
                                   OR tipocaja_id = "4"
                                   OR tipocaja_id = "5"
                                   OR DATE(fecha) BETWEEN "'.$fecha_inicial.'" AND "'.$fecha_final.'"');


        $inventario = \DB::SELECT('SELECT SUM(unidad*valor) AS monto
                                   FROM inventario 
                                   WHERE DATE(updated_at) BETWEEN "'.$fecha_inicial.'" AND "'.$fecha_final.'"');

        $prestamo = \DB::SELECT('SELECT SUM(monto) AS monto
                                 FROM prestamo
                                 WHERE estado = "ACTIVO DESEMBOLSADO" OR estado = "LIQUIDACION" AND DATE(updated_at) BETWEEN "'.$fecha_inicial.'" AND "'.$fecha_final.'"');

        for ($i=0; $i < 12 ; $i++) { 
            $registro[$i] = 0;
            $montoFinal[$i] = 0;
            $caja[$i] = \DB::SELECT('SELECT 0 AS monto');// + $inventario[$i]->monto + $prestamo[$i]->monto;
            
        }
        
        for ($i=0; $i < 12; $i++) { 
            $registro[$i]++;
            $montoFinal[$i++] = $caja[$i]->monto;
        }
        
        dd($montoFinal);
        */

        return response()->json(["view"=>view('finanza.tbAnual')->render()]);
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

        $efectivo = \DB::SELECT('SELECT SUM(monto) AS monto, DATE(created_at) AS fecinicio
                                 FROM desembolso
                                 WHERE DATE(created_at) BETWEEN "'.$fecha_inicial.'" AND "'.$fecha_final.'" 
                                 GROUP BY DATE(created_at)');

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

        $venta = \DB::SELECT('SELECT SUM(importe - monto) AS venta, date(created_at) AS fecVenta
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

        $gastoAdmin = \DB::SELECT('SELECT SUM(monto) AS gasto, MONTH(created_at) AS created_at 
                              FROM movimiento 
                              WHERE codigo = "GA" AND (created_at BETWEEN "'.$fecha_inicial.'" AND "'.$fecha_final.'")
                              GROUP BY MONTH(created_at)');

        $pt = count($gastoAdmin);

        for($d=1;$d<=$ultimo_dia;$d++){
            $registros[$d]=0;
            $gastoAdministrativo[$d]=0;      
        }

        foreach($gastoAdmin as $ga){
            $diasel = intval($ga->created_at);
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

        //dd($registrosPrestamo);

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

        $efectivo = \DB::SELECT('SELECT sum(monto) AS monto, MONTH(created_at) AS fec
                                 FROM prestamo 
                                 WHERE DATE(created_at) BETWEEN "'.$fecha_inicial.'" AND "'.$fecha_final.'" 
                                 GROUP BY MONTH(created_at)');

        $pt = count($efectivo);

        for($m=1; $m<=12 ;$m++){
            $registros[$m]=0;
            $monto[$m]=0;      
        }

        foreach($efectivo as $ef){
            $messel = intval($ef->fec);
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

        $interes = \DB::SELECT('SELECT SUM(intpago) AS interes, MONTH(created_at) AS created_at
                                FROM pago
                                WHERE created_at BETWEEN "'.$fecha_inicial.'" AND "'.$fecha_final.'"
                                GROUP BY MONTH(created_at)');

        $pt = count($interes);

        for($m=1; $m<=12; $m++){
            $registros[$m]=0;
            $totalInteres[$m]=0;      
        }

        foreach($interes as $it){
            $messel = intval(date($it->created_at) );
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

        $mora = \DB::SELECT('SELECT SUM(mora) AS mora, MONTH(created_at) AS created_at
                                FROM pago
                                WHERE created_at BETWEEN "'.$fecha_inicial.'" AND "'.$fecha_final.'"
                                GROUP BY MONTH(created_at)');

        $pt = count($mora);

        for($m=1; $m<=12; $m++){
            $registros[$m]=0;
            $totalMoras[$m]=0;      
        }

        foreach($mora as $mo){
            $messel = intval($mo->created_at);
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

        $venta = \DB::SELECT('SELECT SUM(importe - monto) AS venta, MONTH(created_at) AS fecVenta
                             FROM movimiento 
                             WHERE codigo = "V" AND created_at BETWEEN "'.$fecha_inicial.'" AND "'.$fecha_final.'"
                             GROUP BY MONTH(created_at)');

        $pt = count($venta);

        for($m=1; $m<=12; $m++){
            $registros[$m]=0;
            $gananciaVenta[$m]=0;      
        }

        foreach($venta as $ve){
            $messel = intval($ve->fecVenta);
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

        $gastoAdmin = \DB::SELECT('SELECT SUM(monto) AS gasto, MONTH(created_at) AS created_at 
                              FROM movimiento 
                              WHERE (codigo = "GA" OR codigo ="o") AND (created_at BETWEEN "'.$fecha_inicial.'" AND "'.$fecha_final.'")
                              GROUP BY MONTH(created_at)');
                                  
        //dd($gastoAdmin);

        $pt = count($gastoAdmin);

        for($m=1; $m<=12; $m++){
            $registros[$m]=0;
            $gastosAdministrativos[$m]=0;      
        }

        foreach($gastoAdmin as $ga){
            $messel = intval($ga->created_at);
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
