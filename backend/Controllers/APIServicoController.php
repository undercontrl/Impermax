<?php

namespace App\Impermax\Controllers;
use App\Impermax\Database\Database;
use App\Impermax\Models\Servico;
use App\Impermax\Core\ValidaToken;

class APIServicoController{
    private $servicoModel;
    private $chaveAPI;
    public function __construct(){
        $db = Database::getInstance();
        $this->servicoModel = new Servico($db);
        $this->chaveAPI = new ValidaToken();
    }
    
    public function getServicos($pagina=0){
        $this->chaveAPI->ValidaToken();
        //condição ternaria é igual if else
        $registros_por_pagina = $pagina===0 ? 200 : 5;
        $pagina = $pagina===0 ? 1 : (int)$pagina;
        $dados = $this->servicoModel->paginacaoAPI($pagina, $registros_por_pagina);
        
        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'success',
            'data' => $dados
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        exit;
    }

    public function salvarServico(){
        header('content-Type: application/json');
        $servico = json_decode(file_get_contents('php://input'), true);
 
        if (empty($servico) || !is_array($servico)) {
            echo json_encode(['status' => 'error', 'message' => 'Nenhum item recebido no servico.']);
            exit;
        }

        // Se tiver ID, decide entre Excluir ou Atualizar
        if (isset($servico['id_servico'])) {
            // Se o payload indicar exclusão (excluido_em preenchido), deleta (Soft Delete)
            if (isset($servico['excluido_em']) && !empty($servico['excluido_em'])) {
                $sucesso = $this->servicoModel->deletarServicoInterno($servico['id_servico']);
                if ($sucesso) {
                    http_response_code(200);
                    echo json_encode([
                        'status' => 'success', 
                        'message' => 'Serviço excluído com sucesso!', 
                        'id_servico' => $servico['id_servico']
                    ]);
                } else {
                    http_response_code(500);
                    echo json_encode(['status' => 'error', 'message' => 'Erro ao excluir o serviço.']);
                }
            } else {
                // Caso contrário, é um UPDATE
                $sucesso = $this->servicoModel->atualizarServico(
                    (int)$servico['id_servico'],
                    $servico["nome_servico"],
                    $servico["descricao_servico"],
                    $servico["valor_base_servico"],
                    $servico["status_servico"] ?? 'Ativo'
                );

                if ($sucesso) {
                    http_response_code(200);
                    echo json_encode([
                        'status' => 'success', 
                        'message' => 'Serviço atualizado com sucesso!', 
                        'id_servico' => $servico['id_servico']
                    ]);
                } else {
                    http_response_code(500);
                    echo json_encode(['status' => 'error', 'message' => 'Erro ao atualizar o serviço.']);
                }
            }
        } else {
            // Cadastro de novo serviço
            $novoServicoId = $this->servicoModel->inserirServicoAPI(
                $servico["nome_servico"],
                $servico["descricao_servico"],
                $servico["valor_base_servico"],
                $servico["status_servico"] ?? 'Ativo'
            );

            if ($novoServicoId) {
                http_response_code(201);
                echo json_encode([
                    'status' => 'success', 
                    'message' => 'cadastrado com sucesso!', 
                    'id_servico' => $novoServicoId
                ]);
            } else {
                http_response_code(500);
                echo json_encode([
                    'status' => 'error', 
                    'message' => 'Ocorreu um erro ao processar o seu servico'
                ]);
            }
        }
    }
}
