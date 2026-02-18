<?php

namespace App\Impermax\Controllers;
use App\Impermax\Database\Database;
use App\Impermax\Models\Usuario;
use App\Impermax\Core\ValidaToken;

class APIUsuarioController{
    private $usuarioModel;
    private $chaveAPI;
    public function __construct(){
        $db = Database::getInstance();
        $this->usuarioModel = new Usuario($db);
        $this->chaveAPI = new ValidaToken();
    }
    
    public function getUsuarios($pagina=0){
         $this->chaveAPI->ValidaToken();
        //condição ternaria é igual if else
        $registros_por_pagina = $pagina===0 ? 200 : 5;
        $pagina = $pagina===0 ? 1 : (int)$pagina;
        $dados = $this->usuarioModel->paginacaoAPI($pagina, $registros_por_pagina);
        foreach($dados['data'] as &$usuario){
        unset($usuario['senha_usuario']);
        }
        unset($usuario);
        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'success',
            'data' => $dados
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        exit;
    }

    public function salvarUsuario(){
        header('content-Type: application/json');
        $usuario = json_decode(file_get_contents('php://input'), true);
 
        if (empty($usuario) || !is_array($usuario)) {
            echo json_encode(['status' => 'error', 'message' => 'Nenhum item recebido no usuario.']);
            exit;
        }

        // Se tiver ID, decide entre Excluir ou Atualizar
        if (isset($usuario['id_usuario'])) {
             // Se o payload indicar exclusão (excluido_em preenchido), deleta (Soft Delete)
             if (isset($usuario['excluido_em']) && !empty($usuario['excluido_em'])) {
                $sucesso = $this->usuarioModel->deletarUsuario($usuario['id_usuario']);
                if ($sucesso) {
                    http_response_code(200);
                    echo json_encode([
                        'status' => 'success', 
                        'message' => 'Usuário excluído com sucesso!', 
                        'id_usuario' => $usuario['id_usuario']
                    ]);
                } else {
                    http_response_code(500);
                    echo json_encode(['status' => 'error', 'message' => 'Erro ao excluir o usuário.']);
                }
            } else {
                // Caso contrário, é um UPDATE
                $sucesso = $this->usuarioModel->atualizarUsuario(
                    (int)$usuario['id_usuario'],
                    $usuario["nome_usuario"],
                    $usuario["email_usuario"],
                    $usuario["senha_usuario"] ?? '',
                    $usuario["tipo_usuario"],
                    $usuario["status_usuario"]
                );

                if ($sucesso) {
                    http_response_code(200);
                    echo json_encode([
                        'status' => 'success', 
                        'message' => 'Usuário atualizado com sucesso!', 
                        'id_usuario' => $usuario['id_usuario']
                    ]);
                } else {
                    http_response_code(500);
                    echo json_encode(['status' => 'error', 'message' => 'Erro ao atualizar o usuário.']);
                }
            }
        } else {
            $novoUsuarioId = $this->usuarioModel->inserirUsuario(
                $usuario["nome_usuario"],
                $usuario["email_usuario"],
                $usuario["senha_usuario"],
                $usuario["tipo_usuario"],
                $usuario["status_usuario"],
            );
            if ($novoUsuarioId) {
                http_response_code(201);
                echo json_encode([
                    'status' => 'success', 'message' => 'cadastrado com sucesso!', 'id_usuario' => $novoUsuarioId
                ]);
            } else {
                http_response_code(500);
                echo json_encode([
                    'status' => 'error', 'message' => 'Ocorreu um erro ao processar o seu usuário']);
            }
        }
    }





}