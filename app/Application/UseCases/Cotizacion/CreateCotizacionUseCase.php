<?php

namespace App\Application\UseCases\Cotizacion;

use App\Models\Cotizacion;
use App\Application\UseCases\Garantia\CreateGarantiaUseCase;
use App\Application\UseCases\Notificacion\CreateNotificacionUseCase;
use Exception;


class CreateCotizacionUseCase
{

    private $createGarantiaUseCase;
    private $createNotificacionUseCase;

    public function __construct(
        CreateGarantiaUseCase $createGarantiaUseCase, 
        CreateNotificacionUseCase $createNotificacionUseCase
        )
    {
        $this->createGarantiaUseCase = $createGarantiaUseCase;
        $this->createNotificacionUseCase = $createNotificacionUseCase;
    }

    public function execute(array $data): Cotizacion
    {
        try {
            $garantiaData = [
                'nombreGarnatia' => $data['nombreGarnatia'],
                'detalleGarantia' => $data['detalleGarantia'],
                'idTipoGarantia' => $data['idTipoGarantia'],
                'estadoGarantia' => "ACTIVO"
            ];
            
            $notificacionData = [
                'mensajeNotificacion' => $data['mensajeNotificacion'],
                'asuntoNotificacion' => $data['asuntoNotificacion'],
                'estadoNotificacion' => $data['estadoNotificacion'],
                'idSucursal' => $data['idSucursal'],
                'tipoNotificacion' => $data['tipoNotificacion'],
                'idUser' => $data['idUser'],
                'iconNotificacion' => $data['iconNotificacion'],
            ];
    
            $garantia = $this->createGarantiaUseCase->execute($garantiaData);
            $notificacion = $this->createNotificacionUseCase->execute($notificacionData);
            
            $cotizacion = new Cotizacion();
            $cotizacion->max = $data['precMax'];
            $cotizacion->min = $data['precMin'];
            $cotizacion->estado = $data['estadoCotizacion'];
            $cotizacion->precio = $data['precioReal'];
            $cotizacion->cliente_id = $data['idCliente'];
            $cotizacion->empleado_id = $data['idEmpleado'];
            $cotizacion->garantia_id = $garantia->id;
            $cotizacion->tipoprestamo_id = $data['tipoPrestamo'];
            $cotizacion->sede_id = $data['idSucursal'];
            $cotizacion->save();
    
            return $cotizacion;
            
        } catch (Exception $e) {
            throw new Exception("Error al guardar la cotización: " . $e->getMessage());
        }
    }
}
