<?php
namespace App\Impermax\Controllers;

use App\Impermax\Models\Avaliacao;
use App\Impermax\Models\Usuario;
use App\Impermax\Database\Database;
use App\Impermax\Core\View;
use App\Impermax\Core\Redirect;
use App\Impermax\Validadores\AvaliacaoValidador;
use App\Impermax\Controllers\Admin\FuncionarioController;

class AvaliacaoController extends FuncionarioController
{
    private $avaliacao;
    private $usuario;
    private $db;

    public function __construct()
    {
        parent::__construct();
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

    // View listar COM FILTROS
    public function viewListarAvaliacao()
    {
        // Captura os filtros da URL
        $filtros = [
            'busca' => $_GET['busca'] ?? '',
            'status' => $_GET['status'] ?? '',
            'nota' => $_GET['nota'] ?? '',
            'ordem_campo' => $_GET['ordem_campo'] ?? '',
            'ordem_direcao' => $_GET['ordem_direcao'] ?? ''
        ];

        // Busca avaliações com filtros
        $avaliacoes = $this->avaliacao->buscarAvaliacoesComFiltros($filtros);

        // Renderiza a view
        View::render("avaliacao/index", [
            "avaliacoes" => $avaliacoes
        ]);
    }

    // View criar
    public function viewCriarAvaliacao()
    {
        // Busca todos os clientes para o select
        $clientes = $this->usuario->buscarUsuarios();
        
        View::render("avaliacao/create", [
            "clientes" => $clientes
        ]);
    }

    // View editar
    public function viewEditarAvaliacao($id)
    {
        // Busca os dados da avaliação
        $avaliacao = $this->avaliacao->buscarAvaliacaoPorId($id);
        
        // Busca todos os clientes para o select
        $clientes = $this->usuario->buscarUsuarios();
        
        // Renderiza a view
        View::render("avaliacao/edit", [
            "avaliacao" => $avaliacao,
            "clientes" => $clientes
        ]);
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

    public function deletarMultiplos()
    {
        header('Content-Type: application/json');
        
        $ids = $_POST['ids'] ?? [];
        
        if (empty($ids)) {
            echo json_encode(['success' => false, 'message' => 'Nenhuma avaliação selecionada']);
            exit;
        }
        
        $sucesso = 0;
        foreach ($ids as $id) {
            if ($this->avaliacao->excluirAvaliacao($id)) {
                $sucesso++;
            }
        }
        
        if ($sucesso > 0) {
            echo json_encode([
                'success' => true,
                'message' => "$sucesso avaliação(ões) excluída(s) com sucesso!"
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Erro ao excluir avaliações'
            ]);
        }
        exit;
    }
}