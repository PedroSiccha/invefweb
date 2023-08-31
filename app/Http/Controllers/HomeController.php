<?php

namespace App\Http\Controllers;

use App\Application\UseCases\Cotizacion\SearchCotizacionUseCase;
use App\Models\Cliente;
use App\Models\Proceso;
use App\Models\Sede;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    protected $searchCotizacionUseCase;
    
    public function __construct(
        SearchCotizacionUseCase $searchCotizacionUseCase
    )
    {
        $this->middleware('auth');
        $this->searchCotizacionUseCase = $searchCotizacionUseCase;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $id = auth()->user()->id;
        $Proceso = new Proceso();
        
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        
        $rol = DB::SELECT('SELECT * FROM userrol ur
                            JOIN rol r ON r.id = ur.rol_id
                            WHERE ur.users_id = "'.$id.'"');
                        
        
        if ($rol == "Cliente") {

            

            $user = Auth::user();
            $usuario = DB::SELECT('SELECT e.nombre, e.apellido, e.id, u.name AS area, e.foto AS foto 
                                    FROM empleado e, users u 
                                    WHERE e.users_id = u.id AND u.id = "'.$user->id.'"');
                                    
            if ($usuario == null) {
                Auth::logout();
                return redirect('/');
            }

            $cliente = DB::SELECT('SELECT c.id as cliente_id, c.nombre, c.apellido, c.dni, c.correo, dr.direccion, c.fecnac, c.edad, c.genero, c.foto, c.facebook, c.ingmax, c.ingmin, c.gasmax, c.gasmin, c.created_at, o.nombre AS ocupacion, r.recomendacion AS recomendacion, c.evaluacion AS evaluacion, c.telefono, c.whatsapp, c.referencia 
                                    FROM cliente c, ocupacion o, recomendacion r, direccion dr
                                    WHERE c.ocupacion_id = o.id AND c.recomendacion_id = r.id AND c.direccion_id = dr.id AND c.id = "'.$id.'" AND c.sede_id = "'.$idSucursal.'" GROUP BY c.id');

            $cantCotizacion = DB::SELECT('SELECT COUNT(c.id) AS cantCotizacion 
                                           FROM cotizacion c, cliente cl 
                                           WHERE c.cliente_id = cl.id AND cl.id = "'.$id.'" AND c.sede_id = "'.$idSucursal.'"');

            $cantCotPendiente = DB::SELECT('SELECT COUNT(c.id) AS cantCotizacion 
                                            FROM cotizacion c, cliente cl 
                                            WHERE c.cliente_id = cl.id AND c.estado = "PAGADO" AND cl.id = "'.$id.'" AND c.sede_id = "'.$idSucursal.'"');

            $cantCotAceptadas = DB::SELECT('SELECT COUNT(c.id) AS cantCotizacion 
                                            FROM cotizacion c, cliente cl 
                                            WHERE c.cliente_id = cl.id AND c.estado = "ACTIVO" AND cl.id = "'.$id.'" AND c.sede_id = "'.$idSucursal.'"');

            $cantPrestamo = DB::SELECT('SELECT COUNT(p.id) AS catPrestamo 
                                        FROM prestamo p, cotizacion c 
                                        WHERE p.cotizacion_id = c.id AND p.cotizacion_id = c.id AND c.cliente_id = "'.$id.'" AND p.sede_id = "'.$idSucursal.'"');

            $cantPrePendiente = DB::SELECT('SELECT COUNT(p.id) AS catPrestamo 
                                            FROM prestamo p, cotizacion c 
                                            WHERE p.cotizacion_id = c.id AND p.estado = "PAGADO" AND c.cliente_id = "'.$id.'" AND p.sede_id = "'.$idSucursal.'"');

            $cantPreAceptadas = DB::SELECT('SELECT COUNT(p.id) AS catPrestamo  
                                            FROM prestamo p, cotizacion c 
                                            WHERE p.cotizacion_id = c.id AND p.estado = "ACTIVO" AND c.cliente_id = "'.$id.'"');

            $prestamo = DB::SELECT('SELECT p.id AS prestamo_id, p.monto, p.fecinicio, p.fecfin, p.total, p.estado, p.created_at, g.nombre, p.intpagar, m.mora
                                    FROM prestamo p, cotizacion c, garantia g, mora m
                                    WHERE p.cotizacion_id = c.id AND c.garantia_id = g.id AND m.id = p.mora_id AND c.cliente_id = "'.$id.'"');

            $cotizacion = DB::SELECT('SELECT c.id AS cotizacion_id, c.max, c.min, c.created_at, c.estado, tp.nombre AS tipoPrestamo, g.nombre AS garantia
                                    FROM cotizacion c, tipoprestamo tp, garantia g
                                    WHERE c.garantia_id = g.id AND c.tipoprestamo_id = tp.id AND c.estado = "PRESTAMO" AND c.cliente_id = "'.$id.'"');
            
    
            $listCotizaciones = DB::SELECT('SELECT c.id AS cotizacion_id, tp.nombre AS tipoPrestamo, g.nombre AS garantia, g.detalle AS detalleGarantia, c.max, c.min, CONCAT(e.nombre, " ", e.apellido) AS empleado 
                                            FROM cotizacion c, tipoprestamo tp, garantia g, empleado e 
                                            WHERE c.tipoprestamo_id = tp.id AND c.garantia_id = g.id AND c.empleado_id = e.id AND c.estado = "PRESTAMO" AND c.cliente_id = "'.$id.'"');

            $tipoPrestamo = DB::SELECT('SELECT * FROM tipoprestamo'); 
            $tipoGarantia = DB::SELECT('SELECT * FROM tipogarantia WHERE detalle != "tj"');
            $tipoJoya = DB::SELECT('SELECT * FROM tipogarantia WHERE detalle != "tp"');
            $almacen = DB::SELECT('SELECT * FROM almacen');
            $distrito = DB::SELECT('SELECT * FROM distrito');
            $provincia = DB::SELECT('SELECT * FROM provincia');
            $departamento = DB::SELECT('SELECT * FROM departamento');
            $ocupacion = DB::SELECT('SELECT * FROM ocupacion');
            $tipoDocumento = DB::SELECT('SELECT * FROM tipodocide');
            

            return view('cliente', compact('cliente', 'cantCotizacion', 'cantCotPendiente', 'cantCotAceptadas', 'cantPrestamo', 'cantPrePendiente', 'cantPreAceptadas', 'prestamo', 'cotizacion', 'cotizacion', 'listCotizaciones', 'tipoPrestamo', 'tipoGarantia', 'tipoJoya', 'almacen', 'distrito', 'provincia', 'departamento', 'ocupacion', 'tipoDocumento', 'usuario'));

        }else {
            
            
            $user = Auth::user();
            $ingresos = [];
            $egresos = [];
            $clientes = [];
            $prestamos = [];
            $desembolsos = [];
            $liquidaciones = [];
            $vendidos = [];
            $renovados = [];
            

            $informes = DB::SELECT('SELECT tp.nombre AS credito, tp.detalle AS resumen, tp.imagen, r.requisito AS requisito 
                                     FROM tipoprestamo tp 
                                     LEFT JOIN tipocredito_requisito tr ON tp.id = tr.tipocredito_id 
                                     LEFT JOIN requisitos r ON r.id = tr.requisitos_id');

            $usuario = DB::SELECT('SELECT e.nombre, e.apellido, e.id, u.name AS area, e.foto AS foto, e.sede_id AS sede
                                    FROM empleado e, users u 
                                    WHERE e.users_id = u.id AND u.id = "'.$user->id.'"');
                                    
            $sucursales = DB::SELECT('SELECT * 
                                       FROM sede
                                       WHERE estado = "ACTIVO"');
                                       
            foreach ($sucursales as $s) {
                $ingreso = DB::select('SELECT COALESCE(SUM(m.monto), 0) AS sum FROM sede s
                                        INNER JOIN caja c on c.sede_id = s.id
                                        INNER JOIN movimiento m ON m.caja_id = c.id
                                        WHERE m.tipo = "INGRESO" AND c.estado = "ABIERTA" AND s.estado = "ACTIVO" AND s.id = "'.$s->id.'"');
            
                $egreso = DB::select('SELECT COALESCE(SUM(m.monto), 0) AS sum FROM sede s
                                       INNER JOIN caja c on c.sede_id = s.id
                                       INNER JOIN movimiento m ON m.caja_id = c.id
                                       WHERE m.tipo = "EGRESO" AND c.estado = "ABIERTA" AND s.estado = "ACTIVO" AND s.id = "'.$s->id.'"');
                                       
                $prestamo = DB::SELECT('SELECT COALESCE(COUNT(*), 0) AS prestamo
                                          FROM prestamo 
                                          WHERE estado = "ACTIVO DESEMBOLSADO" AND sede_id = "'.$s->id.'"');
                                          
                $desembolso = DB::SELECT('SELECT COALESCE(COUNT(*), 0) AS desembolso
                                          FROM prestamo 
                                          WHERE estado = "ACTIVO" AND sede_id = "'.$s->id.'"');
                                          
                $liquidacion = DB::SELECT('SELECT COALESCE(COUNT(*), 0) AS liquidacion
                                          FROM prestamo 
                                          WHERE estado = "LIQUIDACION" AND sede_id = "'.$s->id.'"');
                                          
                $vendido = DB::SELECT('SELECT COALESCE(COUNT(*), 0) AS vendidos
                                          FROM prestamo 
                                          WHERE estado = "VENDIDO" AND sede_id = "'.$s->id.'"');
                                          
                $renovado = DB::SELECT('SELECT COALESCE(COUNT(*), 0) AS renovados
                                          FROM prestamo 
                                          WHERE estado = "RENOVADO" AND sede_id = "'.$s->id.'"');
                                          
                $cliente = DB::SELECT('SELECT COALESCE(COUNT(*), 0) AS clientes 
                                         FROM cliente 
                                         WHERE sede_id = "'.$s->id.'"');
            
                $ingresos[] = $ingreso[0]->sum;
                $egresos[] = $egreso[0]->sum;
                
                $clientes[] = $cliente[0]->clientes;
                $prestamos[] = $prestamo[0]->prestamo;
                $desembolsos[] = $desembolso[0]->desembolso;
                $liquidaciones[] = $liquidacion[0]->liquidacion;
                $vendidos[] = $vendido[0]->vendidos;
                $renovados[] = $renovado[0]->renovados;
            }
            
            //dd($ingreso);
                                    
            if ($usuario == null) {
                
                Auth::logout();
                return redirect('/');
                
            }

            return view('home')->with([
                'sucursales' => $sucursales,
                'ingresos' => $ingresos,
                'egresos' => $egresos,
                'usuario' => $usuario,
                'rol' => $rol,
                'clientes' => $clientes,
                'prestamos' => $prestamos,
                'desembolsos' => $desembolsos,
                'liquidaciones' => $liquidaciones,
                'vendidos' => $vendidos,
                'renovados' => $renovados
            ]);
            //return view('home', compact('informes', 'usuario', 'rol', 'sucursales'));
            
        }          
    }

    public function web()
    {

        return view('web.index');
    }

    public function buscarClienteH(Request $request)
    {
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $code = 500;
        $message = "";
        $data = "";
        
        $dni = $request->dni;

        $cliente = Cliente::where('dni', $dni)->first();
        $sucursal = Sede::where('id', $idSucursal)->first();

        if ($cliente == null) {
            $estado = 500;
            $message = "El cliente no existe";
            $data = "cliente";
        }else {
            $estado = 200;
            $message = $cliente->id;
            $data = "perfilCliente";   
        }
        
        return response()->json(['estado' => $estado, 'message' => $message, 'data' => $data]);
    }
    
    public function buscarClienteHP(Request $request)
    {
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $code = 500;
        $message = "";
        $dni = $request->dni;
        $data = [
                    'dniCliente' => $dni,
                ];

        $cliente = Cliente::where('dni', $dni)->first();

        if ($cliente == null) {
            
            $code = 500;
            $message = "El cliente no existe";
            $data = [
                        'url' => "cliente",
                        'estado' => "0"
                    ];
            
        }else {
            $cotizacion = $this->searchCotizacionUseCase->execute($data);

            if ($cotizacion == null) {
                
                $id = $cliente->id;
                $estado = "1";
                
                $code = 500;
                $message = "No existe cotización para este cliente";
                $data = [
                            'id' => $cliente->id,
                            'estado' => "1"
                        ];
                        
            }else {
                if ($cotizacion->sucursal_id == $idSucursal) {
                    $code = 200;
                    $message = "Lista de cotizaciones";
                    $data = [
                                'cotizacion' => $cotizacion,
                                'estado' => "2"
                            ];
                } else {
                    $code = 200;
                    $message = "Esta cotización pertenece a la sucursal: \n".$cotizacion->sucursal_nombre;
                    $data = [
                                'cotizacion' => $cotizacion,
                                'estado' => "3"
                            ];
                }
                
                
            }
            
        }
        
        return response()->json(['code'=>$code, 'message'=>$message, 'data'=>$data]);
    }

    public function verificarCaja(Request $request)
    {
        $caja = DB::SELECT('SELECT MAX(id) AS id FROM caja');

        if ($caja[0]->id == null) {
            $resp = "sincaja";
            return response()->json(['resp'=>$resp]);
        }else {
            $verCaja = DB::SELECT('SELECT id FROM caja WHERE estado = "ABIERTA" AND id = "'.$caja[0]->id.'"');
            if ($verCaja == null) {

                $caja = DB::SELECT('SELECT * FROM caja WHERE id = "'.$caja[0]->id.'"');

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
