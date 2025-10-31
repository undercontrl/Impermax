<?php
namespace App\Impermax\Controllers;

use App\Impermax\Controllers\Admin\AdminController;
use App\Impermax\Models\Projeto;
use App\Impermax\Database\Database;
use App\Impermax\Core\View;
use App\Impermax\Core\Redirect;
use App\Impermax\Validadores\ProjetoValidador;
use App\Impermax\Core\FileManager;

class ProjetoController extends AdminController
{
    private $projeto;
    private $db;
    private $gerenciarImagem;

    public function __construct()
    {
        parent::__construct();
        $this->db = Database::getInstance();
        $this->projeto = new Projeto($this->db);
        // CORREÇÃO: Caminho correto para o diretório de uploads
        $this->gerenciarImagem = new FileManager($_SERVER['DOCUMENT_ROOT'] . '/upload');
    }

    // ==================== VIEWS ====================
    
    /**
     * Listar todos os projetos com filtros, ordenação e paginação
     */
    public function viewListarProjetos()
    {
        // Parâmetros de filtro
        $busca = $_GET['busca'] ?? '';
        
        // Parâmetros de ordenação
        $ordemCampo = $_GET['ordem_campo'] ?? 'criado_em';
        $ordemDirecao = $_GET['ordem_direcao'] ?? 'DESC';
        
        // Parâmetros de paginação
        $paginaAtual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        $itensPorPagina = 12; // Grid funciona melhor com múltiplos de 3 ou 4
        $offset = ($paginaAtual - 1) * $itensPorPagina;
        
        // Buscar projetos filtrados
        $projetos = $this->projeto->buscarProjetosFiltrados(
            $busca,
            $ordemCampo,
            $ordemDirecao,
            $itensPorPagina,
            $offset
        );
        
        // Contar total de registros para paginação
        $totalRegistros = $this->projeto->contarProjetosFiltrados($busca);
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
        $stats = $this->projeto->buscarEstatisticas($busca);
        
        View::render("projeto/index", [
            "projetos" => $projetos,
            "paginacao" => $paginacao,
            "stats" => $stats
        ]);
    }

    /**
     * Formulário de criação
     */
    public function viewCriarProjetos()
    {
        View::render("projeto/create");
    }

    /**
     * Formulário de edição
     */
    public function viewEditarProjetos($id = null)
    {
        if (!$id) {
            Redirect::redirecionarComMensagem("projeto/listar", "error", "ID do projeto não fornecido!");
            return;
        }

        $projeto = $this->projeto->buscarProjetoPorID($id);

        if (!$projeto) {
            Redirect::redirecionarComMensagem("projeto/listar", "error", "Projeto não encontrado!");
            return;
        }

        View::render("projeto/edit", ["projeto" => $projeto]);
    }

    /**
     * Visualizar detalhes do projeto
     */
    public function viewVerProjeto($id)
    {
        if (!$id) {
            Redirect::redirecionarComMensagem("projeto/listar", "error", "ID do projeto não fornecido!");
            return;
        }

        $projeto = $this->projeto->buscarProjetoPorID($id);
        
        if (!$projeto) {
            Redirect::redirecionarComMensagem("projeto/listar", "error", "Projeto não encontrado!");
            return;
        }

        View::render("projeto/view", ["projeto" => $projeto]);
    }

    /**
     * Confirmação de exclusão
     */
    public function viewExcluirProjetos($id)
    {
        $projeto = $this->projeto->buscarProjetoPorID($id);
        
        if (!$projeto) {
            Redirect::redirecionarComMensagem("projeto/listar", "error", "Projeto não encontrado!");
            return;
        }

        View::render("projeto/delete", ["projeto" => $projeto]);
    }

    // ==================== AÇÕES ====================
    
    /**
     * Salvar novo projeto
     */
    public function salvarProjeto()
    {
        $erros = ProjetoValidador::ValidarEntradas($_POST, $_FILES);

        if (!empty($erros)) {
            Redirect::redirecionarComMensagem("projeto/criar", "error", implode("<br>", $erros));
            return;
        }

        try {
            // Upload das imagens
            $foto_antes_projeto = $this->gerenciarImagem->salvarArquivo($_FILES['foto_antes_projeto'], 'projeto');
            $foto_depois_projeto = $this->gerenciarImagem->salvarArquivo($_FILES['foto_depois_projeto'], 'projeto');

            $ok = $this->projeto->inserirProjeto(
                $foto_antes_projeto,
                $foto_depois_projeto,
                $_POST["descricao_projeto"]
            );

            if ($ok) {
                Redirect::redirecionarComMensagem("projeto/listar", "success", "Projeto cadastrado com sucesso!");
            } else {
                Redirect::redirecionarComMensagem("projeto/criar", "error", "Erro ao cadastrar projeto!");
            }
        } catch (\Exception $e) {
            Redirect::redirecionarComMensagem("projeto/criar", "error", "Erro ao fazer upload: " . $e->getMessage());
        }
    }

    /**
     * Atualizar projeto existente
     */
    public function atualizarProjeto()
    {
        $id = $_POST['id_projeto'] ?? null;
        
        if (!$id) {
            Redirect::redirecionarComMensagem("projeto/listar", "error", "ID do projeto não fornecido!");
            return;
        }

        $erros = ProjetoValidador::ValidarEntradas($_POST, $_FILES, true);

        if (!empty($erros)) {
            Redirect::redirecionarComMensagem("projeto/editar/$id", "error", implode("<br>", $erros));
            return;
        }

        try {
            // Buscar projeto atual para manter imagens se não houver novas
            $projetoAtual = $this->projeto->buscarProjetoPorID($id);
            
            // Verifica se há novas imagens ou mantém as atuais
            $foto_antes_projeto = $projetoAtual['foto_antes_projeto'];
            $foto_depois_projeto = $projetoAtual['foto_depois_projeto'];
            
            if (!empty($_FILES['foto_antes_projeto']['name'])) {
                // Deletar imagem antiga
                if (!empty($projetoAtual['foto_antes_projeto'])) {
                    $this->gerenciarImagem->delete($projetoAtual['foto_antes_projeto']);
                }
                $foto_antes_projeto = $this->gerenciarImagem->salvarArquivo($_FILES['foto_antes_projeto'], 'projeto');
            }
            
            if (!empty($_FILES['foto_depois_projeto']['name'])) {
                // Deletar imagem antiga
                if (!empty($projetoAtual['foto_depois_projeto'])) {
                    $this->gerenciarImagem->delete($projetoAtual['foto_depois_projeto']);
                }
                $foto_depois_projeto = $this->gerenciarImagem->salvarArquivo($_FILES['foto_depois_projeto'], 'projeto');
            }

            $sucesso = $this->projeto->atualizarProjeto(
                $id,
                $foto_antes_projeto,
                $foto_depois_projeto,
                $_POST["descricao_projeto"]
            );

            if ($sucesso) {
                Redirect::redirecionarComMensagem("projeto/listar", "success", "Projeto atualizado com sucesso!");
            } else {
                Redirect::redirecionarComMensagem("projeto/editar/$id", "error", "Erro ao atualizar o projeto!");
            }
        } catch (\Exception $e) {
            Redirect::redirecionarComMensagem("projeto/editar/$id", "error", "Erro ao fazer upload: " . $e->getMessage());
        }
    }

    /**
     * Deletar projeto (soft delete)
     */
    public function deletarProjeto()
    {
        $id = $_POST['id_projeto'] ?? null;
        
        if (!$id) {
            Redirect::redirecionarComMensagem("projeto/listar", "error", "ID do projeto não fornecido!");
            return;
        }

        $sucesso = $this->projeto->excluirProjeto($id);

        if ($sucesso) {
            Redirect::redirecionarComMensagem("projeto/listar", "success", "Projeto excluído com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("projeto/listar", "error", "Erro ao excluir o projeto!");
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
            echo json_encode(['success' => false, 'message' => 'Nenhum projeto selecionado']);
            exit;
        }
        
        $sucesso = 0;
        foreach ($ids as $id) {
            if ($this->projeto->excluirProjeto($id)) {
                $sucesso++;
            }
        }
        
        if ($sucesso > 0) {
            echo json_encode([
                'success' => true,
                'message' => "$sucesso projeto(s) excluído(s) com sucesso!"
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Erro ao excluir projetos'
            ]);
        }
        exit;
    }
}