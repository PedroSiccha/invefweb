<?php

namespace App\Http\Controllers;

use App\Models\Direccion;
use App\Models\Empleado;
use App\Models\MenuRol;
use App\Models\Permiso;
use App\Models\PermisoRol;
use App\Models\Planilla;
use App\Models\Proceso;
use App\Models\Rol;
use App\Models\RoleUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class RecursosHumanosController extends Controller
{
    public function empleado()
    {
        $Proceso = new Proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;
        
        $user = Auth::user();
        $usuario = DB::SELECT('SELECT e.nombre, e.apellido, e.id, u.name AS area, e.foto AS foto, e.sede_id AS sede
                                FROM empleado e, users u 
                                WHERE e.users_id = u.id AND u.id = "'.$user->id.'"');

        $empleado = DB::SELECT('SELECT e.id AS empleado_id, e.nombre, e.apellido, e.dni, e.fecnac, e.edad, e.telefono, e.referencia, e.whatsapp, e.estado, e.genero, e.valoracion, 
                                        tdi.nombre AS tipoDocumento,
                                        d.direccion, di.distrito, pr.provincia, de.departamento,
                                        t.turno, t.detalle, t.horainicio, t.horafin,
                                        p.fecinicio, p.fecfin, p.monto,
                                        u.name, u.email
                                 FROM empleado e, tipodocide tdi, direccion d, distrito di, provincia pr, departamento de, turno t, planilla p, users u
                                 WHERE e.tipodocide_id = tdi.id AND e.direccion_id = d.id AND d.distrito_id = di.id AND di.provincia_id = pr.id AND pr.departamento_id = de.id AND e.turno_id = t.id AND e.planilla_id = p.id AND e.users_id = u.id AND e.sede_id = "'.$idSucursal.'"');

        $tipodocumento = DB::SELECT('SELECT * FROM tipodocide');
        
        $turno = DB::SELECT('SELECT * FROM turno');

        $planilla = DB::SELECT('SELECT * FROM planilla');

        $distrito = DB::SELECT('SELECT * FROM distrito');

        $provincia = DB::SELECT('SELECT * FROM provincia');

        $departamento = DB::SELECT('SELECT * FROM departamento');

        $tipoUsuario = DB::SELECT('SELECT * FROM rol');

        $sede = DB::SELECT('SELECT s.id, s.nombre, d.direccion, di.distrito  
                             FROM sede s, direccion d, distrito di
                             WHERE s.direccion_id = d.id AND d.distrito_id = di.id AND s.estado = "ACTIVO"');


        return view('rrhh.empleado', compact('empleado', 'usuario', 'tipodocumento', 'turno', 'planilla', 'distrito', 'provincia', 'departamento', 'tipoUsuario', 'sede'));
    }

    public function baja(Request $request)
    {
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;
        
        $empleado_id = $request->id;
        $resp = 0;

        $emp = Empleado::where('id', '=', $empleado_id)->first();
        $emp->estado = "DESACTIVADO";
        if ($emp->save()) {
            
            $user_id = DB::SELECT('SELECT u.id AS id 
                                    FROM empleado e, users u 
                                    WHERE e.users_id = u.id AND e.id = "'.$empleado_id.'"');

            $us = User::where('id', '=', $user_id[0]->id)->first();
            $us->username = "DESACTIVADO;";
            
            if ($us->save()) {
                
                $resp = 1;

            }

            
        }
        $empleado = DB::SELECT('SELECT e.id AS empleado_id, e.nombre, e.apellido, e.dni, e.fecnac, e.edad, e.telefono, e.referencia, e.whatsapp, e.estado, e.genero, e.valoracion, 
                                        tdi.nombre AS tipoDocumento,
                                        d.direccion, di.distrito, pr.provincia, de.departamento,
                                        t.turno, t.detalle, t.horainicio, t.horafin,
                                        p.fecinicio, p.fecfin, p.monto,
                                        u.name, u.email
                                 FROM empleado e, tipodocide tdi, direccion d, distrito di, provincia pr, departamento de, turno t, planilla p, users u
                                 WHERE e.tipodocide_id = tdi.id AND e.direccion_id = d.id AND d.distrito_id = di.id AND di.provincia_id = pr.id AND pr.departamento_id = de.id AND e.turno_id = t.id AND e.planilla_id = p.id AND e.users_id = u.id AND e.sede_id = "'.$idSucursal.'"');

        return response()->json(["view"=>view('rrhh.tabEmpleado',compact('empleado'))->render(), 'resp'=>$resp]);
    }

    public function activarEmpleado(Request $request)
    {
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;
        
        $empleado_id = $request->id;
        $resp = 0;

        $emp = Empleado::where('id', '=', $empleado_id)->first();
        $emp->estado = "ACTIVO";
        if ($emp->save()) {
            
            $user_id = DB::SELECT('SELECT u.id AS id, u.name AS estado
                                    FROM empleado e, users u
                                    WHERE e.users_id = u.id AND e.id = "'.$empleado_id.'"');

            $us = User::where('id', '=', $user_id[0]->id)->first();
            $us->username = $user_id[0]->estado;
            if ($us->save()) {
                $resp = 1;
            }            
        }
        $empleado = DB::SELECT('SELECT e.id AS empleado_id, e.nombre, e.apellido, e.dni, e.fecnac, e.edad, e.telefono, e.referencia, e.whatsapp, e.estado, e.genero, e.valoracion, 
                                        tdi.nombre AS tipoDocumento,
                                        d.direccion, di.distrito, pr.provincia, de.departamento,
                                        t.turno, t.detalle, t.horainicio, t.horafin,
                                        p.fecinicio, p.fecfin, p.monto,
                                        u.name, u.email
                                 FROM empleado e, tipodocide tdi, direccion d, distrito di, provincia pr, departamento de, turno t, planilla p, users u
                                 WHERE e.tipodocide_id = tdi.id AND e.direccion_id = d.id AND d.distrito_id = di.id AND di.provincia_id = pr.id AND pr.departamento_id = de.id AND e.turno_id = t.id AND e.planilla_id = p.id AND e.users_id = u.id AND e.sede_id = "'.$idSucursal.'"');
                                 
        return response()->json(["view"=>view('rrhh.tabEmpleado',compact('empleado'))->render(), 'resp'=>$resp]);
    }

    public function verEmpleado(Request $request)
    {
        $empleado_id = $request->id;

        $empleado = DB::SELECT('SELECT e.nombre, e.apellido, e.dni, e.fecnac, e.edad, e.telefono, e.referencia, e.whatsapp, e.tipodocide_id, e.genero, e.foto, d.direccion, di.id AS distrito_id, p.id AS provincia_id, de.id AS departamento_id
                                 FROM empleado e, direccion d, distrito di, provincia p, departamento de
                                 WHERE e.direccion_id = d.id AND d.distrito_id = di.id AND di.provincia_id = p.id AND p.departamento_id = de.id AND e.id = "'.$empleado_id.'"');

        return response()->json(['nombre'=>$empleado[0]->nombre, 'apellido'=>$empleado[0]->apellido, 'dni'=>$empleado[0]->dni, 'fecnac'=>$empleado[0]->fecnac, 'edad'=>$empleado[0]->edad, 'telefono'=>$empleado[0]->telefono, 'referencia'=>$empleado[0]->referencia, 'whatsapp'=>$empleado[0]->whatsapp, 'tipodocide_id'=>$empleado[0]->tipodocide_id, 'genero'=>$empleado[0]->genero, 'foto'=>$empleado[0]->foto, 'direccion'=>$empleado[0]->direccion, 'distrito_id'=>$empleado[0]->distrito_id, 'provincia_id'=>$empleado[0]->provincia_id, 'departamento_id'=>$empleado[0]->departamento_id]);
    }

    public function pagopersonal()
    {
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;
        
        $user = Auth::user();
        $usuario = DB::SELECT('SELECT e.nombre, e.apellido, e.id, u.name AS area, e.foto AS foto, e.sede_id AS sede
                                FROM empleado e, users u 
                                WHERE e.users_id = u.id AND u.id = "'.$user->id.'"');

        $empleado = DB::SELECT('SELECT e.id AS empleado_id, e.nombre, e.apellido, e.dni, e.fecnac, e.edad, e.telefono, e.referencia, e.whatsapp, e.estado, e.genero, e.valoracion, 
                                        tdi.nombre AS tipoDocumento,
                                        d.direccion, di.distrito, pr.provincia, de.departamento,
                                        t.turno, t.detalle, t.horainicio, t.horafin,
                                        p.fecinicio, p.fecfin, p.monto,
                                        u.name, u.email
                                 FROM empleado e, tipodocide tdi, direccion d, distrito di, provincia pr, departamento de, turno t, planilla p, users u
                                 WHERE e.tipodocide_id = tdi.id AND e.direccion_id = d.id AND d.distrito_id = di.id AND di.provincia_id = pr.id AND pr.departamento_id = de.id AND e.turno_id = t.id AND e.planilla_id = p.id AND e.users_id = u.id AND e.sede_id = "'.$idSucursal.'"');

        return view('rrhh.pagopersonal', compact('empleado', 'usuario'));
    }

    public function rendimientopersonal()
    {
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;
        
        $user = Auth::user();
        $usuario = DB::SELECT('SELECT e.nombre, e.apellido, e.id, u.name AS area, e.foto AS foto, e.sede_id AS sede
                                FROM empleado e, users u 
                                WHERE e.users_id = u.id AND u.id = "'.$user->id.'"');

        $empleado = DB::SELECT('SELECT e.id AS empleado_id, e.nombre, e.apellido, e.dni, e.estado, e.valoracion, e.foto FROM empleado e WHERE e.sede_id = "'.$idSucursal.'"');

        return view('rrhh.rendimientopersonal', compact('empleado', 'usuario'));
    }

    public function seguridad()
    {
        $user = Auth::user();
        $usuario = DB::SELECT('SELECT e.nombre, e.apellido, e.id, u.name AS area, e.foto AS foto, e.sede_id AS sede
                                FROM empleado e, users u 
                                WHERE e.users_id = u.id AND u.id = "'.$user->id.'"');

        $roles = DB::SELECT('SELECT * FROM rol');
        $menus = DB::SELECT('SELECT * FROM menu');
        $menuRols = DB::SELECT('SELECT mr.id AS menurol_id, r.id AS rol_id, r.nombre AS rol, m.id AS menu_id, m.nombre AS menu
                                 FROM menurol mr
                                 RIGHT JOIN rol r ON mr.rol_id = r.id
                                 RIGHT JOIN menu m ON mr.menu_id = m.id');

        $permisos = DB::SELECT('SELECT * FROM permiso');

        return view('rrhh.seguridad', compact('roles', 'menuRols', 'usuario', 'menus', 'permisos'));
    }
    
    public function verMenuRol(Request $request)
    {
        
        $menuRols = DB::SELECT('SELECT mr.id AS menurol_id, r.id AS rol_id, r.nombre AS rol, m.id AS menu_id, m.nombre AS menu
                                 FROM menurol mr
                                 RIGHT JOIN rol r ON mr.rol_id = r.id
                                 RIGHT JOIN menu m ON mr.menu_id = m.id
                                 WHERE r.id = "'.$request->id.'"');
                                 
        $rol = $menuRols[0]->rol;
        $id = $menuRols[0]->rol_id;
        
        return response()->json(["view"=>view('rrhh.tabListaMenu',compact('menuRols'))->render(), "Titulo"=>view('rrhh.divTitulo',compact('rol'))->render(), "id"=>$id]);
    }
    
    public function eliminarMenuRol(Request $request)
    {
        $menuRol = $request->idMenuRol;
        $resp = 0;
        
        for ($i=0; $i < count($menuRol) ; $i++) { 

            $idEliminar=$menuRol[$i];
            
            $menRol = MenuRol::find($idEliminar);
            
            if ($menRol) {
                $menRol->delete();
            }  
        }
        
         $menuRols = DB::SELECT('SELECT mr.id AS menurol_id, r.id AS rol_id, r.nombre AS rol, m.id AS menu_id, m.nombre AS menu
                                 FROM menurol mr
                                 RIGHT JOIN rol r ON mr.rol_id = r.id
                                 RIGHT JOIN menu m ON mr.menu_id = m.id
                                 WHERE r.id = "'.$request->id.'"');
                                 
        $rol = $menuRols[0]->rol;
        $id = $menuRols[0]->rol_id;
        
        return response()->json(["view"=>view('rrhh.tabListaMenu',compact('menuRols'))->render(), "Titulo"=>view('rrhh.divTitulo',compact('rol'))->render(), "id"=>$id]);
    }

    public function nuevoPermiso(Request $request)
    {
        $nombre = $request->nombre;
        $slug = $request->slug;

        $perm = new Permiso();
        $perm->nombre = $nombre;
        $perm->slug = $slug;
        if ($perm->save()) {
            
            $permisos = DB::SELECT('SELECT * FROM permiso');

            return response()->json(["view"=>view('rrhh.listPermiso',compact('permisos'))->render()]);

        }
    }

    public function asignarPermisoRol(Request $request)
    {
        $rol_id = $request->rol_id;
        $permiso_id = $request->idPermiso;

        for ($i=0; $i < count($permiso_id) ; $i++) { 
            
            //Aca llegas cada id de alergia

            $idLlenar=$permiso_id[$i];
            $perRol = new PermisoRol();
            $perRol->permiso_id = $permiso_id[$i];
            $perRol->rol_id = $rol_id;
            $perRol->save();
            //$resultado.='id: '.$idLlenar.' | ';
            
        }
    }

    public function crearRol(Request $request)
    {
        $rol = new Rol();
        $rol->nombre = $request->nombre;
        if ($rol->save()) {
            $roles = DB::SELECT('SELECT * FROM rol');

            return response()->json(["view"=>view('rrhh.listRol',compact('roles'))->render()]);
        }
    }

    public function asignarMenuRol(Request $request)
    {
        $rol_id = $request->rol_id;
        $menu_id = $request->idMenu;
        
        for ($i=0; $i < count($menu_id) ; $i++) { 
            
            //Aca llegas cada id de alergia

            $idLlenar=$menu_id[$i];
            $menRol = new MenuRol();
            $menRol->menu_id = $menu_id[$i];
            $menRol->rol_id = $rol_id;
            $menRol->save();
            //$resultado.='id: '.$idLlenar.' | ';
            
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function guardarEmpleado(Request $request)
    {
        
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;

        $img=$request->foto;
        $dni = $request->dni;
        $subido="";
        $urlGuardar="";

        if ($request->hasFile('foto')) { 

            $nombre=$img->getClientOriginalName();
            $extension=$img->getClientOriginalExtension();
            $nuevoNombre=$dni.".".$extension;
            
            $subido = Storage::disk('perfilEmpleado')->put($nuevoNombre, File::get($img));
    
            if($subido){
                $urlGuardar='img/perfilEmpleado/'.$nuevoNombre;
            }
        }

        $dir = new Direccion();
        $dir->direccion = $request->direccion;
        $dir->referencia = $request->dirReferencia;
        $dir->distrito_id = $request->distrito_id;
        if ($dir->save()) {

            $pla = new Planilla();
            $pla->fecinicio = $request->iniContrato;
            $pla->fecfin = $request->finContrato;
            $pla->monto = $request->mensualidad;
            if ($pla->save()) {
                
                $user = new User();
                $user->name = "admin";
                $user->email = $request->correo;
                $user->password = bcrypt($request->dni);
                $user->username = $request->dni;
                if ($user->save()) {

                    $direccion = DB::SELECT('SELECT MAX(id) AS id FROM direccion');
                    $planilla = DB::SELECT('SELECT MAX(id) AS id FROM planilla');        
                    $users = DB::SELECT('SELECT MAX(id) AS id FROM users WHERE email = "'.$request->correo.'"');

                    $emp = new Empleado();
                    $emp->nombre = $request->nombre;
                    $emp->apellido = $request->apellido;
                    $emp->dni = $request->dni;
                    $emp->fecnac = $request->fecnacimiento;
                    $emp->edad = $request->edad;
                    $emp->telefono = $request->telefono;
                    $emp->referencia = $request->telfreferencia;
                    $emp->whatsapp = $request->whatsapp;
                    $emp->tipodocide_id = $request->tipodocumento_id;
                    $emp->estado = "ACTIVO";
                    $emp->direccion_id = $direccion[0]->id;
                    $emp->genero = $request->genero;
                    $emp->turno_id = $request->turno_id;
                    $emp->planilla_id = $planilla[0]->id;
                    $emp->valoracion = "100";
                    $emp->users_id = $users[0]->id;
                    $emp->foto = $urlGuardar;
                    $emp->sede_id = $request->sede_id;
                    if ($emp->save()) { 

                        $userRol = new RoleUser();
                        $userRol->estado = "1";
                        $userRol->users_id = $users[0]->id;
                        $userRol->rol_id = $request->rol_id;
                        if ($userRol->save()) {
                            $resultado = "Todo Bien";
                            return response()->json(['resultado'=>$resultado]);
                        }
                    }
                    
                }

            }
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function editarEmpleado(Request $request)
    {
        $empleado_id = $request->editId;
        $tipodocide_id = $request->editTipoDocIde;
        $referencia = $request->editNumReferencia;
        $fecnac = $request->editFecNac;
        $genero = $request->editGener;
        $direccion = $request->editDireccion;
        $distrito = $request->editDistrito;
        $apellido = $request->editApellido;
        $dni = $request->editDNI;
        $telefono = $request->editTelefono;
        $whatsapp = $request->editWhatsapp;
        $edad = $request->editEdad;
        $foto = $request->editFoto;
        $img=$request->editFotoA;
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
        $dir->direccion = $direccion;
        $dir->distrito_id = $distrito;

        if ($dir->save()) {
            $dir_id = DB::SELECT('SELECT MAX(id) AS id FROM direccion');

            $emp = Empleado::where('id', '=', $empleado_id)->first();
            $emp->nombre = $request->editNombre;
            $emp->apellido = $apellido;
            $emp->dni = $dni;
            $emp->telefono = $telefono;
            $emp->referencia = $referencia;
            $emp->whatsapp = $whatsapp;
            $emp->fecnac = $fecnac;
            $emp->edad = $edad;
            $emp->genero = $genero;
            $emp->tipodocide_id = $tipodocide_id;
            $emp->direccion_id = $dir_id[0]->id;
            $emp->foto = $urlGuardar;
            
            if ($emp->save()) {
                $resultado = 1;
                return response()->json(['resultado'=>$resultado]);
            }
        }

        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function cambiarPass(Request $request)
    {
        $id = $request->id;
        $passAcutal = $request->passActual;
        $passNueva = $request->passNueva;

        $pass = DB::SELECT('SELECT u.*, u.password AS pass FROM users u, empleado e WHERE e.users_id = u.id');
        
        if (Hash::check($passAcutal, $pass[0]->pass)) {
            $user = User::where('id', '=', $id)->first();
            $user->password = Hash::make($passNueva);
            if ($user->save()) {
                $resp = 1;
            }
        }else {
            $resp = 2;
        }
        return response()->json(['resp'=>$resp]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editarSueldo(Request $request)
    {
        $empleado_id = $request->empleado_id;
        $monto = $request->sueldo;
        $fecinicio = $request->fecinicio;
        $fecfin = $request->fecfin;

        $planilla = DB::SELECT('SELECT planilla_id 
                                 FROM empleado 
                                 WHERE id = "'.$empleado_id.'"');

        $plan = Planilla::where('id', '=', $planilla[0]->planilla_id)->first();
        $plan->fecinicio = $fecinicio;
        $plan->fecfin = $fecfin;
        $plan->monto = $monto;
        if ($plan->save()) {
            $resp = 1;

            $empleado = DB::SELECT('SELECT e.id AS empleado_id, e.nombre, e.apellido, e.dni, e.fecnac, e.edad, e.telefono, e.referencia, e.whatsapp, e.estado, e.genero, e.valoracion, 
                                        tdi.nombre AS tipoDocumento,
                                        d.direccion, di.distrito, pr.provincia, de.departamento,
                                        t.turno, t.detalle, t.horainicio, t.horafin,
                                        p.fecinicio, p.fecfin, p.monto,
                                        u.name, u.email
                                 FROM empleado e, tipodocide tdi, direccion d, distrito di, provincia pr, departamento de, turno t, planilla p, users u
                                 WHERE e.tipodocide_id = tdi.id AND e.direccion_id = d.id AND d.distrito_id = di.id AND di.provincia_id = pr.id AND pr.departamento_id = de.id AND e.turno_id = t.id AND e.planilla_id = p.id AND e.users_id = u.id');

            return response()->json(["view"=>view('rrhh.tabSueldo',compact('empleado'))->render(), 'resp' => $resp]);
            
        }else {
            $resp = 0;

            return response()->json(['resp'=>$resp]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function perfilEmpleadoRendimiento($id)
    {
        $users_id = Auth::user()->id;
        $user = Auth::user();
        $usuario = DB::SELECT('SELECT e.nombre, e.apellido, e.id, u.name AS area, e.foto AS foto, e.sede_id AS sede
                                FROM empleado e, users u 
                                WHERE e.users_id = u.id AND u.id = "'.$user->id.'"');

        $notificacion = DB::SELECT('SELECT * FROM  notificacion WHERE estado = "PENDIENTE" AND sede = "'.$usuario[0]->sede.'"');

        if ($notificacion == null) {
            $notificacion = DB::SELECT('SELECT "" AS icono, "" AS asunto, "00:00:00" AS tiempo');
        }

        $cantNotificaciones = DB::SELECT('SELECT COUNT(*) AS cant FROM notificacion WHERE estado = "PENDIENTE" AND sede = "'.$usuario[0]->sede.'"');

        if($cantNotificaciones == null){
            $cantNotificaciones = DB::SELECT('SELECT "0" AS cant');
        }

        $empleado = DB::SELECT('SELECT e.id AS empleado_id, e.nombre, e.apellido, e.dni, e.fecnac, e.edad, e.telefono, e.referencia, e.whatsapp, e.estado, e.genero, e.valoracion, e.foto,
                                        tdi.nombre AS tipoDocumento,
                                        d.direccion,
                                        di.distrito,
                                        p.provincia,
                                        de.departamento,
                                        t.turno, t.detalle AS detalleTurno,
                                        pl.fecinicio AS inicioPlanilla, pl.fecfin AS finPlanilla, pl.monto AS montoPlanilla
                                 FROM empleado e, tipodocide tdi, direccion d, distrito di, provincia p, departamento de, turno t, planilla pl
                                 WHERE e.tipodocide_id = tdi.id AND e.direccion_id = d.id AND d.distrito_id = di.id AND di.provincia_id = p.id AND p.departamento_id = de.id AND e.turno_id = t.id AND e.planilla_id = pl.id AND e.id = "'.$id.'"');

        $prestamo = DB::SELECT('SELECT p.id AS prestamo_id, p.monto AS montoPrestamo, p.fecinicio, p.fecfin, p.total, p.sede_id 
                                 FROM empleado e, prestamo p
                                 WHERE p.empleado_id = e.id AND p.empleado_id = "'.$id.'"');

        $evaluacion = DB::SELECT('SELECT c.id AS cotizacion_id, c.max, c.min, c.estado, c.precio,  
                                        cl.nombre, cl.apellido,
                                        g.nombre AS garantia, g.detalle AS detalleGarantia, 
                                        tp.nombre AS tipoPrestamo
                                   FROM cotizacion c, cliente cl, garantia g, tipoprestamo tp
                                   WHERE c.cliente_id = cl.id AND c.garantia_id = g.id AND c.tipoprestamo_id = tp.id AND c.empleado_id = "'.$id.'"');

        $tipodocumento = DB::SELECT('SELECT * FROM tipodocide');

        $distrito = DB::SELECT('SELECT * FROM distrito');

        $provincia = DB::SELECT('SELECT * FROM provincia');

        $departamento = DB::SELECT('SELECT * FROM departamento');

        $listPrestamos = DB::SELECT('SELECT estado, monto, fecinicio, fecfin 
                                      FROM prestamo 
                                      WHERE empleado_id = "'.$id.'"');

        $listCotizacion = DB::SELECT('SELECT c.max, c.min, c.estado, g.nombre AS garantia  
                                       FROM cotizacion c, garantia g 
                                       WHERE c.empleado_id = "'.$id.'" AND c.garantia_id = g.id');

        $listPago = DB::SELECT('SELECT prestamo_id, monto, importe 
                                 FROM pago 
                                 WHERE empleado_id = "'.$id.'"');

        $turno = DB::SELECT('SELECT * FROM turno');

        $sede = DB::SELECT('SELECT * FROM sede');

        return view('rrhh.perfilEmpleado', compact('empleado', 'prestamo', 'evaluacion', 'usuario', 'tipodocumento', 'distrito', 'provincia', 'departamento', 'listPrestamos', 'listCotizacion', 'listPago', 'turno', 'sede', 'notificacion', 'cantNotificacion'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function verEmpleadoRendimiento(Request $request)
    {
        $empleado_id = $request->id;

        $empleado = DB::SELECT('SELECT estado, turno_id, sede_id 
                                 FROM empleado 
                                 where id = "'.$empleado_id.'"');

        return response()->json(['estado'=>$empleado[0]->estado, 'turno_id'=>$empleado[0]->turno_id, 'sede_id'=>$empleado[0]->sede_id]);                           
    }

    public function guardarEmpleadoRendimiento(Request $request)
    {
        $empleado_id = $request->empleado_id;
        $estado = $request->estado;
        $turno_id = $request->turno_id;
        $sede_id = $request->sede_id;

        $emp = Empleado::where('id', '=', $empleado_id)->first();
        $emp->estado = $estado;
        $emp->turno_id = $turno_id;
        $emp->sede_id = $sede_id;
        if ($emp->save()) {
            $resp = 1;
        }else {
            $resp = 0;
        }

        return response()->json(['resp' => $resp]);
    }
}
