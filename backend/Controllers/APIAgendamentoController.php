<?php

namespace App\Impermax\Controllers;
use App\Impermax\Database\Database;
use App\Impermax\Models\Agendamento;
use App\Impermax\Core\ValidaToken;

class APIAgendamentoController{
    private $agendamentoModel;
    private $chaveAPI;
    
    public function __construct(){
        $db = Database::getInstance();
        $this->agendamentoModel = new Agendamento($db);
        $this->chaveAPI = new ValidaToken();
    }
    
    public function getAgendamentos($pagina=0){
         $this->chaveAPI->ValidaToken();
        //condição ternaria é igual if else
        $registros_por_pagina = $pagina===0 ? 200 : 5;
        $pagina = $pagina===0 ? 1 : (int)$pagina;
        $dados = $this->agendamentoModel->paginacaoAPI($pagina, $registros_por_pagina);
        
        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'success',
            'data' => $dados
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        exit;
    }

    public function salvarAgendamento(){
        header('content-Type: application/json');
        $input = file_get_contents('php://input');
        $agendamento = json_decode($input, true);
 
        if (empty($agendamento) || !is_array($agendamento)) {
            echo json_encode(['status' => 'error', 'message' => 'Nenhum item recebido no agendamento.']);
            exit;
        }

        // Se tiver ID, decide entre Excluir ou Atualizar
        if (isset($agendamento['id_agendamento'])) {
            // Se o payload indicar exclusão (excluido_em preenchido), deleta (Soft Delete)
            if (isset($agendamento['excluido_em']) && !empty($agendamento['excluido_em'])) {
                $sucesso = $this->agendamentoModel->excluirAgendamento($agendamento['id_agendamento']);
                if ($sucesso) {
                    http_response_code(200);
                    echo json_encode([
                        'status' => 'success', 
                        'message' => 'Agendamento excluído com sucesso!', 
                        'id_agendamento' => $agendamento['id_agendamento']
                    ]);
                } else {
                    http_response_code(500);
                    echo json_encode(['status' => 'error', 'message' => 'Erro ao excluir o agendamento.']);
                }
            } else {
                // Caso contrário, é um UPDATE
                // Campos necessários para atualizarAgendamento: id, id_cliente, data_solicitada, total_agendamento, status_agendamento
                $sucesso = $this->agendamentoModel->atualizarAgendamento(
                    (int)$agendamento['id_agendamento'],
                    $agendamento['id_cliente'],
                    $agendamento['data_solicitada'],
                    $agendamento['total_agendamento'],
                    $agendamento['status_agendamento']
                );

                if ($sucesso) {
                    http_response_code(200);
                    echo json_encode([
                        'status' => 'success', 
                        'message' => 'Agendamento atualizado com sucesso!', 
                        'id_agendamento' => $agendamento['id_agendamento']
                    ]);
                } else {
                    http_response_code(500);
                    echo json_encode(['status' => 'error', 'message' => 'Erro ao atualizar o agendamento.']);
                }
            }
        } else {
            // Campos: id_cliente, data_solicitada, total_agendamento, status_agendamento
            $novoAgendamentoId =  $this->agendamentoModel->inserirAgendamento(
                $agendamento['id_cliente'], 
                $agendamento['data_solicitada'], 
                $agendamento['total_agendamento'], 
                $agendamento['status_agendamento']
            );
            
            if ($novoAgendamentoId) {
                // Salvar orçamentos vinculados se existirem no payload
                if (!empty($agendamento['orcamentos'])) {
                    $db = Database::getInstance();
                    foreach ($agendamento['orcamentos'] as $id_orcamento) {
                        $sql = "INSERT INTO tbl_agendamento_orcamento (id_agendamento, id_orcamento) 
                                VALUES (:id_agendamento, :id_orcamento)";
                        $stmt = $db->prepare($sql);
                        $stmt->bindParam(':id_agendamento', $novoAgendamentoId);
                        $stmt->bindParam(':id_orcamento', $id_orcamento);
                        $stmt->execute();
                    }
                }

                http_response_code(201);
                echo json_encode([
                    'status' => 'success', 
                    'message' => 'Cadastrado com sucesso!', 
                    'id_agendamento' => $novoAgendamentoId
                ]);
            } else {
                http_response_code(500);
                echo json_encode([
                    'status' => 'error', 
                    'message' => 'Ocorreu um erro ao processar o seu agendamento'
                ]);
            }
        }
    }
}
