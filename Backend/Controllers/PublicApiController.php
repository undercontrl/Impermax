<?php

namespace App\Impermax\Controllers;

use App\Impermax\Models\Servico;
use App\Impermax\Database\Database;

class PublicApiController{
    private $servicoModel;
    public function __construct(){
        $db = Database::getInstance();
        $this->servicoModel = new Servico($db);
    }

    public function listarServicosAtivos(): void {
        header('Content-Type: application/json; charset=utf-8');

        try {
            $servicos = $this->servicoModel->listarServicosAtivos();
            echo json_encode([
                'status' => 'success',
                'data' => $servicos
            ]);
        } catch (\Throwable $e) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Erro ao buscar serviços: ' . $e->getMessage()
            ]);
        }
    }



}