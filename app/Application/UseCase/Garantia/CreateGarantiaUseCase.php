<?php

namespace App\Application\UseCases\Garantia;

use App\Models\Garantia;
use Exception;

class CreateGarantiaUseCase
{

    public function execute(array $data): Garantia
    {
        try {
            $garantia = new Garantia();
            $garantia->nombre = $data['nombreGarnatia'];
            $garantia->detalle = $data['detalleGarantia'];
            $garantia->estado = $data['estadoGarantia'];
            $garantia->tipogarantia_id = $data['idTipoGarantia'];
            $garantia->save();
            return $garantia;
        } catch (Exception $e) {
            throw new Exception("Error al guardar la garantía: " . $e->getMessage());
        }
    }
}
