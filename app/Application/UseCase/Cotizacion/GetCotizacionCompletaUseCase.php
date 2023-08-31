<?php

namespace App\Application\UseCases\Cotizacion;

use App\Application\DTO\Cotizacion\CotizacionCompletaDTO;
use Exception;
use Illuminate\Support\Facades\DB;

class GetCotizacionCompletaUseCase
{

    public function execute(array $data): CotizacionCompletaDTO
    {
        try {
            $id = $data['idCotizacion'];
            
            $cotizacion = DB::table('cotizacion')
                            ->join('garantia', 'cotizacion.garantia_id', '=', 'garantia.id')
                            ->select('garantia.nombre AS producto', 'garantia.id AS garantia_id', 'cotizacion.id AS cotizacion_id', 'cotizacion.precio AS valorreal', 'cotizacion.max AS presmax', 'cotizacion.min AS presmin')
                            ->where('cotizacion.id', $id)
                            ->first();
                            
            $cliente = DB::table('cliente')
                        ->join('cotizacion', 'cotizacion.cliente_id', '=', 'cliente.id')
                        ->join('direccion', 'cliente.direccion_id', '=', 'direccion.id')
                        ->join('distrito', 'direccion.distrito_id', '=', 'distrito.id')
                        ->join('provincia', 'distrito.provincia_id', '=', 'provincia.id')
                        ->join('departamento', 'provincia.departamento_id', '=', 'departamento.id')
                        ->select('cliente.id', 'cliente.nombre', 'cliente.apellido', 'cliente.dni', DB::raw('CONCAT(direccion.direccion, " - ", distrito.distrito, " - ", provincia.provincia, " - ", departamento.departamento) AS direccion'), 'cliente.evaluacion')
                        ->where('cotizacion.id', $id)
                        ->first();
                        
            $almacen = DB::table('garantia_casillero')
                        ->join('garantia', 'garantia_casillero.garantia_id', '=', 'garantia.id')
                        ->join('cotizacion', 'cotizacion.garantia_id', '=', 'garantia.id')
                        ->join('casillero', 'garantia_casillero.casillero_id', '=', 'casillero.id')
                        ->join('stand', 'casillero.stand_id', '=', 'stand.id')
                        ->join('almacen', 'stand.almacen_id', '=', 'almacen.id')
                        ->select('casillero.id AS casillero_id', 'casillero.nombre AS casillero', 'stand.nombre AS stand', 'almacen.nombre AS almacen')
                        ->where('cotizacion.id', $id)
                        ->first();
                        
            $cotizacionCompletaDTO = new CotizacionCompletaDTO($cotizacion, $cliente, $almacen);

            return $cotizacionCompletaDTO;
            
        } catch (Exception $e) {
            throw new Exception("Error al guardar la garantía: " . $e->getMessage());
        }
    }
}
