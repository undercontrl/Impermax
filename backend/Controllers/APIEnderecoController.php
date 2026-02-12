<?php

namespace App\Impermax\Controllers;
use App\Impermax\Database\Database;
use App\Impermax\Models\Endereco;
use App\Impermax\Core\ValidaToken;

class APIEnderecoController{
    private $enderecoModel;
    private $chaveAPI;
    
    public function __construct(){
        $db = Database::getInstance();
        $this->enderecoModel = new Endereco($db);
        $this->chaveAPI = new ValidaToken();
    }
    
    public function getEnderecos($pagina=0){
         $this->chaveAPI->ValidaToken();
        //condição ternaria é igual if else
        $registros_por_pagina = $pagina===0 ? 200 : 5;
        $pagina = $pagina===0 ? 1 : (int)$pagina;
        $dados = $this->enderecoModel->paginacaoAPI($pagina, $registros_por_pagina);
        
        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'success',
            'data' => $dados
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        exit;
    }

    public function salvarEndereco(){
        header('content-Type: application/json');
        $input = file_get_contents('php://input');
        $endereco = json_decode($input, true);
 
        if (empty($endereco) || !is_array($endereco)) {
            echo json_encode(['status' => 'error', 'message' => 'Nenhum dado recebido no endereço.']);
            exit;
        }

        // Se tiver ID, deleta. Senão, insere.
        if (isset($endereco['id_endereco'])) {
            $sucesso = $this->enderecoModel->excluirEndereco($endereco['id_endereco']);
            if ($sucesso) {
                http_response_code(200);
                echo json_encode([
                    'status' => 'success', 
                    'message' => 'Endereço excluído com sucesso!', 
                    'id_endereco' => $endereco['id_endereco']
                ]);
            } else {
                http_response_code(500);
                echo json_encode([
                    'status' => 'error', 
                    'message' => 'Erro ao excluir o endereço.'
                ]);
            }
        } else {
            // function inserirEndereco($id_usuario, $cep_endereco, $logadouro_endereco, $numero_endereco, $complemento_endereco, $bairro_endereco, $cidade_endereco, $uf_endereco)
            // Validar campos obrigatórios se necessário, ou passar null/vazio conforme lógica
            
            $id_usuario = $endereco['id_usuario'] ?? null;
            $cep_endereco = $endereco['cep_endereco'] ?? null;
            $logadouro_endereco = $endereco['logadouro_endereco'] ?? null;
            $numero_endereco = $endereco['numero_endereco'] ?? null;
            $complemento_endereco = $endereco['complemento_endereco'] ?? null;
            $bairro_endereco = $endereco['bairro_endereco'] ?? null;
            $cidade_endereco = $endereco['cidade_endereco'] ?? null;
            $uf_endereco = $endereco['uf_endereco'] ?? null;

            $novoEnderecoId =  $this->enderecoModel->inserirEndereco(
                $id_usuario, 
                $cep_endereco, 
                $logadouro_endereco, 
                $numero_endereco, 
                $complemento_endereco, 
                $bairro_endereco, 
                $cidade_endereco, 
                $uf_endereco
            );
            
            if ($novoEnderecoId) {
                http_response_code(201);
                echo json_encode([
                    'status' => 'success', 
                    'message' => 'Endereço cadastrado com sucesso!', 
                    'id_endereco' => $novoEnderecoId
                ]);
            } else {
                http_response_code(500);
                echo json_encode([
                    'status' => 'error', 
                    'message' => 'Ocorreu um erro ao processar o seu endereço'
                ]);
            }
        }
    }
}
