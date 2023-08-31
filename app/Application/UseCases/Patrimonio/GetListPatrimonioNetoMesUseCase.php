<?php

namespace App\Application\UseCases\Patrimonio;

use Exception;
use Illuminate\Support\Collection;
use App\Models\Inventario;
use App\Models\Prestamo;
use App\Models\Caja;
use Illuminate\Support\Facades\DB;

class GetListPatrimonioNetoMesUseCase
{

    public function __construct()
    {
    }

    public function execute(array $data): Collection
    {
        
        $idSucursal = $data['idSucursal'];
        $anio = $data['anio'];
        
        function numeroAMes($numeroMes) {
            $meses = array(
                1 => 'ENE',
                2 => 'FEB',
                3 => 'MAR',
                4 => 'ABR',
                5 => 'MAY',
                6 => 'JUN',
                7 => 'JUL',
                8 => 'AGO',
                9 => 'SEP',
                10 => 'OCT',
                11 => 'NOV',
                12 => 'DIC'
            );
        
            return isset($meses[$numeroMes]) ? $meses[$numeroMes] : 'Mes inválido';
        }
        
        try {
        
            $result = DB::table(function ($query) use ($idSucursal, $anio) {
                        // Consulta del monto del inventario
                        $query->selectRaw('SUM(unidad * valor) AS total, YEAR(created_at) AS anio, MONTH(created_at) AS mes')
                            ->from('inventario')
                            ->where('tipoinventario_id', 1)
                            ->where('estado', 'ACTIVO')
                            ->where('sede_id', $idSucursal)
                            ->whereYear('created_at', $anio)
                            ->groupBy('anio', 'mes')
                            ->unionAll(
                                // Consulta del monto de préstamos colocados
                                DB::table('prestamo')
                                    ->selectRaw('COALESCE(SUM(monto), 0.00) AS total, YEAR(created_at) AS anio, MONTH(created_at) AS mes')
                                    ->where('estado', 'ACTIVO DESEMBOLSADO')
                                    ->where('sede_id', $idSucursal)
                                    ->whereYear('created_at', $anio)
                                    ->groupBy('anio', 'mes')
                            )
                            ->unionAll(
                                // Consulta del monto de préstamos en liquidación
                                DB::table('prestamo')
                                    ->selectRaw('COALESCE(SUM(monto), 0.00) AS total, YEAR(created_at) AS anio, MONTH(created_at) AS mes')
                                    ->where('estado', 'LIQUIDACION')
                                    ->where('sede_id', $idSucursal)
                                    ->whereYear('created_at', $anio)
                                    ->groupBy('anio', 'mes')
                            )
                            ->unionAll(
                                // Consulta del monto de caja chica
                                DB::table('caja')
                                    ->join('tipocaja', 'caja.tipocaja_id', '=', 'tipocaja.id')
                                    ->selectRaw('SUM(caja.monto) AS total, YEAR(caja.created_at) AS anio, MONTH(caja.created_at) AS mes')
                                    ->where('caja.estado', 'abierta')
                                    ->where('tipocaja.tipo', 'caja chica')
                                    ->where('caja.sede_id', $idSucursal)
                                    ->whereYear('caja.created_at', $anio)
                                    ->groupBy('anio', 'mes')
                            )
                            ->unionAll(
                                // Consulta del monto de caja grande
                                DB::table('caja')
                                    ->join('tipocaja', 'caja.tipocaja_id', '=', 'tipocaja.id')
                                    ->selectRaw('SUM(caja.monto) AS total, YEAR(caja.created_at) AS anio, MONTH(caja.created_at) AS mes')
                                    ->where('caja.estado', 'abierta')
                                    ->where('tipocaja.tipo', 'caja grande')
                                    ->where('caja.sede_id', $idSucursal)
                                    ->whereYear('caja.created_at', $anio)
                                    ->groupBy('anio', 'mes')
                            )
                            ->unionAll(
                                // Consulta del monto de bancos
                                DB::table('caja')
                                    ->join('tipocaja', 'caja.tipocaja_id', '=', 'tipocaja.id')
                                    ->selectRaw('SUM(caja.monto) AS total, YEAR(caja.created_at) AS anio, MONTH(caja.created_at) AS mes')
                                    ->where('caja.estado', 'abierta')
                                    ->where('tipocaja.categoria', 'banco')
                                    ->where('caja.sede_id', $idSucursal)
                                    ->whereYear('caja.created_at', $anio)
                                    ->groupBy('anio', 'mes')
                            );
                    }, 'all_data')
                    ->selectRaw('SUM(total) AS total_general, anio, mes')
                    ->groupBy('anio', 'mes')
                    ->get();
                    
                    
                    
                    $result = $result->map(function ($item) {
                        // Obtener el nombre del mes usando la función numeroAMes
                        $item->mes = numeroAMes($item->mes);
                    
                        // Retornar el elemento actualizado
                        return $item;
                    });
                    
                    

        return $result;
            
        } catch (Exception $e) {
            throw new Exception("GetListPatrimonioNetoMesUseCase: " . $e->getMessage());
        }
    }
}