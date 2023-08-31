<?php

namespace App\Application\UseCases\Prestamo;

use App\Models\Prestamo;
use Exception;


class UpdateEstadoPrestamoUseCase
{

    public function __construct()
    {
    }

    public function execute(array $data): Prestamo
    {

        try {
            
            $prestamo = Prestamo::where('id', '=', $data['idPrestamo'])->first();
            $prestamo->estado = $data['estadoPrestamo'];
            $prestamo->save();
            return $prestamo;
            
        } catch (Exception $e) {
            throw new Exception("UpdateEstadoPrestamoUseCase: " . $e->getMessage());
        }
    }
}
