<?php

namespace App\Application\UseCases\Caja;

use App\Models\Caja;
use Exception;


class UpdateSaldoCajaUseCase
{

    public function __construct()
    {
    }

    public function execute(array $data): Caja
    {

        try {
            
            $caja = Caja::where('id', '=', $data['idCaja'])->first();
            $caja->monto = $data['nuevoMontoCaja'];
            $caja->save();
            return $caja;
            
        } catch (Exception $e) {
            throw new Exception("UpdateSaldoCajaUseCase: " . $e->getMessage());
        }
    }
}
