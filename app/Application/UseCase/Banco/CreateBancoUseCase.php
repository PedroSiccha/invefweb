<?php

namespace App\Application\UseCases\Banco;

use App\Application\UseCases\Notificacion\CreateNotificacionUseCase;
use App\Models\Caja;
use Exception;

class CreateBancoUseCase
{
    private $createNotificacionUseCase;

    public function __construct(
        CreateNotificacionUseCase $createNotificacionUseCase,
    )
    {
        $this->createNotificacionUseCase = $createNotificacionUseCase;
    }

    public function execute(array $data): Caja
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
            
            
            $caja = new Caja();
            $caja->estado = $data['estadoBanco'];
            $caja->monto = $data['montoBanco'];
            $caja->fecha = $data['fechaBanco'];
            $caja->inicio = $data['inicioBanco'];
            $caja->fin = $data['finBanco'];
            $caja->montofin = $data['montoFinBanco'];
            $caja->empleado = $data['idEmpleado'];
            $caja->sede_id = $data['idSucursal'];
            $caja->tipocaja_id = $data['idTipoCaja'];
            $caja->save();
            
            return $caja;
            
        } catch (Exception $e) {
            throw new Exception("CreatePagoUseCase: " . $e->getMessage());
        }
    }
}

