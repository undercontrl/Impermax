<?php

namespace App\Impermax\Controllers;
use App\Impermax\Database\Database;
use App\Impermax\Models\Pagamento;
use App\Impermax\Core\ValidaToken;

class APIPagamentoController{
    private $pagamentoModel;
    private $chaveAPI;
    public function __construct(){
        $db = Database::getInstance();
        $this->pagamentoModel = new Pagamento($db);
        $this->chaveAPI = new ValidaToken();
    }

    public function getPagamentos($pagina=0){
         $this->chaveAPI->ValidaToken();
        //condição ternaria é igual if else
        $registros_por_pagina = $pagina===0 ? 200 : 5;
        $pagina = $pagina===0 ? 1 : (int)$pagina;
        $dados = $this->pagamentoModel->paginacaoAPI($pagina, $registros_por_pagina);
        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'success',
            'data' => $dados
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        exit;
    }

    public function salvarPagamento(){
        header('content-Type: application/json');
        $input = file_get_contents('php://input');
        $pagamento = json_decode($input, true);
 
        if (empty($pagamento) || !is_array($pagamento)) {
            echo json_encode(['status' => 'error', 'message' => 'Nenhum item recebido no pagamento.']);
            exit;
        }

        // Se tiver ID, deleta. Senão, insere.
        if (isset($pagamento['id_pagamento'])) {
            $sucesso = $this->pagamentoModel->excluirPagamento($pagamento['id_pagamento']);
            if ($sucesso) {
                http_response_code(200);
                echo json_encode([
                    'status' => 'success', 
                    'message' => 'Pagamento excluído com sucesso!', 
                    'id_pagamento' => $pagamento['id_pagamento']
                ]);
            } else {
                http_response_code(500);
                echo json_encode([
                    'status' => 'error', 
                    'message' => 'Erro ao excluir o pagamento.'
                ]);
            }
        } else {
            $novoPagamentoId = $this->pagamentoModel->inserirPagamento(
                $pagamento["id_cliente"],
                $pagamento["total_devedor"],
                $pagamento["dinheiro"],
                $pagamento["credito"],
                $pagamento["debito"],
                $pagamento["pix"],
                $pagamento["status_pagamento"],
                $pagamento["data_pagamento"]
            );
            
            if ($novoPagamentoId) {
                http_response_code(201);
                echo json_encode([
                    'status' => 'success', 
                    'message' => 'Cadastrado com sucesso!', 
                    'id_pagamento' => $novoPagamentoId
                ]);
            } else {
                http_response_code(500);
                echo json_encode([
                    'status' => 'error', 
                    'message' => 'Ocorreu um erro ao processar o seu pagamento'
                ]);
            }
        }
    }





}