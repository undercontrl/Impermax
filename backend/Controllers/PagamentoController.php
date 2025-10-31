<?php
namespace App\Impermax\Controllers;

use App\Impermax\Controllers\Admin\AdminController;
use App\Impermax\Models\Pagamento;
use App\Impermax\Database\Database;
use App\Impermax\Core\View;
use App\Impermax\Core\Redirect;
use App\Impermax\Validadores\PagamentoValidador;

class PagamentoController extends AdminController
{
    private $pagamento;
    private $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = Database::getInstance();
        $this->pagamento = new Pagamento($this->db);
    }

    // ==================== VIEWS ====================
    
    /**
     * Listar todos os pagamentos com filtros, ordenação e paginação
     */
    public function viewListarPagamentos()
    {
        // Parâmetros de filtro
        $busca = $_GET['busca'] ?? '';
        $status = $_GET['status'] ?? '';
        $periodo = $_GET['periodo'] ?? '';
        
        // Parâmetros de ordenação
        $ordemCampo = $_GET['ordem_campo'] ?? 'data_pagamento';
        $ordemDirecao = $_GET['ordem_direcao'] ?? 'DESC';
        
        // Parâmetros de paginação
        $paginaAtual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        $itensPorPagina = 10;
        $offset = ($paginaAtual - 1) * $itensPorPagina;
        
        // Buscar pagamentos filtrados
        $pagamentos = $this->pagamento->buscarPagamentosFiltrados(
            $busca,
            $status,
            $periodo,
            $ordemCampo,
            $ordemDirecao,
            $itensPorPagina,
            $offset
        );
        
        // Contar total de registros para paginação
        $totalRegistros = $this->pagamento->contarPagamentosFiltrados($busca, $status, $periodo);
        $totalPaginas = ceil($totalRegistros / $itensPorPagina);
        
        // Calcular informações de paginação
        $inicio = $offset + 1;
        $fim = min($offset + $itensPorPagina, $totalRegistros);
        
        $paginacao = [
            'pagina_atual' => $paginaAtual,
            'total_paginas' => $totalPaginas,
            'total' => $totalRegistros,
            'inicio' => $inicio,
            'fim' => $fim
        ];
        
        // Buscar estatísticas
        $stats = $this->pagamento->buscarEstatisticas($busca, $status, $periodo);
        
        View::render("pagamento/index", [
            "pagamentos" => $pagamentos,
            "paginacao" => $paginacao,
            "stats" => $stats
        ]);
    }

    /**
     * Formulário de criação
     */
    public function viewCriarPagamentos()
    {
        $clientes = $this->pagamento->getClientes();
        View::render("pagamento/create", ["usuarios" => $clientes]);
    }

    /**
     * Formulário de edição
     */
    public function viewEditarPagamentos($id = null)
    {
        if (!$id) {
            Redirect::redirecionarComMensagem("pagamento/listar", "error", "ID do pagamento não fornecido!");
            return;
        }

        $pagamento = $this->pagamento->buscarPagamentoPorID($id);
        
        if (!$pagamento) {
            Redirect::redirecionarComMensagem("pagamento/listar", "error", "Pagamento não encontrado!");
            return;
        }

        $clientes = $this->pagamento->getClientes();
        
        View::render("pagamento/edit", [
            "pagamento" => $pagamento,
            "usuarios" => $clientes
        ]);
    }

    /**
     * Visualizar detalhes do pagamento
     */
    public function viewVerPagamento($id)
    {
        if (!$id) {
            Redirect::redirecionarComMensagem("pagamento/listar", "error", "ID do pagamento não fornecido!");
            return;
        }

        $pagamento = $this->pagamento->buscarPagamentoPorID($id);
        
        if (!$pagamento) {
            Redirect::redirecionarComMensagem("pagamento/listar", "error", "Pagamento não encontrado!");
            return;
        }

        View::render("pagamento/view", ["pagamento" => $pagamento]);
    }

    /**
     * Confirmação de exclusão
     */
    public function viewExcluirPagamentos($id)
    {
        $pagamento = $this->pagamento->buscarPagamentoPorID($id);
        
        if (!$pagamento) {
            Redirect::redirecionarComMensagem("pagamento/listar", "error", "Pagamento não encontrado!");
            return;
        }

        View::render("pagamento/delete", ["pagamento" => $pagamento]);
    }

    // ==================== AÇÕES ====================
    
    /**
     * Salvar novo pagamento
     */
    public function salvarPagamento()
    {
        $erros = PagamentoValidador::ValidarEntradas($_POST);

        if (!empty($erros)) {
            Redirect::redirecionarComMensagem("pagamento/criar", "error", implode("<br>", $erros));
            return;
        }

        // Calcular total pago e status
        $total_pago = ($_POST['dinheiro'] ?? 0) + ($_POST['debito'] ?? 0) + 
                      ($_POST['credito'] ?? 0) + ($_POST['pix'] ?? 0);
        $status = $this->pagamento->calcularStatus($_POST['total_devedor'], $total_pago);

        $ok = $this->pagamento->inserirPagamento(
            $_POST["id_cliente"],
            $_POST["total_devedor"],
            $_POST['dinheiro'] ?? 0,
            $_POST['credito'] ?? 0,
            $_POST['debito'] ?? 0,
            $_POST['pix'] ?? 0,
            $status,
            $_POST["data_pagamento"]
        );

        if ($ok) {
            Redirect::redirecionarComMensagem("pagamento/listar", "success", "Pagamento cadastrado com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("pagamento/criar", "error", "Erro ao cadastrar pagamento!");
        }
    }

    /**
     * Atualizar pagamento existente
     */
    public function atualizarPagamento()
    {
        $id = $_POST['id_pagamento'] ?? null;
        
        if (!$id) {
            Redirect::redirecionarComMensagem("pagamento/listar", "error", "ID do pagamento não fornecido!");
            return;
        }

        $erros = PagamentoValidador::ValidarEntradas($_POST);

        if (!empty($erros)) {
            Redirect::redirecionarComMensagem("pagamento/editar/{$id}", "error", implode("<br>", $erros));
            return;
        }

        // Calcular total pago e status
        $total_pago = ($_POST['dinheiro'] ?? 0) + ($_POST['debito'] ?? 0) + 
                      ($_POST['credito'] ?? 0) + ($_POST['pix'] ?? 0);
        $status = $this->pagamento->calcularStatus($_POST['total_devedor'], $total_pago);

        $ok = $this->pagamento->atualizarPagamento(
            $id,
            $_POST["id_cliente"],
            $_POST["total_devedor"],
            $_POST['dinheiro'] ?? 0,
            $_POST['credito'] ?? 0,
            $_POST['debito'] ?? 0,
            $_POST['pix'] ?? 0,
            $status,
            $_POST["data_pagamento"]
        );

        if ($ok) {
            Redirect::redirecionarComMensagem("pagamento/listar", "success", "Pagamento atualizado com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("pagamento/editar/{$id}", "error", "Erro ao atualizar pagamento!");
        }
    }

    /**
     * Deletar pagamento (soft delete)
     */
    public function deletarPagamento()
    {
        $id = $_POST['id_pagamento'] ?? null;
        
        if (!$id) {
            Redirect::redirecionarComMensagem("pagamento/listar", "error", "ID do pagamento não fornecido!");
            return;
        }

        $ok = $this->pagamento->excluirPagamento($id);

        if ($ok) {
            Redirect::redirecionarComMensagem("pagamento/listar", "success", "Pagamento excluído com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("pagamento/listar", "error", "Erro ao excluir pagamento!");
        }
    }

    /**
     * Exclusão múltipla via AJAX
     */
    public function deletarMultiplos()
    {
        header('Content-Type: application/json');
        
        $ids = $_POST['ids'] ?? [];
        
        if (empty($ids)) {
            echo json_encode(['success' => false, 'message' => 'Nenhum pagamento selecionado']);
            exit;
        }
        
        $sucesso = 0;
        foreach ($ids as $id) {
            if ($this->pagamento->excluirPagamento($id)) {
                $sucesso++;
            }
        }
        
        if ($sucesso > 0) {
            echo json_encode([
                'success' => true,
                'message' => "$sucesso pagamento(s) excluído(s) com sucesso!"
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Erro ao excluir pagamentos'
            ]);
        }
        exit;
    }

    /**
     * Redirecionamento para listagem
     */
    public function index()
    {
        $this->viewListarPagamentos();
    }
}