<?php

namespace App\Application\UseCases\Prestamo;

use App\Models\Prestamo;
use Exception;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class GetPrestamosColocadosUseCase
{

    public function __construct() {}

    public function execute(int $idSucursal): float
    {
        try {
            
            // Obtener la fecha del primer día del mes actual
            $fechaInicioMes = Carbon::now()->startOfMonth()->toDateString();
            
            // Obtener la fecha del último día del mes actual
            $fechaFinMes = Carbon::now()->endOfMonth()->toDateString();
            
            $prestamoColocado = Prestamo::where('estado', 'ACTIVO DESEMBOLSADO')
                ->where('sede_id', $idSucursal)
                ->whereBetween('created_at', [$fechaInicioMes, $fechaFinMes])
                ->select(DB::raw('COALESCE(SUM(monto), 0.00) AS monto'))
                ->first();
                                            
            return round($prestamoColocado->monto, 2);
            
        } catch (Exception $e) {
            throw new Exception("CreatePrestamoUseCase: " . $e->getMessage());
        }
    }
}
