<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //dd(auth()->user()->id);
        //dd(session()->all());
        //dd(session()->rol_nombre);
        //dd(session()->get('rol_nombre'));

        $rol = session()->get('rol_nombre');
        
        if ($rol == "Cliente") {

            $id = auth()->user()->id;

            $user = Auth::user();
            $usuario = \DB::SELECT('SELECT e.nombre, e.apellido, e.id, u.name AS area, e.foto AS foto 
                                    FROM empleado e, users u 
                                    WHERE e.users_id = u.id AND u.id = "'.$user->id.'"');

            $cliente = \DB::SELECT('SELECT c.id as cliente_id, c.nombre, c.apellido, c.dni, c.correo, dr.direccion, c.fecnac, c.edad, c.genero, c.foto, c.facebook, c.ingmax, c.ingmin, c.gasmax, c.gasmin, c.created_at, o.nombre AS ocupacion, r.recomendacion AS recomendacion, c.evaluacion AS evaluacion, c.telefono, c.whatsapp, c.referencia 
                                    FROM cliente c, ocupacion o, recomendacion r, direccion dr
                                    WHERE c.ocupacion_id = o.id AND c.recomendacion_id = r.id AND c.direccion_id = dr.id AND c.id = "'.$id.'" GROUP BY c.id');

            $cantCotizacion = \DB::SELECT('SELECT COUNT(c.id) AS cantCotizacion 
                                        FROM cotizacion c, cliente cl 
                                        WHERE c.cliente_id = cl.id AND cl.id = "'.$id.'"');

            $cantCotPendiente = \DB::SELECT('SELECT COUNT(c.id) AS cantCotizacion 
                                            FROM cotizacion c, cliente cl 
                                            WHERE c.cliente_id = cl.id AND c.estado = "PAGADO" AND cl.id = "'.$id.'"');

            $cantCotAceptadas = \DB::SELECT('SELECT COUNT(c.id) AS cantCotizacion 
                                            FROM cotizacion c, cliente cl 
                                            WHERE c.cliente_id = cl.id AND c.estado = "ACTIVO" AND cl.id = "'.$id.'"');

            $cantPrestamo = \DB::SELECT('SELECT COUNT(p.id) AS catPrestamo 
                                        FROM prestamo p, cotizacion c 
                                        WHERE p.cotizacion_id = c.id AND p.cotizacion_id = c.id AND c.cliente_id = "'.$id.'"');

            $cantPrePendiente = \DB::SELECT('SELECT COUNT(p.id) AS catPrestamo 
                                            FROM prestamo p, cotizacion c 
                                            WHERE p.cotizacion_id = c.id AND p.estado = "PAGADO" AND c.cliente_id = "'.$id.'"');

            $cantPreAceptadas = \DB::SELECT('SELECT COUNT(p.id) AS catPrestamo  
                                            FROM prestamo p, cotizacion c 
                                            WHERE p.cotizacion_id = c.id AND p.estado = "ACTIVO" AND c.cliente_id = "'.$id.'"');

            $prestamo = \DB::SELECT('SELECT p.id AS prestamo_id, p.monto, p.fecinicio, p.fecfin, p.total, p.estado, p.created_at, g.nombre, p.intpagar, m.mora
                                    FROM prestamo p, cotizacion c, garantia g, mora m
                                    WHERE p.cotizacion_id = c.id AND c.garantia_id = g.id AND m.id = p.mora_id AND c.cliente_id = "'.$id.'"');

            $cotizacion = \DB::SELECT('SELECT c.id AS cotizacion_id, c.max, c.min, c.created_at, c.estado, tp.nombre AS tipoPrestamo, g.nombre AS garantia
                                    FROM cotizacion c, tipoprestamo tp, garantia g
                                    WHERE c.garantia_id = g.id AND c.tipoprestamo_id = tp.id AND c.estado = "PRESTAMO" AND c.cliente_id = "'.$id.'"');
            
    
            $listCotizaciones = \DB::SELECT('SELECT c.id AS cotizacion_id, tp.nombre AS tipoPrestamo, g.nombre AS garantia, g.detalle AS detalleGarantia, c.max, c.min, CONCAT(e.nombre, " ", e.apellido) AS empleado 
                                            FROM cotizacion c, tipoprestamo tp, garantia g, empleado e 
                                            WHERE c.tipoprestamo_id = tp.id AND c.garantia_id = g.id AND c.empleado_id = e.id AND c.estado = "PRESTAMO" AND c.cliente_id = "'.$id.'"');

            $tipoPrestamo = \DB::SELECT('SELECT * FROM tipoprestamo'); 
            $tipoGarantia = \DB::SELECT('SELECT * FROM tipogarantia WHERE detalle != "tj"');
            $tipoJoya = \DB::SELECT('SELECT * FROM tipogarantia WHERE detalle != "tp"');
            $almacen = \DB::SELECT('SELECT * FROM almacen');
            $distrito = \DB::SELECT('SELECT * FROM distrito');
            $provincia = \DB::SELECT('SELECT * FROM provincia');
            $departamento = \DB::SELECT('SELECT * FROM departamento');
            $ocupacion = \DB::SELECT('SELECT * FROM ocupacion');
            $tipoDocumento = \DB::SELECT('SELECT * FROM tipodocide');
            

            return view('cliente', compact('cliente', 'cantCotizacion', 'cantCotPendiente', 'cantCotAceptadas', 'cantPrestamo', 'cantPrePendiente', 'cantPreAceptadas', 'prestamo', 'cotizacion', 'cotizacion', 'listCotizaciones', 'tipoPrestamo', 'tipoGarantia', 'tipoJoya', 'almacen', 'distrito', 'provincia', 'departamento', 'ocupacion', 'tipoDocumento', 'usuario'));

        }else {
            
            $user = Auth::user();

            $informes = \DB::SELECT('SELECT tp.nombre AS credito, tp.detalle AS resumen, tp.imagen, r.requisito AS requisito 
                                    FROM tipoprestamo tp 
                                    LEFT JOIN tipocredito_requisito tr ON tp.id = tr.tipocredito_id 
                                    LEFT JOIN requisitos r ON r.id = tr.requisitos_id');

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

            return view('home', compact('informes', 'usuario', 'notificacion', 'cantNotificaciones'));
            
        }

        

        /*
        switch ($rol) {
            case 'Administrador':
                return view('home', compact('informes', 'usuario'));
                break;
             case 'Almacen':
                return view('home', compact('informes', 'usuario'));
                break;
        }
        */
        

                                 
        
    }

    public function web()
    {

        return view('web.index');
    }

    public function buscarClienteH(Request $request)
    {
        $dni = $request->dni;

        $cliente = \DB::SELECT('SELECT id FROM cliente WHERE dni = "'.$dni.'"');

        if ($cliente == null) {
            $url = "cliente";
            $estado = "0";
            return response()->json(['url'=>$url, 'estado'=>$estado]);
        }else {
            $url = "perfilCliente";
            $id = $cliente[0]->id;
            $estado = "1";
            return response()->json(['url'=>$url, 'id'=>$id, 'estado'=>$estado]);
        }
    }

    public function buscarClienteHP(Request $request)
    {
        $dni = $request->dni;

        $cliente = \DB::SELECT('SELECT id FROM cliente WHERE dni = "'.$dni.'"');

        if ($cliente == null) {
            $url = "cliente";
            $estado = "0";
            return response()->json(['url'=>$url, 'estado'=>$estado]);
        }else {
            $cotizacion = \DB::SELECT('SELECT c.id id FROM cotizacion c, cliente cl WHERE c.cliente_id = cl.id AND cl.dni = "'.$dni.'"'); 

            if ($cotizacion == null) {
                
                $id = $cliente[0]->id;
                $estado = "1";
                return response()->json(['id'=>$id, 'estado'=>$estado]);
            }else {
                $cotizacionE = \DB::SELECT('SELECT MAX(c.id) id FROM cotizacion c, cliente cl WHERE c.cliente_id = cl.id AND cl.dni = "'.$dni.'"');
                $id = $cotizacionE[0]->id;
                $estado = "2";
                return response()->json(['id'=>$id, 'estado'=>$estado]);
            }
            
        }
    }

    public function verificarCaja(Request $request)
    {
        $caja = \DB::SELECT('SELECT MAX(id) AS id FROM caja');

        if ($caja[0]->id == null) {
            $resp = "sincaja";
            return response()->json(['resp'=>$resp]);
        }else {
            $verCaja = \DB::SELECT('SELECT id FROM caja WHERE estado = "ABIERTA" AND id = "'.$caja[0]->id.'"');
            if ($verCaja == null) {

                $caja = \DB::SELECT('SELECT * FROM caja WHERE id = "'.$caja[0]->id.'"');

                $fecha = $caja[0]->updated_at;
                $monto = $caja[0]->montofin;

                $resp = "cerrada";
                return response()->json(['resp'=>$resp, 'fecha'=>$fecha, 'monto'=>$monto]);
            }else {
                $resp = "abierta";
                return response()->json(['resp'=>$resp]);
            }
        }

    }
}
