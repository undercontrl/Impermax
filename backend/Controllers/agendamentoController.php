<?php
namespace App\Impermax\Controllers;

use App\Impermax\Controllers\Admin\AdminController;
use App\Impermax\Models\Agendamento;
use App\Impermax\Models\Usuario;
use App\Impermax\Database\Database;
use App\Impermax\Core\View;
use App\Impermax\Core\Redirect;
use App\Impermax\Validadores\AgendamentoValidador;

class AgendamentoController extends AdminController
{
    private $agendamento;
    private $usuario;
    private $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = Database::getInstance();
        $this->agendamento = new Agendamento($this->db);
        $this->usuario = new Usuario($this->db);
    }

    // Listar todos os agendamentos
    public function viewListarAgendamentos()
    {
        $dados = $this->agendamento->buscarAgendamentosComCliente();
        View::render("agendamento/index", ["agendamentos" => $dados]);
    }

    // Formulário de criação
    public function viewCriarAgendamentos()
    {
        $usuarios = $this->usuario->buscarUsuarios();
        View::render("agendamento/create", ["usuarios" => $usuarios]);
    }

    // Formulário de edição
    public function viewEditarAgendamentos($id)
    {
        $agendamento = $this->agendamento->buscarAgendamentoPorId($id);
        $usuarios = $this->usuario->buscarUsuarios();

        View::render("agendamento/edit", [
            "agendamento" => $agendamento,
            "usuarios" => $usuarios
        ]);
    }

    // Confirmação de exclusão
    public function viewExcluirAgendamentos($id)
    {
        View::render("agendamento/delete", ["id_agendamento" => $id]);
    }

    //  Salvar novo agendamento
    public function salvarAgendamento()
    {
        $erros = AgendamentoValidador::ValidarEntradas($_POST);

        if (!empty($erros)) {
            Redirect::redirecionarComMensagem("agendamento/criar", "error", implode("<br>", $erros));
        }

        $ok = $this->agendamento->inserirAgendamento(
            $_POST["id_cliente"],
            $_POST["data_solicitada"],
            $_POST["total_agendamento"],
            $_POST["status_agendamento"]
        );

        if ($ok) {
            Redirect::redirecionarComMensagem("agendamento/listar", "success", "Agendamento realizado com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("agendamento/criar", "error", "Erro ao realizar agendamento!");
        }
    }

    // Atualizar agendamento existente
    public function atualizarAgendamento()
    {
        $erros = AgendamentoValidador::ValidarEntradas($_POST);

        if (!empty($erros)) {
            Redirect::redirecionarComMensagem("agendamento/editar/{id}", "error", implode("<br>", $erros));
        }

        $ok = $this->agendamento->atualizarAgendamento(
            $_POST["id_agendamento"],
            $_POST["id_cliente"],
            $_POST["data_solicitada"],
            $_POST["total_agendamento"],
            $_POST["status_agendamento"]
        );

        if ($ok) {
            Redirect::redirecionarComMensagem("agendamento/listar", "success", "Agendamento atualizado com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("agendamento/editar/{id}", "error", "Erro ao atualizar agendamento!");
        }
    }

    // Deletar agendamento (soft delete)
    public function deletarAgendamento()
    {
        $ok = $this->agendamento->excluirAgendamento($_POST["id_agendamento"]);

        if ($ok) {
            Redirect::redirecionarComMensagem("agendamento/listar", "success", "Agendamento excluído com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("agendamento/listar", "error", "Erro ao excluir agendamento!");
        }
    }

    // Relatório (mantido)
    public function relatorioAgendamento($id, $dataInicial, $dataFinal)
    {
        View::render("agendamento/relatorio", [
            "id" => $id,
            "dataInicial" => $dataInicial,
            "dataFinal" => $dataFinal
        ]);
    }
}
