<?php
namespace App\Impermax\Controllers;

use App\Impermax\Models\Contato;
use App\Impermax\Database\Database;
use App\Impermax\Core\View;
use App\Impermax\Core\Redirect;
use App\Impermax\Validadores\ContatoValidador;


class ContatoController
{
    private $contato;
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
        $this->contato = new Contato($this->db);
    }

   
    public function index()
    {
        $dados = $this->contato->buscarContatos();
        var_dump($dados);
    }

    public function viewListarContatos()
    {
        $contatos = $this->contato->buscarContatos();
        View::render("contato/index", ["contatos" => $contatos]);
    }

    
    public function viewCriarContato()
    {
        $contato = $this->contato->buscarContatos();
        View::render("contato/create", ["contato" => $contato]);
    }

    
    public function viewEditarContato($id)
    {
        $contato = $this->contato->buscarContatoPorId($id);
        View::render("contato/edit", ["contato" => $contato]);
    }

    
    public function viewExcluirContato($id)
    {
        View::render("contato/delete", ["id_contato" => $id]);
    }

    
    public function salvarContato()
    {
        $erros = ContatoValidador::ValidarEntradas($_POST);

        if (!empty($erros)) {
            Redirect::redirecionarComMensagem("contato/criar", "error", implode("<br>", $erros));
        }

        $ok = $this->contato->inserirContato(
            $_POST["nome_contato"],
            $_POST["telefone_contato"],
            $_POST["email_contato"],
            $_POST["assunto_contato"],
            "pendente",
            $_POST["data_envio"]
        );

        if ($ok) {
            Redirect::redirecionarComMensagem("contato/listar", "success", "Mensagem enviada com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("contato/criar", "error", "Erro ao enviar mensagem!");
        }
    }

    
    public function atualizarContato()
    {
        $erros = ContatoValidador::ValidarEntradas($_POST);

        if (!empty($erros)) {
            Redirect::redirecionarComMensagem("contato/editar/{id}", "error", implode("<br>", $erros));
        }

        $ok = $this->contato->atualizarContato(
            $_POST["id_contato"],
            $_POST["nome_contato"],
            $_POST["telefone_contato"],
            $_POST["email_contato"],
            $_POST["assunto_contato"],
            $_POST["status_contato"],
            $_POST["data_envio"]
        );

        if ($ok) {
            Redirect::redirecionarComMensagem("contato/listar", "success", "Contato atualizado com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("contato/editar/{id}", "error", "Erro ao atualizar contato!");
        }
    }

   
    public function deletarContato()
    {
        $ok = $this->contato->excluirContato($_POST["id_contato"]);

        if ($ok) {
            Redirect::redirecionarComMensagem("contato/listar", "success", "Contato excluído com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("contato/listar", "error", "Erro ao excluir contato!");
        }
    }
}