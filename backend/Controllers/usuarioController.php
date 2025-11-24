<?php
namespace App\Impermax\Controllers;

use App\Impermax\Models\Usuario;
use App\Impermax\Database\Database;
use App\Impermax\Core\View;
use App\Impermax\Core\Redirect;
use App\Impermax\Validadores\UsuarioValidador;
use App\Impermax\Controllers\Admin\AdminController;

class UsuarioController extends AdminController
{
    private $usuario;
    private $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = Database::getInstance();
        $this->usuario = new Usuario($this->db);
    }

    // ========== LISTAR COM FILTROS E PAGINAÇÃO ==========
    public function viewListarUsuarios()
    {
        // Captura filtros
        $busca = $_GET['busca'] ?? '';
        $tipo = $_GET['tipo'] ?? '';
        $status = $_GET['status'] ?? '';
        $paginaAtual = (int)($_GET['pagina'] ?? 1);
        $ordenarPor = $_GET['ordem_campo'] ?? 'id_usuario';
        $direcao = $_GET['ordem_direcao'] ?? 'DESC';
        $itensPorPagina = 10;

        // Busca com filtros
        $usuarios = $this->usuario->buscarUsuariosComFiltros(
            $busca, $tipo, $status, $paginaAtual, $itensPorPagina, $ordenarPor, $direcao
        );

        // Conta total
        $totalUsuarios = $this->usuario->contarUsuariosComFiltros($busca, $tipo, $status);

        // Estatísticas
        $stats = $this->usuario->calcularEstatisticas($busca, $tipo, $status);

        // Paginação
        $totalPaginas = ceil($totalUsuarios / $itensPorPagina);
        $inicio = (($paginaAtual - 1) * $itensPorPagina) + 1;
        $fim = min($paginaAtual * $itensPorPagina, $totalUsuarios);

        $paginacao = [
            'pagina_atual' => $paginaAtual,
            'total_paginas' => $totalPaginas,
            'total' => $totalUsuarios,
            'inicio' => $totalUsuarios > 0 ? $inicio : 0,
            'fim' => $fim
        ];

        View::render("usuario/index", [
            "usuarios" => $usuarios,
            "stats" => $stats,
            "paginacao" => $paginacao
        ]);
    }

    // ========== AÇÕES EM MASSA ==========
    public function alterarStatusEmMassa()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            Redirect::redirecionarComMensagem("usuario/listar", "error", "Método inválido!");
            return;
        }

        $idsString = $_POST['ids'] ?? '';
        $novoStatus = $_POST['status'] ?? '';

        if (empty($idsString) || empty($novoStatus)) {
            Redirect::redirecionarComMensagem("usuario/listar", "error", "Dados inválidos!");
            return;
        }

        $ids = array_filter(array_map('intval', explode(',', $idsString)));

        if (empty($ids)) {
            Redirect::redirecionarComMensagem("usuario/listar", "error", "Nenhum item selecionado!");
            return;
        }

        $statusPermitidos = ['Ativo', 'Inativo', 'Pendente'];
        if (!in_array($novoStatus, $statusPermitidos)) {
            Redirect::redirecionarComMensagem("usuario/listar", "error", "Status inválido!");
            return;
        }

        $ok = $this->usuario->alterarStatusEmMassa($ids, $novoStatus);

        if ($ok) {
            Redirect::redirecionarComMensagem(
                "usuario/listar",
                "success",
                count($ids) . " usuário(s) atualizado(s)!"
            );
        } else {
            Redirect::redirecionarComMensagem("usuario/listar", "error", "Erro ao alterar status!");
        }
    }

    public function excluirEmMassa()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            Redirect::redirecionarComMensagem("usuario/listar", "error", "Método inválido!");
            return;
        }

        $idsString = $_POST['ids'] ?? '';
        if (empty($idsString)) {
            Redirect::redirecionarComMensagem("usuario/listar", "error", "Dados inválidos!");
            return;
        }

        $ids = array_filter(array_map('intval', explode(',', $idsString)));

        if (empty($ids)) {
            Redirect::redirecionarComMensagem("usuario/listar", "error", "Nenhum item selecionado!");
            return;
        }

        $ok = $this->usuario->excluirEmMassa($ids);

        if ($ok) {
            Redirect::redirecionarComMensagem(
                "usuario/listar",
                "success",
                count($ids) . " usuário(s) excluído(s)!"
            );
        } else {
            Redirect::redirecionarComMensagem("usuario/listar", "error", "Erro ao excluir!");
        }
    }
    public function alterarStatus($id)
    {
        $novoStatus = $_POST['novo_status'] ?? 'Ativo';
        
        $ok = $this->usuario->alterarStatusUsuario($id, $novoStatus);
        
        if ($ok) {
            Redirect::redirecionarComMensagem(
                "usuario/visualizar/{$id}", 
                "success", 
                "Status alterado com sucesso!"
            );
        } else {
            Redirect::redirecionarComMensagem(
                "usuario/visualizar/{$id}", 
                "error", 
                "Erro ao alterar status!"
            );
        }
    }

    // ========== CRUD ORIGINAL ==========
    public function index()
    {
        $this->viewListarUsuarios();
    }

    public function viewVisualizarUsuario($id)
    {
        $usuario = $this->usuario->buscarUsuarioPorID($id);

        if ($usuario) {
            View::render("usuario/view", ["usuario" => $usuario]);
        } else {
            Redirect::redirecionarComMensagem("usuario/listar", "error", "Usuário não encontrado!");
        }
    }

    public function viewCriarUsuarios()
    {
        View::render("usuario/create");
    }

    public function viewEditarUsuarios($id = null)
    {
        if (!$id) {
            Redirect::redirecionarComMensagem("usuario/listar", "error", "ID do usuário não fornecido.");
            return;
        }

        $usuario = $this->usuario->buscarUsuarioPorID($id);

        if (!$usuario) {
            Redirect::redirecionarComMensagem("usuario/listar", "error", "Usuário não encontrado.");
            return;
        }

        View::render("usuario/edit", ["usuario" => $usuario]);
    }

    public function viewExcluirUsuarios($id)
    {
        $usuario = $this->usuario->buscarUsuarioPorID($id);
        if ($usuario) {
            View::render("usuario/delete", ["usuario" => $usuario]);
        } else {
            Redirect::redirecionarComMensagem("usuario/listar", "error", "Usuário não encontrado!");
        }
    }

    public function salvarUsuario()
    {
        $erros = UsuarioValidador::ValidarEntradas($_POST);
        if (!empty($erros)) {
            Redirect::redirecionarComMensagem("usuario/criar", "error", implode("<br>", $erros));
            return;
        }

        $sucesso = $this->usuario->inserirUsuario(
            $_POST["nome_usuario"],
            $_POST["email_usuario"],
            $_POST["senha_usuario"],
            $_POST["tipo_usuario"],
            "Ativo"
        );

        if ($sucesso) {
            Redirect::redirecionarComMensagem("usuario/listar", "success", "Usuário cadastrado com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("usuario/criar", "error", "Erro ao cadastrar usuário!");
        }
    }

    public function atualizarUsuario($id)
    {
        $erros = UsuarioValidador::ValidarEntradas($_POST);
        if (!empty($erros)) {
            Redirect::redirecionarComMensagem("usuario/editar/{$id}", "error", implode("<br>", $erros));
            return;
        }

        $senha = !empty($_POST["senha_usuario"]) ? $_POST["senha_usuario"] : null;

        if ($this->usuario->atualizarUsuario(
            $id,
            $_POST["nome_usuario"],
            $_POST["email_usuario"],
            $senha,
            $_POST["tipo_usuario"],
            $_POST["status_usuario"]
        )) {
            Redirect::redirecionarComMensagem("usuario/listar", "success", "Usuário atualizado com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("usuario/editar/{$id}", "error", "Erro ao atualizar usuário!");
        }
    }

    public function deletarUsuario($id)
    {
        if ($this->usuario->excluirUsuario($id)) {
            Redirect::redirecionarComMensagem("usuario/listar", "success", "Usuário excluído com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("usuario/listar", "error", "Erro ao excluir usuário!");
        }
    }

    public function relatorioUsuario($id, $dataInicial, $dataFinal)
    {
        View::render("usuario/relatorio", [
            "id" => $id,
            "dataInicial" => $dataInicial,
            "dataFinal" => $dataFinal
        ]);
    }
}