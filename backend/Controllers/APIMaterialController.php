<?php

namespace App\Impermax\Controllers;
use App\Impermax\Database\Database;
use App\Impermax\Models\Material;
use App\Impermax\Core\ValidaToken;

class APIMaterialController{
    private $materialModel;
    private $chaveAPI;
    
    public function __construct(){
        $db = Database::getInstance();
        $this->materialModel = new Material($db);
        $this->chaveAPI = new ValidaToken();
    }
    
    public function getMateriais($pagina=0){
         $this->chaveAPI->ValidaToken();
        //condição ternaria é igual if else
        $registros_por_pagina = $pagina===0 ? 200 : 5;
        $pagina = $pagina===0 ? 1 : (int)$pagina;
        $dados = $this->materialModel->paginacaoAPI($pagina, $registros_por_pagina);
        
        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'success',
            'data' => $dados
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        exit;
    }

    public function salvarMaterial(){
        header('content-Type: application/json');
        $material = json_decode(file_get_contents('php://input'), true);
 
        if (empty($material) || !is_array($material)) {
            echo json_encode(['status' => 'error', 'message' => 'Nenhum item recebido no material.']);
            exit;
        }
        
        // Adapting to Material model parameters: nome_material, qtd_material, descricao_material, id_servico
        $novoMaterialId = $this->materialModel->inserirMaterial(
            $material["nome_material"],
            $material["qtd_material"],
            $material["descricao_material"],
            $material["id_servico"] ?? null
        );

        if ($novoMaterialId) {
            http_response_code(201);
            echo json_encode([
                'staus' => 'success', 'message' => 'cadastrado com sucesso!', 'id_material' => $novoMaterialId
            ]);
        } else {
            http_response_code(500);
            echo json_encode([
                'staus' => 'error', 'message' => 'Ocorreu um erro ao processar o seu material']);

        }
    }
}
