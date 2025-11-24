<?php
namespace App\Impermax\Controllers;

use App\Impermax\Models\Servico;
use App\Impermax\Database\Database;
use App\Impermax\Core\View;
use App\Impermax\Core\Redirect;
use App\Impermax\Validadores\ServicoValidador;
use App\Impermax\Controllers\Admin\AdminController;

class ServicoController {
    private $servico;

    public function __construct() {
        $db = Database::getInstance();
        $this->servico = new Servico($db);
    }

    public function index() {
        $this->viewListarServicos(1);
    }

    /**
     * Lista serviços internos com paginação e busca
     */
    public function viewListarServicos($pagina = 1) {
        $pagina = max(1, (int)$pagina);
        $termo = $_GET['termo'] ?? '';
        
        if (!empty($termo)) {
            // Busca por termo
            $dados = $this->servico->buscarServicosPorNome($termo);
            $paginacao = [
                'total' => count($dados),
                'por_pagina' => count($dados),
                'pagina_atual' => 1,
                'total_paginas' => 1
            ];
        } else {
            // Listagem normal com paginação
            $resultado = $this->servico->listarInternos($pagina, 10);
            $dados = $resultado['data'];
            $paginacao = $resultado;
        }

        View::render("servico/index", [
            "servicos" => $dados,
            'paginacao' => $paginacao,
            'termo' => $termo
        ]);
    }

    /**
     * Rota de busca (usa o mesmo método de listagem)
     */
    public function buscar() {
        $this->viewListarServicos(1);
    }

    /**
     * Exibe formulário de criação
     */
    public function viewCriarServicos() {
        View::render("servico/create");
    }

    /**
     * Salva novo serviço
     */
    public function salvarServico() {
        $erros = ServicoValidador::ValidarEntradas($_POST);
        if (!empty($erros)) {
            Redirect::redirecionarComMensagem("servico/criar", "error", implode("<br>", $erros));
        }

        $sucesso = $this->servico->inserirServico(
            $_POST["nome_servico"],
            $_POST["descricao_servico"],
            $_POST["valor_base_servico"]
        );

        $msg = $sucesso ? "Serviço cadastrado com sucesso!" : "Erro ao cadastrar serviço.";
        $tipo = $sucesso ? "success" : "error";
        Redirect::redirecionarComMensagem("servico/listar", $tipo, $msg);
    }

    /**
     * Exibe formulário de edição
     */
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

    /**
     * Atualiza serviço existente
     */
    public function atualizarServico($id) {
        $erros = ServicoValidador::ValidarEntradas($_POST);
        if (!empty($erros)) {
            Redirect::redirecionarComMensagem("servico/editar/$id", "error", implode("<br>", $erros));
        }

        $sucesso = $this->servico->atualizarServico(
            $id,
            $_POST["nome_servico"],
            $_POST["descricao_servico"],
            $_POST["valor_base_servico"]
        );

        $msg = $sucesso ? "Serviço atualizado com sucesso!" : "Erro ao atualizar serviço.";
        $tipo = $sucesso ? "success" : "error";
        Redirect::redirecionarComMensagem("servico/listar", $tipo, $msg);
    }

    /**
     * Exibe confirmação de exclusão
     */
    public function viewExcluirServicos($id) {
        $servico = $this->servico->buscarServicoPorID($id);
        if (!$servico) {
            Redirect::redirecionarComMensagem("servico/listar", "error", "Serviço não encontrado.");
        }

        View::render("servico/delete", ["servico" => $servico]);
    }

    /**
     * Executa exclusão (soft delete)
     */
    public function deletarServico($id) {
        $id = (int) ($id ?: $_POST['id_servico'] ?? 0);
        if ($id <= 0) {
            Redirect::redirecionarComMensagem("servico/listar", "error", "ID inválido.");
        }

        $sucesso = $this->servico->deletarServicoInterno($id);

        $msg = $sucesso ? "Serviço removido com sucesso!" : "Erro ao remover serviço.";
        $tipo = $sucesso ? "success" : "error";
        Redirect::redirecionarComMensagem("servico/listar", $tipo, $msg);
    }

    /**
     * API: Retorna sugestões para autocomplete
     */
    public function sugestoes() {
        $termo = $_GET['termo'] ?? '';
        
        if (strlen($termo) < 2) {
            header('Content-Type: application/json');
            echo json_encode([]);
            exit;
        }

        $resultados = $this->servico->buscarServicosPorNome($termo);
        $limitados = array_slice($resultados, 0, 8);

        header('Content-Type: application/json');
        echo json_encode($limitados);
        exit;
    }
}
?>