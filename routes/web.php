<?php

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
    return view('welcome');
})->name('web');
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');


//Route::group(['middleware' => ['auth', 'superadmin']], function(){
    //Route::get('/home', 'HomeController@index')->name('home');
    Route::post('/buscarClienteH', 'HomeController@buscarClienteH')->name('buscarClienteH');
    Route::post('/buscarClienteHP', 'HomeController@buscarClienteHP')->name('buscarClienteHP');

    Route::post('/verificarCaja', 'HomeController@VerificarCaja')->name('verificarCaja');

    /*  Módulo de Atención al Cliente */
    Route::get('/cartera', 'AtencionclienteController@cartera')->name('cartera');
    Route::post('/buscarCliente', 'AtencionclienteController@buscarCliente')->name('buscarCliente');
    Route::get('/cliente', 'AtencionclienteController@cliente')->name('cliente');
    Route::post('/guardarCliente', 'AtencionclienteController@guadarCliente')->name('guardarCliente');
    Route::post('/guardarOcupacion', 'AtencionclienteController@guadarOcupacion')->name('guardarOcupacion');
    Route::post('/guardarRecomendacion', 'AtencionclienteController@guadarRecomendacion')->name('guardarRecomendacion');
    Route::get('/perfilCliente/{id}', 'AtencionclienteController@perfil')->name('perfilCliente');
    Route::post('/guardarTipoDocumento', 'AtencionclienteController@guardarTipoDocumento')->name('guardarTipoDocumento');
    Route::post('/mostrarProvincia', 'AtencionclienteController@mostrarProvincia')->name('mostrarProvincia');
    Route::post('/mostrarDistrito', 'AtencionclienteController@mostrarDistrito')->name('mostrarDistrito');
    Route::post('/buscarStandCotizacion', 'AtencionclienteController@buscarStandCotizacion')->name('buscarStandCotizacion');
    Route::post('/buscarCasilleroCotizacion', 'AtencionclienteController@buscarCasilleroCotizacion')->name('buscarCasilleroCotizacion');
    Route::post('/cargarEditCliente', 'AtencionclienteController@cargarEditCliente')->name('cargarEditCliente');
    Route::post('/editarCliente', 'AtencionclienteController@editarCliente')->name('editarCliente');
    Route::post('/verificarDNI', 'AtencionclienteController@verificarDNI')->name('verificarDNI');
    Route::post('/direCliente', 'AtencionclienteController@direCliente')->name('direCliente');
    Route::post('/verNotificacion', 'AtencionclienteController@verNotificacion')->name('verNotificacion');

    /* Módulo de Prestamos */
    Route::get('/evaluacion', 'PrestamoController@evaluacion')->name('evaluacion');
    Route::post('/valorJoyas', 'PrestamoController@valorJoyas')->name('valorJoyas');
    Route::post('/generarCotizacion', 'PrestamoController@generarCotizacion')->name('generarCotizacion');
    Route::get('/garantia', 'PrestamoController@garantia')->name('garantia');
    Route::get('/listcontrato', 'PrestamoController@listcontrato')->name('listContrato');
    Route::get('/macro', 'PrestamoController@macro')->name('macro');
    Route::get('/prestamo/{id}', 'PrestamoController@prestamo')->name('prestamo');
    Route::post('/generarPrestamo', 'PrestamoController@generarPrestamo')->name('generarPrestamo');
    Route::get('/printContrato', 'PrestamoController@printContrato')->name('printContrato');
    Route::post('/buscarClienteContrato', 'PrestamoController@buscarClienteContrato')->name('buscarClienteContrato');
    Route::get('/descargarPdfContrato/{id}', 'PrestamoController@descargarPdfContrato')->name('descargarPdfContrato');
    Route::get('/imprimirContrato/{id}', 'PrestamoController@imprimirContrato')->name('imprimirContrato');
    Route::post('/verCorreo', 'PrestamoController@verCorreo')->name('verCorreo');

    /* Módulo de Desembolso */
    Route::get('/desembolso', 'DesembolsoController@desembolso')->name('desembolso');
    Route::post('/desembolsar', 'DesembolsoController@desembolsar')->name('desembolsar');
    Route::get('/printBoucherDesembolso', 'DesembolsoController@printBoucherDesembolso')->name('printBoucherDesembolso');
    Route::post('/buscarDesembolso', 'DesembolsoController@buscarDesembolso')->name('buscarDesembolso');
    Route::post('/desembolsarDeposito', 'DesembolsoController@desembolsarDeposito')->name('desembolsarDeposito');

    /* Módulo de Almacen */
    Route::get('/buscargarantia', 'AlmacenController@buscargarantia')->name('buscarGarantia');
    Route::get('/almacen', 'AlmacenController@index')->name('almacen');
    Route::post('/buscarStand', 'AlmacenController@buscarStand')->name('buscarStand');
    Route::post('/buscarCasillero', 'AlmacenController@buscarCasillero')->name('buscarCasillero');
    Route::post('/cargarStand', 'AlmacenController@cargarStand')->name('cargarStand');
    Route::post('/guardarAlmacen', 'AlmacenController@guardarAlmacen')->name('guardarAlmacen');
    Route::post('/guardarStand', 'AlmacenController@guardarStand')->name('guardarStand');
    Route::post('/guardarCasillero', 'AlmacenController@guardarCasillero')->name('guardarCasillero');
    Route::post('/verProvinciaAlmacen', 'AlmacenController@verProvinciaAlmacen')->name('verProvinciaAlmacen');
    Route::post('/verDistritoAlmacen', 'AlmacenController@verDistritoAlmacen')->name('verDistritoAlmacen');
    Route::post('/buscarGarantiaCasillero', 'AlmacenController@buscarGarantiaCasillero')->name('buscarGarantiaCasillero');
    Route::post('/recoger', 'AlmacenController@recoger')->name('recoger');
    Route::post('buscarGarantiaPrestamo', 'AlmacenController@buscarGarantiaPrestamo')->name('buscarGarantiaPrestamo');
    Route::post('/recogerGarantia', 'AlmacenController@recogerGarantia')->name('recogerGarantia');
    Route::post('/mostrarStand', 'AlmacenController@mostrarStand')->name('mostrarStand');
    Route::post('/mostrarCasillero', 'AlmacenController@mostrarCasillero')->name('mostrarCasillero');
    Route::post('/liberarStand', 'AlmacenController@liberarStand')->name('liberarStand');
    Route::post('/eliminarCasillero', 'AlmacenController@eliminarCasillero')->name('eliminarCasillero');
    Route::post('/cargarAlmacen', 'AlmacenController@cargarAlmacen')->name('cargarAlmacen');
    Route::post('/editarAlmacen', 'AlmacenController@editarAlmacen')->name('editarAlmacen');
    Route::post('/mostrarCantCasulleros', 'AlmacenController@mostrarCantCasulleros')->name('mostrarCantCasulleros');

    /* Módulo de Cobranza */
    Route::get('/atraso', 'CobranzaController@atraso')->name('atraso');
    Route::get('/caja/cobranza', 'CobranzaController@caja')->name('cajaCobranza');
    Route::get('/notificar', 'CobranzaController@notificar')->name('notificar');
    Route::get('/pago', 'CobranzaController@pago')->name('pago');
    Route::get('/renovar', 'CobranzaController@renovar')->name('renovar');
    Route::post('/buscarClientePago', 'CobranzaController@buscarClientePago')->name('buscarClientePago');
    Route::get('/printTicket', 'CobranzaController@printTicket')->name('printTicket');
    Route::post('/pagoPrestamo', 'CobranzaController@pagoPrestamo')->name('pagoPrestamo');
    Route::post('/renovarPrestamo', 'CobranzaController@renovarPrestamo')->name('renovarPrestamo');
    Route::post('/abrirCaja', 'CobranzaController@abrirCaja')->name('abrirCaja');
    Route::post('/crearCaja', 'CobranzaController@crearCaja')->name('crearCaja');
    Route::post('/consultarCaja', 'CobranzaController@consultarCaja')->name('consultarCaja');
    Route::post('/cerrarCaja', 'CobranzaController@cerrarCaja')->name('cerrarCaja');
    Route::post('/abrirCajaHome', 'CobranzaController@abrirCajaHome')->name('abrirCajaHome');
    Route::post('/detalleCajaDia', 'CobranzaController@detalleCajaDia')->name('detalleCajaDia'); 
    Route::post('/buscarFechaDiaCaja', 'CobranzaController@buscarFechaDiaCaja')->name('buscarFechaDiaCaja');
    Route::post('/buscarFechaMesCaja', 'CobranzaController@buscarFechaMesCaja')->name('buscarFechaMesCaja');
    Route::post('/buscarDepositoCliente', 'CobranzaController@buscarDepositoCliente')->name('buscarDepositoCliente');
    Route::post('/busquedaClienteNotifi', 'CobranzaController@busquedaClienteNotifi')->name('busquedaClienteNotifi');
    Route::post('/pasarLiquidacion', 'CobranzaController@pasarLiquidacion')->name('pasarLiquidacion');
    Route::post('/depositarPrestamo', 'CobranzaController@depositarPrestamo')->name('depositarPrestamo');
    Route::post('/renovarDepositoPrestamo', 'CobranzaController@renovarDepositoPrestamo')->name('renovarDepositoPrestamo');
    Route::post('/guardarNotificar', 'CobranzaController@guardarNotificar')->name('guardarNotificar');
    Route::post('/consultarMovimiento', 'CobranzaController@consultarMovimiento')->name('consultarMovimiento');

    /* Módulo de Liquidación */
    Route::get('/producto', 'LiquidacionController@producto')->name('producto');
    Route::post('/venderGarantia', 'LiquidacionController@venderGarantia')->name('venderGarantia');
    Route::get('/vendido', 'LiquidacionController@vendido')->name('vendido');

    /* Módulo de Ventas */
    Route::get('/ventas', 'VentaController@index')->name('venta');

    /* Módulo de Recursos Humanos */
    Route::get('/empleado', 'RecursohumanosController@empleado')->name('empleado');
    Route::get('/pagopersonal', 'RecursohumanosController@pagopersonal')->name('pagoPersonal');
    Route::get('/rendimientopersonal', 'RecursohumanosController@rendimientopersonal')->name('rendimientoPersonal');
    Route::get('/seguridad', 'RecursohumanosController@seguridad')->name('seguridad');
    Route::get('/perfilEmpleadoRendimiento/{id}', 'RecursohumanosController@perfilEmpleadoRendimiento')->name('perfilEmpleadoRendimiento');
    Route::post('/guardarEmpleado', 'RecursohumanosController@guardarEmpleado')->name('guardarEmpleado');
    Route::post('/crearRol', 'RecursohumanosController@crearRol')->name('crearRol');
    Route::get('/menuRol', 'MenuRolController@index')->name('menuRol');
    Route::post('/asignarMenuRol', 'RecursohumanosController@asignarMenuRol')->name('asignarMenuRol');
    Route::post('/nuevoPermiso', 'RecursohumanosController@nuevoPermiso')->name('nuevoPermiso');
    Route::post('/asignarPermisoRol', 'RecursohumanosController@asignarPermisoRol')->name('asignarPermisoRol');
    Route::post('/activarEmpleado', 'RecursohumanosController@activarEmpleado')->name('activarEmpleado');
    Route::post('/baja', 'RecursohumanosController@baja')->name('baja');
    Route::post('/verEmpleado', 'RecursohumanosController@verEmpleado')->name('verEmpleado');
    Route::post('/editarEmpleado', 'RecursohumanosController@editarEmpleado')->name('editarEmpleado');
    Route::post('/cambiarPass', 'RecursohumanosController@cambiarPass')->name('cambiarPass');
    Route::post('/editarSueldo', 'RecursohumanosController@editarSueldo')->name('editarSueldo');
    Route::post('/verEmpleadoRendimiento', 'RecursohumanosController@verEmpleadoRendimiento')->name('verEmpleadoRendimiento');
    Route::post('/guardarEmpleadoRendimiento', 'RecursohumanosController@guardarEmpleadoRendimiento')->name('guardarEmpleadoRendimiento');

    Route::get('rol', 'RolController@index')->name('rol');
    Route::get('rolCrear', 'RolController@crear')->name('rolCrear');
    Route::post('rol', 'RolController@guardar')->name('rolGuardar');


    /* Módulo de Administracion */
    Route::get('/configuraciones', 'AdministracionController@configuracion')->name('configuracion');
    Route::post('/guardarInteres', 'AdministracionController@guardarInteres')->name('guardarInteres');
    Route::post('/guardarMora', 'AdministracionController@guardarMora')->name('guardarMora');
    Route::post('/editarInteres', 'AdministracionController@editarInteres')->name('editarInteres');
    Route::post('/editarMora', 'AdministracionController@editarMora')->name('editarMora');
    Route::post('/eliminarInteres', 'AdministracionController@eliminarInteres')->name('eliminarInteres');
    Route::post('/eliminarMora', 'AdministracionController@eliminarMora')->name('eliminarMora');
    Route::get('/politicas', 'AdministracionController@politicas')->name('politicas');
    Route::get('/reuniones', 'AdministracionController@reuniones')->name('reuniones');
    Route::get('/sedes', 'AdministracionController@sedes')->name('sedes');
    Route::post('/guardarSede', 'AdministracionController@guardarSede')->name('guardarSede');
    Route::post('/guardarTipoGarantia', 'AdministracionController@guardarTipoGarantia')->name('guardarTipoGarantia');
    Route::get('/gestionPrestamo', 'AdministracionController@gestionPrestamo')->name('gestionPrestamo');
    Route::post('/mostrarPrestamo', 'AdministracionController@mostrarPrestamo')->name('mostrarPrestamo');
    Route::post('/verifGestionPrestamo', 'AdministracionController@verifGestionPrestamo')->name('verifGestionPrestamo');
    Route::post('/editarPrestamo', 'AdministracionController@editarPrestamo')->name('editarPrestamo');
    Route::post('/guardarGasto', 'AdministracionController@guardarGasto')->name('guardarGasto');
    Route::post('/guardarGastosCG', 'AdministracionController@guardarGastosCG')->name('guardarGastosCG');
    Route::get('/gestionCapital', 'AdministracionController@gestionCapital')->name('gestionCapital');
    Route::post('/mostrarCaja', 'AdministracionController@mostrarCaja')->name('mostrarCaja');
    Route::post('/editarCapital', 'AdministracionController@editarCapital')->name('editarCapital');
    Route::post('/buscarPrestamoAdministracion', 'AdministracionController@buscarPrestamoAdministracion')->name('buscarPrestamoAdministracion');
    Route::post('/guardarDepartamento', 'AdministracionController@guardarDepartamento')->name('guardarDepartamento');
    Route::post('/guardarProvincia', 'AdministracionController@guardarProvincia')->name('guardarProvincia');
    Route::post('/guardarDistrito', 'AdministracionController@guardarDistrito')->name('guardarDistrito');
    Route::post('/actualizarSede', 'AdministracionController@actualizarSede')->name('actualizarSede');
    Route::post('/eliminarSede', 'AdministracionController@eliminarSede')->name('eliminarSede');
    Route::post('/editarTipoGarantia', 'AdministracionController@editarTipoGarantia')->name('editarTipoGarantia');
    Route::post('/editarDepartamento', 'AdministracionController@editarDepartamento')->name('editarDepartamento');
    Route::post('/editarProvincia', 'AdministracionController@editarProvincia')->name('editarProvincia');
    Route::post('/editarDistrito', 'AdministracionController@editarDistrito')->name('editarDistrito');
    Route::post('/eliminarTipoGarantia', 'AdministracionController@eliminarTipoGarantia')->name('eliminarTipoGarantia');
    Route::post('/eliminarDepartamento', 'AdministracionController@eliminarDepartamento')->name('eliminarDepartamento');
    Route::post('/eliminarProvincia', 'AdministracionController@eliminarProvincia')->name('eliminarProvincia');
    Route::post('/eliminarDistrito', 'AdministracionController@eliminarDistrito')->name('eliminarDistrito');

    /* Módulo de Finanzas */
    Route::get('/analisisresult', 'FinanzaController@analisisresult')->name('analisisResult');
    Route::get('/caja', 'FinanzaController@caja')->name('flujoCaja');
    Route::get('/estprestamo', 'FinanzaController@estprestamo')->name('estPrestamo');
    Route::get('/gastos', 'FinanzaController@gastos')->name('gastos');
    Route::get('/patrimonio', 'FinanzaController@patrimonio')->name('patrimonio');
    Route::post('/registrarInventario', 'FinanzaController@registrarInventario')->name('registrarInventario');
    /* Rutas de las Graficas de Finanzas */
    Route::post('/graficoLineaPrestamo', 'FinanzaController@graficoLineaPrestamo')->name('graficoLineaPrestamo');
    Route::post('/graficoLineaPrestamoEstado', 'FinanzaController@graficoLineaPrestamoEstado')->name('graficoLineaPrestamoEstado');
    Route::post('/graficoLineaBienesDia', 'FinanzaController@graficoLineaBienesDia')->name('graficoLineaBienesDia');
    Route::post('/graficoLineaLiquidacionDia', 'FinanzaController@graficoLineaLiquidacionDia')->name('graficoLineaLiquidacionDia');
    Route::post('/graficoLineaVendidoDia', 'FinanzaController@graficoLineaVendidoDia')->name('graficoLineaVendidoDia');
    Route::post('/graficoLineaClienteDia', 'FinanzaController@graficoLineaClienteDia')->name('graficoLineaClienteDia');
    Route::post('/graficoLineaEfectivoDia', 'FinanzaController@graficoLineaEfectivoDia')->name('graficoLineaEfectivoDia');
    Route::post('/graficoLineaInteresDia', 'FinanzaController@graficoLineaInteresDia')->name('graficoLineaInteresDia');
    Route::post('/graficoLineaMoraDia', 'FinanzaController@graficoLineaMoraDia')->name('graficoLineaMoraDia');
    Route::post('/graficoLineaVentaDia', 'FinanzaController@graficoLineaVentaDia')->name('graficoLineaVentaDia');
    Route::post('/graficoLineaAdministrativoDia', 'FinanzaController@graficoLineaAdministrativoDia')->name('graficoLineaAdministrativoDia');
    Route::post('/graficoLineaPrestamoActivoDia', 'FinanzaController@graficoLineaPrestamoActivoDia')->name('graficoLineaPrestamoActivoDia');
    Route::post('/graficoLineaPrestamoMes', 'FinanzaController@graficoLineaPrestamoMes')->name('graficoLineaPrestamoMes');
    Route::post('/graficoLineaBienesMes', 'FinanzaController@graficoLineaBienesMes')->name('graficoLineaBienesMes');
    Route::post('/graficoLineaLiquidacionMes', 'FinanzaController@graficoLineaLiquidacionMes')->name('graficoLineaLiquidacionMes');
    Route::post('/graficoLineaVendidoMes', 'FinanzaController@graficoLineaVendidoMes')->name('graficoLineaVendidoMes');
    Route::post('/graficoLineaClienteMes', 'FinanzaController@graficoLineaClienteMes')->name('graficoLineaClienteMes');
    Route::post('/graficoLineaEfectivoMes', 'FinanzaController@graficoLineaEfectivoMes')->name('graficoLineaEfectivoMes');
    Route::post('/graficoLineaInteresMes', 'FinanzaController@graficoLineaInteresMes')->name('graficoLineaInteresMes');
    Route::post('/graficoLineaMoraMes', 'FinanzaController@graficoLineaMoraMes')->name('graficoLineaMoraMes');
    Route::post('/graficoLineaVentaMes', 'FinanzaController@graficoLineaVentaMes')->name('graficoLineaVentaMes');
    Route::post('/graficoLineaAdministrativoMes', 'FinanzaController@graficoLineaAdministrativoMes')->name('graficoLineaAdministrativoMes');
    Route::post('/graficoLineaPrestamoActivoMes', 'FinanzaController@graficoLineaPrestamoActivoMes')->name('graficoLineaPrestamoActivoMes');
    Route::post('/graficoLineaFlujoCaja', 'FinanzaController@graficoLineaFlujoCaja')->name('graficoLineaFlujoCaja');
    Route::post('/graficoLineaFlujoCajaMes', 'FinanzaController@graficoLineaFlujoCajaMes')->name('graficoLineaFlujoCajaMes');
    Route::post('/graficoFlujoCajaAnual', 'FinanzaController@graficoFlujoCajaAnual')->name('graficoFlujoCajaAnual');

    Route::post('/graficoAnual', 'FinanzaController@graficoAnual')->name('graficoAnual');
    /*Fin Rutas Graficas */

    /* Módulo de Marketing */
    Route::get('/cliente/marketing', 'MarketingController@cliente')->name('clienteMarketing');
    Route::get('/liquidacion', 'MarketingController@liquidacion')->name('liquidacion');
    Route::get('/presupuesto', 'MarketingController@presupuesto')->name('presupuesto');
    Route::get('/reportes', 'MarketingController@reportes')->name('reportes');
    Route::post('/guardarPresupuesto', 'MarketingController@guardarPresupuesto')->name('guardarPresupuesto');
    Route::post('/graficoMarketing', 'MarketingController@graficoMarketing')->name('graficoMarketing');

    /*Pagina Web */
    Route::get('/noticia', 'WebController@noticia')->name('noticia');

    /* Módulo de Empleado */
    Route::get('/correo', 'EmpleadoController@correo')->name('correo');
    Route::get('/manual', 'EmpleadoController@manual')->name('manual');
    Route::get('/perfilEmpleado', 'EmpleadoController@perfil')->name('perfilEmpleado');
    
//});
