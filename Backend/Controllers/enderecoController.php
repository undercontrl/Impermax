<?php
namespace App\Impermax\Controllers;

use App\Impermax\Models\endereco;
use App\Impermax\Models\usuario;
use App\Impermax\Database\Database;
use App\Impermax\Core\View;
use App\Impermax\Core\Redirect;
use App\Impermax\Validadores\EnderecoValidador;
use App\Impermax\Controllers\Admin\AuthenticatedController;
use App\Impermax\Controllers\Admin\AdminController;


class EnderecoController extends AdminController
{
    private $endereco;
    private $usuario;
    private $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = Database::getInstance();
        $this->endereco = new endereco($this->db);
        $this->usuario = new usuario($this->db);
    }

    // Página inicial (lista todos os endereços)
    public function viewListarEnderecos()
    {
        $enderecos = $this->endereco->buscarEnderecos();
        View::render("endereco/index", ["enderecos" => $enderecos]);
    }

    // Página de criação de endereço
    public function viewCriarEndereco()
    {
        $usuarios = $this->usuario->buscarUsuarios();
        View::render("endereco/create", ["usuarios" => $usuarios]);
    }

    // Página de edição de endereço
    public function viewEditarEndereco($id)
    {
        $endereco = $this->endereco->buscarEnderecoPorId($id);
        $usuarios = $this->usuario->buscarUsuarios();
        View::render("endereco/edit", ["endereco" => $endereco, "usuarios" => $usuarios]);
    }

    // Página de exclusão
    public function viewExcluirEndereco($id)
    {
        View::render("endereco/delete", ["id_endereco" => $id]);
    }

    // Salvar novo endereço
    public function salvarEndereco()
    {
        $erros = EnderecoValidador::ValidarEntradas($_POST);
        if (!empty($erros)) {
            Redirect::redirecionarComMensagem("endereco/criar", "error", implode("<br>", $erros));
        }

        $ok = $this->endereco->inserirEndereco(
            $_POST["id_usuario"],
            $_POST["cep_endereco"],
            $_POST["logadouro_endereco"],
            $_POST["numero_endereco"],
            $_POST["complemento_endereco"],
            $_POST["bairro_endereco"],
            $_POST["cidade_endereco"],
            $_POST["uf_endereco"]
        );

        if ($ok) {
            Redirect::redirecionarComMensagem("endereco/listar", "success", "Endereço cadastrado com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("endereco/criar", "error", "Erro ao cadastrar endereço!");
        }
    }

    // Atualizar endereço existente
    public function atualizarEndereco()
    {
        $erros = EnderecoValidador::ValidarEntradas($_POST);
        if (!empty($erros)) {
            Redirect::redirecionarComMensagem("endereco/editar/{id}", "error", implode("<br>", $erros));
        }

        $ok = $this->endereco->atualizarEndereco(
            $_POST["id_endereco"],
            $_POST["cep_endereco"],
            $_POST["logadouro_endereco"],
            $_POST["numero_endereco"],
            $_POST["complemento_endereco"],
            $_POST["bairro_endereco"],
            $_POST["cidade_endereco"],
            $_POST["uf_endereco"]
        );

        if ($ok) {
            Redirect::redirecionarComMensagem("endereco/listar", "success", "Endereço atualizado com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("endereco/editar/{id}", "error", "Erro ao atualizar endereço!");
        }
    }

    // Exclusão lógica
    public function deletarEndereco()
    {
        $ok = $this->endereco->excluirEndereco($_POST["id_endereco"]);

        if ($ok) {
            Redirect::redirecionarComMensagem("endereco/listar", "success", "Endereço excluído com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("endereco/listar", "error", "Erro ao excluir endereço!");
        }
    }
}
