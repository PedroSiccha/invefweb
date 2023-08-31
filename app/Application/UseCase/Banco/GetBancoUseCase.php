<?php

namespace App\Application\UseCases\Banco;

use App\Models\Caja;
use Exception;
use Illuminate\Support\Collection;


class GetBancoUseCase
{

    public function __construct()
    {
    }

    public function execute(array $data): Collection
    {

        try {
            
            $cajas = Caja::join('tipocaja', 'tipocaja.id', '=', 'caja.tipocaja_id')
                    ->where('caja.estado', $data['estadoCaja'])
                    ->where('tipocaja.categoria', 'banco')
                    ->where('caja.sede_id', $data['idSucursal'])
                    ->select('caja.id AS caja_id', 'caja.estado AS caja_estado', 'caja.monto AS caja_monto',  'caja.empleado AS caja_empleado_id', 'caja.sede_id AS caja_sede_id', 'tipocaja.id AS tipocaja_id', 'tipocaja.tipo AS tipocaja_banco', 'tipocaja.detalle AS tipocaja_cuenta')
                    ->get();

            return $cajas;
            
        } catch (Exception $e) {
            throw new Exception("GetBancoUseCase: " . $e->getMessage());
        }
    }
}
