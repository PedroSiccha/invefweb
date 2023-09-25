<?php

namespace App\Http\Controllers;

use App\Models\Proceso;
use App\Models\Direccion;
use App\Models\Almacen;
use App\Models\AlmacenSede;
use App\Models\Casillero;
use App\Models\GarantiaCasillero;
use App\Models\Stand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AlmacenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;

        $user = Auth::user();
        $usuario = DB::SELECT('SELECT e.nombre, e.apellido, e.id, u.name AS area, e.foto AS foto, e.sede_id AS sede
                                FROM empleado e, users u 
                                WHERE e.users_id = u.id AND u.id = "'.$user->id.'"');

        $almacen = DB::SELECT('SELECT a.id AS almacen_id, a.nombre, CONCAT(d.direccion," - ", di.distrito, " - ", p.provincia, " - ", de.departamento) AS direccion, COUNT(s.id) AS cantstand
                                FROM almacen a
                                LEFT JOIN stand s ON s.almacen_id = a.id
                                INNER JOIN direccion d ON a.direccion_id = d.id
                                INNER JOIN distrito di ON d.distrito_id = di.id
                                INNER JOIN provincia p ON di.provincia_id = p.id
                                INNER JOIN departamento de ON p.departamento_id = de.id
                                INNER JOIN almacen_sede ase ON ase.almacen_id = a.id
                                WHERE ase.sede_id = "'.$idSucursal.'"
                                GROUP BY a.id');

        $departamento = DB::SELECT('SELECT * FROM departamento');

        $direccion = DB::SELECT('SELECT * FROM direccion');

        $distrito = DB::SELECT('SELECT * FROM distrito');

        $provincia = DB::SELECT('SELECT * FROM provincia');

        return view('almacen.index', compact('almacen' , 'departamento', 'usuario', 'direccion', 'distrito', 'provincia'));
    }

    public function cargarAlmacen(Request $request)
    {
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;

        $almacen = DB::SELECT('SELECT a.id AS almacen_id, a.nombre, CONCAT(d.direccion," - ", di.distrito, " - ", p.provincia, " - ", de.departamento) AS direccion_concat, COUNT(s.id) AS cantstand,
                                       d.id AS direccion_id, d.direccion AS direccion,
                                       di.id AS distrito_id, di.distrito AS distrito,
                                       p.id AS provincia_id, p.provincia AS provincia,
                                       de.id AS departamento_id, de.departamento AS departamento
                                        FROM almacen a
                                        LEFT JOIN stand s ON s.almacen_id = a.id
                                        INNER JOIN direccion d ON a.direccion_id = d.id
                                        INNER JOIN distrito di ON d.distrito_id = di.id
                                        INNER JOIN provincia p ON di.provincia_id = p.id
                                        INNER JOIN departamento de ON p.departamento_id = de.id
                                        INNER JOIN almacen_sede ase ON ase.almacen_id = a.id
                                        WHERE ase.sede_id = "'.$idSucursal.'" AND a.id = "'.$request->id.'"
                                        GROUP BY a.id');

        $almacen_id = $almacen[0]->almacen_id;
        $nombre = $almacen[0]->nombre;
        $direccion_id = $almacen[0]->direccion_id;
        $direccion = $almacen[0]->direccion;
        $distrito_id = $almacen[0]->distrito_id;
        $distrito = $almacen[0]->distrito;
        $provincia_id = $almacen[0]->provincia_id;
        $provincia = $almacen[0]->provincia;
        $departamento_id = $almacen[0]->departamento_id;
        $departamento = $almacen[0]->departamento;

        return response()->json(['almacen_id'=>$almacen_id, 'nombre'=>$nombre, 'direccion_id'=>$direccion_id, 'direccion'=>$direccion, 'distrito_id'=>$distrito_id, 'distrito'=>$distrito, 'provincia_id'=>$provincia_id, 'provincia'=>$provincia, 'departamento_id'=>$departamento_id, 'departamento'=>$departamento]);                                
    }

    public function editarAlmacen(Request $request)
    {
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        
        $almacen_id = $request->almacen_id;
        $nombre = $request->nombre;
        $direccion = $request->direccion;
        $referencia = $request->referencia;
        $distrito_id = $request->distrito_id;
        $provincia_id = $request->provincia_id;
        $departamento_id = $request->departamento_id;

        $dir = new Direccion();
        $dir->direccion = $direccion;
        $dir->referencia = $referencia;
        $dir->distrito_id = $distrito_id;

        if ($dir->save()) {
            
            $direccion_id = DB::SELECT('SELECT MAX(id) AS id FROM direccion');
            $al = Almacen::where('id', '=',  $almacen_id)->first();
            $al->nombre = $nombre;
            $al->estado = "LIBRE";
            $al->direccion_id = $direccion_id[0]->id;

            if ($al->save()) {
                $almacen = DB::SELECT('SELECT a.id AS almacen_id, a.nombre, CONCAT(d.direccion," - ", di.distrito, " - ", p.provincia, " - ", de.departamento) AS direccion, COUNT(s.id) AS cantstand
                FROM almacen a
                LEFT JOIN stand s ON s.almacen_id = a.id
                INNER JOIN direccion d ON a.direccion_id = d.id
                INNER JOIN distrito di ON d.distrito_id = di.id
                INNER JOIN provincia p ON di.provincia_id = p.id
                INNER JOIN departamento de ON p.departamento_id = de.id
                INNER JOIN almacen_sede ase ON ase.almacen_id = a.id
                WHERE ase.sede_id = "'.$idSucursal.'"
                GROUP BY a.id');

                return response()->json(["view"=>view('almacen.tabAlmacen',compact('almacen'))->render()]);
            }
        }

        
    }

    public function buscargarantia()
    {
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $user = Auth::user();
        $usuario = DB::SELECT('SELECT e.nombre, e.apellido, e.id, u.name AS area, e.foto AS foto, e.sede_id AS sede
                                FROM empleado e, users u 
                                WHERE e.users_id = u.id AND u.id = "'.$user->id.'"');

        $almacen = DB::SELECT('SELECT a.id AS almacen_id, a.nombre, a.estado, CONCAT(d.direccion, " - ", di.distrito, " - ", p.provincia, " - ", de.departamento) AS direccion 
                                FROM almacen a
                                LEFT JOIN stand s ON s.almacen_id = a.id
                                INNER JOIN direccion d ON a.direccion_id = d.id
                                INNER JOIN distrito di ON d.distrito_id = di.id
                                INNER JOIN provincia p ON di.provincia_id = p.id
                                INNER JOIN departamento de ON p.departamento_id = de.id
                                INNER JOIN almacen_sede ase ON ase.almacen_id = a.id
                                WHERE ase.sede_id = "'.$idSucursal.'"
                                GROUP BY a.id');

        $stand = DB::SELECT('SELECT * FROM stand');

        $casillero1 = DB::SELECT('SELECT p.id AS prestamo_id, p.total, g.nombre AS garantia, c.nombre, c.estado, s.nombre AS stand, a.nombre AS almacen
                                  FROM garantia_casillero gc
                                  RIGHT JOIN casillero c ON gc.casillero_id = c.id
                                  LEFT JOIN garantia g ON gc.garantia_id = g.id
                                  LEFT JOIN cotizacion co ON co.garantia_id = g.id
                                  LEFT JOIN prestamo p ON p.cotizacion_id = co.id
                                  INNER JOIN stand s ON c.stand_id = s.id
                                  INNER JOIN almacen a ON s.almacen_id = a.id
                                  WHERE stand_id = "1"');

        $casillero2 = DB::SELECT('SELECT p.id AS prestamo_id, p.total, g.nombre AS garantia, c.nombre, c.estado, s.nombre AS stand, a.nombre AS almacen
                                  FROM garantia_casillero gc
                                  RIGHT JOIN casillero c ON gc.casillero_id = c.id
                                  LEFT JOIN garantia g ON gc.garantia_id = g.id
                                  LEFT JOIN cotizacion co ON co.garantia_id = g.id
                                  LEFT JOIN prestamo p ON p.cotizacion_id = co.id
                                  INNER JOIN stand s ON c.stand_id = s.id
                                  INNER JOIN almacen a ON s.almacen_id = a.id
                                  WHERE stand_id = "2"');

        $casillero3 = DB::SELECT('SELECT p.id AS prestamo_id, p.total, g.nombre AS garantia, c.nombre, c.estado, s.nombre AS stand, a.nombre AS almacen
                                  FROM garantia_casillero gc
                                  RIGHT JOIN casillero c ON gc.casillero_id = c.id
                                  LEFT JOIN garantia g ON gc.garantia_id = g.id
                                  LEFT JOIN cotizacion co ON co.garantia_id = g.id
                                  LEFT JOIN prestamo p ON p.cotizacion_id = co.id
                                  INNER JOIN stand s ON c.stand_id = s.id
                                  INNER JOIN almacen a ON s.almacen_id = a.id
                                  WHERE stand_id = "3"');

        $casillero4 = DB::SELECT('SELECT p.id AS prestamo_id, p.total, g.nombre AS garantia, c.nombre, c.estado, s.nombre AS stand, a.nombre AS almacen
                                    FROM garantia_casillero gc
                                    RIGHT JOIN casillero c ON gc.casillero_id = c.id
                                    LEFT JOIN garantia g ON gc.garantia_id = g.id
                                    LEFT JOIN cotizacion co ON co.garantia_id = g.id
                                    LEFT JOIN prestamo p ON p.cotizacion_id = co.id
                                    INNER JOIN stand s ON c.stand_id = s.id
                                    INNER JOIN almacen a ON s.almacen_id = a.id
                                    WHERE stand_id = "4"');
        
        $casillero5 = DB::SELECT('SELECT p.id AS prestamo_id, p.total, g.nombre AS garantia, c.nombre, c.estado, s.nombre AS stand, a.nombre AS almacen
                                          FROM garantia_casillero gc
                                          RIGHT JOIN casillero c ON gc.casillero_id = c.id
                                          LEFT JOIN garantia g ON gc.garantia_id = g.id
                                          LEFT JOIN cotizacion co ON co.garantia_id = g.id
                                          LEFT JOIN prestamo p ON p.cotizacion_id = co.id
                                          INNER JOIN stand s ON c.stand_id = s.id
                                          INNER JOIN almacen a ON s.almacen_id = a.id
                                          WHERE stand_id = "5"');
        
        $casillero6 = DB::SELECT('SELECT p.id AS prestamo_id, p.total, g.nombre AS garantia, c.nombre, c.estado, s.nombre AS stand, a.nombre AS almacen
                                    FROM garantia_casillero gc
                                    RIGHT JOIN casillero c ON gc.casillero_id = c.id
                                    LEFT JOIN garantia g ON gc.garantia_id = g.id
                                    LEFT JOIN cotizacion co ON co.garantia_id = g.id
                                    LEFT JOIN prestamo p ON p.cotizacion_id = co.id
                                    INNER JOIN stand s ON c.stand_id = s.id
                                    INNER JOIN almacen a ON s.almacen_id = a.id
                                    WHERE stand_id = "6"');
        
        $casillero7 = DB::SELECT('SELECT p.id AS prestamo_id, p.total, g.nombre AS garantia, c.nombre, c.estado, s.nombre AS stand, a.nombre AS almacen
                                          FROM garantia_casillero gc
                                          RIGHT JOIN casillero c ON gc.casillero_id = c.id
                                          LEFT JOIN garantia g ON gc.garantia_id = g.id
                                          LEFT JOIN cotizacion co ON co.garantia_id = g.id
                                          LEFT JOIN prestamo p ON p.cotizacion_id = co.id
                                          INNER JOIN stand s ON c.stand_id = s.id
                                          INNER JOIN almacen a ON s.almacen_id = a.id
                                          WHERE stand_id = "7"');
        
        $casillero8 = DB::SELECT('SELECT p.id AS prestamo_id, p.total, g.nombre AS garantia, c.nombre, c.estado, s.nombre AS stand, a.nombre AS almacen
                                    FROM garantia_casillero gc
                                    RIGHT JOIN casillero c ON gc.casillero_id = c.id
                                    LEFT JOIN garantia g ON gc.garantia_id = g.id
                                    LEFT JOIN cotizacion co ON co.garantia_id = g.id
                                    LEFT JOIN prestamo p ON p.cotizacion_id = co.id
                                    INNER JOIN stand s ON c.stand_id = s.id
                                    INNER JOIN almacen a ON s.almacen_id = a.id
                                    WHERE stand_id = "8"');
        
        $casillero9 = DB::SELECT('SELECT p.id AS prestamo_id, p.total, g.nombre AS garantia, c.nombre, c.estado, s.nombre AS stand, a.nombre AS almacen
                                          FROM garantia_casillero gc
                                          RIGHT JOIN casillero c ON gc.casillero_id = c.id
                                          LEFT JOIN garantia g ON gc.garantia_id = g.id
                                          LEFT JOIN cotizacion co ON co.garantia_id = g.id
                                          LEFT JOIN prestamo p ON p.cotizacion_id = co.id
                                          INNER JOIN stand s ON c.stand_id = s.id
                                          INNER JOIN almacen a ON s.almacen_id = a.id
                                          WHERE stand_id = "9"');

        $cantGarantia = DB::SELECT('SELECT COUNT(*) AS cantGarantia 
                                     FROM almacen a
                                     INNER JOIN stand s ON s.almacen_id = a.id
                                     INNER JOIN casillero c ON c.stand_id = s.id
                                     INNER JOIN almacen_sede ase ON ase.almacen_id = a.id
                                     WHERE c.estado = "OCUPADO" AND ase.sede_id = "'.$idSucursal.'"');

        return view('almacen.buscargarntia', compact('almacen', 'stand', 'casillero1', 'casillero2', 'casillero3', 'casillero4', 'casillero5', 'casillero6', 'casillero7', 'casillero8', 'casillero9', 'usuario', 'cantGarantia'));
    }
    
    public function mostrarStand(Request $request)
    {
        $stand = DB::SELECT('SELECT id AS stand_id, nombre FROM stand WHERE almacen_id = "'.$request->almacen_id.'"');

        return response()->json(["view"=>view('almacen.mostrarStand',compact('stand'))->render()]);
    }

    public function mostrarCasillero(Request $request)
    {
        
        $casillero = DB::SELECT('SELECT * FROM casillero WHERE stand_id = "'.$request->stand_id.'"');

        if ($casillero == null) {
            $resp = 1;
        }else {
            $resp = 0;
        }
        
        return response()->json(["view"=>view('almacen.mostrarCasillero',compact('casillero'))->render(), 'resp'=>$resp]);
    }

    public function liberarStand(Request $request)
    {
        $garantia = DB::SELECT('SELECT c.id AS casillero_id, c.estado, c.nombre AS casillero, g.id AS garantia_id, g.nombre AS garantia, g.detalle AS detalleGarantia, CONCAT(cl.nombre, " ", cl.apellido) AS nombre, p.id AS prestamo_id, p.estado AS prestamoEstado
                                 FROM casillero c
                                 INNER JOIN garantia_casillero gc ON gc.casillero_id = c.id
                                 INNER JOIN garantia g ON gc.garantia_id = g.id
                                 INNER JOIN cotizacion co ON co.garantia_id = g.id
                                 LEFT JOIN prestamo p ON p.cotizacion_id = co.id
                                 INNER JOIN cliente cl ON co.cliente_id = cl.id
                                 WHERE c.id = "'.$request->casillero_id.'" AND (c.estado = "OCUPADO" OR c.estado = "RECOGER")
                                 LIMIT 1');

        $estado = $garantia[0]->estado;                                 

        if ($garantia == null) {

            $resp = 0;

            return response()->json(['resp'=>$resp]);
        }else {
            if ($estado == "OCUPADO") {

                $resp = 1;

                return response()->json(["view"=>view('almacen.modalNoLiberar',compact('garantia'))->render(), 'resp' => $resp]);

            }elseif ($estado == "RECOGER") {

                $resp = 2;
                $cliente = $garantia[0]->nombre;
                $garantia_id = $garantia[0]->garantia_id;
                $prestamo_id = $garantia[0]->prestamo_id;

                return response()->json(['resp' => $resp, 'cliente' => $cliente, 'garantia_id' => $garantia_id, 'prestamo_id' => $prestamo_id]);
            }
            
        }
    }

    public function eliminarCasillero(Request $request)
    {
        $cas = Casillero::find($request->casillero_id);
        $cas->delete();
    }

    public function buscarStand(Request $request)
    {
        $stand = DB::SELECT('SELECT * FROM stand WHERE Almacen_id = "'.$request->almacen.'" AND estado = "LIBRE"');

        return response()->json(["view"=>view('almacen.listStand',compact('stand'))->render()]);
    }

    public function buscarCasillero(Request $request)
    {
        $casillero = DB::SELECT('SELECT * FROM casillero WHERE stand_id = "'.$request->stand.'" AND estado = "LIBRE"');

        return response()->json(["view"=>view('almacen.listCasillero',compact('casillero'))->render()]);
    }

    public function cargarStand(Request $request)
    {
        $stand = DB::SELECT('SELECT * FROM stand WHERE Almacen_id = "'.$request->id.'"');

        return response()->json(["view"=>view('almacen.comboStand',compact('stand'))->render()]);
    }

    public function guardarAlmacen(Request $request)
    {
        
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        
        $dir = new Direccion();
        $dir->direccion = $request->direccion;
        $dir->distrito_id = $request->distrito_id;
        if ($dir->save()) {

            $direccion_id = DB::SELECT('SELECT MAX(id) AS id FROM direccion');

            $almacen = new Almacen();
            $almacen->nombre = $request->nombre;
            $almacen->direccion_id = $direccion_id[0]->id;
            $almacen->estado = "LIBRE";
            if ($almacen->save()) {
                 $idAlmacen = $almacen->id;
                
                $almacenSucursal = new AlmacenSede();
                $almacenSucursal->detalle =  "";
                $almacenSucursal->sede_id = $idSucursal;
                $almacenSucursal->almacen_id = $idAlmacen;
                if ($almacenSucursal->save()) {
                    
                }
                
                
                $almacen = DB::SELECT('SELECT a.id AS almacen_id, a.nombre, CONCAT(d.direccion," - ", di.distrito, " - ", p.provincia, " - ", de.departamento) AS direccion, COUNT(s.id) AS cantstand
                                        FROM almacen a
                                        LEFT JOIN stand s ON s.almacen_id = a.id
                                        INNER JOIN direccion d ON a.direccion_id = d.id
                                        INNER JOIN distrito di ON d.distrito_id = di.id
                                        INNER JOIN provincia p ON di.provincia_id = p.id
                                        INNER JOIN departamento de ON p.departamento_id = de.id
                                        INNER JOIN almacen_sede ase ON ase.almacen_id = a.id
                                        WHERE ase.sede_id = "'.$idSucursal.'"
                                        GROUP BY a.id');

                return response()->json(["view"=>view('almacen.tabAlmacen',compact('almacen'))->render()]);
            }
        }

        

        
    }

    public function mostrarCantCasulleros(Request $request)
    {
        $almacen_id = $request->almacen_id;
        

        $numStand = DB::SELECT('SELECT a.id AS almacen_id, s.id AS stand_id, s.nombre AS stand, COUNT(c.id) AS cantCasilleros
                                 FROM almacen a
                                 LEFT JOIN stand s ON s.almacen_id = a.id
                                 LEFT JOIN casillero c ON c.stand_id = s.id
                                 WHERE a.id = "'.$almacen_id.'"
                                 GROUP BY s.id
                                 ORDER BY s.id ASC');

        return response()->json(["view"=>view('almacen.tabDivCantCasillero',compact('numStand'))->render()]);
    }

    public function guardarStand(Request $request)
    {
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        
        $stand = new Stand();
        $stand->nombre = $request->nombre;
        $stand->detalle = $request->detalle;
        $stand->almacen_id = $request->almacen_id;
        $stand->estado = "LIBRE";
        if ($stand->save()) {
            $almacen = DB::SELECT('SELECT a.id AS almacen_id, a.nombre, CONCAT(d.direccion," - ", di.distrito, " - ", p.provincia, " - ", de.departamento) AS direccion, COUNT(s.id) AS cantstand, COUNT(c.id) AS cantcasillero
                                    FROM almacen a
                                    LEFT JOIN stand s ON s.almacen_id = a.id
                                    LEFT JOIN casillero c ON c.stand_id = s.id
                                    INNER JOIN direccion d ON a.direccion_id = d.id
                                    INNER JOIN distrito di ON d.distrito_id = di.id
                                    INNER JOIN provincia p ON di.provincia_id = p.id
                                    INNER JOIN departamento de ON p.departamento_id = de.id
                                    INNER JOIN almacen_sede ase ON ase.almacen_id = a.id
                                    WHERE ase.sede_id = "'.$idSucursal.'"
                                    GROUP BY a.id');

            return response()->json(["view"=>view('almacen.tabAlmacen',compact('almacen'))->render()]);
        }

        
    }

    public function guardarCasillero(Request $request)
    {
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        
        $casillero = new Casillero();
        $casillero->nombre = $request->nombre;
        $casillero->detalle = $request->detalle;
        $casillero->stand_id = $request->stand_id;
        $casillero->estado = "LIBRE";
        if ($casillero->save()) {
            $almacen = DB::SELECT('SELECT a.id AS almacen_id, a.nombre, CONCAT(d.direccion," - ", di.distrito, " - ", p.provincia, " - ", de.departamento) AS direccion, COUNT(s.id) AS cantstand, COUNT(c.id) AS cantcasillero
                                    FROM almacen a
                                    LEFT JOIN stand s ON s.almacen_id = a.id
                                    LEFT JOIN casillero c ON c.stand_id = s.id
                                    INNER JOIN direccion d ON a.direccion_id = d.id
                                    INNER JOIN distrito di ON d.distrito_id = di.id
                                    INNER JOIN provincia p ON di.provincia_id = p.id
                                    INNER JOIN departamento de ON p.departamento_id = de.id
                                    INNER JOIN almacen_sede ase ON ase.almacen_id = a.id
                                    WHERE ase.sede_id = "'.$idSucursal.'"
                                    GROUP BY a.id');

            return response()->json(["view"=>view('almacen.tabAlmacen',compact('almacen'))->render()]);
        }

        
    }

    public function verProvinciaAlmacen(Request $request){
        $departamento_id = $request->departamento_id;

        $provincia = DB::SELECT('SELECT * FROM provincia WHERE departamento_id ="'.$departamento_id.'"');
        
        return response()->json(["view"=>view('almacen.cbProvincia', compact('provincia'))->render(), '$departamento_id'=>$departamento_id]);
    }

    public function verDistritoAlmacen(Request $request){
        $id = $request->provincia_id;

        $distrito = DB::SELECT('SELECT * FROM distrito WHERE provincia_id ="'.$id.'"');
        
        return response()->json(["view"=>view('almacen.cbDistrito', compact('distrito'))->render(), '$id'=>$id]);
    }

    public function buscarGarantiaCasillero(Request $request){
        $id = $request->id;

        $revisar = DB::SELECT('SELECT g.nombre AS garantia, g.detalle AS detallegarantia, cl.nombre AS nomcliente, cl.apellido AS apecliente FROM prestamo p, cotizacion c, garantia g, cliente cl WHERE c.cliente_id = cl.id AND c.garantia_id = g.id AND p.cotizacion_id = c.id AND p.estado = "PAGADO" AND p.id = "'.$request->id.'"');
        
        $garantia = $revisar[0]->garantia;
        $detalleGarantia = $revisar[0]->detallegarantia;
        $nomCliente = $revisar[0]->nomcliente;
        $apeCliente = $revisar[0]->apecliente;

        return response()->json(['garantia'=>$garantia, 'detalleGarantia'=>$detalleGarantia, 'nomCliente'=>$nomCliente, 'apeCliente'=>$apeCliente]);
    }

    public function recoger(Request $request){
        $dni = $request->dni;
        $id = $request->id;

        $revisar = DB::SELECT('SELECT g.id AS garantia_id 
                                FROM prestamo p, cotizacion c, garantia g, cliente cl 
                                WHERE c.cliente_id = cl.id AND c.garantia_id = g.id AND p.cotizacion_id = c.id AND p.estado = "PAGADO" AND p.id = "'.$id.'" AND cl.dni = "'.$dni.'"');

        if ($revisar == null) {
            $resp = "Numero de DNI Erroneo";
        }else {
            $garantiaCasillero = DB::SELECT('SELECT casillero_id FROM garantia_casillero WHERE garantia_id = "'.$revisar[0]->garantia_id.'"');

            $cas = Casillero::where('id', '=',  $garantiaCasillero[0]->casillero_id)->first();
            $cas->estado = "LIBRE";

            if ($cas->save()) {
                $resp = "Garantia Entregada";
            }
        }

        /* Inicio */

            $almacen = DB::SELECT('SELECT a.id AS almacen_id, a.nombre, a.estado, CONCAT(d.direccion, " - ", di.distrito, " - ", p.provincia, " - ", de.departamento) AS direccion 
                                    FROM almacen a, direccion d, distrito di, provincia p, departamento de
                                    WHERE a.direccion_id = d.id AND d.distrito_id = di.id AND di.provincia_id = p.id AND p.departamento_id = de.id');

            $stand = DB::SELECT('SELECT * FROM stand');

            $casillero1 = DB::SELECT('SELECT p.id AS prestamo_id, p.total, g.nombre AS garantia, c.nombre, c.estado, s.nombre AS stand, a.nombre AS almacen
                                    FROM garantia_casillero gc
                                    RIGHT JOIN casillero c ON gc.casillero_id = c.id
                                    LEFT JOIN garantia g ON gc.garantia_id = g.id
                                    LEFT JOIN cotizacion co ON co.garantia_id = g.id
                                    LEFT JOIN prestamo p ON p.cotizacion_id = co.id
                                    INNER JOIN stand s ON c.stand_id = s.id
                                    INNER JOIN almacen a ON s.almacen_id = a.id
                                    WHERE stand_id = "1"');

            $casillero2 = DB::SELECT('SELECT p.id AS prestamo_id, p.total, g.nombre AS garantia, c.nombre, c.estado, s.nombre AS stand, a.nombre AS almacen
                                    FROM garantia_casillero gc
                                    RIGHT JOIN casillero c ON gc.casillero_id = c.id
                                    LEFT JOIN garantia g ON gc.garantia_id = g.id
                                    LEFT JOIN cotizacion co ON co.garantia_id = g.id
                                    LEFT JOIN prestamo p ON p.cotizacion_id = co.id
                                    INNER JOIN stand s ON c.stand_id = s.id
                                    INNER JOIN almacen a ON s.almacen_id = a.id
                                    WHERE stand_id = "2"');

            $casillero3 = DB::SELECT('SELECT p.id AS prestamo_id, p.total, g.nombre AS garantia, c.nombre, c.estado, s.nombre AS stand, a.nombre AS almacen
                                    FROM garantia_casillero gc
                                    RIGHT JOIN casillero c ON gc.casillero_id = c.id
                                    LEFT JOIN garantia g ON gc.garantia_id = g.id
                                    LEFT JOIN cotizacion co ON co.garantia_id = g.id
                                    LEFT JOIN prestamo p ON p.cotizacion_id = co.id
                                    INNER JOIN stand s ON c.stand_id = s.id
                                    INNER JOIN almacen a ON s.almacen_id = a.id
                                    WHERE stand_id = "3"');

            $casillero4 = DB::SELECT('SELECT p.id AS prestamo_id, p.total, g.nombre AS garantia, c.nombre, c.estado, s.nombre AS stand, a.nombre AS almacen
                                        FROM garantia_casillero gc
                                        RIGHT JOIN casillero c ON gc.casillero_id = c.id
                                        LEFT JOIN garantia g ON gc.garantia_id = g.id
                                        LEFT JOIN cotizacion co ON co.garantia_id = g.id
                                        LEFT JOIN prestamo p ON p.cotizacion_id = co.id
                                        INNER JOIN stand s ON c.stand_id = s.id
                                        INNER JOIN almacen a ON s.almacen_id = a.id
                                        WHERE stand_id = "4"');

            $casillero5 = DB::SELECT('SELECT p.id AS prestamo_id, p.total, g.nombre AS garantia, c.nombre, c.estado, s.nombre AS stand, a.nombre AS almacen
                                            FROM garantia_casillero gc
                                            RIGHT JOIN casillero c ON gc.casillero_id = c.id
                                            LEFT JOIN garantia g ON gc.garantia_id = g.id
                                            LEFT JOIN cotizacion co ON co.garantia_id = g.id
                                            LEFT JOIN prestamo p ON p.cotizacion_id = co.id
                                            INNER JOIN stand s ON c.stand_id = s.id
                                            INNER JOIN almacen a ON s.almacen_id = a.id
                                            WHERE stand_id = "5"');

            $casillero6 = DB::SELECT('SELECT p.id AS prestamo_id, p.total, g.nombre AS garantia, c.nombre, c.estado, s.nombre AS stand, a.nombre AS almacen
                                        FROM garantia_casillero gc
                                        RIGHT JOIN casillero c ON gc.casillero_id = c.id
                                        LEFT JOIN garantia g ON gc.garantia_id = g.id
                                        LEFT JOIN cotizacion co ON co.garantia_id = g.id
                                        LEFT JOIN prestamo p ON p.cotizacion_id = co.id
                                        INNER JOIN stand s ON c.stand_id = s.id
                                        INNER JOIN almacen a ON s.almacen_id = a.id
                                        WHERE stand_id = "6"');

            $casillero7 = DB::SELECT('SELECT p.id AS prestamo_id, p.total, g.nombre AS garantia, c.nombre, c.estado, s.nombre AS stand, a.nombre AS almacen
                                            FROM garantia_casillero gc
                                            RIGHT JOIN casillero c ON gc.casillero_id = c.id
                                            LEFT JOIN garantia g ON gc.garantia_id = g.id
                                            LEFT JOIN cotizacion co ON co.garantia_id = g.id
                                            LEFT JOIN prestamo p ON p.cotizacion_id = co.id
                                            INNER JOIN stand s ON c.stand_id = s.id
                                            INNER JOIN almacen a ON s.almacen_id = a.id
                                            WHERE stand_id = "7"');

            $casillero8 = DB::SELECT('SELECT p.id AS prestamo_id, p.total, g.nombre AS garantia, c.nombre, c.estado, s.nombre AS stand, a.nombre AS almacen
                                        FROM garantia_casillero gc
                                        RIGHT JOIN casillero c ON gc.casillero_id = c.id
                                        LEFT JOIN garantia g ON gc.garantia_id = g.id
                                        LEFT JOIN cotizacion co ON co.garantia_id = g.id
                                        LEFT JOIN prestamo p ON p.cotizacion_id = co.id
                                        INNER JOIN stand s ON c.stand_id = s.id
                                        INNER JOIN almacen a ON s.almacen_id = a.id
                                        WHERE stand_id = "8"');

            $casillero9 = DB::SELECT('SELECT p.id AS prestamo_id, p.total, g.nombre AS garantia, c.nombre, c.estado, s.nombre AS stand, a.nombre AS almacen
                                            FROM garantia_casillero gc
                                            RIGHT JOIN casillero c ON gc.casillero_id = c.id
                                            LEFT JOIN garantia g ON gc.garantia_id = g.id
                                            LEFT JOIN cotizacion co ON co.garantia_id = g.id
                                            LEFT JOIN prestamo p ON p.cotizacion_id = co.id
                                            INNER JOIN stand s ON c.stand_id = s.id
                                            INNER JOIN almacen a ON s.almacen_id = a.id
                                            WHERE stand_id = "9"');

        /* Fin */

        return response()->json(["view"=>view('almacen.verAlmacen',compact('almacen', 'stand', 'casillero1', 'casillero2', 'casillero3', 'casillero4', 'casillero5', 'casillero6', 'casillero7', 'casillero8', 'casillero9'))->render()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function buscarGarantiaPrestamo(Request $request)
    {
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        
        $prestamo_id = $request->dato;

        $garantia = DB::SELECT('SELECT p.id AS prestamo_id, g.id AS garantia_id, g.nombre AS garantia, g.detalle AS detgarantia, CONCAT(ca.nombre, " - ", s.nombre, " - ", a.nombre) AS casillero, ca.estado
                                 FROM garantia g
                                 INNER JOIN cotizacion c ON c.garantia_id = g.id
                                 INNER JOIN garantia_casillero ga ON ga.garantia_id = g.id
                                 INNER JOIN prestamo p ON p.cotizacion_id = c.id
                                 INNER JOIN casillero ca ON ga.casillero_id = ca.id
                                 INNER JOIN stand s ON ca.stand_id = s.id
                                 INNER JOIN almacen a ON s.almacen_id = a.id
                                 INNER JOIN almacen_sede ase ON ase.almacen_id = a.id
                                 WHERE ca.estado != "LIBRE" AND ase.sede_id = "'.$idSucursal.'" AND p.id LIKE "%'.$prestamo_id.'%"');

        return response()->json(["view"=>view('prestamo.tabGarantiaAlmacen',compact('garantia'))->render()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function recogerGarantia(Request $request)
    {
        $prestamo_id = $request->id;
        $dni = $request->dni;

        $datos = DB::SELECT('SELECT p.id AS prestamo_id, c.id AS cotizacion_id, g.id AS garantia_id, gc.id AS garantiacasillero_id, ca.id AS casillero_id, cl.id AS cliente_id, cl.dni AS dni 
                              FROM prestamo p, cotizacion c, garantia g, garantia_casillero gc, casillero ca, cliente cl
                              WHERE p.cotizacion_id = c.id AND c.garantia_id = g.id AND gc.garantia_id = g.id AND gc.casillero_id = ca.id AND c.cliente_id = cl.id AND p.id = "'.$prestamo_id.'"');

        
        //dd($dni);
        if ( $datos[0]->dni == $dni ) {
            $garCas = GarantiaCasillero::where('id', '=',  $datos[0]->garantiacasillero_id)->first();
            $garCas->estado = "LIBRE";
            if ($garCas->save()) {
                $cas = Casillero::where('id', '=', $datos[0]->casillero_id)->first();
                $cas->estado = "LIBRE";
                if ($cas->save()) {
                    $garantia = DB::SELECT('SELECT p.id AS prestamo_id, g.id AS garantia_id, g.nombre AS garantia, g.detalle AS detgarantia, CONCAT(ca.nombre, " - ", s.nombre, " - ", a.nombre) AS casillero, ca.estado
                                            FROM garantia g, cotizacion c, prestamo p, casillero ca, stand s, almacen a, garantia_casillero ga
                                            WHERE c.garantia_id = g.id AND p.cotizacion_id = c.id AND ga.garantia_id = g.id AND ga.casillero_id = ca.id AND ca.Stand_id = s.id AND s.Almacen_id = a.id AND ca.estado != "LIBRE"');
                    $mensaje = "El casillero se liberó correctamente";
                    return response()->json(["view"=>view('prestamo.tabGarantiaAlmacen',compact('garantia'))->render(), 'mensaje'=>$mensaje]);
                }
            }
        }else {
            $garantia = DB::SELECT('SELECT p.id AS prestamo_id, g.id AS garantia_id, g.nombre AS garantia, g.detalle AS detgarantia, CONCAT(ca.nombre, " - ", s.nombre, " - ", a.nombre) AS casillero, ca.estado
                                    FROM garantia g, cotizacion c, prestamo p, casillero ca, stand s, almacen a, garantia_casillero ga
                                    WHERE c.garantia_id = g.id AND p.cotizacion_id = c.id AND ga.garantia_id = g.id AND ga.casillero_id = ca.id AND ca.Stand_id = s.id AND s.Almacen_id = a.id AND ca.estado != "LIBRE"');
            $mensaje = "DNI no es válido";
            return response()->json(["view"=>view('prestamo.tabGarantiaAlmacen',compact('garantia'))->render(), 'mensaje'=>$mensaje]);
        }
    }

}