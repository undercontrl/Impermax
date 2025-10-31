<?php
namespace App\Impermax\Controllers;

use App\Impermax\Models\ServicoSite;
use App\Impermax\Database\Database;
use App\Impermax\Core\View;
use App\Impermax\Core\Redirect;
use App\Impermax\Validadores\ServicoSiteValidador;
use App\Impermax\Controllers\Admin\AdminController;
use App\Impermax\Core\FileManager;

class ServicoSiteController extends AdminController {
    private $model;
    private $fileManager;

    public function __construct() {
        parent::__construct();
        $db = Database::getInstance();
        $this->model = new ServicoSite($db);
        $this->fileManager = new FileManager('upload');
    }

    public function index() {
        $this->listar(1);
    }

    /**
     * Lista serviços do site com filtros e paginação
     */
    public function listar($pagina = 1) {
        $pagina = max(1, (int)$pagina);
        $statusFiltro = $_GET['status'] ?? '';
        
        // Busca os dados
        $resultado = $this->model->listarTodos($pagina, 12);
        $servicos = $resultado['data'];
        
        // Aplica filtro de status se necessário
        if (!empty($statusFiltro)) {
            $servicos = array_filter($servicos, function($servico) use ($statusFiltro) {
                $statusServico = strtolower($servico['status_servico']);
                return $statusServico === strtolower($statusFiltro);
            });
            
            // Recalcula paginação após filtro
            $resultado['total'] = count($servicos);
            $resultado['total_paginas'] = 1;
        }
        
        View::render("servico-site/index", [
            'servicos' => $servicos,
            'paginacao' => $resultado
        ]);
    }

    /**
     * Exibe formulário de criação
     */
    public function criar() {
        View::render("servico-site/create");
    }

    /**
     * Exibe formulário de edição
     */
    public function editar($id) {
        $servico = $this->model->buscarPorId($id);
        if (!$servico) {
            Redirect::redirecionarComMensagem("servico-site/listar", "error", "Serviço não encontrado.");
        }
        View::render("servico-site/edit", ['servico' => $servico]);
    }

    /**
     * Alterna status entre Ativo/Inativo
     */
    public function alternar($id) {
        $sucesso = $this->model->alternarStatus($id);
        
        if ($sucesso) {
            Redirect::redirecionarComMensagem("servico-site/listar", "success", "Status alterado com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("servico-site/listar", "error", "Erro ao alterar status.");
        }
    }

    /**
     * Salva novo serviço
     */
    public function salvar() {
        // Validação
        $erros = ServicoSiteValidador::validar($_POST, $_FILES);
        if ($erros) {
            return Redirect::redirecionarComMensagem(
                "servico-site/criar", 
                "error", 
                implode("<br>", $erros)
            );
        }

        // Upload da foto
        $foto = null;
        if (isset($_FILES['foto_servico']) && $_FILES['foto_servico']['error'] === UPLOAD_ERR_OK) {
            $foto = $this->fileManager->salvarArquivo($_FILES['foto_servico'], 'servicos');
            
            if (!$foto) {
                return Redirect::redirecionarComMensagem(
                    "servico-site/criar",
                    "error",
                    "Erro ao fazer upload da imagem."
                );
            }
        }

        // Insere no banco
        $sucesso = $this->model->inserir(
            $_POST['nome_servico'],
            $_POST['descricao_servico'],
            $foto,
            'Inativo' // Status padrão
        );

        $msg = $sucesso ? "Serviço criado com sucesso!" : "Erro ao criar serviço.";
        $tipo = $sucesso ? "success" : "error";
        
        Redirect::redirecionarComMensagem("servico-site/listar", $tipo, $msg);
    }

    /**
     * Atualiza serviço existente
     */
    public function atualizar($id) {
        // Validação (permite edição sem nova foto)
        $erros = ServicoSiteValidador::validar($_POST, $_FILES, true);
        if ($erros) {
            return Redirect::redirecionarComMensagem(
                "servico-site/editar/$id",
                "error",
                implode("<br>", $erros)
            );
        }

        // Verifica se há nova foto
        $foto = $_POST['foto_servico_atual'] ?? null;
        
        if (isset($_FILES['foto_servico']) && $_FILES['foto_servico']['error'] === UPLOAD_ERR_OK) {
            $novaFoto = $this->fileManager->salvarArquivo($_FILES['foto_servico'], 'servicos');
            
            if ($novaFoto) {
                // Remove foto antiga se existir
                if (!empty($foto)) {
                    $this->fileManager->excluirArquivo($foto, 'servicos');
                }
                $foto = $novaFoto;
            }
        }

        // Atualiza no banco
        $sucesso = $this->model->atualizar(
            $id,
            $_POST['nome_servico'],
            $_POST['descricao_servico'],
            $foto,
            $_POST['status_servico'] ?? 'Inativo'
        );

        $msg = $sucesso ? "Serviço atualizado com sucesso!" : "Erro ao atualizar.";
        $tipo = $sucesso ? "success" : "error";
        
        Redirect::redirecionarComMensagem("servico-site/listar", $tipo, $msg);
    }

    /**
     * API: Retorna serviços ativos para o site público
     */
    public function api() {
        $servicos = $this->model->listarAtivos();
        
        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'data' => $servicos,
            'total' => count($servicos)
        ]);
        exit;
    }
}
?>