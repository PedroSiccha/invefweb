<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
        
    $banner = DB::SELECT('SELECT * FROM banner WHERE estado = "ACTIVO"');

    $resumen = DB::SELECT('SELECT * FROM resumen WHERE estado = "ACTIVO"');

    $porQueElegirnos = DB::SELECT('SELECT * FROM resumenempresa WHERE estado = "ACTIVO"');
    
    $caracteristicas = DB::SELECT('SELECT * FROM caracteristicas WHERE estado = "ACTIVO"');

    return view('welcome', compact('banner', 'resumen', 'porQueElegirnos', 'caracteristicas'));
    
})->name('web');

Route::post('/guardarFormulario', [App\Http\Controllers\MarketingController::class, 'guardarFormulario'])->name('guardarFormulario');

Route::get('/sobre-nosotros', function () {

    $banner = DB::SELECT('SELECT * FROM banernosotros WHERE estado = "ACTIVO"');

    $nosotros = DB::SELECT('SELECT * FROM nosotros WHERE estado = "ACTIVO"');

    return view('web.nosotros', compact('banner', 'nosotros'));
    
})->name('nosotros');

Route::get('/servicios', function () {
    
    $banner = DB::SELECT('SELECT * FROM bannerservicios WHERE estado = "ACTIVO"');

    $servicios = DB::SELECT('SELECT * FROM servicios WHERE estado = "ACTIVO"');

    return view('web.servicio', compact('banner', 'servicios'));
    
})->name('servicios');

Route::get('/preguntas-frecuentes', function () {
    
    $banner = DB::SELECT('SELECT * FROM bannerpreguntafrecuenta WHERE estado = "ACTIVO"');

    $pregunta = DB::SELECT('SELECT * FROM preguntafrecuente WHERE estado = "ACTIVO"');

    return view('web.preguntafrecuente', compact('banner', 'pregunta'));
    
})->name('preguntas');

Route::get('/equipos', function () {
    
    $banner = DB::SELECT('SELECT * FROM banner WHERE estado = "ACTIVO"');

    $resumen = DB::SELECT('SELECT * FROM resumen WHERE estado = "ACTIVO"');

    $porQueElegirnos = DB::SELECT('SELECT * FROM resumenempresa WHERE estado = "ACTIVO"');

    return view('web.liquidacion', compact('banner', 'resumen', 'porQueElegirnos'));
    
})->name('equipos');

Route::get('/detalleProducto', function () {
    
    $banner = DB::SELECT('SELECT * FROM banner WHERE estado = "ACTIVO"');

    $resumen = DB::SELECT('SELECT * FROM resumen WHERE estado = "ACTIVO"');

    $porQueElegirnos = DB::SELECT('SELECT * FROM resumenempresa WHERE estado = "ACTIVO"');

    return view('web.detalleProducto', compact('banner', 'resumen', 'porQueElegirnos'));
    
})->name('detalleProducto');

Route::get('/cl23', function () {
    $ocupacion = DB::SELECT('SELECT * FROM ocupacion');
    $recomendacion = DB::SELECT('SELECT * FROM recomendacion');
    $tipodoc = DB::SELECT('SELECT * FROM tipodocide');
    $departamento = DB::SELECT('SELECT * FROM departamento');
    $provincia = DB::SELECT('SELECT * FROM provincia');
    $distrito = DB::SELECT('SELECT * FROM distrito');
    return view('web.registroSorteo', compact('ocupacion', 'recomendacion', 'tipodoc', 'departamento' ,'provincia', 'distrito'));
})->name('cli');

Route::post('/mostrarResumen', [App\Http\Controllers\WebController::class, 'mostrarResumen'])->name('mostrarResumen');

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::post('/buscarClienteH', [App\Http\Controllers\HomeController::class, 'buscarClienteH'])->name('buscarClienteH');
    Route::post('/buscarClienteHP', [App\Http\Controllers\HomeController::class, 'buscarClienteHP'])->name('buscarClienteHP');

    Route::post('/verificarCaja', [App\Http\Controllers\HomeController::class, 'VerificarCaja'])->name('verificarCaja');

    /*  Módulo de Atención al Cliente */
    Route::get('/cartera', [App\Http\Controllers\AtencionclienteController::class, 'cartera'])->name('cartera');
    Route::post('/buscarCliente', [App\Http\Controllers\AtencionclienteController::class, 'buscarCliente'])->name('buscarCliente');
    Route::get('/cliente', [App\Http\Controllers\AtencionclienteController::class, 'cliente'])->name('cliente');
    Route::post('/guardarCliente', [App\Http\Controllers\AtencionclienteController::class, 'guadarCliente'])->name('guardarCliente');
    Route::post('/guardarOcupacion', [App\Http\Controllers\AtencionclienteController::class, 'guadarOcupacion'])->name('guardarOcupacion');
    Route::get('/perfilCliente/{id}', [App\Http\Controllers\AtencionclienteController::class, 'perfil'])->name('perfilCliente');
    Route::post('/guardarTipoDocumento', [App\Http\Controllers\AtencionclienteController::class, 'guardarTipoDocumento'])->name('guardarTipoDocumento');
    Route::post('/mostrarProvincia', [App\Http\Controllers\AtencionclienteController::class, 'mostrarProvincia'])->name('mostrarProvincia');
    Route::post('/mostrarDistrito', [App\Http\Controllers\AtencionclienteController::class, 'mostrarDistrito'])->name('mostrarDistrito');
    Route::post('/buscarStandCotizacion', [App\Http\Controllers\AtencionclienteController::class, 'buscarStandCotizacion'])->name('buscarStandCotizacion');
    Route::post('/buscarCasilleroCotizacion', [App\Http\Controllers\AtencionclienteController::class, 'buscarCasilleroCotizacion'])->name('buscarCasilleroCotizacion');
    Route::post('/cargarEditCliente', [App\Http\Controllers\AtencionclienteController::class, 'cargarEditCliente'])->name('cargarEditCliente');
    Route::post('/editarCliente', [App\Http\Controllers\AtencionclienteController::class, 'editarCliente'])->name('editarCliente');
    Route::post('/verificarDNI', [App\Http\Controllers\AtencionclienteController::class, 'verificarDNI'])->name('verificarDNI');
    Route::post('/direCliente', [App\Http\Controllers\AtencionclienteController::class, 'direCliente'])->name('direCliente');
    Route::post('/verNotificacion', [App\Http\Controllers\AtencionclienteController::class, 'verNotificacion'])->name('verNotificacion');
    Route::post('/verPagos', [App\Http\Controllers\AtencionclienteController::class, 'verPago'])->name('verPagos');
    Route::post('/buscarGarantiaPC', [App\Http\Controllers\AtencionclienteController::class, 'buscarGarantiaPC'])->name('buscarGarantiaPC');

    /* Módulo de Prestamos */
    Route::get('/evaluacion', [App\Http\Controllers\PrestamoController::class, 'evaluacion'])->name('evaluacion');
    Route::post('/valorJoyas', [App\Http\Controllers\PrestamoController::class, 'valorJoyas'])->name('valorJoyas');
    Route::post('/generarCotizacion', [App\Http\Controllers\PrestamoController::class, 'generarCotizacion'])->name('generarCotizacion');
    Route::get('/garantia', [App\Http\Controllers\PrestamoController::class, 'garantia'])->name('garantia');
    Route::get('/listcontrato', [App\Http\Controllers\PrestamoController::class, 'listcontrato'])->name('listContrato');
    Route::get('/macro', [App\Http\Controllers\PrestamoController::class, 'macro'])->name('macro');
    Route::get('/prestamo/{id}', [App\Http\Controllers\PrestamoController::class, 'prestamo'])->name('prestamo');
    Route::post('/generarPrestamo', [App\Http\Controllers\PrestamoController::class, 'generarPrestamo'])->name('generarPrestamo');
    Route::get('/printContrato/{id}', [App\Http\Controllers\PrestamoController::class, 'printContrato'])->name('printContrato');
    Route::post('/buscarClienteContrato', [App\Http\Controllers\PrestamoController::class, 'buscarClienteContrato'])->name('buscarClienteContrato');
    Route::get('/descargarPdfContrato/{id}', [App\Http\Controllers\PrestamoController::class, 'descargarPdfContrato'])->name('descargarPdfContrato');
    Route::get('/imprimirContrato/{id}', [App\Http\Controllers\PrestamoController::class, 'imprimirContrato'])->name('imprimirContrato');
    Route::post('/verCorreo', [App\Http\Controllers\PrestamoController::class, 'verCorreo'])->name('verCorreo');
    Route::get('/listaCotizacion', function() {
        $listCotizacion = DB::SELECT('SELECT c.id AS cotizacion_id, c.max, c.min, c.estado AS cotizacion_estado, c.precio, c.created_at AS created_at, cl.id AS cliente_id, cl.nombre AS cl_nombre, cl.apellido AS cl_apellido, cl.dni AS cl_dni, e.id AS empleado_id, e.nombre AS                               e_nombre, e.apellido AS e_apellido, e.dni AS e_dni, g.id AS garantia_id, g.nombre AS g_nombre, g.detalle AS g_detalle, tp.id AS tipoprestamo_id, tp.nombre AS tp_nombre, tp.detalle AS tp_detalle FROM cotizacion c, cliente cl, empleado e,                               garantia g, tipoprestamo tp WHERE c.cliente_id = cl.id AND c.empleado_id = e.id AND c.garantia_id = g.id AND c.tipoprestamo_id = tp.id AND c.estado = "PENDIENTE" ORDER BY c.created_at ASC;');
        
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
        
        $almacen = DB::SELECT('SELECT * FROM almacen');
        
        return view('prestamo.cotizacion', compact('listCotizacion', 'usuario', 'notificacion', 'cantNotificaciones', 'almacen'));
        
    })->name('listaCotizacion');
    Route::post('/asignarCasillero', [App\Http\Controllers\PrestamoController::class, 'asignarCasillero'])->name('asignarCasillero');
    Route::post('/eliminarCotizacion', [App\Http\Controllers\PrestamoController::class, 'eliminarCotizacion'])->name('eliminarCotizacion');
    Route::post('/buscarCotizacion', [App\Http\Controllers\PrestamoController::class, 'buscarCotizacion'])->name('buscarCotizacion');
    

    /* Módulo de Desembolso */
    Route::get('/desembolso', [App\Http\Controllers\DesembolsoController::class, 'desembolso'])->name('desembolso');
    Route::post('/desembolsar', [App\Http\Controllers\DesembolsoController::class, 'desembolsar'])->name('desembolsar');
    Route::get('/printBoucherDesembolso/{id}', [App\Http\Controllers\DesembolsoController::class, 'printBoucherDesembolso'])->name('printBoucherDesembolso');
    Route::post('/buscarDesembolso', [App\Http\Controllers\DesembolsoController::class, 'buscarDesembolso'])->name('buscarDesembolso');
    Route::post('/desembolsarDeposito', [App\Http\Controllers\DesembolsoController::class, 'desembolsarDeposito'])->name('desembolsarDeposito');

    /* Módulo de Almacen */
    Route::get('/buscargarantia', [App\Http\Controllers\AlmacenController::class, 'buscargarantia'])->name('buscarGarantia');
    Route::get('/almacen', [App\Http\Controllers\AlmacenController::class, 'index'])->name('almacen');
    Route::post('/buscarStand', [App\Http\Controllers\AlmacenController::class, 'buscarStand'])->name('buscarStand');
    Route::post('/buscarCasillero', [App\Http\Controllers\AlmacenController::class, 'buscarCasillero'])->name('buscarCasillero');
    Route::post('/cargarStand', [App\Http\Controllers\AlmacenController::class, 'cargarStand'])->name('cargarStand');
    Route::post('/guardarAlmacen', [App\Http\Controllers\AlmacenController::class, 'guardarAlmacen'])->name('guardarAlmacen');
    Route::post('/guardarStand', [App\Http\Controllers\AlmacenController::class, 'guardarStand'])->name('guardarStand');
    Route::post('/guardarCasillero', [App\Http\Controllers\AlmacenController::class, 'guardarCasillero'])->name('guardarCasillero');
    Route::post('/verProvinciaAlmacen', [App\Http\Controllers\AlmacenController::class, 'verProvinciaAlmacen'])->name('verProvinciaAlmacen');
    Route::post('/verDistritoAlmacen', [App\Http\Controllers\AlmacenController::class, 'verDistritoAlmacen'])->name('verDistritoAlmacen');
    Route::post('/buscarGarantiaCasillero', [App\Http\Controllers\AlmacenController::class, 'buscarGarantiaCasillero'])->name('buscarGarantiaCasillero');
    Route::post('/recoger', [App\Http\Controllers\AlmacenController::class, 'recoger'])->name('recoger');
    Route::post('buscarGarantiaPrestamo', [App\Http\Controllers\AlmacenController::class, 'buscarGarantiaPrestamo'])->name('buscarGarantiaPrestamo');
    Route::post('/recogerGarantia', [App\Http\Controllers\AlmacenController::class, 'recogerGarantia'])->name('recogerGarantia');
    Route::post('/mostrarStand', [App\Http\Controllers\AlmacenController::class, 'mostrarStand'])->name('mostrarStand');
    Route::post('/mostrarCasillero', [App\Http\Controllers\AlmacenController::class, 'mostrarCasillero'])->name('mostrarCasillero');
    Route::post('/liberarStand', [App\Http\Controllers\AlmacenController::class, 'v'])->name('liberarStand');
    Route::post('/eliminarCasillero', [App\Http\Controllers\AlmacenController::class, 'eliminarCasillero'])->name('eliminarCasillero');
    Route::post('/cargarAlmacen', [App\Http\Controllers\AlmacenController::class, 'cargarAlmacen'])->name('cargarAlmacen');
    Route::post('/editarAlmacen', [App\Http\Controllers\AlmacenController::class, 'editarAlmacen'])->name('editarAlmacen');
    Route::post('/mostrarCantCasulleros', [App\Http\Controllers\AlmacenController::class, 'mostrarCantCasulleros'])->name('mostrarCantCasulleros');

    /* Módulo de Cobranza */
    Route::get('/atraso', [App\Http\Controllers\CobranzaController::class, 'atraso'])->name('atraso');
    Route::get('/caja/cobranza', [App\Http\Controllers\CobranzaController::class, 'caja'])->name('cajaCobranza');
    Route::get('/notificar', [App\Http\Controllers\CobranzaController::class, 'notificar'])->name('notificar');
    Route::get('/pago', [App\Http\Controllers\CobranzaController::class, 'pago'])->name('pago');
    Route::get('/renovar', [App\Http\Controllers\CobranzaController::class, 'renovar'])->name('renovar');
    Route::post('/buscarClientePago', [App\Http\Controllers\CobranzaController::class, 'buscarClientePago'])->name('buscarClientePago');
    Route::get('/printTicket/{id}', [App\Http\Controllers\CobranzaController::class, 'printTicket'])->name('printTicket');
    Route::post('/pagoPrestamo', [App\Http\Controllers\CobranzaController::class, 'pagoPrestamo'])->name('pagoPrestamo');
    Route::post('/renovarPrestamo', [App\Http\Controllers\CobranzaController::class, 'renovarPrestamo'])->name('renovarPrestamo');
    Route::post('/abrirCaja', [App\Http\Controllers\CobranzaController::class, 'abrirCaja'])->name('abrirCaja');
    Route::post('/abrirBanco', [App\Http\Controllers\CobranzaController::class, 'abrirBanco'])->name('abrirBanco');
    Route::post('/crearCaja', [App\Http\Controllers\CobranzaController::class, 'crearCaja'])->name('crearCaja');
    Route::post('/consultarCaja', [App\Http\Controllers\CobranzaController::class, 'consultarCaja'])->name('consultarCaja');
    Route::post('/cerrarCaja', [App\Http\Controllers\CobranzaController::class, 'cerrarCaja'])->name('cerrarCaja');
    Route::post('/abrirCajaHome', [App\Http\Controllers\CobranzaController::class, 'abrirCajaHome'])->name('abrirCajaHome');
    Route::post('/detalleCajaDia', [App\Http\Controllers\CobranzaController::class, 'detalleCajaDia'])->name('detalleCajaDia'); 
    Route::post('/buscarFechaDiaCaja', [App\Http\Controllers\CobranzaController::class, 'buscarFechaDiaCaja'])->name('buscarFechaDiaCaja');
    Route::post('/buscarFechaMesCaja', [App\Http\Controllers\CobranzaController::class, 'buscarFechaMesCaja'])->name('buscarFechaMesCaja');
    Route::post('/buscarDepositoCliente', [App\Http\Controllers\CobranzaController::class, 'buscarDepositoCliente'])->name('buscarDepositoCliente');
    Route::post('/busquedaClienteNotifi', [App\Http\Controllers\CobranzaController::class, 'busquedaClienteNotifi'])->name('busquedaClienteNotifi');
    Route::post('/pasarLiquidacion', [App\Http\Controllers\CobranzaController::class, 'pasarLiquidacion'])->name('pasarLiquidacion');
    Route::post('/depositarPrestamo', [App\Http\Controllers\CobranzaController::class, 'depositarPrestamo'])->name('depositarPrestamo');
    Route::post('/renovarDepositoPrestamo', [App\Http\Controllers\CobranzaController::class, 'renovarDepositoPrestamo'])->name('renovarDepositoPrestamo');
    Route::post('/guardarNotificar', [App\Http\Controllers\CobranzaController::class, 'guardarNotificar'])->name('guardarNotificar');
    Route::post('/consultarMovimiento', [App\Http\Controllers\CobranzaController::class, 'consultarMovimiento'])->name('consultarMovimiento');
    Route::post('/ingresarComision', [App\Http\Controllers\CobranzaController::class, 'ingresarComision'])->name('ingresarComision');
    Route::post('/consultarHistorial', [App\Http\Controllers\CobranzaController::class, 'consultarHistorial'])->name('consultarHistorial');
    Route::post('/abrirCajaGrande', [App\Http\Controllers\CobranzaController::class, 'abrirCajaGrande'])->name('abrirCajaGrande');
    Route::get('/gestionBanco', [App\Http\Controllers\CobranzaController::class, 'gestionBanco'])->name('gestionBanco');
    Route::post('/crearBanco', [App\Http\Controllers\CobranzaController::class, 'crearBanco'])->name('crearBanco');
    Route::post('/editarBanco', [App\Http\Controllers\CobranzaController::class, 'editarBanco'])->name('editarBanco');
    Route::post('/eliminarBanco', [App\Http\Controllers\CobranzaController::class, 'eliminarBanco'])->name('eliminarBanco');
    Route::post('/buscarBanco', [App\Http\Controllers\CobranzaController::class, 'buscarBanco'])->name('buscarBanco');
    Route::post('/asignarCapital', [App\Http\Controllers\CobranzaController::class, 'asignarCapital'])->name('asignarCapital');
    Route::post('/asignarCapitalBanco', [App\Http\Controllers\CobranzaController::class, 'asignarCapitalBanco'])->name('asignarCapitalBanco');
    

    /* Módulo de Liquidación */
    Route::get('/producto', [App\Http\Controllers\LiquidacionController::class, 'producto'])->name('producto');
    Route::post('/venderGarantia', [App\Http\Controllers\LiquidacionController::class, 'venderGarantia'])->name('venderGarantia');
    Route::get('/vendido', [App\Http\Controllers\LiquidacionController::class, 'v'])->name('vendido');
    Route::post('/buscarProdLiquidacion', [App\Http\Controllers\LiquidacionController::class, 'buscarProdLiquidacion'])->name('buscarProdLiquidacion');
    Route::post('/agendarRecojo', [App\Http\Controllers\LiquidacionController::class, 'agendarRecojo'])->name('agendarRecojo');
    Route::post('/ponerVenta', [App\Http\Controllers\LiquidacionController::class, 'ponerVendido'])->name('ponerVenta');
    Route::post('/listaAgendados', [App\Http\Controllers\LiquidacionController::class, 'listaAgendados'])->name('listaAgendados');

    /* Módulo de Ventas */
    Route::get('/ventas', [App\Http\Controllers\VentaController::class, 'index'])->name('venta');

    /* Módulo de Recursos Humanos */
    Route::get('/empleado', [App\Http\Controllers\RecursohumanosController::class, 'empleado'])->name('empleado');
    Route::get('/pagopersonal', [App\Http\Controllers\RecursohumanosController::class, 'pagopersonal'])->name('pagoPersonal');
    Route::get('/rendimientopersonal', [App\Http\Controllers\RecursohumanosController::class, 'rendimientopersonal'])->name('rendimientoPersonal');
    
    Route::get('/seguridad', [App\Http\Controllers\RecursohumanosController::class, 'seguridad'])->middleware('verificarRol')->name('seguridad');
    
    Route::post('/verMenuRol', [App\Http\Controllers\RecursohumanosController::class, 'verMenuRol'])->name('verMenuRol');
    Route::post('/eliminarMenuRol', [App\Http\Controllers\RecursohumanosController::class, 'eliminarMenuRol'])->name('eliminarMenuRol');
    
    
    Route::get('/perfilEmpleadoRendimiento/{id}', [App\Http\Controllers\RecursohumanosController::class, 'perfilEmpleadoRendimiento'])->name('perfilEmpleadoRendimiento');
    Route::post('/guardarEmpleado', [App\Http\Controllers\RecursohumanosController::class, 'guardarEmpleado'])->name('guardarEmpleado');
    Route::post('/crearRol', [App\Http\Controllers\RecursohumanosController::class, 'crearRol'])->name('crearRol');
    Route::get('/menuRol', [App\Http\Controllers\MenuRolController::class, 'index'])->name('menuRol');
    Route::post('/asignarMenuRol', [App\Http\Controllers\RecursohumanosController::class, 'asignarMenuRol'])->name('asignarMenuRol');
    Route::post('/nuevoPermiso', [App\Http\Controllers\RecursohumanosController::class, 'nuevoPermiso'])->name('nuevoPermiso');
    Route::post('/asignarPermisoRol', [App\Http\Controllers\RecursohumanosController::class, 'asignarPermisoRol'])->name('asignarPermisoRol');
    Route::post('/activarEmpleado', [App\Http\Controllers\RecursohumanosController::class, 'v'])->name('activarEmpleado');
    Route::post('/baja', [App\Http\Controllers\RecursohumanosController::class, 'baja'])->name('baja');
    Route::post('/verEmpleado', [App\Http\Controllers\RecursohumanosController::class, 'verEmpleado'])->name('verEmpleado');
    Route::post('/editarEmpleado', [App\Http\Controllers\RecursohumanosController::class, 'editarEmpleado'])->name('editarEmpleado');
    Route::post('/cambiarPass', [App\Http\Controllers\RecursohumanosController::class, 'cambiarPass'])->name('cambiarPass');
    Route::post('/editarSueldo', [App\Http\Controllers\RecursohumanosController::class, 'editarSueldo'])->name('editarSueldo');
    Route::post('/verEmpleadoRendimiento', [App\Http\Controllers\RecursohumanosController::class, 'verEmpleadoRendimiento'])->name('verEmpleadoRendimiento');
    Route::post('/guardarEmpleadoRendimiento', [App\Http\Controllers\RecursohumanosController::class, 'guardarEmpleadoRendimiento'])->name('guardarEmpleadoRendimiento');

    Route::get('rol', [App\Http\Controllers\RolController::class, 'index'])->name('rol');
    Route::get('rolCrear', [App\Http\Controllers\RolController::class, 'crear'])->name('rolCrear');
    Route::post('rol', [App\Http\Controllers\RolController::class, 'guardar'])->name('rolGuardar');


    /* Módulo de Administracion */
    Route::get('/configuraciones', [App\Http\Controllers\AdministracionController::class, 'configuracion'])->name('configuracion');
    Route::post('/guardarInteres', [App\Http\Controllers\AdministracionController::class, 'guardarInteres'])->name('guardarInteres');
    Route::post('/guardarMora', [App\Http\Controllers\AdministracionController::class, 'guardarMora'])->name('guardarMora');
    Route::post('/editarInteres', [App\Http\Controllers\AdministracionController::class, 'editarInteres'])->name('editarInteres');
    Route::post('/editarMora', [App\Http\Controllers\AdministracionController::class, 'editarMora'])->name('editarMora');
    Route::post('/eliminarInteres', [App\Http\Controllers\AdministracionController::class, 'eliminarInteres'])->name('eliminarInteres');
    Route::post('/eliminarMora', [App\Http\Controllers\AdministracionController::class, 'eliminarMora'])->name('eliminarMora');
    Route::get('/politicas', [App\Http\Controllers\AdministracionController::class, 'politicas'])->name('politicas');
    Route::get('/reuniones', [App\Http\Controllers\AdministracionController::class, 'reuniones'])->name('reuniones');
    Route::get('/sedes', [App\Http\Controllers\AdministracionController::class, 'sedes'])->name('sedes');
    Route::post('/guardarSede', [App\Http\Controllers\AdministracionController::class, 'guardarSede'])->name('guardarSede');
    Route::post('/guardarTipoGarantia', [App\Http\Controllers\AdministracionController::class, 'guardarTipoGarantia'])->name('guardarTipoGarantia');
    Route::get('/gestionPrestamo', [App\Http\Controllers\AdministracionController::class, 'gestionPrestamo'])->name('gestionPrestamo');
    Route::post('/mostrarPrestamo', [App\Http\Controllers\AdministracionController::class, 'mostrarPrestamo'])->name('mostrarPrestamo');
    Route::post('/verifGestionPrestamo', [App\Http\Controllers\AdministracionController::class, 'verifGestionPrestamo'])->name('verifGestionPrestamo');
    Route::post('/editarPrestamo', [App\Http\Controllers\AdministracionController::class, 'editarPrestamo'])->name('editarPrestamo');
    Route::post('/guardarGasto', [App\Http\Controllers\AdministracionController::class, 'guardarGasto'])->name('guardarGasto');
    Route::post('/guardarGastosCG', [App\Http\Controllers\AdministracionController::class, 'guardarGastosCG'])->name('guardarGastosCG');
    Route::post('/guardarGastosBanco', [App\Http\Controllers\AdministracionController::class, 'guardarGastosBanco'])->name('guardarGastosBanco');
    Route::get('/gestionCapital', [App\Http\Controllers\AdministracionController::class, 'gestionCapital'])->name('gestionCapital');
    Route::post('/mostrarCaja', [App\Http\Controllers\AdministracionController::class, 'mostrarCaja'])->name('mostrarCaja');
    Route::post('/editarCapital', [App\Http\Controllers\AdministracionController::class, 'editarCapital'])->name('editarCapital');
    Route::post('/buscarPrestamoAdministracion', [App\Http\Controllers\AdministracionController::class, 'buscarPrestamoAdministracion'])->name('buscarPrestamoAdministracion');
    Route::post('/guardarDepartamento', [App\Http\Controllers\AdministracionController::class, 'guardarDepartamento'])->name('guardarDepartamento');
    Route::post('/guardarProvincia', [App\Http\Controllers\AdministracionController::class, 'guardarProvincia'])->name('guardarProvincia');
    Route::post('/guardarDistrito', [App\Http\Controllers\AdministracionController::class, 'guardarDistrito'])->name('guardarDistrito');
    Route::post('/actualizarSede', [App\Http\Controllers\AdministracionController::class, 'actualizarSede'])->name('actualizarSede');
    Route::post('/eliminarSede', [App\Http\Controllers\AdministracionController::class, 'eliminarSede'])->name('eliminarSede');
    Route::post('/editarTipoGarantia', [App\Http\Controllers\AdministracionController::class, 'editarTipoGarantia'])->name('editarTipoGarantia');
    Route::post('/editarDepartamento', [App\Http\Controllers\AdministracionController::class, 'editarDepartamento'])->name('editarDepartamento');
    Route::post('/editarProvincia', [App\Http\Controllers\AdministracionController::class, 'editarProvincia'])->name('editarProvincia');
    Route::post('/editarDistrito', [App\Http\Controllers\AdministracionController::class, 'editarDistrito'])->name('editarDistrito');
    Route::post('/eliminarTipoGarantia', [App\Http\Controllers\AdministracionController::class, 'eliminarTipoGarantia'])->name('eliminarTipoGarantia');
    Route::post('/eliminarDepartamento', [App\Http\Controllers\AdministracionController::class, 'eliminarDepartamento'])->name('eliminarDepartamento');
    Route::post('/eliminarProvincia', [App\Http\Controllers\AdministracionController::class, 'eliminarProvincia'])->name('eliminarProvincia');
    Route::post('/eliminarDistrito', [App\Http\Controllers\AdministracionController::class, 'eliminarDistrito'])->name('eliminarDistrito');
    
    Route::post('/guardarRecomendacion', [App\Http\Controllers\AdministracionController::class, 'guardarRecomendacion'])->name('guardarRecomendacion');
    Route::post('/editarRecomendacion', [App\Http\Controllers\AdministracionController::class, 'editarRecomendacion'])->name('editarRecomendacion');
    Route::post('/eliminarRecomendacion', [App\Http\Controllers\AdministracionController::class, 'eliminarRecomendacion'])->name('eliminarRecomendacion');

    /* Módulo de Finanzas */
    Route::get('/analisisresult', [App\Http\Controllers\FinanzaController::class, 'analisisresult'])->name('analisisResult');
    Route::get('/caja', [App\Http\Controllers\FinanzaController::class, 'caja'])->name('flujoCaja');
    Route::get('/estprestamo', [App\Http\Controllers\FinanzaController::class, 'estprestamo'])->name('estPrestamo');
    
    Route::post('/graficoEstPrestamoAnual', [App\Http\Controllers\FinanzaController::class, 'graficoEstPrestamoAnual'])->name('graficoEstPrestamoAnual');
    
    Route::post('/cerrarControlPatrimonio', [App\Http\Controllers\FinanzaController::class, 'cerrarControlPatrimonio'])->name('cerrarControlPatrimonio');
    
    Route::get('/gastos', [App\Http\Controllers\FinanzaController::class, 'gastos'])->name('gastos');
    Route::get('/patrimonio', [App\Http\Controllers\FinanzaController::class, 'patrimonio'])->name('patrimonio');
    Route::post('/registrarInventario', [App\Http\Controllers\FinanzaController::class, 'registrarInventario'])->name('registrarInventario');
    Route::post('/editarInventario', [App\Http\Controllers\FinanzaController::class, 'editarInventario'])->name('editarInventario');
    Route::post('/eliminarInventario', [App\Http\Controllers\FinanzaController::class, 'eliminarInventario'])->name('eliminarInventario');
    Route::post('/graficoPatrimonio', [App\Http\Controllers\FinanzaController::class, 'graficoPatrimonio'])->name('graficoPatrimonio');
    Route::post('/tabMesPatrimonio', [App\Http\Controllers\FinanzaController::class, 'tabMesPatrimonio'])->name('tabMesPatrimonio');
    Route::post('/getListaMesPatrimonio', [App\Http\Controllers\FinanzaController::class, 'getListaMesPatrimonio'])->name('getListaMesPatrimonio');
    /* Rutas de las Graficas de Finanzas */
    Route::post('/graficoLineaPrestamo', [App\Http\Controllers\FinanzaController::class, 'graficoLineaPrestamo'])->name('graficoLineaPrestamo');
    Route::post('/graficoLineaPrestamoEstado', [App\Http\Controllers\FinanzaController::class, 'graficoLineaPrestamoEstado'])->name('graficoLineaPrestamoEstado');
    Route::post('/graficoLineaBienesDia', [App\Http\Controllers\FinanzaController::class, 'graficoLineaBienesDia'])->name('graficoLineaBienesDia');
    Route::post('/graficoLineaLiquidacionDia', [App\Http\Controllers\FinanzaController::class, 'graficoLineaLiquidacionDia'])->name('graficoLineaLiquidacionDia');
    Route::post('/graficoLineaVendidoDia', [App\Http\Controllers\FinanzaController::class, 'graficoLineaVendidoDia'])->name('graficoLineaVendidoDia');
    Route::post('/graficoLineaClienteDia', [App\Http\Controllers\FinanzaController::class, 'graficoLineaClienteDia'])->name('graficoLineaClienteDia');
    Route::post('/graficoLineaEfectivoDia', [App\Http\Controllers\FinanzaController::class, 'graficoLineaEfectivoDia'])->name('graficoLineaEfectivoDia');
    Route::post('/graficoLineaInteresDia', [App\Http\Controllers\FinanzaController::class, 'graficoLineaInteresDia'])->name('graficoLineaInteresDia');
    Route::post('/graficoLineaMoraDia', [App\Http\Controllers\FinanzaController::class, 'graficoLineaMoraDia'])->name('graficoLineaMoraDia');
    Route::post('/graficoLineaVentaDia', [App\Http\Controllers\FinanzaController::class, 'graficoLineaVentaDia'])->name('graficoLineaVentaDia');
    Route::post('/graficoLineaAdministrativoDia', [App\Http\Controllers\FinanzaController::class, 'graficoLineaAdministrativoDia'])->name('graficoLineaAdministrativoDia');
    Route::post('/graficoLineaPrestamoActivoDia', [App\Http\Controllers\FinanzaController::class, 'graficoLineaPrestamoActivoDia'])->name('graficoLineaPrestamoActivoDia');
    Route::post('/graficoLineaPrestamoMes', [App\Http\Controllers\FinanzaController::class, 'graficoLineaPrestamoMes'])->name('graficoLineaPrestamoMes');
    Route::post('/graficoLineaBienesMes', [App\Http\Controllers\FinanzaController::class, 'graficoLineaBienesMes'])->name('graficoLineaBienesMes');
    Route::post('/graficoLineaLiquidacionMes', [App\Http\Controllers\FinanzaController::class, 'graficoLineaLiquidacionMes'])->name('graficoLineaLiquidacionMes');
    Route::post('/graficoLineaVendidoMes', [App\Http\Controllers\FinanzaController::class, 'graficoLineaVendidoMes'])->name('graficoLineaVendidoMes');
    Route::post('/graficoLineaClienteMes', [App\Http\Controllers\FinanzaController::class, 'graficoLineaClienteMes'])->name('graficoLineaClienteMes');
    Route::post('/graficoLineaEfectivoMes', [App\Http\Controllers\FinanzaController::class, 'graficoLineaEfectivoMes'])->name('graficoLineaEfectivoMes');
    Route::post('/graficoLineaInteresMes', [App\Http\Controllers\FinanzaController::class, 'graficoLineaInteresMes'])->name('graficoLineaInteresMes');
    Route::post('/graficoLineaMoraMes', [App\Http\Controllers\FinanzaController::class, 'graficoLineaMoraMes'])->name('graficoLineaMoraMes');
    Route::post('/graficoLineaVentaMes', [App\Http\Controllers\FinanzaController::class, 'graficoLineaVentaMes'])->name('graficoLineaVentaMes');
    Route::post('/graficoLineaAdministrativoMes', [App\Http\Controllers\FinanzaController::class, 'graficoLineaAdministrativoMes'])->name('graficoLineaAdministrativoMes');
    Route::post('/graficoLineaPrestamoActivoMes', [App\Http\Controllers\FinanzaController::class, 'graficoLineaPrestamoActivoMes'])->name('graficoLineaPrestamoActivoMes');
    Route::post('/graficoLineaFlujoCaja', [App\Http\Controllers\FinanzaController::class, 'graficoLineaFlujoCaja'])->name('graficoLineaFlujoCaja');
    Route::post('/graficoLineaFlujoCajaMes', [App\Http\Controllers\FinanzaController::class, 'graficoLineaFlujoCajaMes'])->name('graficoLineaFlujoCajaMes');
    Route::post('/graficoFlujoCajaAnual', [App\Http\Controllers\FinanzaController::class, 'graficoFlujoCajaAnual'])->name('graficoFlujoCajaAnual');
    Route::post('/analisisResultadoMes', [App\Http\Controllers\FinanzaController::class, 'analisisResultadoMes'])->name('analisisResultadoMes');
    Route:: post('/verHistorialPat', [App\Http\Controllers\FinanzaController::class, 'verHistorialPat'])->name('verHistorialPat');
    Route::post('/verHisrialGastosDia', [App\Http\Controllers\FinanzaController::class, 'verHisrialGastosDia'])->name('verHisrialGastosDia');
    Route::post('/verHistorialGastosCGDia', [App\Http\Controllers\FinanzaController::class, 'verHistorialGastosCGDia'])->name('verHistorialGastosCGDia');
    Route::post('/graficoAnual', [App\Http\Controllers\FinanzaController::class, 'graficoAnual'])->name('graficoAnual');
    /*Fin Rutas Graficas */

    /* Módulo de Marketing */
    Route::get('/cliente/marketing', [App\Http\Controllers\MarketingController::class, 'cliente'])->name('clienteMarketing');
    Route::post('/busquedaClientePotencial', [App\Http\Controllers\MarketingController::class, 'busquedaClientePotencial'])->name('busquedaClientePotencial');
    Route::get('/liquidacion', [App\Http\Controllers\MarketingController::class, 'liquidacion'])->name('liquidacion');
    Route::get('/presupuesto', [App\Http\Controllers\MarketingController::class, 'presupuesto'])->name('presupuesto');
    Route::get('/reportes', [App\Http\Controllers\MarketingController::class, 'reportes'])->name('reportes');
    Route::post('/guardarPresupuesto', [App\Http\Controllers\MarketingController::class, 'guardarPresupuesto'])->name('guardarPresupuesto');
    Route::post('/graficoMarketing', [App\Http\Controllers\MarketingController::class, 'graficoMarketing'])->name('graficoMarketing');
    Route::post('/busquedaSemaforo', [App\Http\Controllers\MarketingController::class, 'busquedaSemaforo'])->name('busquedaSemaforo');
    Route::get('/reportesCliente', [App\Http\Controllers\MarketingController::class, 'reportesCliente'])->name('reportesCliente');
    Route::post('/graficoLineaClienteNuevo', [App\Http\Controllers\MarketingController::class, 'graficoLineaClienteNuevo'])->name('graficoLineaClienteNuevo');
    Route::post('/graficoLineaClientesNuevosMes', [App\Http\Controllers\MarketingController::class, 'graficoLineaClientesNuevosMes'])->name('graficoLineaClientesNuevosMes');
    Route::get('/reportesRecomendacion', [App\Http\Controllers\MarketingController::class, 'reportesRecomendacion'])->name('reportesRecomendacion');
    Route::post('/graficoRecomendaciones', [App\Http\Controllers\MarketingController::class, 'graficoRecomendaciones'])->name('graficoRecomendaciones');
    Route::post('/mostrarRecomendacion', [App\Http\Controllers\MarketingController::class, 'mostrarRecomendacion'])->name('mostrarRecomendacion');
    Route::post('/graficoLineaRecomendacion', [App\Http\Controllers\MarketingController::class, 'graficoLineaRecomendacion'])->name('graficoLineaRecomendacion');
    Route::post('/graficoLineaRecomendacionMes', [App\Http\Controllers\MarketingController::class, 'graficoLineaRecomendacionMes'])->name('graficoLineaRecomendacionMes');
    Route::post('/graficoLineaRecomendacionAnual', [App\Http\Controllers\MarketingController::class, 'graficoLineaRecomendacionAnual'])->name('graficoLineaRecomendacionAnual');
    Route::post('/graficoMarketingRecomendaciones', [App\Http\Controllers\MarketingController::class, 'graficoMarketingRecomendaciones'])->name('graficoMarketingRecomendaciones');
    Route::post('/graficoMarketingRecomendacionesDias', [App\Http\Controllers\MarketingController::class, 'graficoMarketingRecomendacionesDias'])->name('graficoMarketingRecomendacionesDias');
    Route::post('/graficoMarketingRecomendacionMes', [App\Http\Controllers\MarketingController::class, 'graficoMarketingRecomendacionMes'])->name('graficoMarketingRecomendacionMes');
    Route::post('/listaClienteNuevoDia', [App\Http\Controllers\MarketingController::class, 'listaClienteNuevoDia'])->name('listaClienteNuevoDia');
    Route::post('/listaClientesNuevosMes', [App\Http\Controllers\MarketingController::class, 'listaClientesNuevosMes'])->name('listaClientesNuevosMes');
    Route::post('/listaClientesNuevosAnio', [App\Http\Controllers\MarketingController::class, 'listaClientesNuevosAnio'])->name('listaClientesNuevosAnio');
    
    Route::post('/graficoLineaRenovacionesDia', [App\Http\Controllers\MarketingController::class, 'graficoLineaRenovacionesDia'])->name('graficoLineaRenovacionesDia');
    Route::post('/listaRenovacionesDia', [App\Http\Controllers\MarketingController::class, 'listaRenovacionesDia'])->name('listaRenovacionesDia');
    Route::post('/graficoLineaPresGenerales', [App\Http\Controllers\MarketingController::class, 'graficoLineaPresGenerales'])->name('graficoLineaPresGenerales');
    Route::post('/listaPresGeneralesDia', [App\Http\Controllers\MarketingController::class, 'listaPresGeneralesDia'])->name('listaPresGeneralesDia');
    Route::post('/graficoLineaRenovacionesMes', [App\Http\Controllers\MarketingController::class, 'graficoLineaRenovacionesMes'])->name('graficoLineaRenovacionesMes');
    Route::post('/listaRenovacionesMes', [App\Http\Controllers\MarketingController::class, 'listaRenovacionesMes'])->name('listaRenovacionesMes');
    Route::post('/graficoLineaPresGeneralesMes', [App\Http\Controllers\MarketingController::class, 'graficoLineaPresGeneralesMes'])->name('graficoLineaPresGeneralesMes');
    Route::post('/listaPresGeneralesMes', [App\Http\Controllers\MarketingController::class, 'listaPresGeneralesMes'])->name('listaPresGeneralesMes');

    /*Pagina Web */
    Route::get('/noticia', [App\Http\Controllers\WebController::class, 'noticia'])->name('noticia');
    Route::post('/guardarBanner', [App\Http\Controllers\WebController::class, 'guardarBanner'])->name('guardarBanner');
    Route::post('/editarBanner', [App\Http\Controllers\WebController::class, 'editarBanner'])->name('editarBanner');
    Route::post('/eliminarBanner', [App\Http\Controllers\WebController::class, 'eliminarBanner'])->name('eliminarBanner');
    Route::post('/cambiarEstadoBanner', [App\Http\Controllers\WebController::class, 'cambiarEstadoBanner'])->name('cambiarEstadoBanner');
    Route::post('/guardarResumenEmpresa', [App\Http\Controllers\WebController::class, 'guardarResumenEmpresa'])->name('guardarResumenEmpresa');
    Route::post('/editarResumenEmpresa', [App\Http\Controllers\WebController::class, 'editarResumenEmpresa'])->name('editarResumenEmpresa');
    Route::post('/eliminarResumen', [App\Http\Controllers\WebController::class, 'eliminarResumen'])->name('eliminarResumen');
    Route::post('/cambiarEstadoResumenEmpresa', [App\Http\Controllers\WebController::class, 'cambiarEstadoResumenEmpresa'])->name('cambiarEstadoResumenEmpresa');
    Route::post('/guardarPorQueElegirnos', [App\Http\Controllers\WebController::class, 'guardarPorQueElegirnos'])->name('guardarPorQueElegirnos');
    Route::post('/editarPorQueElegirnos', [App\Http\Controllers\WebController::class, 'editarPorQueElegirnos'])->name('editarPorQueElegirnos');
    Route::post('/eliminarPorQueElegirnos', [App\Http\Controllers\WebController::class, 'eliminarPorQueElegirnos'])->name('eliminarPorQueElegirnos');
    Route::post('/cambiarEstadoPorQueElegirnos', [App\Http\Controllers\WebController::class, 'cambiarEstadoPorQueElegirnos'])->name('cambiarEstadoPorQueElegirnos');
    Route::post('/guardarCaracteristica', [App\Http\Controllers\WebController::class, 'guardarCaracteristica'])->name('guardarCaracteristica');
    Route::post('/cambiarEstadoCaracteristica', [App\Http\Controllers\WebController::class, 'cambiarEstadoCaracteristica'])->name('cambiarEstadoCaracteristica');
    Route::get('/configNosotros', [App\Http\Controllers\WebController::class, 'configNosotros'])->name('configNosotros');
    Route::post('/guardarBannerNostros', [App\Http\Controllers\WebController::class, 'guardarBannerNostros'])->name('guardarBannerNostros');
    Route::post('/guardarResumenNosotros', [App\Http\Controllers\WebController::class, 'guardarResumenNosotros'])->name('guardarResumenNosotros');
    Route::post('/guardarDetalleNosotros', [App\Http\Controllers\WebController::class, 'guardarDetalleNosotros'])->name('guardarDetalleNosotros');

    Route::get('/configServicios', [App\Http\Controllers\WebController::class, 'configServicios'])->name('configServicios');
    Route::post('/guardarBannerServicio', [App\Http\Controllers\WebController::class, 'guardarBannerServicio'])->name('guardarBannerServicio');
    Route::post('/cambiarEstadoBannerServicio', [App\Http\Controllers\WebController::class, 'cambiarEstadoBannerServicio'])->name('cambiarEstadoBannerServicio');
    Route::post('/editarBannerServicio', [App\Http\Controllers\WebController::class, 'editarBannerServicio'])->name('editarBannerServicio');
    Route::post('/eliminarBannerServicio', [App\Http\Controllers\WebController::class, 'eliminarBannerServicio'])->name('eliminarBannerServicio');
    Route::post('/guardarServicio', [App\Http\Controllers\WebController::class, 'guardarServicio'])->name('guardarServicio');
    Route::post('/cambiarEstadoServicio', [App\Http\Controllers\WebController::class, 'cambiarEstadoServicio'])->name('cambiarEstadoServicio');
    Route::post('/editarServicio', [App\Http\Controllers\WebController::class, 'editarServicio'])->name('editarServicio');
    Route::post('/eliminarServicio', [App\Http\Controllers\WebController::class, 'eliminarServicio'])->name('eliminarServicio');
    Route::post('/editarCaracteristica', [App\Http\Controllers\WebController::class, 'editarCaracteristica'])->name('editarCaracteristica');
    Route::post('/eliminarCaracteristica', [App\Http\Controllers\WebController::class, 'eliminarCaracteristica'])->name('eliminarCaracteristica');
    
    /* Modulo Semaforo */
    Route::post('/actualizarSemaforo', [App\Http\Controllers\SemaforoController::class, 'actualizarSemaforo'])->name('actualizarSemaforo');
    Route::post('/obtenerSemaforo', [App\Http\Controllers\SemaforoController::class, 'obtenerSemaforo'])->name('obtenerSemaforo');
    Route::post('/personalizarSemaforo', [App\Http\Controllers\SemaforoController::class, 'personalizarSemaforo'])->name('personalizarSemaforo');
    
    //Route::get('/detalleServicio', 'WebController@cambiarEstadoBanner/?')->name('detalleServicio');
    Route::get('/detalleServicio/{id}', function ($id) {
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

        $banner = DB::SELECT('SELECT * FROM bannerservicios WHERE id = "'.$id.'"');

        $requisitos = DB::SELECT('SELECT * FROM requisitos_servicios WHERE servicios_id = "'.$id.'"');


        return view('web.detalleServicio', compact('usuario', 'notificacion', 'cantNotificaciones', 'banner', 'requisito'));
    });

    Route::get('/configPregFrecuentes', [App\Http\Controllers\WebController::class, 'configPregFrecuentes'])->name('configPregFrecuentes');
    Route::post('/guardarBannerPregunta', [App\Http\Controllers\WebController::class, 'guardarBannerPregunta'])->name('guardarBannerPregunta');
    Route::post('/guardarPreguntaFrecuente', [App\Http\Controllers\WebController::class, 'guardarPreguntaFrecuente'])->name('guardarPreguntaFrecuente');

    Route::get('/configProductos', [App\Http\Controllers\WebController::class, 'configProductos'])->name('configProductos');

    Route::get('/configAreas', [App\Http\Controllers\WebController::class, 'configAreas'])->name('configAreas');

    Route::get('/configPromociones', [App\Http\Controllers\WebController::class, 'configPromociones'])->name('configPromociones');


    /* Módulo de Empleado */
    Route::get('/correo', [App\Http\Controllers\EmpleadoController::class, 'correo'])->name('correo');
    Route::get('/manual', [App\Http\Controllers\EmpleadoController::class, 'manual'])->name('manual'); 
    Route::get('/perfilEmpleado', [App\Http\Controllers\EmpleadoController::class, 'perfil'])->name('perfilEmpleado');
