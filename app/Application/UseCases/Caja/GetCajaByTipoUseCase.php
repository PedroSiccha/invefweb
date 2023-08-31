<?php

namespace App\Application\UseCases\Caja;

use App\Models\Caja;
use Exception;


class GetCajaByTipoUseCase
{

    public function __construct()
    {
    }

    public function execute(array $data): Caja
    {

        try {
            
            $caja = Caja::join('tipocaja', 'tipocaja.id', '=', 'caja.tipocaja_id')
                    ->where('caja.estado', $data['estadoCaja'])
                    ->where('tipocaja.tipo', $data['tipoCaja'])
                    ->where('caja.sede_id', $data['idSucursal'])
                    ->select('caja.*')
                    ->first();
                    
            if ($caja === null) {
                //throw new Exception("No se encontró ninguna caja que cumpla con los criterios especificados.");
                $caja = new Caja();
                $caja->id = 0;
                $caja->estado = "abierta";
                $caja->monto = "0.00";
                $caja->fecha = "0000-00-00";
                $caja->inicio = "07:09:06";
                $caja->fin = null;
                $caja->created_at = "2023-06-12 19:09:06";
                $caja->updated_at = "2023-06-12 19:09:06";
                $caja->montofin = null;
                $caja->empleado = "1";
                $caja->sede_id = 2;
                $caja->tipocaja_id = 1;
            }
    
            return $caja;
            
        } catch (Exception $e) {
            throw new Exception("GetCajaByTipoUseCase: " . $e->getMessage());
        }
    }
}
