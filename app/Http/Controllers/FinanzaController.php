<?php

namespace App\Http\Controllers;

use App\Application\UseCases\Banco\GetBancoUseCase;
use App\Application\UseCases\Caja\GetCajaByTipoUseCase;
use App\Application\UseCases\Inventario\GetMontoInventarioUseCase;
use App\Application\UseCases\Liquidacion\GetMontoLiquidacionUseCase;
use App\Application\UseCases\Patrimonio\GetListPatrimonioNetoMesUseCase;
use App\Application\UseCases\Patrimonio\GetListPatrimonioNetoUseCase;
use App\Application\UseCases\Patrimonio\GetPatrimonioNetoCase;
use App\Application\UseCases\Prestamo\GetPrestamosColocadosUseCase;
use App\Models\Caja;
use App\Models\ControlPatrimonio;
use App\Models\Empleado;
use App\Models\Inventario;
use App\Models\Movimiento;
use App\Models\MovimientoDocumento;
use App\Models\Proceso;
use App\Models\TipoInventario;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FinanzaController extends Controller
{
    protected $getCajaByTipoUseCase;
    protected $getBancoUseCase;
    protected $getPrestamosColocadosUseCase;
    protected $getMontoLiquidacionUseCase;
    protected $getMontoInventarioUseCase;
    protected $getPatrimonioNetoCase;
    protected $getListPatrimonioNetoUseCase;
    protected $getListPatrimonioNetoMesUseCase;
    
    public function __construct(
        GetCajaByTipoUseCase $getCajaByTipoUseCase, 
        GetBancoUseCase $getBancoUseCase, 
        GetPrestamosColocadosUseCase $getPrestamosColocadosUseCase, 
        GetMontoLiquidacionUseCase $getMontoLiquidacionUseCase, 
        GetMontoInventarioUseCase $getMontoInventarioUseCase, 
        GetPatrimonioNetoCase $getPatrimonioNetoCase, 
        GetListPatrimonioNetoUseCase $getListPatrimonioNetoUseCase, 
        GetListPatrimonioNetoMesUseCase $getListPatrimonioNetoMesUseCase
        )
    {
        $this->getCajaByTipoUseCase = $getCajaByTipoUseCase;
        $this->getBancoUseCase = $getBancoUseCase;
        $this->getPrestamosColocadosUseCase = $getPrestamosColocadosUseCase;
        $this->getMontoLiquidacionUseCase = $getMontoLiquidacionUseCase;
        $this->getMontoInventarioUseCase = $getMontoInventarioUseCase;
        $this->getPatrimonioNetoCase = $getPatrimonioNetoCase;
        $this->getListPatrimonioNetoUseCase = $getListPatrimonioNetoUseCase;
        $this->getListPatrimonioNetoMesUseCase = $getListPatrimonioNetoMesUseCase;
    }
    
    public function analisisresult()
    {
        $Proceso = new Proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;
        
        $user = Auth::user();
        $usuario = Empleado::join('users as u', 'empleado.users_id', '=', 'u.id')
                            ->where('u.id', $user->id)
                            ->select('empleado.nombre', 'empleado.apellido', 'empleado.id', 'u.name as area', 'empleado.foto', 'empleado.sede_id as sede')
                            ->first();


        $cajaGrande = Caja::join('tipocaja as tc', 'caja.tipocaja_id', '=', 'tc.id')
                    ->where('tc.codigo', 'CG')
                    ->where('caja.sede_id', $idSucursal)
                    ->select('caja.id')
                    ->max('caja.id');
                             

        $utilidades = DB::SELECT('SELECT IF(SUM(intpago) IS NULL, 0.00, SUM(intpago)) AS utilidades
                                   FROM pago 
                                   WHERE sede_id = "'.$idSucursal.'" AND (CONCAT(MONTH(created_at), "-", YEAR(created_at)) = CONCAT(MONTH(NOW()), "-", YEAR(NOW())))');

        $mora = DB::SELECT('SELECT IF(SUM(mora) IS NULL, 0.00, SUM(mora)) AS mora
                             FROM pago 
                             WHERE sede_id = "'.$idSucursal.'" AND (CONCAT(MONTH(created_at), "-", YEAR(created_at)) = CONCAT(MONTH(NOW()), "-", YEAR(NOW())))');

        $venta = DB::SELECT('SELECT IF(SUM(m.importe - m.monto) IS NULL, 0.00, SUM(m.importe - m.monto)) AS venta 
                              FROM movimiento m, caja c
                              WHERE m.caja_id = c.id AND c.sede_id = "'.$idSucursal.'" AND m.codigo = "V" AND CONCAT(MONTH(m.created_at), "-", YEAR(m.created_at)) = CONCAT(MONTH(NOW()), "-", YEAR(NOW()))');
                              

        $gastosadministrativos = Movimiento::join('caja as c', 'movimiento.caja_id', '=', 'c.id')
                                            ->join('tipocaja as tc', 'c.tipocaja_id', '=', 'tc.id')
                                            ->where('c.sede_id', $idSucursal)
                                            ->where('movimiento.codigo', 'GA')
                                            ->where('movimiento.tipo', 'EGRESO')
                                            ->where('movimiento.serie', '!=', 'cc')
                                            ->where('movimiento.concepto', '!=', 'impuesto')
                                            ->whereYear('movimiento.created_at', Carbon::now()->year)
                                            ->whereMonth('movimiento.created_at', Carbon::now()->month)
                                            ->where('c.id', $cajaGrande)
                                            ->selectRaw('COALESCE(SUM(movimiento.monto), 0.00) as monto')
                                            ->first();
                                            
        // dd($gastosadministrativos);
        
        $historialCajaGrande = Movimiento::selectRaw('SUM(movimiento.monto) AS monto, MONTH(movimiento.created_at) AS mes')
                                            ->join('caja', 'movimiento.caja_id', '=', 'caja.id')
                                            ->where('caja.sede_id', $idSucursal)
                                            ->where('movimiento.codigo', 'GA')
                                            ->whereRaw('CONCAT(MONTH(movimiento.created_at), "-", YEAR(movimiento.created_at)) = CONCAT(MONTH(NOW()), "-", YEAR(NOW()))')
                                            ->groupBy('mes')
                                            ->get();
                                            
        // dd($historialCajaGrande);
                                    
                                    // If there are no matching records, set 'monto' to 0
        if ($historialCajaGrande->isEmpty()) {
            $historialCajaGrande = collect([['monto' => 0, 'mes' => null]]);
        }

        $cajaChica = DB::SELECT('SELECT SUM(m.monto) AS monto 
                                  FROM movimiento m, caja c, tipocaja tc
                                  WHERE m.caja_id = c.id AND c.tipocaja_id = tc.id AND tc.codigo = "cc" AND c.sede_id = "'.$idSucursal.'" AND (MONTH(NOW()) = MONTH(m.created_at) AND YEAR(NOW()) = YEAR(m.created_at)) AND m.tipo = "EGRESO" AND m.codigo = "o"');
                                  
        // dd($cajaChica);
                            
        $cajaChicaMonto = $cajaChica ? $cajaChica[0]->monto : 0;

        $historial = DB::SELECT('SELECT SUM(utilidades) AS monto, anio
                                  FROM(SELECT IF(SUM(intpago) IS NULL, 0.00, SUM(intpago)) AS utilidades, YEAR(created_at) AS anio
                                       FROM pago
                                       WHERE sede_id = "'.$idSucursal.'"
                                       GROUP BY YEAR(created_at)
                                       UNION
                                       SELECT IF(SUM(mora) IS NULL, 0.00, SUM(mora)) AS mora, YEAR(created_at) AS anio
                                       FROM pago 
                                       WHERE sede_id = "'.$idSucursal.'"
                                       GROUP BY YEAR(created_at)
                                       UNION
                                       SELECT IF(SUM(m.importe - m.monto) IS NULL, 0.00, SUM(m.importe - m.monto)) AS venta, YEAR(m.created_at) AS anio
                                       FROM movimiento m, caja c
                                       WHERE m.caja_id = c.id AND c.sede_id = "'.$idSucursal.'" AND m.codigo = "V"
                                       GROUP BY YEAR(m.created_at)
                                       UNION
                                       SELECT IF(SUM(m.monto) IS NULL, 0.00, SUM(m.monto))  AS monto, YEAR(m.created_at) AS anio
                                       FROM movimiento m, caja c, tipocaja tc
                                       WHERE m.caja_id = c.id AND c.tipocaja_id = tc.id AND c.sede_id = "'.$idSucursal.'" AND (m.codigo = "GA" OR tc.codigo = "CC") AND m.tipo = "EGRESO" AND m.serie != "cc" AND m.concepto != "impuesto" AND c.id = "'.$cajaGrande.'"
                                       GROUP BY YEAR(m.created_at)) t
                                       GROUP BY anio');

        $historialMes = DB::SELECT('SELECT SUM(utilidades) AS monto, mes
                                     FROM(SELECT IF(SUM(intpago) IS NULL, 0.00, SUM(intpago)) AS utilidades, MONTH(created_at) AS mes
                                          FROM pago 
                                          WHERE sede_id = "'.$idSucursal.'" AND YEAR(created_at) = YEAR(NOW())
                                          GROUP BY MONTH(created_at)
                                          UNION
                                          SELECT IF(SUM(mora) IS NULL, 0.00, SUM(mora)) AS mora, MONTH(created_at) AS mes
                                          FROM pago 
                                          WHERE sede_id = "'.$idSucursal.'" AND YEAR(created_at) = YEAR(NOW())
                                          GROUP BY MONTH(created_at)
                                          UNION
                                          SELECT IF(SUM(m.importe - m.monto) IS NULL, 0.00, SUM(m.importe - m.monto)) AS venta, MONTH(m.created_at) AS mes
                                          FROM movimiento m, caja c
                                          WHERE m.caja_id = c.id AND c.sede_id = "'.$idSucursal.'" AND YEAR(m.created_at) = YEAR(NOW())
                                          GROUP BY MONTH(m.created_at)
                                          UNION
                                          SELECT IF(SUM(m.monto) IS NULL, 0.00, SUM(m.monto))  AS monto, MONTH(m.created_at) AS mes
                                          FROM movimiento m, caja c, tipocaja tc
                                          WHERE m.caja_id = c.id AND c.tipocaja_id = tc.id AND c.sede_id = "'.$idSucursal.'" AND (m.codigo = "GA" OR tc.codigo = "CC") AND m.tipo = "EGRESO" AND m.serie != "cc" AND m.concepto != "impuesto"
                                          AND YEAR(m.created_at) = YEAR(NOW())
                                     GROUP BY MONTH(m.created_at)) t
                                     GROUP BY mes
                                     ORDER BY mes ASC');

        $historialAnual1 = DB::SELECT('SELECT SUM(intpago) + SUM(mora) AS utilidades, YEAR(created_at) AS anio
                                       FROM pago
                                       WHERE sede_id = "'.$idSucursal.'"
                                       GROUP BY YEAR(created_at)');

        $historialAnual2 = DB::SELECT('SELECT SUM(m.importe-m.monto) + SUM(m.importe) AS utilidades, YEAR(m.created_at) AS anio
                                        FROM movimiento m, caja c
                                        WHERE m.caja_id = c.id AND c.sede_id = "'.$idSucursal.'" AND m.codigo = "V" OR m.codigo = "GA" 
                                        GROUP BY YEAR(m.created_at)');

        $historialMes1 = DB::SELECT('SELECT SUM(intpago) + SUM(mora) AS utilidades, MONTH(created_at) AS mes
                                      FROM pago
                                      WHERE sede_id = "'.$idSucursal.'" AND YEAR(created_at) = YEAR(NOW())
                                      GROUP BY MONTH(created_at)');

        $historialMes2 = DB::SELECT('SELECT SUM(m.importe-m.monto) + SUM(m.importe) AS utilidades, MONTH(m.created_at) AS mes
                                      FROM movimiento m, caja c
                                      WHERE m.caja_id = c.id AND c.sede_id = "'.$idSucursal.'" AND m.codigo = "V" OR m.codigo = "GA" AND YEAR(m.created_at) = YEAR(NOW())
                                      GROUP BY MONTH(m.created_at)');

        $impuesto = DB::SELECT('SELECT SUM(m.monto) AS monto 
                                 FROM movimiento m, caja c
                                 WHERE m.caja_id = c.id AND m.concepto = "IMPUESTO" AND c.sede_id = "'.$idSucursal.'" AND c.id = "'.$cajaGrande.'" AND CONCAT(MONTH(m.created_at), "-", YEAR(m.created_at)) = CONCAT(MONTH(NOW()), "-", YEAR(NOW()))');
                                 
        $impuestoHistorial = DB::SELECT('SELECT IF(SUM(m.monto) IS NULL, 0.00, SUM(m.monto))  AS monto, YEAR(m.created_at) AS anio
                                          FROM movimiento m, caja c
                                          WHERE m.caja_id = c.id AND m.concepto = "IMPUESTO" AND c.sede_id = "'.$idSucursal.'" AND c.id = "'.$cajaGrande.'"
                                          GROUP BY YEAR(m.created_at)');
                                          
        $historialCajaChica = DB::SELECT('SELECT SUM(m.monto) AS monto, MONTH(m.created_at) AS mes
                                           FROM movimiento m, caja c
                                           WHERE m.caja_id = c.id AND c.sede_id = "'.$idSucursal.'" AND m.codigo = "o" AND YEAR(m.created_at) = YEAR(NOW())
                                           GROUP BY MONTH(m.created_at)');
                                           
        $cajaBanco = DB::SELECT('SELECT SUM(m.monto) AS monto 
                                  FROM movimiento m, caja c, tipocaja tc 
                                  WHERE m.caja_id = c.id AND c.tipocaja_id = tc.id AND tc.categoria = "banco" AND c.sede_id = "'.$idSucursal.'" AND (MONTH(NOW()) = MONTH(m.created_at) AND YEAR(NOW()) = YEAR(m.created_at)) AND m.tipo = "EGRESO" AND concepto NOT LIKE "%DESEMBOLSO%"');
                                                    
        $historialAnualUtilidades = DB::SELECT('SELECT 
                                                    subquery.anio AS anio,
                                                    IFNULL(subquery.utilidades, 0.00) + IFNULL(subquery.mora, 0.00) + IFNULL(subquery.venta, 0.00) - 
                                                    (IFNULL(subquery.historia_caja_grande, 0.00) + IFNULL(subquery.caja_chica, 0.00) + IFNULL(subquery.caja_banco, 0.00)) AS totalUtilidades
                                                FROM (
                                                    SELECT DISTINCT YEAR(created_at) AS anio,
                                                        (
                                                          SELECT IF(SUM(intpago) IS NULL, 0.00, SUM(intpago))
                                                          FROM pago 
                                                          WHERE sede_id = "'.$idSucursal.'" AND (CONCAT(MONTH(created_at), "-", YEAR(created_at)) = CONCAT(MONTH(NOW()), "-", YEAR(NOW())))
                                                          AND YEAR(created_at) = YEAR(dates.created_at)
                                                         ) AS utilidades,
                                                         
                                                        (
                                                         SELECT IF(SUM(mora) IS NULL, 0.00, SUM(mora))
                                                         FROM pago 
                                                         WHERE sede_id = "'.$idSucursal.'" AND (CONCAT(MONTH(created_at), "-", YEAR(created_at)) = CONCAT(MONTH(NOW()), "-", YEAR(NOW())))
                                                         AND YEAR(created_at) = YEAR(dates.created_at)
                                                         ) AS mora,
                                                         
                                                        (
                                                         SELECT IF(SUM(m.importe - m.monto) IS NULL, 0.00, SUM(m.importe - m.monto))
                                                         FROM movimiento m, caja c
                                                         WHERE m.caja_id = c.id AND c.sede_id = "'.$idSucursal.'" AND m.codigo = "V" AND CONCAT(MONTH(m.created_at), "-", YEAR(m.created_at)) = CONCAT(MONTH(NOW()), "-", YEAR(NOW()))
                                                         AND YEAR(m.created_at) = YEAR(dates.created_at)
                                                         ) AS venta,
                                                         
                                                        (
                                                         SELECT IF(SUM(movimiento.monto) IS NULL, 0.00, SUM(movimiento.monto))
                                                         FROM movimiento 
                                                         INNER JOIN caja ON movimiento.caja_id = caja.id 
                                                         WHERE caja.sede_id = '.$idSucursal.' AND movimiento.codigo = "GA" AND CONCAT(MONTH(movimiento.created_at), "-", YEAR(movimiento.created_at)) = CONCAT(MONTH(NOW()), "-", YEAR(NOW()))
                                                         AND YEAR(movimiento.created_at) = YEAR(dates.created_at)
                                                         ) AS historia_caja_grande,
                                                         
                                                        (
                                                         SELECT IF(SUM(m.monto) IS NULL, 0.00, SUM(m.monto))
                                                         FROM movimiento m, caja c, tipocaja tc
                                                         WHERE m.caja_id = c.id AND c.tipocaja_id = tc.id AND tc.codigo = "cc" AND c.sede_id = "'.$idSucursal.'" AND (MONTH(dates.created_at) = MONTH(m.created_at) AND YEAR(dates.created_at) = YEAR(m.created_at)) AND m.tipo = "EGRESO" AND m.codigo = "o"
                                                         ) AS caja_chica,
                                                         
                                                        (
                                                         SELECT IF(SUM(m.monto) IS NULL, 0.00, SUM(m.monto))
                                                         FROM movimiento m, caja c, tipocaja tc 
                                                         WHERE m.caja_id = c.id AND c.tipocaja_id = tc.id AND tc.categoria = "banco" AND c.sede_id = "'.$idSucursal.'" AND (MONTH(dates.created_at) = MONTH(m.created_at) AND YEAR(dates.created_at) = YEAR(m.created_at)) AND m.tipo = "EGRESO" AND concepto NOT LIKE "%DESEMBOLSO%"
                                                         ) AS caja_banco
                                                    FROM (
                                                        SELECT created_at FROM pago WHERE sede_id = "'.$idSucursal.'" AND (CONCAT(MONTH(created_at), "-", YEAR(created_at)) = CONCAT(MONTH(NOW()), "-", YEAR(NOW())))
                                                        UNION
                                                        SELECT created_at FROM movimiento WHERE caja_id IN (SELECT id FROM caja WHERE sede_id = "'.$idSucursal.'" AND tipocaja_id IN (SELECT id FROM tipocaja WHERE codigo = "cc")) AND tipo = "EGRESO" AND codigo = "o" AND (MONTH(NOW()) = MONTH(created_at) AND YEAR(NOW()) = YEAR(created_at))
                                                        UNION
                                                        SELECT created_at FROM movimiento WHERE caja_id IN (SELECT id FROM caja WHERE sede_id = "'.$idSucursal.'" AND tipocaja_id IN (SELECT id FROM tipocaja WHERE categoria = "banco")) AND tipo = "EGRESO" AND (MONTH(NOW()) = MONTH(created_at) AND YEAR(NOW()) = YEAR(created_at))
                                                        UNION
                                                        SELECT created_at FROM movimiento WHERE caja_id IN (SELECT id FROM caja WHERE sede_id = "'.$idSucursal.'") AND codigo = "V" AND (CONCAT(MONTH(created_at), "-", YEAR(created_at)) = CONCAT(MONTH(NOW()), "-", YEAR(NOW())))
                                                        UNION
                                                        SELECT created_at FROM movimiento WHERE caja_id IN (SELECT id FROM caja WHERE sede_id = "'.$idSucursal.'" AND tipocaja_id IN (SELECT id FROM tipocaja WHERE codigo = "GA")) AND codigo = "GA" AND (CONCAT(MONTH(created_at), "-", YEAR(created_at)) = CONCAT(MONTH(NOW()), "-", YEAR(NOW())))
                                                    ) AS dates
                                                ) AS subquery
                                                ORDER BY subquery.anio;
                                                ');
                                                    
        $historialMensualUtilidades = DB::SELECT('
                                                    SELECT 
                                                        MONTH(subquery.created_at) AS mes,
                                                        IFNULL(subquery.utilidades, 0.00) + IFNULL(subquery.mora, 0.00) + IFNULL(subquery.venta, 0.00) - 
                                                        (IFNULL(subquery.historia_caja_grande, 0.00) + IFNULL(subquery.caja_chica, 0.00) + IFNULL(subquery.caja_banco, 0.00)) AS totalUtilidades
                                                    FROM (
                                                        SELECT 
                                                            created_at,
                                                            (
                                                              SELECT IF(SUM(intpago) IS NULL, 0.00, SUM(intpago))
                                                              FROM pago 
                                                              WHERE sede_id = "2" AND MONTH(created_at) = MONTH(dates.created_at) AND YEAR(created_at) = YEAR(dates.created_at)
                                                             ) AS utilidades,
                                                             
                                                            (
                                                             SELECT IF(SUM(mora) IS NULL, 0.00, SUM(mora))
                                                             FROM pago 
                                                             WHERE sede_id = "2" AND MONTH(created_at) = MONTH(dates.created_at) AND YEAR(created_at) = YEAR(dates.created_at)
                                                             ) AS mora,
                                                             
                                                            (
                                                             SELECT IF(SUM(m.importe - m.monto) IS NULL, 0.00, SUM(m.importe - m.monto))
                                                             FROM movimiento m, caja c
                                                             WHERE m.caja_id = c.id AND c.sede_id = "2" AND m.codigo = "V" AND MONTH(m.created_at) = MONTH(dates.created_at) AND YEAR(m.created_at) = YEAR(dates.created_at)
                                                             ) AS venta,
                                                             
                                                            (
                                                             SELECT IF(SUM(movimiento.monto) IS NULL, 0.00, SUM(movimiento.monto))
                                                             FROM movimiento 
                                                             INNER JOIN caja ON movimiento.caja_id = caja.id 
                                                             WHERE caja.sede_id = 2 AND movimiento.codigo = "GA" AND MONTH(movimiento.created_at) = MONTH(dates.created_at) AND YEAR(movimiento.created_at) = YEAR(dates.created_at)
                                                             ) AS historia_caja_grande,
                                                             
                                                            (
                                                             SELECT IF(SUM(m.monto) IS NULL, 0.00, SUM(m.monto))
                                                             FROM movimiento m, caja c, tipocaja tc
                                                             WHERE m.caja_id = c.id AND c.tipocaja_id = tc.id AND tc.codigo = "cc" AND c.sede_id = "2" AND (MONTH(dates.created_at) = MONTH(m.created_at) AND YEAR(dates.created_at) = YEAR(m.created_at)) AND m.tipo = "EGRESO" AND m.codigo = "o"
                                                             ) AS caja_chica,
                                                             
                                                            (
                                                             SELECT IF(SUM(m.monto) IS NULL, 0.00, SUM(m.monto))
                                                             FROM movimiento m, caja c, tipocaja tc 
                                                             WHERE m.caja_id = c.id AND c.tipocaja_id = tc.id AND tc.categoria = "banco" AND c.sede_id = "2" AND (MONTH(dates.created_at) = MONTH(m.created_at) AND YEAR(dates.created_at) = YEAR(m.created_at)) AND m.tipo = "EGRESO" AND concepto NOT LIKE "%DESEMBOLSO%"
                                                             ) AS caja_banco
                                                        FROM (
                                                            SELECT created_at FROM pago WHERE sede_id = "2" AND MONTH(created_at) = MONTH(NOW()) AND YEAR(created_at) = YEAR(NOW())
                                                            UNION
                                                            SELECT created_at FROM movimiento WHERE caja_id IN (SELECT id FROM caja WHERE sede_id = "2" AND tipocaja_id IN (SELECT id FROM tipocaja WHERE codigo = "cc")) AND tipo = "EGRESO" AND codigo = "o" AND MONTH(created_at) = MONTH(NOW()) AND YEAR(created_at) = YEAR(NOW())
                                                            UNION
                                                            SELECT created_at FROM movimiento WHERE caja_id IN (SELECT id FROM caja WHERE sede_id = "2" AND tipocaja_id IN (SELECT id FROM tipocaja WHERE categoria = "banco")) AND tipo = "EGRESO" AND MONTH(created_at) = MONTH(NOW()) AND YEAR(created_at) = YEAR(NOW())
                                                            UNION
                                                            SELECT created_at FROM movimiento WHERE caja_id IN (SELECT id FROM caja WHERE sede_id = "2") AND codigo = "V" AND MONTH(created_at) = MONTH(NOW()) AND YEAR(created_at) = YEAR(NOW())
                                                            UNION
                                                            SELECT created_at FROM movimiento WHERE caja_id IN (SELECT id FROM caja WHERE sede_id = "2" AND tipocaja_id IN (SELECT id FROM tipocaja WHERE codigo = "GA")) AND codigo = "GA" AND MONTH(created_at) = MONTH(NOW()) AND YEAR(created_at) = YEAR(NOW())
                                                        ) AS dates
                                                    ) AS subquery
                                                    GROUP BY mes
                                                    ORDER BY mes;
        ');
        
        

        return view('finanza.analisisresult', compact('impuesto', 'historialMes1', 'historialMes2', 'historialAnual1', 'historialAnual2', 'usuario', 'utilidades', 'mora', 'venta', 'gastosadministrativos', 'cajaChica', 'historial', 'historialMes', 'impuestoHistorial', 'historialCajaChica', 'historialCajaGrande', 'cajaBanco', 'historialAnualUtilidades', 'historialMensualUtilidades'));
    }

    public function analisisResultadoMes(Request $request)
    {
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;
        
        $anio = $request->anio;

        $historialMensualUtilidades = DB::SELECT('SELECT 
                                        SUM(sub.montoUtilidades) AS totalUtilidades, 
                                        sub.mes 
                                    FROM 
                                        (
                                            SELECT 
                                                (IF(SUM(intpago) IS NULL, 0.00, SUM(intpago)) + IF(SUM(mora) IS NULL, 0.00, SUM(mora))) AS montoUtilidades, 
                                                MONTH(created_at) AS mes 
                                            FROM pago 
                                            WHERE sede_id = "'.$idSucursal.'" AND YEAR(created_at) = YEAR(NOW())
                                            GROUP BY MONTH(created_at)
                                            UNION ALL
                                            SELECT 
                                                IF(SUM(m.importe - m.monto) IS NULL, 0.00, SUM(m.importe - m.monto)) AS venta,
                                                MONTH(m.created_at) AS mes 
                                            FROM movimiento m, caja c
                                            WHERE m.caja_id = c.id AND c.sede_id = "'.$idSucursal.'" AND m.codigo = "V" AND YEAR(m.created_at) = "'.$anio.'"
                                            GROUP BY MONTH(m.created_at)
                                            UNION ALL
                                            SELECT 
                                    			(IF(SUM(m.monto) IS NULL, 0.00, SUM(m.monto)))*(-1) AS montoCajaGrande, 
                                    			MONTH(m.created_at) AS mes 
                                    		FROM movimiento m, caja c
                                    		WHERE m.caja_id = c.id AND c.sede_id = "'.$idSucursal.'" AND m.codigo = "GA" AND YEAR(m.created_at) = "'.$anio.'"
                                    		GROUP BY YEAR(m.created_at)
                                            UNION ALL
                                            SELECT 
                                                (IF(SUM(m.monto) IS NULL, 0.00, SUM(m.monto)))*(-1) AS montoCajaChica, 
                                                MONTH(m.created_at) AS mes
                                    		FROM movimiento m, caja c
                                    		WHERE m.caja_id = c.id AND c.sede_id = "'.$idSucursal.'" AND m.codigo = "o" AND YEAR(m.created_at) = "'.$anio.'"
                                    		GROUP BY MONTH(m.created_at)
                                        ) AS sub 
                                    GROUP BY sub.mes;');

        return response()->json(["view"=>view('finanza.tabAnalisisResultadoMes',compact('historialMensualUtilidades'))->render()]);

    }

    public function caja()
    {
        $user = Auth::user();
        $usuario = DB::SELECT('SELECT e.nombre, e.apellido, e.id, u.name AS area, e.foto AS foto, e.sede_id AS sede
                                FROM empleado e, users u 
                                WHERE e.users_id = u.id AND u.id = "'.$user->id.'"');
                                
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;
        

        $anio = DB::SELECT('SELECT YEAR(fecinicio) AS anio 
                             FROM prestamo 
                             WHERE sede_id = "'.$idSucursal.'"
                             GROUP BY YEAR(fecinicio)');

        return view('finanza.caja', compact('usuario', 'anio'));
    }

    public function graficoLineaFlujoCaja(Request $request)
    {
        
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;
        
        $anio = $request->anio;
        $mes = $request->mes;

        $primer_dia=1;
        $ultimo_dia=$this->getUltimoDiaMes($anio,$mes);
        $fecha_inicial=date("Y-m-d H:i:s", strtotime($anio."-".$mes."-".$primer_dia) );
        $fecha_final=date("Y-m-d H:i:s", strtotime($anio."-".$mes."-".$ultimo_dia) );

        $egreso = DB::SELECT('SELECT SUM(m.importe) AS monto, DATE(m.created_at) AS fecinicio
                                FROM movimiento m, caja c
                                WHERE m.caja_id = c.id AND c.sede_id = "'.$idSucursal.'" AND m.tipo = "EGRESO" AND (m.created_at BETWEEN "'.$fecha_inicial.'" AND "'.$fecha_final.'")
                                GROUP BY DATE(m.created_at)');

        $ingreso = DB::SELECT('SELECT SUM(m.importe) AS monto, DATE(m.created_at) AS fecinicio
                               FROM movimiento m, caja c
                               WHERE m.caja_id = c.id AND c.sede_id = "'.$idSucursal.'" AND m.tipo = "INGRESO" AND (m.created_at BETWEEN "'.$fecha_inicial.'" AND "'.$fecha_final.'")
                               GROUP BY DATE(m.created_at)');

        $pt = count($egreso);

        $pt = count($ingreso);

        for($d=1;$d<=$ultimo_dia;$d++){
            $registros[$d]=0;
            $registroEgreso[$d]=0;
            $registroIngreso[$d]=0;
        }

        foreach($egreso as $e){
            $diasel = intval(date("d",strtotime($e->fecinicio) ) );
            $registroEgreso[$diasel++] = $e->monto;
        }

        foreach($ingreso as $i){
            $diasel = intval(date("d",strtotime($i->fecinicio) ) );
            $registroIngreso[$diasel++] = $i->monto;
        }

        $data = array("totaldias"=>$ultimo_dia, "registroEgreso"=>$registroEgreso, "registroIngreso" => $registroIngreso);

        return json_encode($data);
    }

    public function graficoLineaFlujoCajaMes(Request $request)
    {
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;
        $anio = $request->anio;
    
        $fecha_inicial = date("Y-m-d", strtotime($anio . "-01-01"));
        $fecha_final = date("Y-m-d", strtotime($anio . "-12-31"));
    
        $result = DB::select('SELECT 
                                    SUM(CASE WHEN m.tipo = "EGRESO" THEN m.importe ELSE 0 END) AS monto_egreso,
                                    SUM(CASE WHEN m.tipo = "INGRESO" THEN m.importe ELSE 0 END) AS monto_ingreso,
                                    MONTH(m.created_at) AS fecinicio
                               FROM movimiento m, caja c
                               WHERE m.caja_id = c.id AND c.sede_id = ? AND (m.created_at BETWEEN ? AND ?)
                               GROUP BY MONTH(m.created_at)', [$idSucursal, $fecha_inicial, $fecha_final]);
    
        // Arreglos para almacenar los montos de ingreso y egreso por mes
        $registroEgreso = array_fill(1, 12, 0);
        $registroIngreso = array_fill(1, 12, 0);
    
        foreach ($result as $row) {
            $mes = intval($row->fecinicio);
            $registroEgreso[$mes] = $row->monto_egreso;
            $registroIngreso[$mes] = $row->monto_ingreso;
        }
    
        $data = array("registrosmes" => "12", "registroEgreso" => $registroEgreso, "registroIngreso" => $registroIngreso);
    
        return json_encode($data);
    }


    public function estprestamo()
    {
        $Proceso = new proceso();
        $sucursal = $Proceso->obtenerSucursal();
        $idSucursal = $sucursal->sucursal_id;
        $idEmpleado = $sucursal->id;
        $users_id = Auth::user()->id;
    
        $registroEfectivo = [];
        $registroVenta = [];
        $registroGastosAdministrativos = [];
        $registrosBalancePrestamo = [];
        $registrosBalanceRenovacion = [];
        $registros = [];
        $registroInteres = [];
        $registroMora = [];
    
        $user = Auth::user();
        $usuario = DB::select('SELECT e.nombre, e.apellido, e.id, u.name AS area, e.foto AS foto, e.sede_id AS sede
                                FROM empleado e, users u 
                                WHERE e.users_id = u.id AND u.id = ?', [$user->id]);
    
        $anio = DB::select('SELECT YEAR(fecinicio) AS anio 
                             FROM prestamo 
                             WHERE sede_id = ?
                             GROUP BY YEAR(fecinicio)', [$idSucursal]);
    
        $estado = DB::select('SELECT estado 
                               FROM prestamo 
                               WHERE sede_id = ?
                               GROUP BY estado', [$idSucursal]);
    
        /*Prestmoas*/
        $prestamos = DB::select('SELECT COUNT(*) AS cant, YEAR(fecinicio) AS anio 
                                  FROM prestamo 
                                  WHERE sede_id = ?
                                  GROUP BY YEAR(fecinicio)', [$idSucursal]);
    
        $efectivo = DB::select('SELECT sum(monto) AS monto, YEAR(created_at) AS fec
                                 FROM desembolso 
                                 WHERE sede_id = ?
                                 GROUP BY YEAR(created_at)', [$idSucursal]);
    
        $interes = DB::select('SELECT SUM(intpago) AS interes, YEAR(created_at) AS created_at
                                FROM pago
                                WHERE sede_id = ?
                                GROUP BY YEAR(created_at)', [$idSucursal]);
    
        $mora = DB::select('SELECT SUM(mora) AS mora, YEAR(created_at) AS created_at
                            FROM pago
                            WHERE sede_id = ?
                            GROUP BY YEAR(created_at)', [$idSucursal]);
    
        $venta = DB::select('SELECT SUM(m.importe - m.monto) AS venta, YEAR(m.created_at) AS fecVenta
                              FROM movimiento m, caja c
                              WHERE m.caja_id = c.id AND c.sede_id = ?
                              GROUP BY YEAR(m.created_at)', [$idSucursal]);
    
        $gastoAdmin = DB::select('SELECT SUM(m.monto) AS gasto, YEAR(m.created_at) AS created_at 
                                   FROM movimiento m, caja c
                                   WHERE m.caja_id = c.id AND c.sede_id = ?
                                   GROUP BY YEAR(m.created_at)', [$idSucursal]);
    
        $balancePrestamo = DB::select('SELECT COUNT(*) as cant, YEAR(created_at) AS created_at 
                                        FROM prestamo 
                                        WHERE codigo = "N" AND estado = "ACTIVO DESEMBOLSADO" AND sede_id = ?
                                        GROUP BY YEAR(created_at)', [$idSucursal]);
    
        $balanceRenovacion = DB::select('SELECT COUNT(*) as cant, YEAR(created_at) AS created_at 
                                          FROM prestamo 
                                          WHERE codigo = "R" AND estado = "ACTIVO DESEMBOLSADO" AND sede_id = ?
                                          GROUP BY YEAR(created_at)', [$idSucursal]);
    
        foreach ($prestamos as $pr) {
            $registros[$pr->anio] = $pr->cant;
        }
    
        foreach ($efectivo as $e) {
            $registroEfectivo[$e->fec] = $e->monto;
        }
    
        foreach ($interes as $i) {
            $registroInteres[$i->created_at] = $i->interes;
        }
    
        foreach ($mora as $m) {
            $registroMora[$m->created_at] = $m->mora;
        }
    
        foreach ($venta as $v) {
            $registroVenta[$v->fecVenta] = $v->venta;
        }
    
        foreach ($gastoAdmin as $ga) {
            $registroGastosAdministrativos[$ga->created_at] = $ga->gasto;
        }
    
        foreach ($balancePrestamo as $bp) {
            $registrosBalancePrestamo[$bp->created_at] = $bp->cant;
        }
    
        foreach ($balanceRenovacion as $br) {
            $registrosBalanceRenovacion[$br->created_at] = $br->cant;
        }
    
        return view('finanza.estprestamo', compact(
            'usuario',
            'anio',
            'estado',
            'registros',
            'registroEfectivo',
            'registroInteres',
            'registroMora',
            'registroVenta',
            'registroGastosAdministrativos',
            'registrosBalancePrestamo',
            'registrosBalanceRenovacion'
        ));
    }


    public function gastos()
    {
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;
        
        $user = Auth::user();
        $usuario = DB::SELECT('SELECT e.nombre, e.apellido, e.id, u.name AS area, e.foto AS foto, e.sede_id AS sede
                                FROM empleado e, users u 
                                WHERE e.users_id = u.id AND u.id = "'.$user->id.'"');

        $cajaChica = DB::SELECT('SELECT m.* 
                                  FROM movimiento m, caja c, tipocaja tc
                                  WHERE m.caja_id = c.id AND tc.id = c.tipocaja_id AND tc.codigo = "cc" AND MONTH(NOW()) = MONTH(m.created_at) AND c.sede_id = "'.$idSucursal.'" AND m.tipo = "EGRESO" AND m.codigo = "o"');

        $cajaGrande = DB::SELECT('SELECT m.*
                                    FROM movimiento m
                                    INNER JOIN caja c ON m.caja_id = c.id
                                    WHERE MONTH(NOW()) = MONTH(m.created_at) AND m.tipo = "EGRESO" AND m.codigo = "GA" AND c.sede_id = "2" AND c.tipocaja_id = '.$idSucursal.' AND m.tipo = "EGRESO";');

        $historialCajaGrande = DB::SELECT('SELECT SUM(m.monto) AS monto, MONTH(m.created_at) AS mes
                                            FROM movimiento m, caja c
                                            WHERE m.caja_id = c.id AND c.sede_id = "'.$idSucursal.'" AND m.codigo = "GA" AND YEAR(m.created_at) = YEAR(NOW())
                                            GROUP BY MONTH(m.created_at)');
                                            
        $historialAnualCajaGrande = DB::SELECT('SELECT SUM(m.monto) AS monto, YEAR(m.created_at) AS anio FROM movimiento m, caja c WHERE m.caja_id = c.id AND c.sede_id = "'.$idSucursal.'" AND m.codigo = "GA" GROUP BY YEAR(m.created_at)');

        $historialCajaChica = DB::SELECT('SELECT SUM(m.monto) AS monto, MONTH(m.created_at) AS mes
                                           FROM movimiento m, caja c
                                           WHERE m.caja_id = c.id AND c.sede_id = "'.$idSucursal.'" AND m.codigo = "o" AND YEAR(m.created_at) = YEAR(NOW())
                                           GROUP BY MONTH(m.created_at)');
                                           
        $historialAnualCajaChica = DB::SELECT('SELECT SUM(m.monto) AS monto, YEAR(m.created_at) AS anio FROM movimiento m, caja c WHERE m.caja_id = c.id AND c.sede_id = "'.$idSucursal.'" AND m.codigo = "o" GROUP BY YEAR(m.created_at)');
                                           
        $listaBancos = DB::SELECT('SELECT 
                                        c.id AS caja_id, c.estado AS estado, c.monto AS monto, c.fecha AS fecha, c.inicio AS inicio, c.fin AS fin, c.montofin AS montofin, c.empleado AS empleado_id, c.sede_id AS sede_id, 
                                        tc.id AS banco_id, tc.tipo AS tipo, tc.codigo AS codigo, tc.detalle AS detalle, tc.categoria AS categoria 
                                    FROM caja c 
                                    RIGHT JOIN tipocaja tc ON c.tipocaja_id = tc.id 
                                    WHERE c.estado = "abierta" AND tc.categoria = "banco" AND c.sede_id = "'.$idSucursal.'"');
        
        $historialBanco = Movimiento::select('movimiento.*')
                                    ->join('movimiento_documento as md', 'movimiento.id', '=', 'md.movimiento_id')
                                    ->join('documento as d', 'md.documento_id', '=', 'd.id')
                                    ->join('caja as c', 'movimiento.caja_id', '=', 'c.id')
                                    ->join('tipocaja as tc', 'c.tipocaja_id', '=', 'tc.id')
                                    ->where('tc.categoria', 'banco')
                                    ->where('c.sede_id', $idSucursal)
                                    ->where('movimiento.tipo', 'EGRESO')
                                    ->whereMonth('movimiento.created_at', now()->month)
                                    ->whereYear('movimiento.created_at', now()->year)
                                    ->get();
                                
        $montosBanco = MovimientoDocumento::selectRaw('SUM(m.monto) as monto, MONTH(m.created_at) as mes')
                                            ->join('movimiento as m', 'movimiento_documento.movimiento_id', '=', 'm.id')
                                            ->join('caja as c', 'm.caja_id', '=', 'c.id')
                                            ->join('tipocaja as tc', 'c.tipocaja_id', '=', 'tc.id')
                                            ->where('c.sede_id', $idSucursal)
                                            ->whereRaw('m.created_at >= DATE_FORMAT(NOW(), "%Y-01-01")')
                                            ->whereRaw('m.created_at <= NOW()')
                                            ->where('tc.categoria', 'banco')
                                            ->groupBy(DB::raw('MONTH(m.created_at)'))
                                            ->get();
                                        
        $historialAnualBanco = Movimiento::selectRaw('SUM(movimiento.monto) as monto, YEAR(movimiento.created_at) as anio')
                                ->join('caja as c', 'movimiento.caja_id', '=', 'c.id')
                                ->join('tipocaja as tc', 'c.tipocaja_id', '=', 'tc.id')
                                ->where('c.sede_id', $idSucursal)
                                ->where('tc.categoria', 'banco')
                                ->groupBy(DB::raw('YEAR(movimiento.created_at)'))
                                ->get();
                                
        $historialAnualBanco = MovimientoDocumento::selectRaw('SUM(m.monto) as monto, YEAR(m.created_at) as anio')
                                ->join('movimiento as m', 'movimiento_documento.movimiento_id', '=', 'm.id')
                                ->join('caja as c', 'm.caja_id', '=', 'c.id')
                                ->join('tipocaja as tc', 'c.tipocaja_id', '=', 'tc.id')
                                ->where('c.sede_id', $idSucursal)
                                ->where('tc.categoria', 'banco')
                                ->groupBy(DB::raw('YEAR(m.created_at)'))
                                ->get();


        for($m=1; $m<=12; $m++){
            $montoCaja[$m]=0;
            $montoCajaGrande[$m]=0;  
            $montoBanco[$m]=0;  
        }

        foreach ($historialCajaChica as $hcc) {
            $messel = intval($hcc->mes);
            $montoCaja[$messel++] = $hcc->monto;
        }
        

        foreach ($historialCajaGrande as $hcg) {
            $messel = intval($hcg->mes);
            $montoCajaGrande[$messel++] = $hcg->monto;
        }
        
        foreach ($montosBanco as $hb) {
            $messel = intval($hb->mes);
            $montoBanco[$messel++] = $hb->monto;
        }

        return view('finanza.gastos', compact('usuario', 'cajaChica', 'cajaGrande', 'historialCajaChica', 'montoCaja', 'montoCajaGrande', 'listaBancos', 'historialBanco', 'historialAnualCajaGrande', 'historialAnualCajaChica', 'historialAnualBanco', 'montoBanco'));
    }

    public function verHisrialGastosDia(Request $request)
    {
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;
        
        $mes = $request->mes;
        $user = Auth::user();
        $usuario = DB::SELECT('SELECT e.nombre, e.apellido, e.id, u.name AS area, e.foto AS foto, e.sede_id AS sede
                                FROM empleado e, users u 
                                WHERE e.users_id = u.id AND u.id = "'.$user->id.'"');

        $cajaChica = DB::SELECT('SELECT m.* 
                                  FROM movimiento m, caja c, tipocaja tc
                                  WHERE m.caja_id = c.id AND tc.id = c.tipocaja_id AND tc.codigo = "cc" AND CONCAT(YEAR(m.created_at), "-", MONTH(m.created_at))  = CONCAT(YEAR(NOW()), "-", '.$mes.') AND c.sede_id = "'.$idSucursal.'" AND m.tipo = "EGRESO" AND m.codigo = "o"');

        return response()->json(["view"=>view('finanza.tabHistorialGastosCC',compact('cajaChica'))->render()]);

    }

    public function verHistorialGastosCGDia(Request $request)
    {
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;
        
        $mes = $request->mes;
        $user = Auth::user();
        $usuario = DB::SELECT('SELECT e.nombre, e.apellido, e.id, u.name AS area, e.foto AS foto, e.sede_id AS sede
                                FROM empleado e, users u 
                                WHERE e.users_id = u.id AND u.id = "'.$user->id.'"');

        $cajaGrande = DB::SELECT('SELECT m.*, d.url AS documento 
                                   FROM movimiento m, movimiento_documento md, documento d, caja c
                                   WHERE md.movimiento_id = m.id AND md.documento_id = d.id AND m.caja_id = c.id AND c.sede_id = "'.$idSucursal.'" AND codigo = "GA" AND CONCAT(YEAR(NOW()), "-", '.$mes.') = CONCAT(YEAR(m.created_at), "-", MONTH(m.created_at))');

        return response()->json(["view"=>view('finanza.tabHistorialGastosCG',compact('cajaGrande'))->render()]);
    }

    public function historialCajaGrande(Request $request)
    {
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;
        
        $anio = $request->anio;

        $primer_dia=1;

        $fecha_inicial=date("Y-m-d H:i:s", strtotime($anio."-01-01") );
        $fecha_final=date("Y-m-d H:i:s", strtotime($anio."-12-31") );

        $gastoAdmin = DB::SELECT('SELECT SUM(m.monto) AS gasto, DATE(m.created_at) AS created_at 
                              FROM movimiento m, caja c
                              WHERE m.caja_id = c.id AND c.sede_id = "'.$idSucursal.'" AS m.codigo = "GA" AND (m.created_at BETWEEN "'.$fecha_inicial.'" AND "'.$fecha_final.'")
                              GROUP BY MONTH(m.created_at)');

        $pt = count($gastoAdmin);

        for($m=1; $m<=12; $m++){
            $registros[$m]=0;
            $gastosAdministrativos[$m]=0;      
        }

        foreach($gastoAdmin as $ga){
            $messel = intval(date("m",strtotime($ga->created_at) ) );
            $registros[$messel]++;
            $gastosAdministrativos[$messel++] = $ga->gasto;
  
        }

        $data = array("registrosmes"=>$registros, "administrativo" => $gastosAdministrativos);

        return json_encode($data);
    }

    public function editarInventario(Request $request){

        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $id = $request->id;
        $unidad = $request->unidad;
        $nombre = $request->nombre;
        $marca = $request->marca;
        $valor = $request->valor;
        
        $in = Inventario::where('id', '=', $id)->first(); 
        $in->unidad = $unidad;
        $in->nombre = $nombre;
        $in->valor = $valor;
        $in->marca = $marca;
        if ($in->save()) {
            $resp = "1";

            $equipo = Inventario::where('tipoinventario_id', '1')
                            ->where('estado', 'ACTIVO')
                            ->where('sede_id', $idSucursal)
                            ->get();
    
            $tipoinventario = TipoInventario::all();
    
    
            $totalInventario = Inventario::where('tipoinventario_id', 1)
                                ->where('estado', 'ACTIVO')
                                ->where('sede_id', $idSucursal)
                                ->selectRaw('ROUND(SUM(unidad * valor), 2) AS total')
                                ->first();
                                
            $totalInventario->total = round($totalInventario->total, 2);
        }

        return response()->json(["view"=>view('finanza.tabMueble',compact('equipo', 'totalInventario'))->render(), "viewTi"=>view('finanza.activosMueble',compact('totalInventario'))->render(), 'resp'=>$resp]);

    }

    public function eliminarInventario(Request $request)
    {
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $id = $request->id;
        $unidad = $request->unidad;
        $valor = $request->valor;
        $resp = "0";
        
        $in = Inventario::find($id); 
        if ($in->delete()) {
            $resp = "1";

            $equipo = Inventario::where('tipoinventario_id', '1')
                            ->where('estado', 'ACTIVO')
                            ->where('sede_id', $idSucursal)
                            ->get();
    
            $tipoinventario = Tipoinventario::all();
    
    
            $totalInventario = Inventario::where('tipoinventario_id', 1)
                                ->where('estado', 'ACTIVO')
                                ->where('sede_id', $idSucursal)
                                ->selectRaw('ROUND(SUM(unidad * valor), 2) AS total')
                                ->first();
                                
            $totalInventario->total = round($totalInventario->total, 2);
        }

        return response()->json(["view"=>view('finanza.tabMueble',compact('equipo', 'totalInventario'))->render(), "viewTi"=>view('finanza.activosMueble',compact('totalInventario'))->render(), 'resp'=>$resp]);
    }

    public function patrimonio()    
    {
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;
        
        $prestamoColocado = $this->getPrestamosColocadosUseCase->execute($idSucursal);
        
        $liquidacion = $this->getMontoLiquidacionUseCase->execute($idSucursal);
        
        $inventario = $this->getMontoInventarioUseCase->execute($idSucursal);
                       
        $dataCajaChica = [
                'estadoCaja' => "abierta",
                'tipoCaja' => "caja chica",
                'idSucursal' => $idSucursal
            ];
            
        $dataCajaGrande = [
            'estadoCaja' => "abierta",
            'tipoCaja' => "Caja Grande",
            'idSucursal' => $idSucursal
        ];
        
        $dataBanco = [
            'estadoCaja' => "abierta",
            'idSucursal' => $idSucursal
        ];
        
        $cajaGrande = $this->getCajaByTipoUseCase->execute($dataCajaGrande);
        
        $montoCajaGrande = str_replace(',', '', $cajaGrande->monto);
        $montoCajaGrande = (float) $montoCajaGrande;
                    
        $cajaChica = $this->getCajaByTipoUseCase->execute($dataCajaChica);
        
        $montoCajaChica = str_replace(',', '', $cajaChica->monto);
        $montoCajaChica = (float) $montoCajaChica;
        
        $cajaBancos = $this->getBancoUseCase->execute($dataBanco);
        
        $dataPatrimonioNeto = [
                'idSucursal' => $idSucursal,
                'montoPrestamosColocados' => $prestamoColocado,
                'montoLiquidacion' => $liquidacion,
                'montoCajaChica' => $montoCajaChica,
                'montoInventario' => $inventario,
                'montoCajaGrande' => $montoCajaGrande,
                'montoBanco' => $cajaBancos->sum('caja_monto')
        ];
        
        $patrimonioNeto = $this->getPatrimonioNetoCase->execute($dataPatrimonioNeto);
        
        $patrimonioNeto = number_format($patrimonioNeto, 2);
        
        $precActivo = str_replace(',', '', $patrimonioNeto);
        $precActivo = (float) $precActivo;
        $precActivo = ROUND($precActivo/100, 2);

        $equipo = Inventario::where('tipoinventario_id', '1')
                            ->where('estado', 'ACTIVO')
                            ->where('sede_id', $idSucursal)
                            ->get();


        $software = Inventario::where('tipoinventario_id', '2')
                              ->where('estado', 'ACTIVO')
                              ->where('sede_id', $idSucursal)
                              ->where('marca', "SOFTWARE")
                              ->get();

        $tipoinventario = Tipoinventario::all();


        $totalInventario = Inventario::where('tipoinventario_id', 1)
                            ->where('estado', 'ACTIVO')
                            ->where('sede_id', $idSucursal)
                            ->selectRaw('ROUND(SUM(unidad * valor), 2) AS total')
                            ->first();
                            
        $totalInventario->total = round($totalInventario->total, 2);
    
        $sumaBancos = $cajaBancos->sum('caja_monto');
        
        $listPatrimonioNeto = $this->getListPatrimonioNetoUseCase->execute($idSucursal);
        
        $dataPatrimonioNetoMes = [
                'idSucursal' => $idSucursal,
                'anio' => 2023
        ];
        
        $listPatrimonioNetoMes = $this->getListPatrimonioNetoMesUseCase->execute($dataPatrimonioNetoMes);
        
        $listaPatrimonioMes = DB::SELECT('SELECT meses.mes, COALESCE(MAX(cp.monto), 0) AS monto_mayor
                                        FROM (
                                            SELECT 1 AS numero_mes, "Enero" AS mes
                                            UNION SELECT 2, "Febrero"
                                            UNION SELECT 3, "Marzo"
                                            UNION SELECT 4, "Abril"
                                            UNION SELECT 5, "Mayo"
                                            UNION SELECT 6, "Junio"
                                            UNION SELECT 7, "Julio"
                                            UNION SELECT 8, "Agosto"
                                            UNION SELECT 9, "Septiembre"
                                            UNION SELECT 10, "Octubre"
                                            UNION SELECT 11, "Noviembre"
                                            UNION SELECT 12, "Diciembre"
                                        ) AS meses
                                        LEFT JOIN control_patrimonial AS cp
                                        ON meses.numero_mes = cp.numbermes AND cp.anio = YEAR(CURRENT_DATE())
                                        GROUP BY meses.mes
                                        ORDER BY meses.numero_mes');

        return view('finanza.patrimonio', compact('prestamoColocado', 'liquidacion', 'cajaChica', 'equipo', 'software', 'tipoinventario', 'totalInventario', 'cajaGrande', 'patrimonioNeto', 'sumaBancos', 'precActivo', 'listPatrimonioNeto', 'listPatrimonioNetoMes', 'listaPatrimonioMes'));
    } 
    
    public function getListaMesPatrimonio(Request $request) {
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $dataPatrimonioNetoMes = [
                'idSucursal' => $idSucursal,
                'anio' => $request->anio
        ];
        
        $listPatrimonioNetoMes = $this->getListPatrimonioNetoMesUseCase->execute($dataPatrimonioNetoMes);
        return response()->json(["view"=>view('finanza.tabListMesPatrimonioNeto', compact('listPatrimonioNetoMes'))->render()]);
    }

    public function verHistorialPat(Request $request){
        $anio = $request->anio;
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;

        $histMes = DB::SELECT('SELECT SUM(monto) AS monto, mes
                                    FROM (
                                        SELECT IF(SUM(monto) IS NULL, 0.00, SUM(monto)) AS monto, MONTH(fecha) AS mes
                                        FROM caja 
                                        WHERE sede_id = "'.$idSucursal.'" AND id = (SELECT MAX(id) FROM caja WHERE tipocaja_id = "1")
                                            OR tipocaja_id = "2"
                                            OR tipocaja_id = "3"
                                            OR tipocaja_id = "4"
                                            OR tipocaja_id = "5"
                                        AND YEAR(fecha) = '.$anio.'
                                        GROUP BY MONTH(fecha)
                                        UNION                                
                                        SELECT IF(SUM(unidad*valor) IS NULL, 0.00, SUM(unidad*valor))  AS monto, MONTH(updated_at) AS mes 
                                        FROM inventario 
                                        WHERE YEAR(updated_at) = '.$anio.'
                                        GROUP BY MONTH(updated_at)
                                        UNION
                                        SELECT IF(SUM(monto) IS NULL, 0.00, SUM(monto)) AS monto, MONTH(updated_at) AS mes
                                        FROM prestamo
                                        WHERE sede_id = "'.$idSucursal.'" AND estado = "ACTIVO DESEMBOLSADO" OR estado = "LIQUIDACION" AND YEAR(updated_at) = '.$anio.'
                                        GROUP BY MONTH(updated_at)
                                    ) f
                                    GROUP BY mes
                                    ORDER BY mes ASC');

            for ($m=1; $m <= 12; $m++) { 
                $nomMes[$m] = 0;
                $montoMes[$m] = 0;
            }

            foreach($histMes as $hm){
                $messel = intval($hm->mes);
                $montoMes[$messel++] = $hm->monto;
      
            }

            return response()->json(["view"=>view('finanza.tbHistPat', compact('histMes', 'montoMes'))->render()]);

    }

    public function getUltimoDiaMes($elAnio,$elMes) {
        return date("d",(mktime(0,0,0,$elMes+1,1,$elAnio)-1));
    }

    public function graficoLineaPrestamo(Request $request)
    {
        $anio = $request->anio;
        $mes = $request->mes;
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;

        $primer_dia=1;
        $ultimo_dia=$this->getUltimoDiaMes($anio,$mes);
        $fecha_inicial=date("Y-m-d H:i:s", strtotime($anio."-".$mes."-".$primer_dia) );
        $fecha_final=date("Y-m-d H:i:s", strtotime($anio."-".$mes."-".$ultimo_dia) );

        $prestamos = DB::SELECT('SELECT * 
                                  FROM prestamo 
                                  WHERE sede_id = "'.$idSucursal.'" AND fecinicio BETWEEN "'.$fecha_inicial.'" AND "'.$fecha_final.'"');
           
        $pt = count($prestamos);

        for($d=1;$d<=$ultimo_dia;$d++){
            $registros[$d]=0;      
        }

        foreach($prestamos as $pts){
            $diasel = intval(date("d",strtotime($pts->fecinicio) ) );
            $registros[$diasel]++;    
        }

        $data = array("totaldias"=>$ultimo_dia, "registrosdia" =>$registros);

        return json_encode($data);
    }

    public function graficoPatrimonio(Request $request)
    {
        $anio = $request->anio;
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;

        $fecha_inicial = date("Y-m-d H:i:s", strtotime($anio."-01-01") );
        $fecha_final = date("Y-m-d H:i:s", strtotime($anio."-12-31") );

        $caja = DB::SELECT('SELECT SUM(monto) AS monto, YEAR(updated_at) AS anio
                             FROM caja 
                             WHERE sede_id = "'.$idSucursal.'" AND id = (SELECT MAX(id) FROM caja WHERE tipocaja_id = "1") AND tipocaja_id = "1" 
                                OR tipocaja_id = "2"
                                OR tipocaja_id = "3"
                                OR tipocaja_id = "4"
                                OR tipocaja_id = "5"
                                GROUP BY YEAR(updated_at)');

        $inventario = DB::SELECT('SELECT SUM(unidad*valor) AS monto, YEAR(updated_at) AS anio FROM inventario GROUP BY YEAR(updated_at)');

        $prestamo = DB::SELECT('SELECT SUM(monto) AS monto, YEAR(updated_at) AS anio
                                 FROM prestamo
                                 WHERE sede_id = "'.$idSucursal.'" AND estado = "ACTIVO DESEMBOLSADO" OR estado = "LIQUIDACION" GROUP BY YEAR(updated_at)');

        

        for ($i=0; $i < count($inventario) ; $i++) { 
            $monto[$i] = $caja[$i]->monto + $inventario[$i]->monto + $prestamo[$i]->monto;
            $anios[$i] = $caja[$i]->anio;
        }

        return response()->json(["view"=>view('finanza.tbAnual', compact('monto', 'anios'))->render()]);
    }

    public function tabMesPatrimonio(Request $request)
    {
        return response()->json(["view"=>view('finanza.tbAnual')->render()]);
    }

    public function graficoLineaBienesDia(Request $request)
    {

        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;
        $anio = $request->anio;
        $mes = $request->mes;

        $primer_dia=1;
        $ultimo_dia=$this->getUltimoDiaMes($anio,$mes);
        $fecha_inicial=date("Y-m-d H:i:s", strtotime($anio."-".$mes."-".$primer_dia) );
        $fecha_final=date("Y-m-d H:i:s", strtotime($anio."-".$mes."-".$ultimo_dia) );

        $prestamos = DB::SELECT('SELECT * 
                                  FROM prestamo 
                                  WHERE sede_id = "'.$idSucursal.'" AND fecinicio BETWEEN "'.$fecha_inicial.'" AND "'.$fecha_final.'"');

        $pt = count($prestamos);

        for($d=1;$d<=$ultimo_dia;$d++){
            $registros[$d]=0;      
        }

        foreach($prestamos as $pts){
            $diasel = intval(date("d",strtotime($pts->fecinicio) ) );
            $registros[$diasel]++;    
        }

        $data = array("totaldias"=>$ultimo_dia, "registrosdia" =>$registros);

        return json_encode($data);

    }

    public function graficoLineaLiquidacionDia(Request $request)
    {

        $anio = $request->anio;
        $mes = $request->mes;
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;

        $primer_dia=1;
        $ultimo_dia=$this->getUltimoDiaMes($anio,$mes);
        $fecha_inicial=date("Y-m-d H:i:s", strtotime($anio."-".$mes."-".$primer_dia) );
        $fecha_final=date("Y-m-d H:i:s", strtotime($anio."-".$mes."-".$ultimo_dia) );

        $liquidacion = DB::SELECT('SELECT * 
                                    FROM prestamo 
                                    WHERE sede_id = "'.$idSucursal.'" AND estado = "LIQUIDACION" AND fecinicio BETWEEN "'.$fecha_inicial.'" AND "'.$fecha_final.'"');

        $pt = count($liquidacion);

        for($d=1;$d<=$ultimo_dia;$d++){
            $registros[$d]=0;      
        }

        foreach($liquidacion as $lq){
            $diasel = intval(date("d",strtotime($lq->fecinicio) ) );
            $registros[$diasel]++;    
        }

        $data = array("totaldias"=>$ultimo_dia, "registrosdia" =>$registros);

        return json_encode($data);
        
    }

    public function graficoLineaVendidoDia(Request $request)
    {

        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;
        $anio = $request->anio;
        $mes = $request->mes;

        $primer_dia=1;
        $ultimo_dia=$this->getUltimoDiaMes($anio,$mes);
        $fecha_inicial=date("Y-m-d H:i:s", strtotime($anio."-".$mes."-".$primer_dia) );
        $fecha_final=date("Y-m-d H:i:s", strtotime($anio."-".$mes."-".$ultimo_dia) );

        $vendido = DB::SELECT('SELECT * 
                                FROM prestamo 
                                WHERE sede_id = "'.$idSucursal.'" AND estado = "VENDIDO" AND fecinicio BETWEEN "'.$fecha_inicial.'" AND "'.$fecha_final.'"');

        $pt = count($vendido);

        for($d=1;$d<=$ultimo_dia;$d++){
            $registros[$d]=0;      
        }

        foreach($vendido as $v){
            $diasel = intval(date("d",strtotime($v->fecinicio) ) );
            $registros[$diasel]++;    
        }

        $data = array("totaldias"=>$ultimo_dia, "registrosdia" =>$registros);

        return json_encode($data);
        
    }

    public function graficoLineaClienteDia(Request $request)
    {
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;
        $anio = $request->anio;
        $mes = $request->mes;

        $primer_dia=1;
        $ultimo_dia=$this->getUltimoDiaMes($anio,$mes);
        $fecha_inicial=date("Y-m-d H:i:s", strtotime($anio."-".$mes."-".$primer_dia) );
        $fecha_final=date("Y-m-d H:i:s", strtotime($anio."-".$mes."-".$ultimo_dia) );

        $cliente = DB::SELECT('SELECT * 
                                FROM cliente 
                                WHERE sede_id = "'.$idSucursal.'" AND created_at BETWEEN "'.$fecha_inicial.'" AND "'.$fecha_final.'"');

        $pt = count($cliente);

        for($d=1;$d<=$ultimo_dia;$d++){
            $registros[$d]=0;      
        }

        foreach($cliente as $cl){
            $diasel = intval(date("d",strtotime($cl->created_at) ) );
            $registros[$diasel]++;    
        }

        $data = array("totaldias"=>$ultimo_dia, "registrosdia" =>$registros);

        return json_encode($data);
        
    }

    public function graficoLineaEfectivoDia(Request $request)
    {
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;
        $anio = $request->anio;
        $mes = $request->mes;

        $primer_dia=1;
        $ultimo_dia=$this->getUltimoDiaMes($anio,$mes);
        $fecha_inicial=date("Y-m-d H:i:s", strtotime($anio."-".$mes."-".$primer_dia) );
        $fecha_final=date("Y-m-d H:i:s", strtotime($anio."-".$mes."-".$ultimo_dia) );

        $efectivo = DB::SELECT('SELECT SUM(monto) AS monto, DATE(created_at) AS fecinicio
                                 FROM desembolso
                                 WHERE sede_id = "'.$idSucursal.'" AND DATE(created_at) BETWEEN "'.$fecha_inicial.'" AND "'.$fecha_final.'" 
                                 GROUP BY DATE(created_at)');

        $pt = count($efectivo);

        for($d=1;$d<=$ultimo_dia;$d++){
            $registros[$d]=0;
            $monto[$d]=0;      
        }

        foreach($efectivo as $ef){
            $diasel = intval(date("d",strtotime($ef->fecinicio) ) );
            $registros[$diasel]++;
            $monto[$diasel++] = $ef->monto;
  
        }

        $data = array("totaldias"=>$ultimo_dia, "registrosdia"=>$registros, "monto" => $monto);

        return json_encode($data);
        
    }

    public function graficoLineaInteresDia(Request $request)
    {
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;
        $anio = $request->anio;
        $mes = $request->mes;

        $primer_dia=1;
        $ultimo_dia=$this->getUltimoDiaMes($anio,$mes);
        $fecha_inicial=date("Y-m-d H:i:s", strtotime($anio."-".$mes."-".$primer_dia) );
        $fecha_final=date("Y-m-d H:i:s", strtotime($anio."-".$mes."-".$ultimo_dia) );

        $interes = DB::SELECT('SELECT SUM(intpago) AS interes, DATE(created_at) AS created_at
                                FROM pago
                                WHERE sede_id = "'.$idSucursal.'" AND created_at BETWEEN "'.$fecha_inicial.'" AND "'.$fecha_final.'"
                                GROUP BY DATE(created_at)');

        $pt = count($interes);

        for($d=1;$d<=$ultimo_dia;$d++){
            $registros[$d]=0;
            $totalInteres[$d]=0;      
        }

        foreach($interes as $it){
            $diasel = intval(date("d",strtotime($it->created_at) ) );
            $registros[$diasel]++;
            $totalInteres[$diasel++] = $it->interes;
  
        }

        $data = array("totaldias"=>$ultimo_dia, "registrosdia"=>$registros, "interes" => $totalInteres);

        return json_encode($data);
        
    }

    public function graficoLineaMoraDia(Request $request)
    {
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;
        $anio = $request->anio;
        $mes = $request->mes;

        $primer_dia=1;
        $ultimo_dia=$this->getUltimoDiaMes($anio,$mes);
        $fecha_inicial=date("Y-m-d H:i:s", strtotime($anio."-".$mes."-".$primer_dia) );
        $fecha_final=date("Y-m-d H:i:s", strtotime($anio."-".$mes."-".$ultimo_dia) );

        $mora = DB::SELECT('SELECT SUM(mora) AS mora, DATE(created_at) AS created_at
                                FROM pago
                                WHERE sede_id = "'.$idSucursal.'" AND created_at BETWEEN "'.$fecha_inicial.'" AND "'.$fecha_final.'"
                                GROUP BY DATE(created_at)');

        $pt = count($mora);

        for($d=1;$d<=$ultimo_dia;$d++){
            $registros[$d]=0;
            $totalMoras[$d]=0;      
        }

        foreach($mora as $mo){
            $diasel = intval(date("d",strtotime($mo->created_at) ) );
            $registros[$diasel]++;
            $totalMoras[$diasel++] = $mo->mora;
  
        }

        $data = array("totaldias"=>$ultimo_dia, "registrosdia"=>$registros, "mora" => $totalMoras);

        return json_encode($data);
        
    }

    public function graficoLineaVentaDia(Request $request)
    {

        $anio = $request->anio;
        $mes = $request->mes;
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;

        $primer_dia=1;
        $ultimo_dia=$this->getUltimoDiaMes($anio,$mes);
        $fecha_inicial=date("Y-m-d H:i:s", strtotime($anio."-".$mes."-".$primer_dia) );
        $fecha_final=date("Y-m-d H:i:s", strtotime($anio."-".$mes."-".$ultimo_dia) );

        $venta = DB::SELECT('SELECT SUM(m.importe - m.monto) AS venta, date(m.created_at) AS fecVenta
                             FROM movimiento m, caja c
                             WHERE m.caja_id = c.id AND c.sede_id = "'.$idSucursal.'" AND m.codigo = "V" AND m.created_at BETWEEN "'.$fecha_inicial.'" AND "'.$fecha_final.'"
                             GROUP BY DATE(m.created_at)');

        $pt = count($venta);

        for($d=1;$d<=$ultimo_dia;$d++){
            $registros[$d]=0;
            $gananciaVenta[$d]=0;      
        }

        foreach($venta as $ve){
            $diasel = intval(date("d",strtotime($ve->fecVenta) ) );
            $registros[$diasel]++;
            $gananciaVenta[$diasel++] = $ve->venta;
  
        }

        $data = array("totaldias"=>$ultimo_dia, "registrosdia"=>$registros, "venta" => $gananciaVenta);

        return json_encode($data);
        
    }

    public function graficoLineaAdministrativoDia(Request $request)
{
    $anio = $request->anio;
    $mes = $request->mes;
    $Proceso = new proceso();
    $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;

    $primer_dia = 1;
    $ultimo_dia = $this->getUltimoDiaMes($anio, $mes);
    $fecha_inicial = date("Y-m-d H:i:s", strtotime("$anio-$mes-$primer_dia"));
    $fecha_final = date("Y-m-d H:i:s", strtotime("$anio-$mes-$ultimo_dia"));

    $query = "SELECT DATE(movimiento.created_at) AS fecha, SUM(movimiento.monto) AS gasto
              FROM movimiento
              JOIN caja ON movimiento.caja_id = caja.id
              WHERE caja.sede_id = $idSucursal
              AND (
                    (movimiento.codigo = 'GA' AND movimiento.created_at BETWEEN '$fecha_inicial' AND '$fecha_final')
                    OR
                    (movimiento.tipo = 'EGRESO' AND movimiento.codigo = 'o' AND caja.tipocaja_id IN (SELECT id FROM tipocaja WHERE codigo = 'cc') AND movimiento.created_at BETWEEN '$fecha_inicial' AND '$fecha_final')
                    OR
                    (movimiento.tipo = 'EGRESO' AND caja.tipocaja_id IN (SELECT id FROM tipocaja WHERE categoria = 'banco') AND movimiento.created_at BETWEEN '$fecha_inicial' AND '$fecha_final' AND movimiento.concepto NOT LIKE '%DESEMBOLSO%')
                 )
              GROUP BY fecha";

    $gastoAdmin = DB::select($query);

    $registros = array_fill(1, $ultimo_dia, 0);
    $gastoAdministrativo = array_fill(1, $ultimo_dia, 0);

    foreach ($gastoAdmin as $ga) {
        $dia = intval(date('j', strtotime($ga->fecha)));
        $registros[$dia]++;
        $gastoAdministrativo[$dia] = $ga->gasto;
    }

    $data = array("totaldias" => $ultimo_dia, "registrosdia" => $registros, "administrativo" => $gastoAdministrativo);

    return json_encode($data);
}


    public function graficoLineaPrestamoActivoDia(Request $request)
    {

        $anio = $request->anio;
        $mes = $request->mes;
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;

        $primer_dia=1;
        $ultimo_dia=$this->getUltimoDiaMes($anio,$mes);
        $fecha_inicial=date("Y-m-d H:i:s", strtotime($anio."-".$mes."-".$primer_dia) );
        $fecha_final=date("Y-m-d H:i:s", strtotime($anio."-".$mes."-".$ultimo_dia) );

        $prestamo = DB::SELECT('SELECT * 
                                 FROM prestamo 
                                 WHERE sede_id = "'.$idSucursal.'" AND codigo = "N" AND estado = "ACTIVO DESEMBOLSADO" AND (fecinicio BETWEEN "'.$fecha_inicial.'" AND "'.$fecha_final.'")');

        $renovacion = DB::SELECT('SELECT * 
                                   FROM prestamo 
                                   WHERE sede_id = "'.$idSucursal.'" AND codigo = "R" AND estado = "ACTIVO DESEMBOLSADO" AND (fecinicio BETWEEN "'.$fecha_inicial.'" AND "'.$fecha_final.'")');

        $pt = count($prestamo);

        $pt2 = count($renovacion);

        for($d=1;$d<=$ultimo_dia;$d++){
            $registros[$d]=0;
            $registrosPrestamo[$d]=0;      
            $registrosRenovacion[$d]=0;      
        }

        foreach($prestamo as $p){
            $diasel = intval(date("d",strtotime($p->fecinicio) ) );
            $registrosPrestamo[$diasel]++;
        }

        foreach($renovacion as $r){
            $diasel = intval(date("d",strtotime($r->fecinicio) ) );
            $registrosRenovacion[$diasel]++;
            //$gastoAdministrativo[$diasel++] = $ga->gasto;
  
        }

        $data = array("totaldias"=>$ultimo_dia, "registrosPrestamo"=>$registrosPrestamo, "registrosRenovacion" => $registrosRenovacion);

        return json_encode($data);

    }

    public function graficoLineaPrestamoMes(Request $request)
    {
        $anio = $request->anio;
        $fecha_inicial=date("Y-m-d H:i:s", strtotime($anio."-01-01") );
        $fecha_final=date("Y-m-d H:i:s", strtotime($anio."-12-31") );
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;

        $prestamos = DB::SELECT('SELECT * 
                                  FROM prestamo 
                                  WHERE sede_id = "'.$idSucursal.'" AND fecinicio BETWEEN "'.$fecha_inicial.'" AND "'.$fecha_final.'"');

        $pt = count($prestamos);

        for($m=1; $m<=12; $m++){
            $registros[$m]=0;
        }

        foreach($prestamos as $pr){
            $messel = intval(date("m",strtotime($pr->fecinicio) ) );
            $registros[$messel]++;          
  
        }

        $data = array("registrosmes"=>$registros);

        return json_encode($data);
    }

    public function graficoLineaBienesMes(Request $request)
    {
        $anio = $request->anio;

        $fecha_inicial=date("Y-m-d H:i:s", strtotime($anio."-01-01") );
        $fecha_final=date("Y-m-d H:i:s", strtotime($anio."-12-31") );
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;

        $prestamos = DB::SELECT('SELECT * 
                                  FROM prestamo 
                                  WHERE sede_id = "'.$idSucursal.'" AND fecinicio BETWEEN "'.$fecha_inicial.'" AND "'.$fecha_final.'"');

        $pt = count($prestamos);

        for($m=1; $m<=12; $m++){
            $registros[$m]=0;
        }

        foreach($prestamos as $pr){
            $messel = intval(date("m",strtotime($pr->fecinicio) ) );
            $registros[$messel]++;          
  
        }

        $data = array("registrosmes"=>$registros);

        return json_encode($data);
    }

    public function graficoLineaLiquidacionMes(Request $request)
    {
        $anio = $request->anio;

        $fecha_inicial=date("Y-m-d H:i:s", strtotime($anio."-01-01") );
        $fecha_final=date("Y-m-d H:i:s", strtotime($anio."-12-31") );
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;

        $liquidacion = DB::SELECT('SELECT * 
                                    FROM prestamo 
                                    WHERE sede_id = "'.$idSucursal.'" AND estado = "LIQUIDACION" AND fecinicio BETWEEN "'.$fecha_inicial.'" AND "'.$fecha_final.'"');

        $pt = count($liquidacion);

        for($m=1; $m<=12; $m++){
            $registros[$m]=0;      
        }

        foreach($liquidacion as $lq){
            $messel = intval(date("m",strtotime($lq->fecinicio) ) );
            $registros[$messel]++;    
        }

        $data = array("registrosmes" =>$registros);

        return json_encode($data);
    }

    public function graficoLineaVendidoMes(Request $request)
    {
        $anio = $request->anio;
        $fecha_inicial=date("Y-m-d H:i:s", strtotime($anio."-01-01") );
        $fecha_final=date("Y-m-d H:i:s", strtotime($anio."-12-31") );
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;

        $vendido = DB::SELECT('SELECT * 
                                FROM prestamo 
                                WHERE sede_id = "'.$idSucursal.'" AND estado = "VENDIDO" AND fecinicio BETWEEN "'.$fecha_inicial.'" AND "'.$fecha_final.'"');

        $pt = count($vendido);

        for($m=1; $m<=12; $m++){
            $registros[$m]=0;      
        }

        foreach($vendido as $v){
            $messel = intval(date("m",strtotime($v->fecinicio) ) );
            $registros[$messel]++;    
        }

        $data = array("registrosmes" =>$registros);

        return json_encode($data);
    }

    public function graficoLineaClienteMes(Request $request)
    {
        $anio = $request->anio;

        $primer_dia=1;

        $fecha_inicial=date("Y-m-d H:i:s", strtotime($anio."-01-01") );
        $fecha_final=date("Y-m-d H:i:s", strtotime($anio."-12-31") );
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;

        $cliente = DB::SELECT('SELECT * 
                                FROM cliente 
                                WHERE sede_id = "'.$idSucursal.'" AND created_at BETWEEN "'.$fecha_inicial.'" AND "'.$fecha_final.'"');

        $pt = count($cliente);

        for($m=1 ;$m<=12 ;$m++){
            $registros[$m]=0;      
        }

        foreach($cliente as $cl){
            $messel = intval(date("m",strtotime($cl->created_at) ) );
            $registros[$messel]++;    
        }

        $data = array("registrosmes" =>$registros);

        return json_encode($data);
    }

    public function graficoLineaEfectivoMes(Request $request)
    {
        $anio = $request->anio;
        $fecha_inicial=date("Y-m-d H:i:s", strtotime($anio."-01-01") );
        $fecha_final=date("Y-m-d H:i:s", strtotime($anio."-12-31") );
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;

        $efectivo = DB::SELECT('SELECT sum(monto) AS monto, MONTH(created_at) AS fec
                                 FROM prestamo 
                                 WHERE sede_id = "'.$idSucursal.'" AND DATE(created_at) BETWEEN "'.$fecha_inicial.'" AND "'.$fecha_final.'" 
                                 GROUP BY MONTH(created_at)');

        $pt = count($efectivo);

        for($m=1; $m<=12 ;$m++){
            $registros[$m]=0;
            $monto[$m]=0;      
        }

        foreach($efectivo as $ef){
            $messel = intval($ef->fec);
            $registros[$messel]++;
            $monto[$messel++] = $ef->monto;
  
        }

        

        $data = array("registrosmes"=>$registros, "monto" => $monto);

        return json_encode($data);
    }

    public function graficoLineaInteresMes(Request $request)
    {
        $anio = $request->anio;
        $fecha_inicial=date("Y-m-d H:i:s", strtotime($anio."-01-01") );
        $fecha_final=date("Y-m-d H:i:s", strtotime($anio."-12-31") );
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;

        $interes = DB::SELECT('SELECT SUM(intpago) AS interes, MONTH(created_at) AS created_at
                                FROM pago
                                WHERE sede_id = "'.$idSucursal.'" AND created_at BETWEEN "'.$fecha_inicial.'" AND "'.$fecha_final.'"
                                GROUP BY MONTH(created_at)');

        $pt = count($interes);

        for($m=1; $m<=12; $m++){
            $registros[$m]=0;
            $totalInteres[$m]=0;      
        }

        foreach($interes as $it){
            $messel = intval(date($it->created_at) );
            $registros[$messel]++;
            $totalInteres[$messel++] = $it->interes;
  
        }

        $data = array("registrosmes"=>$registros, "interes" => $totalInteres);

        return json_encode($data);
    }

    public function graficoLineaMoraMes(Request $request)
    {
        $anio = $request->anio;
        $fecha_inicial=date("Y-m-d H:i:s", strtotime($anio."-01-01") );
        $fecha_final=date("Y-m-d H:i:s", strtotime($anio."-12-31") );
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;

        $mora = DB::SELECT('SELECT SUM(mora) AS mora, MONTH(created_at) AS created_at
                                FROM pago
                                WHERE sede_id = "'.$idSucursal.'" AND created_at BETWEEN "'.$fecha_inicial.'" AND "'.$fecha_final.'"
                                GROUP BY MONTH(created_at)');

        $pt = count($mora);

        for($m=1; $m<=12; $m++){
            $registros[$m]=0;
            $totalMoras[$m]=0;      
        }

        foreach($mora as $mo){
            $messel = intval($mo->created_at);
            $registros[$messel]++;
            $totalMoras[$messel++] = $mo->mora;
  
        }

        $data = array("registrosmes"=>$registros, "mora" => $totalMoras);

        return json_encode($data);
    }

    public function graficoLineaVentaMes(Request $request)
    {
        $anio = $request->anio;

        $primer_dia=1;

        $fecha_inicial=date("Y-m-d H:i:s", strtotime($anio."-01-01") );
        $fecha_final=date("Y-m-d H:i:s", strtotime($anio."-12-31") );
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;

        $venta = DB::SELECT('SELECT SUM(m.importe - m.monto) AS venta, MONTH(m.created_at) AS fecVenta
                             FROM movimiento m, caja c
                             WHERE m.caja_id = c.id AND c.sede_id = "'.$idSucursal.'" AND m.codigo = "V" AND m.created_at BETWEEN "'.$fecha_inicial.'" AND "'.$fecha_final.'"
                             GROUP BY MONTH(m.created_at)');

        $pt = count($venta);

        for($m=1; $m<=12; $m++){
            $registros[$m]=0;
            $gananciaVenta[$m]=0;      
        }

        foreach($venta as $ve){
            $messel = intval($ve->fecVenta);
            $registros[$messel]++;
            $gananciaVenta[$messel++] = $ve->venta;
  
        }

        $data = array("registrosmes"=>$registros, "venta" => $gananciaVenta);

        return json_encode($data);
    }

    public function graficoLineaAdministrativoMes(Request $request)
    {
        $anio = $request->anio;
        $fecha_inicial = date("Y-m-d", strtotime($anio."-01-01"));
        $fecha_final = date("Y-m-d", strtotime($anio."-12-31"));
        
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        
        $gastoAdmin = DB::SELECT('SELECT mes, SUM(monto) AS gasto
                                     FROM (
                                        SELECT SUM(movimiento.monto) AS monto, 
                                               MONTH(movimiento.created_at) AS mes
                                        FROM movimiento
                                        JOIN caja ON movimiento.caja_id = caja.id
                                        WHERE caja.sede_id = '.$idSucursal.'
                                        AND movimiento.codigo = "GA"
                                        AND movimiento.created_at BETWEEN "'.$fecha_inicial.'" AND "'.$fecha_final.'"
                                        GROUP BY mes
                                    
                                        UNION ALL
                                    
                                        SELECT SUM(m.monto) AS monto, MONTH(m.created_at) AS mes
                                        FROM movimiento m, caja c, tipocaja tc
                                        WHERE m.caja_id = c.id AND c.tipocaja_id = tc.id AND tc.codigo = "cc" AND c.sede_id = "'.$idSucursal.'" AND m.created_at BETWEEN "'.$fecha_inicial.'" AND "'.$fecha_final.'" AND m.tipo = "EGRESO" AND m.codigo = "o"
                                        GROUP BY mes
                                    
                                        UNION ALL
                                    
                                        SELECT SUM(m.monto) AS monto, MONTH(m.created_at) AS mes
                                        FROM movimiento m, caja c, tipocaja tc 
                                        WHERE m.caja_id = c.id AND c.tipocaja_id = tc.id AND tc.categoria = "banco" AND c.sede_id = "'.$idSucursal.'" AND m.created_at BETWEEN "'.$fecha_inicial.'" AND "'.$fecha_final.'" AND m.tipo = "EGRESO" AND concepto NOT LIKE "%DESEMBOLSO%"
                                        GROUP BY mes
                                     ) AS subquery
                                     GROUP BY mes;');
// dd($gastoAdmin);

    
        $registros = array_fill(1, 12, 0);
        $gastosAdministrativos = array_fill(1, 12, 0);
    
        foreach ($gastoAdmin as $ga) {
            $mes = $ga->mes;
            $registros[$mes]++;
            $gastosAdministrativos[$mes] = $ga->gasto;
        }
    
        $data = array("registrosmes" => array_values($registros), "administrativo" => array_values($gastosAdministrativos));
    
        return json_encode($data);
    }


    public function graficoLineaPrestamoActivoMes(Request $request)
    {
        $anio = $request->anio;

        $primer_dia=1;

        $fecha_inicial=date("Y-m-d H:i:s", strtotime($anio."-01-01") );
        $fecha_final=date("Y-m-d H:i:s", strtotime($anio."-12-31") );
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;

        $prestamo = DB::SELECT('SELECT * 
                                 FROM prestamo 
                                 WHERE sede_id = "'.$idSucursal.'" AND codigo = "N" AND estado = "ACTIVO DESEMBOLSADO" AND (fecinicio BETWEEN "'.$fecha_inicial.'" AND "'.$fecha_final.'")');

        $renovacion = DB::SELECT('SELECT * 
                                   FROM prestamo 
                                   WHERE sede_id = "'.$idSucursal.'" AND codigo = "R" AND estado = "ACTIVO DESEMBOLSADO" AND (fecinicio BETWEEN "'.$fecha_inicial.'" AND "'.$fecha_final.'")');

        $pt = count($prestamo);

        $pt2 = count($renovacion);

        for($m=1; $m<=12; $m++){
            $registros[$m]=0;
            $registrosPrestamo[$m]=0;
            $registrosRenovacion[$m]=0;
        }

        foreach($prestamo as $p){
            $messel = intval(date("m",strtotime($p->fecinicio) ) );
            $registrosPrestamo[$messel]++;
        }

        foreach($renovacion as $r){
            $messel = intval(date("m",strtotime($r->fecinicio) ) );
            $registrosRenovacion[$messel]++;
        }

        $data = array("registrosmes"=>$registros, "prestamo" => $registrosPrestamo, "renovacion" => $registrosRenovacion);

        return json_encode($data);
    }

    public function graficoLineaPrestamoEstado(Request $request)
    {
        $anio = $request->anio;
        $mes = $request->mes;
        $estado = $request->estado;

        $primer_dia=1;
        $ultimo_dia=$this->getUltimoDiaMes($anio,$mes);
        $fecha_inicial=date("Y-m-d H:i:s", strtotime($anio."-".$mes."-".$primer_dia) );
        $fecha_final=date("Y-m-d H:i:s", strtotime($anio."-".$mes."-".$ultimo_dia) );
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;

        $prestamos = DB::SELECT('SELECT * 
                                  FROM prestamo 
                                  WHERE sede_id = "'.$idSucursal.'" AND estado = "'.$estado.'" AND fecinicio BETWEEN "'.$fecha_inicial.'" AND "'.$fecha_final.'"');
           
        $pt = count($prestamos);

        for($d=1;$d<=$ultimo_dia;$d++){
            $registros[$d]=0;     
        }

        foreach($prestamos as $pts){
            $diasel = intval(date("d",strtotime($pts->fecinicio) ) );
            $registros[$diasel]++;    
        }
        


        $data = array("totaldias"=>$ultimo_dia, "registrosdia" =>$registros);
        
        return json_encode($data);
    }

    public function graficoAnual(Request $request)
    {
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;
        
        $anio = DB::SELECT('SELECT YEAR(fecinicio) AS anio 
                             FROM prestamo 
                             WHERE sede_id = "'.$idSucursal.'"
                             GROUP BY YEAR(fecinicio)');

        $prestamo = DB::SELECT('SELECT COUNT(*) AS cantidadPrestamo, YEAR(fecinicio) AS fecinicio 
                                 FROM prestamo 
                                 WHERE sede_id = "'.$idSucursal.'" AND estado = "ACTIVO DESEMBOLSADO" GROUP BY YEAR(fecinicio)');

        $bienes = DB::SELECT('SELECT COUNT(*) AS cantidadBienes 
                               FROM prestamo 
                               WHERE sede_id = "'.$idSucursal.'"
                               GROUP BY YEAR(fecinicio)');

        $liquidacion = DB::SELECT('SELECT COUNT(*) AS cantLiquidacion 
                                    FROM prestamo 
                                    WHERE sede_id = "'.$idSucursal.'" estado = "LIQUIDACION" 
                                    GROUP BY YEAR(fecinicio)');

        $vendido = DB::SELECT('SELECT COUNT(*) AS cantVendido  
                                FROM prestamo 
                                WHERE sede_id = "'.$idSucursal.'" estado = "VENDIDO" 
                                GROUP BY YEAR(fecinicio)');

        $cliente = DB::SELECT('SELECT COUNT(*) AS contCliente 
                                FROM cliente 
                                WHERE sede_id = "'.$idSucursal.'"
                                GROUP BY YEAR(created_at)');

        $efectivo = DB::SELECT('SELECT sum(monto) AS monto, YEAR(fecinicio) fecinicio
                                 FROM prestamo 
                                 WHERE sede_id = "'.$idSucursal.'"
                                 GROUP BY YEAR(fecinicio)');

        $interes = DB::SELECT('SELECT SUM(intpago) AS interes, YEAR(created_at) AS created_at
                                FROM pago
                                WHERE sede_id = "'.$idSucursal.'"
                                GROUP BY YEAR(created_at)');

        $mora = DB::SELECT('SELECT SUM(mora) AS mora, YEAR(created_at) AS created_at
                             FROM pago
                             WHERE sede_id = "'.$idSucursal.'"
                             GROUP BY YEAR(created_at)');

        $venta = DB::SELECT('SELECT SUM(m.importe - m.interesPagar - m.moraPagar - m.monto) AS venta, YEAR(m.created_at) AS fecVenta
                              FROM movimiento m, caja c
                              WHERE m.caja_id = c.id AND c.sede_id = "'.$idSucursal.'" AND m.codigo = "V"
                              GROUP BY YEAR(m.created_at)');

        $gastoAdmin = DB::SELECT('SELECT SUM(m.monto) AS gasto, YEAR(m.created_at) AS created_at 
                                   FROM movimiento m, caja c
                                   WHERE m.caja_id = c.id AND c.sede_id = "'.$idSucursal.'" AND m.codigo = "GA"
                                   GROUP BY YEAR(m.created_at)');

        $prestamoActivo = DB::SELECT('SELECT COUNT(*) AS cantPrestamoActivo 
                                       FROM prestamo 
                                       WHERE sede_id = "'.$idSucursal.'" AND codigo = "N" AND estado = "ACTIVO DESEMBOLSADO"
                                       GROUP BY YEAR(fecinicio)');

        $renovacionActivo = DB::SELECT('SELECT COUNT(*) AS cantRenovacionActivo 
                                         FROM prestamo 
                                         WHERE sede_id = "'.$idSucursal.'" AND codigo = "R" AND estado = "ACTIVO DESEMBOLSADO" 
                                         GROUP BY YEAR(fecinicio)');

        $totAnio = COUNT($anio);

        for($a=1; $a<=$totAnio ;$a++){
            $registros[$a]=0;
            $monto[$a]=0;
            $veranio[$a] = 0;
            $cantidadPrestamo[$a] = 0;
            $cantidadBienes[$a] = 0;
            $cantidadLiquidacion[$a] = 0;
            $cantidadVendido[$a] = 0;
            $cantidadCliente[$a] = 0;
            $montoEfectivo[$a] = 0;
            $montoInteres[$a] = 0;
            $montoMora[$a] = 0;
            $montoVenta[$a] = 0;      
            $gastoAdministrativo[$a] = 0;
            $presActivo[$a] = 0;
            $renActivo[$a] = 0;
        }
                                         


        foreach($prestamo as $pts){
            $veranio[] = $pts->fecinicio;
            $cantidadPrestamo[] = $pts->cantidadPrestamo;
        }

        foreach ($bienes as $bi) {
            $cantidadBienes[] = $bi->cantidadBienes;
        }

        foreach ($liquidacion as $li) {
            $cantidadLiquidacion[] = $li->cantLiquidacion;
        }

        foreach ($vendido as $ve) {
            $cantidadVendido[] = $ve->cantVendido;
        }

        foreach ($cliente as $cl) {
            $cantidadCliente[] = $cl->contCliente;
        }

        foreach ($efectivo as $ef) {
            $montoEfectivo[] = $ef->monto;
        }

        foreach ($interes as $in) {
            $montoInteres[] = $in->interes;
        }

        foreach ($mora as $mo) {
            $montoMora[] = $mo->mora;
        }

        foreach ($venta as $vt) {
            $montoVenta[] = $vt->venta;
        }

        foreach ($gastoAdmin as $ga){
            $gastoAdministrativo[] = $ga->gasto;
        }

        foreach ($prestamoActivo as $pa) {
            $presActivo[] = $pa->cantPrestamoActivo;
        }

        foreach ($renovacionActivo as $ra) {
            $renActivo[] = $ra->cantRenovacionActivo;
        }

        

        $data = array("totalanio" => $totAnio, "anio"=>$veranio , "cantprestamo" =>$cantidadPrestamo, "cantbienes" => $cantidadBienes, "cantliquidacion" => $cantidadLiquidacion, "cantvendido" => $cantidadVendido, "cantcliente" => $cantidadCliente, "montefectivo" => $montoEfectivo, "montinteres" => $montoInteres, "monmora" => $montoMora, "monventa" => $montoVenta, "gastoAdmin" => $gastoAdministrativo, "prestamoactivo" => $presActivo, "renovacionactivo" => $renActivo);
        
        return json_encode($data);
    }

    public function graficoFlujoCajaAnual(Request $request)
    {
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $users_id = Auth::user()->id;
        $veranio = [];
        $registros = [];
        $montoEgreso = [];
        $montoIngreso = [];
        
        
        $anio = DB::SELECT('SELECT YEAR(fecinicio) AS anio 
                             FROM prestamo 
                             WHERE sede_id = "'.$idSucursal.'"
                             GROUP BY YEAR(fecinicio)');

        $egreso = DB::SELECT('SELECT SUM(m.importe) AS monto, YEAR(m.created_at) AS fecinicio
                               FROM movimiento m, caja c
                               WHERE m.caja_id = c.id AND c.sede_id = "'.$idSucursal.'" AND m.tipo = "EGRESO"
                               GROUP BY YEAR(m.created_at)');

        $ingreso = DB::SELECT('SELECT SUM(m.importe) AS monto, YEAR(m.created_at) AS fecinicio
                                FROM movimiento m, caja c
                                WHERE m.caja_id = c.id AND c.sede_id = "'.$idSucursal.'" AND m.tipo = "INGRESO"
                                GROUP BY YEAR(m.created_at)');

        $cantAnio = COUNT($anio);

        for($a=1; $a<=$cantAnio ;$a++){
            $registros[$a]=0;
        }

        foreach($egreso as $e){
            $veranio[] = $e->fecinicio;
            $montoEgreso[] = $e->monto;
        }

        foreach($ingreso as $i){
            $montoIngreso[] = $i->monto;
        }

        $data = array("totalanio" => $cantAnio, "numanio"=>$veranio , "egreso" =>$montoEgreso, "ingreso" => $montoIngreso);
        
        return json_encode($data);

    }
    
    public function graficoEstPrestamoAnual(Request $request)
    {
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
    
        $anioData = DB::select('SELECT YEAR(fecinicio) AS anio 
                                FROM prestamo 
                                WHERE s');
                                
        return json_encode($anioData);
    }
    
    public function registrarInventario(Request $request)
    {
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        
        $inventario = new Inventario();
        $inventario->unidad = $request->unidad;
        $inventario->nombre = $request->nombre;
        $inventario->valor = $request->valor;
        $inventario->marca = $request->marca;
        $inventario->estado = "ACTIVO";
        $inventario->tipoinventario_id = $request->tipoinventario_id;
        $inventario->sede_id = $idSucursal;
        if($inventario->save()){
            
        }
    }
    
    public function cerrarControlPatrimonio(Request $request)
    {
        $resp = 0;
        $Proceso = new proceso();
        $idSucursal = $Proceso->obtenerSucursal()->sucursal_id;
        $idEmpleado = $Proceso->obtenerSucursal()->id;
        $mesActual = date("n");
        setlocale(LC_TIME, 'es_ES');
        $nombreMesActual = strftime("%B");
        $anioActual = date("Y");
        $fechaActual = date("Y-m-d");
        $horaActual = date("H:i:s");
        $listPatrimonioNeto = $this->getListPatrimonioNetoUseCase->execute($idSucursal);
        // dd($listPatrimonioNeto);
        $monto = number_format($listPatrimonioNeto[0]->total_general, 2);
        $montoSinComa = str_replace(',', '', $monto);
        
        
        $controlPatrimonio = new ControlPatrimonio();
        $controlPatrimonio->mes = $nombreMesActual;
        $controlPatrimonio->numbermes = $mesActual;
        $controlPatrimonio->anio = $anioActual;
        $controlPatrimonio->monto = $montoSinComa;
        $controlPatrimonio->user_id = $idEmpleado;
        $controlPatrimonio->feccierre = $fechaActual;
        $controlPatrimonio->horacierre = $horaActual;
        $controlPatrimonio->sede_id = $idSucursal;
        if ($controlPatrimonio->save()) {
            $resp = 1;    
        }
        return response()->json(["resp"=>$resp]);
    }
}
