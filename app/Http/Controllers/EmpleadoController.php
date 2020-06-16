<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function correo()
    {
        return view('empleado.correo');
    }

    public function manual()
    {
        return view('empleado.manuales');
    }

    public function perfil()
    {
        $users_id = Auth::user()->id;
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

        $empleado = \DB::SELECT('SELECT e.id AS empleado_id, e.nombre, e.apellido, e.dni, e.fecnac, e.edad, e.telefono, e.referencia, e.whatsapp, e.estado, e.genero, e.valoracion, e.foto,
                                        tdi.nombre AS tipoDocumento,
                                        d.direccion,
                                        di.distrito,
                                        p.provincia,
                                        de.departamento,
                                        t.turno, t.detalle AS detalleTurno,
                                        pl.fecinicio AS inicioPlanilla, pl.fecfin AS finPlanilla, pl.monto AS montoPlanilla
                                 FROM empleado e, tipodocide tdi, direccion d, distrito di, provincia p, departamento de, turno t, planilla pl
                                 WHERE e.tipodocide_id = tdi.id AND e.direccion_id = d.id AND d.distrito_id = di.id AND di.provincia_id = p.id AND p.departamento_id = de.id AND e.turno_id = t.id AND e.planilla_id = pl.id AND e.users_id = "'.$users_id.'"');

        $prestamo = \DB::SELECT('SELECT p.id AS prestamo_id, p.monto AS montoPrestamo, p.fecinicio, p.fecfin, p.total, p.sede_id 
                                 FROM empleado e, prestamo p
                                 WHERE p.empleado_id = e.id AND p.empleado_id = "'.$empleado[0]->empleado_id.'"');

        $evaluacion = \DB::SELECT('SELECT c.id AS cotizacion_id, c.max, c.min, c.estado, c.precio,  
                                        cl.nombre, cl.apellido,
                                        g.nombre AS garantia, g.detalle AS detalleGarantia, 
                                        tp.nombre AS tipoPrestamo
                                   FROM cotizacion c, cliente cl, garantia g, tipoprestamo tp
                                   WHERE c.cliente_id = cl.id AND c.garantia_id = g.id AND c.tipoprestamo_id = tp.id AND c.empleado_id = "'.$empleado[0]->empleado_id.'"');

        $tipodocumento = \DB::SELECT('SELECT * FROM tipodocide');

        $distrito = \DB::SELECT('SELECT * FROM distrito');

        $provincia = \DB::SELECT('SELECT * FROM provincia');

        $departamento = \DB::SELECT('SELECT * FROM departamento');

        $listPrestamos = \DB::SELECT('SELECT estado, monto, fecinicio, fecfin 
                                      FROM prestamo 
                                      WHERE empleado_id = "'.$empleado[0]->empleado_id.'"');

        $listCotizacion = \DB::SELECT('SELECT c.max, c.min, c.estado, g.nombre AS garantia  
                                       FROM cotizacion c, garantia g 
                                       WHERE c.empleado_id = "'.$empleado[0]->empleado_id.'" AND c.garantia_id = g.id');

        $listPago = \DB::SELECT('SELECT prestamo_id, monto, importe 
                                 FROM pago 
                                 WHERE empleado_id = "'.$empleado[0]->empleado_id.'"');

        return view('empleado.perfil', compact('empleado', 'prestamo', 'evaluacion', 'usuario', 'tipodocumento', 'distrito', 'provincia', 'departamento', 'listPrestamos', 'listCotizacion', 'listPago', 'notificacion', 'cantNotificaciones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
