<?php
namespace App\Impermax\Controllers;

use App\Impermax\Controllers\Admin\AdminController;
use App\Impermax\Models\Projeto;
use App\Impermax\Database\Database;
use App\Impermax\Core\View;
use App\Impermax\Core\Redirect;
use App\Impermax\Validadores\ProjetoValidador;
use App\Impermax\Core\FileManager;

class ProjetoController
{
    private $projeto;
    private $db;
    private $gerenciarImagem;

    public function __construct()
    {
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
                $_POST["descricao_projeto"],
                'Inativo'

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

        // Buscar projeto atual
        $projetoAtual = $this->projeto->buscarProjetoPorID($id);
        
        if (!$projetoAtual) {
            Redirect::redirecionarComMensagem("projeto/listar", "error", "Projeto não encontrado!");
            return;
        }

        // Validar apenas descrição (imagens são opcionais na edição)
        $errosDescricao = [];
        
        if (empty($_POST['descricao_projeto'])) {
            $errosDescricao[] = "A descrição é obrigatória";
        } elseif (strlen($_POST['descricao_projeto']) < 10) {
            $errosDescricao[] = "A descrição deve ter no mínimo 10 caracteres";
        } elseif (strlen($_POST['descricao_projeto']) > 500) {
            $errosDescricao[] = "A descrição deve ter no máximo 500 caracteres";
        }
        
        if (!empty($errosDescricao)) {
            Redirect::redirecionarComMensagem("projeto/editar/$id", "error", implode("<br>", $errosDescricao));
            return;
        }

        try {
            // Manter imagens atuais por padrão
            $foto_antes_projeto = $projetoAtual['foto_antes_projeto'];
            $foto_depois_projeto = $projetoAtual['foto_depois_projeto'];
            
            // Verificar se há nova imagem ANTES
            if (isset($_FILES['foto_antes_projeto']) && $_FILES['foto_antes_projeto']['error'] === UPLOAD_ERR_OK) {
                // Deletar imagem antiga se existir
                if (!empty($projetoAtual['foto_antes_projeto'])) {
                    $caminhoAntigo = $_SERVER['DOCUMENT_ROOT'] . '/upload/' . $projetoAtual['foto_antes_projeto'];
                    if (file_exists($caminhoAntigo)) {
                        @unlink($caminhoAntigo);
                    }
                }
                // Upload nova imagem
                $foto_antes_projeto = $this->gerenciarImagem->salvarArquivo($_FILES['foto_antes_projeto'], 'projeto');
            }
            
            // Verificar se há nova imagem DEPOIS
            if (isset($_FILES['foto_depois_projeto']) && $_FILES['foto_depois_projeto']['error'] === UPLOAD_ERR_OK) {
                // Deletar imagem antiga se existir
                if (!empty($projetoAtual['foto_depois_projeto'])) {
                    $caminhoAntigo = $_SERVER['DOCUMENT_ROOT'] . '/upload/' . $projetoAtual['foto_depois_projeto'];
                    if (file_exists($caminhoAntigo)) {
                        @unlink($caminhoAntigo);
                    }
                }
                // Upload nova imagem
                $foto_depois_projeto = $this->gerenciarImagem->salvarArquivo($_FILES['foto_depois_projeto'], 'projeto');
            }

            // Atualizar no banco
            $sucesso = $this->projeto->atualizarProjeto(
                $id,
                $foto_antes_projeto,
                $foto_depois_projeto,
                $_POST["descricao_projeto"],
                $_POST['status_servico'] ?? 'Inativo'
            );

            if ($sucesso) {
                Redirect::redirecionarComMensagem("projeto/listar", "success", "Projeto atualizado com sucesso!");
            } else {
                Redirect::redirecionarComMensagem("projeto/editar/$id", "error", "Erro ao atualizar o projeto no banco!");
            }
        } catch (\Exception $e) {
            error_log("Erro ao atualizar projeto: " . $e->getMessage());
            Redirect::redirecionarComMensagem("projeto/editar/$id", "error", "Erro ao atualizar: " . $e->getMessage());
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


    /**
     * Ativar projeto
     */
    public function ativarProjeto($id)
    {
        if (!$id) {
            Redirect::redirecionarComMensagem("projeto/listar", "error", "ID não informado!");
            return;
        }

        if ($this->projeto->ativarProjeto($id)) {
            Redirect::redirecionarComMensagem("projeto/listar", "success", "Projeto ativado com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("projeto/listar", "error", "Erro ao ativar projeto!");
        }
    }

    /**
     * Desativar projeto
     */
    public function desativarProjeto($id)
    {
        if (!$id) {
            Redirect::redirecionarComMensagem("projeto/listar", "error", "ID não informado!");
            return;
        }

        if ($this->projeto->desativarProjeto($id)) {
            Redirect::redirecionarComMensagem("projeto/listar", "success", "Projeto desativado com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("projeto/listar", "error", "Erro ao desativar projeto!");
        }
    }
}