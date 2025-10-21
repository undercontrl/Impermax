<?php
namespace App\Impermax\Controllers;
use App\Impermax\Models\Pagamento;
use App\Impermax\Database\Database;
use App\Impermax\Core\View;
use App\Impermax\Core\Redirect;
use App\Impermax\Validadores\PagamentoValidador;

class PagamentoController {
    private $pagamento;
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
        $this->pagamento = new Pagamento($this->db);
    }

    public function index() {
        $this->viewListarPagamentos();
    }

public function salvarPagamento() {
    $erros = PagamentoValidador::ValidarEntradas($_POST);
    if (!empty($erros)) {
        Redirect::redirecionarComMensagem("pagamento/criar", "error", implode("<br>", $erros));
        return;
    }

    $total_pago = ($_POST['dinheiro'] ?? 0) + ($_POST['debito'] ?? 0) + ($_POST['credito'] ?? 0) + ($_POST['pix'] ?? 0);
    $status = $this->pagamento->calcularStatus($_POST['total_devedor'], $total_pago);

    if ($this->pagamento->inserirPagamento(
        $_POST["id_cliente"],
        $_POST["total_devedor"],
        $_POST['dinheiro'] ?? 0,
        $_POST['credito'] ?? 0,
        $_POST['debito'] ?? 0,
        $_POST['pix'] ?? 0,
        $status,
        $_POST["data_pagamento"]
    )) {
        Redirect::redirecionarComMensagem("pagamento/listar", "success", "Pagamento cadastrado com sucesso!");
    } else {
        Redirect::redirecionarComMensagem("pagamento/criar", "error", "Erro ao cadastrar pagamento!");
    }
}

public function atualizarPagamento(int $id) {
    // MESMA LÓGICA DO SALVAR
    $total_pago = ($_POST['dinheiro'] ?? 0) + ($_POST['debito'] ?? 0) + ($_POST['credito'] ?? 0) + ($_POST['pix'] ?? 0);
    $status = $this->pagamento->calcularStatus($_POST['total_devedor'], $total_pago);

    if ($this->pagamento->atualizarPagamento(
        $id,
        $_POST["id_cliente"],
        $_POST["total_devedor"],
        $_POST['dinheiro'] ?? 0,
        $_POST['credito'] ?? 0,
        $_POST['debito'] ?? 0,
        $_POST['pix'] ?? 0,
        $status,
        $_POST["data_pagamento"]
    )) {
        Redirect::redirecionarComMensagem("pagamento/listar", "success", "Pagamento atualizado com sucesso!");
    } else {
        Redirect::redirecionarComMensagem("pagamento/editar/{$id}", "error", "Erro ao atualizar pagamento!");
    }
}

    // ✅ DELETAR
    public function deletarPagamento(int $id) {
        if ($this->pagamento->excluirPagamento($id)) {
            Redirect::redirecionarComMensagem("pagamento/listar", "success", "Pagamento excluído com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("pagamento/listar", "error", "Erro ao excluir pagamento!");
        }
    }

    public function viewListarPagamentos() {
        $dados = $this->pagamento->buscarPagamentos();
        View::render("pagamento/index", ["Pagamentos" => $dados]);
    }

    public function viewCriarPagamentos() {
        $clientes = $this->pagamento->getClientes();
        View::render("pagamento/create", ["usuarios" => $clientes]);
    }

    public function viewEditarPagamentos(int $id) {
        $pagamento = $this->pagamento->buscarPagamentoPorID($id);
        $clientes = $this->pagamento->getClientes();
        
        if ($pagamento) {
            View::render("pagamento/edit", [
                "pagamento" => $pagamento,
                "usuarios" => $clientes
            ]);
        } else {
            Redirect::redirecionarComMensagem("pagamento/listar", "error", "Pagamento não encontrado!");
        }
    }

    public function viewExcluirPagamentos(int $id) {
        $pagamento = $this->pagamento->buscarPagamentoPorID($id);
        if ($pagamento) {
            View::render("pagamento/delete", ["pagamento" => $pagamento]);
        } else {
            Redirect::redirecionarComMensagem("pagamento/listar", "error", "Pagamento não encontrado!");
        }
    }
}