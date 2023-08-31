<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Direccion;
use App\Models\Ocupacion;
use App\Models\Proceso;
use App\Models\Recomendacion;
use App\Models\Sede;
use App\Models\TipoDocIde;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class AtencionClienteController extends Controller
{
    public function cartera()
    {
        $user = Auth::user();
        $Proceso = new Proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $usuario = DB::SELECT('SELECT e.nombre, e.apellido, e.id, u.name AS area, e.foto AS foto, e.sede_id AS sede
                                FROM empleado e, users u 
                                WHERE e.users_id = u.id AND u.id = "'.$user->id.'"');

        $clientes = DB::SELECT(' SELECT cl.id AS cliente_id, cl.nombre, cl.apellido, cl.dni, cl.correo, dr.direccion, cl.fecnac, cl.edad, cl.genero, cl.foto, cl.facebook, cl.ingmax, cl.ingmin, cl.gasmax, cl.gasmin, o.nombre AS ocupacion, r.recomendacion AS recomendacion , cl.whatsapp 
                                  FROM cliente cl 
                                  INNER JOIN ocupacion o ON cl.ocupacion_id = o.id 
                                  INNER JOIN recomendacion r ON cl.recomendacion_id = r.id 
                                  INNER JOIN direccion dr ON cl.direccion_id = dr.id
                                  WHERE cl.sede_id = "'.$idSucursal.'"');

        $cantClientes = count($clientes);

        return view('atencioncliente.cartera', compact('cantClientes', 'clientes', 'usuario'));
    }

    public function buscarCliente(Request $request)
    {
        $Proceso = new Proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        
        $clientes = DB::SELECT('SELECT cl.id AS cliente_id, cl.nombre, cl.apellido, cl.dni, cl.correo, dr.direccion, cl.fecnac, cl.edad, cl.genero, cl.foto, cl.facebook, cl.ingmax, cl.ingmin, cl.gasmax, cl.gasmin, o.nombre AS ocupacion, r.recomendacion AS recomendacion , cl.whatsapp 
                                FROM cliente cl 
                                INNER JOIN ocupacion o ON cl.ocupacion_id = o.id 
                                INNER JOIN recomendacion r ON cl.recomendacion_id = r.id 
                                INNER JOIN direccion dr ON cl.direccion_id = dr.id
                                WHERE cl.sede_id = "'.$idSucursal.'" AND (cl.nombre LIKE "%'.$request->dato.'%" OR cl.apellido LIKE "%'.$request->dato.'%" OR cl.dni LIKE "%'.$request->dato.'%")
                                GROUP BY cl.id');
                                 
        return response()->json(["view"=>view('atencioncliente.tabCliente',compact('clientes'))->render()]);
    }
    
    public function buscarGarantiaPC(Request $request)
    {
        $dato = $request->dato;
        $resp = 0;
        
        $tipoGarantia = DB::SELECT('SELECT * FROM tipogarantia WHERE nombre LIKE "%'.$dato.'%"');
        
        $var = DB::SELECT('SELECT COUNT(*) AS conteo FROM tipogarantia WHERE nombre LIKE "%'.$dato.'%"');
        
        if($var[0]->conteo == 0){
            $resp = 0;
            $tipoGarantia = DB::SELECT('SELECT * FROM tipogarantia');
        }else{
            $resp = 1;
        }
        
        return response()->json(["view"=>view('atencioncliente.listGarantia',compact('tipoGarantia'))->render(), "resp"=>$resp]);
        
    }

    public function cliente()
    {
        $user = Auth::user();
        $Proceso = new Proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $usuario = DB::SELECT('SELECT e.nombre, e.apellido, e.id, u.name AS area, e.foto AS foto, e.sede_id AS sede
                                FROM empleado e, users u 
                                WHERE e.users_id = u.id AND u.id = "'.$user->id.'"');

        $ocupacion = DB::SELECT('SELECT * FROM ocupacion');
        $recomendacion = DB::SELECT('SELECT * FROM recomendacion');
        $tipodoc = DB::SELECT('SELECT * FROM tipodocide');
        $departamento = DB::SELECT('SELECT * FROM departamento');
        $provincia = DB::SELECT('SELECT * FROM provincia');
        $distrito = DB::SELECT('SELECT * FROM distrito');

        return view('atencioncliente.crear', compact('ocupacion', 'recomendacion', 'tipodoc', 'departamento', 'provincia', 'distrito', 'usuario'));
    }

    public function guadarCliente(Request $request)
    {
        $user_id = 1;
        $Proceso = new Proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;

        $code = 500;
        $message = "";
        $data = "";

        if ($request->whastapp == null) {
            $whatsapp = $request->telefono;
        }else {
            $whatsapp = $request->whastapp;
        }
        $img=$request->foto;
        $dni = $request->dni;
        $subido="";
        $urlGuardar="";
        
        if (Auth::user() != null) {
            $user_id = Auth::user()->id;

            $empleado = DB::SELECT('SELECT e.id AS empleado_id, e.sede_id AS sede_id 
                                 FROM users u, empleado e
                                 WHERE u.id = e.users_id AND u.id = "'.$user_id.'"');
        }
        

        $clientes = Cliente::where('dni', $dni)->first();
        
        if ($clientes != null) {
            
            $sede = Sede::where('id', $clientes->sede_id)->first();
            
            $code = 500;
            $message = "El usuario ya se encuentra registrado, revise su sede";
            $data = $sede;
        } else {
            
            if ($request->hasFile('foto')) { 
                $nombre=$img->getClientOriginalName();
                $extension=$img->getClientOriginalExtension();
                $nuevoNombre=$dni.".".$extension;
                $subido = Storage::disk('perfil')->put($nuevoNombre, File::get($img));
                if($subido){
                    $urlGuardar='img/perfil/'.$nuevoNombre;
                }
            }
            
            $user = new User();
            $user->name = $request->nombre." ".$request->apellido;
            $user->email = $request->correo;
            $user->password = bcrypt($request->dni);
            $user->username = $dni;
            if ($user->save()) {
                $dir = new Direccion();
                $dir->direccion = $request->direccion;
                $dir->referencia = $request->dirReferencia;
                $dir->distrito_id = $request->distrito_id;
                if ($dir->save()) {
                    $dir_id = $dir->id;
    
                    $cliente = new Cliente();
                    $cliente->nombre = $request->nombre;
                    $cliente->apellido = $request->apellido;
                    $cliente->dni = $dni;
                    $cliente->correo = $request->correo;
                    $cliente->direccion_id = $dir_id; 
                    $cliente->fecnac = $request->fecnacimiento;
                    $cliente->edad = $request->edad;
                    $cliente->genero = $request->genero;
                    $cliente->foto = $urlGuardar;
                    $cliente->facebook = "https://web.facebook.com/?_rdc=1&_rdr";
                    $cliente->tipodocide_id = "1";
                    $cliente->ocupacion_id = $request->ocupacion_id;
                    $cliente->recomendacion_id = $request->recomendado_id;
                    $cliente->evaluacion = "100";
                    $cliente->telefono = $request->telefono;
                    $cliente->whatsapp = $whatsapp;
                    $cliente->referencia = $request->tlfReferencia;
                    $cliente->users_id = $user_id;
                    $cliente->sede_id = $idSucursal;
                    if ($cliente->save()) {
                        $code = 201;
                        $message = "Cliente Guardado Correctamente";
                        $data = $cliente->id;
                    }
    
                } else {
                    $code = 500;
                    $message = "Hubo un error al registrar la dirección del cliente";
                }
            } else {
                $code = 500;
                $message = "Hubo un error al registrar el usuario del cliente";
            }
            
        }

        return response()->json(['code' => $code, 'message' => $message, 'data' => $data]);
        
    }

    public function editarCliente(Request $request)
    {
        $Proceso = new Proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $img=$request->editFotoA;
        $dni = $request->editDNI;
        $subido="";
        $urlGuardar="";

        if ($request->hasFile('editFotoA')) { 

        $nombre=$img->getClientOriginalName();
        $extension=$img->getClientOriginalExtension();
        $nuevoNombre=$dni.".".$extension;
        $subido = Storage::disk('perfil')->put($nuevoNombre, File::get($img));

            if($subido){
                $urlGuardar='img/perfil/'.$nuevoNombre;
            }

        }

        $dir = new Direccion();
        $dir->direccion = $request->editDireccion;
        $dir->distrito_id = $request->editDistrito;

        if ($dir->save()) {
            $dir_id = DB::SELECT('SELECT MAX(id) AS id FROM direccion');

            $cliente = Cliente::where('id', '=', $request->editId)->first();
            $cliente->nombre = $request->editNombre;
            $cliente->apellido = $request->editApellido;
            $cliente->dni = $request->editDNI;
            $cliente->correo = $request->editCorreo;
            $cliente->telefono = $request->editTelefono;
            $cliente->referencia = $request->editNumReferencia;
            $cliente->whatsapp = $request->editWhatsapp;
            $cliente->fecnac = $request->editFecNac;
            $cliente->edad = $request->editEdad;
            $cliente->genero = $request->editGenero;
            //$cliente->ocupacion_id = $request->editOcupacion;
            $cliente->facebook = $request->editFacebook;
            $cliente->direccion_id = $dir_id[0]->id;
            $cliente->ocupacion_id = $request->editOcupacion;
            $cliente->foto = $urlGuardar;
            
            if ($cliente->save()) {
                $resultado = "Todo Bien";
                return response()->json(['resultado'=>$resultado]);
            }
        }
        
     
    }

    public function guadarOcupacion(Request $request)
    {
        $ocupa = $request->ocupacion;
        $ocu = new Ocupacion();
        $ocu->nombre = $ocupa;

        if ($ocu->save()) {
            $ocupacion = Ocupacion::all();
            return response()->json(["view"=>view('atencioncliente.listOcupacion',compact('ocupacion'))->render(), 'ocupa'=>$ocupa]);
        }
    }

    public function guardarRecomendacion(Request $request)
    {
        $recu = $request->recomendacion;
        $rec = new Recomendacion();
        $rec->recomendacion = $recu;

        if ($rec->save()) {
            $recomendacion = Recomendacion::all();
            return response()->json(["view"=>view('atencioncliente.listRecomendacion',compact('recomendacion'))->render(), 'recu'=>$recu]);
        }
    }

    public function guardarTipoDocumento(Request $request){
        $tipodoc = $request->tipodocumento;
        $td = new TipoDocIde();
        $td->nombre = $tipodoc;

        if ($td->save()) {
            $tipodoc = TipoDocIde::all();
            return response()->json(["view"=>view('atencioncliente.listTipoDocumento', compact('tipodoc'))->render(), '$tipodoc'=>$tipodoc]);
        }
    }

    public function perfil($id)
    {
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;

        $user = Auth::user();
        $usuario = DB::SELECT('SELECT e.nombre, e.apellido, e.id, u.name AS area, e.foto AS foto, e.sede_id AS sede
                                FROM empleado e, users u 
                                WHERE e.users_id = u.id AND u.id = "'.$user->id.'"');

        $cliente = Cliente::select('cliente.id as cliente_id', 'cliente.nombre', 'cliente.apellido', 'cliente.dni', 'cliente.correo', 'direccion.direccion', 'cliente.fecnac', 'cliente.edad', 'cliente.genero', 'cliente.foto', 'cliente.facebook', 'cliente.ingmax', 'cliente.ingmin', 'cliente.gasmax', 'cliente.gasmin', 'cliente.created_at', 'ocupacion.nombre AS ocupacion', 'recomendacion.recomendacion AS recomendacion', 'cliente.evaluacion AS evaluacion', 'cliente.telefono', 'cliente.whatsapp', 'cliente.referencia')
                            ->join('ocupacion', 'cliente.ocupacion_id', '=', 'ocupacion.id')
                            ->join('recomendacion', 'cliente.recomendacion_id', '=', 'recomendacion.id')
                            ->join('direccion', 'cliente.direccion_id', '=', 'direccion.id')
                            ->where('cliente.id', $id)
                            ->first();

        $cantPrestamo = DB::SELECT('SELECT COUNT(p.id) AS catPrestamo 
                                     FROM prestamo p, cotizacion c 
                                     WHERE p.cotizacion_id = c.id AND p.cotizacion_id = c.id AND c.cliente_id = "'.$id.'"');
                                     
                                     

        $cantPrePendiente = DB::SELECT('SELECT COUNT(p.id) AS catPrestamo 
                                         FROM prestamo p, cotizacion c 
                                         WHERE p.cotizacion_id = c.id AND p.estado != "PAGADO" AND c.cliente_id = "'.$id.'"');
                                         
                                         

        $cantPreAceptadas = DB::SELECT('SELECT COUNT(*) AS catPrestamo
                                         FROM cliente c, cotizacion co, prestamo p
                                         WHERE c.id = co.cliente_id AND co.id = p.cotizacion_id AND p.estado = "PAGADO" AND c.id = "'.$id.'"');
                                         
                                         

        $prestamo = DB::SELECT('SELECT p.id AS prestamo_id, p.monto, p.fecinicio, p.fecfin, p.total, p.estado, p.created_at, g.nombre, p.intpagar, i.porcentaje, m.mora AS morapagar
                                 FROM prestamo p, cotizacion c, garantia g, mora m, tipocredito_interes tci, interes i
                                 WHERE p.cotizacion_id = c.id AND c.garantia_id = g.id AND m.id = p.mora_id AND p.tipocredito_interes_id = tci.id AND tci.interes_id = i.id AND (p.estado != "PAGADO" AND p.estado != "RENOVADO") AND c.cliente_id = "'.$id.'"');
                                 
        

        $cotizacion = DB::SELECT('SELECT c.id AS cotizacion_id, c.max, c.min, c.created_at, c.estado, tp.nombre AS tipoPrestamo,g.id AS garantia_id, g.nombre AS garantia
                                   FROM cotizacion c, tipoprestamo tp, garantia g
                                   WHERE c.garantia_id = g.id AND c.tipoprestamo_id = tp.id AND c.estado = "PENDIENTE" AND c.cliente_id = "'.$id.'"');
                                   
                                   
        
 
        $listCotizaciones = DB::SELECT('SELECT c.id AS cotizacion_id, tp.nombre AS tipoPrestamo, g.nombre AS garantia, g.detalle AS detalleGarantia, c.max, c.min, CONCAT(e.nombre, " ", e.apellido) AS empleado 
                                         FROM cotizacion c, tipoprestamo tp, garantia g, empleado e 
                                         WHERE c.tipoprestamo_id = tp.id AND c.garantia_id = g.id AND c.empleado_id = e.id AND c.estado = "PRESTAMO" AND c.cliente_id = "'.$id.'"');
                                         
                                         
 
        $tipoPrestamo = DB::SELECT('SELECT * FROM tipoprestamo'); 
        $tipoGarantia = DB::SELECT('SELECT * FROM tipogarantia WHERE detalle != "tj"');
        $tipoJoya = DB::SELECT('SELECT * FROM tipogarantia WHERE detalle != "tp"');
        $almacen = DB::SELECT('SELECT a.* FROM almacen a 
                                INNER JOIN almacen_sede ase
                                WHERE a.id = ase.almacen_id AND ase.sede_id = "'.$idSucursal.'";');
        $distrito = DB::SELECT('SELECT * FROM distrito');
        $provincia = DB::SELECT('SELECT * FROM provincia');
        $departamento = DB::SELECT('SELECT * FROM departamento');
        $ocupacion = DB::SELECT('SELECT * FROM ocupacion');
        $tipoDocumento = DB::SELECT('SELECT * FROM tipodocide');
        

        $hPrestamo = DB::SELECT('SELECT p.id AS prestamo_id, p.monto, p.fecinicio, p.fecfin, p.total, p.estado, p.created_at, g.nombre AS garantia, p.intpagar, m.mora
                                  FROM prestamo p, cotizacion c, garantia g, mora m
                                  WHERE p.cotizacion_id = c.id AND c.garantia_id = g.id AND m.id = p.mora_id AND c.cliente_id = "'.$id.'" AND p.estado = "PAGADO"');
                                  
        $colorRed = DB::SELECT('SELECT COUNT(c.cliente_id) AS cantidad, c.cliente_id, DATEDIFF(DATE(NOW()), p.fecfin) AS dias FROM `prestamo` p, `cotizacion` c WHERE p.cotizacion_id = c.id AND c.cliente_id = "'.$id.'" AND p.estado = "VENDIDO"');
        
        $colorAmbar = DB::SELECT('SELECT COUNT(c.cliente_id) AS cantidad, c.cliente_id, DATEDIFF(DATE(NOW()), p.fecfin) AS dias FROM `prestamo` p, `cotizacion` c WHERE p.cotizacion_id = c.id AND c.cliente_id = "'.$id.'" AND p.estado = "LIQUIDACION"');
                                 
        $colorGreen = DB::SELECT('SELECT COUNT(c.cliente_id) AS cantidad, c.cliente_id, DATEDIFF(DATE(NOW()), p.fecfin) AS dias FROM `prestamo` p, `cotizacion` c WHERE p.cotizacion_id = c.id AND c.cliente_id = "'.$id.'" AND (p.estado != "LIQUIDACION" OR p.estado != "VENDIDO") AND p.estado = "ACTIVO DESEMBOLSADO";');
        
        
        return view('atencioncliente.perfil', compact('cliente', 'cantPrestamo', 'cantPrePendiente', 'cantPreAceptadas', 'prestamo', 'cotizacion', 'cotizacion', 'listCotizaciones', 'tipoPrestamo', 'tipoGarantia', 'tipoJoya', 'almacen', 'distrito', 'provincia', 'departamento', 'ocupacion', 'tipoDocumento', 'usuario', 'hPrestamo', 'colorRed', 'colorAmbar', 'colorGreen'));
    }

    

    public function mostrarProvincia(Request $request){
        $departamento_id = $request->departamento_id;

        $provincia = DB::SELECT('SELECT * FROM provincia WHERE departamento_id ="'.$departamento_id.'"');
        
        return response()->json(["view"=>view('atencioncliente.listProvincia', compact('provincia'))->render(), '$departamento_id'=>$departamento_id]);
    }

    public function mostrarDistrito(Request $request){
        $id = $request->provincia_id;

        $distrito = DB::SELECT('SELECT * FROM distrito WHERE provincia_id ="'.$id.'"');
        
        return response()->json(["view"=>view('atencioncliente.listDistrito', compact('distrito'))->render(), '$id'=>$id]);
    }

    public function buscarStandCotizacion(Request $request)
    {
        $id = $request->almacen_id;

        $stand = DB::SELECT('SELECT * FROM stand WHERE estado = "libre" AND almacen_id ="'.$id.'"');
        
        return response()->json(["view"=>view('atencioncliente.cbStand', compact('stand'))->render(), '$id'=>$id]);
    }

    public function buscarCasilleroCotizacion(Request $request)
    {
        $id = $request->stand_id;

        $casillero = DB::SELECT('SELECT * FROM casillero WHERE estado = "libre" AND stand_id = "'.$id.'"');
        
        return response()->json(["view"=>view('atencioncliente.cbCasillero', compact('casillero'))->render(), '$id'=>$id]);
    }

    public function cargarEditCliente(Request $request)
    {
        $id = $request->id;

        $cliente = DB::SELECT('SELECT * FROM cliente WHERE id = "'.$id.'"');

        $nombre = $cliente[0]->nombre;
        $apellido = $cliente[0]->apellido;
        $dni = $cliente[0]->dni;
        $correo = $cliente[0]->correo;
        $telefono = $cliente[0]->telefono;
        $referencia = $cliente[0]->referencia;
        $whatsapp = $cliente[0]->whatsapp;
        $fecnac = $cliente[0]->fecnac;
        $edad = $cliente[0]->edad;
        $genero = $cliente[0]->genero;
        $foto = $cliente[0]->foto;
        $facebook = $cliente[0]->facebook;
        $ingmax = $cliente[0]->ingmax;
        $ingmin = $cliente[0]->ingmin;
        $gasmax = $cliente[0]->gasmax;
        $gasmin = $cliente[0]->gasmin;
        $evaluacion = $cliente[0]->evaluacion;
        $tipodocide_id = $cliente[0]->tipodocide_id;
        $direccion_id = $cliente[0]->direccion_id;
        $ocupacion_id = $cliente[0]->ocupacion_id;
        $recomendacion_id = $cliente[0]->recomendacion_id;
        $users_id = $cliente[0]->users_id;

        $direccion = DB::SELECT('SELECT * FROM direccion WHERE id = "'.$direccion_id.'"');
        $distrito_id = $direccion[0]->distrito_id;
        $direccion = $direccion[0]->direccion;

        $distrito = DB::SELECT('SELECT * FROM distrito WHERE id = "'.$distrito_id.'"');
        $provincia_id = $distrito[0]->provincia_id;

        $provincia = DB::SELECT('SELECT * FROM provincia WHERE id = "'.$provincia_id.'"');
        $departamento_id = $provincia[0]->departamento_id;

        $departamento = DB::SELECT('SELECT * FROM departamento WHERE id = "'.$departamento_id.'"');
        
        
        return response()->json(['id'=>$id, 'nombre'=>$nombre, 'apellido'=>$apellido, 'dni'=>$dni, 'correo'=>$correo, 'telefono'=>$telefono, 'referencia'=>$referencia, 'whatsapp'=>$whatsapp, 'fecnac'=>$fecnac, 'genero'=>$genero, 'foto'=>$foto, 'facebook'=>$facebook, 'ingmax'=>$ingmax, 'ingmin'=>$ingmin, 'gasmax'=>$gasmax, 'gasmin'=>$gasmin, 'evaluacion'=>$evaluacion, 'tipodocide_id'=>$tipodocide_id, 'direccion_id'=>$direccion_id, 'ocupacion_id'=>$ocupacion_id, 'recomendacion_id'=>$recomendacion_id, 'users_id'=>$users_id, 'distrito_id'=>$distrito_id, 'provincia_id'=>$provincia_id, 'departamento_id'=>$departamento_id, 'direccion'=>$direccion, 'edad'=>$edad]);
    }

    public function verificarDNI(Request $request)
    {
        $dni = $request->dni;

        $ver = DB::SELECT('SELECT * FROM cliente WHERE dni = "'.$dni.'"');

        if ($ver == null) {
            $resp = 0;
        }else {
            $resp = 1;
        }

        return response()->json(['resp'=>$resp]);

    }

    public function direCliente(Request $request)
    {
        $id = $request->id;
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;

        $clientes = DB::SELECT(' SELECT cl.id AS cliente_id, cl.nombre, cl.apellido, cl.dni, cl.correo, dr.direccion, cl.fecnac, cl.edad, cl.genero, cl.foto, cl.facebook, cl.ingmax, cl.ingmin, cl.gasmax, cl.gasmin, o.nombre AS ocupacion, r.recomendacion AS recomendacion , cl.whatsapp 
                                  FROM cliente cl 
                                  INNER JOIN ocupacion o ON cl.ocupacion_id = o.id 
                                  INNER JOIN recomendacion r ON cl.recomendacion_id = r.id 
                                  INNER JOIN direccion dr ON cl.direccion_id = dr.id
                                  WHERE cl.id = "'.$id.'" AND cl.sede_id = "'.$idSucursal.'"');

        return response()->json(["view"=>view('atencioncliente.direCliente', compact('clientes'))->render()]);
    }

    public function verNotificacion(Request $request)
    {
        $prestamo_id = $request->id;

        $prestamo = DB::SELECT('SELECT cotizacion_id FROM prestamo WHERE id = "'.$prestamo_id.'"');

        $cotizacion = DB::SELECT('SELECT id FROM prestamo WHERE cotizacion_id = "'.$prestamo[0]->cotizacion_id.'"');

        foreach ($cotizacion as $c) {

            $notificacion = DB::SELECT('SELECT d.* 
                                         FROM prestamo_documento pd, documento d
                                         WHERE pd.documento_id = d.id AND pd.prestamo_id = "'.$c->id.'" AND d.estado = "NOTIFICACION"');
        }

        return response()->json(["view"=>view('atencioncliente.verNotifi', compact('notificacion'))->render()]);

    }

    public function verPago(Request $request)
    {
        $prestamo_id = $request->id;

        $prestamo = DB::SELECT('SELECT cotizacion_id FROM prestamo WHERE id = "'.$prestamo_id.'"');

        $cotizacion = DB::SELECT('SELECT id FROM prestamo WHERE cotizacion_id = "'.$prestamo[0]->cotizacion_id.'"');

        foreach ($cotizacion as $c) {

            $notificacion = DB::SELECT('SELECT d.* 
                                         FROM prestamo_documento pd, documento d
                                         WHERE pd.documento_id = d.id AND pd.prestamo_id = "'.$c->id.'" AND d.estado = "PAGO"');
        }

        return response()->json(["view"=>view('atencioncliente.verNotifi', compact('notificacion'))->render()]);

    }

    public function pruebaApi()
    {   
        
        $clientes = DB::SELECT(' SELECT cl.id AS cliente_id, cl.nombre, cl.apellido, cl.dni, cl.correo, dr.direccion, cl.fecnac, cl.edad, cl.genero, cl.foto, cl.facebook, cl.ingmax, cl.ingmin, cl.gasmax, cl.gasmin, o.nombre AS ocupacion, r.recomendacion AS recomendacion , cl.whatsapp 
                                  FROM cliente cl 
                                  INNER JOIN ocupacion o ON cl.ocupacion_id = o.id 
                                  INNER JOIN recomendacion r ON cl.recomendacion_id = r.id 
                                  INNER JOIN direccion dr ON cl.direccion_id = dr.id
                                  GROUP BY cl.id');
        
        return $clientes;
    }
    
    public function pruebaApiId($id)
    {   
        
        $clientes = DB::SELECT(' SELECT cl.id AS cliente_id, cl.nombre, cl.apellido, cl.dni, cl.correo, dr.direccion, cl.fecnac, cl.edad, cl.genero, cl.foto, cl.facebook, cl.ingmax, cl.ingmin, cl.gasmax, cl.gasmin, o.nombre AS ocupacion, r.recomendacion AS recomendacion , cl.whatsapp 
                                  FROM cliente cl 
                                  INNER JOIN ocupacion o ON cl.ocupacion_id = o.id 
                                  INNER JOIN recomendacion r ON cl.recomendacion_id = r.id 
                                  INNER JOIN direccion dr ON cl.direccion_id = dr.id
                                  WHERE cl.id = "'.$id.'"
                                  GROUP BY cl.id');
        
        return $clientes;
    }
}
