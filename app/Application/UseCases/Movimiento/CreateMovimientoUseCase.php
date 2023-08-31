<?php

namespace App\Application\UseCases\Movimiento;

use App\Models\Movimiento;
use App\Application\UseCases\Caja\UpdateSaldoCajaUseCase;
use Exception;


class CreateMovimientoUseCase
{

    private $updateSaldoCajaUseCase;

    public function __construct(UpdateSaldoCajaUseCase $updateSaldoCajaUseCase)
    {
        $this->updateSaldoCajaUseCase = $updateSaldoCajaUseCase;
    }

    public function execute(array $data): Movimiento
    {
        try {
            
            $cajaData = [
                'idCaja' => $data['idCaja'],
                'nuevoMontoCaja' => $data['nuevoMontoCaja'],
            ];
    
            $caja = $this->updateSaldoCajaUseCase->execute($cajaData);
            
            $movimiento = new Movimiento();
            $movimiento->estado = $data['estadoMovimiento'];
            $movimiento->monto = $data['montoPrestamo'];
            $movimiento->concepto = $data['conceptoMovimiento'];
            $movimiento->tipo = $data['tipoMovimiento'];
            $movimiento->empleado = $data['idEmpleado'];
            $movimiento->importe = $data['importeMovimiento'];
            $movimiento->codigo = $data['codigoOrigenMovimiento'];
            $movimiento->serie = $data['codigoSerieMovimiento'];
            $movimiento->caja_id = $data['idCaja'];
            $movimiento->codprestamo = $data['idPrestamo'];
            $movimiento->condesembolso = $data['idDesembolso'];
            $movimiento->codgarantia = $data['idGarantia'];
            $movimiento->garantia = $data['nombreGarantia'];
            $movimiento->save();
            
            return $movimiento;
            
        } catch (Exception $e) {
            throw new Exception("Error al guardar el movimiento: " . $e->getMessage());
        }
    }
}
