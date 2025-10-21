<?php
namespace App\Impermax\Controllers;
use App\Impermax\Models\Orcamento;
use App\Impermax\Database\Database;
use App\Impermax\Core\View;
use App\Impermax\Core\Redirect;
use App\Impermax\Validadores\OrcamentoValidador;
use App\Impermax\Models\usuario;

class OrcamentoController {  // ✅ MAIÚSCULA
    private $orcamento;
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
        $this->orcamento = new Orcamento($this->db);  // ✅ MAIÚSCULA
    }

    public function index() {
        $this->viewListarOrcamentos();
    }

    // ✅ SALVAR
    public function salvarOrcamento() {
        $erros = OrcamentoValidador::ValidarEntradas($_POST);  // ✅ MAIÚSCULA
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

    // ✅ ATUALIZAR
    public function atualizarOrcamento(int $id) {
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
            Redirect::redirecionarComMensagem("orcamento/listar", "success", "Orçamento atualizado com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("orcamento/editar/{$id}", "error", "Erro ao atualizar orçamento!");
        }
    }

    public function viewExcluirOrcamentos(int $id) {
    $orcamento = $this->orcamento->buscarOrcamentoPorID($id);
    if ($orcamento) {
        View::render("orcamento/delete", ["orcamento" => $orcamento]);
    } else {
        Redirect::redirecionarComMensagem("orcamento/listar", "error", "Orçamento não encontrado!");
    }
}

    public function deletarOrcamento(int $id) {
    if ($this->orcamento->excluirOrcamento($id)) {
        Redirect::redirecionarComMensagem("orcamento/listar", "success", "Orçamento excluído com sucesso!");
    } else {
        Redirect::redirecionarComMensagem("orcamento/listar", "error", "Erro ao excluir orçamento!");
    }
}

    public function viewListarOrcamentos() {
        $dados = $this->orcamento->buscarOrcamentos();
        View::render("orcamento/index", ["orcamentos" => $dados]);
    }

    public function viewCriarOrcamentos() {
        $clientes = $this->orcamento->getClientes();
        View::render("orcamento/create", ["usuarios" => $clientes]);
    }

    public function viewEditarOrcamentos(int $id) {
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

}