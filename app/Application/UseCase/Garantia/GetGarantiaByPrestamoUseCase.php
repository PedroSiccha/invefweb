<?php

namespace App\Application\UseCases\Garantia;

use App\Models\Garantia;
use Exception;


class GetGarantiaByPrestamoUseCase
{

    public function __construct()
    {
    }

    public function execute($idPrestamo): Garantia
    {

        try {
            
            $garantia = Garantia::join('cotizacion', 'cotizacion.garantia_id', '=', 'garantia.id')
                            ->join('prestamo', 'prestamo.cotizacion_id', '=', 'cotizacion.id')
                            ->where('prestamo.id', $idPrestamo)
                            ->select('garantia.*')
                            ->first();
            
            return $garantia;
            
        } catch (Exception $e) {
            throw new Exception("GetGarantiaByPrestamoUseCase: " . $e->getMessage());
        }
    }
}
