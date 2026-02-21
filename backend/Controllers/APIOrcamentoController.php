<?php

namespace App\Impermax\Controllers;
use App\Impermax\Database\Database;
use App\Impermax\Models\Orcamento;
use App\Impermax\Core\ValidaToken;

class APIOrcamentoController{
    private $orcamentoModel;
    private $chaveAPI;
    
    public function __construct(){
        $db = Database::getInstance();
        $this->orcamentoModel = new Orcamento($db);
        $this->chaveAPI = new ValidaToken();
    }
    
    public function getOrcamentos($pagina=0){
         $this->chaveAPI->ValidaToken();
        //condição ternaria é igual if else
        $registros_por_pagina = $pagina===0 ? 200 : 5;
        $pagina = $pagina===0 ? 1 : (int)$pagina;
        $dados = $this->orcamentoModel->paginacaoAPI($pagina, $registros_por_pagina);
        
        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'success',
            'data' => $dados
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        exit;
    }

    public function salvarOrcamento(){
        header('content-Type: application/json');
        $input = file_get_contents('php://input');
        $orcamento = json_decode($input, true);
 
        if (empty($orcamento) || !is_array($orcamento)) {
            echo json_encode(['status' => 'error', 'message' => 'Nenhum item recebido no orcamento.']);
            exit;
        }

        // Se tiver ID, decide entre Excluir ou Atualizar
        if (isset($orcamento['id_orcamento'])) {
            // Se o payload indicar exclusão (excluido_em preenchido), deleta (Soft Delete)
            if (isset($orcamento['excluido_em']) && !empty($orcamento['excluido_em'])) {
                $sucesso = $this->orcamentoModel->excluirOrcamento($orcamento['id_orcamento']);
                if ($sucesso) {
                    http_response_code(200);
                    echo json_encode([
                        'status' => 'success', 
                        'message' => 'Orcamento excluído com sucesso!', 
                        'id_orcamento' => $orcamento['id_orcamento']
                    ]);
                } else {
                    http_response_code(500);
                    echo json_encode(['status' => 'error', 'message' => 'Erro ao excluir o orcamento.']);
                }
            } else {
                // Caso contrário, é um UPDATE
                $sucesso = $this->orcamentoModel->atualizarOrcamento(
                    (int)$orcamento['id_orcamento'],
                    $orcamento['id_cliente'], 
                    $orcamento['descricao_orcamento'], 
                    $orcamento['status_orcamento'], 
                    $orcamento['data_orcamento'],
                    $orcamento['valor_orcamento'],
                    $orcamento['total_item_orcamento']
                );

                if ($sucesso) {
                    http_response_code(200);
                    echo json_encode([
                        'status' => 'success', 
                        'message' => 'Orcamento atualizado com sucesso!', 
                        'id_orcamento' => $orcamento['id_orcamento']
                    ]);
                } else {
                    http_response_code(500);
                    echo json_encode(['status' => 'error', 'message' => 'Erro ao atualizar o orcamento.']);
                }
            }
        } else {
            // Campos: id_cliente, descricao_orcamento, status_orcamento, data_orcamento, valor_orcamento, total_item_orcamento
            $novoOrcamentoId =  $this->orcamentoModel->inserirOrcamento(
                $orcamento['id_cliente'], 
                $orcamento['descricao_orcamento'], 
                $orcamento['status_orcamento'], 
                $orcamento['data_orcamento'],
                $orcamento['valor_orcamento'],
                $orcamento['total_item_orcamento']
            );
            
            if ($novoOrcamentoId) {
                http_response_code(201);
                echo json_encode([
                    'status' => 'success', 
                    'message' => 'Cadastrado com sucesso!', 
                    'id_orcamento' => $novoOrcamentoId
                ]);
            } else {
                http_response_code(500);
                echo json_encode([
                    'status' => 'error', 
                    'message' => 'Ocorreu um erro ao processar o seu orcamento'
                ]);
            }
        }
    }
}
