<?php

namespace App\Application\UseCases\Inventario;

use App\Models\Inventario;
use Exception;


class GetMontoInventarioUseCase
{

    public function __construct() {}

    public function execute(int $idSucursal): float
    {
        try {
            
            $totalInventario = Inventario::where('tipoinventario_id', 1)
                                        ->where('estado', 'ACTIVO')
                                        ->where('sede_id', $idSucursal)
                                        ->selectRaw('ROUND(SUM(unidad * valor), 2) AS total')
                                        ->first();
                                            
            return round($totalInventario->total, 2);
            
        } catch (Exception $e) {
            throw new Exception("GetMontoInventarioUseCase: " . $e->getMessage());
        }
    }
}
