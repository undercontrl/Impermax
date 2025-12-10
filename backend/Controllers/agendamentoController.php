<?php
namespace App\Impermax\Controllers;

use App\Impermax\Controllers\Admin\AdminController;
use App\Impermax\Models\Agendamento;
use App\Impermax\Models\Usuario;
use App\Impermax\Models\Orcamento;
use App\Impermax\Database\Database;
use App\Impermax\Core\View;
use App\Impermax\Core\Redirect;
use App\Impermax\Validadores\AgendamentoValidador;
use App\Impermax\Core\EmailNotification;

class AgendamentoController
{
    private $agendamento;
    private $usuario;
    private $db;
    private EmailNotification $emailNotification;

    public function __construct()
    {
        $this->db = Database::getInstance();
        $this->agendamento = new Agendamento($this->db);
        $this->usuario = new Usuario($this->db);
        // $this->orcamento = new Orcamento($this->db);
        $this->emailNotification = new EmailNotification();
    }

    // Listar todos os agendamentos com filtros, busca, ordenação e paginação
    public function viewListarAgendamentos()
    {
        // Parâmetros de filtro
        $busca = $_GET['busca'] ?? '';
        $status = $_GET['status'] ?? '';
        $periodo = $_GET['periodo'] ?? '';
        
        // Parâmetros de ordenação
        $ordemCampo = $_GET['ordem_campo'] ?? 'data_solicitada';
        $ordemDirecao = $_GET['ordem_direcao'] ?? 'DESC';
        
        // Parâmetros de paginação
        $paginaAtual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        $itensPorPagina = 10;
        $offset = ($paginaAtual - 1) * $itensPorPagina;
        
        // Buscar agendamentos filtrados
        // $agendamentos = $this->agendamento->buscarAgendamentosFiltrados(
        //     $busca,
        //     $status,
        //     $periodo,
        //     $ordemCampo,
        //     $ordemDirecao,
        //     $itensPorPagina,
        //     $offset
        // );

        $agendamentos = $this->agendamento->buscarAgendamentosComServicoEOrcamento(
            $busca,
            $status,
            $periodo,
            $ordemCampo,
            $ordemDirecao,
            $itensPorPagina,
            $offset
        );
        
        
        // Contar total de registros para paginação
        $totalRegistros = $this->agendamento->contarAgendamentosFiltrados($busca, $status, $periodo);
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
        $stats = $this->agendamento->buscarEstatisticas($busca, $status, $periodo);
        
        View::render("agendamento/index", [
            "agendamentos" => $agendamentos,
            "paginacao" => $paginacao,
            "stats" => $stats
        ]);
    }

    // Formulário de criação
    public function viewCriarAgendamentos()
    {
        $usuarios = $this->usuario->buscarUsuarios();

        // Se já tiver um cliente selecionado (via GET)
        $id_cliente = $_GET['id_cliente'] ?? null;
        $servicos = [];

        if ($id_cliente) {
            $servicos = $this->agendamento->buscarOrcamentosPorCliente($id_cliente);
        }

        View::render("agendamento/create", [
            "usuarios" => $usuarios,
            "servicos" => $servicos,
            "id_cliente_selecionado" => $id_cliente
        ]);
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

    // Visualizar detalhes do agendamento (página de visualização)
    public function viewVerAgendamento($id)
    {
        $agendamento = $this->agendamento->buscarAgendamentoComClienteCompleto($id);
        
        if (!$agendamento) {
            Redirect::redirecionarComMensagem("agendamento/listar", "error", "Agendamento não encontrado!");
            return;
        }

        View::render("agendamento/view", [
            "agendamento" => $agendamento
        ]);
    }

    // Confirmação de exclusão
    public function viewExcluirAgendamentos($id)
    {
        View::render("agendamento/delete", ["id_agendamento" => $id]);
    }

    // Salvar novo agendamento
    public function salvarAgendamento()
    {
        $erros = AgendamentoValidador::ValidarEntradas($_POST);

        if (!empty($erros)) {
            Redirect::redirecionarComMensagem("agendamento/criar", "error", implode("<br>", $erros));
        }

        // Inserir o agendamento
        $ok = $this->agendamento->inserirAgendamento(
            $_POST["id_cliente"],
            $_POST["data_solicitada"],
            $_POST["total_agendamento"],
            $_POST["status_agendamento"]
        );

        if ($ok) {
            // Pegar o ID do agendamento recém-criado
            $id_agendamento = $this->db->lastInsertId();
            
            // Salvar os orçamentos selecionados
            if (!empty($_POST['orcamentos_selecionados'])) {
                $orcamentos = json_decode($_POST['orcamentos_selecionados'], true);
                
                foreach ($orcamentos as $id_orcamento) {
                    $sql = "INSERT INTO tbl_agendamento_orcamento (id_agendamento, id_orcamento) 
                            VALUES (:id_agendamento, :id_orcamento)";
                    $stmt = $this->db->prepare($sql);
                    $stmt->bindParam(':id_agendamento', $id_agendamento);
                    $stmt->bindParam(':id_orcamento', $id_orcamento);
                    $stmt->execute();
                }
            }
            
            Redirect::redirecionarComMensagem("agendamento/listar", "success", "Agendamento realizado com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("agendamento/criar", "error", "Erro ao realizar agendamento!");
        }
    }

    // Atualizar agendamento existente
    public function atualizarAgendamento(int $id)
    {
        $erros = AgendamentoValidador::ValidarEntradas($_POST);
        if (!empty($erros)) {
            Redirect::redirecionarComMensagem("agendamento/editar/{$id}", "error", implode("<br>", $erros));
            return;
        }
        if ($this->agendamento->atualizarAgendamento(
            $id,
            // $_POST["id_agendamento"],
            $_POST["id_cliente"],
            $_POST["data_solicitada"],
            $_POST["total_agendamento"],
            $_POST["status_agendamento"]
        )) {

            // arrumar essa parte do email depois
            
            // if($_POST["status_agendamento"] === 'agendada'){
            //     $agendamento = $this->agendamento->buscarAgendamentos($id);
            //     $email = $agendamento['email_usuario'] ?? '';
            //     $nome = $agendamento ['nome_cliente'] ?? '';
            //     $dataAgendamento = $agendamento ['data_solicitada'] ?? '';
            //     $servico = $agendamento ['descricao_servico'] ?? '';

            //     $this->emailNotification->agendamentoConfirmado($email, $nome, $dataAgendamento, $servico);
            // }
            Redirect::redirecionarComMensagem("agendamento/listar", "success", "Agendamento atualizado com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("agendamento/editar/{$id}", "error", "Erro ao atualizar agendamento!");
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

    // Exclusão múltipla via AJAX
    public function deletarMultiplos()
    {
        header('Content-Type: application/json');
        
        $ids = $_POST['ids'] ?? [];
        
        if (empty($ids)) {
            echo json_encode(['success' => false, 'message' => 'Nenhum agendamento selecionado']);
            exit;
        }
        
        $sucesso = 0;
        foreach ($ids as $id) {
            if ($this->agendamento->excluirAgendamento($id)) {
                $sucesso++;
            }
        }
        
        if ($sucesso > 0) {
            echo json_encode([
                'success' => true, 
                'message' => "$sucesso agendamento(s) excluído(s) com sucesso!"
            ]);
        } else {
            echo json_encode([
                'success' => false, 
                'message' => 'Erro ao excluir agendamentos'
            ]);
        }
        exit;
    }

    // Relatório
    public function relatorioAgendamento($id, $dataInicial, $dataFinal)
    {
        View::render("agendamento/relatorio", [
            "id" => $id,
            "dataInicial" => $dataInicial,
            "dataFinal" => $dataFinal
        ]);
    }

    public function buscarOrcamentosPorClienteAjax()
    {
        // Define o cabeçalho como JSON
        header('Content-Type: application/json');
        
        // Verifica se o ID do cliente foi enviado
        $id_cliente = $_POST['id_cliente'] ?? null;

        if (!$id_cliente) {
            echo json_encode([
                'success' => false, 
                'message' => 'Cliente não informado'
            ]);
            exit;
        }

        try {
            // Busca os orçamentos do cliente
            $orcamentos = $this->agendamento->buscarOrcamentosPorCliente($id_cliente);

            // Retorna os dados
            echo json_encode([
                'success' => true,
                'orcamentos' => $orcamentos
            ]);
        } catch (\Exception $e) {
            // Em caso de erro
            echo json_encode([
                'success' => false,
                'message' => 'Erro ao buscar orçamentos: ' . $e->getMessage()
            ]);
        }
        
        exit;
    }


}