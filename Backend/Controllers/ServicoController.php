<?php
namespace App\Impermax\Controllers;

use App\Impermax\Models\Servico;
use App\Impermax\Database\Database;
use App\Impermax\Core\View;
use App\Impermax\Core\Redirect;
use App\Impermax\Validadores\ServicoValidador;
use App\Impermax\Controllers\Admin\AuthenticatedController;

class ServicoController extends AuthenticatedController {
    private $servico;

    public function __construct() {
        parent::__construct();
        $db = Database::getInstance();
        $this->servico = new Servico($db);
    }

    public function index() {
        $this->viewListarServicos(1);
    }

    // === DASHBOARD INTERNO ===
    public function viewListarServicos($pagina = 1) {
    $pagina = max(1, (int)$pagina);
    
    // Lê termo de busca
    $termo = $_GET['termo'] ?? '';
    
    if (!empty($termo)) {
        $dados = $this->servico->buscarServicosPorNome($termo);
        $paginacao = null;
    } else {
        $dados = $this->servico->listarInternos($pagina, 20);
        $paginacao = $dados;
        $dados = $dados['data'];
    }

    View::render("servico/index", [
        "servicos" => $dados,
        'paginacao' => $paginacao,
        'termo' => $termo
    ]);
}

// Rota de busca
public function buscar() {
    $this->viewListarServicos(1); // Usa mesmo método
}

    // === CRUD INTERNO ===
    public function viewCriarServicos() {
        View::render("servico/create");
    }

    public function salvarServico() {
        $erros = ServicoValidador::ValidarEntradas($_POST);
        if (!empty($erros)) {
            Redirect::redirecionarComMensagem("servico/criar", "error", implode("<br>", $erros));
        }

        // Não precisa de foto para uso interno
        $sucesso = $this->servico->inserirServico(
            $_POST["nome_servico"],
            $_POST["descricao_servico"],
            $_POST["valor_base_servico"],
            null, // foto_servico = null (interno não usa)
            'Inativo' // status padrão, mas controlado pelo site
        );

        $msg = $sucesso ? "Serviço interno cadastrado!" : "Erro ao cadastrar.";
        $tipo = $sucesso ? "success" : "error";
        Redirect::redirecionarComMensagem("servico/listar", $tipo, $msg);
    }

    public function viewEditarServicos($id = null) {
        if (!$id) {
            Redirect::redirecionarComMensagem("servico/listar", "error", "ID não fornecido.");
        }

        $servico = $this->servico->buscarServicoPorID($id);
        if (!$servico) {
            Redirect::redirecionarComMensagem("servico/listar", "error", "Serviço não encontrado.");
        }

        View::render("servico/edit", ["servico" => $servico]);
    }

    public function atualizarServico($id) {
        $erros = ServicoValidador::ValidarEntradas($_POST);
        if (!empty($erros)) {
            Redirect::redirecionarComMensagem("servico/editar/$id", "error", implode("<br>", $erros));
        }

        // Mantém foto atual (se existir) - não é foco do interno
        $fotoAtual = $_POST['foto_servico_atual'] ?? null;

        $sucesso = $this->servico->atualizarServico(
            $id,
            $_POST["nome_servico"],
            $_POST["descricao_servico"],
            $_POST["valor_base_servico"],
            $_POST["status_servico"] ?? 'Inativo' // Mantém status
        );

        $msg = $sucesso ? "Serviço interno atualizado!" : "Erro ao atualizar.";
        $tipo = $sucesso ? "success" : "error";
        Redirect::redirecionarComMensagem("servico/listar", $tipo, $msg);
    }

    // === EXCLUSÃO INTERNA (soft delete) ===
    public function viewExcluirServicos($id) {
        $servico = $this->servico->buscarServicoPorID($id);
        if (!$servico) {
            Redirect::redirecionarComMensagem("servico/listar", "error", "Serviço não encontrado.");
        }

        View::render("servico/delete", ["servico" => $servico]);
    }

    public function deletarServico($id) {
        $id = (int) ($id ?: $_POST['id_servico'] ?? 0);
        if ($id <= 0) {
            Redirect::redirecionarComMensagem("servico/listar", "error", "ID inválido.");
        }

        // Para uso interno: usa soft delete (excluido_em)
        $sucesso = $this->servico->deletarServicoInterno($id);

        $msg = $sucesso ? "Serviço interno removido!" : "Erro ao remover.";
        $tipo = $sucesso ? "success" : "error";
        Redirect::redirecionarComMensagem("servico/listar", $tipo, $msg);
    }




    public function sugestoes() {
    $termo = $_GET['termo'] ?? '';
    if (strlen($termo) < 2) {
        echo json_encode([]);
        exit;
    }

    $resultados = $this->servico->buscarServicosPorNome($termo);
    $limitados = array_slice($resultados, 0, 8); // Máximo 8 sugestões

    header('Content-Type: application/json');
    echo json_encode($limitados);
    exit;
}

    
}