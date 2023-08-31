<?php

namespace App\Application\UseCases\Pago;

use App\Models\Pago;
use App\Application\UseCases\Movimiento\CreateMovimientoUseCase;
use App\Application\UseCases\Notificacion\CreateNotificacionUseCase;
use App\Application\UseCases\Prestamo\UpdateEstadoPrestamoUseCase;
use Exception;


class CreatePagoUseCase
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

    public function execute(array $data): Pago
    {
        try {
            
            if (isset($data['mensajeNotificacion'])) {
                $notificacionData = [
                    'mensajeNotificacion' => $data['mensajeNotificacion'],
                    'asuntoNotificacion' => $data['asuntoNotificacion'],
                    'estadoNotificacion' => $data['estadoNotificacion'],
                    'idSucursal' => $data['idSucursal'],
                    'tipoNotificacion' => $data['tipoNotificacion'],
                    'idUser' => $data['idUser'],
                    'iconNotificacion' => $data['iconNotificacion'],
                ];
                $notificacion = $this->createNotificacionUseCase->execute($notificacionData);
            }
            
            $prestamoData = [
                'idPrestamo' => $data['idPrestamo'],
                'estadoPrestamo' => $data['estadoPrestamo'],
            ];
            
            $prestamo = $this->updateEstadoPrestamoUseCase->execute($prestamoData);
            
            $pago = new Pago();
            $pago->codigo = $data['codigoPago'];
            $pago->serie = $data['idPrestamo'];
            $pago->monto = $data['monto'];
            $pago->importe = $data['montoPago'];
            $pago->vuelto = $data['vueltoPago'];
            $pago->intpago = $data['interesPago'];
            $pago->mora = $data['moraPago'];
            $pago->diaspasados = $data['diasPago'];
            $pago->tipocomprobante_id = $data['idTipoComprobante'];
            $pago->prestamo_id = $data['idPrestamo'];
            $pago->empleado_id = $data['idEmpleado'];
            $pago->sede_id = $data['idSucursal'];
            $pago->save();
            
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
                'idDesembolso' => $pago->id,
                'idGarantia' => $data['idGarantia'],
                'nombreGarantia' => $data['nombreGarantia'],
            ];
            
            $movimiento = $this->createMovimientoUseCase->execute($movimientoData);
            
            return $pago;
            
        } catch (Exception $e) {
            throw new Exception("CreatePagoUseCase: " . $e->getMessage());
        }
    }
}

