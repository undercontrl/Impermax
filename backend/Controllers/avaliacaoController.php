<?php
namespace App\Impermax\Controllers;

use App\Impermax\Controllers\Admin\AdminController;
use App\Impermax\Models\Avaliacao;
use App\Impermax\Database\Database;
use App\Impermax\Core\View;
use App\Impermax\Core\Redirect;
use App\Impermax\Validadores\AvaliacaoValidador;

class AvaliacaoController
{
    private $avaliacao;
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
        $this->avaliacao = new Avaliacao($this->db);
    }

    public function index()
    {
        $this->viewListarAvaliacoes();
    }

    /**
     * Listar avaliações com filtros e paginação
     */
    public function viewListarAvaliacoes()
    {
        $filtros = [
            'busca' => $_GET['busca'] ?? '',
            'status' => $_GET['status'] ?? '',
            'nota' => $_GET['nota'] ?? '',
            'ordem_campo' => $_GET['ordem_campo'] ?? '',
            'ordem_direcao' => $_GET['ordem_direcao'] ?? '',
            'pagina' => (int)($_GET['pagina'] ?? 1)
        ];
        
        $avaliacoes = $this->avaliacao->buscarAvaliacoesComFiltros($filtros);
        $totalRegistros = $this->avaliacao->contarAvaliacoesComFiltros($filtros);
        
        $itensPorPagina = 10;
        $totalPaginas = ceil($totalRegistros / $itensPorPagina);
        $paginaAtual = $filtros['pagina'];
        
        View::render("avaliacao/index", [
            "avaliacoes" => $avaliacoes,
            "totalPaginas" => $totalPaginas,
            "paginaAtual" => $paginaAtual,
            "totalRegistros" => $totalRegistros
        ]);
    }

    /**
     * VIEW: Criar avaliação
     */
    public function viewCriarAvaliacoes()
    {
        $clientes = $this->avaliacao->getClientes();
        View::render("avaliacao/create", ["usuarios" => $clientes]);
    }

    /**
     * VIEW: Editar avaliação
     */
    public function viewEditarAvaliacoes($id)
    {
        if (!$id) {
            Redirect::redirecionarComMensagem("avaliacao/listar", "error", "ID da avaliação não fornecido!");
            return;
        }

        $avaliacao = $this->avaliacao->buscarAvaliacaoPorId($id);
        $clientes = $this->avaliacao->getClientes();
        
        if ($avaliacao) {
            View::render("avaliacao/edit", [
                "avaliacao" => $avaliacao,
                "usuarios" => $clientes
            ]);
        } else {
            Redirect::redirecionarComMensagem("avaliacao/listar", "error", "Avaliação não encontrada!");
        }
    }

    /**
     * VIEW: Confirmar exclusão
     */
    public function viewExcluirAvaliacoes($id)
    {
        if (!$id) {
            Redirect::redirecionarComMensagem("avaliacao/listar", "error", "ID da avaliação não fornecido!");
            return;
        }

        $avaliacao = $this->avaliacao->buscarAvaliacaoPorId($id);
        
        if ($avaliacao) {
            View::render("avaliacao/delete", ["avaliacao" => $avaliacao]);
        } else {
            Redirect::redirecionarComMensagem("avaliacao/listar", "error", "Avaliação não encontrada!");
        }
    }

    /**
     * Salvar nova avaliação
     */
    public function salvarAvaliacao()
    {
        $erros = AvaliacaoValidador::validarEntradas($_POST);
        
        if (!empty($erros)) {
            Redirect::redirecionarComMensagem("avaliacao/criar", "error", implode("<br>", $erros));
            return;
        }

        if ($this->avaliacao->inserirAvaliacao(
            $_POST["id_cliente"],
            $_POST["descricao_avaliacao"],
            $_POST["nota_avaliacao"],
            $_POST["status_avaliacao"]
        )) {
            Redirect::redirecionarComMensagem("avaliacao/listar", "success", "Avaliação cadastrada com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("avaliacao/criar", "error", "Erro ao cadastrar avaliação!");
        }
    }

    /**
     * Atualizar avaliação
     */
    public function atualizarAvaliacao()
    {
        if (!isset($_POST['id_avaliacao'])) {
            Redirect::redirecionarComMensagem("avaliacao/listar", "error", "ID da avaliação não fornecido!");
            return;
        }

        $id = (int)$_POST['id_avaliacao'];
        $erros = AvaliacaoValidador::validarEntradas($_POST, true);
        
        if (!empty($erros)) {
            Redirect::redirecionarComMensagem("avaliacao/editar/{$id}", "error", implode("<br>", $erros));
            return;
        }

        if ($this->avaliacao->atualizarAvaliacao(
            $id,
            $_POST["id_cliente"],
            $_POST["descricao_avaliacao"],
            $_POST["nota_avaliacao"],
            $_POST["status_avaliacao"]
        )) {
            Redirect::redirecionarComMensagem("avaliacao/listar", "success", "Avaliação atualizada com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("avaliacao/editar/{$id}", "error", "Erro ao atualizar avaliação!");
        }
    }

    /**
     * Deletar avaliação (soft delete)
     */
    public function deletarAvaliacao()
    {
        if (!isset($_POST['id_avaliacao'])) {
            Redirect::redirecionarComMensagem("avaliacao/listar", "error", "ID da avaliação não fornecido!");
            return;
        }

        $id = (int)$_POST['id_avaliacao'];
        
        if ($this->avaliacao->excluirAvaliacao($id)) {
            Redirect::redirecionarComMensagem("avaliacao/listar", "success", "Avaliação excluída com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("avaliacao/listar", "error", "Erro ao excluir avaliação!");
        }
    }

    /**
     * Deletar múltiplas avaliações
     */
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