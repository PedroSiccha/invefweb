<?php

namespace App\Http\Controllers;

use App\Models\Proceso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EmpleadoController extends Controller
{
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
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;
        $user = Auth::user();
        $usuario = DB::SELECT('SELECT e.nombre, e.apellido, e.id, u.name AS area, e.foto AS foto, e.sede_id AS sede
                                FROM empleado e, users u 
                                WHERE e.users_id = u.id AND u.id = "'.$user->id.'"');

        $empleado = DB::SELECT('SELECT e.id AS empleado_id, e.nombre, e.apellido, e.dni, e.fecnac, e.edad, e.telefono, e.referencia, e.whatsapp, e.estado, e.genero, e.valoracion, e.foto,
                                        tdi.nombre AS tipoDocumento,
                                        d.direccion,
                                        di.distrito,
                                        p.provincia,
                                        de.departamento,
                                        t.turno, t.detalle AS detalleTurno,
                                        pl.fecinicio AS inicioPlanilla, pl.fecfin AS finPlanilla, pl.monto AS montoPlanilla
                                 FROM empleado e, tipodocide tdi, direccion d, distrito di, provincia p, departamento de, turno t, planilla pl
                                 WHERE e.tipodocide_id = tdi.id AND e.direccion_id = d.id AND d.distrito_id = di.id AND di.provincia_id = p.id AND p.departamento_id = de.id AND e.turno_id = t.id AND e.planilla_id = pl.id AND e.users_id = "'.$users_id.'" AND e.sede_id = "'.$idSucursal.'"');

        $prestamo = DB::SELECT('SELECT p.id AS prestamo_id, p.monto AS montoPrestamo, p.fecinicio, p.fecfin, p.total, p.sede_id 
                                 FROM empleado e, prestamo p
                                 WHERE p.empleado_id = e.id AND p.empleado_id = "'.$empleado[0]->empleado_id.'" AND p.sede_id = "'.$idSucursal.'"');

        $evaluacion = DB::SELECT('SELECT c.id AS cotizacion_id, c.max, c.min, c.estado, c.precio,  
                                        cl.nombre, cl.apellido,
                                        g.nombre AS garantia, g.detalle AS detalleGarantia, 
                                        tp.nombre AS tipoPrestamo
                                   FROM cotizacion c, cliente cl, garantia g, tipoprestamo tp
                                   WHERE c.cliente_id = cl.id AND c.garantia_id = g.id AND c.tipoprestamo_id = tp.id AND c.empleado_id = "'.$empleado[0]->empleado_id.'" AND c.sede_id = "'.$idSucursal.'"');

        $tipodocumento = DB::SELECT('SELECT * FROM tipodocide');

        $distrito = DB::SELECT('SELECT * FROM distrito');

        $provincia = DB::SELECT('SELECT * FROM provincia');

        $departamento = DB::SELECT('SELECT * FROM departamento');

        $listPrestamos = DB::SELECT('SELECT estado, monto, fecinicio, fecfin 
                                      FROM prestamo 
                                      WHERE empleado_id = "'.$empleado[0]->empleado_id.'" AND sede_id = "'.$idSucursal.'"');

        $listCotizacion = DB::SELECT('SELECT c.max, c.min, c.estado, g.nombre AS garantia  
                                       FROM cotizacion c, garantia g 
                                       WHERE c.empleado_id = "'.$empleado[0]->empleado_id.'" AND c.garantia_id = g.id AND c.sede_id = "'.$idSucursal.'"');

        $listPago = DB::SELECT('SELECT prestamo_id, monto, importe 
                                 FROM pago 
                                 WHERE empleado_id = "'.$empleado[0]->empleado_id.'" AND sede_id = "'.$idSucursal.'"');

        return view('empleado.perfil', compact('empleado', 'prestamo', 'evaluacion', 'usuario', 'tipodocumento', 'distrito', 'provincia', 'departamento', 'listPrestamos', 'listCotizacion', 'listPago'));
    }   
}