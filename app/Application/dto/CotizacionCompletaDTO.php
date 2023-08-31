<?php
namespace App\Application\DTO\Cotizacion;
    
    class CotizacionCompletaDTO
    {
        public $cotizacion;
        public $cliente;
        public $almacen;
        
        public function __construct($cotizacion, $cliente, $almacen)
        {
            $this->cotizacion = $cotizacion;
            $this->cliente = $cliente;
            $this->almacen = $almacen;
        }
    }