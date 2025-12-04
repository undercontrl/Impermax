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
        $pagamento = json_decode(file_get_contents('php://input'), true);
 
        if (empty($pagamento) || !is_array($pagamento)) {
            echo json_encode(['status' => 'error', 'message' => 'Nenhum item recebido no pagamento.']);
            exit;
        }
        $novoPagamento = $this->pagamentoModel->inserirPagamento(
            $pagamento["id_cliente"],
            $pagamento["total_devedor"],
            $pagamento["dinheiro"],
            $pagamento["credito"],
            $pagamento["debito"],
            $pagamento["pix"],
            $pagamento["status_pagamento"],
            $pagamento["data_pagamento"],

        );
        if ($novoPagamento) {
            http_response_code(201);
            echo json_encode([
                'staus' => 'success', 'message' => 'cadastrado com sucesso!', 'id_pedido' => $novoPagamento
            ]);
        } else {
            http_response_code(500);
            echo json_encode([
                'staus' => 'error', 'message' => 'Ocorreu um erro ao processar o seu produto']);

        }
    }





}