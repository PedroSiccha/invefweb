<?php

namespace App\Application\UseCases\Cliente;

use App\Models\Cliente;
use Exception;
use DB;


class GetClienteByPrestamoUseCase
{

    public function __construct()
    {
    }

    public function execute($idPrestamo): Cliente
    {

        try {
            
            $cliente = Cliente::join('cotizacion', 'cliente.id', '=', 'cotizacion.cliente_id')
                                ->join('prestamo', 'cotizacion.id', '=', 'prestamo.cotizacion_id')
                                ->select('cliente.id AS cliente_id', 'cliente.evaluacion', 'cliente.nombre', 'cliente.apellido')
                                ->where('prestamo.id', $idPrestamo)
                                ->first();

            if (!$cliente) {
                throw new Exception('Cliente no encontrado');
            }

            return $cliente;
            
        } catch (Exception $e) {
            throw new Exception("GetClienteByPrestamoUseCase: " . $e->getMessage());
        }
    }
}
