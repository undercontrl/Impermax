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
    $db = Database::getInstance();
    $model = new \App\Impermax\Models\Servico($db);
    $dados = $model->listarAtivosParaSite();

    foreach($dados as &$s){
        $s['caminho_imagem'] = '/backend/upload/' . $s['foto_servico'];
    }
    unset($s);

    header('Content-Type: application/json');
    echo json_encode(['status' => 'success', 'data' => $dados], JSON_UNESCAPED_SLASHES);
    exit;
}

}