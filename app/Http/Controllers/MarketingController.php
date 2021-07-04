<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Movimiento;
use App\Caja;
use App\Formulario;

class MarketingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function cliente()
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

        $clientes = \DB::SELECT('SELECT * FROM cliente WHERE id NOT IN (
                                 SELECT c.id FROM cliente c
                                 INNER JOIN cotizacion co ON c.id = co.cliente_id
                                 INNER JOIN prestamo p ON co.id = p.cotizacion_id
                                 WHERE p.estado = "ACTIVO" OR p.estado = "RENOVADO" OR p.estado = "ACTIVO DESEMBOLSADO"
                                 GROUP BY c.id)');

        $conteo = \DB::SELECT('SELECT COUNT(*) as conteo FROM cliente WHERE id NOT IN (
                               SELECT c.id FROM cliente c
                               INNER JOIN cotizacion co ON c.id = co.cliente_id
                               INNER JOIN prestamo p ON co.id = p.cotizacion_id
                               WHERE p.estado = "ACTIVO" OR p.estado = "RENOVADO" OR p.estado = "ACTIVO DESEMBOLSADO"
                               GROUP BY c.id)');

        return view('marketing.cliente', compact('usuario', 'clientes', 'notificacion', 'cantNotificaciones', 'conteo'));
    }

    public function liquidacion()
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

        return view('marketing.liquidacion', compact('usuario', 'notificacion', 'cantNotificaciones'));
    }

    public function presupuesto()
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

        $presMensual = \DB::SELECT('SELECT monto, DATE_FORMAT(created_at, "%b") AS mes FROM movimiento WHERE concepto = "publicidad"');

        return view('marketing.presupuesto', compact('usuario', 'presMensual', 'notificacion', 'cantNotificaciones'));
    }

    public function guardarPresupuesto(Request $request)
    {
        $resp = "0";
        $monto = $request->monto;
        $user_id = Auth::user()->id;
        $cajaG = \DB::SELECT('SELECT MAX(id) AS id, montofin 
                             FROM caja 
                             WHERE tipocaja_id = "2"');
        $sede = \DB::SELECT('SELECT sede_id 
                             FROM empleado 
                             WHERE users_id = "'.$user_id.'"');

        $actualizarCaja = $cajaG[0]->montofin - $monto;

        $mov = new Movimiento();
        $mov->codigo = "GA";
        $mov->estado = "ACTIVO";
        $mov->monto = $monto;
        $mov->concepto = "Publicidad";
        $mov->tipo = "EGRESO";
        $mov->empleado = $user_id;
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
            $caja->empleado = $user_id;
            $caja->sede_id = $sede[0]->sede_id;

            if ($caja->save()) {
                $resp = "1";
            }

        }
        $presMensual = \DB::SELECT('SELECT monto, DATE_FORMAT(created_at, "%b") AS mes FROM movimiento WHERE concepto = "publicidad"');

        return response()->json(["presupuesto"=>view('marketing.tabPresupuesto',compact('presMensual'))->render(), 'resp'=>$resp]);

    }

    public function reportes()
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

        return view('marketing.reportes', compact('usuario', 'notificacion', 'cantNotificaciones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function graficoMarketing(Request $request)
    {

        for($a=1; $a<=12 ;$a++){
            $cliActivo[$a]=0;
            $cliInac[$a] = 0;
            $mes[$a] = 0;
        }
        

        $clientesActivos = \DB::SELECT('SELECT COUNT(c.id) AS clientesActivos, MONTH(p.fecinicio) AS mes
                                        FROM cliente c, cotizacion co, prestamo p
                                        WHERE c.id = co.cliente_id AND p.cotizacion_id = co.id AND p.estado = "ACTIVO DESEMBOLSADO"
                                        GROUP BY MONTH(p.fecinicio)');

        foreach ($clientesActivos as $ca) {
            $mes = $ca->mes;
            $cliActivo[$mes] = $ca->clientesActivos;
        }

        $cantClienteActivo = \DB::SELECT('SELECT COUNT(c.id) AS cantidad
                                          FROM cliente c, cotizacion co, prestamo p
                                          WHERE c.id = co.cliente_id AND p.cotizacion_id = co.id AND p.estado = "ACTIVO DESEMBOLSADO"');

        $clientesInActivos = \DB::SELECT('SELECT COUNT(c.id) AS clientesInActivos, MONTH(p.fecinicio) AS mes
                                        FROM cliente c, cotizacion co, prestamo p
                                        WHERE c.id = co.cliente_id AND p.cotizacion_id = co.id AND p.estado != "ACTIVO DESEMBOLSADO"
                                        GROUP BY MONTH(p.fecinicio)');

        foreach ($clientesInActivos as $cia) {
            $mes = $cia->mes;
            $cliInac[$mes] = $cia->clientesInActivos;
        }

        $cantClienteInActivo = \DB::SELECT('SELECT COUNT(c.id) AS cantidad
                                            FROM cliente c, cotizacion co, prestamo p
                                            WHERE c.id = co.cliente_id AND p.cotizacion_id = co.id AND p.estado != "ACTIVO DESEMBOLSADO"');

        $ocupacion = \DB::SELECT('SELECT COUNT(c.id) AS cantidad, o.id AS ocupacion  
                                  FROM cliente c, ocupacion o 
                                  WHERE c.ocupacion_id = o.id GROUP BY ocupacion_id');

        $nomOcupacion = \DB::SELECT('SELECT nombre, id FROM ocupacion');

        $numOcupa = COUNT($ocupacion);

        foreach ($ocupacion as $o) {
            $ocupa = $o->ocupacion;
            $ocupaCant[$ocupa] = $o->cantidad;
        }

        foreach ($nomOcupacion as $no) {
            $idocupa = $no->id;
            $nombreOcupacion[$idocupa] = $no->nombre;
        }

        $recomendacion = \DB::SELECT('SELECT COUNT(c.id) AS cantidad, r.id AS idRecomendacion
                                      FROM cliente c, recomendacion r
                                      WHERE c.recomendacion_id = r.id GROUP BY r.id');

        $nomRecomendacion = \DB::SELECT('SELECT recomendacion, id FROM recomendacion');

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
        

        //dd(json_encode($data));
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
