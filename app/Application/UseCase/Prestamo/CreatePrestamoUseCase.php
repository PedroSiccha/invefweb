<?php

namespace App\Application\UseCases\Prestamo;

use App\Models\Prestamo;
use App\Application\UseCases\Notificacion\CreateNotificacionUseCase;
use App\Application\UseCases\Cotizacion\UpdateEstadoCotizacionUseCase;
use App\Application\UseCases\Cliente\UpdatePuntajeClienteUseCase;
use Exception;


class CreatePrestamoUseCase
{

    private $createNotificacionUseCase;
    private $updateEstadoCotizacionUseCase;
    private $updatePuntajeClienteUseCase;

    public function __construct(
        CreateNotificacionUseCase $createNotificacionUseCase, 
        UpdateEstadoCotizacionUseCase $updateEstadoCotizacionUseCase, 
        UpdatePuntajeClienteUseCase $updatePuntajeClienteUseCase
        )
    {
        $this->createNotificacionUseCase = $createNotificacionUseCase;
        $this->updateEstadoCotizacionUseCase = $updateEstadoCotizacionUseCase;
        $this->updatePuntajeClienteUseCase = $updatePuntajeClienteUseCase;
    }

    public function execute(array $data): Prestamo
    {
        try {
            
            if (isset($data['idCotizacion'])) {
                $cotizacionData = [
                    'idCotizacion' => $data['idCotizacion'],
                    'estadoCotizacion' => $data['estadoCotizacion']
                ];    
                $cotizacion = $this->updateEstadoCotizacionUseCase->execute($cotizacionData);
            }
            
            if (isset($data['puntajeCliente'])) {
                
                $clienteData = [
                    'idCliente' => $data['idCliente'],
                    'puntajeCliente' => $data['puntajeCliente']
                ];    
                $cliente = $this->updatePuntajeClienteUseCase->execute($clienteData);
                
            }
            
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
            
            $prestamo = new Prestamo();
            $prestamo->codigo = $data['codigoOrigenPrestamo'];
            $prestamo->monto = $data['monto'];
            $prestamo->fecinicio = $data['fechaInicio'];
            $prestamo->fecfin = $data['fechaFin'];
            $prestamo->total = $data['precioTotal'];
            $prestamo->estado = $data['estadoPrestamo'];
            $prestamo->cotizacion_id = $data['idCotizacion'];
            $prestamo->empleado_id = $data['idEmpleado'];
            $prestamo->tipocredito_interes_id = $data['idTipoCreditoInteres'];
            $prestamo->mora_id = $data['idMora'];
            $prestamo->macro = $data['estadoMacro'];
            $prestamo->intpagar = $data['interesPagar'];
            $prestamo->sede_id = $data['idSucursal'];
            $prestamo->save();
            
            return $prestamo;
            
        } catch (Exception $e) {
            throw new Exception("CreatePrestamoUseCase: " . $e->getMessage());
        }
    }
}
