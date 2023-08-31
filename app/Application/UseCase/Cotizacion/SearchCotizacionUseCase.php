<?php

namespace App\Application\UseCases\Cotizacion;

use App\Models\Cotizacion;
use Exception;
//use Illuminate\Database\Eloquent\Collection;


class SearchCotizacionUseCase
{

    public function execute(array $data): Cotizacion
    {
        try {
            $dni = $data['dniCliente'];
            
            $cotizacion = Cotizacion::select('cotizacion.id as cotizacion_id', 'cotizacion.max as cotizacion_max', 'cotizacion.min as cotizacion_min',
                                             'garantia.id as garantia_id', 'garantia.nombre as garantia',
                                             'cliente.id as cliente_id', 'cliente.nombre as cliente_nombre', 'cliente.apellido as cliente_apellido', 'cliente.dni as cliente_dni',
                                             'sede.id as sucursal_id', 'sede.nombre as sucursal_nombre')
                                    ->join('cliente', 'cliente.id', '=', 'cotizacion.cliente_id')
                                    ->join('sede', 'sede.id', '=', 'cotizacion.sede_id')
                                    ->join('garantia', 'garantia.id', '=', 'cotizacion.garantia_id')
                                    ->where('cotizacion.estado', 'PRESTAMO')
                                    ->where('cliente.dni', $dni)
                                    ->orderBy('cotizacion.created_at', 'desc')
                                    ->first();

            return $cotizacion;
            
        } catch (Exception $e) {
            throw new Exception("Error al guardar la garantía: " . $e->getMessage());
        }
    }
}
