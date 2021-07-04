<?php
    
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Prestamo;
use App\Pago;
use App\Caja;
use App\Movimiento;
use App\Casillero;
use App\Notificacion;
use App\PrestamoDocumento;
use App\Documento;
use App\proceso;
use App\Cliente;
use Storage;
use Illuminate\Support\Facades\Auth;

class CobranzaController extends Controller
{   
    /**
     * Display a listing of the resource.d
     *
     * @return \Illuminate\Http\Response
     */
    public function atraso()
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

        $listAtrasos = \DB::SELECT('SELECT p.id AS prestamo_id, cl.nombre, cl.apellido, cl.dni, g.nombre AS garantia, p.fecfin, DATEDIFF(CURDATE(), p.fecinicio) AS dia, p.monto, p.intpagar, p.estado, cl.facebook, cl.whatsapp, cl.correo, cl.telefono, m.mora, cl.referencia, p.fecinicio, cl.id AS cliente_id
                                      FROM prestamo p, cotizacion c, cliente cl, garantia g, mora m
                                      WHERE p.cotizacion_id = c.id AND c.cliente_id = cl.id AND c.garantia_id = g.id AND DATEDIFF(CURDATE(), p.fecinicio) > 30 AND p.estado = "ACTIVO DESEMBOLSADO" AND p.mora_id = m.id AND p.sede_id = "'.$usuario[0]->sede.'"');


        return view('cobranza.atraso', compact('usuario', 'listAtrasos', 'notificacion', 'cantNotificaciones'));
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

        $cajaChica = \DB::SELECT('SELECT * FROM tipocaja WHERE codigo = "cc"');
        $cajaGrande = \DB::SELECT('SELECT * FROM tipocaja WHERE codigo = "cg"');
        $banco = \DB::SELECT('SELECT * FROM tipocaja WHERE codigo = "bn"');
 
        $idMax = \DB::SELECT('SELECT MAX(id) AS id FROM caja WHERE estado = "abierta" AND tipocaja_id = "'.$cajaChica[0]->id.'" AND sede_id = "'.$usuario[0]->sede.'"'); //Maximo ID de la caja abierta
        if ($idMax[0]->id == null) { // Verifica si la caja está existe o no existe ninguna caja
            $ver = "1";
            $caja = \DB::SELECT('SELECT "0.00" AS monto');
        }else {
            $ver = "0";
            $caja = \DB::SELECT('SELECT * FROM caja WHERE id = "'.$idMax[0]->id.'" AND sede_id = "'.$usuario[0]->sede.'"');
        }

        $idMaxCg = \DB::SELECT('SELECT MAX(id) AS id FROM caja WHERE estado = "abierta" AND tipocaja_id = "'.$cajaGrande[0]->id.'" AND sede_id = "'.$usuario[0]->sede.'"'); //Maximo ID de la caja abierta
        if ($idMaxCg[0]->id == null) { // Verifica si la caja está existe o no existe ninguna caja
            $ver = "1";
            $cajaGrande = \DB::SELECT('SELECT "0.00" AS monto');
        }else {
            $ver = "0";
            $cajaGrande = \DB::SELECT('SELECT * FROM caja WHERE id = "'.$idMaxCg[0]->id.'" AND sede_id = "'.$usuario[0]->sede.'"');
        }

        //Banco de la nacion
        $idMaxB = \DB::SELECT('SELECT MAX(id) AS id FROM caja WHERE estado = "abierta" AND tipocaja_id = "'.$banco[0]->id.'" AND sede_id = "'.$usuario[0]->sede.'"'); //Maximo ID de la caja abierta
        if ($idMaxB[0]->id == null) { // Verifica si la caja está existe o no existe ninguna caja
            $ver = "1";
            $banco = \DB::SELECT('SELECT "0.00" AS monto');
        }else {
            $ver = "0";
            $banco = \DB::SELECT('SELECT * FROM caja WHERE id = "'.$idMaxB[0]->id.'" AND sede_id = "'.$usuario[0]->sede.'"');
        }

        //Banco de Creditos
        $bcp = \DB::SELECT('SELECT * FROM tipocaja WHERE codigo = "bcp"');
        $idBcp = \DB::SELECT('SELECT MAX(id) AS id FROM caja WHERE estado = "abierta" AND tipocaja_id = "'.$bcp[0]->id.'" AND sede_id = "'.$usuario[0]->sede.'"'); //Maximo ID de la caja abierta
        if ($idBcp[0]->id == null) { // Verifica si la caja está existe o no existe ninguna caja
            $ver = "1";
            $bcp = \DB::SELECT('SELECT "0.00" AS monto');
        }else {
            $ver = "0";
            $bcp = \DB::SELECT('SELECT * FROM caja WHERE id = "'.$idBcp[0]->id.'" AND sede_id = "'.$usuario[0]->sede.'"');
        }

        //Interbank
        $interbank = \DB::SELECT('SELECT * FROM tipocaja WHERE codigo = "i"');
        $idInterbank = \DB::SELECT('SELECT MAX(id) AS id FROM caja WHERE estado = "abierta" AND tipocaja_id = "'.$interbank[0]->id.'" AND sede_id = "'.$usuario[0]->sede.'"'); //Maximo ID de la caja abierta
        if ($idInterbank[0]->id == null) { // Verifica si la caja está existe o no existe ninguna caja
            $ver = "1";
            $interbank = \DB::SELECT('SELECT "0.00" AS monto');
        }else {
            $ver = "0";
            $interbank = \DB::SELECT('SELECT * FROM caja WHERE id = "'.$idInterbank[0]->id.'" AND sede_id = "'.$usuario[0]->sede.'"');
        }

        $ingreso = \DB::SELECT('SELECT m.*, cl.nombre AS nombreCl, cl.apellido AS apellidoCl, e.nombre AS nombreEm, e.apellido AS apellidoEm
                                FROM movimiento m, caja c, prestamo p, cotizacion co, cliente cl, empleado e
                                WHERE m.caja_id = c.id AND m.codprestamo = p.id AND p.cotizacion_id = co.id AND m.empleado = e.id AND co.cliente_id = cl.id AND m.tipo = "INGRESO" AND c.estado = "ABIERTA" AND c.sede_id = "'.$usuario[0]->sede.'" AND DATE(m.created_at) = CURDATE()
                                ORDER BY m.created_at DESC');//Muestra los ingresos de la caja abierta actualmente

        $cantIngreso = \DB::SELECT('SELECT SUM(m.importe) monto
                                    FROM movimiento m, caja c, prestamo p, cotizacion co, cliente cl, empleado e
                                    WHERE m.caja_id = c.id AND m.codprestamo = p.id AND p.cotizacion_id = co.id AND m.empleado = e.id AND co.cliente_id = cl.id AND m.tipo = "INGRESO" AND c.estado = "ABIERTA" AND c.sede_id = "'.$usuario[0]->sede.'" AND DATE(m.created_at) = CURDATE()');        

        if ($cantIngreso == null) {
            $cantIngreso = \DB::SELECT('SELECT "0.00" AS monto');
        }

        $egreso = \DB::SELECT('SELECT m.*, cl.nombre AS nombreCl, cl.apellido AS apellidoCl, e.nombre AS nombreEm, e.apellido AS apellidoEm
                               FROM movimiento m, caja c, prestamo p, cotizacion co, cliente cl, empleado e
                               WHERE m.caja_id = c.id AND m.codprestamo = p.id AND p.cotizacion_id = co.id AND m.empleado = e.id AND co.cliente_id = cl.id AND m.tipo = "EGRESO" AND c.estado = "ABIERTA" AND c.sede_id = "'.$usuario[0]->sede.'" AND DATE(m.created_at) = CURDATE()
                               ORDER BY m.created_at DESC');//Muestra los egresos de la caja abierta actualmente

        $cantEgreso = \DB::SELECT('SELECT SUM(m.monto) monto
                                   FROM movimiento m, caja c, prestamo p, cotizacion co, cliente cl, empleado e
                                   WHERE m.caja_id = c.id AND m.codprestamo = p.id AND p.cotizacion_id = co.id AND m.empleado = e.id AND co.cliente_id = cl.id AND m.tipo = "EGRESO" AND c.estado = "ABIERTA" AND c.sede_id = "'.$usuario[0]->sede.'"  AND DATE(m.created_at) = CURDATE()');

        if($cantEgreso == null) {
            $cantEgreso = \DB::SELECT('SELECT "0.00" AS monto'); 
        }

        $controlCaja = \DB::SELECT('SELECT * FROM caja WHERE ESTADO = "CERRADA" AND sede_id = "'.$usuario[0]->sede.'"');
 
        return view('cobranza.caja',compact('ver', 'caja', 'ingreso', 'egreso', 'usuario', 'controlCaja', 'notificacion', 'cantNotificaciones', 'cajaGrande', 'banco', 'cantIngreso', 'cantEgreso', 'bcp', 'interbank'));
        
    }

    public function detalleCajaDia(Request $request)
    {
        $id = $request->id;

        $ingresoCd = \DB::SELECT('SELECT m.*, cl.nombre AS nombreCl, cl.apellido AS apellidoCl, e.nombre AS nombreEm, e.apellido AS apellidoEm
                                  FROM movimiento m, caja c, prestamo p, cotizacion co, cliente cl, empleado e
                                  WHERE m.caja_id = c.id AND m.codprestamo = p.id AND p.cotizacion_id = co.id AND m.empleado = e.id AND co.cliente_id = cl.id AND m.tipo = "INGRESO" AND c.estado = "CERRADA" AND caja_id = "'.$id.'"');//Muestra los ingresos de la caja abierta actualmente

        $egresoCd = \DB::SELECT('SELECT m.*, cl.nombre AS nombreCl, cl.apellido AS apellidoCl, e.nombre AS nombreEm, e.apellido AS apellidoEm
                                 FROM movimiento m, caja c, prestamo p, cotizacion co, cliente cl, empleado e
                                 WHERE m.caja_id = c.id AND m.codprestamo = p.id AND p.cotizacion_id = co.id AND m.empleado = e.id AND co.cliente_id = cl.id AND m.tipo = "EGRESO" AND c.estado = "CERRADA" AND caja_id = "'.$id.'"');//Muestra los egresos de la caja abierta actualmente

        return response()->json(["view"=>view('cobranza.divDetalleCaja',compact('ingresoCd', 'egresoCd'))->render()]);
    } 

    public function buscarFechaDiaCaja(Request $request){
        $FechaInicio = $request->FechaInicio;
        $FechaFin = $request->FechaFin;

        $controlCaja = \DB::SELECT('SELECT * FROM caja WHERE ESTADO = "CERRADA" AND created_at BETWEEN "'.$FechaInicio.'" AND "'.$FechaFin.'"');

        $montoIni = \DB::SELECT('SELECT SUM(monto) AS MontoInicial FROM caja WHERE ESTADO = "CERRADA" AND created_at BETWEEN "'.$FechaInicio.'" AND "'.$FechaFin.'"');

        $montoFin = \DB::SELECT('SELECT SUM(montofin) AS MontoFinal FROM caja WHERE ESTADO = "CERRADA" AND created_at BETWEEN "'.$FechaInicio.'" AND "'.$FechaFin.'"');

        $variacion = $montoFin[0]->MontoFinal - $montoIni[0]->MontoInicial;

        return response()->json(["view"=>view('cobranza.divCajaDia',compact('controlCaja', 'variacion'))->render()]);
    }

    public function buscarFechaMesCaja(Request $request){
        $FechaInicio = $request->FechaInicio;
        $FechaFin = $request->FechaFin;
    }

    public function buscarDepositoCliente(Request $request){
        $datoCliente = $request->cliente;
        
        $cliente = \DB::SELECT('SELECT p.id AS prestamo_id, p.monto, p.fecinicio, p.fecfin, p.total, cl.id AS cliente_id, cl.nombre, cl.apellido, cl.dni, g.nombre AS garantia, p.intpagar, m.mora AS morapagar, i.porcentaje
                                FROM prestamo p, cotizacion c, cliente cl, garantia g, mora m, tipocredito_interes tci, interes i
                                WHERE c.cliente_id = cl.id AND p.cotizacion_id = c.id AND c.garantia_id = g.id AND p.mora_id = m.id AND p.estado = "ACTIVO DESEMBOLSADO" AND p.tipocredito_interes_id = tci.id AND tci.interes_id = i.id AND (cl.nombre LIKE "%'.$datoCliente.'%" OR cl.apellido LIKE "%'.$datoCliente.'%" OR cl.dni LIKE "%'.$datoCliente.'%")
                                ORDER BY p.fecfin ASC');

        return response()->json(["view"=>view('cobranza.listDepositoCliente',compact('cliente'))->render()]);
    }

    public function notificar()
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

        $listTipoArch = \DB::SELECT('SELECT * FROM tipodocumento');

        $listNotificar = \DB::SELECT('SELECT p.id AS prestamo_id, cl.nombre, cl.apellido, cl.dni, g.nombre AS garantia, p.fecfin, DATEDIFF(CURDATE(), p.fecinicio) AS dia, p.monto, p.intpagar, p.estado, cl.facebook, cl.whatsapp, cl.correo, cl.telefono, m.mora, cl.referencia, p.fecinicio, i.porcentaje, cl.id AS cliente_id
                                      FROM prestamo p, cotizacion c, cliente cl, garantia g, mora m, tipocredito_interes tci, interes i
                                      WHERE p.cotizacion_id = c.id AND c.cliente_id = cl.id AND c.garantia_id = g.id AND DATEDIFF(CURDATE(), p.fecinicio) > 24 AND p.estado = "ACTIVO DESEMBOLSADO" AND p.mora_id = m.id AND tci.id = p.tipocredito_interes_id AND tci.interes_id = i.id AND p.sede_id = "'.$usuario[0]->sede.'"
                                      ORDER BY DATEDIFF(NOW(), p.fecinicio) DESC');

        $countNotificar = \DB::SELECT('SELECT COUNT(p.id) AS cantidad
                                       FROM prestamo p, cotizacion c, cliente cl, garantia g, mora m, tipocredito_interes tci, interes i
                                       WHERE p.cotizacion_id = c.id AND c.cliente_id = cl.id AND c.garantia_id = g.id AND DATEDIFF(CURDATE(), p.fecinicio) > 24 AND p.estado = "ACTIVO DESEMBOLSADO" AND p.mora_id = m.id AND tci.id = p.tipocredito_interes_id AND tci.interes_id = i.id AND p.sede_id = "'.$usuario[0]->sede.'"');

        return view('cobranza.notificar', compact('listNotificar', 'usuario', 'notificacion', 'cantNotificaciones', 'listTipoArch', 'countNotificar'));
    }

    public function pasarLiquidacion(Request $request)
    {
        $prestamos = \DB::SELECT('SELECT p.id AS prestamo_id, DATEDIFF(CURDATE(), p.fecinicio) AS dia
                                  FROM prestamo p
                                  WHERE p.estado = "ACTIVO DESEMBOLSADO" AND DATEDIFF(CURDATE(), p.fecinicio) > 59');

        for ($i=0; $i < COUNT($prestamos); $i++) { 
            $pre = Prestamo::where('id', '=', $prestamos[$i]->prestamo_id)->first();
            $pre->estado = "LIQUIDACION";
            $pre->save();
        }

        $listNotificar = \DB::SELECT('SELECT p.id AS prestamo_id, cl.nombre, cl.apellido, cl.dni, g.nombre AS garantia, p.fecfin, DATEDIFF(CURDATE(), p.fecinicio) AS dia, p.monto, p.intpagar, p.estado, cl.facebook, cl.whatsapp, cl.correo, cl.telefono, m.mora, cl.referencia, p.fecinicio, i.porcentaje
                                      FROM prestamo p, cotizacion c, cliente cl, garantia g, mora m, tipocredito_interes tci, interes i
                                      WHERE p.cotizacion_id = c.id AND c.cliente_id = cl.id AND c.garantia_id = g.id AND DATEDIFF(CURDATE(), p.fecinicio) > 24 AND p.estado = "ACTIVO DESEMBOLSADO" AND p.mora_id = m.id AND tci.id = p.tipocredito_interes_id AND tci.interes_id = i.id 
                                      ORDER BY p.fecfin ASC');

        return response()->json(["view"=>view('cobranza.listNotificar',compact('listNotificar'))->render()]);
    }
    

    public function busquedaClienteNotifi(Request $request)
    {
        $dato = $request->datoCliente; 
        
        $listNotificar = \DB::SELECT('SELECT p.id AS prestamo_id, cl.nombre, cl.apellido, cl.dni, g.nombre AS garantia, p.fecfin, DATEDIFF(CURDATE(), p.fecinicio) AS dia, p.monto, p.intpagar, p.estado, cl.facebook, cl.whatsapp, cl.correo, cl.telefono, m.mora, cl.referencia, p.fecinicio, i.porcentaje, cl.id AS cliente_id
                                      FROM prestamo p, cotizacion c, cliente cl, garantia g, mora m, tipocredito_interes tci, interes i
                                      WHERE p.cotizacion_id = c.id AND c.cliente_id = cl.id AND c.garantia_id = g.id AND DATEDIFF(CURDATE(), p.fecinicio) > 24 AND p.estado = "ACTIVO DESEMBOLSADO" AND p.mora_id = m.id AND tci.id = p.tipocredito_interes_id AND tci.interes_id = i.id  AND (cl.nombre LIKE "%'.$dato.'%" OR cl.apellido LIKE "%'.$dato.'%" OR cl.dni LIKE "%'.$dato.'%") 
                                      ORDER BY DATEDIFF(NOW(), p.fecinicio) DESC');

        return response()->json(["view"=>view('cobranza.listNotificar',compact('listNotificar'))->render()]);
    }

    public function pago()
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

        $prestamo = \DB::SELECT('SELECT p.id AS prestamo_id, p.monto, p.fecinicio, p.fecfin, p.total, cl.id AS cliente_id, cl.nombre, cl.apellido, cl.dni, g.nombre AS garantia, p.intpagar, m.mora AS morapagar, i.porcentaje
                                 FROM prestamo p, cotizacion c, cliente cl, garantia g, mora m, tipocredito_interes tci, interes i
                                 WHERE c.cliente_id = cl.id AND p.cotizacion_id = c.id AND c.garantia_id = g.id AND p.mora_id = m.id AND p.estado = "ACTIVO DESEMBOLSADO" AND p.tipocredito_interes_id = tci.id AND tci.interes_id = i.id
                                 ORDER BY DATEDIFF(NOW(), p.fecinicio) DESC');

        $cantPrestamo = \DB::SELECT('SELECT COUNT(*) AS cantidad FROM prestamo WHERE estado = "ACTIVO DESEMBOLSADO"');

        return view('cobranza.pago', compact('prestamo', 'usuario' ,'cantPrestamo', 'notificacion', 'cantNotificaciones'));
    }

    public function buscarClientePago(Request $request)
    {

        $prestamo = \DB::SELECT('SELECT p.id AS prestamo_id, p.monto, p.fecinicio, p.fecfin, p.total, cl.id AS cliente_id, cl.nombre, cl.apellido, cl.dni, g.nombre AS garantia, p.intpagar, m.mora AS morapagar, i.porcentaje
                                 FROM prestamo p, cotizacion c, cliente cl, garantia g, mora m, tipocredito_interes tci, interes i
                                 WHERE c.cliente_id = cl.id AND p.cotizacion_id = c.id AND c.garantia_id = g.id AND p.mora_id = m.id AND p.estado = "ACTIVO DESEMBOLSADO" AND p.tipocredito_interes_id = tci.id AND tci.interes_id = i.id AND (cl.nombre LIKE "%'.$request->dato.'%" OR cl.apellido LIKE "%'.$request->dato.'%" OR cl.dni LIKE "%'.$request->dato.'%") ORDER BY DATEDIFF(NOW(), p.fecinicio) DESC');

        return response()->json(["view"=>view('cobranza.tabCliente',compact('prestamo'))->render()]);
    }

    public function renovar()
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

        $prestamo = \DB::SELECT('SELECT p.id AS prestamo_id, p.monto, p.fecinicio, p.fecfin, p.total, cl.id AS cliente_id, cl.nombre, cl.apellido, cl.dni, g.nombre AS garantia, p.intpagar, m.mora AS morapagar, i.porcentaje
                                 FROM prestamo p, cotizacion c, cliente cl, garantia g, mora m, tipocredito_interes tci, interes i
                                 WHERE c.cliente_id = cl.id AND p.cotizacion_id = c.id AND c.garantia_id = g.id AND p.mora_id = m.id AND p.estado = "ACTIVO DESEMBOLSADO" AND p.tipocredito_interes_id = tci.id AND tci.interes_id = i.id AND p.codigo = "R"
                                 ORDER BY p.fecfin ASC');

        return view('cobranza.renovar', compact('prestamo', 'usuario', 'notificacion', 'cantNotificaciones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function printTicket()
    {
        $idPago = \DB::SELECT('SELECT MAX(id) AS id FROM pago');

        $pago = \DB::SELECT('SELECT CONCAT(cl.nombre, " ", cl.apellido) AS cliente, cl.dni, p.id AS prestamo_id, g.nombre AS garantia, CONCAT(ca.nombre, " - ", s.nombre, " - ", a.nombre) AS almacen, p.monto AS montoPrestamo, pa.intpago AS interes, pa.mora AS mora, (p.monto + pa.intpago + pa.mora) AS total, pa.importe AS importe, ((p.monto + pa.intpago + pa.mora) - pa.importe) as restante, p.fecinicio
                             FROM prestamo p, cotizacion c, cliente cl, garantia g, garantia_casillero gc, casillero ca, stand s, almacen a, pago pa, mora m
                             WHERE p.cotizacion_id = c.id AND c.cliente_id = cl.id AND c.garantia_id = g.id AND gc.garantia_id = g.id AND gc.casillero_id = ca.id AND ca.stand_id = s.id AND s.almacen_id = a.id AND pa.prestamo_id = p.id AND p.mora_id = m.id AND pa.id = "'.$idPago[0]->id.'"');
                             
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
        $idPrestamo = $request->idPrestamo;
        $importe = $request->importe; //Cantidad recibida en físco
        $pago = $request->importeMonto; //Cantidad a cobrar segun indicado por el cliente
        $monto = $request->monto;
        $dias = $request->dia;
        $mora = $request->mora;
        $interes = $request->interes;
        $res = 0; //Codigo Inicial
        $conError = "";
        
        $prestamo = \DB::SELECT('SELECT *
                                 FROM prestamo p
                                 WHERE p.id = "'.$idPrestamo.'"');

        $tipocaja = \DB::SELECT('SELECT * 
                                 FROM tipocaja 
                                 WHERE tipo = "caja chica"');
        $caja = \DB::SELECT('SELECT MAX(id) AS id 
                             FROM caja 
                             WHERE estado = "ABIERTA" AND tipocaja_id = "'.$tipocaja[0]->id.'" AND sede_id = "'.$prestamo[0]->sede_id.'"');

        $users_id = Auth::user()->id;
        $empleado = \DB::SELECT('SELECT e.id AS id FROM empleado e WHERE e.users_id = "'.$users_id.'"');
        $empleado_id = $empleado[0]->id;

        $garantia = \DB::SELECT('SELECT g.* FROM prestamo p
                                 INNER JOIN cotizacion c ON p.cotizacion_id = c.id
                                 INNER JOIN garantia g ON c.garantia_id = g.id
                                 WHERE p.id = "'.$idPrestamo.'"');

        $totalPago = $mora + $interes + $monto;

        $maxCaja = \DB::SELECT('SELECT id, monto 
                                FROM caja 
                                WHERE id = "'.$caja[0]->id.'"');

        $cliente = \DB::SELECT('SELECT cl.id AS cliente_id, cl.evaluacion
                                FROM prestamo p, cotizacion c, cliente cl
                                WHERE p.cotizacion_id = c.id AND cl.id = c.cliente_id AND p.id = "'.$idPrestamo.'"');

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
                $pag->empleado_id = $empleado_id;
                $pag->sede_id = $prestamo[0]->sede_id;
                if ($pag->save()) {

                    $pag = \DB::SELECT('SELECT MAX(id) AS id FROM pago');

                    $mov = new Movimiento();
                    $mov->codigo = "N";
                    $mov->serie = "cc";
                    $mov->estado = "ACTIVO";
                    $mov->monto = $monto; //Aqui debe guardar el importe
                    $mov->concepto = "EFECTIVO - CANCELACIÓN ".$idPrestamo;
                    $mov->tipo = "INGRESO";
                    $mov->empleado = $empleado_id;
                    $mov->importe = $pago;
                    $mov->codprestamo = $idPrestamo;
                    $mov->condesembolso = $pag[0]->id;
                    $mov->codgarantia = $garantia[0]->id;
                    $mov->garantia = $garantia[0]->nombre;
                    $mov->interesPagar = $interes;
                    $mov->moraPagar = $mora;
                    $mov->caja_id = $caja[0]->id;
                    if ($mov->save()) {

                        $garantia_casillero = \DB::SELECT('SELECT casillero_id FROM garantia_casillero WHERE garantia_id = "'.$garantia[0]->id.'"');

                        $cas = Casillero::where('id', '=',  $garantia_casillero[0]->casillero_id)->first();
                        $cas->estado = "RECOGER";
                        if ($cas->save()) {

                            $tipocaja = \DB::SELECT('SELECT * FROM tipocaja WHERE codigo = "cc"');
                            $maxCaja = \DB::SELECT('SELECT MAX(id) AS id, monto FROM caja WHERE estado = "abierta" AND tipocaja_id = "'.$tipocaja[0]->id.'" GROUP BY id');
                            
                            $nuevoMonto = proceso::actualizarCaja($maxCaja[0]->monto, $pago, 2);

                            $caja = Caja::where('id', '=', $maxCaja[0]->id)->first();
                            $caja->monto = $nuevoMonto;
                            if ($caja->save()) {

                                $nuevaEvaluacio = $cliente[0]->evaluacion + 30;
                                if ( $nuevaEvaluacio >= 100) {
                                    $nuevaEvaluacio = 100;
                                }
                                
                                $cli = Cliente::where('id', '=', $cliente[0]->cliente_id)->first();
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
                $pag->empleado_id = $empleado_id;
                $pag->sede_id = $prestamo[0]->sede_id;
                if ($pag->save()) {
                    
                    $pag = \DB::SELECT('SELECT MAX(id) AS id FROM pago');

                    $mov = new Movimiento();
                    $mov->codigo = "N";
                    $mov->serie = "cc";
                    $mov->estado = "ACTIVO";
                    $mov->monto = $monto;
                    $mov->concepto = "EFECTIVO - AMORTIZACIÓN ".$idPrestamo;
                    $mov->tipo = "INGRESO";
                    $mov->empleado = $empleado_id;
                    $mov->importe = $pago;
                    $mov->codprestamo = $idPrestamo;
                    $mov->condesembolso = $pag[0]->id;
                    $mov->codgarantia = $garantia[0]->id;
                    $mov->garantia = $garantia[0]->nombre;
                    $mov->interesPagar = $interes;
                    $mov->moraPagar = $mora;
                    $mov->caja_id = $caja[0]->id;
                    if ($mov->save()) {

                        $tipocaja = \DB::SELECT('SELECT * FROM tipocaja WHERE codigo = "cc"');
                        $maxCaja = \DB::SELECT('SELECT MAX(id) AS id, monto FROM caja WHERE estado = "abierta" AND tipocaja_id = "'.$tipocaja[0]->id.'" GROUP BY id');

                        $nuevoMonto = proceso::actualizarCaja($maxCaja[0]->monto, $pago, 2);

                        $caja = Caja::where('id', '=', $maxCaja[0]->id)->first();
                        $caja->monto = $nuevoMonto;
                        if ($caja->save()) {

                            $nuevaEvaluacio = $cliente[0]->evaluacion + 15;

                            if ( $nuevaEvaluacio >= 100) {
                                $nuevaEvaluacio = 100;
                            }

                            $cli = Cliente::where('id', '=', $cliente[0]->cliente_id)->first();
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

        $prestamo =\DB::SELECT('SELECT p.id AS prestamo_id, p.monto, p.fecinicio, p.fecfin, p.total, cl.id AS cliente_id, cl.nombre, cl.apellido, cl.dni, g.nombre AS garantia, p.intpagar, m.mora AS morapagar, i.porcentaje
                                FROM prestamo p, cotizacion c, cliente cl, garantia g, mora m, tipocredito_interes tci, interes i
                                WHERE c.cliente_id = cl.id AND p.cotizacion_id = c.id AND c.garantia_id = g.id AND p.mora_id = m.id AND p.estado = "ACTIVO DESEMBOLSADO" AND p.tipocredito_interes_id = tci.id AND tci.interes_id = i.id
                                ORDER BY p.fecfin ASC');

        return response()->json(["view"=>view('cobranza.tabCliente',compact('prestamo'))->render(), "res" => $res, "conError" => $conError]);
    }

    public function renovarPrestamo(Request $request)
    {
        $users_id = Auth::user()->id;
        $idPrestamo = $request->idPrestamo;
        $pago = $request->importe; 
        $monto = $request->monto;
        $dias = $request->dia;
        $mora = $request->mora;
        $interes = $request->interes;
        $pagoMinimo = $mora + $interes;
        $totalPago = $pagoMinimo + $monto;
        $prestamo = \DB::SELECT('SELECT *
                                 FROM prestamo p
                                 WHERE p.id = "'.$idPrestamo.'"');
        $tipocaja = \DB::SELECT('SELECT * 
                                 FROM tipocaja 
                                 WHERE codigo = "cc"');
        $empleado = \DB::SELECT('SELECT e.id AS id, e.sede_id AS sede_id
                                 FROM empleado e 
                                 WHERE e.users_id = "'.$users_id.'"');
        $empleado_id = $empleado[0]->id;
        $caja = \DB::SELECT('SELECT MAX(id) AS id, monto
                             FROM caja 
                             WHERE estado = "ABIERTA" AND tipocaja_id = "'.$tipocaja[0]->id.'"');
        $garantia = \DB::SELECT('SELECT g.* FROM prestamo p
                                INNER JOIN cotizacion c ON p.cotizacion_id = c.id
                                INNER JOIN garantia g ON c.garantia_id = g.id
                                WHERE p.id = "'.$idPrestamo.'"');

        $fechaInicio = $prestamo[0]->fecinicio;
        $nuevaFechaInicio = date("Y-m-d", strtotime($fechaInicio."+ 1 month"));
        $fechaFin = $prestamo[0]->fecfin;
        $nuevaFechaFin = date("Y-m-d", strtotime($fechaFin."+1 month"));

        $cliente = \DB::SELECT('SELECT cl.id AS cliente_id, cl.evaluacion
                                FROM prestamo p, cotizacion c, cliente cl
                                WHERE p.cotizacion_id = c.id AND cl.id = c.cliente_id AND p.id = "'.$idPrestamo.'"');



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
            $pre->empleado_id = $empleado[0]->id;
            $pre->sede_id = $prestamo[0]->sede_id;
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
                    $pag->empleado_id = $empleado[0]->id;
                    $pag->sede_id = $empleado[0]->sede_id;
                    if ($pag->save()) {
                        
                        $pag = \DB::SELECT('SELECT MAX(id) AS id FROM pago');
                        $des = \DB::SELECT('SELECT id FROM desembolso WHERE prestamo_id = "'.$idPrestamo.'"');

                        $mov = new Movimiento();
                        $mov->codigo = "R";
                        $mov->serie = "cc";
                        $mov->estado = "ACTIVO";
                        $mov->monto = $pago;
                        $mov->concepto = "EFECTIVO RENOVACION-".$idPrestamo;
                        $mov->tipo = "INGRESO";
                        $mov->empleado = $empleado[0]->id;
                        $mov->importe = $pago;
                        $mov->codprestamo = $idPrestamo;
                        $mov->condesembolso = $pag[0]->id;
                        $mov->codgarantia = $garantia[0]->id;
                        $mov->garantia = $garantia[0]->nombre;
                        $mov->interesPagar = $interes;
                        $mov->moraPagar = $mora;
                        $mov->caja_id = $caja[0]->id;
                        if ($mov->save()) {

                            $tipocaja = \DB::SELECT('SELECT * FROM tipocaja WHERE codigo = "cc"');
                            $maxCaja = \DB::SELECT('SELECT MAX(id) AS id, monto FROM caja WHERE estado = "abierta" AND tipocaja_id = "'.$tipocaja[0]->id.'"');
                            
                            $nuevoMonto = proceso::actualizarCaja($maxCaja[0]->monto, $pago, 2);

                            $caja = Caja::where('id', '=', $caja[0]->id)->first();
                            $caja->monto = $nuevoMonto;

                            if ($caja->save()) {

                                $nuevaEvaluacio = $cliente[0]->evaluacion + 5;

                                if ( $nuevaEvaluacio >= 100) {
                                    $nuevaEvaluacio = 100;
                                }
                                
                                $cli = Cliente::where('id', '=', $cliente[0]->cliente_id)->first();
                                $cli->evaluacion = $nuevaEvaluacio;
                                $cli->save();

                                $aux = 1;

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
            $pre->empleado_id = $empleado[0]->id;
            $pre->sede_id = $prestamo[0]->sede_id;
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
                    $pag->empleado_id = $empleado[0]->id;
                    $pag->sede_id = $empleado[0]->sede_id;
                    if ($pag->save()) {
                        
                        $pag = \DB::SELECT('SELECT MAX(id) AS id FROM pago');
                        $des = \DB::SELECT('SELECT id FROM desembolso WHERE id = "'.$idPrestamo.'"');

                        $mov = new Movimiento();
                        $mov->codigo = "R";
                        $mov->serie = "cc";
                        $mov->estado = "ACTIVO";
                        $mov->monto = $pago;
                        $mov->concepto = "EFECTIVO RENOVACION-".$idPrestamo;
                        $mov->tipo = "INGRESO";
                        $mov->empleado = $empleado[0]->id;
                        $mov->importe = $pago;
                        $mov->codprestamo = $idPrestamo;
                        $mov->condesembolso = $pag[0]->id;
                        $mov->codgarantia = $garantia[0]->id;
                        $mov->garantia = $garantia[0]->nombre;
                        $mov->interesPagar = $interes;
                        $mov->moraPagar = $mora;
                        $mov->caja_id = $caja[0]->id;
                        if ($mov->save()) {

                            $tipocaja = \DB::SELECT('SELECT * FROM tipocaja WHERE codigo = "cc"');
                            $maxCaja = \DB::SELECT('SELECT MAX(id) AS id, monto FROM caja WHERE estado = "abierta" AND tipocaja_id = "'.$tipocaja[0]->id.'"');
                            
                            $nuevoMonto = proceso::actualizarCaja($maxCaja[0]->monto, $pago, 2);

                            $caja = Caja::where('id', '=', $caja[0]->id)->first();
                            $caja->monto = $nuevoMonto;
                            if ($caja->save()) {

                                $nuevaEvaluacio = $cliente[0]->evaluacion + 5;

                                if ( $nuevaEvaluacio >= 100) {
                                    $nuevaEvaluacio = 100;
                                }
                                
                                $cli = Cliente::where('id', '=', $cliente[0]->cliente_id)->first();
                                $cli->evaluacion = $nuevaEvaluacio;
                                $cli->save();
                                
                                $aux = "1";
                            }
                        }
                    }
                }
            }
        }else {
            $aux = "2";
        }

        $prestamo = \DB::SELECT('SELECT p.id AS prestamo_id, p.monto, p.fecinicio, p.fecfin, p.total, cl.id AS cliente_id, cl.nombre, cl.apellido, cl.dni, g.nombre AS garantia, p.intpagar, m.mora AS morapagar, i.porcentaje
                                 FROM prestamo p, cotizacion c, cliente cl, garantia g, mora m, tipocredito_interes tci, interes i
                                 WHERE c.cliente_id = cl.id AND p.cotizacion_id = c.id AND c.garantia_id = g.id AND p.mora_id = m.id AND p.estado = "ACTIVO DESEMBOLSADO" AND p.tipocredito_interes_id = tci.id AND tci.interes_id = i.id
                                 ORDER BY p.fecfin ASC');

        return response()->json(["view"=>view('cobranza.tabCliente',compact('prestamo', 'aux'))->render()]);
    }

    public function abrirCaja(Request $request)
    {
        $estado = "abierta";
        $fecinicio = date('Y-m-a');
        $montoInicio = $request->montoInicial;
        $users_id = "1";

        $caja = new Caja();
        $caja->estado = $estado;
        $caja->fecinicio = date('Y-m-a');
        $caja->montoinicio = $montoInicio;
        $caja->users_id = $users_id;
        if ($caja->save()) {
            $respuesta = "Caja Generada";
            $idMax = \DB::SELECT('SELECT MAX(id) AS id FROM caja WHERE estado = "abierta"');
            if ($idMax[0]->id == null) {
                $ver = "1";
                $caja = \DB::SELECT('SELECT * FROM caja WHERE id = "'.$idMax[0]->id.'"');
            }else {
                $ver = "0";
                $caja = \DB::SELECT('SELECT * FROM caja WHERE id = "'.$idMax[0]->id.'"');
            }
            return response()->json(["view"=>view('cobranza.genCaja',compact('ver', 'caja'))->render()]);
        }
    }

    public function abrirCajaHome(Request $request)
    {
        $estado = "abierta";
        $fecinicio = date('Y-m-a');
        $horaInicio = date('h:i:s A');
        $montoInicio = $request->monto;
        $users_id = Auth::user()->id;
        $empleado = \DB::SELECT('SELECT e.id AS id 
                                 FROM empleado e 
                                 WHERE e.users_id = "'.$users_id.'"');
        $empleado_id = $empleado[0]->id;
        $tipocaja = \DB::SELECT('SELECT id 
                                 FROM tipocaja 
                                 WHERE codigo = "cc"');
        $sede = \DB::SELECT('SELECT sede_id 
                             FROM empleado 
                             WHERE users_id = "'.$users_id.'"');

        $caja = new Caja();
        $caja->estado = $estado;
        $caja->monto = $montoInicio;
        $caja->fecha = date('Y-m-a');
        $caja->inicio = $horaInicio;
        $caja->empleado = $empleado_id;
        $caja->sede_id = $sede[0]->sede_id;
        $caja->tipocaja_id = $tipocaja[0]->id;

        if ($caja->save()) {
            $resp = "Caja Inicializada";
            return response()->json(['resp'=>$resp]);
        }
    }

    public function crearCaja(Request $request) 
    {
        $estado = "abierta";
        $fecinicio = date('Y-m-a');
        $horaInicio = date('h:i:s A');
        $montoInicio = $request->monto;
        $users_id = Auth::user()->id;
        $empleado = \DB::SELECT('SELECT e.id AS id 
                                 FROM empleado e 
                                 WHERE e.users_id = "'.$users_id.'"');
        $empleado_id = $empleado[0]->id;
        $tipocaja = \DB::SELECT('SELECT id 
                                 FROM tipocaja 
                                 WHERE codigo = "cc"');
        $sede = \DB::SELECT('SELECT sede_id 
                             FROM empleado 
                             WHERE users_id = "'.$users_id.'"');


        $caja = new Caja();
        $caja->estado = $estado;
        $caja->monto = $montoInicio;
        $caja->fecha = date('Y-m-a');
        $caja->inicio = $horaInicio;
        $caja->empleado = $empleado_id;
        $caja->sede_id = $sede[0]->sede_id;
        $caja->tipocaja_id = $tipocaja[0]->id;

        if ($caja->save()) {
            $resp = "Caja Inicializada";
            return response()->json(['resp'=>$resp]);
        }
    }

    public function consultarCaja(Request $request) 
    {

        $maxCaja = \DB::SELECT('SELECT MAX(id) AS id FROM caja WHERE estado = "ABIERTA"');

        $caja = \DB::SELECT('SELECT * FROM caja WHERE id = "'.$maxCaja[0]->id.'"');

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
        $idPrestamo = $request->idPrestamo;
        $dias = $request->dia;
        $mora = $request->mora;
        $pago = $request->pago;
        $serie = $request->serie;
        $interes = $request->interes;
        $monto = $request->monto;
        $banco = $request->banco;
        $resp = 0;
        
        $prestamo = \DB::SELECT('SELECT *
                                 FROM prestamo p
                                 WHERE p.id = "'.$idPrestamo.'"');

        $tipocaja = \DB::SELECT('SELECT * FROM tipocaja WHERE codigo = "'.$banco.'"');

        $caja = \DB::SELECT('SELECT id FROM caja WHERE estado = "abierta" AND tipocaja_id = "'.$tipocaja[0]->id.'"');

        $users_id = Auth::user()->id;
        $empleado = \DB::SELECT('SELECT e.id AS id FROM empleado e WHERE e.users_id = "'.$users_id.'"');
        $empleado_id = $empleado[0]->id;

        $caja = \DB::SELECT('SELECT MAX(id) AS id FROM caja WHERE estado = "ABIERTA" AND tipocaja_id = "'.$tipocaja[0]->id.'"');

        $garantia = \DB::SELECT('SELECT g.* FROM prestamo p
                                 INNER JOIN cotizacion c ON p.cotizacion_id = c.id
                                 INNER JOIN garantia g ON c.garantia_id = g.id
                                 WHERE p.id = "'.$idPrestamo.'"');


        $totalPago = $mora + $interes + $monto;

        if ($pago == $totalPago) {
            
            $pre = Prestamo::where('id', '=',  $idPrestamo)->first();
            $pre->estado = "PAGADO";
            if ($pre->save()) {
                
                $pag = new Pago();
                $pag->codigo = "P"; //PAGADO
                $pag->serie = $idPrestamo;
                $pag->monto = $pago;
                $pag->importe = $pago;
                $pag->vuelto = "0.00";
                $pag->intpago = $interes;
                $pag->mora = $mora;
                $pag->diaspasados = $dias;
                $pag->tipocomprobante_id = 1;
                $pag->prestamo_id = $idPrestamo;
                $pag->empleado_id = $empleado_id;
                $pag->sede_id = $prestamo[0]->sede_id;
                if ($pag->save()) {
                    
                    $pag = \DB::SELECT('SELECT MAX(id) AS id FROM pago');

                    $mov = new Movimiento();
                    $mov->codigo = "D"; //Deposito
                    $mov->serie = $serie;
                    $mov->estado = "ACTIVO";
                    $mov->monto = $pago;
                    $mov->concepto = "DEPOSITO CANCELACIÓN ".$idPrestamo; 
                    $mov->tipo = "INGRESO";
                    $mov->empleado = $empleado_id;
                    $mov->importe = $pago;
                    $mov->codprestamo = $idPrestamo;
                    $mov->condesembolso = $pag[0]->id;
                    $mov->codgarantia = $garantia[0]->id;
                    $mov->garantia = $garantia[0]->nombre;
                    $mov->interesPagar = $interes;
                    $mov->moraPagar = $mora;
                    $mov->caja_id = $caja[0]->id;
                    if ($mov->save()) {
                        
                        $garantia_casillero = \DB::SELECT('SELECT casillero_id FROM garantia_casillero WHERE garantia_id = "'.$garantia[0]->id.'"');
                            
                        $cas = Casillero::where('id', '=',  $garantia_casillero[0]->casillero_id)->first();
                        $cas->estado = "RECOGER";
                        if ($cas->save()) {

                            $tipocaja = \DB::SELECT('SELECT * FROM tipocaja WHERE codigo = "'.$banco.'"');
                            $maxCaja = \DB::SELECT('SELECT MAX(id) AS id, monto FROM caja WHERE estado = "abierta" AND tipocaja_id = "'.$tipocaja[0]->id.'"');

                            $nuevoMonto = $maxCaja[0]->monto + $pago;

                            $caja = Caja::where('id', '=', $maxCaja[0]->id)->first();
                            $caja->monto = $nuevoMonto;
                            if ($caja->save()) {
                                $resp = 1;
                            }
                        }
                    }
                    
                }
                
            }

        }elseif ($pago < $totalPago) {
            
            $pre = Prestamo::where('id', '=',  $idPrestamo)->first();
            $pre->monto = $totalPago - $pago;
            $pre->codigo = "n";
            if ($pre->save()) {

                $pag = new Pago();
                $pag->codigo = "A"; //AMORTIZADO
                $pag->serie = $idPrestamo;
                $pag->monto = $pago;
                $pag->importe = $pago;
                $pag->vuelto = "0.00";
                $pag->intpago = $interes;
                $pag->mora = $mora;
                $pag->diaspasados = $dias;
                $pag->tipocomprobante_id = 1;
                $pag->prestamo_id = $idPrestamo;
                $pag->empleado_id = $empleado_id;
                $pag->sede_id = $prestamo[0]->sede_id;
                if ($pag->save()) {
                    
                    $pag = \DB::SELECT('SELECT MAX(id) AS id FROM pago');

                    $mov = new Movimiento();
                    $mov->codigo = "D";
                    $mov->serie = $serie;
                    $mov->estado = "ACTIVO";
                    $mov->monto = $pago;
                    $mov->concepto = "DEPOSITO AMORTIZACIÓN ".$idPrestamo;
                    $mov->tipo = "INGRESO";
                    $mov->empleado = $empleado_id;
                    $mov->importe = $pago;
                    $mov->codprestamo = $idPrestamo;
                    $mov->condesembolso = $pag[0]->id;
                    $mov->codgarantia = $garantia[0]->id;
                    $mov->garantia = $garantia[0]->nombre;
                    $mov->interesPagar = $interes;
                    $mov->moraPagar = $mora;
                    $mov->caja_id = $caja[0]->id;
                    if ($mov->save()) {

                        $tipocaja = \DB::SELECT('SELECT * FROM tipocaja WHERE codigo = "'.$banco.'"');
                        $maxCaja = \DB::SELECT('SELECT MAX(id) AS id, monto FROM caja WHERE estado = "abierta" AND tipocaja_id = "'.$tipocaja[0]->id.'" GROUP BY id');

                        $nuevoMonto = $maxCaja[0]->monto + $pago;

                        $caja = Caja::where('id', '=', $maxCaja[0]->id)->first();
                        $caja->monto = $nuevoMonto;
                        if ($caja->save()) {
                            $resp = 1;
                        }
                    }
                }
            }
        }else {
            $resp = 2;
        }
/*
        $cliente = \DB::SELECT('SELECT p.id AS prestamo_id, p.monto, p.fecinicio, p.fecfin, p.total, cl.id AS cliente_id, cl.nombre, cl.apellido, cl.dni, g.nombre AS garantia, p.intpagar, m.mora AS morapagar, i.porcentaje
                                FROM prestamo p, cotizacion c, cliente cl, garantia g, mora m, tipocredito_interes tci, interes i
                                WHERE c.cliente_id = cl.id AND p.cotizacion_id = c.id AND c.garantia_id = g.id AND p.mora_id = m.id AND p.estado = "ACTIVO DESEMBOLSADO" AND p.tipocredito_interes_id = tci.id AND tci.interes_id = i.id AND (cl.nombre LIKE "%'.$datoCliente.'%" OR cl.apellido LIKE "%'.$datoCliente.'%" OR cl.dni LIKE "%'.$datoCliente.'%")
                                ORDER BY p.fecfin ASC');

                                */

    

        return response()->json(['resp'=>$resp, 'idPrestamo'=>$idPrestamo, 'banco'=>$banco]);
    }

    public function ingresarComision(Request $request)
    {
        $idPrestamo = $request->idPrestamo;
        $comision = $request->comision;
        $banco = $request->banco;
        $resp = 0;

        $tipocaja = \DB::SELECT('SELECT * FROM tipocaja WHERE codigo = "'.$banco.'"');
        $maxCaja = \DB::SELECT('SELECT MAX(id) AS id, monto FROM caja WHERE estado = "abierta" AND tipocaja_id = "'.$tipocaja[0]->id.'" group by id');

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

        $prestamo = \DB::SELECT('SELECT *
                                 FROM prestamo p
                                 WHERE p.id = "'.$idPrestamo.'"');
        $tipocaja = \DB::SELECT('SELECT * 
                                 FROM tipocaja 
                                 WHERE codigo = "'.$banco.'"');
        $empleado = \DB::SELECT('SELECT e.id AS id, e.sede_id AS sede_id
                                 FROM empleado e 
                                 WHERE e.users_id = "'.$users_id.'"');
        $empleado_id = $empleado[0]->id;
        $caja = \DB::SELECT('SELECT MAX(id) AS id, monto
                             FROM caja 
                             WHERE estado = "ABIERTA" AND tipocaja_id = "'.$tipocaja[0]->id.'" group by id');

        $garantia = \DB::SELECT('SELECT g.* FROM prestamo p
                                INNER JOIN cotizacion c ON p.cotizacion_id = c.id
                                INNER JOIN garantia g ON c.garantia_id = g.id
                                WHERE p.id = "'.$idPrestamo.'"');

        $fechaInicio = $prestamo[0]->fecinicio;
        $nuevaFechaInicio = date("Y-m-d", strtotime($fechaInicio."+ 1 month"));
        $fechaFin = $prestamo[0]->fecfin;
        $nuevaFechaFin = date("Y-m-d", strtotime($fechaFin."+1 month"));

        //dd('Pago: '. $pago.' PagoMinimo: '.$pagoMinimo);

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
            $pre->empleado_id = $empleado[0]->id;
            $pre->sede_id = $prestamo[0]->sede_id;
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
                    $pag->empleado_id = $empleado[0]->id;
                    $pag->sede_id = $empleado[0]->sede_id;
                    if ($pag->save()) {
                        
                        $pag = \DB::SELECT('SELECT MAX(id) AS id FROM pago');
                        $des = \DB::SELECT('SELECT id FROM desembolso WHERE prestamo_id = "'.$idPrestamo.'"');

                        $mov = new Movimiento();
                        $mov->codigo = "D";
                        $mov->serie = $serie;
                        $mov->estado = "ACTIVO";
                        $mov->monto = $pago;
                        $mov->concepto = "DEPOSITO RENOVACION-".$idPrestamo;
                        $mov->tipo = "INGRESO";
                        $mov->empleado = $empleado[0]->id;
                        $mov->importe = $pago;
                        $mov->codprestamo = $idPrestamo;
                        $mov->condesembolso = $pag[0]->id;
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
            $pre->empleado_id = $empleado[0]->id;
            $pre->sede_id = $prestamo[0]->sede_id;
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
                    $pag->empleado_id = $empleado[0]->id;
                    $pag->sede_id = $empleado[0]->sede_id;
                    if ($pag->save()) {
                        
                        $pag = \DB::SELECT('SELECT MAX(id) AS id FROM pago');
                        $des = \DB::SELECT('SELECT id FROM desembolso WHERE id = "'.$idPrestamo.'"');

                        $mov = new Movimiento();
                        $mov->codigo = "D";
                        $mov->serie = $serie;
                        $mov->estado = "ACTIVO";
                        $mov->monto = $pago;
                        $mov->concepto = "DEPOSITO RENOVACION-".$idPrestamo;
                        $mov->tipo = "INGRESO";
                        $mov->empleado = $empleado[0]->id;
                        $mov->importe = $pago;
                        $mov->codprestamo = $idPrestamo;
                        $mov->condesembolso = $pag[0]->id;
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

        $prestamo = \DB::SELECT('SELECT p.id AS prestamo_id, p.monto, p.fecinicio, p.fecfin, p.total, cl.id AS cliente_id, cl.nombre, cl.apellido, cl.dni, g.nombre AS garantia, p.intpagar, m.mora AS morapagar, i.porcentaje
                                 FROM prestamo p, cotizacion c, cliente cl, garantia g, mora m, tipocredito_interes tci, interes i
                                 WHERE c.cliente_id = cl.id AND p.cotizacion_id = c.id AND c.garantia_id = g.id AND p.mora_id = m.id AND p.estado = "ACTIVO DESEMBOLSADO" AND p.tipocredito_interes_id = tci.id AND tci.interes_id = i.id
                                 ORDER BY p.fecfin ASC');

        return response()->json(["view"=>view('cobranza.tabCliente',compact('prestamo', 'aux'))->render(), 'resp'=>$aux, 'idPrestamo'=>$idPrestamo, 'banco'=>$banco]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function guardarNotificar(Request $request)
    {

        $img=$request->archivo;
        $prestamo_id = $request->prestamo_id;
        $nombreArc = $request->nomArchivo;
        $asunto = $request->asunArchivo;
        $tipodocumento_id = $request->tipodocumento_id;
        $user_id = Auth::user()->id;
        $empleado = \DB::SELECT('SELECT e.id AS empleado_id, e.sede_id AS sede_id 
                                 FROM users u, empleado e
                                 WHERE u.id = e.users_id AND u.id = "'.$user_id.'"');

        $subido="";
        $urlGuardar="";
        $resp = "";

        if ($request->hasFile('archivo')) { 
            $nombre=$img->getClientOriginalName();
            $extension=$img->getClientOriginalExtension();
            $nuevoNombre=$nombreArc.$prestamo_id.".".$extension;
            $subido = Storage::disk('notifiPrestamo')->put($nuevoNombre, \File::get($img));
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
            $documento = \DB::SELECT('SELECT MAX(id) AS id FROM documento WHERE estado = "NOTIFICACION"');

            $pdoc = new PrestamoDocumento();
            $pdoc->asunto = $asunto;
            $pdoc->detalle = "Notificacion al prestamo ".$prestamo_id;
            $pdoc->estado = "ACTIVO";
            $pdoc->prestamo_id = $prestamo_id;
            $pdoc->documento_id = $documento[0]->id;
            if ($pdoc->save()) {
                $resp = 1;
            }
        }

        return response()->json([ "resp" => $resp]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function consultarMovimiento(Request $request)
    {
        $nombre = $request->nombre;
        $codigo = $request->codigo;
        $fecinicio = $request->fecInicio;
        $fecfin = $request->fecFin;
        $cant = 0;

        $consultaI = \DB::SELECT('SELECT m.id AS cod, m.monto AS monto, m.concepto AS concepto, m.tipo AS tipo, DATE(m.created_at) AS fecha, g.nombre
                                 FROM movimiento m, prestamo p, cotizacion c, cliente cl, garantia g
                                 WHERE m.codprestamo = p.id AND p.cotizacion_id = c.id AND c.cliente_id = cl.id AND m.codgarantia = g.id AND m.tipo = "INGRESO" AND (m.id = "'.$codigo.'" AND CONCAT(cl.nombre, " ", cl.apellido) LIKE "%'.$nombre.'%") AND m.created_at BETWEEN "'.$fecinicio.'" AND "'.$fecfin.'"');

        $consultaE = \DB::SELECT('SELECT m.id AS cod, m.monto AS monto, m.concepto AS concepto, m.tipo AS tipo, DATE(m.created_at) AS fecha, g.nombre
                                  FROM movimiento m, prestamo p, cotizacion c, cliente cl, garantia g
                                  WHERE m.codprestamo = p.id AND p.cotizacion_id = c.id AND c.cliente_id = cl.id AND m.codgarantia = g.id AND m.tipo = "EGRESO" AND (m.id = "'.$codigo.'" AND CONCAT(cl.nombre, " ", cl.apellido) LIKE "%'.$nombre.'%") AND m.created_at BETWEEN "'.$fecinicio.'" AND "'.$fecfin.'"');

        $cant = COUNT($consultaI) + COUNT($consultaE);

        return response()->json(["view"=>view('cobranza.tabConsulta',compact('consultaI', 'consultaE'))->render(), "cant" => $cant]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function consultarHistorial(Request $request)
    {
        $user = Auth::user();
        $usuario = \DB::SELECT('SELECT e.nombre, e.apellido, e.id, u.name AS area, e.foto AS foto, e.sede_id AS sede
                                FROM empleado e, users u 
                                WHERE e.users_id = u.id AND u.id = "'.$user->id.'"');

        $ingreso = \DB::SELECT('SELECT m.*, cl.nombre AS nomCli, cl.apellido AS apeCli, e.nombre AS nomEmp, e.apellido AS apeEmp, m.created_at AS fecha
                                FROM movimiento m, caja c, prestamo p, cotizacion co, cliente cl, empleado e
                                WHERE m.caja_id = c.id AND m.codprestamo = p.id AND p.cotizacion_id = co.id AND m.empleado = e.id AND co.cliente_id = cl.id AND m.tipo = "INGRESO" AND c.estado = "ABIERTA" AND c.sede_id = "'.$usuario[0]->sede.'" AND DATE_FORMAT(m.created_at, "%Y-%m-%d") = "'.$request->fecha.'"
                                ORDER BY m.created_at DESC');
                            

        $sumIngreso = \DB::SELECT('SELECT SUM(m.importe) monto
                                    FROM movimiento m, caja c, prestamo p, cotizacion co, cliente cl, empleado e
                                    WHERE m.caja_id = c.id AND m.codprestamo = p.id AND p.cotizacion_id = co.id AND m.empleado = e.id AND co.cliente_id = cl.id AND m.tipo = "INGRESO" AND c.estado = "ABIERTA" AND c.sede_id = "'.$usuario[0]->sede.'" AND DATE_FORMAT(m.created_at, "%Y-%m-%d") = "'.$request->fecha.'"');

        $egreso = \DB::SELECT('SELECT m.*, cl.nombre AS nomCli, cl.apellido AS apeCli, e.nombre AS nomEmp, e.apellido AS apeEmp, m.created_at AS fecha
                               FROM movimiento m, caja c, prestamo p, cotizacion co, cliente cl, empleado e
                               WHERE m.caja_id = c.id AND m.codprestamo = p.id AND p.cotizacion_id = co.id AND m.empleado = e.id AND co.cliente_id = cl.id AND m.tipo = "EGRESO" AND c.estado = "ABIERTA" AND c.sede_id = "'.$usuario[0]->sede.'" AND DATE_FORMAT(m.created_at, "%Y-%m-%d") = "'.$request->fecha.'"
                               ORDER BY m.created_at DESC');

        $sumEgreso = \DB::SELECT('SELECT SUM(m.monto) AS monto
                                   FROM movimiento m
                                   WHERE m.tipo = "EGRESO"  AND DATE_FORMAT(m.created_at, "%Y-%m-%d") = "'.$request->fecha.'"');

        return response()->json(["view"=>view('cobranza.listaHitorial',compact('ingreso', 'egreso', 'sumIngreso', 'sumEgreso'))->render()]);
    }
}
