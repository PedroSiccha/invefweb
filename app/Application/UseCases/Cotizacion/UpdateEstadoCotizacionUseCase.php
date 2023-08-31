<?php

namespace App\Application\UseCases\Cotizacion;

use App\Models\Cotizacion;
use Exception;


class UpdateEstadoCotizacionUseCase
{

    public function __construct()
    {
    }

    public function execute(array $data): Cotizacion
    {
        try {
            
            $cotizacion = Cotizacion::where('id', '=', $data['idCotizacion'])->first();
            $cotizacion->estado = $data['estadoCotizacion'];
            $cotizacion->save();
    
            return $cotizacion;
            
        } catch (Exception $e) {
            throw new Exception("Error al actualizar el estado de la cotización: " . $e->getMessage());
        }
    }
}
