<?php
namespace App\Impermax\Controllers;

use App\Impermax\Models\Avaliacao;
use App\Impermax\Models\Usuario;
use App\Impermax\Database\Database;
use App\Impermax\Core\View;
use App\Impermax\Core\Redirect;
use App\Impermax\Validadores\AvaliacaoValidador;

class AvaliacaoController
{
    private $avaliacao;
    private $usuario;
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
        $this->avaliacao = new Avaliacao($this->db);
        $this->usuario = new Usuario($this->db);
    }

    // Página principal (debug ou API)
    public function index()
    {
        $dados = $this->avaliacao->buscarAvaliacao();
        var_dump($dados);
    }

    // View listar
    public function viewListarAvaliacao()
    {
        $avaliacoes = $this->avaliacao->buscarAvaliacao();
        View::render("avaliacao/index", ["avaliacoes" => $avaliacoes]);
    }

    // View criar
    public function viewCriarAvaliacao()
    {
        $avaliacao = $this->avaliacao->buscarAvaliacao();
        View::render("avaliacao/create", ["avaliacao" => $avaliacao]);
    }

    // View editar
    public function viewEditarAvaliacao($id)
    {
        // Busca os dados da avaliação (cliente + detalhes)
        $avaliacao = $this->avaliacao->buscarAvaliacaoPorId($id);
    
        // Renderiza a view com a avaliação
        View::render("avaliacao/edit", ["avaliacao" => $avaliacao]);
    }
    

    // View excluir
    public function viewExcluirAvaliacao($id)
    {
        View::render("avaliacao/delete", ["id_avaliacao" => $id]);
    }

    // POST - salvar avaliação
    public function salvarAvaliacao()
    {
        $erros = AvaliacaoValidador::ValidarEntradas($_POST);

        if (!empty($erros)) {
            Redirect::redirecionarComMensagem("avaliacao/criar", "error", implode("<br>", $erros));
        }

        $ok = $this->avaliacao->inserirAvaliacao(
            $_POST["id_cliente"],
            $_POST["descricao_avaliacao"],
            $_POST["nota_avaliacao"],
            $_POST["status_avaliacao"]
        );

        if ($ok) {
            Redirect::redirecionarComMensagem("avaliacao/listar", "success", "Avaliação cadastrada com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("avaliacao/criar", "error", "Erro ao cadastrar avaliação!");
        }
    }

    // POST - atualizar
    public function atualizarAvaliacao()
    {
        $ok = $this->avaliacao->atualizarAvaliacao(
            $_POST["id_avaliacao"],
            $_POST["id_cliente"],
            $_POST["descricao_avaliacao"],
            $_POST["nota_avaliacao"],
            $_POST["status_avaliacao"]
        );

        if ($ok) {
            Redirect::redirecionarComMensagem("avaliacao/listar", "success", "Avaliação atualizada com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("avaliacao/editar/{id}", "error", "Erro ao atualizar avaliação!");
        }
    }

    // POST - deletar
    public function deletarAvaliacao()
    {
        $ok = $this->avaliacao->excluirAvaliacao($_POST["id_avaliacao"]);

        if ($ok) {
            Redirect::redirecionarComMensagem("avaliacao/listar", "success", "Avaliação excluída com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("avaliacao/listar", "error", "Erro ao excluir avaliação!");
        }
    }
}
