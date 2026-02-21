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
        $input = file_get_contents('php://input');
        $material = json_decode($input, true);
 
        if (empty($material) || !is_array($material)) {
            echo json_encode(['status' => 'error', 'message' => 'Nenhum item recebido no material.']);
            exit;
        }

        // Se tiver ID, decide entre Excluir ou Atualizar
        if (isset($material['id_material'])) {
            // Se o payload indicar exclusão (excluido_em preenchido), deleta (Soft Delete)
            if (isset($material['excluido_em']) && !empty($material['excluido_em'])) {
                $sucesso = $this->materialModel->excluirMaterial($material['id_material']);
                if ($sucesso) {
                    http_response_code(200);
                    echo json_encode([
                        'status' => 'success', 
                        'message' => 'Material excluído com sucesso!', 
                        'id_material' => $material['id_material']
                    ]);
                } else {
                    http_response_code(500);
                    echo json_encode(['status' => 'error', 'message' => 'Erro ao excluir o material.']);
                }
            } else {
                // Caso contrário, é um UPDATE
                $sucesso = $this->materialModel->atualizarMaterial(
                    (int)$material['id_material'],
                    $material['nome_material'],
                    $material['qtd_material'],
                    $material['descricao_material'],
                    $material['id_servico']
                );

                if ($sucesso) {
                    http_response_code(200);
                    echo json_encode([
                        'status' => 'success', 
                        'message' => 'Material atualizado com sucesso!', 
                        'id_material' => $material['id_material']
                    ]);
                } else {
                    http_response_code(500);
                    echo json_encode(['status' => 'error', 'message' => 'Erro ao atualizar the material.']);
                }
            }
        } else {
            $novoMaterialId =  $this->materialModel->inserirMaterial(
                $material['nome_material'], 
                $material['qtd_material'], 
                $material['descricao_material'], 
                $material['id_servico']
            );
            
            if ($novoMaterialId) {
                http_response_code(201);
                echo json_encode([
                    'status' => 'success', 
                    'message' => 'Cadastrado com sucesso!', 
                    'id_material' => $novoMaterialId
                ]);
            } else {
                http_response_code(500);
                echo json_encode([
                    'status' => 'error', 
                    'message' => 'Ocorreu um erro ao processar o seu material'
                ]);
            }
        }
    }
}
