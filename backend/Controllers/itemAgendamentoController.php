<?php
namespace App\Impermax\Controllers;

use App\Impermax\Models\item_agendamento;
use App\Impermax\Models\agendamento;
use App\Impermax\Models\servico;
use App\Impermax\Models\usuario;
use App\Impermax\Database\Database;
use App\Impermax\Core\View;
use App\Impermax\Core\Redirect;
use App\Impermax\Validadores\ItemAgendamentoValidador;

class ItemAgendamentoController
{
    private $itemAgendamento;
    private $agendamento;
    private $servico;
    private $usuario;
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
        $this->itemAgendamento = new item_agendamento($this->db);
        $this->agendamento = new agendamento($this->db);
        $this->servico = new servico($this->db);
        $this->usuario = new usuario($this->db);
    }

    // Listar itens de agendamento
    public function viewListarItemAgendamento()
    {
        $itens = $this->itemAgendamento->buscarItemAgendamentos();
        View::render("item_agendamento/index", ["itens" => $itens]);
    }

    //  Criar novo item de agendamento
    public function viewCriarItemAgendamento()
    {
        $agendamentos = $this->agendamento->buscarAgendamentos();
        $servicos = $this->servico->buscarServicos();
        $usuarios = $this->usuario->buscarUsuarios();

        View::render("item_agendamento/create", [
            "agendamentos" => $agendamentos,
            "servicos" => $servicos,
            "usuarios" => $usuarios
        ]);
    }

    public function viewEditarItemAgendamento($id)
    {
        $item = $this->itemAgendamento->buscarItemAgendamentoPorId($id);
        $agendamentos = $this->agendamento->buscarAgendamentos();
        $servicos = $this->servico->buscarServicos();
        $usuarios = $this->usuario->buscarUsuarios();

        View::render("item_agendamento/edit", [
            "item" => $item,
            "agendamentos" => $agendamentos,
            "servicos" => $servicos,
            "usuarios" => $usuarios
        ]);
    }

    public function viewExcluirItemAgendamento($id)
    {
        View::render("item_agendamento/delete", ["id_item_agendamento" => $id]);
    }

    //  Salvar novo item
    public function salvarItemAgendamento()
    {
        $erros = ItemAgendamentoValidador::ValidarEntradas($_POST);
        if (!empty($erros)) {
            Redirect::redirecionarComMensagem("item_agendamento/criar", "error", implode("<br>", $erros));
        }

        $ok = $this->itemAgendamento->inserirItemAgendamento(
            $_POST["id_agendamento"],
            $_POST["id_servico"],
            $_POST["valor_servico"],
            $_POST["qtde_solicitada"],
            $_POST["total_item"],
            $_POST["id_responsavel"]
        );

        if ($ok) {
            Redirect::redirecionarComMensagem("item_agendamento/listar", "success", "Item de agendamento cadastrado com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("item_agendamento/criar", "error", "Erro ao cadastrar item de agendamento!");
        }
    }

    // Atualizar item existente
    public function atualizarItemAgendamento()
    {
        $erros = ItemAgendamentoValidador::ValidarEntradas($_POST);
        if (!empty($erros)) {
            Redirect::redirecionarComMensagem("item_agendamento/editar/{id}", "error", implode("<br>", $erros));
        }

        $ok = $this->itemAgendamento->atualizarItemAgendamento(
            $_POST["id_item_agendamento"],
            $_POST["id_agendamento"],
            $_POST["id_servico"],
            $_POST["valor_servico"],
            $_POST["qtde_solicitada"],
            $_POST["total_item"],
            $_POST["id_responsavel"]
        );

        if ($ok) {
            Redirect::redirecionarComMensagem("item_agendamento/listar", "success", "Item atualizado com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("item_agendamento/editar/{id}", "error", "Erro ao atualizar item!");
        }
    }

    // Excluir item (lógica)
    public function deletarItemAgendamento()
    {
        $ok = $this->itemAgendamento->excluirItemAgendamento($_POST["id_item_agendamento"]);

        if ($ok) {
            Redirect::redirecionarComMensagem("item_agendamento/listar", "success", "Item excluído com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("item_agendamento/listar", "error", "Erro ao excluir item!");
        }
    }
}
