<?php
namespace App\Impermax\Controllers;

use App\Impermax\Database\Database;
use App\Impermax\Models\Usuario;

class APIUsuarioController{
    private $usuarioModel;
    private $chaveAPI = "E9768D4706F9FF10385A01F911CBA67EDA01ED1FEDE37DDF46B40FC39A9F789B";
    public function __construct(){
        $db = Database::getInstance();
        $this->usuarioModel = new Usuario($db);
    }

    private function buscaChaveAPI(){
        $headers = getallheaders();
        $token = explode(' ', $headers['Authorization'] ?? '')[1] ?? null;
        return $token === $this->chaveAPI;
    }

    public function getUsuarios($pagina=0) {
        if(!$this->buscaChaveAPI()){
            http_response_code(500);
            echo json_encode([
                'status' => 'error',
                'message' => 'Acesso não autorizado. Chave API inválida.'
            ]);
            exit;
        }
        $registros_por_pagina = $pagina===0 ? 100 : 5;
        $pagina = $pagina===0 ? 1 : (int)$pagina;
        $dados = $this->usuarioModel->paginacaoAPI($pagina, $registros_por_pagina);
        foreach ($dados['data'] as &$usuario) {
            unset($usuario['senha_usuario']);
        }
        header('Content-Type: application/json');
        http_response_code(200);
        echo json_encode([
            'status' => 'success',
            'data' => $dados
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        
        exit;
    }

    public function salvarUsuario() {
        header('Content-Type: application/json');
        $usuario = json_decode(file_get_contents('php://input'), true);
        if (empty($usuario) || !is_array($usuario)) {
            echo json_encode(['status' => 'error', 'message' => 'usuario não cadastrado.']);
            exit;
        }
        $novoPedidoId = $this->usuarioModel->inserirUsuario(
            $usuario["nome_usuario"], 
            $usuario["email_usuario"],
            $usuario["senha_usuario"],
            $usuario["tipo_usuario"],
            $usuario["status_usuario"]
        );
        if ($novoPedidoId) {
            http_response_code(201);
            echo json_encode([
                'status' => 'success', 'message' => 'Usuario cadastrado com sucesso!',  'id_pedido' => $novoPedidoId
            ]);
        } else {
            http_response_code(500);
            echo json_encode([
                'status' => 'error', 'message' => 'Ocorreu um erro ao cadastrar o usuario. Tente novamente.'
            ]);
        }
        exit;
    }
}