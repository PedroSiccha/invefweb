<?php

namespace App\Application\UseCases\Liquidacion;

use App\Models\Prestamo;
use Exception;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class GetMontoLiquidacionUseCase
{

    public function __construct() {}

    public function execute(int $idSucursal): float
    {
        try {
            
            $fechaInicioMes = Carbon::now()->startOfMonth()->toDateString();

            // Obtener la fecha del último día del mes actual
            $fechaFinMes = Carbon::now()->endOfMonth()->toDateString();
            
            $liquidacion = Prestamo::where('estado', 'LIQUIDACION')
                                   ->where('sede_id', $idSucursal)
                                   ->whereBetween('created_at', [$fechaInicioMes, $fechaFinMes])
                                   ->select(DB::raw('COALESCE(SUM(monto), 0.00) AS monto'))
                                   ->first();
                                            
            return round($liquidacion->monto, 2);
            
        } catch (Exception $e) {
            throw new Exception("GetMontoLiquidacionUseCase: " . $e->getMessage());
        }
    }
}
