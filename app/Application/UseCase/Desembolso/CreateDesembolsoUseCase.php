<?php

namespace App\Application\UseCases\Desembolso;

use App\Models\Desembolso;
use App\Application\UseCases\Movimiento\CreateMovimientoUseCase;
use App\Application\UseCases\Notificacion\CreateNotificacionUseCase;
use App\Application\UseCases\Prestamo\UpdateEstadoPrestamoUseCase;
use Exception;


class CreateDesembolsoUseCase
{

    private $createMovimientoUseCase;
    private $createNotificacionUseCase;
    private $updateEstadoPrestamoUseCase;

    public function __construct(
        CreateMovimientoUseCase $createMovimientoUseCase, 
        CreateNotificacionUseCase $createNotificacionUseCase, 
        UpdateEstadoPrestamoUseCase $updateEstadoPrestamoUseCase
        )
    {
        $this->createMovimientoUseCase = $createMovimientoUseCase;
        $this->createNotificacionUseCase = $createNotificacionUseCase;
        $this->updateEstadoPrestamoUseCase = $updateEstadoPrestamoUseCase;
    }

    public function execute(array $data): Desembolso
    {
        try {
            
            
            $notificacionData = [
                'mensajeNotificacion' => $data['mensajeNotificacion'],
                'asuntoNotificacion' => $data['asuntoNotificacion'],
                'estadoNotificacion' => $data['estadoNotificacion'],
                'idSucursal' => $data['idSucursal'],
                'tipoNotificacion' => $data['tipoNotificacion'],
                'idUser' => $data['idUser'],
                'iconNotificacion' => $data['iconNotificacion'],
            ];
            
            $prestamoData = [
                'idPrestamo' => $data['idPrestamo'],
                'estadoPrestamo' => $data['estadoPrestamo'],
            ];
    
            $notificacion = $this->createNotificacionUseCase->execute($notificacionData);
            $prestamo = $this->updateEstadoPrestamoUseCase->execute($prestamoData);
            
            $desembolso = new Desembolso();
            $desembolso->numero = $data['numeroDesembolso'];
            $desembolso->estado = $data['estadoDesembolso'];
            $desembolso->monto = $data['montoPrestamo'];
            $desembolso->prestamo_id = $data['idPrestamo'];
            $desembolso->empleado_id = $data['idEmpleado'];
            $desembolso->sede_id = $data['idSucursal'];
            $desembolso->save();
            
            $movimientoData = [
                'idCaja' => $data['idCaja'],
                'nuevoMontoCaja' => $data['nuevoMontoCaja'],
                'estadoMovimiento' => $data['estadoMovimiento'],
                'montoPrestamo' => $data['montoPrestamo'],
                'conceptoMovimiento' => $data['conceptoMovimiento'],
                'tipoMovimiento' => $data['tipoMovimiento'],
                'idEmpleado' => $data['idEmpleado'],
                'importeMovimiento' => $data['importeMovimiento'],
                'codigoOrigenMovimiento' => $data['codigoOrigenMovimiento'],
                'codigoSerieMovimiento' => $data['codigoSerieMovimiento'],
                'idSucursal' => $data['idSucursal'],
                'idPrestamo' => $data['idPrestamo'],
                'idDesembolso' => $desembolso->id,
                'idGarantia' => $data['idGarantia'],
                'nombreGarantia' => $data['nombreGarantia'],
            ];
            
            $movimiento = $this->createMovimientoUseCase->execute($movimientoData);
            
    
            return $desembolso;
            
        } catch (Exception $e) {
            throw new Exception("CreateDesembolsoUseCase: " . $e->getMessage());
        }
    }
}

