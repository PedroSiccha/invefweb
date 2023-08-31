<?php

namespace App\Application\UseCases\Notificacion;

use App\Models\Notificacion;
use Exception;

class CreateNotificacionUseCase
{
    
    public function execute(array $data): Notificacion
    {
        try {
            $notification = new Notificacion();
            $notification->mensaje = $data['mensajeNotificacion'];
            $notification->tiempo = date("H:m:s");
            $notification->asunto = $data['asuntoNotificacion'];
            $notification->estado = $data['estadoNotificacion'];
            $notification->sede =  $data['idSucursal'];
            $notification->tipo = $data['tipoNotificacion'];
            $notification->tipo = $data['idUser'];
            $notification->icono = $data['iconNotificacion'];
            $notification->save();
            return $notification;
        } catch (Exception $e) {
            throw new Exception("Error al guardar la notificación: " . $e->getMessage());
        }
    }
}
