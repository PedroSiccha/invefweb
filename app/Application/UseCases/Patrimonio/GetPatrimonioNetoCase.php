<?php

namespace App\Application\UseCases\Patrimonio;

use App\Models\Prestamo;
use App\Models\Inventario;
use Exception;


class GetPatrimonioNetoCase
{

    public function __construct()
    {
    }

    public function execute(array $data): float
    {
        
        $idSucursal = $data['idSucursal'];
        $montoPrestamosColocados = $data['montoPrestamosColocados'];
        $montoLiquidacion = $data['montoLiquidacion'];
        $montoCajaChica = $data['montoCajaChica'];
        $montoInventario = $data['montoInventario'];
        $montoCajaGrande = $data['montoCajaGrande'];
        $montoBanco = $data['montoBanco'];

        try {
            
            $activosTotales = $montoPrestamosColocados + $montoLiquidacion + $montoCajaChica + $montoInventario + $montoCajaGrande + $montoBanco;

            return round($activosTotales, 2);
            
        } catch (Exception $e) {
            throw new Exception("GetPatrimonioNetoCase: " . $e->getMessage());
        }
    }
}
