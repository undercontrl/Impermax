<?php
namespace App\Impermax\Controllers;

use App\Impermax\Models\Orcamento;
use App\Impermax\Database\Database;
use App\Impermax\Core\View;
use App\Impermax\Core\Redirect;
use App\Impermax\Validadores\OrcamentoValidador;
use App\Impermax\Core\EmailNotification;

class OrcamentoController
{
    private $orcamento;
    private $db;
    private EmailNotification $emailNotification;

    public function __construct()
    {
        $this->db = Database::getInstance();
        $this->orcamento = new Orcamento($this->db);
        $this->emailNotification = new EmailNotification();
    }

    // ========== LISTAR COM FILTROS E PAGINAÇÃO ==========
    public function viewListarOrcamentos()
    {
        // Captura filtros
        $busca = $_GET['busca'] ?? '';
        $status = $_GET['status'] ?? '';
        $periodo = $_GET['periodo'] ?? '';
        $paginaAtual = (int)($_GET['pagina'] ?? 1);
        $ordenarPor = $_GET['ordem_campo'] ?? 'id_orcamento';
        $direcao = $_GET['ordem_direcao'] ?? 'DESC';
        $itensPorPagina = 10;

        // Busca com filtros
        $orcamentos = $this->orcamento->buscarOrcamentosComFiltros(
            $busca, $status, $periodo, $paginaAtual, $itensPorPagina, $ordenarPor, $direcao
        );

        // Conta total
        $totalOrcamentos = $this->orcamento->contarOrcamentosComFiltros($busca, $status, $periodo);

        // Estatísticas
        $stats = $this->orcamento->calcularEstatisticas($busca, $status, $periodo);

        // Paginação
        $totalPaginas = ceil($totalOrcamentos / $itensPorPagina);
        $inicio = (($paginaAtual - 1) * $itensPorPagina) + 1;
        $fim = min($paginaAtual * $itensPorPagina, $totalOrcamentos);

        $paginacao = [
            'pagina_atual' => $paginaAtual,
            'total_paginas' => $totalPaginas,
            'total' => $totalOrcamentos,
            'inicio' => $totalOrcamentos > 0 ? $inicio : 0,
            'fim' => $fim
        ];

        View::render("orcamento/index", [
            "orcamentos" => $orcamentos,
            "stats" => $stats,
            "paginacao" => $paginacao
        ]);
    }

    // ========== AÇÕES EM MASSA ==========
    public function alterarStatusEmMassa()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            Redirect::redirecionarComMensagem("orcamento/listar", "error", "Método inválido!");
            return;
        }

        $idsString = $_POST['ids'] ?? '';
        $novoStatus = $_POST['status'] ?? '';

        if (empty($idsString) || empty($novoStatus)) {
            Redirect::redirecionarComMensagem("orcamento/listar", "error", "Dados inválidos!");
            return;
        }

        $ids = array_filter(array_map('intval', explode(',', $idsString)));

        if (empty($ids)) {
            Redirect::redirecionarComMensagem("orcamento/listar", "error", "Nenhum item selecionado!");
            return;
        }

        $statusPermitidos = ['aprovado', 'aguardando', 'recusado', 'em_analise'];
        if (!in_array($novoStatus, $statusPermitidos)) {
            Redirect::redirecionarComMensagem("orcamento/listar", "error", "Status inválido!");
            return;
        }

        $ok = $this->orcamento->alterarStatusEmMassa($ids, $novoStatus);

        if ($ok) {
            Redirect::redirecionarComMensagem(
                "orcamento/listar",
                "success",
                count($ids) . " orçamento(s) atualizado(s)!"
            );
        } else {
            Redirect::redirecionarComMensagem("orcamento/listar", "error", "Erro ao alterar status!");
        }
    }

    public function excluirEmMassa()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            Redirect::redirecionarComMensagem("orcamento/listar", "error", "Método inválido!");
            return;
        }

        $idsString = $_POST['ids'] ?? '';
        if (empty($idsString)) {
            Redirect::redirecionarComMensagem("orcamento/listar", "error", "Dados inválidos!");
            return;
        }

        $ids = array_filter(array_map('intval', explode(',', $idsString)));

        if (empty($ids)) {
            Redirect::redirecionarComMensagem("orcamento/listar", "error", "Nenhum item selecionado!");
            return;
        }

        $ok = $this->orcamento->excluirEmMassa($ids);

        if ($ok) {
            Redirect::redirecionarComMensagem(
                "orcamento/listar",
                "success",
                count($ids) . " orçamento(s) excluído(s)!"
            );
        } else {
            Redirect::redirecionarComMensagem("orcamento/listar", "error", "Erro ao excluir!");
        }
    }

    // ========== CRUD ORIGINAL ==========
    public function index()
    {
        $this->viewListarOrcamentos();
    }

    public function viewVisualizarOrcamento(int $id)
    {
        $orcamento = $this->orcamento->buscarOrcamentoPorID($id);
        
        if ($orcamento) {
            View::render("orcamento/view", ["orcamento" => $orcamento]);
        } else {
            Redirect::redirecionarComMensagem("orcamento/listar", "error", "Orçamento não encontrado!");
        }
    }

    public function viewCriarOrcamentos()
    {
        $clientes = $this->orcamento->getClientes();
        View::render("orcamento/create", ["usuarios" => $clientes]);
    }

    public function viewEditarOrcamentos(int $id)
    {
        $orcamento = $this->orcamento->buscarOrcamentoPorID($id);
        $clientes = $this->orcamento->getClientes();

        if ($orcamento) {
            View::render("orcamento/edit", [
                "orcamento" => $orcamento,
                "usuarios" => $clientes
            ]);
        } else {
            Redirect::redirecionarComMensagem("orcamento/listar", "error", "Orçamento não encontrado!");
        }
    }

    public function viewExcluirOrcamentos(int $id)
    {
        $orcamento = $this->orcamento->buscarOrcamentoPorID($id);
        if ($orcamento) {
            View::render("orcamento/delete", ["orcamento" => $orcamento]);
        } else {
            Redirect::redirecionarComMensagem("orcamento/listar", "error", "Orçamento não encontrado!");
        }
    }

    public function salvarOrcamento()
    {
        $erros = OrcamentoValidador::ValidarEntradas($_POST);
        if (!empty($erros)) {
            Redirect::redirecionarComMensagem("orcamento/criar", "error", implode("<br>", $erros));
            return;
        }

        if ($this->orcamento->inserirOrcamento(
            $_POST["id_cliente"],
            $_POST["descricao_orcamento"],
            $_POST["status_orcamento"],
            $_POST["data_orcamento"],
            $_POST["valor_orcamento"],
            $_POST["total_item_orcamento"]
        )) {
            Redirect::redirecionarComMensagem("orcamento/listar", "success", "Orçamento cadastrado com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("orcamento/criar", "error", "Erro ao cadastrar orçamento!");
        }
    }

    public function atualizarOrcamento(int $id)
    {
        $erros = OrcamentoValidador::ValidarEntradas($_POST);
        if (!empty($erros)) {
            Redirect::redirecionarComMensagem("orcamento/editar/{$id}", "error", implode("<br>", $erros));
            return;
        }
        if ($this->orcamento->atualizarOrcamento(
            $id,
            $_POST["id_cliente"],
            $_POST["descricao_orcamento"],
            $_POST["status_orcamento"],
            $_POST["data_orcamento"],
            $_POST["valor_orcamento"],
            $_POST["total_item_orcamento"]
        )) {
            if($_POST["status_orcamento"] === 'aprovado') {
                // aqui a função de notificação de email
                $orcamento = $this->orcamento->buscarOrcamentoPorID($id);
                $email = $orcamento['email_usuario'] ?? '';
                $nome = $orcamento['nome_cliente'] ?? '';
                $numeroOrcamento = $orcamento['id_orcamento'] ?? '';
                $valor = $orcamento['valor_orcamento'] ?? 0;
                
                $this->emailNotification->orcamentoAprovado($email, $nome, $numeroOrcamento, $valor);
            }
            Redirect::redirecionarComMensagem("orcamento/listar", "success", "Orçamento atualizado com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("orcamento/editar/{$id}", "error", "Erro ao atualizar orçamento!");
        }
    }

    // public function atualizarOrcamentoComNotificacao(int $id)
    // {
    //     $erros = OrcamentoValidador::ValidarEntradas($_POST);
    //     if (!empty($erros)) {
    //         Redirect::redirecionarComMensagem("orcamento/editar/{$id}", "error", implode("<br>", $erros));
    //         return;
    //     }

    //     $statusAtualizado = $_POST["status_orcamento"] ?? '';

    //     if ($this->orcamento->atualizarOrcamento(
    //         $id,
    //         $_POST["id_cliente"],
    //         $_POST["descricao_orcamento"],
    //         $statusAtualizado,
    //         $_POST["data_orcamento"],
    //         $_POST["valor_orcamento"],
    //         $_POST["total_item_orcamento"]
    //     )) {
    //         if ($statusAtualizado === 'aprovado') {
    //             // aqui a função de notificação de email
    //             $orcamento = $this->orcamento->buscarOrcamentoPorID($id);
    //             $email = $orcamento['email_cliente'] ?? '';
    //             $nome = $orcamento['nome_cliente'] ?? '';
    //             $numeroOrcamento = $orcamento['id_orcamento'] ?? '';
    //             $valor = $orcamento['valor_orcamento'] ?? 0;

    //             $this->emailNotification->orcamentoAprovado($email, $nome, $numeroOrcamento, $valor);
    //         }
    //         Redirect::redirecionarComMensagem("orcamento/listar", "success", "Orçamento atualizado com sucesso!");
    //     } else {
    //         Redirect::redirecionarComMensagem("orcamento/editar/{$id}", "error", "Erro ao atualizar orçamento!");
    //     }
    // }

    public function deletarOrcamento(int $id)
    {
        if ($this->orcamento->excluirOrcamento($id)) {
            Redirect::redirecionarComMensagem("orcamento/listar", "success", "Orçamento excluído com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("orcamento/listar", "error", "Erro ao excluir orçamento!");
        }
    }
}