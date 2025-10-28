<?php

namespace App\Impermax\Controllers;

use App\Impermax\Models\ServicoSite;
use App\Impermax\Database\Database;

class PublicApiController{
    private $servicoModel;
    public function __construct(){
        $db = Database::getInstance();
        $this->servicoModel = new ServicoSite($db);
    }

    public function getServicos(){
    $model = $this->servicoModel;
    
    // Usa o método que já filtra por 'Ativo'
    $dados = $model->listarAtivos(); // ← ESTE MÉTODO JÁ FILTRA!

    foreach($dados as &$s){
        $s['caminho_imagem'] = '/backend/upload/' . $s['foto_servico'];
    }
    unset($s);

    header('Content-Type: application/json');
    echo json_encode([
        'status' => 'success',
        'data' => $dados
    ], JSON_UNESCAPED_SLASHES);
    exit;
}

}