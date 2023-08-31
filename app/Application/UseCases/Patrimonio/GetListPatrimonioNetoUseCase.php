<?php

namespace App\Application\UseCases\Patrimonio;

use Exception;
use Illuminate\Support\Collection;
use App\Models\Inventario;
use App\Models\Prestamo;
use App\Models\Caja;
use Illuminate\Support\Facades\DB;

class GetListPatrimonioNetoUseCase
{

    public function __construct()
    {
    }

    public function execute(int $idSucursal): Collection
    {

        try {
            
            $result = DB::table(function ($query) use ($idSucursal) {
                            // Consulta del monto del inventario
                            $query->selectRaw('SUM(unidad * valor) AS total, YEAR(created_at) AS anio')
                                ->from('inventario')
                                ->where('tipoinventario_id', 1)
                                ->where('estado', 'ACTIVO')
                                ->where('sede_id', $idSucursal)
                                ->groupBy('anio')
                                ->unionAll(
                                    // Consulta del monto de préstamos colocados
                                    DB::table('prestamo')
                                        ->selectRaw('COALESCE(SUM(monto), 0.00) AS total, YEAR(created_at) AS anio')
                                        ->where('estado', 'ACTIVO DESEMBOLSADO')
                                        ->where('sede_id', $idSucursal)
                                        ->groupBy('anio')
                                )
                                ->unionAll(
                                    // Consulta del monto de préstamos en liquidación
                                    DB::table('prestamo')
                                        ->selectRaw('COALESCE(SUM(monto), 0.00) AS total, YEAR(created_at) AS anio')
                                        ->where('estado', 'LIQUIDACION')
                                        ->where('sede_id', $idSucursal)
                                        ->groupBy('anio')
                                )
                                ->unionAll(
                                    // Consulta del monto de caja chica
                                    DB::table('caja')
                                        ->join('tipocaja', 'caja.tipocaja_id', '=', 'tipocaja.id')
                                        ->selectRaw('SUM(caja.monto) AS total, YEAR(caja.created_at) AS anio')
                                        ->where('caja.estado', 'abierta')
                                        ->where('tipocaja.tipo', 'caja chica')
                                        ->where('caja.sede_id', $idSucursal)
                                        ->groupBy('anio')
                                )
                                ->unionAll(
                                    // Consulta del monto de caja grande
                                    DB::table('caja')
                                        ->join('tipocaja', 'caja.tipocaja_id', '=', 'tipocaja.id')
                                        ->selectRaw('SUM(caja.monto) AS total, YEAR(caja.created_at) AS anio')
                                        ->where('caja.estado', 'abierta')
                                        ->where('tipocaja.tipo', 'caja grande')
                                        ->where('caja.sede_id', $idSucursal)
                                        ->groupBy('anio')
                                )
                                ->unionAll(
                                    // Consulta del monto de bancos
                                    DB::table('caja')
                                        ->join('tipocaja', 'caja.tipocaja_id', '=', 'tipocaja.id')
                                        ->selectRaw('SUM(caja.monto) AS total, YEAR(caja.created_at) AS anio')
                                        ->where('caja.estado', 'abierta')
                                        ->where('tipocaja.categoria', 'banco')
                                        ->where('caja.sede_id', $idSucursal)
                                        ->groupBy('anio')
                                );
                        }, 'all_data')
                        ->selectRaw('SUM(total) AS total_general, anio')
                        ->groupBy('anio')
                        ->get();
        
            return $result;
            
        } catch (Exception $e) {
            throw new Exception("GetListPatrimonioNetoUseCase: " . $e->getMessage());
        }
    }
}