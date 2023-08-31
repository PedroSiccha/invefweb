<?php

namespace App\Application\UseCases\Cliente;

use App\Models\Cliente;
use Exception;


class UpdatePuntajeClienteUseCase
{

    public function __construct()
    {
    }

    public function execute(array $data): Cliente
    {

        try {
            
            $cli = Cliente::where('id', '=', $data['idCliente'])->first();
            $cli->evaluacion = $data['puntajeCliente'];
            $cli->save();
    
            return $cli;
            
        } catch (Exception $e) {
            throw new Exception("Error al actualizar el puntaje del cliente: " . $e->getMessage());
        }
    }
}
