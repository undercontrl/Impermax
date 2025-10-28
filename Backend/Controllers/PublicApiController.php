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

    public function getServicos(){
    $dados = $this->servicoModel->listarServicosAtivos();
    
    // Ordenar por ID (ou por nome, se preferir)
    usort($dados, function($a, $b) {
        return $a['id_servico'] <=> $b['id_servico'];
    });

    foreach($dados as &$servico){
        $servico['caminho_imagem'] = '/backend/upload/' . $servico['foto_servico'];
    }
    unset($servico);

    header('Content-Type: application/json');
    echo json_encode([
        'status' => 'success',
        'data' => $dados
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    exit;
}

}