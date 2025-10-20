<?php
namespace App\Impermax\Controllers;

use App\Impermax\Models\Item_Orcamento;
use App\Impermax\Models\Servico;
use App\Impermax\Models\Orcamento;
use App\Impermax\Database\Database;
use App\Impermax\Core\View;
use App\Impermax\Core\Redirect;
use App\Impermax\Validadores\ItemOrcamentoValidador;

class ItemOrcamentoController
{
    private $item_orcamento;
    private $servico;
    private $orcamento;
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
        $this->item_orcamento = new Item_Orcamento($this->db);
        $this->servico = new Servico($this->db);
        $this->orcamento = new Orcamento($this->db);
    }

    // Listagem
    public function viewListarItemOrcamento()
    {
        $itens = $this->item_orcamento->buscarItemOrcamento();
        View::render("item_orcamento/index", ["itens_orcamento" => $itens]);
    }

    // Criar
    public function viewCriarItemOrcamento()
    {
        $orcamentos = $this->orcamento->buscarOrcamentosComCliente(); // com join pra mostrar nome cliente
        $servicos = $this->servico->buscarServicos();

        View::render("item_orcamento/create", [
            "orcamentos" => $orcamentos,
            "servicos" => $servicos
        ]);
    }

    public function salvarItemOrcamento()
    {
        $erros = ItemOrcamentoValidador::ValidarEntradas($_POST);
        if (!empty($erros)) {
            Redirect::redirecionarComMensagem("item_orcamento/criar", "error", implode("<br>", $erros));
        }

        $ok = $this->item_orcamento->inserirItemOrcamento(
            $_POST["id_orcamento"],
            $_POST["id_servico"],
            $_POST["descricao_item_orcamento"],
            $_POST["metragem"],
            $_POST["status_item_orcamento"]
        );

        if ($ok) {
            Redirect::redirecionarComMensagem("item_orcamento/listar", "success", "Item de orçamento criado com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("item_orcamento/criar", "error", "Erro ao criar item de orçamento!");
        }
    }

    // Editar
    public function viewEditarItemOrcamento($id)
    {
        $item = $this->item_orcamento->buscarItemOrcamentoPorId($id);
        $orcamentos = $this->orcamento->buscarOrcamentosComCliente();
        $servicos = $this->servico->buscarServicos();

        View::render("item_orcamento/edit", [
            "item_orcamento" => $item,
            "orcamentos" => $orcamentos,
            "servicos" => $servicos
        ]);
    }

    public function atualizarItemOrcamento($id)
    {
        $ok = $this->item_orcamento->atualizarItemOrcamento(
            $id,
            $_POST["id_orcamento"],
            $_POST["id_servico"],
            $_POST["descricao_item_orcamento"],
            $_POST["metragem"],
            $_POST["status_item_orcamento"]
        );

        if ($ok) {
            Redirect::redirecionarComMensagem("item_orcamento/listar", "success", "Item de orçamento atualizado com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("item_orcamento/editar/$id", "error", "Erro ao atualizar item de orçamento!");
        }
    }

    // Excluir
    public function viewExcluirItemOrcamento($id)
    {
        View::render("item_orcamento/delete", ["id_item_orcamento" => $id]);
    }

    public function deletarItemOrcamento($id)
    {
        $ok = $this->item_orcamento->excluirAgendamento($id);
        if ($ok) {
            Redirect::redirecionarComMensagem("item_orcamento/listar", "success", "Item excluído com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("item_orcamento/listar", "error", "Erro ao excluir item!");
        }
    }
}
