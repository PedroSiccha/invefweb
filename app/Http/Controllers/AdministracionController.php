<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interes;
use App\Mora;
use App\Sede;
use App\Direccion;
use App\Tipogarantia;
use App\Prestamo;
use App\Movimiento;
use App\Caja;
use App\Departamento;
use App\Provincia;
use App\Distrito;
use App\Documento;
use App\MovimientoDocumento;
use Illuminate\Support\Facades\Auth;
use Storage;

class AdministracionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function configuracion()
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

        $interes = \DB::SELECT('SELECT * FROM interes');
        $mora = \DB::SELECT('SELECT * FROM mora');
        $tipogarantia = \DB::SELECT('SELECT * FROM tipogarantia');
        $departamento = \DB::SELECT('SELECT * FROM departamento');
        $provincia = \DB::SELECT('SELECT p.id, p.provincia, p.departamento_id, d.departamento 
                                  FROM provincia p, departamento d 
                                  WHERE p.departamento_id = d.id');
        $distrito = \DB::SELECT('SELECT di.id, di.distrito, di.provincia_id, p.provincia, p.departamento_id, d.departamento 
                                        FROM distrito di, provincia p, departamento d 
                                        WHERE di.provincia_id = p.id AND p.departamento_id = d.id');

        return view('administracion.configuraciones', compact('interes', 'mora', 'usuario', 'tipogarantia', 'departamento', 'provincia', 'distrito', 'notificacion', 'cantNotificaciones'));
    } 

    public function guardarInteres(Request $request)
    {
        $interes = new Interes();
        $interes->porcentaje = $request->interes;
        if ($interes->save()) {
            $interes = Interes::all();
            return response()->json(["view"=>view('administracion.tabInteres',compact('interes'))->render(), 'inte'=>$request->interes]);
        }
    }

    public function guardarMora(Request $request)
    {
        $mora = new Mora();
        $mora->valor = $request->mora;
        if ($mora->save()) {
            $mora = Mora::all();
            return response()->json(["view"=>view('administracion.tabMora',compact('mora'))->render(), 'mor'=>$request->mora]);
        }
    }

    public function guardarTipoGarantia(Request $request)
    {
        $nombre = $request->nombre;
        $precMax = $request->precminimo;
        $precMin = $request->tipoGarantia;
        $detalle = $request->precmaximo;
        $pureza = $request->detalle;

        $tgar = new Tipogarantia();
        $tgar->nombre = $nombre;
        $tgar->precMax = $precMax;
        $tgar->precMin = $precMin;
        $tgar->detalle = $detalle;
        $tgar->pureza = $pureza;
        
        if ($tgar->save()) {
            $tipogarantia = \DB::SELECT('SELECT * FROM tipogarantia');
            
            return response()->json(["view"=>view('administracion.tabTipoGarantia',compact('tipogarantia'))->render()]);
        }

    }

    public function guardarDepartamento(Request $request)
    {
        $dep = new Departamento();
        $dep->departamento = $request->nombre;
        if ($dep->save()) {
            $departamento = \DB::SELECT('SELECT * FROM departamento');
            $resp = 1;

        }else {
            $resp = 0;
        }

        return response()->json(["view"=>view('administracion.tabDepartamento',compact('departamento'))->render(), 'resp'=>$resp]);
    }

    public function guardarProvincia(Request $request)
    {
        $prov = new Provincia();
        $prov->provincia = $request->nombre;
        $prov->departamento_id = $request->departamento_id;
        if ($prov->save()) {
            $provincia = \DB::SELECT('SELECT p.id, p.provincia, p.departamento_id, d.departamento 
                                  FROM provincia p, departamento d 
                                  WHERE p.departamento_id = d.id');
            $resp = 1;

        }else {
            $resp = 0;
        }

        return response()->json(["view"=>view('administracion.tabProvincia',compact('provincia'))->render(), 'resp'=>$resp]);
    }

    public function guardarDistrito(Request $request)
    {
        $dist = new Distrito();
        $dist->distrito = $request->nombre;
        $dist->provincia_id = $request->provincia_id;
        if ($dist->save()) {
            $distrito = \DB::SELECT('SELECT di.id, di.distrito, di.provincia_id, p.provincia, p.departamento_id, d.departamento 
                                        FROM distrito di, provincia p, departamento d 
                                        WHERE di.provincia_id = p.id AND p.departamento_id = d.id');
            $resp = 1;

        }else {
            $resp = 0;
        }

        return response()->json(["view"=>view('administracion.tabDistrito',compact('distrito'))->render(), 'resp'=>$resp]);
    }

    public function editarInteres(Request $request)
    {
        $interes = Interes::where('id', '=', $request->id)->first();
        $interes->porcentaje = $request->interes;
        if ($interes->save()) {
            $interes = Interes::all();
            return response()->json(["view"=>view('administracion.tabInteres',compact('interes'))->render(), 'inte'=>$request->interes]);
        }
    }

    public function editarMora(Request $request)
    {
        $mora = Mora::where('id', '=', $request->id)->first();
        $mora->valor = $request->mora;
        if ($mora->save()) {
            $mora = Mora::all();
            return response()->json(["view"=>view('administracion.tabMora',compact('mora'))->render(), 'mor'=>$request->mora]);
        }
    }

    public function eliminarInteres(Request $request)
    {
        $interes = Interes::where('id', '=', $request->id)->first();
        if ($interes->delete()) {

           $interes=Interes::get();

            return response()->json(["view"=>view('administracion.tabInteres',compact('interes'))->render(), 'inte'=>$request->interes]);

        }
    }

    public function eliminarMora(Request $request)
    {
        $mora = Mora::where('id', '=', $request->id)->first();
        if ($mora->delete()) {

           $mora=Mora::get();

            return response()->json(["view"=>view('administracion.tabMora',compact('mora'))->render(), 'mor'=>$request->mora]);

        }
    }

    public function politicas()
    {
        return view('administracion.politicas');
    }

    public function reuniones()
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

        $reuniones = \DB::SELECT('SELECT r.id AS reunion_id, r.nombre AS nombrereunion, r.detalle AS detallereunion, r.motivo AS motivoreunion, r.estado, r.fecha, r.inicio, r.fin, s.nombre AS sede, s.referencia 
                                  FROM reuniones r, reunion_sede rs, sede s
                                  WHERE rs.reuniones_id = r.id AND rs.sede_id = s.id');
 
    return view('administracion.reuniones', compact('usuario', 'reuniones', 'notificacion', 'cantNotificaciones'));
    }

    public function sedes()
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

        $departamento = \DB::SELECT('SELECT * FROM departamento');

        $provincia = \DB::SELECT('SELECT * FROM provincia');

        $distrito = \DB::SELECT('SELECT * FROM distrito');

        $sede = \DB::SELECT('SELECT s.id AS sede_id, s.nombre, s.detalle, s.referencia, s.estado, s.telefono, s.telfreferencia, s.direccion_id, d.direccion, di.distrito, p.provincia, de.departamento, di.id AS distrito_id, p.id AS provincia_id, de.id AS departamento_id
                             FROM sede s
                             LEFT JOIN direccion d ON d.id = s.direccion_id
                             LEFT JOIN distrito di ON di.id = d.distrito_id
                             LEFT JOIN provincia p ON p.id = di.provincia_id
                             LEFT JOIN departamento de ON de.id = p.departamento_id
                            WHERE s.estado = "ACTIVO"');

        return view('administracion.sedes', compact('usuario', 'departamento', 'provincia', 'distrito', 'sede', 'notificacion', 'cantNotificaciones'));
    }

    public function actualizarSede(Request $request)
    {
        $sede_id = $request->sede_id;
        $nombre = $request->nombre;
        $detalle = $request->detalle;
        $telefono = $request->telefono;
        $telfreferencia = $request->telfreferencia;
        $direccion = $request->direccion_id;
        $distrito_id = $request->distrito_id;
        $referencia = $request->referencia;

        $dir = new Direccion();
        $dir->direccion = $direccion;
        $dir->referencia = $referencia;
        $dir->distrito_id = $distrito_id;
        if ($dir->save()) {
            $dir_id = \DB::SELECT('SELECT MAX(id) AS id FROM direccion');

            $sede = Sede::where('id', '=', $sede_id)->first();
            $sede->nombre = $nombre;
            $sede->detalle = $detalle;
            $sede->referencia = $referencia;
            $sede->telefono = $telefono;
            $sede->telfreferencia = $telfreferencia;
            $sede->direccion_id = $dir_id[0]->id;
            if ($sede->save()) {
                
                $sede = \DB::SELECT('SELECT s.id AS sede_id, s.nombre, s.detalle, s.referencia, s.estado, s.telefono, s.telfreferencia, s.direccion_id, d.direccion, di.distrito, p.provincia, de.departamento, di.id AS distrito_id, p.id AS provincia_id, de.id AS departamento_id
                                     FROM sede s
                                     LEFT JOIN direccion d ON d.id = s.direccion_id
                                     LEFT JOIN distrito di ON di.id = d.distrito_id
                                     LEFT JOIN provincia p ON p.id = di.provincia_id
                                     LEFT JOIN departamento de ON de.id = p.departamento_id
                                     WHERE s.estado = "ACTIVO"');

                return response()->json(["view"=>view('administracion.listSede',compact('sede'))->render()]);
            }
            
        }
        

    }

    public function eliminarSede(Request $request)
    {
        $sede_id = $request->sede_id;
        $sede = Sede::where('id', '=', $sede_id)->first();
        $sede->estado = "BAJA";
        if ($sede->save()) {
            $sede = \DB::SELECT('SELECT s.id AS sede_id, s.nombre, s.detalle, s.referencia, s.estado, s.telefono, s.telfreferencia, s.direccion_id, d.direccion, di.distrito, p.provincia, de.departamento, di.id AS distrito_id, p.id AS provincia_id, de.id AS departamento_id
                                 FROM sede s
                                 LEFT JOIN direccion d ON d.id = s.direccion_id
                                 LEFT JOIN distrito di ON di.id = d.distrito_id
                                 LEFT JOIN provincia p ON p.id = di.provincia_id
                                 LEFT JOIN departamento de ON de.id = p.departamento_id
                                 WHERE s.estado = "ACTIVO"');

                return response()->json(["view"=>view('administracion.listSede',compact('sede'))->render()]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function guardarSede(Request $request)
    {
        $nombre = $request->nombre;
        $detalle = $request->detalle;
        $referencia = $request->referencia;
        $estado = "ACTIVO";
        $telefono = $request->telefono;
        $telfreferencia = $request->telfReferencia;
        $direccion = $request->direccion;
        $distrito_id = $request->distrito_id;

        $dir = new Direccion();
        $dir->direccion = $direccion;
        $dir->referencia = $referencia;
        $dir->distrito_id = $distrito_id;
        if ($dir->save()) {
            $dir_id = \DB::SELECT('SELECT MAX(id) AS id FROM direccion');

            $sede = new Sede();
            $sede->nombre = $nombre;
            $sede->detalle = $detalle;
            $sede->referencia = $referencia;
            $sede->estado = $estado;
            $sede->telefono = $telefono;
            $sede->telfreferencia = $telfreferencia;
            $sede->direccion_id = $dir_id[0]->id;

            if ($sede->save()) {

                $sede = \DB::SELECT('SELECT s.id AS sede_id, s.nombre, s.detalle, s.referencia, s.estado, s.telefono, s.telfreferencia, s.direccion_id, d.direccion, di.distrito, p.provincia, de.departamento, di.id AS distrito_id, p.id AS provincia_id, de.id AS departamento_id
                                     FROM sede s
                                     LEFT JOIN direccion d ON d.id = s.direccion_id
                                     LEFT JOIN distrito di ON di.id = d.distrito_id
                                     LEFT JOIN provincia p ON p.id = di.provincia_id
                                     LEFT JOIN departamento de ON de.id = p.departamento_id
                                     WHERE s.estado = "ACTIVO"');

                return response()->json(["view"=>view('administracion.listSede',compact('sede'))->render()]);
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function gestionPrestamo()
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

        $prestamo = \DB::SELECT('SELECT p.id AS prestamo_id, cl.nombre, cl.apellido, cl.dni, g.nombre AS garantia, p.monto, p.fecinicio, p.fecfin 
                                 FROM prestamo p, cotizacion c, garantia g, cliente cl
                                 WHERE p.cotizacion_id = c.id AND c.garantia_id = g.id AND c.cliente_id = cl.id AND p.sede_id = "'.$usuario[0]->sede.'"
                                 ORDER BY p.id');

        $interes = \DB::SELECT('SELECT * FROM interes');

        $mora = \DB::SELECT('SELECT * FROM mora');

        $sede = \DB::SELECT('SELECT * FROM sede');


        return view('administracion.gestionPrestamo', compact('usuario', 'prestamo', 'interes', 'mora', 'sede', 'notificacion', 'cantNotificaciones'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function mostrarPrestamo(Request $request)
    {
        $prestamo_id = $request->id;
        

        $prestamo = \DB::SELECT('SELECT p.id, p.monto, p.fecinicio, p.fecfin, p.total, p.macro, p.intpagar, p.estado, ti.interes_id AS tipocredito_interes_id, p.mora_id, p.sede_id 
                                 FROM prestamo p, tipocredito_interes ti
                                 WHERE p.tipocredito_interes_id = ti.id AND p.id = "'.$prestamo_id.'"');

        return response()->json(['prestamo_id'=>$prestamo[0]->id, 'monto'=>$prestamo[0]->monto, 'fecinicio'=>$prestamo[0]->fecinicio, 'fecfin'=>$prestamo[0]->fecfin, 'total'=>$prestamo[0]->total, 'macro'=>$prestamo[0]->macro, 'intpagar'=>$prestamo[0]->intpagar, 'estado'=>$prestamo[0]->estado, 'tipocredito_interes_id'=>$prestamo[0]->tipocredito_interes_id, 'mora_id'=>$prestamo[0]->mora_id, 'sede_id'=>$prestamo[0]->sede_id]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function verifGestionPrestamo(Request $request)
    {
        $pass = $request->pass;
        
        $user = Auth::user()->id;

        $validacion = \DB::SELECT('SELECT CONCAT(dni, edad) AS pass FROM empleado WHERE users_id = "'.$user.'"');

        if ($pass == $validacion[0]->pass) {
            $resp = 1;
        }else {
            $resp = 0;
        }

        return response()->json(['resp'=>$resp]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editarPrestamo(Request $request)
    {
        $prestamo_id = $request->prestamo_id;
        $monto = $request->monto;
        $fecinicio = $request->fecinicio;
        $fecfin = $request->fecfin;
        $totalPrestamo = $request->totalPrestamo;
        $estadoMacro = $request->estadoMacro;
        $sede_id = $request->sede_id;
        $intPagar = $request->intPagar;
        $estado = $request->estado;
        $interes_id = $request->tipocredito_interes_id;
        $mora_id =  $request->mora_id;

        $tipocredito_interes_id = \DB::SELECT('SELECT id FROM tipocredito_interes WHERE interes_id = "'.$interes_id.'"');

        $pres = Prestamo::where('id', '=', $prestamo_id)->first();
        $pres->monto = $monto;
        $pres->fecinicio = $fecinicio;
        $pres->fecfin = $fecfin;
        $pres->total = $totalPrestamo;
        $pres->macro = $estadoMacro;
        $pres->intpagar = $intPagar;
        $pres->estado = $estado;
        $pres->tipocredito_interes_id = $tipocredito_interes_id[0]->id;
        $pres->mora_id = $mora_id;
        $pres->sede_id = $sede_id;

        if ($pres->save()) {
            $prestamo = \DB::SELECT('SELECT p.id AS prestamo_id, cl.nombre, cl.apellido, cl.dni, g.nombre AS garantia, p.monto, p.fecinicio, p.fecfin 
                                 FROM prestamo p, cotizacion c, garantia g, cliente cl
                                 WHERE p.cotizacion_id = c.id AND c.garantia_id = g.id AND c.cliente_id = cl.id
                                 ORDER BY p.id');

            return response()->json(["view"=>view('administracion.listPrestamo',compact('prestamo'))->render()]);
            
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function guardarGasto(Request $request)
    {
        $serie = $request->serie;
        $monto = $request->monto;
        $concepto = $request->concepto;
        $resp = "";

        $user = Auth::user()->id;
        $empleado = \DB::SELECT('SELECT id FROM empleado WHERE users_id = "'.$user.'"');

        $caja = \DB::SELECT('SELECT MAX(c.id) AS id 
                             FROM caja c, tipocaja tc 
                             WHERE c.tipocaja_id = tc.id AND c.estado = "abierta" AND tc.codigo = "CC"');

        $cajaM = \DB::SELECT('SELECT monto FROM caja WHERE id = "'.$caja[0]->id.'"');

        $actualizarCaja = $cajaM[0]->monto - $monto;

        $mov = new Movimiento();
        $mov->estado = "ACTIVO";
        $mov->monto = $monto;
        $mov->concepto = $concepto;
        $mov->tipo = "EGRESO";
        $mov->empleado = $empleado[0]->id;
        $mov->importe = $monto;
        $mov->codigo = "o";
        $mov->serie = $serie;
        $mov->caja_id = $caja[0]->id;
        $mov->codprestamo = "";
        $mov->condesembolso = "";
        $mov->codgarantia = "";
        $mov->garantia = "";

        if ($mov->save()) {

            $caja = Caja::where('id', '=', $caja[0]->id)->first();
            $caja->fecha = date('d-m-Y');
            $caja->inicio = date('H:i:s');
            $caja->fin = date('H:i:s');
            $caja->monto = $actualizarCaja;
            if ($caja->save()) {
                $resp = "1";
            }

                       
        }

        $cajaChica = \DB::SELECT('SELECT * 
                                  FROM movimiento 
                                  WHERE codigo <> "GA" AND MONTH(NOW()) = MONTH(created_at)');

        return response()->json(["pagos"=>view('administracion.tabPagosCC',compact('cajaChica'))->render(), 'resp'=>$resp]);
    }

    public function guardarGastosCG(Request $request)
    {
        $user = Auth::user()->id;
        $cajaG = \DB::SELECT('SELECT MAX(id) AS id 
                              FROM caja 
                              WHERE tipocaja_id = "2"');

        $cm = \DB::SELECT('SELECT monto
                           FROM caja
                           WHERE id = "'.$cajaG[0]->id.'"');

        $rec=$request->recibo;
        $nomRec = $request->conceptoCG;
        $comprobante = $request->comprobanteCG;
        $monto = $request->montoCG;
        $concepto = $request->garantiaCG;
        $actualizarCaja = $cm[0]->monto - $monto;
        $subido="";
        $urlGuardar="";

        if ($request->hasFile('recibo')) { 

            $nombre=$rec->getClientOriginalName();
            $extension=$rec->getClientOriginalExtension();
            $nuevoNombre=$nomRec.date("Y-m-d").".".$extension;
            $subido = Storage::disk('pagosGa')->put($nuevoNombre, \File::get($rec));
            if($subido){
                $urlGuardar='img/pagosGa/'.$nuevoNombre;
            }
        }else{
            $urlGuardar='img/pagosGa/recibodefault.jpg';
        }

        $doc = new Documento();
        $doc->nombre = $nomRec;
        $doc->asunto = "RECIBO DE PAGO";
        $doc->url = $urlGuardar;
        $doc->fecha = date("Y-m-a");
        $doc->estado = "ACTIVO";
        $doc->tipodocumento_id = "1";
        if ($doc->save()) {
            
            $mov = new Movimiento();
            $mov->codigo = "GA";
            $mov->serie = $comprobante;
            $mov->estado = "ACTIVO";
            $mov->monto = $monto;
            $mov->concepto = $nomRec;
            $mov->tipo = "EGRESO";
            $mov->empleado = $user;
            $mov->importe = $monto;
            $mov->codprestamo = "0";
            $mov->condesembolso = "0";
            $mov->codGarantia = "0";
            $mov->garantia = $concepto;
            $mov->interesPagar = "0";
            $mov->moraPagar = "0";
            $mov->caja_id = $cajaG[0]->id;
            if ($mov->save()) {
                
                $caja = Caja::where('id', '=', $cajaG[0]->id)->first();
                $caja->monto = $actualizarCaja;
                $caja->fecha = date('d-m-Y');
                $caja->inicio = date('H:i:s');
                $caja->fin = date('H:i:s');
                $caja->montofin = $actualizarCaja;
                if ($caja->save()) {

                    $movimiento = \DB::SELECT('SELECT MAX(id) AS id 
                                               FROM movimiento 
                                               WHERE codigo = "GA" AND serie = "'.$comprobante.'"');

                    $documento = \DB::SELECT('SELECT MAX(id) AS id 
                                              FROM documento 
                                              WHERE nombre = "'.$nomRec.'"');

                    $movDoc = new MovimientoDocumento();
                    $movDoc->asunto = "RECIBO DE PAGO";
                    $movDoc->detalle = "";
                    $movDoc->estado = "ACTIVO";
                    $movDoc->movimiento_id = $movimiento[0]->id;
                    $movDoc->documento_id = $documento[0]->id;
                    if ($movDoc->save()) {
                        $resp = "1";
                    }
                }
            }
        }

        $cajaGrande = \DB::SELECT('SELECT m.*, d.url AS documento 
                                   FROM movimiento m, movimiento_documento md, documento d 
                                   WHERE md.movimiento_id = m.id AND md.documento_id = d.id AND codigo = "GA" AND MONTH(NOW()) = MONTH(m.created_at)');

        return response()->json(["pagos"=>view('administracion.tabPagos',compact('cajaGrande'))->render(), 'resp'=>$resp]);
    }

    public function gestionCapital()
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

        $sede = \DB::SELECT('SELECT * FROM sede');

        $listCaja = \DB::SELECT('SELECT c.id AS caja_id, c.estado, c.monto, c.fecha, c.inicio, c.fin, c.montofin, c.empleado, s.id AS sede_id, s.nombre, c.tipocaja_id
                                 FROM caja c
                                 LEFT JOIN sede s ON c.sede_id = s.id
                                 WHERE c.sede_id = "'.$usuario[0]->sede.'"
                                 GROUP BY c.tipocaja_id');

        $capital = \DB::SELECT('SELECT c.id AS caja_id, c.estado, c.monto, c.fecha, c.inicio, c.fin, c.montofin, c.empleado, s.id AS sede_id, s.nombre, c.tipocaja_id, tc.tipo AS tipocaja
                                FROM caja c
                                LEFT JOIN sede s ON c.sede_id = s.id
                                INNER JOIN tipocaja tc ON tc.id = c.tipocaja_id
                                WHERE c.estado = "abierta" AND c.sede_id = "'.$usuario[0]->sede.'"');

        return view('administracion.gestionCapital', compact('usuario', 'sede', 'listCaja', 'capital', 'notificacion', 'cantNotificaciones'));
    }

    public function mostrarCaja(Request $request)
    {
        $caja_id = $request->id;
        

        $caja = \DB::SELECT('SELECT id AS caja_id, monto FROM caja WHERE id = "'.$caja_id.'"');

        return response()->json(['caja_id'=>$caja[0]->caja_id, 'monto'=>$caja[0]->monto]);
    }

    public function editarCapital(Request $request)
    {
        $caja_id = $request->caja_id;
        $monto = $request->monto;

        $caja = Caja::where('id', '=', $caja_id)->first();
        $caja->monto = $monto;

        if ($caja->save()) {
            $capital = \DB::SELECT('SELECT c.id AS caja_id, c.estado, c.monto, c.fecha, c.inicio, c.fin, c.montofin, c.empleado, s.id AS sede_id, s.nombre
                                FROM caja c
                                LEFT JOIN sede s ON c.sede_id = s.id
                                WHERE c.estado = "abierta"');

            return response()->json(["view"=>view('administracion.listCapital',compact('capital'))->render()]);
            
        }
    }

    public function buscarPrestamoAdministracion(Request $request)
    {
        $prestamo = \DB::SELECT('SELECT p.id AS prestamo_id, p.monto, p.fecinicio, p.fecfin, p.total, cl.id AS cliente_id, cl.nombre, cl.apellido, cl.dni, g.nombre AS garantia, p.intpagar, m.mora AS morapagar, i.porcentaje
                                 FROM prestamo p, cotizacion c, cliente cl, garantia g, mora m, tipocredito_interes tci, interes i
                                 WHERE c.cliente_id = cl.id AND p.cotizacion_id = c.id AND c.garantia_id = g.id AND p.mora_id = m.id AND p.estado = "ACTIVO DESEMBOLSADO" AND p.tipocredito_interes_id = tci.id AND tci.interes_id = i.id AND (cl.nombre LIKE "%'.$request->dato.'%" OR cl.apellido LIKE "%'.$request->dato.'%" OR cl.dni LIKE "%'.$request->dato.'%")');

        $prestamo = \DB::SELECT('SELECT p.id AS prestamo_id, cl.nombre, cl.apellido, cl.dni, g.nombre AS garantia, p.monto, p.fecinicio, p.fecfin 
                                 FROM prestamo p, cotizacion c, garantia g, cliente cl
                                 WHERE p.cotizacion_id = c.id AND c.garantia_id = g.id AND c.cliente_id = cl.id AND p.id = "'.$request->dato.'"
                                 ORDER BY p.id');

        return response()->json(["view"=>view('administracion.listPrestamo',compact('prestamo'))->render()]);
    }

    public function editarTipoGarantia(Request $request)
    {
        $tipogarantia_id = $request->tipogarantia_id;
        $nombre = $request->nombre;
        $precmaximo = $request->precmaximo;
        $precminimo = $request->precminimo;
        $pureza = $request->pureza;

        $tGar = TipoGarantia::where('id', '=', $tipogarantia_id)->first();
        $tGar->nombre = $nombre;
        $tGar->precMax = $precmaximo;
        $tGar->detalle = $precminimo;
        $tGar->pureza = $pureza;
        if ($tGar->save()) {
            
            $tipogarantia = \DB::SELECT('SELECT * FROM tipogarantia');
            
            return response()->json(["view"=>view('administracion.tabTipoGarantia',compact('tipogarantia'))->render()]);
        }


    }

    public function editarDepartamento(Request $request)
    {
        $departamento_id = $request->departamento_id;
        $nombre = $request->nombre;

        $dep = Departamento::where('id', '=', $departamento_id)->first();
        $dep->departamento = $nombre;
        if ($dep->save()) {
            
            $departamento = \DB::SELECT('SELECT * FROM departamento');

            return response()->json(["view"=>view('administracion.tabDepartamento',compact('departamento'))->render()]);
        }
        
    }

    public function editarProvincia(Request $request)
    {
        $provincia_id = $request->provincia_id;
        $nombre = $request->nombre;
        $departamento_id = $request->departamento_id;

        $pro = Provincia::where('id', '=', $provincia_id)->first();
        $pro->provincia = $nombre;
        $pro->departamento_id = $departamento_id;
        if ($pro->save()) {
            
            $provincia = \DB::SELECT('SELECT p.id, p.provincia, p.departamento_id, d.departamento 
                                  FROM provincia p, departamento d 
                                  WHERE p.departamento_id = d.id');
        

            return response()->json(["view"=>view('administracion.tabProvincia',compact('provincia'))->render()]);
        }
        
    }

    public function editarDistrito(Request $request)
    {
        $distrito_id = $request->distrito_id;
        $nombre = $request->nombre;
        $provincia_id = $request->provincia_id;
        
        $dis = Distrito::where('id', '=', $distrito_id)->first();
        $dis->distrito = $nombre;
        $dis->provincia_id = $provincia_id;
        if ($dis->save()) {
            
            
            $distrito = \DB::SELECT('SELECT di.id, di.distrito, di.provincia_id, p.provincia, p.departamento_id, d.departamento 
                                            FROM distrito di, provincia p, departamento d 
                                            WHERE di.provincia_id = p.id AND p.departamento_id = d.id');

            return response()->json(["view"=>view('administracion.tabDistrito',compact('distrito'))->render()]);
        }

    }

    public function eliminarTipoGarantia(Request $request)
    {
        $tipogarantia_id = $request->id;

        $tipo = TipoGarantia::where('id', '=', $tipogarantia_id)->first();
        if ($tipo->delete()) {
            $tipogarantia = \DB::SELECT('SELECT * FROM tipogarantia');
            
            return response()->json(["view"=>view('administracion.tabTipoGarantia',compact('tipogarantia'))->render()]);
        }
    }

    public function eliminarDepartamento(Request $request)
    {
        $departamento_id = $request->id;

        $dep = Departamento::where('id', '=', $departamento_id)->first();
        if ($dep->delete()) {
            
            $departamento = \DB::SELECT('SELECT * FROM departamento');

            return response()->json(["view"=>view('administracion.tabDepartamento',compact('departamento'))->render()]);
        }
    }

    public function eliminarProvincia(Request $request)
    {
        
        $provincia_id = $request->id;

        $pro = Provincia::where('id', '=', $provincia_id)->first();
        if ($pro->delete()) {

            $provincia = \DB::SELECT('SELECT p.id, p.provincia, p.departamento_id, d.departamento 
                                  FROM provincia p, departamento d 
                                  WHERE p.departamento_id = d.id');
        

            return response()->json(["view"=>view('administracion.tabProvincia',compact('provincia'))->render()]);
        }
    }

    public function eliminarDistrito(Request $request)
    {
        $distrito_id = $request->id;

        $dis = Distrito::where('id', '=', $distrito_id)->first();
        if ($dis->delete()) {
            
            
            $distrito = \DB::SELECT('SELECT di.id, di.distrito, di.provincia_id, p.provincia, p.departamento_id, d.departamento 
                                            FROM distrito di, provincia p, departamento d 
                                            WHERE di.provincia_id = p.id AND p.departamento_id = d.id');

            return response()->json(["view"=>view('administracion.tabDistrito',compact('distrito'))->render()]);
        }
    }
}
